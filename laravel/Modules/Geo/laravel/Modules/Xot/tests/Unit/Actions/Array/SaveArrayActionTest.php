<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Modules\Xot\Actions\Array\SaveArrayAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\glob;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

uses(TestCase::class);

/** @var string|null $arrayTestTempDir */
$arrayTestTempDir = null;

beforeEach(function () use (&$arrayTestTempDir): void {
    $arrayTestTempDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'pest_test_'.uniqid();
    if (! file_exists($arrayTestTempDir)) {
        mkdir($arrayTestTempDir, 0755, true);
    }
});

afterEach(function () use (&$arrayTestTempDir): void {
    if (! is_string($arrayTestTempDir) || ! file_exists($arrayTestTempDir)) {
        return;
    }

    foreach (glob($arrayTestTempDir.'/*') ?: [] as $file) {
        if (is_string($file)) {
            unlink($file);
        }
    }

    rmdir($arrayTestTempDir);
    $arrayTestTempDir = null;
});

describe('Save Array Action', function () use (&$arrayTestTempDir): void {
    test('saves array in json format', function () use (&$arrayTestTempDir): void {
        Assert::assertIsString($arrayTestTempDir);
        $path = $arrayTestTempDir.'/data.json';

        $result = app(SaveArrayAction::class)->execute(['a' => 1], $path, 'json');

        Assert::assertTrue($result);
    });

    test('saves array in php format by default', function () use (&$arrayTestTempDir): void {
        Assert::assertIsString($arrayTestTempDir);
        $path = $arrayTestTempDir.'/data.php';

        $result = app(SaveArrayAction::class)->execute(['b' => 2], $path);
        Assert::assertTrue($result);

        Assert::assertSame(['b' => 2], require $path);
    });

    test('throws for unsupported format', function () use (&$arrayTestTempDir): void {
        Assert::assertIsString($arrayTestTempDir);

        try {
            app(SaveArrayAction::class)->execute([], $arrayTestTempDir.'/invalid.txt', 'xml');
            Assert::fail('Expected exception not thrown');
        } catch (\InvalidArgumentException) {
            // Expected
        }
    });
});
