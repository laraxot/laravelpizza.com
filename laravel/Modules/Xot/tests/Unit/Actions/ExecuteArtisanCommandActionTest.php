<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Process;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use Tests\TestCase;

uses(TestCase::class);

test('execute artisan command action executes allowed command', function () {
    Event::fake();
    Process::fake([
        'php artisan migrate' => Process::result('Migration successful', '', 0),
    ]);

    $action = app(ExecuteArtisanCommandAction::class);
    $result = $action->execute('migrate');

    expect($result['status'])->toBe('completed')
        ->and($result['exitCode'])->toBe(0)
        ->and($result['output'])->toContain('Migration successful');

    Event::assertDispatched('artisan-command.started');
    Event::assertDispatched('artisan-command.completed');
});

test('execute artisan command action throws exception for forbidden command', function () {
    $action = app(ExecuteArtisanCommandAction::class);
    expect(fn () => $action->execute('tinker'))->toThrow(\RuntimeException::class);
});

test('execute artisan command action handles failed command', function () {
    Event::fake();
    Process::fake([
        'php artisan migrate' => Process::result('', 'Migration failed', 1),
    ]);

    $action = app(ExecuteArtisanCommandAction::class);
    $result = $action->execute('migrate');

    expect($result['status'])->toBe('failed')
        ->and($result['exitCode'])->toBe(1)
        ->and($result['output'])->toContain('[ERROR] Migration failed');

    Event::assertDispatched('artisan-command.failed');
});
