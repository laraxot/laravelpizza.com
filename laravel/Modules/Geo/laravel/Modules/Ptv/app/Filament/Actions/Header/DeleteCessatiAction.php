<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Actions\Header;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Ptv\Actions\Cessati\GetCessatiRecords;
use Modules\Ptv\Actions\Cessati\GetCessatiRecordsCount;
use Modules\Ptv\Actions\Cessati\GetCessatiRecordsCountAction;
use Modules\Ptv\Actions\Cessati\GetCessatiRecordsPreview;

/**
 * DeleteCessatiAction - Header action to delete records that exist in indennitaResponsabilita
 * but not in rep00f for a specific year.
 *
 * This action:
 * 1. Shows a modal asking for year selection
 * 2. Displays records that exist in indennitaResponsabilita but not in rep00f for that year
 * 3. Provides a delete button to remove those records
 */
final class DeleteCessatiAction extends Action
{
    public static function make(?string $name = null): static
    {
        $name ??= self::getDefaultName();

        return parent::make($name);
    }

    public static function getDefaultName(): string
    {
        return 'delete_cessati';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('')
            ->tooltip(__('ptv::scheda.actions.delete_cessati.label'))
            ->icon('heroicon-o-trash')
            ->color('danger')
            ->form([
                Select::make('anno')
                    ->label(__('ptv::scheda.actions.delete_cessati.year_label'))
                    ->placeholder(__('ptv::scheda.actions.delete_cessati.year_placeholder'))
                    ->options([
                        '2023' => '2023',
                        '2024' => '2024',
                        '2025' => '2025',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set): void {
                        $count = $state ? app(GetCessatiRecordsCount::class)->execute((int) $state) : 0;
                        $set('records_count', $count > 0
                            ? "{$count} record trovati"
                            : 'Nessun record trovati');

                        // Also update the preview
                        $preview = $state ? app(GetCessatiRecordsPreview::class)->execute((int) $state) : '';
                        $set('records_preview', $preview);
                    }),

                TextEntry::make('records_count')
                    ->label(__('ptv::scheda.actions.delete_cessati.count_label'))
                    ->formatStateUsing(function ($state, callable $get): string {
                        $anno = $get('anno');
                        if (! $anno) {
                            return 'Seleziona un anno';
                        }

                        $count = app(GetCessatiRecordsCountAction::class)->execute((int) $anno);

                        return $count > 0
                            ? "{$count} record trovati"
                            : 'Nessun record trovati';
                    })
                    ->badge()
                    ->color(fn (string $state): string => str_contains($state, 'Nessun') ? 'gray' : 'warning'),

                Textarea::make('records_preview')
                    ->label(__('ptv::scheda.actions.delete_cessati.preview_label'))
                    ->rows(10)
                    ->disabled(),
            ])
            ->action(function (array $data, $livewire): void {
                if (! ($livewire instanceof ListRecords)) {
                    return;
                }

                $anno = $data['anno'] ?? null;
                if (! $anno) {
                    Notification::make()
                        ->title(__('ptv::scheda.actions.delete_cessati.no_year_error'))
                        ->danger()
                        ->send();

                    return;
                }

                $cessatiRecords = app(GetCessatiRecords::class)->execute((int) $anno);

                if ($cessatiRecords->isEmpty()) {
                    Notification::make()
                        ->title(__('ptv::scheda.actions.delete_cessati.no_records_error'))
                        ->warning()
                        ->send();

                    return;
                }

                try {
                    DB::transaction(function () use ($cessatiRecords): void {
                        foreach ($cessatiRecords as $record) {
                            $record->delete();
                        }
                    });

                    Notification::make()
                        ->title(__('ptv::scheda.actions.delete_cessati.success_title', [
                            'count' => $cessatiRecords->count(),
                        ]))
                        ->success()
                        ->send();

                    $livewire->resetTable();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title(__('ptv::scheda.actions.delete_cessati.error_title'))
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            })
            ->modalHeading(__('ptv::scheda.actions.delete_cessati.modal_title'))
            ->modalDescription(__('ptv::scheda.actions.delete_cessati.modal_description'))
            ->modalSubmitActionLabel(__('ptv::scheda.actions.delete_cessati.submit_label'))
            ->modalCancelActionLabel(__('ptv::scheda.actions.delete_cessati.cancel_label'))
            ->modalWidth('4xl')
            ->visible(function ($livewire): bool {
                if (! ($livewire instanceof ListRecords)) {
                    return false;
                }

                $resource = $livewire->getResource();
                $user = auth()->user();
                $canDelete = $user && $user->hasRole(['super-admin', 'admin', 'hr-manager']);

                return $canDelete;
            });
    }
}
