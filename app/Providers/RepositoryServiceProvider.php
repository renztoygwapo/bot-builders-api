<?php

namespace App\Providers;

use App\Models\Area;
use App\Models\Draw;
use App\Models\Game;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Winner;
use App\Models\Cluster;
use App\Repositories\Repository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('User', function () {
            return new Repository(new User);
        });

        $this->app->singleton('Game', function () {
            return new Repository(new Game);
        });

        $this->app->singleton('Draw', function () {
            return new Repository(new Draw);
        });

        $this->app->singleton('Ticket', function () {
            return new Repository(new Ticket);
        });

        $this->app->singleton('Winner', function () {
            return new Repository(new Winner);
        });

        $this->app->singleton('Cluster', function () {
            return new Repository(new Cluster);
        });

        $this->app->singleton('Area', function () {
            return new Repository(new Area);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
