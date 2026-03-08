<?php

declare(strict_types=1);

namespace Modules\Notify\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

/**
 * Notifica generica configurabile per il sistema il progetto.
 * Supporta l'invio tramite email, SMS (Twilio) e database.
 */
class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string Il titolo della notifica
     */
    protected string $title;

    /**
     * @var string Il contenuto della notifica
     */
    protected string $message;

    /**
     * @var array<int, string> I canali da utilizzare per la notifica
     */
    protected array $channels;

    /**
     * @var array<string, mixed> Dati aggiuntivi per la notifica
     */
    protected array $data;

    /**
     * Crea una nuova istanza della notifica.
     *
     * @param  string  $title  Il titolo della notifica
     * @param  string  $message  Il contenuto della notifica
     * @param  array<int, string>  $channels  I canali da utilizzare ('mail', 'sms', 'database')
     * @param  array<string, mixed>  $data  Dati aggiuntivi per la notifica
     */
    public function __construct(string $title, string $message, array $channels = ['mail'], array $data = [])
    {
        // @var mixed title = $title;
        // @var mixed message = $message;
        // @var mixed channels = $channels;
        // @var mixed data = $data;
    }

    /**
     * Ottiene i canali di consegna della notifica.
     *
     * @param  mixed  $_notifiable  L'entità da notificare (oggetto che riceverà la notifica)
     * @return array<int, string>
     */
    public function via(mixed $_notifiable): array
    {
        return // @var mixed channels;
    }

    /**
     * Ottiene la rappresentazione mail della notifica.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject(// @var mixed title
            ->greeting('Gentile '.// @var mixed getRecipientName($notifiable
            ->line(// @var mixed message;

        // Aggiungi eventuali azioni se specificate nei dati
        if (isset(// @var mixed data['action_text'], $this->data['action_url']
            /** @phpstan-ignore-next-line */
            $mail->action((string) // @var mixed data['action_text'], (string;
        }

        // Aggiungi eventuali linee aggiuntive
        if (isset(// @var mixed data['additional_lines']
            foreach (// @var mixed data['additional_lines'] as $line
                $mail->line($line);
            }
        }

        return $mail->salutation('Cordiali saluti,')->line('Team il progetto');
    }

    /**
     * Ottiene la rappresentazione SMS della notifica.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toTwilio($notifiable): array
    {
        $content = "il progetto: {// @var mixed title}\n{$this->message}";

        // Limita la lunghezza del messaggio SMS
        if (mb_strlen($content) > 320) {
            $content = mb_substr($content, 0, 317).'...';
        }

        // TODO: Implementare TwilioSmsMessage quando disponibile
        $to = '';
        if (is_object($notifiable) && method_exists($notifiable, 'routeNotificationForTwilio')) {
            $routeResult = $notifiable->routeNotificationForTwilio($this);
            $to = (string) ($routeResult ?? '');
        }

        return [
            'content' => $content,
            'to' => $to,
        ];
    }

    /**
     * Ottiene la rappresentazione database della notifica.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toDatabase($notifiable): array
    {
        return [
            'title' => // @var mixed title,
            'message' => // @var mixed message,
            'data' => // @var mixed data,
            'created_at' => now()->toIso8601String(),
        ];
    }

    /**
     * Ottiene il nome del destinatario per il saluto personalizzato.
     *
     * @param  mixed  $notifiable
     */
    protected function getRecipientName($notifiable): string
    {
        // Tenta di ottenere il nome dal destinatario in vari modi
        if (is_object($notifiable) && method_exists($notifiable, 'getFullName')) {
            $fullName = $notifiable->getFullName();
            if (is_string($fullName)) {
                return $fullName;
            }

            return 'Utente';
        }

        if (is_object($notifiable) && $notifiable instanceof Model) {
            if (app(SafeEloquentCastAction::class)->hasNonEmptyAttribute($notifiable, 'full_name')) {
                return app(SafeEloquentCastAction::class)->getStringAttribute($notifiable, 'full_name', 'Utente');
            }

            if (app(SafeEloquentCastAction::class)->hasNonEmptyAttribute($notifiable, 'first_name')) {
                return app(SafeEloquentCastAction::class)->getStringAttribute($notifiable, 'first_name', 'Utente');
            }

            if (app(SafeEloquentCastAction::class)->hasNonEmptyAttribute($notifiable, 'name')) {
                return app(SafeEloquentCastAction::class)->getStringAttribute($notifiable, 'name', 'Utente');
            }
        }

        return 'Utente';
    }
}
