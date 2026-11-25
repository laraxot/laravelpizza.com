<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources\RatingResource\RelationManagers;

use Modules\Rating\Filament\Resources\RatingResource;

/**
 * I sotto-criteri di un criterio, per il modulo Rating.
 *
 * Guscio di due righe, come `Schemas/RatingForm` e `Tables/RatingsTable` accanto:
 * tutto il comportamento sta nella base condivisa, qui si dichiara solo **a quale
 * Resource appartiene** — che e' l'unica cosa che la base non puo' sapere.
 */
class ChildrenRelationManager extends BaseChildrenRelationManager
{
    protected static string $resource = RatingResource::class;
}
