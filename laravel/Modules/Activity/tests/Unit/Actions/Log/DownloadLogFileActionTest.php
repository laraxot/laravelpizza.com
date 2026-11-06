<?php

declare(strict_types=1);
use Illuminate\Support\Facades\File;
use Modules\Activity\Actions\Log\DownloadLogFileAction;
use Modules\Activity\Exceptions\InvalidLogFileException;
use Tests\TestCase;

uses(TestCase::class);

/*
 * storage_path() e' puntato a una cartella temporanea con useStoragePath(): il download lavora su
 * storage/logs e i test non devono mai toccare quello vero. L'originale e' ripristinato in afterEach.
 */
beforeEach(function (): void {
    $this->originalStorage = storage_path();
    $this->tempStorage = $this->originalStorage.'/framework/testing/log-download-'.uniqid('', true);
    File::makeDirectory($this->tempStorage.'/logs/reports/252', 0777, true);
    app()->useStoragePath($this->tempStorage);

    File::put($this->tempStorage.'/logs/laravel.log', "[2026-09-20 10:00:00] local.INFO: ok\n");
    File::put($this->tempStorage.'/logs/reports/252/daily.log', "contenuto del report\n");
    File::put($this->originalStorage.'/framework/testing/segreto-download.log', 'segreto');
});

afterEach(function (): void {
    app()->useStoragePath($this->originalStorage);
    File::deleteDirectory($this->tempStorage);
    File::delete($this->originalStorage.'/framework/testing/segreto-download.log');
});

it('returns a streamed download of the requested log file', function (): void {
    $response = (new DownloadLogFileAction)->execute('reports/252/daily.log');

    expect($response->headers->get('Content-Disposition'))->toContain('reports_252_daily.log');
    expect($response->headers->get('Content-Type'))->toContain('text/plain');
    /** @var Symfony\Component\HttpFoundation\File\File $file */
    $file = $response->getFile();
    expect(File::get($file->getPathname()))->toBe("contenuto del report\n");
});

it('refuses files outside the log directory, missing files and non-log files', function (): void {
    $action = new DownloadLogFileAction;

    foreach (['../framework/testing/segreto-download.log', 'non-esiste.log', '', 'laravel.log/../../.env', '/etc/passwd'] as $file) {
        expect(fn () => $action->execute($file))->toThrow(InvalidLogFileException::class);
    }
});
