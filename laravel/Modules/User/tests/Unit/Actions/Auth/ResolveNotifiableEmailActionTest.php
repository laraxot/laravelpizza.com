<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\User\Actions\Auth\ResolveNotifiableEmailAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Destinatario delle email di reset password e di verifica, usato da UserServiceProvider.
 */

test('usa getEmailForPasswordReset quando il modello la espone', function (): void {
    $notifiable = new class extends Model
    {
        public function getEmailForPasswordReset(): string
        {
            return 'reset@example.test';
        }
    };
    $notifiable->forceFill([
        'email' => 'altro@example.test',
    ]);

    Assert::assertSame('reset@example.test', app(ResolveNotifiableEmailAction::class)->execute($notifiable));
});

test('altrimenti usa l attributo email', function (): void {
    $notifiable = new class extends Model {};
    $notifiable->forceFill([
        'email' => 'utente@example.test',
    ]);

    Assert::assertSame('utente@example.test', app(ResolveNotifiableEmailAction::class)->execute($notifiable));
});

test('restituisce null se il modello non ha un indirizzo', function (): void {
    $notifiable = new class extends Model {};

    Assert::assertNull(app(ResolveNotifiableEmailAction::class)->execute($notifiable));
});

test('rifiuta un indirizzo che non e una stringa', function (): void {
    $notifiable = new class extends Model {};
    $notifiable->forceFill([
        'email' => 123,
    ]);

    expect(fn () => app(ResolveNotifiableEmailAction::class)->execute($notifiable))
        ->toThrow(InvalidArgumentException::class, 'Email address must be a string.');
});
