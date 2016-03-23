<?php

use Illuminate\Database\Seeder;

class AirTypeSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\AirType::insert(
            [
                [
                    'name' => 'PM2.5',
                ],
                [
                    'name' => 'Temp'
                ],
                [
                    'name' => 'Noise'
                ],
                [
                    'name' => 'Humidity'
                ]
            ]
        );
    }
}
