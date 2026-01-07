<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SsoProviderResource\RelationManagers;

<<<<<<< HEAD
use Filament\Tables\Columns\Column;
=======
<<<<<<< HEAD
use Filament\Tables\Columns\Column;
=======
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Modules\Xot\Filament\Traits\HasXotTable;

class UsersRelationManager extends XotBaseRelationManager
{
    use HasXotTable;

    protected static string $relationship = 'users';

    protected static ?string $recordTitleAttribute = 'name';

    /**
<<<<<<< HEAD
     * @return array<string, Column>
=======
<<<<<<< HEAD
     * @return array<string, Column>
=======
     * @return array<string, \Filament\Tables\Columns\Column>
>>>>>>> 939bd20e2 (.)
>>>>>>> 9d7e4c81 (.)
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable()->toggleable(),
            'name' => TextColumn::make('name')->searchable()->sortable()->toggleable(),
            'email' => TextColumn::make('email')->searchable()->sortable()->toggleable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->toggleable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
