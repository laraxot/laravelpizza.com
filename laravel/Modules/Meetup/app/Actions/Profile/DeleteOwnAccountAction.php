<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Gdpr\Actions\Account\DeleteAccountAction;
use Modules\Meetup\Actions\Event\UnregisterAttendeeFromEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Il partecipante elimina il proprio account dalla pagina "Modifica il profilo" (GDPR art. 17).
 *
 * 1. Libera i posti degli eventi futuri a cui era iscritto (gli organizzatori non contano più su di lui).
 * 2. Gdpr DeleteAccountAction: revoca dei consensi, registrazione della richiesta, deleted_at, logout.
 * 3. Cancella i dati personali, come promette l'informativa ("dopo la cancellazione vengono eliminati"):
 *    nome, email, foto, biografia, indirizzo. Resta un utente anonimo, così le iscrizioni passate (storico degli
 *    eventi) e il registro dei consensi restano coerenti senza contenere più chi era.
 */
final class DeleteOwnAccountAction
{
    use QueueableAction;

    public function __construct(
        private readonly UnregisterAttendeeFromEventAction $unregister,
        private readonly DeleteAccountAction $deleteAccount,
        private readonly ResolveOwnProfileAction $resolveProfile,
    ) {}

    public function execute(User $user, string $reason = ''): void
    {
        $userId = $user->id;

        $upcomingEventIds = EventUser::query()
            ->where('user_id', $userId)
            ->pluck('event_id')
            ->all();
        Event::query()
            ->whereIn('id', $upcomingEventIds)
            ->where('start_date', '>', now())
            ->get()
            ->each(fn (Event $event): bool => $this->unregister->execute($event, $userId));

        $profile = $this->resolveProfile->execute($user);

        $this->deleteAccount->execute($user, $reason);

        $profile->clearMediaCollection(UpdateOwnAvatarAction::COLLECTION);
        $profile->forceFill([
            'first_name' => null,
            'last_name' => null,
            'email' => null,
            'bio' => null,
            'address' => null,
            'phone' => null,
        ])->save();

        $user->forceFill([
            'name' => (string) __('meetup::profile_edit.delete.anonymous_name'),
            'first_name' => null,
            'last_name' => null,
            'email' => 'deleted-'.$userId.'@invalid.invalid',
            'password' => Hash::make(Str::random(64)),
            'remember_token' => null,
        ])->save();
    }
}
