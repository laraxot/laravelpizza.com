<?php

declare(strict_types=1);

namespace Modules\Xot\States\Transitions;

use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\Notify\Datas\RecordNotificationData;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Contracts\UserContract;
use Spatie\ModelStates\Transition;
use Webmozart\Assert\InvalidArgumentException;

abstract class XotBaseTransition extends Transition
{
    public function __construct(
        public Model $record,
        public ?string $message = '',
    ) {
    }

    public function handle(): Model
    {
        $this->sendNotifications();
        $class = static::class;

        $stateNamespace = Str::of($class)->beforeLast('\Transitions\\')->toString();
        $stateClassName = Str::of($class)->afterLast('To')->toString();
        $newStateClass = $stateNamespace.'\\'.$stateClassName;

        /* @phpstan-ignore-next-line */
        $record->state = new $newStateClass($this->record);
        $record->save();

        return $record;
    }

    public function sendNotifications(): void
    {
        $data = $this->getNotificationData();
        $recipients = $this->getNotificationRecipients();
        foreach ($recipients as $recipient) {
            $this->sendRecipientNotification($recipient, $data);
        }
    }

    /**
     * @return array<string, RecordNotificationData>
     */
    public function getNotificationRecipients(): array
    {
        return [
            // 'me' => $record,
            'me_mail' => RecordNotificationData::from(['record' => $record, 'channel' => 'mail']
            // 'patient' => $record->patient,
            // 'doctor' => $record->doctor,
            // 'patient_mail' => RecordNotificationData::from(['record' => $record->patient, 'channel' => 'mail']),
            // 'doctor_mail' => RecordNotificationData::from(['record' => $record->doctor, 'channel' => 'mail']),
        ];
    }

    /**
     * Get notification attachments.
     *
     * @return array<int, array<string, string>>
     */
    public function getNotificationAttachments(): array
    {
        return [];
    }

    public function getNotificationSlug(UserContract $recipient): string
    {
        $typeEnum = $recipient->type;
        $type = $typeEnum instanceof \BackedEnum ? (string) $typeEnum->value : 'unknown';

        $slug =
            class_basename($record
            '-'.
            $type.
            '-'.
            Str::of(class_basename(static::class))->kebab()->toString();
        $slug = Str::slug($slug);

        return $slug;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function sendRecipientNotification(RecordNotificationData $recipient, array $data): void
    {
        $slug = $this->getNotificationSlug($recipient->record);

        if (! class_exists(RecordNotification::class)) {
            return;
        }

        // RecordNotification resolves MailTemplate internally from slug (lazy resolution)
        // No need to pre-load MailTemplate - pass slug directly
        $notify = new RecordNotification($record, $slug);
        $mergeData = $data;

        $notify->mergeData($mergeData);

        $attachments = $this->getNotificationAttachments();

        $notify->addAttachments($attachments);

        try {
            Notification::route($recipient->getChannel(), $recipient->getRoute())->notify($notify);
        } catch (\TypeError|InvalidArgumentException $e) {
            $message = 'channel :['.$recipient->getChannel().'] error: ['.$e->getMessage().']';
            FilamentNotification::make()
                ->title('Error')
                ->danger()
                ->body($message)
                ->send();
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function getNotificationData(): array
    {
        return [
            'message' => $message,
            // 'appointment_date' => $appointment->starts_at?->format('d/m/Y H:i'
            // 'patient_name' => $appointment->patient->name ?? 'N/A',
            // 'doctor_name' => $appointment->doctor->name ?? 'N/A',
        ];
    }
}
