<?php

namespace Programic\Repository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->commands([
            Commands\MakeRepositoryCommand::class,
        ]);
    }

    public function register(): void
    {
        $this->app->singleton(Repository::class, function ($app) {
            return new Repository($app);
        });

        $this->app->alias(Repository::class, 'repository');
    }
}
