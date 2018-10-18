<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TeasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$username_arr = [];
        for ($i=0; $i < 35; $i++) { 
        	do{
        		$username = '';
        		for ($j=0; $j < rand(4,9); $j++) { 
        			$username .= chr(rand(97,122));
        		}
        		$username = ucfirst($username);
        	}while (in_array($username, $username_arr));
        	$cate = [13,15];
	        $roles = [4=>2,5=>$cate[rand(0,1)],6=>2,7=>$cate[rand(0,1)]];
	        $r = rand(4,7);
	        DB::table('tea_users')->insert([
	        	'username'=>$username,
	        	'password'=>Hash::make('123456'),
	        	'qq'=>rand(11234567, 2252940632),
	        	'status'=>1,
	        	'roles'=>$r,
	        	'cate'=>$roles[$r],
	        	'addtime' => time()
	        ]);
	        $username_arr[] = $username;
	    }
    }
}
