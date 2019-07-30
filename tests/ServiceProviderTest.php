<?php

namespace Hassan\S3BrowserBasedUploads\Tests;

use GrahamCampbell\TestBenchCore\ServiceProviderTrait;
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploadsFactory;
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploadsManager;

class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTrait;

    public function test_is_injectable()
    {
        $this->assertIsInjectable(S3BrowserBasedUploadsFactory::class);
        $this->assertIsInjectable(S3BrowserBasedUploadsManager::class);
    }

}