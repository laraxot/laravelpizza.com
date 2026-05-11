<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ContactsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'contact_type' => TextColumn::make('contact_type')->sortable(),
            'value' => TextColumn::make('value')->searchable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'verified_at' => TextColumn::make('verified_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
