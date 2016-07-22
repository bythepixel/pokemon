<?php

namespace App\Providers;

use App\Repositories\PokemonRepository;
use App\Repositories\SightingsRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    /**
     * Registers repositories
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SightingsRepository::class, function () { return new SightingsRepository(); });
        $this->app->singleton(PokemonRepository::class, function () { return new PokemonRepository(); });
    }
}