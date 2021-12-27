<?php

namespace NovaAdDirector\Nova\Flexible\Layouts;

use Laravel\Nova\Fields\Text;
use Whitecube\NovaFlexibleContent\Layouts\Layout;

class GPTTarget extends Layout
{
    protected string $name = 'gpt-target';

    protected string $title = 'gpt-target';

    public function title(): string
    {
        return trans("nova-ad-director::resource.layouts.{$this->title}");
    }

    public function fields(): array
    {
        return [
            Text::make(
                trans("nova-ad-director::resource.configuration.{$this->name}.target_key"),
                'target_key'
            )
                ->placeholder('Sponsor_Ad_Targets')
                ->rules('required')
                ->help(trans("nova-ad-director::resource.configuration.{$this->name}.help_target_key")),
            Text::make(
                trans("nova-ad-director::resource.configuration.{$this->name}.target_value"),
                'target_value'
            )
                ->placeholder('Sponsor1,Sponsor2')
                ->rules('required')
                ->help(trans("nova-ad-director::resource.configuration.{$this->name}.help_target_value")),
        ];
    }
}
