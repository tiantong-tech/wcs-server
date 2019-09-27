<?php

namespace App\Http\Controllers;

use App\Plc\PlcClient as Plc;

class PlcController extends _Controller
{
  public function test()
  {
    $host = $this->get('host', 'required');
    $taskPort = $this->get('task_port', 'required');
    $commandPort = $this->get('command_port', 'required');

    $result = [];
    $plc = new Plc($host, $taskPort);
    try {
      $plc->connect();
      $plc->test();
      $result[0] = true;
    } catch (\Exception $e) {
      $result[0] = false;
    }
    try {
      $plc->connect($host, $commandPort);
      $plc->test();
      $result[1] = true;
    } catch (\Exception $e) {
      $result[1] = false;
    }

    return $result;
  }

  public function getState ()
  {
    $host = $this->get('host', 'required');
    $port = $this->get('port', 'required');
    $plc = new Plc($host, $port);
    $plc->connect();

    return [
      'result' => $plc->read('002000')
    ];
  }

  public function testDispatch()
  {
    $host = $this->get('host', 'required');
    $port = $this->get('port', 'required');
    $address = $this->get('address', 'required');
    $value = $this->get('value', 'required');

    try {
      $plc = new Plc($host, $port);
      $plc->connect();

      if ($plc->read('002000') !== '0001') {
        throw new \Exception();
      }

      $plc->write($address, $value);

      if ($plc->read('002000') !== '0000') {
        throw new \Exception();
      }

      return $this->success([
        'msg' => 'success to dispatch task',
        'result' => true
      ]);
    } catch (\Exception $e) {
      return $this->success([
        'msg' => 'fail to dispatch task',
        'result' => false
      ]);
    }
  }

  public function read()
  {
    $host = $this->get('host', 'required');
    $port = $this->get('port', 'required');
    $address = $this->get('address', 'required');
    $length = $this->get('length', 'required');
    $plc = new Plc($host, $port);
    $plc->connect();
  }

  public function write()
  {
    $host = $this->get('host', 'required');
    $port = $this->get('port', 'required');
    $address = $this->get('address', 'required');
    $data = $this->get('data', 'required');
    $length = $this->get('length', 'nullable', 1);
    try {
      $plc = new Plc($host, $port);
      $plc->connect();
      $plc->test();
      $plc->write($address, $data, $length);
      return $this->success('success to write data');
    } catch (\Exception $e) {
      return $this->failure('fail to write plc data');
    }
  }
}
