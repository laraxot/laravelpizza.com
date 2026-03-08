<?php

declare(strict_types=1);

use Modules\Xot\Actions\Arr\SavePhpArrayAction;

beforeEach(function (): void {
    $action = app(SavePhpArrayAction::class);
    $tempDir = sys_get_temp_dir();
    mkdir($tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($tempDir
        array_map('unlink', glob($tempDir.'/*'));
        rmdir($tempDir);
    }
});

it('saves array to php file', function (): void {
    $data = ['a' => 1, 'b' => 'test'];
    $path = $tempDir.'/data.php';

    $result = $action->execute($data, $path);

    expect($result)->toBeTrue();
    $loaded = require $path;
    expect($loaded)->toBe($data);
});

it('saved file has strict types', function (): void {
    $path = $tempDir.'/strict.php';
    $action->execute(['x' => 1], $path);

    expect(file_get_contents($path))->toContain('declare(strict_types=1)');
});
