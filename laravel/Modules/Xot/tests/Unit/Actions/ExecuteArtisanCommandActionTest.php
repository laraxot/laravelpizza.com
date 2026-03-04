<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions;

use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Event;

uses(TestCase::class);

it('executes allowed artisan command correctly', function (): void {
    Event::fake();
    Process::fake([
        'php artisan migrate' => Process::result('Migration successful', '', 0),
    ]);

    $action = app(ExecuteArtisanCommandAction::class);
    $result = $action->execute('migrate');

    expect($result['status'])->toBe('completed');
    expect($result['exitCode'])->toBe(0);
    expect($result['output'])->toContain('Migration successful');

    Event::assertDispatched('artisan-command.started');
    Event::assertDispatched('artisan-command.completed');
});

it('throws exception for forbidden artisan command', function (): void {
    $action = app(ExecuteArtisanCommandAction::class);
    
    expect(fn() => $action->execute('tinker'))->toThrow(\RuntimeException::class, 'Comando non consentito');
});

it('handles failed artisan command correctly', function (): void {
    Event::fake();
    Process::fake([
        'php artisan migrate' => Process::result('', 'Migration failed', 1),
    ]);

    $action = app(ExecuteArtisanCommandAction::class);
    $result = $action->execute('migrate');

    expect($result['status'])->toBe('failed');
    expect($result['exitCode'])->toBe(1);
    expect($result['output'])->toContain('[ERROR] Migration failed');

    Event::assertDispatched('artisan-command.failed');
});
