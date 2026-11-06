<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\ContactResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Models\Contact;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ContactsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Contact>
     */
    protected static string $model = Contact::class;

    public function getTableFilters(): array
    {
        return [
            'active' => Filter::make('active')->query(fn (Builder $query): Builder => $query->where('active', true)),
            'inactive' => Filter::make('inactive')->query(
                fn (Builder $query): Builder => $query->where('active', false),
            )];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id'),
            'contact_type' => TextColumn::make('contact_type')->searchable()->sortable(),
            'value' => TextColumn::make('value')->searchable()->sortable()->copyable()->wrap(),
            'first_name' => TextColumn::make('first_name')->searchable()->sortable(),
            'last_name' => TextColumn::make('last_name')->searchable()->sortable(),
            'user_id' => TextColumn::make('user_id')->sortable(),
            'verified_at' => TextColumn::make('verified_at')->dateTime()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true)];
    }

    /**
     * @return array<string, IconColumn|TextColumn>
     */
    public static function contactTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id'),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'email' => TextColumn::make('email')->searchable()->sortable(),
            'phone' => TextColumn::make('phone')->searchable()->sortable(),
            'message' => TextColumn::make('message')->searchable()->sortable(),
            'is_read' => IconColumn::make('is_read')->boolean(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()];
    }

    /**
     * @return array<string, Filter>
     */
    public static function contactTableFilters(): array
    {
        return [
            'active' => Filter::make('active')->query(fn (Builder $query): Builder => $query->where('active', true)),
            'inactive' => Filter::make('inactive')->query(
                fn (Builder $query): Builder => $query->where('active', false),
            )];
    }
}
