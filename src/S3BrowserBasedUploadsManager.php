<?php

namespace Hassan\S3BrowserBasedUploads;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class S3BrowserBasedUploadsManager extends AbstractManager
{
    /**
     * @var S3BrowserBasedUploadsFactory
     */
    protected $factory;

    /**
     * Create a new manager instance.
     *
     * @param Repository $config
     * @param S3BrowserBasedUploadsFactory $factory
     *
     * @return void
     */
    public function __construct(Repository $config, S3BrowserBasedUploadsFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param  array  $config
     *
     * @return S3BrowserBasedUploads
     */
    protected function createConnection(array $config) : S3BrowserBasedUploads
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName() : string
    {
        return 's3-browser-based-uploads';
    }
}
