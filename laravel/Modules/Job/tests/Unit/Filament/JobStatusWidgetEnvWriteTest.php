<?php

declare(strict_types=1);

use Filament\FilamentManager;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Facade;
use Livewire\Attributes\Locked;
use Mockery\MockInterface;
use Modules\Job\Filament\Widgets\JobStatusWidget;
<<<<<<< .merge_file_dDPjzl
use Modules\Job\Tests\TestCase;
=======
use Modules\Job\Tests\Unit\Filament\JobStatusWidgetProbe;
>>>>>>> .merge_file_QdpvNM
use Modules\Xot\Contracts\UserContract;

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\putenv;
use function Safe\tempnam;
use function Safe\unlink;

uses(TestCase::class);

/*
 * Test puri: nessun database, nessun bootstrap dell'app, nessun TestCase del modulo (usa
 * DatabaseTransactions), mai il vero .env: la scrittura va su un file temporaneo. Application vuota
 * con config/files/filament; container originale e QUEUE_CONNECTION ripristinati in afterEach.
 */

/**
 * Salta la risoluzione della vista del costruttore di XotBaseWidget (richiede un'app avviata)
 * e redirige la scrittura su un file temporaneo.
 */
const JOB_ENV_WIDGET_INITIAL = "APP_ENV=testing\nQUEUE_CONNECTION=database\nAPP_DEBUG=false\n";

beforeEach(function (): void {
    $this->jobPreviousContainer = Container::getInstance();
    $this->jobPreviousFacadeApp = Facade::getFacadeApplication();
    $this->jobPreviousQueueEnv = getenv('QUEUE_CONNECTION');

    $container = new Application(sys_get_temp_dir());
    $container->instance('config', new Repository([
        'queue' => ['connections' => [
            'sync' => ['driver' => 'sync'],
            'database' => ['driver' => 'database'],
            'ok_name-2' => ['driver' => 'null'],
            "evil\nAPP_DEBUG=true" => ['driver' => 'null'],
            'with space' => ['driver' => 'null'],
            'a=b' => ['driver' => 'null'],
        ]],
    ]));
    $container->instance('files', new Filesystem);
    Container::setInstance($container);
    Facade::clearResolvedInstances();
    Facade::setFacadeApplication($container);
    $this->jobContainer = $container;

    $this->jobEnvFile = tempnam(sys_get_temp_dir(), 'jobenv');
    file_put_contents($this->jobEnvFile, JOB_ENV_WIDGET_INITIAL);
});

afterEach(function (): void {
    Mockery::close();
    if (is_file($this->jobEnvFile)) {
        unlink($this->jobEnvFile);
    }
    putenv($this->jobPreviousQueueEnv === false ? 'QUEUE_CONNECTION' : 'QUEUE_CONNECTION='.$this->jobPreviousQueueEnv);
    Container::setInstance($this->jobPreviousContainer);
    Facade::clearResolvedInstances();
    Facade::setFacadeApplication($this->jobPreviousFacadeApp);
});

/**
 * $user e' un mock (UserContract/Authenticatable): Guard::user() e' esso stesso un mock.
 */
function jobEnvWidgetActAs(Application $container, ?object $user): void
{
    $guard = Mockery::mock(Guard::class);
    $guard->shouldReceive('user')->andReturn($user);

    $filament = Mockery::mock(FilamentManager::class);
    $filament->shouldReceive('auth')->andReturn($guard);

    $container->instance('filament', $filament);
    Facade::clearResolvedInstance('filament');
}

function jobEnvWidgetUser(bool $isSuperAdmin): MockInterface
{
    $user = Mockery::mock(UserContract::class, Authenticatable::class);
    $user->shouldReceive('hasRole')->with('super-admin')->andReturn($isSuperAdmin);

    return $user;
}

function jobEnvWidgetProbe(string $envFile, string $conn): JobStatusWidgetProbe
{
    $widget = new JobStatusWidgetProbe;
    $widget->probeEnvFile = $envFile;
    $widget->old_value = 'database';
    $widget->form_data['conn'] = $conn;

    return $widget;
}

it('locks old_value so the client cannot rewrite it', function (): void {
    $attributes = (new ReflectionProperty(JobStatusWidget::class, 'old_value'))->getAttributes(Locked::class);

    expect($attributes)->toHaveCount(1);
});

it('allows only well-formed connection names from config queue.connections', function (): void {
    $widget = new JobStatusWidgetProbe;

    expect($widget->getAllowedConnections())->toBe(['sync', 'database', 'ok_name-2']);
});

it('rejects values that are not a configured connection and leaves .env untouched', function (string $value): void {
    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(true));
    $widget = jobEnvWidgetProbe($this->jobEnvFile, $value);

    $widget->updatedFormData($value, 'conn');

    expect(file_get_contents($this->jobEnvFile))->toBe(JOB_ENV_WIDGET_INITIAL)
        ->and($widget->form_data['conn'])->toBe('database')
        ->and($widget->old_value)->toBe('database');
})->with([
    'newline injection' => "sync\nAPP_DEBUG=true",
    'crlf injection' => "sync\r\nMAIL_HOST=evil",
    'trailing newline' => "sync\n",
    'equals sign' => 'sync=1',
    'trailing space' => 'sync ',
    'not configured' => 'redis',
    'malicious configured-looking key' => "evil\nAPP_DEBUG=true",
    'empty' => '',
]);

it('denies saveEnv to a non super-admin before touching .env', function (): void {
    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(false));
    $widget = jobEnvWidgetProbe($this->jobEnvFile, 'sync');

    expect(fn () => $widget->saveEnv())->toThrow(AuthorizationException::class)
        ->and(file_get_contents($this->jobEnvFile))->toBe(JOB_ENV_WIDGET_INITIAL);
});

it('denies the client-driven updatedFormData hook to guests', function (): void {
    jobEnvWidgetActAs($this->jobContainer, null);
    $widget = jobEnvWidgetProbe($this->jobEnvFile, 'sync');

    expect(fn () => $widget->updatedFormData('sync', 'conn'))->toThrow(AuthorizationException::class)
        ->and(file_get_contents($this->jobEnvFile))->toBe(JOB_ENV_WIDGET_INITIAL);
});

it('writes only the QUEUE_CONNECTION line for a valid connection chosen by a super-admin', function (): void {
    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(true));
    $widget = jobEnvWidgetProbe($this->jobEnvFile, 'sync');

    $widget->updatedFormData('sync', 'conn');

    expect(file_get_contents($this->jobEnvFile))->toBe("APP_ENV=testing\nQUEUE_CONNECTION=sync\nAPP_DEBUG=false\n")
        ->and($widget->old_value)->toBe('sync');
});

function jobEnvWidgetKernel(Application $container): MockInterface
{
    $kernel = Mockery::mock(Kernel::class);
    $container->instance(Kernel::class, $kernel);
    Facade::clearResolvedInstance(Kernel::class);

    return $kernel;
}

it('hides the widget from non super-admin users', function (): void {
    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(false));
    expect(JobStatusWidget::canView())->toBeFalse();

    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(true));
    expect(JobStatusWidget::canView())->toBeTrue();
});

it('denies the queue artisan buttons and the dummy action to a non super-admin', function (): void {
    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(false));
    jobEnvWidgetKernel($this->jobContainer)->shouldReceive('call')->never();
    $widget = jobEnvWidgetProbe($this->jobEnvFile, 'database');

    expect(fn () => $widget->artisan('flush'))->toThrow(AuthorizationException::class)
        ->and(fn () => $widget->dummyAction())->toThrow(AuthorizationException::class)
        ->and($widget->out)->toBe('');
});

it('runs only listed queue subcommands for a super-admin', function (): void {
    jobEnvWidgetActAs($this->jobContainer, jobEnvWidgetUser(true));
    $kernel = jobEnvWidgetKernel($this->jobContainer);
    $kernel->shouldReceive('call')->once()->with('queue:restart')->andReturn(0);
    $kernel->shouldReceive('output')->once()->andReturn('done');
    $widget = jobEnvWidgetProbe($this->jobEnvFile, 'database');

    $widget->artisan('migrate:fresh --force');
    $widget->artisan('restart');

    expect($widget->out)->toBe('<hr/>done<hr/>');
});
