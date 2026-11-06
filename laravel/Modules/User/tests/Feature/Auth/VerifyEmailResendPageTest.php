<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

/*
 * DCP-285 (D-04): `resend()` della pagina `pages/auth/verify.blade.php` (Folio, raggiungibile da un utente autenticato) aveva due difetti.
 * `redirect('/')` senza `return`: per un indirizzo gia' verificato l'esecuzione proseguiva e rimandava comunque la notifica.
 * `event(new Verified)` dopo un semplice reinvio: l'evento dice che l'indirizzo e' stato verificato, e qui non lo e'.
 * Nessuna nuova rotta: la rotta `verification.verify` e il flusso di verifica sono DEC-11 del titolare.
 */

it('only redirects an already verified user and sends nothing', function (): void {
    Notification::fake();
    Event::fake([Verified::class]);
    $user = UserFactory::new()->createOne(['email_verified_at' => now()]);

    Volt::actingAs($user)->test('auth.verify')->call('resend')->assertRedirect('/');

    Notification::assertNothingSent();
    Event::assertNotDispatched(Verified::class);
});

it('sends one verification notification to an unverified user without announcing a verification', function (): void {
    Notification::fake();
    Event::fake([Verified::class]);
    $user = UserFactory::new()->createOne(['email_verified_at' => null]);

    Volt::actingAs($user)->test('auth.verify')->call('resend')->assertDispatched('resent');

    Notification::assertSentToTimes($user, VerifyEmail::class, 1);
    Event::assertNotDispatched(Verified::class);
});
