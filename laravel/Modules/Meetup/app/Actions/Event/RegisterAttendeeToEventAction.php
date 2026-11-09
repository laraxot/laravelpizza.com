<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Carbon;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Spatie\QueueableAction\QueueableAction;

/**
 * Iscrive un utente a un evento rispettando gli invarianti di dominio (PRD FR-9, FR-11).
 *
 * - La transazione usa la connessione del modello (`meetup`), non quella di default:
 *   con una connessione diversa la transazione non proteggerebbe le scritture.
 * - L'evento viene riletto con `lockForUpdate()` dentro la transazione, così due
 *   iscrizioni concorrenti non possono superare la capienza leggendo un contatore stantio.
 * - Solo eventi pubblicati e non ancora iniziati accettano iscrizioni.
 */
class RegisterAttendeeToEventAction
{
    use QueueableAction;

    public function execute(Event $event, string $userId): EventUser
    {
        /** @var EventUser $registration */
        $registration = $event->getConnection()->transaction(function () use ($event, $userId): EventUser {
            /** @var Event $locked */
            $locked = Event::query()
                ->whereKey($event->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status !== 'published') {
                throw new \DomainException('Event is not open for registration');
            }

            $startDate = $locked->start_date;
            if ($startDate instanceof Carbon && $startDate->isPast()) {
                throw new \DomainException('Event has already started');
            }

            if ($locked->isFull()) {
                throw new \DomainException('Event is full');
            }

            if ($locked->isUserRegistered($userId)) {
                throw new \DomainException('User already registered for this event');
            }

            $registration = EventUser::query()->create([
                'event_id' => (int) $locked->getKey(),
                'user_id' => $userId,
            ]);

            $locked->increment('attendees_count');

            return $registration;
        });

        $event->refresh();

        return $registration;
    }
}
