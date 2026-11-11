<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Carbon;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Notifications\EventReminderNotification;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * I-03: un promemoria a ogni iscritto degli eventi pubblicati che iniziano nelle prossime 24 ore.
 * Idempotente: `reminder_sent_at` evita doppioni anche se il comando gira ogni ora o viene rilanciato a mano.
 */
class SendEventRemindersAction
{
    use QueueableAction;

    /**
     * @return int promemoria inviati
     */
    public function execute(?Carbon $now = null): int
    {
        $now ??= Carbon::now();
        $sent = 0;

        $events = Event::query()
            ->published()
            ->whereBetween('start_date', [$now, $now->copy()->addDay()])
            ->with('venue')
            ->get();

        foreach ($events as $event) {
            $pending = EventUser::query()
                ->where('event_id', $event->getKey())
                ->where('status', 'attending')
                ->whereNull('reminder_sent_at')
                ->get();

            foreach ($pending as $registration) {
                $user = User::query()->find($registration->user_id);
                if ($user instanceof User) {
                    $appLocale = config('app.locale');
                    $locale = is_string($user->lang ?? null) && $user->lang !== '' ? $user->lang : (is_string($appLocale) ? $appLocale : 'it');
                    $user->notify(new EventReminderNotification($event, $locale));
                    $sent++;
                }

                // Anche senza utente (account cancellato): non riprovare a ogni giro.
                $registration->forceFill(['reminder_sent_at' => $now])->save();
            }
        }

        return $sent;
    }
}
