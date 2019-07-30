<?php

namespace Hassan\S3BrowserBasedUploads\Http\Controllers;

use Hassan\S3BrowserBasedUploads\Facades\S3BrowserBasedUploads;

class CredentialsController
{
    public function __invoke()
    {
        return response([
            'url'    => S3BrowserBasedUploads::getEndpointUrl(),
            'fields' => S3BrowserBasedUploads::getFields(),
        ]);
    }
}
