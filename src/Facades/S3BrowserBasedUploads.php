<?php

namespace Hassan\S3BrowserBasedUploads\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string getEndpointUrl()
 * @method static array getFields()
 * @method static \Hassan\S3BrowserBasedUploads\S3BrowserBasedUploads connection(string|null $name = null)
 */
class S3BrowserBasedUploads extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 's3-browser-based-uploads';
    }
}
