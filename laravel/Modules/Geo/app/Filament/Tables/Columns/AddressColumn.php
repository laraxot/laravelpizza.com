<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Tables\Columns;

use Filament\Tables\Columns\ViewColumn;
use Modules\Geo\Enums\AddressItemEnum;

/**
 * AddressColumn - Colonna Filament riutilizzabile per rendering indirizzi.
 *
 * Utilizza ViewColumn + Blade view per separare completamente
 * logica e presentazione seguendo i principi DRY/KISS
 *
 * PATTERN CORRETTO:
 * - ViewColumn per layout complessi
 * - Blade view separata per HTML
 * - Accessibilità WCAG 2.1 AA compliant
 *
 * Segue esattamente la stessa architettura di ContactColumn
 * per garantire consistenza nel codebase
 *
 * @author Laraxot Team
 *
 * @version 1.0 - IMPLEMENTAZIONE INIZIALE
 *
 * @since 2025-12-12
 */
class AddressColumn extends ViewColumn
{
    /**
     * View Blade per il rendering della colonna.
     */
    protected string $view = 'geo::filament.tables.columns.address';

    protected function setUp(): void
    {
        parent::setUp();

        // Passa i componenti indirizzo alla view
        $addressItems = AddressItemEnum::cases();

        /** @var array<string> $searchableArray */
        $searchableArray = AddressItemEnum::getSearchable();

        $this->view(static::getView())
            'address_items' => $addressItems,
        ])
            ->searchable($searchableArray)
            ->sortable(false)
            ->toggleable(isToggledHiddenByDefault: false);
    }
}
