<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Notifications\EventRegistrationConfirmedNotification;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Journey UJ-2: un utente autenticato si iscrive a un evento e riceve la conferma via email.
 *
 * Gli invarianti (pubblicato, non iniziato, capienza, duplicati) restano in
 * RegisterAttendeeToEventAction; qui si aggiunge solo la notifica (PRD FR-10).
 */
class JoinEventAction
{
    use QueueableAction;

    public function __construct(
        private readonly RegisterAttendeeToEventAction $registerAttendee,
    ) {}

    public function execute(Event $event, User $user, ?string $locale = null): EventUser
    {
        $registration = $this->registerAttendee->execute($event, (string) $user->getKey());

        $user->notify(new EventRegistrationConfirmedNotification(
            $event,
            $locale ?? LaravelLocalization::getCurrentLocale(),
        ));

        return $registration;
    }
}
