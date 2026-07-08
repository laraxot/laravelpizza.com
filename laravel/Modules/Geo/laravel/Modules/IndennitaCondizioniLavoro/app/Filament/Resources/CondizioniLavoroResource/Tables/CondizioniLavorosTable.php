<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Filament\Resources\CondizioniLavoroResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;
use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;
use Modules\Ptv\Actions\GetValutatoriOptionsByWhere;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Symfony\Component\HttpFoundation\Response;

class CondizioniLavorosTable extends XotBaseResourceTable
{
    public function getTableHeaderActions(): array
    {
        return [
            'exportPdf' => Action::make('exportPdf')
                ->label('Pdf ')
                ->icon('heroicon-s-document')
                ->action(function (): Response {
                    /** @var array<string, mixed> */
                    /** @phpstan-ignore-next-line property.notFound */
                    $rawFilters = $this->tableFilters;
                    /** @var array<string, mixed> $tableFilters */
                    $tableFilters = is_array($rawFilters) ? $rawFilters : [];

                    return app(MakePdf::class)->execute($tableFilters);
                }),
            'replicate' => Action::make('replicate')
                ->label('')
                ->icon('heroicon-o-clipboard-document-list')
                ->tooltip('ricopia da quadrimentre precendente')
                ->action(function (): void {
                    /** @var array<string, mixed> */
                    /** @phpstan-ignore-next-line property.notFound */
                    $rawFilters = $this->tableFilters;
                    /** @var array<string, mixed> $tableFilters */
                    $tableFilters = is_array($rawFilters) ? $rawFilters : [];
                    app(ReplicateIndennita::class)->execute($tableFilters);
                }),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        // Use WorkerColumn for DRY - groups matr, cognome, nome
        return [
            'lavoratore' => WorkerColumn::make('lavoratore'),
            // 'stabi' => TextColumn::make('stabi')->searchable(),
            // 'repar' => TextColumn::make('repar')->searchable(),
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

    /**
     * @return array<int, \Filament\Tables\Filters\SelectFilter>
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
                    Select::make('valutatore_id')
                        ->label('valutatore')
                        ->options(static fn (callable $get) => app(GetValutatoriOptionsByWhere::class)
                            ->execute('IndennitaCondizioniLavoro', ['anno' => $get('anno'), 'quadrimestre' => $get('quadrimestre')])),
                ])
                ->query(static function (Builder $query, array $data): Builder {
                    // Type narrowing: ensure data has required keys
                    $anno = isset($data['anno']) && (is_int($data['anno']) || is_string($data['anno'])) ? $data['anno'] : null;
                    if ($anno === null) {
                        return $query->where('id', 0);
                    }

                    // NOTE: Populate/FixValutatoreIdByAnno calls intentionally disabled here (legacy behaviour).

                    $query = $query->where($data);

                    if (! Auth::user()?->hasRole('super-admin')) {
                        return $query->whereHas('indennitaTipoDettaglio');
                    }

                    return $query;
                })->columns(4),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableActions(): array
    {
        // Types are inferred by Filament v4
        return [
            'compila' => CompilaAction::make(),

            'edit' => EditAction::make()
                ->iconButton()
                ->tooltip('modifica'),
        ];
    }
}
