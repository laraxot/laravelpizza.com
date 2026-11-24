<?php

declare(strict_types=1);

use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Guard;
use Mockery\MockInterface;
use Modules\Notify\Filament\Clusters\Test;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Filament\Traits\SuperAdminOnlyTrait;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpKernel\Exception\HttpException;

use function Safe\glob;

uses(TestCase::class);
/**
 * Il cluster "Test" invia email/SMS/WhatsApp/Telegram/Push con le credenziali aziendali:
 * deve restare riservato al super-admin (NTF-02). Nessuna query: utente e guard sono mock.
 */

/**
 * Pagine concrete del cluster, scoperte dal filesystem: una pagina nuova e' coperta senza toccare il test.
 *
 * @return array<string, array{class-string}>
 */
function notifyTestClusterPages(): array
{
    $pages = [];
    foreach (glob(dirname(__DIR__, 3).'/app/Filament/Clusters/Test/Pages/*.php') as $file) {
        Assert::assertIsString($file);
        $class = 'Modules\\Notify\\Filament\\Clusters\\Test\\Pages\\'.basename($file, '.php');
        if (! class_exists($class) || (new ReflectionClass($class))->isAbstract()) {
            continue;
        }

        $pages[class_basename($class)] = [$class];
    }

    return $pages;
}

/**
 * Installa un Filament::auth() finto (una sola volta per test) e ritorna la "sessione":
 * assegnando `$session['user']` si cambia l'utente del pannello (null = ospite).
 *
 * @return ArrayObject<string, UserContract|null>
 */
function notifyTestClusterSession(): ArrayObject
{
    /** @var ArrayObject<string, UserContract|null> $session */
    $session = new ArrayObject(['user' => null]);

    $guard = Mockery::mock(Guard::class);
    $guard->shouldReceive('user')->andReturnUsing(static fn (): ?UserContract => $session['user']);
    Filament::shouldReceive('auth')->andReturn($guard);

    return $session;
}

function notifyTestClusterUser(bool $isSuperAdmin): UserContract
{
    /** @var MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

test('il cluster Test trova almeno una pagina da proteggere', function (): void {
    Assert::assertNotEmpty(notifyTestClusterPages());
});

test('il cluster Test usa SuperAdminOnlyTrait', function (): void {
    Assert::assertContains(SuperAdminOnlyTrait::class, class_uses_recursive(Test::class));
    Assert::assertSame(
        (new ReflectionClass(SuperAdminOnlyTrait::class))->getFileName(),
        (new ReflectionMethod(Test::class, 'canAccess'))->getFileName(),
    );
});

test('la pagina usa canAccess() di SuperAdminOnlyTrait', function (string $class): void {
    Assert::assertContains(SuperAdminOnlyTrait::class, class_uses_recursive($class));
    // canAccess() non deve essere ridefinita nella pagina con un criterio piu' permissivo.
    Assert::assertSame(
        (new ReflectionClass(SuperAdminOnlyTrait::class))->getFileName(),
        (new ReflectionMethod($class, 'canAccess'))->getFileName(),
    );
})->with(fn (): array => notifyTestClusterPages());

test('canAccess() e\' false per ospite e utente non super-admin, true per super-admin', function (string $class): void {
    $session = notifyTestClusterSession();
    Assert::assertFalse($class::canAccess());

    $session['user'] = notifyTestClusterUser(false);
    Assert::assertFalse($class::canAccess());

    $session['user'] = notifyTestClusterUser(true);
    Assert::assertTrue($class::canAccess());
})->with(fn (): array => notifyTestClusterPages());

test('i metodi di invio rifiutano con 403 un utente non super-admin senza leggere il form', function (): void {
    $session = notifyTestClusterSession();
    $session['user'] = notifyTestClusterUser(false);
    $checked = 0;

    foreach (notifyTestClusterPages() as [$class]) {
        $reflection = new ReflectionClass($class);
        $page = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() !== $class || ! str_starts_with($method->getName(), 'send')) {
                continue;
            }

            try {
                $method->invoke($page);
                Assert::fail($class.'::'.$method->getName().' non e\' protetto.');
            } catch (HttpException $exception) {
                Assert::assertSame(403, $exception->getStatusCode());
            }

            $checked++;
        }
    }

    Assert::assertGreaterThan(0, $checked);
});
