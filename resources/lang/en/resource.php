<?php

return [
    'label'  => 'Advertising',
    'fields' => [
        'key'      => 'Key',
        'location' => 'Location',
        'status'   => 'Status',
        'service'  => 'Service',
    ],
    'configuration' => [
        'gpt' => [
            'adUnitPath' => 'adUnitPath',
            'size'       => 'size',
            'help_size'  => 'Allowed sizes: :sizes',
            'divId'      => 'divId',
            'help_divId' => 'If empty, ID will be autogenerated',
        ],
        'gpt-target' => [
            'target_key'        => 'Target key',
            'help_target_key'   => '',
            'target_value'      => 'Target value',
            'help_target_value' => 'To specify multiple targets please use coma',
        ],
    ],
    'layouts' => [
        'gpt'        => 'Google Publisher Tag',
        'gpt-target' => 'Target',
    ],
    'statuses' => [
        'active'   => 'Active',
        'disabled' => 'Disabled',
    ],
];