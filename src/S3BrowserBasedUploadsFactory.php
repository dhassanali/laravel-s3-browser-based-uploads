<?php

namespace Hassan\S3BrowserBasedUploads;

use Illuminate\Support\Arr;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

class S3BrowserBasedUploadsFactory
{
    /**
     * Create a new S3BrowserBasedUploads instance.
     *
     * @param array $config
     *
     * @return S3BrowserBasedUploads
     */
    public function make(array $config) : S3BrowserBasedUploads
    {
        $adapter = $this->getS3Adapter($config);

        return new S3BrowserBasedUploads(
            $adapter->getClient(),
            $adapter->getBucket(),
            $this->getInputs($config),
            $this->getConditions($config),
            $this->getExpirationTime($config)
        );
    }

    /**
     * get the s3 adapter.
     *
     * @param array $config
     *
     * @return AwsS3Adapter
     */
    protected function getS3Adapter(array $config) : AwsS3Adapter
    {
        return app('filesystem')->disk(Arr::get($config, 'disk', 's3'))->getAdapter();
    }

    /**
     * get the inputs.
     *
     * @param  array  $config
     *
     * @return array
     */
    protected function getInputs(array $config) : array
    {
        return Arr::get($config, 'inputs', []);
    }

    /**
     * get the conditions.
     *
     * @param  array  $config
     *
     * @return array
     */
    protected function getConditions(array $config) : array
    {
        return Arr::get($config, 'conditions', []);
    }

    /**
     * get the expiration time.
     *
     * @param  array  $config
     *
     * @return string
     */
    protected function getExpirationTime(array $config) : string
    {
        return Arr::get($config, 'expiration_time', '+5 minutes');
    }
}
