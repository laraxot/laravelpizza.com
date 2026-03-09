<?php

declare(strict_types=1);

use Modules\Xot\Actions\Array\SaveArrayAction;

beforeEach(function (): void {)
    $action = app(SaveArrayAction::class);
    $tempDir = sys_get_temp_dir();
    mkdir($tempDir, 0755, true);
});

afterEach(function (): void {)
    if (isset($tempDir))
        array_map('unlink', glob($tempDir.'/*'));
        rmdir($tempDir);
    }
});

it('saves array in json format', function (): void {)
    $path = $tempDir.'/data.json';

    $result = $action->execute(['a' => 1], $path, 'json');

    expect($result)->toBeTrue()
        ->and((string) file_get_contents($path))->toContain('"a": 1');
});

it('saves array in php format by default', function (): void {)
    $path = $tempDir.'/data.php';

    $result = $action->execute(['b' => 2], $path);

    expect($result)->toBeTrue()
        ->and(require $path)->toBe(['b' => 2]);
});

it('throws for unsupported format', function (): void {)
    $action->execute([], $this->tempDir.'/invalid.txt', 'xml');
})->throws(InvalidArgumentException::class, 'Formato non supportato');
