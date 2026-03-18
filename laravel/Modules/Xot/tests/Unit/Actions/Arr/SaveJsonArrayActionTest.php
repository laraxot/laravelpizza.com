<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\SaveJsonArrayAction;

beforeEach(function (): void {
    $action = app(SaveJsonArrayAction::class);
    $tempDir = sys_get_temp_dir();
    mkdir($tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($tempDir))
        array_map('unlink', glob($tempDir.'/*'));
        rmdir($tempDir);
    }
});

it('saves array to json file', function (): void {
    $data = ['key' => 'value', 'nested' => ['a' => 1]];
    $path = $tempDir.'/data.json';

    $result = $action->execute($data, $path);

    expect($result)->toBeTrue()
        ->and(file_exists($path))->toBeTrue()
        ->and(json_decode(file_get_contents($path), true))->toBe($data);
});

it('saves empty array', function (): void {
    $path = $tempDir.'/empty.json';
    $result = $action->execute([], $path);

    expect($result)->toBeTrue()
        ->and(json_decode(file_get_contents($path), true))->toBe([]);
});
