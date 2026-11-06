<?php

declare(strict_types=1);
use Illuminate\Support\Facades\File;
use Modules\Activity\Actions\Log\ReadLogTailAction;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->dir = storage_path('framework/testing/log-viewer-'.uniqid('', true));
    File::makeDirectory($this->dir, 0777, true);
});

afterEach(function (): void {
    File::deleteDirectory($this->dir);
});

it('returns an empty result for an empty file', function (): void {
    File::put($this->dir.'/vuoto.log', '');

    $tail = (new ReadLogTailAction)->execute($this->dir.'/vuoto.log');

    expect($tail->content)->toBe('');
    expect($tail->size)->toBe(0);
    expect($tail->bytesRead)->toBe(0);
    expect($tail->truncated)->toBeFalse();
});

it('returns the whole content of a small file without truncating it', function (): void {
    File::put($this->dir.'/piccolo.log', "prima\nseconda\n");

    $tail = (new ReadLogTailAction)->execute($this->dir.'/piccolo.log');

    expect($tail->content)->toBe("prima\nseconda\n");
    expect($tail->truncated)->toBeFalse();
    expect($tail->size)->toBe(14);
});

it('reads only the tail of a large file and drops the partial first line', function (): void {
    $lines = [];
    foreach (range(1, 200) as $i) {
        $lines[] = sprintf('riga-%04d %s', $i, str_repeat('x', 40));
    }
    File::put($this->dir.'/grande.log', implode("\n", $lines)."\n");

    $tail = (new ReadLogTailAction)->execute($this->dir.'/grande.log', 1024);

    expect($tail->truncated)->toBeTrue();
    expect($tail->bytesRead)->toBeLessThanOrEqual(1024);
    expect($tail->size)->toBeGreaterThan(1024);
    // La coda contiene l'ultima riga, per intero, e inizia da un inizio riga (mai a meta').
    expect($tail->content)->toContain('riga-0200');
    expect($tail->content)->toStartWith('riga-');
    expect($tail->content)->not->toContain('riga-0001');
});

it('never reads more than the hard limit even if asked for more', function (): void {
    File::put($this->dir.'/enorme.log', str_repeat(str_repeat('a', 99)."\n", 60000)); // ~6 MB

    $tail = (new ReadLogTailAction)->execute($this->dir.'/enorme.log', 100 * 1024 * 1024);

    expect($tail->bytesRead)->toBeLessThanOrEqual(ReadLogTailAction::MAX_BYTES);
    expect($tail->truncated)->toBeTrue();
});

it('cleans invalid UTF-8 bytes so the page does not break', function (): void {
    File::put($this->dir.'/sporco.log', "ok \xC3\x28 fine\n");

    $tail = (new ReadLogTailAction)->execute($this->dir.'/sporco.log');

    expect(mb_check_encoding($tail->content, 'UTF-8'))->toBeTrue();
    expect($tail->content)->toContain('ok');
    expect($tail->content)->toContain('fine');
});

it('throws a clear error when the file cannot be read', function (): void {
    expect(fn () => (new ReadLogTailAction)->execute($this->dir.'/non-esiste.log'))
        ->toThrow(RuntimeException::class);
});
