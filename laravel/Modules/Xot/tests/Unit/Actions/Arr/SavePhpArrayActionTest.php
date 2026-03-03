<?php

declare(strict_types=1);

use Modules\Xot\Actions\Arr\SavePhpArrayAction;

beforeEach(function (): void {
    $this->action = app(SavePhpArrayAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_save_php_'.uniqid();
    mkdir($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($this->tempDir) && is_dir($this->tempDir)) {
        array_map('unlink', glob($this->tempDir.'/*') ?: []);
        rmdir($this->tempDir);
    }
});

it('saves array to php file', function (): void {
    $data = ['a' => 1, 'b' => 'test'];
    $path = $this->tempDir.'/data.php';

    $result = $this->action->execute($data, $path);

    expect($result)->toBeTrue();
    $loaded = require $path;
    expect($loaded)->toBe($data);
});

it('saved file has strict types', function (): void {
    $path = $this->tempDir.'/strict.php';
    $this->action->execute(['x' => 1], $path);

    expect(file_get_contents($path))->toContain('declare(strict_types=1)');
});
