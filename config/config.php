<?php

return [

    'shipping' => [

        'methods' => [

            'self' => [
                'code' => 'self',
                'name' => 'Self',
            ],

            'novaposhta' => [
                'code' => 'novaposhta',
                'name' => 'Novaposhta',
            ],

            'ukrposhta' => [
                'code' => 'ukrposhta',
                'name' => 'Ukrposhta',
            ],

        ],

    ],

    'payment' => [

        'methods' => [

            'self' => [
                'code' => 'self',
                'name' => 'Self',
            ],

            'privatbank' => [
                'code' => 'privatbank',
                'name' => 'Privatbank',
            ]

        ],
    ],
];