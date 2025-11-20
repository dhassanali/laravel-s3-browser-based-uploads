<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection
    |--------------------------------------------------------------------------
    |
    | The default connection to use for S3 browser-based uploads.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Upload Connections
    |--------------------------------------------------------------------------
    |
    | Configure multiple S3 upload connections with different security policies.
    | Each connection can target different buckets, paths, and restrictions.
    |
    */

    'connections' => [

        'main' => [
            // Laravel filesystem disk name (must be an S3 disk)
            'disk' => 's3',

            // Expiration time for presigned URL (AWS recommends short durations for security)
            // Maximum: 12 hours. Recommended: 5-15 minutes
            'expiration_time' => '+5 minutes',

            // Form input fields for the POST request
            'inputs' => [
                // SECURITY WARNING: Using ${filename} can expose you to path traversal attacks
                // Consider using UUIDs or sanitized names: 'key' => 'tmp/images/' . Str::uuid()
                'key' => 'tmp/images/${filename}',
                'acl' => 'bucket-owner-read',
                'success_action_status' => '201',
            ],

            // S3 POST policy conditions (enforced by AWS)
            'conditions' => [
                // Restrict upload path
                ['starts-with', '$key', 'tmp/images/'],

                // ACL must match
                ['acl' => 'bucket-owner-read'],

                // HTTP status code to return on success
                ['success_action_status' => '201'],

                // Content-Type restriction (images only)
                ['starts-with', '$Content-Type', 'image/'],

                // File size limit: 0 bytes to 1MB (1,000,000 bytes)
                // Adjust based on your needs. Example: 10MB = 10485760
                ['content-length-range', 0, 1000000],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Secure Image Upload Example
        |--------------------------------------------------------------------------
        |
        | This example shows stricter security settings:
        | - Shorter expiration (1 minute)
        | - Larger file size limit (10MB)
        | - Strict content-type validation
        |
        */

        'secure_images' => [
            'disk' => 's3',
            'expiration_time' => '+1 minute',
            'inputs' => [
                'key' => 'uploads/${filename}',
                'acl' => 'private',
                'success_action_status' => '201',
            ],
            'conditions' => [
                ['starts-with', '$key', 'uploads/'],
                ['acl' => 'private'],
                ['success_action_status' => '201'],
                ['starts-with', '$Content-Type', 'image/'],
                ['content-length-range', 1, 10485760], // 1 byte to 10MB
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | Document Upload Example
        |--------------------------------------------------------------------------
        |
        | Example configuration for PDF document uploads
        |
        */

        'documents' => [
            'disk' => 's3',
            'expiration_time' => '+10 minutes',
            'inputs' => [
                'key' => 'documents/${filename}',
                'acl' => 'private',
                'success_action_status' => '201',
            ],
            'conditions' => [
                ['starts-with', '$key', 'documents/'],
                ['acl' => 'private'],
                ['success_action_status' => '201'],
                ['eq', '$Content-Type', 'application/pdf'],
                ['content-length-range', 1, 20971520], // 1 byte to 20MB
            ],
        ],

    ],
];
