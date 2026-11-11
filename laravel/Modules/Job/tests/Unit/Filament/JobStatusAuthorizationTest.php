<?php

declare(strict_types=1);

use Filament\FilamentManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Mockery\MockInterface;
use Modules\Job\Actions\Console\AssertAllowedArtisanCommandAction;
use Modules\Job\Filament\Pages\JobStatus;
use Modules\Job\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

/*
 * Test puri: nessun database, nessun bootstrap dell'app, nessun TestCase del modulo (usa
 * DatabaseTransactions). Application vuota (solo binding di base) + utenti/kernel Artisan mock;
 * il container originale viene ripristinato in afterEach.
 */

beforeEach(function (): void {
    $this->jobPreviousContainer = Container::getInstance();
    $this->jobPreviousFacadeApp = Facade::getFacadeApplication();

    $app = new Application(sys_get_temp_dir());
    Container::setInstance($app);
    Facade::clearResolvedInstances();
    Facade::setFacadeApplication($app);
    $this->jobContainer = $app;
});

afterEach(function (): void {
    Mockery::close();
    Container::setInstance($this->jobPreviousContainer);
    Facade::clearResolvedInstances();
    Facade::setFacadeApplication($this->jobPreviousFacadeApp);
});

/**
 * $user e' un mock (UserContract/Authenticatable): Guard::user() e' esso stesso un mock.
 */
function jobStatusPageActAs(Application $container, ?object $user): void
{
    $guard = Mockery::mock(Guard::class);
    $guard->shouldReceive('user')->andReturn($user);

    $filament = Mockery::mock(FilamentManager::class);
    $filament->shouldReceive('auth')->andReturn($guard);

    $container->instance('filament', $filament);
    Facade::clearResolvedInstance('filament');
}

function jobStatusPageUser(bool $isSuperAdmin): MockInterface
{
    $user = Mockery::mock(UserContract::class, Authenticatable::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);

    return $user;
}

function jobStatusPageKernel(Application $container): MockInterface
{
    $kernel = Mockery::mock(Kernel::class);
    $container->instance(Kernel::class, $kernel);
    Facade::clearResolvedInstance(Kernel::class);

    return $kernel;
}

it('denies canAccess to guests', function (): void {
    jobStatusPageActAs($this->jobContainer, null);

    expect(JobStatus::canAccess())->toBeFalse();
});

it('denies canAccess to users without the super-admin role', function (): void {
    jobStatusPageActAs($this->jobContainer, jobStatusPageUser(false));

    expect(JobStatus::canAccess())->toBeFalse();
});

it('denies canAccess to authenticatables that are not project users', function (): void {
    jobStatusPageActAs($this->jobContainer, Mockery::mock(Authenticatable::class));

    expect(JobStatus::canAccess())->toBeFalse();
});

it('grants canAccess to super-admin', function (): void {
    jobStatusPageActAs($this->jobContainer, jobStatusPageUser(true));

    expect(JobStatus::canAccess())->toBeTrue();
});

it('refuses artisan() to a non super-admin even for a listed command', function (): void {
    jobStatusPageActAs($this->jobContainer, jobStatusPageUser(false));
    jobStatusPageKernel($this->jobContainer)->shouldReceive('call')->never();
    $page = new JobStatus;

    expect(fn () => $page->artisan('route:list'))->toThrow(AuthorizationException::class)
        ->and($page->out)->toBe('');
});

it('rejects commands outside the allowlist even for a super-admin', function (string $command): void {
    jobStatusPageActAs($this->jobContainer, jobStatusPageUser(true));
    jobStatusPageKernel($this->jobContainer)->shouldReceive('call')->never();
    $page = new JobStatus;

    $page->artisan($command);

    expect($page->out)->toBe('');
})->with([
    'migrate fresh' => 'migrate:fresh --force',
    'migrate fresh bare' => 'migrate:fresh',
    'db wipe' => 'db:wipe',
    'listed command with extra option' => 'queue:flush --force',
    'listed command with json option' => 'route:list --json',
    'case change' => 'QUEUE:CLEAR',
    'leading space' => ' queue:clear',
]);

it('runs a listed command by exact match for a super-admin', function (): void {
    jobStatusPageActAs($this->jobContainer, jobStatusPageUser(true));
    $kernel = jobStatusPageKernel($this->jobContainer);
    $kernel->shouldReceive('call')->once()->with('route:list')->andReturn(0);
    $kernel->shouldReceive('output')->once()->andReturn('ok');
    $page = new JobStatus;

    $page->artisan('route:list');

    expect($page->out)->toBe('ok');
});

it('derives the allowlist from the page buttons and excludes destructive framework commands', function (): void {
    $allowed = (new JobStatus)->getAllowedCommands();

    expect($allowed)->toContain('queue:restart')->toContain('route:list');
    foreach (['migrate', 'migrate:fresh', 'db:wipe', 'db:seed', 'tinker'] as $forbidden) {
        expect($allowed)->not->toContain($forbidden);
    }
});

it('AssertAllowedArtisanCommandAction throws for commands that are not listed', function (string $command): void {
    $action = new AssertAllowedArtisanCommandAction;

    expect(fn () => $action->execute($command, ['queue:restart']))->toThrow(InvalidArgumentException::class);
})->with([
    'migrate fresh' => 'migrate:fresh --force',
    'db wipe' => 'db:wipe',
]);

it('AssertAllowedArtisanCommandAction accepts a listed command', function (): void {
    $action = new AssertAllowedArtisanCommandAction;

    expect(fn () => $action->execute('queue:restart', ['queue:restart']))->not->toThrow(InvalidArgumentException::class);
});
