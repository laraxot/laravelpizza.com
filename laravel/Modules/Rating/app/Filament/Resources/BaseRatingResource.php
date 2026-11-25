<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Resources;

use Modules\Rating\Models\Rating;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseRatingResource extends XotBaseResource
{
    protected static ?string $model = Rating::class;

    /**
     * Le relazioni le dichiara ogni modulo, non questa base.
     *
     * Il RelationManager deve nominare la `RatingResource` **del proprio modulo**
     * (`XotBaseRelationManager::$resource`), che questa classe non puo' conoscere:
     * per questo la base e' astratta e la foglia sta accanto alla Resource, come
     * gia' fanno `Schemas/` e `Tables/`.
     *
     * @return array<int, class-string>
     */
    public static function getRelations(): array
    {
        return [];
    }
}
