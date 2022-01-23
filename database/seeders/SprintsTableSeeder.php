<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SprintsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sprints')->delete();
        
        \DB::table('sprints')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'MEM1',
                'started' => '2022-01-23',
                'duration' => 2,
                'status' => 'done',
                'created_at' => '2022-01-23 11:06:21',
                'updated_at' => '2022-01-23 11:06:21',
            ),
        ));
        
        
    }
}