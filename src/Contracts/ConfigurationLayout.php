<?php

namespace NovaAdDirector\Contracts;

interface ConfigurationLayout
{
    public function applyConfiguration(string $locationName): static;
}
