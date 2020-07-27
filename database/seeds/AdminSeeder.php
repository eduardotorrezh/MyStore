<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'last_name' => 'MyStore',
                'email' => 'w7mHLkHLn3GYydPIQHwH61aGJgqIuRkJ4mXGRnMH+rc=',
                'password' => 'SSLNKzoo6QJs6dzo8XrO3A==',
                'rol_id' => 1
            ]          
        ]);
    }
}
