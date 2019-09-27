<?php

namespace App\Http\Controllers;

use Transaction;
use App\Models\Hoister;
use App\Models\HoisterFloor;

class HoisterController extends _Controller
{
  public function list()
  {
    return Hoister::select('id', 'name')->orderBy('id')->get();
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
    $hoister = null;

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
      $hoister = $this->getHoister($data['id']);
      $hoister->fill($data['data']);
    }

    if ($floors && $hoister) {
      Transaction::begin();
      $hoister->save();
      foreach ($floors as $floor) $floor->save();
      Transaction::commit();
    } else {
      if ($floors) {
        foreach ($floors as $floor) $floor->save();
      }
      if ($hoister) {
        $hoister->save();
      }
    }

    return $this->success('success to update hoister');
  }

  public function getDetail()
  {
    return $this->getHoisterWithFloors();
  }

  public function createFloor()
  {
    $hoister = $this->getHoister();
    $data = $this->get('data', 'array', []);

    $floor = new HoisterFloor;
    $floor->fill($data);
    $floor->hoister_id = $hoister->id;
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

  protected function getHoisterWithFloors($id = 0): Hoister
  {
    if (!$id) {
      $id = $this->get('hoister_id');
    }

    $hst = Hoister::with(['floors' => function ($query) {
      $query->orderBy('id', 'asc');
    }])->find($id);
    if (!$hst) {
      $this->failure('fail to find hoister by id', 404);
    }

    return $hst;
  }
}
