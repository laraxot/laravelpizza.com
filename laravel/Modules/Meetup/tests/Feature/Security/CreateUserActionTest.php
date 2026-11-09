<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\Security;

use Modules\Meetup\Tests\TestCase;
use Modules\User\Actions\User\CreateUserAction;

uses(TestCase::class);

/*
 * La registrazione pubblica raccoglie nome e cognome ma non "name" (colonna NOT NULL):
 * prima di questa correzione ogni nuova registrazione andava in errore 500.
 */

test('a user created from first and last name gets a full name', function (): void {
    $user = app(CreateUserAction::class)->execute([
        'first_name' => 'Luca',
        'last_name' => 'Bianchi',
        'email' => 'luca-'.uniqid().'@example.test',
        'password' => 'secret-password',
    ]);

    expect($user->name)->toBe('Luca Bianchi');

    // Pulizia senza eventi del modello: forceDelete() tocca tabelle di permessi assenti nel DB di test.
    \Modules\User\Models\User::query()->whereKey($user->getKey())->toBase()->delete();
});

test('an explicit name is kept as is', function (): void {
    $user = app(CreateUserAction::class)->execute([
        'name' => 'Nickname',
        'first_name' => 'Luca',
        'last_name' => 'Bianchi',
        'email' => 'nick-'.uniqid().'@example.test',
        'password' => 'secret-password',
    ]);

    expect($user->name)->toBe('Nickname');

    // Pulizia senza eventi del modello: forceDelete() tocca tabelle di permessi assenti nel DB di test.
    \Modules\User\Models\User::query()->whereKey($user->getKey())->toBase()->delete();
});
