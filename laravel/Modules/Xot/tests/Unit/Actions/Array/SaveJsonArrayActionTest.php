<?php

declare(strict_types=1);

use Modules\Xot\Actions\Array\SaveJsonArrayAction;

beforeEach(function (): void {
    $action = app(SaveJsonArrayAction::class);
    $tempDir = sys_get_temp_dir();
    mkdir($tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($tempDir)) {
        foreach (glob($tempDir.'/*') as $f) {
            unlink($f);
        }
        rmdir($tempDir);
    }
});

it('saves array to json', function (): void {
    $path = $tempDir.'/d.json';
    $result = $action->execute(['k' => 'v'], $path);
    expect($result)->toBeTrue();
    expect(json_decode(file_get_contents($path), true))->toBe(['k' => 'v']);
});
