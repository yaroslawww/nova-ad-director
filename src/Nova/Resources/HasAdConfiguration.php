<?php

namespace NovaAdDirector\Nova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use NovaAdDirector\NovaAdDirector;
use NovaFlexibleContent\Flexible;

trait HasAdConfiguration
{
    public static function label()
    {
        return trans('nova-ad-director::resource.label');
    }

    public function fields(Request $request)
    {
        return [
            $this->fieldID(),
            $this->fieldKey(),
            $this->fieldLocation(),
            $this->fieldStatus(),
            $this->fieldConfiguration(),
        ];
    }

    public function fieldID(): Field
    {
        return ID::make()->sortable();
    }

    public function fieldKey(): Field
    {
        return Text::make(trans('nova-ad-director::resource.fields.key'), 'key')
                   ->sortable()
                   ->placeholder(implode(NovaAdDirector::$fallbackKeyConnector, ['header', 'page', 'contact']))
                   ->rules('required', 'regex:/^[a-z0-9_\-'.NovaAdDirector::$fallbackKeyConnector.']+$/i', 'max:150')
                   ->readonly(!config('nova-ad-director.creatable'));
    }

    public function fieldLocation(): Field
    {
        return Text::make(trans('nova-ad-director::resource.fields.location'), 'location')
                   ->sortable()
                   ->rules('required', 'regex:/^[a-z0-9_-]+$/i', 'max:150')
                   ->readonly(!config('nova-ad-director.creatable'));
    }

    public function fieldStatus(): Field
    {
        return Select::make(trans('nova-ad-director::resource.fields.status'), 'status')
                     ->options(collect(config('nova-ad-director.statuses'))
                         ->mapWithKeys(fn ($status) => [$status => trans("nova-ad-director::resource.statuses.{$status}")])
                         ->toArray())
                     ->displayUsingLabels()
                     ->sortable()
                     ->rules('required');
    }

    public function fieldConfiguration(): Field
    {
        $field = Flexible::make('Configuration', 'configuration')
                         ->limit()
                         ->rules('required');
        foreach (config('nova-ad-director.flexible.configuration.layouts') as $layout) {
            $field->addLayout($layout);
        }

        return $field;
    }
}
