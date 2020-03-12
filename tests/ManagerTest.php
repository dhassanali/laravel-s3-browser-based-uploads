<?php

namespace Hassan\S3BrowserBasedUploads\Tests;

use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploads;
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploadsFactory;
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploadsManager;
use Illuminate\Contracts\Config\Repository;
use Mockery;

class ManagerTest extends AbstractTestCase
{
    public function test_meke_connection()
    {
        $repository = Mockery::mock(Repository::class);
        $factory = new S3BrowserBasedUploadsFactory;

        $repository
            ->shouldReceive('get')
            ->once()
            ->with('s3-browser-based-uploads.connections')
            ->andReturn(['main' => $this->getConfig()]);

        $repository
            ->shouldReceive('get')
            ->once()
            ->with('s3-browser-based-uploads.default')
            ->andReturn('main');

        $manager = new S3BrowserBasedUploadsManager($repository, $factory);

        $this->assertInstanceOf(S3BrowserBasedUploads::class, $manager->connection());
    }
}
