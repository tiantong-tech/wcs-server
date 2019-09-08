<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SaleProjectSeeder extends Seeder
{
  public function run()
  {
    $data = [];
    $now = Carbon::now();
    for ($i = 0; $i < 1000; $i++) {
      $data[] = [
        'name' => "测试项目 " . ($i + 1),
        'company' => "公司 " . random_int(1, 10),
        'member_ids' => "{1000}",
        'created_at' => $now
      ];
    }

    DB::table('projects')->insert($data);
  }
}
