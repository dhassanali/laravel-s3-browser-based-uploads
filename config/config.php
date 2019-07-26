<?php

return [
    'providers' => [


        'default' => [
            'disk' => 's3',
            'expiration_time' => '+5 minutes',
            'inputs' => [],
            'conditions' => [
                ['starts-with', '$key', ''],
                ['starts-with', '$Content-Type',  'image/'],
                ['content-length-range', 0, 1000000],
            ],
        ],


    ],
];