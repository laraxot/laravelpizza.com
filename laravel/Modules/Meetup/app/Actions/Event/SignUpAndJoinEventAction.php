<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Gdpr\Actions\Consent\CollectGdprConsentsAction;
use Modules\Gdpr\Actions\SaveGdprConsentsAction;
use Modules\Meetup\Models\Event;
use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Iscrizione a un evento con solo email e password, dalla pagina dell'evento (PRD FR-9, "minimo attrito").
 *
 * - Email nuova: crea l'account (consensi privacy e termini obbligatori, salvati come prova GDPR) e iscrive all'evento.
 * - Email già registrata con la password giusta: iscrive l'account esistente.
 * - Email già registrata con un'altra password: DomainException 'email_taken' (il form chiede di accedere).
 *
 * Capienza e iscrizione doppia sono controllate PRIMA di creare l'account (FR-11: errore prima del salvataggio);
 * l'iscrizione vera resta in JoinEventAction, che ripete i controlli sotto lock e invia la conferma (FR-10).
 * Chi chiama fa il login e manda la mail di verifica: qui niente sessione, così l'Action si testa da sola.
 */
class SignUpAndJoinEventAction
{
    use QueueableAction;

    public function __construct(
        private readonly JoinEventAction $joinEvent,
    ) {}

    /**
     * @return array{user: User, created: bool}
     */
    public function execute(
        Event $event,
        string $email,
        string $password,
        bool $consentsAccepted,
        string $locale,
        ?string $ipAddress = null,
        ?string $userAgent = null,
    ): array {
        $email = mb_strtolower(trim($email));

        $existing = User::query()->where('email', $email)->first();
        if ($existing instanceof User) {
            $hash = $existing->getAttribute('password');
            if (! is_string($hash) || $hash === '' || ! Hash::check($password, $hash)) {
                throw new \DomainException('email_taken');
            }
            if ($event->isUserRegistered($existing->id)) {
                throw new \DomainException('User already registered for this event');
            }
        }

        if ($event->isFull()) {
            throw new \DomainException('Event is full');
        }

        $created = false;
        $user = $existing;
        if (! $user instanceof User) {
            if (! $consentsAccepted) {
                throw new \DomainException('consents_required');
            }
            $user = $this->createUser($email, $password, $locale, $ipAddress, $userAgent);
            $created = true;
        }

        $this->joinEvent->execute($event, $user, $locale);

        return ['user' => $user, 'created' => $created];
    }

    private function createUser(string $email, string $password, string $locale, ?string $ipAddress, ?string $userAgent): User
    {
        // Privacy e termini in una sola casella (il testo li nomina entrambi); il marketing non si chiede qui.
        $consents = app(CollectGdprConsentsAction::class)->execute(true, true, false);

        return DB::connection('user')->transaction(function () use ($email, $password, $locale, $consents, $ipAddress, $userAgent): User {
            // Stessi attributi della registrazione del sito (ValidateUserDataAction): il nome mostrato lo ricava
            // CreateUserAction dalla parte prima della @; si può cambiare dopo in "Modifica profilo".
            $user = app(CreateUserAction::class)->execute([
                'email' => $email,
                'password' => Hash::make($password),
                'type' => 'customer_user',
                'lang' => $locale,
                'email_verified_at' => null,
            ]);
            app(SaveGdprConsentsAction::class)->execute($user, $consents, $ipAddress, $userAgent);
            app(LogRegistrationAction::class)->execute($user, ['gdpr_consents' => $consents, 'source' => 'event_page']);

            return $user;
        });
    }
}
