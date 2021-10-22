<?php

return [
    'password-default' => 123456,
    'admin' => 1,
    'user' => 2,
    'active' => 1,
    'inactive' => 1,
    'order' => [
        'state' => [
            'created' => 1, // create payment
            'approved' => 2, // execute payment
            'completed' => 3, // webhook complete payment
            'cancel' => 4
        ],
        'status' => [
            'created' => 1,
            'verified' => 2,  // execute payment
            'webhook' => 3,
            'cancel' => 4
        ]
    ],
    'ipn' => [
        'status' => [
            'completed' => 2
        ]
    ],
    'txn' => [
        'type' => [
            'manually' => 1,
            'webhook' => 2,
            'payment' => 3
        ]
    ]
];
