<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(LocationSeeding::class);
         $this->call(AirTypeSeeding::class);
//         $this->call(UserSeeding::class);
    }
}
