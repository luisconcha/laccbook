<?php

namespace LaccBook\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \LaccBook\Repositories\CategoryRepository::class,
            \LaccBook\Repositories\CategoryRepositoryEloquent::class
        );
        $this->app->bind(
            \LaccBook\Repositories\BookRepository::class,
            \LaccBook\Repositories\BookRepositoryEloquent::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
