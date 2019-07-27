<?php

namespace Hassan\S3BrowserBasedUploads;

use Aws\S3\PostObjectV4;
use Aws\S3\S3ClientInterface;

class S3BrowserBasedUploadsManager extends PostObjectV4
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
     * @return string
     */
    public function getEndpointUrl() : string
    {
        return $this->getFormAttributes()['action'];
    }

    /**
     * @return array
     */
    public function getFields() : array
    {
        return $this->getFormInputs();
    }
}
