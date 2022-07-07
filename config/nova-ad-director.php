<?php

return [
    'tables' => [
        'ad_configurations' => 'ad_configurations',
    ],

    'creatable'  => true,
    'replicable' => false,

    'statuses' => [
        'active',
        'disabled',
    ],

    'flexible' => [
        'configuration' => [
            'layouts' => [
                \NovaAdDirector\Nova\Flexible\Layouts\GPTConfigurationLayout::class,
            ],
        ],
    ],
];
