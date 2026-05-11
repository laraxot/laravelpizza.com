<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Modules\Xot\Actions\Array\SavePhpArrayAction;

beforeEach(function (): void {
    $this->action = app(SavePhpArrayAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_array_php_'.uniqid();
    mkdir($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (isset($this->tempDir) && is_dir($this->tempDir)) {
        foreach (glob($this->tempDir.'/*') ?: [] as $file) {
            unlink($file);
        }
        rmdir($this->tempDir);
    }
});

it('saves array to php', function (): void {
    $path = $this->tempDir.'/d.php';
    $data = ['a' => 1];
    $result = $this->action->execute($data, $path);
    expect($result)->toBeTrue();
    expect(require $path)->toBe($data);
});
