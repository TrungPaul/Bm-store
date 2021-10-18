<?php

return [
    'status' => [
        1 => 'Active',
        2 => 'Inactive',
    ],
    'tab' => [
        1 => 'BM',
        2 => 'VIA',
        3 => 'CLONE'
    ],
    'order' => [
        'state' => [
            'created' => 1, // create payment
            'approved' => 2, // execute payment
            'completed' => 3, // webhook complete payment
            'cancel' => 4
        ],
        'status' => [
            1 => 'created',
            2 => 'verified',  // execute payment
            3 => 'success',
            4 => 'cancel'
        ]
    ],
];
