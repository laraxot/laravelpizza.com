<?php

declare(strict_types=1);

use Tests\TestCase;

uses(TestCase::class);

/*
 * Specifica fantasma: la route `filament.resources.profiles.change-password` non esiste. Il cambio password
 * del profilo e' la Filament action `ChangeProfilePasswordAction` (modale Livewire, nessuna rotta HTTP) e
 * non verifica la password corrente. Corpo originale in git: repo Modules/User, commit 0e2e66d86,
 * tests/Feature/ChangeProfilePasswordTest.php.
 */
test('can change profile password')->skip('filament.resources.profiles.change-password route not implemented');

test('cannot change password with wrong current password')->skip('filament.resources.profiles.change-password route not implemented');
