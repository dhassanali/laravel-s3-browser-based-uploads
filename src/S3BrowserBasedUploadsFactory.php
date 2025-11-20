<?php

namespace Hassan\S3BrowserBasedUploads;

use Aws\S3\S3Client;
use Illuminate\Support\Arr;

class S3BrowserBasedUploadsFactory
{
    /**
     * Create a new S3BrowserBasedUploads instance.
     *
     * @param array $config
     *
     * @return S3BrowserBasedUploads
     */
    public function make(array $config): S3BrowserBasedUploads
    {
        $diskConfig = $this->getDiskConfig($config);

        return new S3BrowserBasedUploads(
            $this->createS3Client($diskConfig),
            $this->getBucket($diskConfig),
            $this->getInputs($config),
            $this->getConditions($config),
            $this->getExpirationTime($config)
        );
    }

    /**
     * Get the filesystem disk configuration.
     *
     * @param array $config
     *
     * @return array
     */
    protected function getDiskConfig(array $config): array
    {
        $diskName = Arr::get($config, 'disk', 's3');

        return config("filesystems.disks.{$diskName}");
    }

    /**
     * Create an S3 client from disk configuration.
     *
     * @param array $diskConfig
     *
     * @return S3Client
     */
    protected function createS3Client(array $diskConfig): S3Client
    {
        $clientConfig = [
            'version' => 'latest',
            'region' => $diskConfig['region'],
            'credentials' => [
                'key' => $diskConfig['key'],
                'secret' => $diskConfig['secret'],
            ],
        ];

        if (isset($diskConfig['endpoint'])) {
            $clientConfig['endpoint'] = $diskConfig['endpoint'];
        }

        if (isset($diskConfig['use_path_style_endpoint'])) {
            $clientConfig['use_path_style_endpoint'] = $diskConfig['use_path_style_endpoint'];
        }

        return new S3Client($clientConfig);
    }

    /**
     * Get the bucket name from disk configuration.
     *
     * @param array $diskConfig
     *
     * @return string
     */
    protected function getBucket(array $diskConfig): string
    {
        return $diskConfig['bucket'];
    }

    /**
     * get the inputs.
     *
     * @param  array  $config
     *
     * @return array
     */
    protected function getInputs(array $config): array
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
    protected function getConditions(array $config): array
    {
        return Arr::get($config, 'conditions', []);
    }

    /**
     * get the expiration time.
     *
     * @param  array  $config
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function getExpirationTime(array $config): string
    {
        $expiration = Arr::get($config, 'expiration_time', '+5 minutes');

        // Validate expiration time for security (AWS recommends short-lived URLs)
        $expirationTimestamp = strtotime($expiration);
        $maxExpiration = strtotime('+12 hours');

        if ($expirationTimestamp === false) {
            throw new \InvalidArgumentException("Invalid expiration time format: {$expiration}");
        }

        if ($expirationTimestamp > $maxExpiration) {
            throw new \InvalidArgumentException('Expiration time exceeds 12 hours. For security, use shorter expiration times.');
        }

        return $expiration;
    }
}
