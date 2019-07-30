<?php

namespace Hassan\S3BrowserBasedUploads\Tests;

use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploads;
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploadsFactory;

class FactoryTest extends AbstractTestCase
{
    public function test_make()
    {
        $factory = new S3BrowserBasedUploadsFactory;

        $instance = $factory->make($this->getConfig());

        $this->assertInstanceOf(S3BrowserBasedUploads::class, $instance);
    }
}