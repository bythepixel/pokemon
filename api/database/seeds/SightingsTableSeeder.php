<?php

use Illuminate\Database\Seeder;

class SightingsTableSeeder extends Seeder
{
    public function run()
    {
        $sightings = [];

        for($counter = 1; $counter < 1000; $counter++) {

            $latitude = mt_rand(-105.09*1000000, -104.88*1000000) / 1000000;
            $longitude = mt_rand(39.69*1000000, 39.78*1000000) / 1000000;
            $pokemon = mt_rand(1,50) === 1 ? 5 : mt_rand(1,4);
            $createdAt = $this->randomDate('2016-07-07', date('Y-m-d H:i:s'));

            $sightings[] = "(1, $pokemon, '$createdAt', POINT($latitude, $longitude))";
        }

        DB::statement("INSERT INTO sightings (user_id, pokemon_id, created_at, location) VALUES " . implode(',', $sightings));
    }

    private function randomDate($startDate, $endDate)
    {
        $startTime = strtotime($startDate);
        $endTime = strtotime($endDate);

        $time = mt_rand($startTime, $endTime);

        return date('Y-m-d H:i:s', $time);
    }
}