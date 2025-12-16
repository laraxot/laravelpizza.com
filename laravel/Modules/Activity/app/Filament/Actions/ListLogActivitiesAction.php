<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Actions;

use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Actions\XotBaseAction;

/**
 * Action per visualizzare lo storico delle attività di un record.
 *
 * Questa action reindirizza alla pagina 'log-activity' della Resource corrente,
 * mostrando tutte le modifiche effettuate sul record tramite Spatie Activity Log.
 *
 * ⚠️ IMPORTANTE: Estende XotBaseAction, MAI estendere Filament\Actions\Action direttamente!
 *
 * @example
 * ```php
 * // In getTableActions() di una Resource Page
 * public function getTableActions(): array
 * {
 *     return [
 *         'activities' => ListLogActivitiesAction::make(),
 *     ];
 * }
 * ```
 *
 * @see \Modules\Activity\Filament\Pages\ListLogActivities
 * @see \Modules\Xot\Filament\Actions\XotBaseAction
 * @see https://github.com/spatie/laravel-activitylog
 */
class ListLogActivitiesAction extends XotBaseAction
{
    /**
     * Configura l'action.
     *
     * Override del metodo setUp() per configurare tutte le proprietà
     * dell'action secondo le convenzioni Laraxot:
     * - MAI usare ->label() o ->tooltip() (traduzioni automatiche via LangServiceProvider)
     * - Icona standard per consistenza UI
     * - Colore appropriato per azione di visualizzazione
     * - URL dinamico basato sulla Resource corrente
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->iconButton();
        $this->icon('heroicon-o-clock')
            ->color('gray')
            ->url(function (ListRecords $livewire, Model $record): string {
                /** @var class-string<resource> $resource */
                $resource = $livewire->getResource();

                return $resource::getUrl('log-activity', ['record' => $record]);
            });
    }

    /**
     * Nome di default dell'action.
     *
     * Questo nome viene utilizzato come chiave nell'array delle actions
     * e per la generazione automatica delle traduzioni tramite LangServiceProvider.
     */
    public static function getDefaultName(): ?string
    {
        return 'list_log_activities';
    }
}
