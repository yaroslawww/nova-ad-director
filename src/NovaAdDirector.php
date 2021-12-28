<?php

namespace NovaAdDirector;

use Illuminate\Support\Str;
use NovaAdDirector\Contracts\ConfigurationLayout;
use NovaAdDirector\Models\AdConfiguration;

class NovaAdDirector
{
    public static string $fallbackKeyConnector = ':';

    public static function setFallbackKeyConnector(string $fallbackKeyConnector): void
    {
        self::$fallbackKeyConnector = $fallbackKeyConnector;
    }

    public function prepareAds(array $preparationMap): static
    {
        foreach ($preparationMap as $locationName => $keyName) {
            $this->prepareAd($locationName, $keyName);
        }

        return $this;
    }

    public function prepareAd(string $locationName, string $keyName): static
    {
        /** @var AdConfiguration $adConfiguration */
        $adConfiguration = AdConfiguration::query()
                                          ->active()
                                          ->locatedPossibleKeys(
                                              $locationName,
                                              $this->possibleKeys($keyName)
                                          )
                                          ->first();
        if ($adConfiguration
            && !$adConfiguration->flexibleConfiguration->isEmpty()) {
            $configuration = $adConfiguration->flexibleConfiguration->first();
            if ($configuration instanceof ConfigurationLayout) {
                $configuration->applyConfiguration($locationName);
            }
        }

        return $this;
    }

    public function fallbackKey(string|array ...$keys): string
    {
        $stack = [];
        foreach ($keys as $key) {
            if (is_string($key)) {
                $key = (array) $key;
            }
            $stack = array_merge($stack, $key);
        }

        return implode(static::$fallbackKeyConnector, $stack);
    }

    public function possibleKeys(string $key): array
    {
        $keys = [$key];
        while (str_contains($key, static::$fallbackKeyConnector)) {
            $key    = Str::beforeLast($key, static::$fallbackKeyConnector);
            $keys[] = $key;
        }

        return $keys;
    }
}
