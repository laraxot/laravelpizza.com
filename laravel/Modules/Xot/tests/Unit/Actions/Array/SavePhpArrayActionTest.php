<?php

declare(strict_types=1);

use Modules\Xot\Actions\Array\SavePhpArrayAction;

beforeEach(function (): void {
    $this->action = app(SavePhpArrayAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_arr_php_'.uniqid();
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

it('saves array to php', function (): void {
    $path = $this->tempDir.'/d.php';
    $data = ['a' => 1];
    $result = $this->action->execute($data, $path);
    expect($result)->toBeTrue();
    expect(require $path)->toBe($data);
});
