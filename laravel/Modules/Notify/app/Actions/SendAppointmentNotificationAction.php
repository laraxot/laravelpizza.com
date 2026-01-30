<?php

declare(strict_types=1);

// This file references SaluteOra models that do not exist in this project

namespace Modules\Notify\Actions;

use Exception;
use Illuminate\Support\Facades\Log;
// use Modules\SaluteOra\Models\Appointment;
// use Modules\SaluteOra\Models\Patient;
use Spatie\QueueableAction\QueueableAction;

class SendAppointmentNotificationAction
{
    use QueueableAction;

    /**
     * Numero massimo di tentativi per l'invio della notifica.
     */
    public int $tries = 3;

    /**
     * Invia una notifica relativa a un appuntamento.
     *
     * @param  mixed  $appointment  L'appuntamento a cui si riferisce la notifica
     * @param  string  $type  Il tipo di notifica (confermato, annullato, promemoria, ecc.)
     * @param  array<string, mixed>  $additionalData  Dati aggiuntivi per la notifica
     */
    public function execute(
        mixed $appointment,
        string $type,
        array $additionalData = []
    ): bool {
        try {
            // Carica il paziente con le relazioni necessarie
            $patient = null; // Patient::with('user')->find($appointment->patient_id);

            // Since patient models are not available in this project,
            // we return early with logging
            Log::info('Notification service not fully implemented - missing Patient models', [
                'type' => $type,
                'additional_data' => $additionalData,
            ]);

            return false;

        } catch (Exception $e) {
            Log::error('Errore nell\'invio della notifica di appuntamento', [
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }

}
