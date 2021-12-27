<?php

namespace NovaAdDirector\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NovaAdDirector\Factories\AdConfigurationFactory;
use Whitecube\NovaFlexibleContent\Concerns\HasFlexible;

class AdConfiguration extends Model
{
    use HasFactory, HasFlexible;

    protected $guarded = [];

    public function getTable()
    {
        return config('nova-ad-director.tables.ad_configurations');
    }

    protected static function newFactory()
    {
        return new AdConfigurationFactory();
    }

    public function getNameAttribute()
    {
        return "{$this->key} ({$this->location})";
    }

    public function getConfigurationAttribute()
    {
        return $this->flexible('configuration', collect(config('nova-ad-director.flexible.configuration.layouts'))->mapWithKeys(fn ($i) => [(new $i)->name() => $i])->toArray());
    }

    public function active(): bool
    {
        return $this->status === 'active';
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 'active');
    }

    public function disabled(): bool
    {
        return $this->status === 'disabled';
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', '=', 'disabled');
    }

    public function scopeLocatedKey($query, string $location, string $key)
    {
        return $query->where('key', '=', $key)
                     ->where('location', '=', $location);
    }

    public function scopeLocatedPossibleKeys($query, string $location, array $keys)
    {
        return $query->where('location', '=', $location)
                     ->whereIn('key', $keys)
                     ->orderByRaw("FIELD(`key`, '".implode(',', $keys)."')");
    }
}
