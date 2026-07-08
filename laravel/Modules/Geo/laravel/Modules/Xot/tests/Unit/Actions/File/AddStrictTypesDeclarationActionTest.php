<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\AddStrictTypesDeclarationAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Xot\Tests\TestCase $this */
    $this->action = app(AddStrictTypesDeclarationAction::class);
    $this->workDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test_strict_types_'.uniqid();
    assert(is_string($this->workDir));
    File::makeDirectory($this->workDir, 0755, true);
});

afterEach(function (): void {
    /* @var \Modules\Xot\Tests\TestCase $this */
    assert(is_string($this->workDir));
    if (File::isDirectory($this->workDir)) {
        File::deleteDirectory($this->workDir);
    }
});

describe('Add Strict Types Declaration Action', function (): void {
    test('adds strict types declaration to php file', function (): void {
        /** @var TestCase $this */
        $file = $this->workDir.'/test.php';
        Assert::assertIsString($this->workDir);
        File::put($file, "<?php\n\nnamespace Test;\n\nclass TestClass {}");

        app(AddStrictTypesDeclarationAction::class)->execute($file);

        $content = File::get($file);
        Assert::assertIsString($content);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('does not duplicate strict types if already present', function (): void {
        /** @var TestCase $this */
        $file = $this->workDir.'/test.php';
        Assert::assertIsString($this->workDir);
        File::put($file, "<?php\n\n\n\nnamespace Test;");

        app(AddStrictTypesDeclarationAction::class)->execute($file);

        $content = File::get($file);
        Assert::assertIsString($content);
        Assert::assertSame(1, substr_count($content, 'declare(strict_types=1)'));
    });

    test('handles file with existing namespace', function (): void {
        /** @var TestCase $this */
        $file = $this->workDir.'/test.php';
        Assert::assertIsString($this->workDir);
        File::put($file, "<?php\n\n\n\nclass TestAction {}");

        app(AddStrictTypesDeclarationAction::class)->execute($file);

        $content = File::get($file);
        Assert::assertIsString($content);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
        Assert::assertStringContainsString('class TestAction {}', $content);
    });
});
