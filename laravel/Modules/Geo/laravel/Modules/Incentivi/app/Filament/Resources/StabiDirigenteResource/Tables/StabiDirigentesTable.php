<?php

declare(strict_types=1);

namespace Modules\Incentivi\Filament\Resources\StabiDirigenteResource\Tables;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Header\ImportStabiDirigenteAction;
use Modules\Ptv\Filament\Actions\Header\ImportValutatoriAction;
use Modules\Xot\Actions\ModelClass\CountAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class StabiDirigentesTable extends XotBaseResourceTable
{
    public function getTableHeaderActions(): array
    {
        // recupera le azioni del parent
        $actions = parent::getTableHeaderActions();

        // aggiungi le azioni con chiavi stringa esplicite
        $actions['import_valutatori_'] = ImportValutatoriAction::make('import_valutatori_')
            ->addFields([
                'anno' => TextInput::make('anno'),
                'quadrimestre' => TextInput::make('quadrimestre'),
            ])
            ->setStabiDirigenteModel(StabiDirigente::class)
            ->setSchedaModel(CondizioniLavoro::class);

        $actions['import_stabi_dirigente_'] = ImportStabiDirigenteAction::make('import_stabi_dirigente_')
            ->visible(fn (): bool => app(CountAction::class)->execute(StabiDirigente::class) === 0);

        return $actions;
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'id' => TextColumn::make('id'),
            'valutatore_id' => TextColumn::make('valutatore_id'),
            'stabi' => TextColumn::make('stabi')->searchable(),
            'repar' => TextColumn::make('repar')->searchable(),
            'nome_stabi' => TextColumn::make('nome_stabi')->searchable(),
            // Tables\Columns\TextColumn::make('ente')->searchable(),
            'matr' => TextColumn::make('matr')->searchable(),
            'nome_diri' => TextColumn::make('nome_diri')->searchable(),
            'nome_diri_plus' => TextColumn::make('nome_diri_plus')->searchable(),
            // TextColumn::make('email')->searchable(),
            'anno' => TextColumn::make('anno'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno')
                ->options([
                    '2021' => '2021',
                    '2022' => '2022',
                    '2023' => '2023',
                    '2024' => '2024',
                    '2025' => '2025',
                ])->query(static function (Builder $query, array $data): Builder {
                    if ($data['value'] == null) {
                        return $query->where('id', 0);
                    }

                    return $query->where('anno', $data['value']);
                }),
        ];
    }
}
