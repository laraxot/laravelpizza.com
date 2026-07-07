<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources\TranslationFileResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class TranslationFilesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableHeaderActions(): array
    {
        $parentActions = parent::getTableHeaderActions();

        // Assicurarsi che tutte le azioni abbiano chiavi stringa
        /** @var array<string, Action|ActionGroup> $actions */
        $actions = [
            'locale_switcher' => LocaleSwitcherRefresh::make('lang'),
        ];

        // Aggiungere le azioni parent con chiavi stringa
        foreach ($parentActions as $key => $action) {
            $actions['parent_'.(is_string($key) ? $key : ((string) $key))] = $action;
        }

        return $actions;
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        /*
         * @return array<int\|string, \Filament\Tables\Columns\Column>
         */
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
