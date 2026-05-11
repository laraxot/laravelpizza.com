<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\SaveJsonArrayAction;

beforeEach(function (): void {
    $this->action = app(SaveJsonArrayAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_arr_'.uniqid();
    mkdir($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($this->tempDir) && is_dir($this->tempDir)) {
        array_map('unlink', glob($this->tempDir.'/*') ?: []);
        rmdir($this->tempDir);
    }
});

it('saves array to json file', function (): void {
    $data = ['key' => 'value', 'nested' => ['a' => 1]];
    $path = $this->tempDir.'/data.json';

    $result = $this->action->execute($data, $path);

    expect($result)->toBeTrue()
        ->and(file_exists($path))->toBeTrue()
        ->and(json_decode(file_get_contents($path), true))->toBe($data);
});

it('saves empty array', function (): void {
    $path = $this->tempDir.'/empty.json';
    $result = $this->action->execute([], $path);

    expect($result)->toBeTrue()
        ->and(json_decode(file_get_contents($path), true))->toBe([]);
});
