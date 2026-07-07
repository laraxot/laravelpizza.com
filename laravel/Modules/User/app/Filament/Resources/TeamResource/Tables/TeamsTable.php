<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\TeamResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TeamsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> 40b96bcd6 (.)
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'user_id' => TextColumn::make('user_id'),
            'name' => TextColumn::make('name')->searchable(),
            'slug' => TextColumn::make('slug'),
            'personal_team' => TextColumn::make('personal_team')->badge(),
            'description' => TextColumn::make('description'),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
        ];
    }
}
