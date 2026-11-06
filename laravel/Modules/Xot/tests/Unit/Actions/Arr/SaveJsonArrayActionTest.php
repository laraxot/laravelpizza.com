<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Arr;

use Modules\Xot\Actions\Arr\SaveJsonArrayAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\json_decode;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

uses(TestCase::class);

// $this dentro le closure Pest e' tipizzato da Pest come TestCall, non come
// Modules\Xot\Tests\TestCase: PHPStan vieta di ritipizzare $this via @var, quindi
// la temp dir del test vive in una variabile locale condivisa per riferimento.
$tempDir = '';

beforeEach(function () use (&$tempDir): void {
    $tempDir = sys_get_temp_dir().'/xot_arr_'.uniqid();
    mkdir($tempDir, 0755, true);
});

afterEach(function () use (&$tempDir): void {
    if ($tempDir !== '' && is_dir($tempDir)) {
        $files = glob($tempDir.'/*');
        foreach ($files as $file) {
            Assert::assertIsString($file);
            unlink($file);
        }
        rmdir($tempDir);
    }
});

describe('Save Json Array Action', function () use (&$tempDir): void {
    test('saves array to json file', function () use (&$tempDir): void {
        $data = ['key' => 'value', 'nested' => ['a' => 1]];
        $path = $tempDir.'/data.json';

        $result = app(SaveJsonArrayAction::class)->execute($data, $path);

        Assert::assertTrue($result);
        Assert::assertSame($data, json_decode(file_get_contents($path), true));
    });

    test('saves empty array', function () use (&$tempDir): void {
        $path = $tempDir.'/empty.json';
        $result = app(SaveJsonArrayAction::class)->execute([], $path);

        Assert::assertTrue($result);
        Assert::assertSame([], json_decode(file_get_contents($path), true));
    });
});
