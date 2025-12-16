<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\User\Filament\Resources\DeviceResource;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DevicesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'devices';

    public static function extendTableCallback(): array
    {
        return [
            'login_at' => TextColumn::make('login_at'),
            'logout_at' => TextColumn::make('logout_at'),
        ];
    }

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'device' => TextInput::make('device')->required()->maxLength(255),
        ];
    }

    #[\Override]
    public function table(Table $table): Table
    {
        $table = DeviceResource::table($table);

        /**
         * @var array<Column|ColumnGroup|\Filament\Tables\Columns\Layout\Component> $columns
         */
        $columns = array_merge($table->getColumns(), static::extendTableCallback());

        $table = $table->columns($columns);

        return $table;
    }
}
