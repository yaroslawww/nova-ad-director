<?php

namespace NovaAdDirector\Console\Commands;

use Illuminate\Console\Command;
use NovaAdDirector\Models\AdConfiguration;

class AdConfigurationCreate extends Command
{
    protected $signature = 'nova-ad-director:ad-config:create
        {key : Key name}
        {location : Location name}
        {--status=disabled : Status}
    ';

    protected $description = 'Create new ad configuration in database';

    public function handle()
    {
        AdConfiguration::create([
            'key'      => $this->argument('key'),
            'location' => $this->argument('location'),
            'status'   => $this->option('status'),
        ]);

        return 0;
    }
}
