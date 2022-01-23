<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DataTypesTableSeeder::class);
        $this->call(DataRowsTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(MembersTableSeeder::class);
        $this->call(SprintsTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
    }
}
