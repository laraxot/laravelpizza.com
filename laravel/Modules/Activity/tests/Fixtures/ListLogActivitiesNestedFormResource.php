<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesNestedFormResource
{
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('gruppo')->schema([
                TextInput::make('nested_field')->label('Nested'),
            ]),
            Section::make('vuoto')->schema([]),
            TextInput::make('flat_field')->label('Flat'),
        ]);
    }

    public static function canRestore(Model $record): bool
    {
        return false;
    }
}
