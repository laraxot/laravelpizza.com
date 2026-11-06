<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Socialite\Resources\SsoProviderResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\SsoProvider;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Filament\Tables\Filters\IsActiveFilter;

class SsoProvidersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<SsoProvider>
     */
    protected static string $model = SsoProvider::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'display_name' => TextColumn::make('display_name')->searchable()->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'type' => TextColumn::make('type')->toggleable(isToggledHiddenByDefault: true),
            // Senza `label()` l'icona non ha testo da annunciare: per lo screen reader
            // e' un controllo muto.
            'is_active' => IconColumn::make('is_active')->boolean()->sortable()->label(__('xot::table-filters.is_active.label')),
            'entity_id' => TextColumn::make('entity_id')->toggleable(isToggledHiddenByDefault: true),
            'redirect_url' => TextColumn::make('redirect_url')->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Il filtro su `is_active` riusa `IsActiveFilter` invece di un `SelectFilter` con
     * opzioni inglesi scritte qui: l'etichetta, lo stato vuoto e le query arrivano gia'
     * tradotti. Il filtro su `type` resta un `SelectFilter` perche' `SAML`, `OIDC` e
     * `OAuth` sono acronimi tecnici che non si traducono.
     *
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'type' => SelectFilter::make('type')->options([
                'saml' => 'SAML',
                'oidc' => 'OIDC',
                'oauth' => 'OAuth',
            ]),
            'is_active' => IsActiveFilter::make('is_active'),
        ];
    }
}
