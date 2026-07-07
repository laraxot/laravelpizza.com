<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Process;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use PHPUnit\Framework\Assert;

it('executes allowed artisan command correctly', function (): void {
    Event::fake();
    Process::fake([
        'php artisan migrate' => Process::result('Migration successful', '', 0),
    ]);

    $action = app(ExecuteArtisanCommandAction::class);
    $result = $action->execute('migrate');

    Assert::assertSame('completed', $result['status']);
    Assert::assertSame(0, $result['exitCode']);
    /** @var array<int, string> $output */
    $output = $result['output'];
    Assert::assertStringContainsString('Migration successful', implode("\n", $output));
    Event::assertDispatched('artisan-command.started');
    Event::assertDispatched('artisan-command.completed');
});

it('handles failed artisan command correctly', function (): void {
    Event::fake();
    Process::fake([
        'php artisan migrate' => Process::result('', 'Migration failed', 1),
    ]);

    $action = app(ExecuteArtisanCommandAction::class);
    $result = $action->execute('migrate');

    Assert::assertSame('failed', $result['status']);
    Assert::assertSame(1, $result['exitCode']);
    /** @var array<int, string> $output */
    $output = $result['output'];
    Assert::assertStringContainsString('[ERROR] Migration failed', implode("\n", $output));
    Event::assertDispatched('artisan-command.failed');
});
