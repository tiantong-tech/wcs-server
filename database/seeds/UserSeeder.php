<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
	public function run()
	{
		// $this->createRoot();
		// if (env('APP_ENV') === 'local') {
		// 	$this->createTestAdmin();
		// }
	}

	public function createRoot()
	{
		// $username = env('ROOT_USERNAME');
		// $password = env('ROOT_PASSWORD');

		// $user = new User;
		// $user->type = 'root';
		// $user->name = 'root';
		// $user->username = $username;
		// $user->password = $password;
		// $user->email = 'root@tiantong.com';
		// $user->save();
	}

	public function createTestAdmin()
	{
    // $data = [];
		// for ($i = 1; $i <= 100; $i++) {
    //   $data[] = [
    //     'id' => 1000000 + $i,
    //     'groups' => "[\"admin\"]",
    //     'name' => "测试用户 $i",
    //     'username' => "testa_admin_$i",
    //     'password' => '123456',
    //     'email' => "test_admin_$i@tiantong.com"
    //   ];
    // }

    // DB::table('users')->insert($data);
	}
}
