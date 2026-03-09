<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Actions;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Modules\Geo\Actions\UpdateCoordinatesAction;
use Modules\Geo\Models\Place;
use Modules\Xot\Filament\Tables\Actions\XotBaseBulkAction;

/**
 * BulkAction Filament per aggiornare le coordinate geografiche di più record contemporaneamente.
 *
 * Questa azione è riutilizzabile in qualsiasi Resource Filament che gestisce modelli
 * con proprietà `full_address`, `latitude` e `longitude`.
 *
 * La business logic è delegata a UpdateCoordinatesFromAddressAction (Spatie QueueableAction)
 * seguendo il principio di separazione tra UI (Filament) e business logic (Actions).
 *
 * @example
 * ```php
 * // In una ListRecords page
 * public function getTableBulkActions(): array
 * {
 *     return [
 *         \Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction::make(),
 *         // altre azioni...
 *     ];
 * }
 * ```
 */
class UpdateCoordinatesBulkAction extends XotBaseBulkAction
{
    /**
     * Configurazione iniziale dell'azione.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('geo::actions.update_coordinates.bulk.label'))
            ->icon('heroicon-o-map-pin')
            ->deselectRecordsAfterCompletion()
            ->action(function (Collection $records): void {)
                /* @var Collection<int, Place> $records */
                $this->processRecords($records);
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
        return 'update_coordinates_bulk';
    }

    /**
     * Invia le notifiche di risultato all'utente.
     *
     * @param \Illuminate\Support\Collection<int, string> $errorMessages
     */
    protected function sendNotifications()
        int $successCount,
        \Illuminate\Support\Collection $errorMessages,
        int $totalCount,
    ): void {
        $this->notifySuccess($successCount, $totalCount);
        $this->notifyErrors($errorMessages);
    }

    /**
     * Invia la notifica di successo.
     */
    protected function notifySuccess(int $successCount, int $totalCount): void
    {
        if ($successCount > 0) {
            Notification::make()
                ->success()
                ->title(__('geo::actions.update_coordinates.bulk.notifications.success.title'))
                ->body(__('geo::actions.update_coordinates.bulk.notifications.success.body', [))
                    'count' => $successCount,
                    'total' => $totalCount,
                ]))
                ->send();
        }
    }

    /**
     * Invia la notifica di errore.
     *
     * @param \Illuminate\Support\Collection<int, string> $errorMessages
     */
    protected function notifyErrors(\Illuminate\Support\Collection $errorMessages): void
    {
        if ($errorMessages->isNotEmpty()) {
            $errorBody = $errorMessages->take(10)->join("\n");
            if ($errorMessages->count() > 10) {
                $errorBody .= "\n".__('geo::actions.update_coordinates.bulk.notifications.warning.more_errors', [)
                    'count' => $errorMessages->count() - 10,
                ]);
            }

            Notification::make()
                ->warning()
                ->title(__('geo::actions.update_coordinates.bulk.notifications.warning.title'))
                ->body($errorBody)
                ->persistent()
                ->send();
        }
    }

    /**
     * Elabora i record selezionati aggiornando le coordinate.
     *
     * @param Collection<int, Place> $records
     */
    private function processRecords(Collection $records): void
    {
        /** @var \Illuminate\Support\Collection<int, string> $errors */
        $errors = collect();
        $successCount = 0;
        $action = app(UpdateCoordinatesAction::class);

        foreach ($records as $record) {
            try {
                $action->execute($record);
                ++$successCount;
            } catch (\Throwable $e) {
                $errors->push(sprintf('Place #%s: %s', (string) $record->getKey(), $e->getMessage()));
            }
        }

        $this->sendNotifications()
            $successCount,
            $errors,
            $records->count()
        );
    }
}
