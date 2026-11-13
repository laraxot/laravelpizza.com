<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

<<<<<<< .merge_file_MeZdId
final class ListLogActivitiesNonSchemaFormResource
{
    public static function form(mixed $schema): object
    {
        return new \stdClass();
    }

    public static function canRestore(mixed $record): bool
=======
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesNonSchemaFormResource
{
    public static function form(Schema $schema): object
    {
        return new \stdClass;
    }

    public static function canRestore(Model $record): bool
>>>>>>> .merge_file_gmKljl
    {
        return false;
    }
}
