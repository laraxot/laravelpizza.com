<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Fixtures;

use Modules\Rating\Filament\Resources\RatingResource;
use Modules\Rating\Filament\Resources\RatingResource\Tables\BaseRatingsTable;

/**
 * Stub concreto: evita classi anonime che in alcuni contesti PHPUnit
 * innescano side-effect del costruttore XotBaseResourceTable.
 *
 * Una Table class reale vive in `{Resource}\Tables\` e `XotBaseResourceTable::getResource()`
 * deduce la Resource dal namespace; lo stub vive in `Tests\Fixtures`, quindi dichiara la
 * Resource a cui appartiene `BaseRatingsTable` invece di aggirare l'asserzione.
 *
 * @see Modules/Rating/docs/filament-table-architecture.md
 */
final class BaseRatingsTableStub extends BaseRatingsTable
{
    /**
     * @return class-string<RatingResource>
     *
     * @see Modules/Rating/docs/filament-table-architecture.md
     */
    public static function getResource(): string
    {
        return RatingResource::class;
    }
}
