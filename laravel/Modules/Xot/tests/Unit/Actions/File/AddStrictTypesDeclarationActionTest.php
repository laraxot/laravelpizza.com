<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\AddStrictTypesDeclarationAction;

beforeEach(function (): void {
    $this->action = app(AddStrictTypesDeclarationAction::class);
    $this->tempDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test_strict_types_'.uniqid();
    File::makeDirectory($this->tempDir, 0755, true);
});

afterEach(function (): void {
    if (File::isDirectory($this->tempDir)) {
        File::deleteDirectory($this->tempDir);
    }
});

it('adds strict types declaration to php file', function (): void {
    $file = $this->tempDir.'/test.php';
    File::put($file, "<?php\n\nnamespace Test;\n\nclass TestClass {}");

    $this->action->execute($file);

    $content = File::get($file);
    expect($content)->toContain('declare(strict_types=1)');
});

it('does not duplicate strict types if already present', function (): void {
    $file = $this->tempDir.'/test.php';
    File::put($file, "<?php\n\n\n\nnamespace Test;");

    $this->action->execute($file);

    $content = File::get($file);
    expect(substr_count($content, 'declare(strict_types=1)'))->toBe(1);
});

it('handles file with existing namespace', function (): void {
    $file = $this->tempDir.'/test.php';
    File::put($file, "<?php\n\n\n\nclass TestAction {}");

    $this->action->execute($file);

    $content = File::get($file);
    expect($content)->toContain('declare(strict_types=1)')
        ->and($content)->toContain('
});
