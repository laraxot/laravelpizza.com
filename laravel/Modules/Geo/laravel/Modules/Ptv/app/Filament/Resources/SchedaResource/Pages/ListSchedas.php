<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Override;

class ListSchedas extends BaseListSchedas
{
    protected static string $resource = SchedaResource::class;

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'type' => TextColumn::make('type'),
            'ha_diritto' => IconColumn::make('ha_diritto')->boolean(),
            'motivo_invio_email' => GroupColumn::make('motivo/invio_email')->schema([
                'motivo' => TextColumn::make('motivo')->searchable(),
                'mail_sended_at' => TextColumn::make('mail_sended_at')
                    ->html()
                    ->default(app(ShowMailSendedAt::class)->execute(...)),
            ]),
            'lavoratore' => LavoratoreColumn::make('lavoratore')->appendColumns([]),
            'qualifica' => QualificaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => PeriodoColumn::make('periodo'),
            'valutatore_id' => SelectColumn::make('valutatore_id')
                ->label('valutatore')
                ->options(function (mixed $record): array {
                    if (! is_object($record) || ! isset($record->anno)) {
                        return [];
                    }

                    /** @var int $anno */
                    $anno = $record->anno;

                    return StabiDirigente::query()
                        ->where('anno', $anno)
                        ->whereRaw('id=valutatore_id')
                        ->pluck('nome_diri', 'id')
                        ->toArray();
                })
                ->visible(auth()->user()?->isSuperAdmin() ?? false),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            'compila' => CompilaAction::make()
                ->visible(fn (SchedaContract $record): bool => (int) $record->ha_diritto > 0),
            'pdf' => PdfAction::make('pdf')
                ->visible(fn (SchedaContract $record): bool => (int) $record->ha_diritto > 0),
        ];
    }
}
