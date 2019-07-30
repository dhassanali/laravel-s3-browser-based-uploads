<?php

namespace Hassan\S3BrowserBasedUploads;

use Aws\S3\PostObjectV4;
use Aws\S3\S3ClientInterface;
use Illuminate\Support\Facades\Route;

class S3BrowserBasedUploads extends PostObjectV4
{
    public function __construct(
        S3ClientInterface $client,
        $bucket,
        array $formInputs,
        array $options = [],
        $expiration = '+1 hours'
    ) {
        $options[] = ['bucket' => $bucket];

        parent::__construct($client, $bucket, $formInputs, $options, $expiration);
    }

    /**
     * get the endpoint url.
     *
     * @return string
     */
    public function getEndpointUrl() : string
    {
        return $this->getFormAttributes()['action'];
    }

    /**
     * get the fields.
     *
     * @return array
     */
    public function getFields() : array
    {
        return $this->getFormInputs();
    }

    /**
     * Bind the credentials route.
     *
     * @param array $options
     *
     * @return void
     */
    public static function routes(array $options = [])
    {
        $options = array_merge([
            'as'        => 's3_browser_based_uploads.',
            'prefix'    => 's3_browser_based_uploads',
            'namespace' => '\Hassan\S3BrowserBasedUploads\Http\Controllers',
        ], $options);

        Route::group($options, static function ($router) {
            $router->get('/credentials', 'CredentialsController')->name('credentials');
        });
    }
}
