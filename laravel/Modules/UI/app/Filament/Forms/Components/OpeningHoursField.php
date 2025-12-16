<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TimePicker;
use Modules\UI\Actions\Datetime\GetDaysMappingAction;
use Modules\UI\Rules\OpeningHoursRule;

/**
 * --.
 */
final class OpeningHoursField extends Field
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
        $native = false;
        $live = false;

        foreach ($days as $dayKey => $dayLabel) {
            $form[] = Placeholder::make($dayKey.'_label')
                ->label('')
                ->content($dayLabel)
                ->extraAttributes(['class' => 'font-medium text-gray-900 dark:text-gray-100 text-center py-2'])
                ->columnSpan(1);

            $form[] = TimePicker::make("{$dayKey}.morning_from")
                ->native($native)
                // ->placeholder('08:00')
                // ->placeholder('09:30')
                ->placeholder('--:--')
                ->format('H:i')
                ->seconds(false)
                ->minutesStep(15)
                ->nullable()
                ->live($live);

            $form[] = TimePicker::make("{$dayKey}.morning_to")
                ->native($native)
                // ->placeholder('13:30')
                ->placeholder('--:--')
                ->format('H:i')
                ->seconds(false)
                ->minutesStep(15)
                ->nullable()
                ->live($live);

            $form[] = TimePicker::make("{$dayKey}.afternoon_from")
                ->native($native)
                // ->placeholder('15:00')
                ->placeholder('--:--')
                ->format('H:i')
                ->seconds(false)
                ->minutesStep(15)
                ->nullable()
                ->live($live);

            $form[] = TimePicker::make("{$dayKey}.afternoon_to")
                ->native($native)
                // ->placeholder('19:00')
                ->placeholder('--:--')
                ->format('H:i')
                ->seconds(false)
                ->minutesStep(15)
                ->nullable()
                ->live($live);
        }

        $this->schema($form)->columns(5);

        $this->afterStateUpdated(function ($_state): void {
            // dddx($state);
        });
        $this->afterStateHydrated(function (OpeningHoursField $_component, $_state): void {
            // Qui puoi normalizzare lo stato iniziale se serve
            // dddx($state);
        });
        $this->rules([
            /*
             * function(){
             * $data = $this->getState();
             * $this->addError(null, 'test');
             * return false;
             * }*/
            new OpeningHoursRule,
        ]);
    }
}
