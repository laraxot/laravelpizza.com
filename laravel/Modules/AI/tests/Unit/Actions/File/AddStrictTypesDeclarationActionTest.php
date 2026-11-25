<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\AddStrictTypesDeclarationAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// $this dentro le closure Pest e' tipizzato da Pest come TestCall (vedi
// @param-closure-this in vendor/pestphp/pest/src/Functions.php), non come
// Modules\Xot\Tests\TestCase: PHPStan vieta di ritipizzare $this via @var,
// quindi la working dir del test vive in una variabile locale condivisa per riferimento.
$workDir = '';

beforeEach(function () use (&$workDir): void {
    $workDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'test_strict_types_'.uniqid();
    File::makeDirectory($workDir, 0755, true);
});

afterEach(function () use (&$workDir): void {
    if (File::isDirectory($workDir)) {
        File::deleteDirectory($workDir);
    }
});

describe('Add Strict Types Declaration Action', function () use (&$workDir): void {
    test('adds strict types declaration to php file', function () use (&$workDir): void {
        $file = $workDir.'/test.php';
        File::put($file, "<?php\n\nnamespace Test;\n\nclass TestClass {}");

        app(AddStrictTypesDeclarationAction::class)->execute($file);

        $content = File::get($file);
        Assert::assertIsString($content);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('does not duplicate strict types if already present', function () use (&$workDir): void {
        $file = $workDir.'/test.php';
        File::put($file, "<?php\n\n\n\nnamespace Test;");

        app(AddStrictTypesDeclarationAction::class)->execute($file);

        $content = File::get($file);
        Assert::assertIsString($content);
        Assert::assertSame(1, substr_count($content, 'declare(strict_types=1)'));
    });

    test('handles file with existing namespace', function () use (&$workDir): void {
        $file = $workDir.'/test.php';
        File::put($file, "<?php\n\n\n\nclass TestAction {}");

        app(AddStrictTypesDeclarationAction::class)->execute($file);

        $content = File::get($file);
        Assert::assertIsString($content);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
        Assert::assertStringContainsString('class TestAction {}', $content);
    });
});
