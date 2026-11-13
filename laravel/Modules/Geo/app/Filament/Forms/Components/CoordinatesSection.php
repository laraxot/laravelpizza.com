<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/**
 * Sezione generica per le coordinate geografiche di un record.
 *
 * Funziona con qualsiasi modello che esponga `full_address`, `latitude` e
 * `longitude` (es. Client TechPlanner, Address Geo). Geocoding delegato a
 * UpdateCoordinatesFromAddressAction, che resta nel modulo Geo: nessuna
 * dipendenza verso moduli di dominio.
 */
class CoordinatesSection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->columns(2);
        $this->heading((string) __('geo::coordinates.address_form.section.heading'))
            ->description((string) __('geo::coordinates.address_form.section.description'));
        $this->headerActions([
            Action::make('geocodeCoordinates')
                ->label((string) __('geo::coordinates.address_form.geocode.label'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->size('sm')
                ->visible(static fn (?Model $record): bool => $record instanceof Model)
                ->action(static function (?Model $record, Set $set): void {
                    if (! $record instanceof Model) {
                        return;
                    }

                    $action = app(UpdateCoordinatesFromAddressAction::class);

                    if (! $action->execute($record)) {
                        Notification::make()
                            ->warning()
                            ->title((string) __('geo::coordinates.address_form.geocode.failed_title'))
                            ->body(implode(' ', $action->getErrors()->all()))
                            ->send();

                        return;
                    }

                    $record->refresh();
                    $set('/latitude', $record->getAttribute('latitude'));
                    $set('/longitude', $record->getAttribute('longitude'));

                    Notification::make()
                        ->success()
                        ->title((string) __('geo::coordinates.address_form.geocode.success_title'))
                        ->send();
                }),
        ]);
        $this->schema($this->getFormSchema());
    }

    /**
     * @return array<string, TextInput>
     */
    protected function getFormSchema(): array
    {
        return [
            'latitude' => TextInput::make('latitude')
                ->label((string) __('geo::coordinates.fields.latitude.label'))
                ->numeric()
                ->minValue(-90)
                ->maxValue(90)
                ->rule('regex:/^-?\d{1,2}(\.\d{1,7})?$/'),
            'longitude' => TextInput::make('longitude')
                ->label((string) __('geo::coordinates.fields.longitude.label'))
                ->numeric()
                ->minValue(-180)
                ->maxValue(180)
                ->rule('regex:/^-?\d{1,3}(\.\d{1,7})?$/'),
        ];
    }
}
