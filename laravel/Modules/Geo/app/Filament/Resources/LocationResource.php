<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Resources;

use Modules\Geo\Filament\Resources\LocationResource\Pages\CreateLocation;
use Modules\Geo\Filament\Resources\LocationResource\Pages\EditLocation;
use Modules\Geo\Filament\Resources\LocationResource\Pages\ListLocations;
use Modules\Geo\Filament\Resources\LocationResource\Pages\ViewLocation;
use Modules\Geo\Models\Location;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Resource per la gestione dei luoghi geografici.
 *
 * Fornisce un'interfaccia completa per:
 * - Creazione di nuovi luoghi con coordinate geografiche
 * - Modifica dei dati esistenti
 * - Visualizzazione delle informazioni su mappa
 * - Ricerca per raggio geografico
 * - Gestione delle relazioni con altri modelli
 */
class LocationResource extends XotBaseResource
{
    protected static ?string $model = Location::class;

    // ✅ CORRETTO - NIENTE navigationGroup - La gestione è centralizzata in XotBaseResource

    /**
     * Definisce le relazioni disponibili per questo resource.
     *
     * @return array<mixed> Le relazioni configurate
     */
    #[\Override]
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Definisce le pagine disponibili per questo resource.
     *
     * Include le pagine per:
     * - Lista dei luoghi
     * - Creazione nuovo luogo
     * - Modifica luogo esistente
     *
     * @return array<mixed> Le pagine configurate
     */
    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListLocations::route('/'),
            'create' => CreateLocation::route('/create'),
            'view' => ViewLocation::route('/{record}'),
            'edit' => EditLocation::route('/{record}/edit'),
        ];
    }
}
