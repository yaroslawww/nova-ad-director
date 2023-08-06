<?php

namespace NovaAdDirector\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use NovaAdDirector\Models\AdConfiguration;

/**
 * @extends Factory<AdConfiguration>
 */
class AdConfigurationFactory extends Factory
{
    protected $model = AdConfiguration::class;

    public function definition()
    {
        return [
            'key'           => $this->faker->unique()->word(),
            'location'      => $this->faker->unique()->word(),
            'status'        => 'active',
            'configuration' => null,
        ];
    }
}
