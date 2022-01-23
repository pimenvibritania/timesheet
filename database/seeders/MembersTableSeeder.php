<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('members')->delete();
        
        \DB::table('members')->insert(array (
            0 => 
            array (
                'id' => 1,
                'first_name' => 'pirman',
                'last_name' => 'abdurohman',
                'role' => 'backend',
                'email' => 'pimenvibritania@gmail.com',
                'created_at' => '2022-01-23 10:54:44',
                'updated_at' => '2022-01-23 10:54:44',
            ),
        ));
        
        
    }
}