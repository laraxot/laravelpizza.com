<?php

declare(strict_types=1);
use Illuminate\Support\Facades\File;
use Modules\Activity\Actions\Log\ResolveLogDirectoryAction;
use Modules\Activity\Actions\Log\ResolveLogFilePathAction;
use Modules\Activity\Exceptions\InvalidLogFileException;
use Safe\Exceptions\FilesystemException;
use Tests\TestCase;

use function Safe\realpath;
use function Safe\symlink;

uses(TestCase::class);

/*
 * Usa Tests\TestCase (root) e non Modules\Activity\Tests\TestCase: queste azioni lavorano solo sul
 * filesystem e la seconda richiede un file sqlite condiviso non presente in ogni ambiente
 * (stesso motivo dei test di Modules/Xot/tests/Feature/Filament/Widgets/EnvWidgetTest.php).
 *
 * Ogni test lavora in una cartella temporanea dentro storage/framework/testing, mai in storage/logs.
 * `$this->root` contiene `logs/` (la cartella base) e, accanto, un `secret.log` FUORI dalla base:
 * serve a provare che non sia mai raggiungibile.
 */
beforeEach(function (): void {
    $this->root = storage_path('framework/testing/log-viewer-'.uniqid('', true));
    $this->base = $this->root.'/logs';
    File::makeDirectory($this->base.'/reports/rejected', 0777, true);
    File::put($this->base.'/laravel.log', "riga\n");
    File::put($this->base.'/reports/rejected/daily_2026-09-20.log', "rifiutata\n");
    File::put($this->base.'/note.txt', 'non e un log');
    File::put($this->root.'/secret.log', 'segreto');
});

afterEach(function (): void {
    File::deleteDirectory($this->root);
});

it('resolves a log file at the top level and in a nested folder', function (): void {
    $action = new ResolveLogFilePathAction;
    $base = realpath($this->base);

    $top = $action->execute('laravel.log', $this->base);
    expect($top->absolutePath)->toBe($base.'/laravel.log');
    expect($top->relativePath)->toBe('laravel.log');

    $nested = $action->execute('reports/rejected/daily_2026-09-20.log', $this->base);
    expect($nested->absolutePath)->toBe($base.'/reports/rejected/daily_2026-09-20.log');
    expect($nested->relativePath)->toBe('reports/rejected/daily_2026-09-20.log');
});

it('rejects path traversal that would reach a file outside the log directory', function (): void {
    $action = new ResolveLogFilePathAction;

    expect(fn () => $action->execute('../secret.log', $this->base))->toThrow(InvalidLogFileException::class);
    expect(fn () => $action->execute('reports/../../secret.log', $this->base))->toThrow(InvalidLogFileException::class);
});

it('rejects an absolute path even if it points to a real log file', function (): void {
    $action = new ResolveLogFilePathAction;

    expect(fn () => $action->execute($this->root.'/secret.log', $this->base))->toThrow(InvalidLogFileException::class);
});

it('rejects files that are not .log, missing files, empty paths and null bytes', function (): void {
    $action = new ResolveLogFilePathAction;

    expect(fn () => $action->execute('note.txt', $this->base))->toThrow(InvalidLogFileException::class);
    expect(fn () => $action->execute('non-esiste.log', $this->base))->toThrow(InvalidLogFileException::class);
    expect(fn () => $action->execute('reports', $this->base))->toThrow(InvalidLogFileException::class);
    expect(fn () => $action->execute('', $this->base))->toThrow(InvalidLogFileException::class);
    expect(fn () => $action->execute("laravel.log\0.txt", $this->base))->toThrow(InvalidLogFileException::class);
});

it('rejects a symlink inside the log directory that points outside of it', function (): void {
    try {
        symlink($this->root.'/secret.log', $this->base.'/link.log');
    } catch (FilesystemException) {
        $this->markTestSkipped('Impossibile creare link simbolici in questo ambiente.');
    }

    $action = new ResolveLogFilePathAction;

    expect(fn () => $action->execute('link.log', $this->base))->toThrow(InvalidLogFileException::class);
});

it('rejects a symlink named .log whose target is not a .log file', function (): void {
    try {
        symlink($this->base.'/note.txt', $this->base.'/finto.log');
    } catch (FilesystemException) {
        $this->markTestSkipped('Impossibile creare link simbolici in questo ambiente.');
    }

    $action = new ResolveLogFilePathAction;

    expect(fn () => $action->execute('finto.log', $this->base))->toThrow(InvalidLogFileException::class);
});

it('fails clearly when the base directory does not exist', function (): void {
    $action = new ResolveLogFilePathAction;

    expect(fn () => $action->execute('laravel.log', $this->root.'/non-esiste'))->toThrow(InvalidLogFileException::class);
});

it('resolves the log directory to its real path and fails when it is missing', function (): void {
    $action = new ResolveLogDirectoryAction;

    expect($action->execute($this->base))->toBe(realpath($this->base));
    expect(fn () => $action->execute($this->root.'/non-esiste'))->toThrow(InvalidLogFileException::class);
    expect(fn () => $action->execute($this->base.'/laravel.log'))->toThrow(InvalidLogFileException::class);
});
