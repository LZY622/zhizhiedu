<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class StusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phone_arr = [];
        for ($i=0; $i < 50; $i++) { 
        	do{
        		$phone = rand(15100000000,18999999999);
        	}while (in_array($phone, $phone_arr));

        	$id = DB::table('stu_users')->insertGetId([
	            'phone' => $phone,
	            'password' => Hash::make('123456'),
	            'addtime' => time()
	        ]);
	        DB::table('users_message')->insert([
	        	'uid' => $id,
	        	'qq'=>rand(11234567, 2252940632)
	        ]);
	        DB::table('class_num')->insert([
	        	'uid' => $id
	        ]);												

        	$phone_arr[] = $phone;
        }
    }
}
