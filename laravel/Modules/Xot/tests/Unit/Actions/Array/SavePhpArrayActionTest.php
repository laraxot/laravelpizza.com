<?php

declare(strict_types=1);

use Modules\Xot\Actions\Array\SavePhpArrayAction;

beforeEach(function (): void {
    $action = app(SavePhpArrayAction::class);
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

it('saves array to php', function (): void {
    $path = $tempDir.'/d.php';
    $data = ['a' => 1];
    $result = $action->execute($data, $path);
    expect($result)->toBeTrue();
    expect(require $path)->toBe($data);
});
