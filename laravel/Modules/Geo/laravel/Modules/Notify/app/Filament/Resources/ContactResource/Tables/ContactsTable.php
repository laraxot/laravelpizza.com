<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ContactsTable extends XotBaseResourceTable
{
    public function getTableFilters(): array
    {
        return [
            'active' => Filter::make('active')->query(fn (Builder $query): Builder => $query->where('active', true)),
            'inactive' => Filter::make('inactive')->query(
                fn (Builder $query): Builder => $query->where('active', false),
            ),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
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
