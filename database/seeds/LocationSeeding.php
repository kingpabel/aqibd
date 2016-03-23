<?php

use Illuminate\Database\Seeder;

class LocationSeeding extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Location::insert(
            [
                [
                    'name' => 'Mohammadpur, Dhaka',
                    'lat' => '23.765953',
                    'lng' => '90.357581'
                ],
                [
                    'name' => 'Farmgate, Dhaka, Dhaka Division',
                    'lat' => '23.756914',
                    'lng' => '90.387295'
                ],
                [
                    'name' => 'Mohakhali, Dhaka, Dhaka Division',
                    'lat' => '23.777567',
                    'lng' => '90.405132'
                ],
                [
                    'name' => 'Tejgaon, Dhaka Division',
                    'lat' => '23.761396',
                    'lng' => '90.390779'
                ],
            ]);
    }
}
