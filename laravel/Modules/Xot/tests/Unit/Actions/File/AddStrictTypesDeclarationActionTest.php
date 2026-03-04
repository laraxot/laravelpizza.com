<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\AddStrictTypesDeclarationAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(AddStrictTypesDeclarationAction::class);
    $this->tempDir = sys_get_temp_dir().'/xot_strict_types_test_'.uniqid();
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
    File::put($file, "<?php\n\ndeclare(strict_types=1);\n\nnamespace Test;");

    $this->action->execute($file);

    $content = File::get($file);
    expect(substr_count($content, 'declare(strict_types=1)'))->toBe(1);
});

it('handles file with existing namespace', function (): void {
    $file = $this->tempDir.'/test.php';
    File::put($file, "<?php\n\nnamespace Modules\\Xot\\Actions;\n\nclass TestAction {}");

    $this->action->execute($file);

    $content = File::get($file);
    expect($content)->toContain('declare(strict_types=1)')
        ->and($content)->toContain('namespace Modules\\Xot\\Actions');
});
