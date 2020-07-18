<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert([
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'Seller',
            ],
            [
                'name' => 'Client',
            ]            
        ]);
    }
}
