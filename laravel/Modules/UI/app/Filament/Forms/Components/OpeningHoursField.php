<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Component;
use Modules\UI\Actions\Datetime\GetDaysMappingAction;
use Modules\UI\Rules\OpeningHoursRule;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

/**
 * --.
 */
final class OpeningHoursField extends XotBaseField
{
    /**
     * Vista Blade per il rendering del componente.
     */
    protected string $view = 'ui::filament.forms.components.opening-hours-field';

    protected function setUp(): void
    {
        parent::setUp();
        $days = app(GetDaysMappingAction::class)->execute();

        $form = [];
        foreach ($days as $dayKey => $dayLabel) {
            $form = array_merge($form, $this->getDaySchema($dayKey, $dayLabel));
        }

        $this->schema($form)->columns(5);

        $this->rules([
            new OpeningHoursRule,
        ]);
    }

    /**
     * @return array<int, Component>
     */
    private function getDaySchema(string $dayKey, string $dayLabel): array
    {
        return [
            Placeholder::make($dayKey.'_label')
                ->content($dayLabel)
                ->extraAttributes([
                    'class' => 'font-medium text-gray-900 dark:text-gray-100 text-center py-2',
                ])
                ->columnSpan(1),

            $this->getTimePickerComponent("{$dayKey}.morning_from"),
            $this->getTimePickerComponent("{$dayKey}.morning_to"),
            $this->getTimePickerComponent("{$dayKey}.afternoon_from"),
            $this->getTimePickerComponent("{$dayKey}.afternoon_to"),
        ];
    }

    private function getTimePickerComponent(string $name): TimePicker
    {
        return TimePicker::make($name)
            ->native(false)
            ->format('H:i')
            ->seconds(false)
            ->minutesStep(15)
            ->nullable()
            ->live(false);
    }
}
