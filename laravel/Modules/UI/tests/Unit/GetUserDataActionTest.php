<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Modules\UI\Actions\GetUserDataAction;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

uses(TestCase::class);

/**
 * Utente in memoria, con le relazioni Spatie già impostate.
 *
 * `getRoleNames()` e `getAllPermissions()` leggono le relazioni `roles` e `permissions`:
 * pre-impostandole con `setRelation()` l'azione percorre gli stessi rami senza aprire una
 * connessione. Non è una scorciatoia — è il modo di provare la logica dell'azione invece
 * della disponibilità del database.
 *
 * @param  array<int, string>  $roles
 * @param  array<int, string>  $permissions
 * @param  array<string, mixed>  $attributes
 */
function uiAuthUser(array $roles = [], array $permissions = [], array $attributes = []): Authenticatable
{
    $user = new class extends User
    {
        public ?object $profile = null;

        public function relationLoaded(mixed $key): bool
        {
            if (! is_string($key)) {
                return false;
            }

            return $key === 'profile' && $this->profile !== null;
        }
    };
    $user->forceFill(array_merge([
        'id' => 42,
        'name' => 'Mario Rossi',
        'email' => 'mario.rossi@example.test',
    ], $attributes));

    $user->setRelation('roles', collect(array_map(
        static fn (string $name): Role => tap(new Role)->forceFill(['name' => $name]),
        $roles,
    )));

    $user->setRelation('permissions', collect(array_map(
        static fn (string $name): Permission => tap(new Permission)->forceFill(['name' => $name]),
        $permissions,
    )));

    return $user;
}

afterEach(function (): void {
    Auth::forgetGuards();
});

it('restituisce null quando nessuno è autenticato', function (): void {
    Assert::assertNull(app(GetUserDataAction::class)->execute());
});

it('restituisce null quando l autenticato non è un User del modulo', function (): void {
    // Un Authenticatable qualsiasi non basta: l'azione richiede il modello del dominio.
    Auth::setUser(new GenericUser(['id' => 1, 'name' => 'Estraneo']));

    Assert::assertNull(app(GetUserDataAction::class)->execute());
});

it('mappa identità, nome e email dell utente autenticato', function (): void {
    Auth::setUser(uiAuthUser());

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertSame(42, $data->id);
    Assert::assertSame('Mario Rossi', $data->name);
    Assert::assertSame('mario.rossi@example.test', $data->email);
});

it('usa profile_photo_path come avatar quando è presente', function (): void {
    Auth::setUser(uiAuthUser(attributes: ['profile_photo_path' => 'avatars/mario.jpg']));

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertSame('avatars/mario.jpg', $data->avatar);
});

it('lascia l avatar nullo quando non c è né foto né profilo caricato', function (): void {
    Auth::setUser(uiAuthUser());

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertNull($data->avatar);
});

it('prende il primo ruolo, non tutti', function (): void {
    Auth::setUser(uiAuthUser(roles: ['hr-manager', 'evaluator']));

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertSame('hr-manager', $data->role);
});

it('lascia il ruolo nullo quando l utente non ne ha', function (): void {
    Auth::setUser(uiAuthUser());

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertNull($data->role);
});

it('elenca i permessi per nome', function (): void {
    Auth::setUser(uiAuthUser(permissions: ['schede.view', 'schede.update']));

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertContains('schede.view', $data->permissions);
    Assert::assertContains('schede.update', $data->permissions);
});

it('restituisce impostazioni vuote quando il profilo non è caricato', function (): void {
    Auth::setUser(uiAuthUser());

    $data = app(GetUserDataAction::class)->execute();

    Assert::assertNotNull($data);
    Assert::assertSame([], $data->settings);
});
