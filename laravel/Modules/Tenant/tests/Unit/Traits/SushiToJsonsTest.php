<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsCoverageModel;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    $directory = storage_path('tests/sushi-jsons');
    File::deleteDirectory($directory);
    File::makeDirectory($directory, 0755, true, true);

    TestCase::$testDirectory = $directory;
    File::put($directory.'/1.json', json_encode(['id' => 1, 'name' => 'From JSON 1', 'meta' => 'file-1']));
    File::put($directory.'/2.json', json_encode(['id' => 2, 'name' => 'From JSON 2', 'meta' => 'file-2']));

    $contentRoot = $directory;
    $mock = Mockery::mock(GetTenantFilePathAction::class);
    // allows(['execute' => $closure]) restituirebbe la closure; andReturnUsing la esegue.
    TestCase::expectMockery($mock, 'execute')->andReturnUsing(
        static function (string $filename) use ($contentRoot): string {
            if (str_starts_with($filename, 'database/content/sushi_jsons_coverage')) {
                return $contentRoot;
            }

            return $contentRoot.'/'.$filename;
        }
    );
    app()->instance(GetTenantFilePathAction::class, $mock);

    config(['sushi.cache-path' => $directory]);

    // Dopo il mock: flushEventListeners() fa `new static`, e il boot di Sushi legge i json.
    SushiToJsonsCoverageModel::flushEventListeners();
    Model::clearBootedModels();
});

afterEach(function (): void {
    File::deleteDirectory(TestCase::$testDirectory);
    Mockery::close();
});

it('merges rows from multiple json files', function (): void {
    $rows = (new SushiToJsonsCoverageModel)->getSushiRows();

    Assert::assertCount(2, $rows);
    Assert::assertSame('From JSON 1', $rows[0]['name']);
    Assert::assertSame('file-2', $rows[1]['meta']);
});

it('queries merged json sushi data', function (): void {
    $fromFile1 = SushiToJsonsCoverageModel::query()->where('meta', 'file-1')->get();

    Assert::assertCount(1, $fromFile1);
});

it('finds row by id across json files', function (): void {
    $found = SushiToJsonsCoverageModel::query()->find(2);

    Assert::assertNotNull($found);
    Assert::assertSame('From JSON 2', $found->name);
});

it('returns empty rows when json directory has no files', function (): void {
    File::deleteDirectory(TestCase::$testDirectory);
    File::makeDirectory(TestCase::$testDirectory, 0755, true, true);

    $rows = (new SushiToJsonsCoverageModel)->getSushiRows();

    Assert::assertSame([], $rows);
});

// Un tenant senza `database/content/<tabella>` non ha righe. Il commit upstream 33465888 aveva tolto il
// controllo e File::allFiles() lanciava DirectoryNotFoundException al primo uso del modello (Cms Menu e
// Page in locale): story sushi-to-jsons-single-source-cleanup.
it('returns empty rows when json directory does not exist', function (): void {
    File::deleteDirectory(TestCase::$testDirectory);

    $rows = (new SushiToJsonsCoverageModel)->getSushiRows();

    Assert::assertSame([], $rows);
});
