<?php

declare(strict_types=1);

namespace Modules\Notify\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// use Modules\SaluteOra\Models\Appointment;

class AppointmentNotificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Dati della notifica dell'appuntamento.
     *
     * @var array<string, mixed>
     */
    public array $notificationData;

    /**
     * Crea una nuova istanza del messaggio.
     *
     * @param  array<string, mixed>  $notificationData
     */
    public function __construct(array $notificationData)
    {
        // @var mixed notificationData = $notificationData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $appointment = // @var mixed notificationData['appointment'];
        $type = // @var mixed notificationData['type'];

        $subject = match ($type) {
            'confirmed' => 'Conferma Appuntamento',
            'reminder' => 'Promemoria Appuntamento',
            'cancelled' => 'Cancellazione Appuntamento',
            'rescheduled' => 'Modifica Appuntamento',
            default => 'Notifica Appuntamento',
        };

        $appointmentId = is_object($appointment) && isset($appointment->id) ? $appointment->id : null;
        if ($appointmentId !== null && $appointmentId !== '') {
            $subject .= ' #'.(string) $appointmentId;
        }

        return new Envelope(
            subject: $subject,
            tags: ['appointment', $type],
            metadata: [
                'appointment_id' => is_object($appointment) && isset($appointment->id) ? $appointment->id : null,
                'type' => $type,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $type = // @var mixed notificationData['type'];

        // Determina il template da utilizzare in base al tipo di notifica
        $view = match ($type) {
            'confirmed' => 'notify::emails.appointments.confirmed',
            'reminder' => 'notify::emails.appointments.reminder',
            'cancelled' => 'notify::emails.appointments.cancelled',
            'rescheduled' => 'notify::emails.appointments.rescheduled',
            default => 'notify::emails.appointments.generic',
        };

        return new Content(
            view: $view,
            with: [
                'appointment' => // @var mixed notificationData['appointment'],
                'patient' => // @var mixed notificationData['patient'],
                'type' => $type,
                'additionalData' => // @var mixed notificationData['additionalData'] ?? [],
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
