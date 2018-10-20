<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class TeaClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$tea = DB::table('tea_users')->get();
    	foreach ($tea as $key => $value) {
    		if ($value->cate == 2) {
    			for ($i=0; $i < 30; $i++) { 
    				$time = -3600+rand(0,32)*1800;
    				$date = strtotime(date('Y-m-d',time()))+(rand(0,6)*24*3600);
    				DB::table('tea_sclass')->where('tid',$value->id)->where('classdate',$date)->where('classtime',$time)->delete();
    				DB::table('tea_sclass')->insert([
    					'tid'=>$value->id,
    					'classdate'=>$date,
    					'classtime'=>$time
    				]);

    			}
    		}else{ 
				$date = rand(4,7);
				for ($i=0; $i < $date; $i++) { 
					$num = rand(6,15);
					DB::table('tea_wcorrect')->insert([
						'tid'=>$value->id,
						'classtime'=>strtotime(date('Y-m-d',time()))+($i*24*3600),
						'total_num'=>$num,
						'num'=>$num,
					]);
				}
				
    		}
    	}

    }
}
