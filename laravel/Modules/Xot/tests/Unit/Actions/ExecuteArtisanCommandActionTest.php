<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Process;
use Modules\Xot\Actions\ExecuteArtisanCommandAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * `execute()` un tempo dispacciava anche `Event::dispatch('artisan-command.*',
 * ...)` (Laravel, server-side), che `ArtisanCommandsManager`/`PassportDashboard`
 * intercettavano via `#[On(...)]` (Livewire, un bus di eventi separato che
 * quegli `Event::dispatch()` non possono mai raggiungere) — nessun listener
 * li riceveva mai davvero, quindi il valore di ritorno di questo metodo è
 * sempre stato l'unico segnale affidabile di stato/output/esito. Rimossi i
 * dispatch morti (story-xot-artisan-commands-manager-stuck-running-state);
 * queste asserzioni ora coprono solo il contratto reale.
 */
it('executes allowed artisan command correctly', function (): void {
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
});

it('handles failed artisan command correctly', function (): void {
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
});
