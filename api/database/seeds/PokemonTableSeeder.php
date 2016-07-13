<?php

use App\Models\Pokemon;
use Illuminate\Database\Seeder;

class PokemonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pokemon::create([
            'name' => 'Bulbasaur',
            'rarity' => 'common',
            'number' => 1,
        ]);

        Pokemon::create([
                'name' => 'Ivysaur',
                'rarity' => 'common',
                'number' => 2
        ]);

        Pokemon::create([
            'name' => 'Venusaur',
            'rarity' => 'common',
            'number' => 3
        ]);

        Pokemon::create([
            'name' => 'Charmander',
            'rarity' => 'common',
            'number' => 4
        ]);

        Pokemon::create([
            'name' => 'Mew',
            'rarity' => 'rare',
            'number' => 151,
        ]);
    }
}