<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\SponsorResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Actions\Table\TableLayoutToggleTableAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Override;

class SponsorsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->placeholder('—')->searchable()->sortable(),
            'level' => TextColumn::make('level')->placeholder('—')
                ->badge()
                ->formatStateUsing(static fn (?string $state): string => $state === null ? '' : (string) __('meetup::sponsor_form.fields.level.options.'.$state)),
            'website' => TextColumn::make('website')->placeholder('—')->toggleable(),
            'order' => TextColumn::make('order')->placeholder('—')->numeric()->sortable(),
            'events_count' => TextColumn::make('events_count')->placeholder('—')->counts('events')->sortable(),
        ];
    }

    public function getDefaultTableSortColumn(): ?string
    {
        return 'name';
    }

    public function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    /**
     * Il pulsante "Nuovo" e' gia' nell'intestazione della pagina: qui resta solo il cambio vista (tabella o schede).
     *
     * @return array<string, TableLayoutToggleTableAction>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'layout' => TableLayoutToggleTableAction::make('layout'),
        ];
    }
}
