<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('reports')->delete();
        
        \DB::table('reports')->insert(array (
            0 => 
            array (
                'id' => 1,
                'sprint_id' => 1,
                'member_id' => 1,
                'previous' => 'asas',
                'next' => 'asasasasa',
                'blocking' => 'asasasas',
                'datetime' => '2022-01-23 00:00:00',
                'created_at' => '2022-01-23 11:11:34',
                'updated_at' => '2022-01-23 11:11:34',
            ),
            1 => 
            array (
                'id' => 2,
                'sprint_id' => 1,
                'member_id' => 1,
                'previous' => 'asas',
                'next' => 'asasasasa',
                'blocking' => 'asasasas',
                'datetime' => '2022-01-23 00:00:00',
                'created_at' => '2022-01-23 11:11:34',
                'updated_at' => '2022-01-23 11:11:34',
            ),
            2 => 
            array (
                'id' => 3,
                'sprint_id' => 1,
                'member_id' => 1,
                'previous' => 'efgsdret',
                'next' => 'gwtert',
                'blocking' => 'etrter',
                'datetime' => '2022-01-23 00:00:00',
                'created_at' => '2022-01-23 11:11:53',
                'updated_at' => '2022-01-23 11:11:53',
            ),
        ));
        
        
    }
}