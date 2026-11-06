<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Policies\UserPolicy;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * DCP-285 (D-06): `UserPolicy` rispondeva `true` a view, create, update e delete a qualunque utente autenticato. Matrice ruolo x abilita' x
 * (se stesso / altro) con utenti e ruoli reali sul DB di prova, passando dal Gate come fanno Filament e DeleteAccountAction.
 */

/**
 * Ruoli che amministrano gli utenti: tutti e soli quelli gia' definiti dal progetto (super-admin passa da before() della policy).
 */
const DCP285_ADMIN_ROLES = ['super-admin', 'admin', 'user::admin'];

/**
 * Ruoli che esistono nel progetto ma non amministrano gli utenti. `null` = cittadino senza ruoli.
 */
const DCP285_NON_ADMIN_ROLES = [null, 'user', 'operator', 'moderator', 'fixcity::admin'];

/**
 * @param  class-string<Model&UserContract>  $class
 */
function dcp285User(?string $role = null, ?string $class = null): UserContract&Model
{
    $class ??= User::class;
    // forceCreate: la factory di Modules\Fixcity\Models\User valorizza solo il nome (email vuota, unica) e perderebbe gli attributi.
    $user = $class::query()->forceCreate(UserFactory::new()->makeOne()->getAttributes());

    if ($role !== null) {
        Role::findOrCreate($role, 'web');
        $user->assignRole($role);
    }

    return $user;
}

function dcp285Allows(UserContract&Model $actor, string $ability, Model|string $target): bool
{
    return Gate::forUser($actor)->allows($ability, $target);
}

describe('UserPolicy: utenti non amministratori', function (): void {
    foreach (DCP285_NON_ADMIN_ROLES as $role) {
        $label = $role ?? 'senza ruoli';

        test("{$label}: non elenca, non crea, non vede, non modifica e non cancella un altro utente", function () use ($role): void {
            $actor = dcp285User($role);
            $other = dcp285User();

            Assert::assertFalse(dcp285Allows($actor, 'viewAny', User::class), 'viewAny');
            Assert::assertFalse(dcp285Allows($actor, 'create', User::class), 'create');
            Assert::assertFalse(dcp285Allows($actor, 'view', $other), 'view altro');
            Assert::assertFalse(dcp285Allows($actor, 'update', $other), 'update altro');
            Assert::assertFalse(dcp285Allows($actor, 'delete', $other), 'delete altro');
        });

        test("{$label}: vede e aggiorna se stesso ma non si cancella", function () use ($role): void {
            $actor = dcp285User($role);

            Assert::assertTrue(dcp285Allows($actor, 'view', $actor), 'view se stesso');
            Assert::assertTrue(dcp285Allows($actor, 'update', $actor), 'update se stesso');
            Assert::assertFalse(dcp285Allows($actor, 'delete', $actor), 'delete se stesso');
        });
    }
});

describe('UserPolicy: ruoli amministrativi', function (): void {
    foreach (['admin', 'user::admin'] as $role) {
        test("{$role}: elenca, crea, vede, modifica e cancella un altro utente ordinario", function () use ($role): void {
            $actor = dcp285User($role);
            $other = dcp285User();

            Assert::assertTrue(dcp285Allows($actor, 'viewAny', User::class), 'viewAny');
            Assert::assertTrue(dcp285Allows($actor, 'create', User::class), 'create');
            Assert::assertTrue(dcp285Allows($actor, 'view', $other), 'view altro');
            Assert::assertTrue(dcp285Allows($actor, 'update', $other), 'update altro');
            Assert::assertTrue(dcp285Allows($actor, 'delete', $other), 'delete altro');
        });

        test("{$role}: modifica se stesso ma non si cancella", function () use ($role): void {
            $actor = dcp285User($role);

            Assert::assertTrue(dcp285Allows($actor, 'update', $actor), 'update se stesso');
            Assert::assertFalse(dcp285Allows($actor, 'delete', $actor), 'delete se stesso');
        });

        test("{$role}: vede ma non modifica ne' cancella un super-admin (nessuna scalata di privilegi)", function () use ($role): void {
            $actor = dcp285User($role);
            $root = dcp285User('super-admin');

            Assert::assertTrue(dcp285Allows($actor, 'view', $root), 'view super-admin');
            Assert::assertFalse(dcp285Allows($actor, 'update', $root), 'update super-admin');
            Assert::assertFalse(dcp285Allows($actor, 'delete', $root), 'delete super-admin');
        });
    }

    test('super-admin: ha accesso a tutto tranne cancellare se stesso', function (): void {
        $actor = dcp285User('super-admin');
        $other = dcp285User();

        Assert::assertTrue(dcp285Allows($actor, 'viewAny', User::class), 'viewAny');
        Assert::assertTrue(dcp285Allows($actor, 'create', User::class), 'create');
        Assert::assertTrue(dcp285Allows($actor, 'view', $other), 'view altro');
        Assert::assertTrue(dcp285Allows($actor, 'update', $other), 'update altro');
        Assert::assertTrue(dcp285Allows($actor, 'delete', $other), 'delete altro');
        Assert::assertTrue(dcp285Allows($actor, 'update', $actor), 'update se stesso');
        Assert::assertFalse(dcp285Allows($actor, 'delete', $actor), 'delete se stesso');
        Assert::assertFalse(dcp285Allows($actor, 'forceDelete', $actor), 'forceDelete se stesso');
    });

    test('solo il super-admin ripristina o cancella definitivamente', function (): void {
        $other = dcp285User();

        foreach (['admin', 'user::admin'] as $role) {
            $actor = dcp285User($role);
            Assert::assertFalse(dcp285Allows($actor, 'restore', $other), "{$role} restore");
            Assert::assertFalse(dcp285Allows($actor, 'forceDelete', $other), "{$role} forceDelete");
        }

        $root = dcp285User('super-admin');
        Assert::assertTrue(dcp285Allows($root, 'restore', $other), 'super-admin restore');
        Assert::assertTrue(dcp285Allows($root, 'forceDelete', $other), 'super-admin forceDelete');
    });
});

describe('UserPolicy: abilita\' collettive e secondarie', function (): void {
    // Filament, senza il metodo sulla policy, considera l'abilita' CONSENTITA (get_authorization_response): vanno definite tutte.
    test('sono definite sulla policy, cosi\' Filament non le concede per assenza', function (): void {
        foreach (['deleteAny', 'restoreAny', 'forceDeleteAny', 'replicate', 'reorder'] as $ability) {
            Assert::assertTrue(method_exists(UserPolicy::class, $ability), "UserPolicy::{$ability}() manca");
        }
    });

    test('solo gli amministratori cancellano in blocco; replicare, riordinare e ripristinare in blocco solo il super-admin', function (): void {
        $other = dcp285User();
        $citizen = dcp285User();
        $admin = dcp285User('user::admin');
        $root = dcp285User('super-admin');

        Assert::assertFalse(dcp285Allows($citizen, 'deleteAny', User::class), 'cittadino deleteAny');
        Assert::assertTrue(dcp285Allows($admin, 'deleteAny', User::class), 'amministratore deleteAny');

        foreach (['restoreAny', 'forceDeleteAny', 'reorder'] as $ability) {
            Assert::assertFalse(dcp285Allows($admin, $ability, User::class), "amministratore {$ability}");
            Assert::assertTrue(dcp285Allows($root, $ability, User::class), "super-admin {$ability}");
        }
        Assert::assertFalse(dcp285Allows($admin, 'replicate', $other), 'amministratore replicate');
        Assert::assertTrue(dcp285Allows($root, 'replicate', $other), 'super-admin replicate');
    });
});

describe('UserPolicy: applicazione alla classe di autenticazione reale', function (): void {
    test('la policy si applica alla classe utente configurata in auth.providers.users.model', function (): void {
        $class = XotData::make()->getUserClass();

        Assert::assertInstanceOf(UserPolicy::class, Gate::getPolicyFor($class), "nessuna UserPolicy per {$class}");
    });

    test('un utente della classe di autenticazione reale non modifica un altro utente', function (): void {
        $class = XotData::make()->getUserClass();
        $actor = dcp285User(null, $class);
        $other = dcp285User(null, $class);

        Assert::assertFalse(dcp285Allows($actor, 'update', $other), 'update altro');
        Assert::assertFalse(dcp285Allows($actor, 'delete', $other), 'delete altro');
        Assert::assertTrue(dcp285Allows($actor, 'update', $actor), 'update se stesso');
    });

    test('un amministratore della classe di autenticazione reale mantiene l\'accesso', function (): void {
        $class = XotData::make()->getUserClass();
        $actor = dcp285User('user::admin', $class);
        $other = dcp285User(null, $class);

        Assert::assertTrue(dcp285Allows($actor, 'viewAny', $class), 'viewAny');
        Assert::assertTrue(dcp285Allows($actor, 'update', $other), 'update altro');
    });
});
