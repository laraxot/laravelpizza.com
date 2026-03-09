<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Register a user to an event with simultaneous GDPR consent recording.
 *
 * Business rules:
 * - privacy_accepted and terms_accepted are mandatory (throws DomainException)
 * - Delegates capacity + duplicate checks to RegisterAttendeeToEventAction
 * - Wraps the whole operation in a transaction
 */
class RegisterWithGdprAction
{
    use QueueableAction;

    /**
     * @param array<string, bool> $consents  e.g. ['privacy_accepted'=>true,'terms_accepted'=>true,'marketing_consent'=>false]
     */
    public function execute(Event $event, User $user, array $consents, ?string $ipAddress = null, ?string $userAgent = null): EventUser
    {
        if (empty($consents['privacy_accepted']) || empty($consents['terms_accepted'])) {
            throw new \DomainException('Privacy policy and terms of service must be accepted to register.');
        }

        return app('db')->transaction(function () use ($event, $user, $consents, $ipAddress, $userAgent): EventUser {
            $registration = app(RegisterAttendeeToEventAction::class)->execute($event, (string) $user->id);

            app(SaveGdprConsentsAction::class)->execute($user, $consents, $ipAddress, $userAgent);

            return $registration;
        });
    }
}
