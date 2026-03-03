<?php

declare(strict_types=1);

use Modules\Xot\Actions\Arr\SaveArrayAction;

beforeEach(function (): void {
    $this->action = app(SaveArrayAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_save_array_'.uniqid();
    mkdir($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($this->tempDir) && is_dir($this->tempDir)) {
        array_map('unlink', glob($this->tempDir.'/*') ?: []);
        rmdir($this->tempDir);
    }
});

it('saves array as json', function (): void {
    $data = ['a' => 1, 'b' => 2];
    $path = $this->tempDir.'/test.json';

    $result = $this->action->execute($data, $path, 'json');

    expect($result)->toBeTrue()
        ->and(file_get_contents($path))->toContain('"a": 1');
});

it('saves array as php', function (): void {
    $data = ['a' => 1, 'b' => 2];
    $path = $this->tempDir.'/test.php';

    $result = $this->action->execute($data, $path, 'php');

    expect($result)->toBeTrue();
    $loaded = require $path;
    expect($loaded)->toBe($data);
});

it('uses php as default format', function (): void {
    $data = ['d' => 3];
    $path = $this->tempDir.'/default.php';

    $result = $this->action->execute($data, $path);

    expect($result)->toBeTrue()
        ->and(require $path)->toBe($data);
});

it('throws for unsupported format', function (): void {
    $this->action->execute([], $this->tempDir.'/x.xml', 'xml');
})->throws(InvalidArgumentException::class, 'Formato non supportato');
