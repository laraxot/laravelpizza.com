<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesNonSchemaFormResource
{
    public static function form(Schema $schema): object
    {
        return new \stdClass;
    }

    public static function canRestore(Model $record): bool
    {
        return false;
    }
}
