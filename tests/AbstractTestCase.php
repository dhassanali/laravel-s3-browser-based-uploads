<?php

namespace Hassan\S3BrowserBasedUploads\Tests;

use GrahamCampbell\TestBench\AbstractPackageTestCase;
use Hassan\S3BrowserBasedUploads\ServiceProvider;

abstract class AbstractTestCase extends AbstractPackageTestCase
{
    protected function getServiceProviderClass(): string
    {
        return ServiceProvider::class;
    }

    protected function getEnvironmentSetUp($app): void
    {
        parent::getEnvironmentSetUp($app);

        $app->config->set('filesystems.disks.s3', [
            'driver' => 's3',
            'key'    => 'key',
            'secret' => 'AWS_SECRET_ACCESS_KEY',
            'region' => 'us-east-1',
            'bucket' => 'AWS_BUCKET',
        ]);
    }

    protected function getConfig(): array
    {
        return [
            'disk' => 's3',
            'expiration_time' => '+5 minutes',
            'inputs' => [],
            'conditions' => [],
        ];
    }
}
