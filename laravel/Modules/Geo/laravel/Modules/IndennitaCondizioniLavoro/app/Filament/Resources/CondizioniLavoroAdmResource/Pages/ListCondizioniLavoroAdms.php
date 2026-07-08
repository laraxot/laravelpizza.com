<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\IndennitaCondizioniLavoro\Actions\Populate;
use Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroAdmResource;
use Modules\Ptv\Actions\FixValutatoreIdByAnno;
use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Ptv\Filament\Tables\Columns\ValutatoreColumn;
use Filament\Actions\Action;
use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;
use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;


class ListCondizioniLavoroAdms extends XotBaseListRecords
{
    protected static string $resource = CondizioniLavoroAdmResource::class;

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        /** @var array{lavoratore: Column, valutatore: Column, indennitaTipoDettaglio: Column, quadrimestre: Column, anno: Column} */
        return [
            'lavoratore' => WorkerColumn::make('lavoratore'),
            'valutatore' => ValutatoreColumn::make('valutatore'),
            //TextColumn::make('cognome')->searchable(),
            //TextColumn::make('nome')->searchable(),
            //TextColumn::make('stabi')->searchable(),
            //TextColumn::make('repar')->searchable(),
            'indennitaTipoDettaglio' => TextColumn::make('indennitaTipoDettaglio')
                ->formatStateUsing(function (TextColumn $column) {
                    $state = $column->getState();
                    if (! $state instanceof Collection) {
                        return '';
                    }

                    /** @var Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio> $state */
                    return $state->pluck('indennitaTipo.nome')->implode(','.PHP_EOL.PHP_EOL.'');
                })
                ->wrap()
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();
                    if (! $state instanceof Collection) {
                        return null;
                    }

                    /** @var Collection<int, \Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio> $state */
                    return $state->map(function ($item): string {
                        if (! is_object($item)) {
                            return '';
                        }

                        // Type narrowing: ensure item has nome property
                        $nome = isset($item->nome) && is_string($item->nome) ? $item->nome : '';
                        $indennitaTipoNome = '';

                        // Type narrowing: ensure indennitaTipo exists and is object
                        if (isset($item->indennitaTipo) && is_object($item->indennitaTipo)) {
                            $indennitaTipoNome = isset($item->indennitaTipo->nome) && is_string($item->indennitaTipo->nome) ? $item->indennitaTipo->nome : '';
                        }

                        return '['.$indennitaTipoNome.'] '.$nome;
                    })->implode(' --------------------- ,'.PHP_EOL.PHP_EOL.'');
                }),
            'quadrimestre' => TextColumn::make('quadrimestre')->searchable(),
            'anno' => TextColumn::make('anno')->searchable(),
        ];
    }

    #[Override]
    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno/valutatore')
                ->label('anno/valutatore')
                ->schema([
                    Select::make('anno')
                        ->options([
                            '2023' => '2023',
                            '2024' => '2024',
                            '2025' => '2025',
                            '2026' => '2026',
                        ])
                        ->reactive(),
                    Select::make('quadrimestre')
                        ->options([
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                        ])
                        ->reactive(),
                    /*
                    Select::make('valutatore_id')
                        ->label('valutatore')
                        ->options(static fn (callable $get, callable $set) => app(GetValutatoriOptions::class)
                            ->execute('IndennitaCondizioniLavoro', $get('anno'))),
                    */
                ])
                ->query(static function (Builder $query, array $data) {
                    if ($data['anno'] == null) {
                        return $query->where('id', 0);
                    }
                    // app(Populate::class)->execute($data);
                    // app(FixValutatoreIdByAnno::class)->execute('IndennitaCondizioniLavoro', 'CondizioniLavoro', $data['anno']);

                    $query = $query->where($data);

                    if (! Auth::user()?->hasRole('super-admin')) {
                        return $query->whereHas('indennitaTipoDettaglio');
                    }

                    return $query;
                })->columns(4),
        ];
    }


    #[Override]
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            /*
            'exportPdf' => Action::make('exportPdf')
                ->label('Pdf ')
                ->icon('heroicon-s-document')
                ->action(function () {
                    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
                    return app(MakePdf::class)->execute($tableFilters);
                }),
            */
            'replicate' => Action::make('replicate')
                ->label('')
                ->icon('heroicon-o-clipboard-document-list')
                ->tooltip('ricopia da quadrimentre precendente')
                ->action(function (): void {
                    $tableFilters = is_array($this->tableFilters) ? $this->tableFilters : [];
                    
                    
                    app(ReplicateIndennita::class)->execute($tableFilters);
                }),
        ];
    }
}
