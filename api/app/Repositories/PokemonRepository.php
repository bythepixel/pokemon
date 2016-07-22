<?php namespace App\Repositories;

use App\Models\Pokemon;

class PokemonRepository extends BaseRepository
{
    public function __construct()
    {
        $this->repository = new Pokemon();
    }
}