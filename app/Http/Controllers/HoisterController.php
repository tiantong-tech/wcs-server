<?php

namespace App\Http\Controllers;

use Transaction;
use IRedis as Redis;
use App\Models\Hoister;
use App\Models\HoisterFloor;

class HoisterController extends _Controller
{
  public function list()
  {
    return Hoister::select('id', 'name', 'is_running')->orderBy('id')->get();
  }

  public function listAll()
  {
    return Hoister::with(['floors' => function ($query) {
      $query->orderBy('key');
    }])->orderBy('id')->get();
  }

  public function deleteHoister()
  {
    $hst = $this->getHoister();

    Redis::publish('system.hoister.accessor', "remove.$hst->id");
    Transaction::begin();
    $hst->delete();
    HoisterFloor::where('hoister_id', $hst->id)->delete();
    Transaction::commit();

    return $this->success('success to delete hoister');
  }

  public function createHoister()
  {
    $name = $this->get('name', 'string');
    $hst = new Hoister;
    $hst->name = $name;
    $hst->save();

    return $this->success('success to create hoister');
  }

  public function updateHoister()
  {
    $floors = [];
    $hst = null;

    $data = $this->get('floors', 'array|nullable');
    if ($data) {
      foreach ($data as $id => $data) {
        $floor = $this->getHoisterFloor($id);
        $floor->fill($data);
        $floors[] = $floor;
      }
    }
    $data = $this->get('hoister', 'array|nullable');
    if ($data) {
      $hst = $this->getHoister($data['id']);
      $hst->fill($data['data']);
    }

    if ($floors && $hst) {
      Transaction::begin();
      $hst->save();
      foreach ($floors as $floor) $floor->save();
      Transaction::commit();
    } else {
      if ($floors) {
        foreach ($floors as $floor) $floor->save();
      }
      if ($hst) {
        $hst->save();
      }
    }

    return $this->success('success to update hoister');
  }

  public function getDetail()
  {
    return $this->getHoisterDetail();
  }

  public function createFloor()
  {
    $hst = $this->getHoister();
    $data = $this->get('data', 'array', []);

    $floor = new HoisterFloor;
    $floor->fill($data);
    $floor->hoister_id = $hst->id;
    $floor->save();
    $floor = HoisterFloor::find($floor->id);

    return $this->success([
      'message' => 'success to create hoister floor',
      'data' => $floor
    ], 201);
  }

  public function deleteFloor()
  {
    $floor = $this->getHoisterFloor();
    $floor->delete();

    return $this->success('success to delete hoister floor');
  }

  public function run()
  {
    $hst = $this->getHoister();
    if ($hst->is_running) {
      return $this->success('hoister system is already running', 200);
    }

    Redis::publish("system.hoister.accessor","run.$hst->id");

    return $this->success('success to run hoister system');
  }

  public function stop()
  {
    $hst = $this->getHoister();
    if (!$hst->is_running) {
      return $this->success('hoister system is not running yet');
    }

    Redis::publish("system.hoister.accessor", "stop.$hst->id");

    return $this->success('success to stop hoister system');
  }

  public function isRunning()
  {
    $hst = $this->getHoister();

    return $this->success([
      'is_running' => $hst->is_running
    ]);
  }

  protected function getHoister($id = 0): Hoister
  {
    if (!$id) {
      $id = $this->get('hoister_id');
    }

    $hst = Hoister::find($id);
    if (!$hst) {
      $this->failure('fail to find hoister by id', 404);
    }

    return $hst;
  }

  protected function getHoisterFloor($id = 0): HoisterFloor
  {
    if (!$id) {
      $id = $this->get('floor_id');
    }

    $floor = HoisterFloor::find($id);
    if (!$floor) {
      $this->failure('fail to find hoister floor by id', 404);
    }

    return $floor;
  }

  protected function getHoisterDetail($id = 0): Hoister
  {
    if (!$id) {
      $id = $this->get('hoister_id');
    }

    $hst = Hoister::with(['floors', 'scanners'])->find($id);
    if (!$hst) {
      $this->failure('fail to find hoister by id', 404);
    }

    return $hst;
  }
}
