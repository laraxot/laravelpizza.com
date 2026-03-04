<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\GetClassNameByPathAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(GetClassNameByPathAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_class_name_by_path_'.uniqid('', true);
    mkdir($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (is_dir($this->tempDir)) {
        array_map('unlink', glob($this->tempDir.'/*') ?: []);
        rmdir($this->tempDir);
    }
});

it('extracts fully-qualified class name from file contents', function (): void {
    $path = $this->tempDir.'/User.php';
    file_put_contents($path, "<?php\nnamespace App\\Models;\nclass User {}\n");
    $result = $this->action->execute($path);

    expect($result)->toBe('App\\Models\\User');
});

it('extracts class name when namespace is missing', function (): void {
    $path = $this->tempDir.'/Simple.php';
    file_put_contents($path, "<?php\nclass Simple {}\n");
    $result = $this->action->execute($path);

    expect($result)->toBe('Simple');
});

it('throws when path does not exist', function (): void {
    $this->action->execute($this->tempDir.'/Missing.php');
})->throws(ErrorException::class);

it('handles nested namespaces', function (): void {
    $path = $this->tempDir.'/UserController.php';
    file_put_contents($path, "<?php\nnamespace App\\Http\\Controllers\\Api\\V1;\nclass UserController {}\n");
    $result = $this->action->execute($path);

    expect($result)->toBe('App\\Http\\Controllers\\Api\\V1\\UserController');
});
