<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Channels;

use Exception;
use Illuminate\Notifications\Notification;
use Modules\Notify\Channels\SmsChannel;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use stdClass;

uses(TestCase::class);
/**
 * Story quaeris-send-invite-migrate-to-record-notification.md, Difetto 17
 * (2026-09-15): `toSms()` e' tipizzato `?SmsData` proprio per poter dire
 * "niente da inviare" (nessun destinatario, o corpo vuoto) senza che sia un
 * errore di programmazione — refactoring Zen Delegation, dicembre 2025
 * (`docs/refactoring/record-notification-zen-delegation.md`). Ma
 * `SmsChannel::send()` non onorava mai quel contratto: qualunque valore
 * diverso da un'istanza di `SmsData`, `null` incluso, faceva lanciare
 * un'eccezione invece di saltare in modo pulito.
 *
 * `SmsChannelTest.php` (esistente) copre solo la struttura della classe via
 * reflection, non chiama mai `send()` per davvero — questo file lo fa,
 * restando comunque sicuro: in entrambi gli scenari sotto, `send()`
 * ritorna/lancia PRIMA di toccare `SmsActionFactory`/il driver reale (letto
 * nel sorgente: la chiamata al factory e' l'ultima istruzione del metodo,
 * dopo i due controlli qui testati).
 */
/**
 * `mixed` voluto: lo stub viola di proposito il contratto `toSms(): ?SmsData`
 * per testare i rami di errore di SmsChannel::send() (null, stringa, ecc.).
 */
function notificationStubReturningFromToSms(mixed $toSmsResult): Notification
{
    return new class($toSmsResult) extends Notification
    {
        public function __construct(private readonly mixed $toSmsResult) {}

        public function toSms(object $notifiable): mixed
        {
            return $this->toSmsResult;
        }
    };
}

it('returns null without throwing when toSms() returns null (Difetto 17)', function (): void {
    $channel = app(SmsChannel::class);
    $notification = notificationStubReturningFromToSms(null);

    $result = $channel->send(new stdClass, $notification);

    Assert::assertNull($result);
});

it('still throws when toSms() returns something that is neither SmsData nor null', function (): void {
    $channel = app(SmsChannel::class);
    $notification = notificationStubReturningFromToSms('not-sms-data');

    expect(fn () => $channel->send(new stdClass, $notification))
        ->toThrow(Exception::class, 'toSms method must return an instance of SmsData');
});

it('still throws when the notification has no toSms method at all', function (): void {
    $channel = app(SmsChannel::class);
    $notification = new class extends Notification {};

    expect(fn () => $channel->send(new stdClass, $notification))
        ->toThrow(Exception::class, 'Notification does not have toSms method');
});