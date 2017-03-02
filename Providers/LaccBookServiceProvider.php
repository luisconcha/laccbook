<?php
namespace LaccBook\Providers;

use Illuminate\Support\ServiceProvider;

class LaccBookServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->publishMigrationsAndSeeders();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register( RouteServiceProvider::class );
        $this->app->register( RepositoryServiceProvider::class );
        $this->app->register( AuthServiceProvider::class );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes( [
          __DIR__ . '/../Config/config.php' => config_path( 'laccbook.php' ),
        ], 'config' );
        $this->mergeConfigFrom(
          __DIR__ . '/../Config/config.php', 'laccbook'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = base_path( 'resources/views/modules/laccbook' );
        $sourcePath = __DIR__ . '/../resources/views';
        $this->publishes( [
          $sourcePath => $viewPath,
        ] );
        $this->loadViewsFrom( array_merge( array_map( function ( $path ) {
            return $path . '/modules/laccbook';
        }, \Config::get( 'view.paths' ) ), [ $sourcePath ] ), 'laccbook' );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = base_path( 'resources/lang/modules/laccbook' );
        if ( is_dir( $langPath ) ) {
            $this->loadTranslationsFrom( $langPath, 'laccbook' );
        } else {
            $this->loadTranslationsFrom( __DIR__ . '/../resources/lang', 'laccbook' );
        }
    }

    /**
     * Register migrations and seed
     */
    public function publishMigrationsAndSeeders()
    {
        $sourcePathMigrations = __DIR__ . '/../database/migrations';
        $sourcePathSeeders    = __DIR__ . '/../database/seeders';
        $this->publishes( [
          $sourcePathMigrations => database_path( 'migrations' ),
        ], 'migrations' );
        $this->publishes( [
          $sourcePathSeeders => database_path( 'seeds' ),
        ], 'seeders' );
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