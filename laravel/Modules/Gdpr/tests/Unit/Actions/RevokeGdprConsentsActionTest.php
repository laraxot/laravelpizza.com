<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\Gdpr\Actions\Consent\RevokeGdprConsentsAction;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

/**
 * DCP-285 (D-02): l'azione filtrava su `subject_type` e scriveva `revoked_user_agent`, colonne che non esistono nella tabella
 * `consents` (migrazioni 000001, 000002, 000005, 000006): ogni esecuzione dava un errore SQL. Si prova sullo schema reale del DB
 * di prova. Non si crea nessuna colonna: lo user agent della revoca e' una richiesta di schema (vedi la story).
 *
 * Classe PHPUnit e non closure Pest: il modulo lega il TestCase in `tests/Pest.php`, che una esecuzione per singolo file non carica.
 */
final class RevokeGdprConsentsActionTest extends TestCase
{
    public function test_revokes_every_active_consent_of_the_user_whichever_way_it_was_written(): void
    {
        $this->app?->instance('request', Request::create('/', 'POST', server: ['REMOTE_ADDR' => '203.0.113.7', 'HTTP_USER_AGENT' => 'Pest/DCP-285']));
        $user = UserFactory::new()->createOne();
        $other = UserFactory::new()->createOne();

        // Come SaveGdprConsentsAction: user_id + user_type (classe) + subject_id.
        $fromRegistration = $this->consentOf($user, 'privacy_policy');
        // Come HasGdpr::giveConsent(): solo la relazione morph, senza subject_id e con l'alias morph come user_type.
        $fromTrait = $this->consentOf($user, 'marketing_consent', ['subject_id' => null, 'user_type' => $user->getMorphClass()]);
        $ofOther = $this->consentOf($other, 'privacy_policy');
        $alreadyRevoked = $this->consentOf($user, 'terms_conditions', ['revoked_at' => '2026-01-02 03:04:05', 'revoked_ip_address' => '198.51.100.9']);

        app(RevokeGdprConsentsAction::class)->execute($user);

        foreach ([$fromRegistration, $fromTrait] as $consent) {
            $fresh = $consent->fresh();
            Assert::assertNotNull($fresh, 'consenso sparito');
            Assert::assertInstanceOf(Carbon::class, $fresh->getAttribute('revoked_at'), "revoked_at mancante per {$fresh->type}");
            Assert::assertSame('203.0.113.7', $fresh->getAttribute('revoked_ip_address'));
        }

        $untouched = $ofOther->fresh();
        Assert::assertNotNull($untouched);
        Assert::assertNull($untouched->getAttribute('revoked_at'), 'consenso di un altro utente revocato');

        $before = $alreadyRevoked->fresh();
        Assert::assertNotNull($before);
        $revokedAt = $before->getAttribute('revoked_at');
        Assert::assertInstanceOf(Carbon::class, $revokedAt);
        Assert::assertSame('2026-01-02 03:04:05', $revokedAt->format('Y-m-d H:i:s'));
        Assert::assertSame('198.51.100.9', $before->getAttribute('revoked_ip_address'));
    }

    public function test_keeps_the_revoked_consents_as_audit_trail_instead_of_deleting_them(): void
    {
        $user = UserFactory::new()->createOne();
        $consent = $this->consentOf($user, 'privacy_policy');

        app(RevokeGdprConsentsAction::class)->execute($user);

        Assert::assertNotNull(Consent::query()->whereKey($consent->getKey())->first());
        Assert::assertNull(Consent::query()->whereKey($consent->getKey())->value('deleted_at'));
    }

    public function test_does_nothing_and_does_not_fail_for_a_user_without_consents(): void
    {
        $user = UserFactory::new()->createOne();

        app(RevokeGdprConsentsAction::class)->execute($user);

        Assert::assertSame(0, Consent::query()->where('user_id', (string) $user->id)->count());
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function consentOf(User $user, string $type, array $attributes = []): Consent
    {
        return Consent::query()->forceCreate(array_merge([
            'user_id' => (string) $user->id,
            'user_type' => $user::class,
            'subject_id' => (string) $user->id,
            'type' => $type,
            'accepted_at' => now(),
        ], $attributes));
    }
}
