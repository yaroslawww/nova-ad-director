<?php

namespace NovaAdDirector\Nova\Resources;

use Laravel\Nova\Resource;

/**
 * @extends Resource<\NovaAdDirector\Models\AdConfiguration>
 */
class AdConfiguration extends Resource
{
    use HasAdConfiguration;

    public static $model = \NovaAdDirector\Models\AdConfiguration::class;

    public static $title = 'name';

    public static $search = [
        'key',
        'location',
    ];
}
