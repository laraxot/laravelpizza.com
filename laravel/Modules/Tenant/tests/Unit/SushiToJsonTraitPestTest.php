<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    if (! File::exists(TestCase::$testDirectory)) {
        File::makeDirectory(TestCase::$testDirectory, 0o755, true, true);
    }
});

afterEach(function (): void {
    /** @var TestCase $this */
    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
    }
});

it('uses isolated json path in testing environment', function (): void {
    /** @var TestCase $this */
    $path = $this->sushiModel()->getJsonFile();

    Assert::assertSame(TestCase::$testJsonPath, $path);
});

it('returns empty rows when json file is missing', function (): void {
    /** @var TestCase $this */
    $rows = $this->sushiModel()->getSushiRows();

    Assert::assertSame([], $rows);
});

it('loads rows from valid json file', function (): void {
    /** @var TestCase $this */
    $payload = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key1' => 'value1'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
    ];

    File::put(TestCase::$testJsonPath, json_encode($payload, JSON_PRETTY_PRINT));

    $rows = $this->sushiModel()->getSushiRows();

    Assert::assertCount(1, $rows);
    Assert::assertSame('Test Item 1', $rows[0]['name'] ?? null);
});

it('throws when json file is not an array', function (): void {
    /** @var TestCase $this */
    File::put(TestCase::$testJsonPath, json_encode('not-an-array'));

    XotBasePest::assertThrows(
        fn (): array => $this->sushiModel()->getSushiRows(),
        Exception::class
    );
});
