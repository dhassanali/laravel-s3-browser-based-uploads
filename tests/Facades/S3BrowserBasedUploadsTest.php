<?php

namespace Hassan\S3BrowserBasedUploads\Tests\Facades;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use Hassan\S3BrowserBasedUploads\Facades\S3BrowserBasedUploads;
use Hassan\S3BrowserBasedUploads\S3BrowserBasedUploadsManager;
use Hassan\S3BrowserBasedUploads\Tests\AbstractTestCase;

class S3BrowserBasedUploadsTest extends AbstractTestCase
{
    use FacadeTrait;

    protected function getFacadeAccessor()
    {
        return 's3-browser-based-uploads';
    }

    protected function getFacadeClass()
    {
        return S3BrowserBasedUploads::class;
    }

    protected function getFacadeRoot()
    {
        return S3BrowserBasedUploadsManager::class;
    }
}