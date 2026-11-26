<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingMorphResource\Pages;

use Modules\Rating\Filament\Resources\RatingMorphResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

/**
 * Lista dei voti (`rating_morph`). Il pulsante di creazione non si dichiara qui:
 * `XotBaseListRecords::getHeaderActions()` lo costruisce (e lo traduce con
 * `rating::rating_morph.actions.create.label`). Un `getActions()` locale non veniva mai
 * chiamato, perche' la base sovrascrive `getHeaderActions()` senza richiamare il parent.
 *
 * @see Modules/Rating/docs/wiki/concepts/xotbase-table-columns-enforcement.md
 */
class ListRatingMorphs extends XotBaseListRecords
{
    protected static string $resource = RatingMorphResource::class;
}
