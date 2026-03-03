<?php

declare(strict_types=1);

use Modules\Xot\Actions\Array\SaveJsonArrayAction;

beforeEach(function (): void {
    $this->action = app(SaveJsonArrayAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_arr_json_'.uniqid();
    mkdir($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($this->tempDir) && is_dir($this->tempDir)) {
        foreach (glob($this->tempDir.'/*') ?: [] as $f) {
            unlink($f);
        }
        rmdir($this->tempDir);
    }
});

it('saves array to json', function (): void {
    $path = $this->tempDir.'/d.json';
    $result = $this->action->execute(['k' => 'v'], $path);
    expect($result)->toBeTrue();
    expect(json_decode(file_get_contents($path), true))->toBe(['k' => 'v']);
});
