<?php

namespace NovaAdDirector\Nova\Flexible\Layouts;

use AdDirector\Facades\AdDirector;
use AdDirector\GPT\AdGPT;
use AdDirector\GPT\Slot;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\Text;
use NovaAdDirector\Contracts\ConfigurationLayout;
use NovaFlexibleContent\Concerns\HasFlexible;
use NovaFlexibleContent\Flexible;
use NovaFlexibleContent\Layouts\Layout;
use NovaFlexibleContent\Layouts\Preset;

class GPTConfigurationLayout extends Layout implements ConfigurationLayout
{
    use HasFlexible;

    protected string $name = 'gpt';

    protected string $title = 'gpt';

    public function title(): string
    {
        return trans("nova-ad-director::resource.layouts.{$this->title}");
    }

    protected function targetsPreset()
    {
        return Preset::withLayouts([
            GPTTarget::class,
        ]);
    }

    public function fields(): array
    {
        $allowedSizeKeys = array_keys(AdGPT::getSizes());

        return [
            Text::make(
                trans("nova-ad-director::resource.configuration.{$this->name}.adUnitPath"),
                'adUnitPath'
            )
                ->placeholder('/1234567/Example_Leaderboard')
                ->rules('required'),
            Text::make(
                trans("nova-ad-director::resource.configuration.{$this->name}.size"),
                'size'
            )
                ->placeholder($allowedSizeKeys[0] ?? trans("nova-ad-director::resource.configuration.{$this->name}.size"))
                ->rules('required', Rule::in($allowedSizeKeys))
                ->help(trans("nova-ad-director::resource.configuration.{$this->name}.help_size", [
                    'sizes' => !empty($allowedSizeKeys) ? implode(', ', $allowedSizeKeys) : '-',
                ])),
            Text::make(
                trans("nova-ad-director::resource.configuration.{$this->name}.divId"),
                'divId'
            )
                ->placeholder('div-gpt-ad-1234567891234-0')
                ->rules('nullable')
                ->help(trans("nova-ad-director::resource.configuration.{$this->name}.help_divId")),
            Flexible::make('Targets', 'targets')
                    ->preset($this->targetsPreset())
                    ->button('Add target'),
        ];
    }

    public function getFlexibleTargetsAttribute()
    {
        return $this->flexible('targets', $this->targetsPreset()->layouts());
    }

    public function applyConfiguration(string $locationName): static
    {
        $slot = Slot::make(
            $this->adUnitPath,
            $this->size,
            $this->divId ?: null
        );

        if ($this->flexibleTargets) {
            /**
             * @var \NovaAdDirector\Nova\Flexible\Layouts\GPTTarget $target
             */
            foreach ($this->targets as $target) {
                if (($key = trim($target->target_key))
                    && ($value = trim($target->target_value))) {
                    $values = array_filter(array_map('trim', explode(',', $value)));
                    if (!empty($values)) {
                        $slot->addTarget($key, $values);
                    }
                }
            }
        }

        AdDirector::gpt()->addLocation($slot, $locationName);

        return $this;
    }
}
