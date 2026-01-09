<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\SaluteOra\Models\Appointment;
use Modules\Notify\Mail\AppointmentNotificationMail;
use Modules\SaluteOra\Models\Patient;
use Spatie\QueueableAction\QueueableAction;

class SendAppointmentNotificationAction
{
    use QueueableAction;

    /**
     * Numero massimo di tentativi per l'invio della notifica.
     *
     * @var int
     */
    public int $tries = 3;

    /**
     * Invia una notifica relativa a un appuntamento.
     *
     * @param Appointment $appointment L'appuntamento a cui si riferisce la notifica
     * @param string $type Il tipo di notifica (confermato, annullato, promemoria, ecc.)
     * @param array<string, mixed> $additionalData Dati aggiuntivi per la notifica
     * 
     * @return bool
     */
    public function execute(
        Appointment $appointment,
        string $type,
        array $additionalData = []
    ): bool {
        try {
            // Carica il paziente con le relazioni necessarie
            $patient = Patient::with('user')->find($appointment->patient_id);
            
            if (!$patient) {
                Log::error('Paziente non trovato per l\'invio della notifica di appuntamento', [
                    'appointment_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                ]);
                return false;
            }
            
            // Prepara i dati per la notifica
            $notificationData = [
                'appointment' => $appointment,
                'patient' => $patient,
                'type' => $type,
                'additionalData' => $additionalData,
            ];
            
            // Invia email se disponibile
            if ($patient->user && $patient->user->email) {
                Mail::to($patient->user->email)
                    ->send(new AppointmentNotificationMail($notificationData));
            }
            
            // Registra la notifica nel database
            $this->recordNotification($appointment, $patient, $type);
            
            // Logga l'invio della notifica
            activity()
                ->performedOn($appointment)
                ->withProperties([
                    'action' => 'send_notification',
                    'notification_type' => $type,
                    'patient_id' => $patient->id,
                ])
                ->log("Notifica di appuntamento di tipo '{$type}' inviata");
            
            return true;
        } catch (\Exception $e) {
            Log::error('Errore nell\'invio della notifica di appuntamento', [
                'appointment_id' => $appointment->id,
                'type' => $type,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return false;
        }
    }
    
    /**
     * Registra la notifica nel database.
     *
     * @param Appointment $appointment
     * @param Patient $patient
     * @param string $type
     */
    private function recordNotification(
        Appointment $appointment,
        Patient $patient,
        string $type
    ): void {
        // Se esiste un modello Notification, lo utilizziamo per registrare la notifica
        if (class_exists('\Modules\Notify\Models\Notification')) {
            $notification = new \Modules\Notify\Models\Notification();
            $notification->tenant_id = $appointment->tenant_id;
            $notification->user_id = $patient->user?->id;
            $notification->subject_type = Appointment::class;
            $notification->subject_id = $appointment->id;
            $notification->type = $type;
            $notification->channels = ['email', 'database'];
            $notification->status = 'sent';
            $notification->data = [
                'appointment_id' => $appointment->id,
                'patient_id' => $patient->id,
                'date' => $appointment->date->format('Y-m-d'),
                'time' => $appointment->start_time?->format('H:i'),
            ];
            $notification->sent_at = now();
            $notification->save();
        }
    }
}
