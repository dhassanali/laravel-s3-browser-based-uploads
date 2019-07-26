<?php

namespace Hassan\S3BrowserBasedUploads;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('s3-browser-based-uploads.php'),
            ], 'config');
        }
    }

    protected function getS3Adapter() : AwsS3Adapter
    {
        return $this->app['filesystem']->disk($this->getConfig('disk'))->getAdapter();
    }

    protected function getInputs() : array
    {
        return $this->getConfig('inputs', []);
    }

    protected function getConditions() : array
    {
        return $this->getConfig('conditions', []);
    }

    protected function getExpirationTime() : string
    {
        return $this->getConfig('expiration_time', '+5 minutes');
    }

    public function getConfig(string $key, $default = null)
    {
        return config('s3-browser-based-uploads.providers.default.' . $key, $default);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 's3-browser-based-uploads');

        $this->app->bind(S3BrowserBasedUploadsManager::class, function () {
            $adapter = $this->getS3Adapter();

            return new S3BrowserBasedUploadsManager(
                $adapter->getClient(),
                $adapter->getBucket(),
                $this->getInputs(),
                $this->getConditions(),
                $this->getExpirationTime()
            );
        });

        $this->app->alias(S3BrowserBasedUploadsManager::class, 's3-browser-based-uploads');
    }
}
