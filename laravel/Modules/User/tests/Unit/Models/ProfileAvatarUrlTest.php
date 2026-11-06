<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Modules\User\Models\Profile;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-user-db');

/*
 * L'header del tema mostra `getAvatarUrl()` a ogni utente connesso, in ogni pagina. Senza email non c'e' nulla da
 * cifrare: l'hash della stringa vuota e' uguale per tutti e farebbe partire una richiesta a gravatar.com per
 * niente (CMT-022: senza email si vedono le iniziali).
 */
function profileAvatarUrl(?string $email): string
{
    $profile = new Profile;
    $profile->setAttribute('email', $email);

    return $profile->getAvatarUrl();
}

it('asks Gravatar for the picture only when the profile has an email', function (): void {
    $url = profileAvatarUrl('Mario.Rossi@Example.test');

    Assert::assertStringStartsWith('https://gravatar.com/avatar/'.hash('sha256', 'mario.rossi@example.test'), $url);
});

it('leaves the avatar empty so the page shows the initial when there is no email', function (?string $email): void {
    Assert::assertSame('', profileAvatarUrl($email));
})->with([
    'null' => [null],
    'empty' => [''],
    'spaces only' => ['   '],
]);
