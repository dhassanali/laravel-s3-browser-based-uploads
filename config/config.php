<?php

return [

    'default' => 'main',

    'connections' => [


        'main' => [
            'disk' => 's3', // your S3 disk in your filesystem config
            'expiration_time' => '+5 minutes',
            'inputs' => [
                'key' => 'tmp/images/${filename}',
                'acl' => 'bucket-owner-read',
                'success_action_status' => '201',
            ],
            'conditions' => [
                ['starts-with', '$key', 'tmp/images/'],
                ['acl' => 'bucket-owner-read'],
                ['success_action_status' => '201'],
                ['starts-with', '$Content-Type',  'image/'],
                ['content-length-range', 0, 1000000],
            ],
        ],


        'another' => [
            'disk' => 's3',
            'expiration_time' => '+5 minutes',
            'inputs' => [],
            'conditions' => [
                ['starts-with', '$key', '/'],
                ['starts-with', '$Content-Type',  'image/'],
                ['content-length-range', 0, 1000000],
            ],
        ],

    ],
];