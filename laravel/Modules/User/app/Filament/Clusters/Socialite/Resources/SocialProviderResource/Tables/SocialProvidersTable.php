<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SocialProviderResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\SocialProvider;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Filament\Tables\Filters\IsActiveFilter;

class SocialProvidersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<SocialProvider>
     */
    protected static string $model = SocialProvider::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            // L'icona da sola non dice nulla a uno screen reader: senza `label()`
            // non c'e' testo da annunciare. La stringa e' quella di `IsActiveFilter`,
            // perche' il concetto e' lo stesso ("stalo attivo"), anche se il campo
            // della colonna si chiama `active` e non `is_active`.
            'active' => IconColumn::make('active')->boolean()->sortable()->label(__('xot::table-filters.is_active.label')),
            'socialite' => IconColumn::make('socialite')->boolean()->sortable(),
            'stateless' => IconColumn::make('stateless')->boolean()->sortable(),
            'scopes' => TextColumn::make('scopes')->badge()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Non un `SelectFilter::make('active')->options([true => 'Active', false => 'Inactive'])`
     * scritto qui: le due opzioni erano stringhe inglesi non tradotte, il filtro non aveva
     * etichetta e il terzo stato ("filtro non applicato") restava un trattino muto.
     * `IsActiveFilter` porta etichetta, stato vuoto e query gia' tradotte in it/en/de.
     *
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'active' => IsActiveFilter::make('active'),
        ];
    }
}
