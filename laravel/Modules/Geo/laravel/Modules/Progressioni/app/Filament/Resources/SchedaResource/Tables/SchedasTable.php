<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedaResource\Tables;

use Filament\Actions\BulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Arr;
use Modules\Ptv\Filament\Actions\Bulk\SendSchedaBulkAction;
use Modules\Ptv\Filament\Resources\SchedaResource\Tables\BaseSchedasTable;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Override;

class SchedasTable extends BaseSchedasTable
{
    /**
     * @return array<string, Column>
     */
    #[Override]
    /**
    * @return array<string, Column>
    */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            'lavoratore' => GroupColumn::make('lavoratore')->schema([
                'matr' => TextColumn::make('matr')->searchable(),
                'cognome' => TextColumn::make('cognome')->searchable(),
                'nome' => TextColumn::make('nome'),
                'email' => TextColumn::make('email'),
            ])->searchable(['matr', 'cognome', 'nome', 'email']),
            'ha_diritto' => IconColumn::make('ha_diritto')
                ->boolean()
                ->sortable(),
            'motivo' => TextColumn::make('motivo')
                ->wrap()
                ->sortable(),

            'qua' => GroupColumn::make('qua')->schema([
                'categoria_ecoval' => TextColumn::make('categoria_ecoval'),
                'posfunval' => TextColumn::make('posfunval'),
                'disci1' => TextColumn::make('disci1'),
                'disci1_txt' => TextColumn::make('disci1_txt'),
            ]),
            'rep' => GroupColumn::make('rep')->schema([
                'stabi' => TextColumn::make('stabi'),
                'stabi_txt' => TextColumn::make('stabi_txt'),
                'repar' => TextColumn::make('repar'),
                'repar_txt' => TextColumn::make('repar_txt'),
            ]),
            'periodo' => GroupColumn::make('periodo')->schema([
                'dal' => TextColumn::make('dal'),
                'al' => TextColumn::make('al'),
                'anno' => TextColumn::make('anno'),
            ]),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Filtri Progressioni: definiti su ListSchedas fino al wire fase 3.
     *
     * @return array<string, Filter>
     */
    #[Override]
    /**
    * @return array<string, Filter>
    */
    public function getTableFilters(): array
    {
        return [];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        /** @var array<string, mixed> $tableFilters */
        $tableFilters = $this->tableFilters ?? [];
        /** @var array<string, mixed> $annoValutatoreFilter */
        $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
        /** @var int|string|null $anno */
        $anno = Arr::get($annoValutatoreFilter, 'anno');
        $tpl = 'progressioni-'.(string) ($anno ?? '');

        return [
            'send_schede' => SendSchedaBulkAction::make()->setTemplate($tpl),
        ];
    }
}
