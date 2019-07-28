<?php

namespace Hassan\S3BrowserBasedUploads;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot() : void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('s3-browser-based-uploads.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register() : void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 's3-browser-based-uploads');

        $this->registerFactory();

        $this->registerManager();
    }

    /**
     * Register the factory class.
     *
     * @return void
     */
    public function registerFactory() : void
    {
        $this->app->singleton('s3-browser-based-uploads.factory', static function () {
            return new S3BrowserBasedUploadsFactory;
        });

        $this->app->alias('s3-browser-based-uploads.factory', S3BrowserBasedUploadsFactory::class);
    }

    /**
     * Register the manager class.
     *
     * @return void
     */
    public function registerManager() : void
    {
        $this->app->singleton('s3-browser-based-uploads', static function (Container $app) {
            return new S3BrowserBasedUploadsManager($app['config'], $app['s3-browser-based-uploads.factory']);
        });

        $this->app->alias('s3-browser-based-uploads', S3BrowserBasedUploadsManager::class);
    }


    /**
     * Get the services.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['s3-browser-based-uploads', 's3-browser-based-uploads.factory'];
    }
}
