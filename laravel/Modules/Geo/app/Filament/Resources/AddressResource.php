<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Province;
use Modules\Geo\Models\Region;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource per la gestione degli indirizzi geografici.
 *
 * Fornisce un'interfaccia completa per:
 * - Creazione di nuovi indirizzi con validazione geografica
 * - Modifica dei dati esistenti
 * - Visualizzazione delle informazioni su mappa
 * - Gestione delle relazioni con altri modelli
 * fornendo funzionalità per la creazione, modifica e visualizzazione
 * degli indirizzi su mappa.
 */
class AddressResource extends XotBaseResource
{
    protected static ?string $model = Address::class;

    // ✅ CORRETTO - NIENTE navigationGroup - La gestione è centralizzata in XotBaseResource

    /**
     * @return array<string, mixed>
     */
    public static function getSearchStep(): array
    {
        return [
            'region' => Select::make('region')
                ->options(Region::getOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set): void {
                    $set('province', null);
                    $set('locality', null);
                    $set('postal_code', null);
                    $set('cap', null);
                }),
            'province' => Select::make('province')
                ->options(Province::getOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->afterStateUpdated(function (Set $set): void {
                    $set('cap', null);
                    $set('postal_code', null);
                    $set('locality', null);
                })
                ->disabled(fn (Get $get) => ! $get('region'))
                ->placeholder(__('filament-forms::components.select.placeholder')),
            // ->extraAttributes([
            // 'class' => 'h-9'
            // ])
            'locality' => Select::make('locality')
                ->options(Locality::getOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->disabled(fn (Get $get) => ! $get('region') || ! $get('province'))
                ->placeholder(__('filament-forms::components.select.placeholder'))
                ->afterStateUpdated(function (Set $set): void {
                    $set('postal_code', null);
                }),
            'postal_code' => Select::make('postal_code')
                ->options(Locality::getPostalCodeOptions(...))
                ->searchable()
                ->required()
                ->live()
                ->disabled(fn (Get $get) => ! $get('region') || ! $get('province'))
                ->placeholder(__('filament-forms::components.select.placeholder')),
        ];
    }
}
