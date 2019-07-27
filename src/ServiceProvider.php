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


    /**
     * @return AwsS3Adapter
     */
    protected function getS3Adapter() : AwsS3Adapter
    {
        return $this->app['filesystem']->disk($this->getConfig('disk'))->getAdapter();
    }

    /**
     *  returns inputs from config file
     */
    protected function getInputs() : array
    {
        return $this->getConfig('inputs', []);
    }

    /**
     *  returns conditions from config file
     */
    protected function getConditions() : array
    {
        return $this->getConfig('conditions', []);
    }

    /**
     *  returns expiration time from config file
     */
    protected function getExpirationTime() : string
    {
        return $this->getConfig('expiration_time', '+5 minutes');
    }

    /**
     * @param  string  $key
     * @param  null  $default
     * @return mixed
     */
    protected function getConfig(string $key, $default = null)
    {
        return config('s3-browser-based-uploads.providers.default.' . $key, $default);
    }
}
