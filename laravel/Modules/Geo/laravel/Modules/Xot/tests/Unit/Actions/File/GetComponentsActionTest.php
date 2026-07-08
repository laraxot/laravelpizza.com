<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\GetComponentsAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;

uses(TestCase::class);

it('gets and caches components correctly', function (): void {
    $tempDir = sys_get_temp_dir().'/test_comps_'.uniqid();
    File::makeDirectory($tempDir);

    $compPath = $tempDir.'/TestComp.php';
    $compContent = "namespace My\Test\Comps;
class TestComp {}";
    File::put($compPath, $compContent);

    if (! class_exists('My\Test\Comps\TestComp')) {
        eval("namespace My\Test\Comps; class TestComp {}");
    }

    $action = app(GetComponentsAction::class);
    $result = $action->execute($tempDir, 'My/Test/Comps', 'prefix-');

    Assert::assertInstanceOf(DataCollection::class, $result);
    Assert::assertSame(1, $result->count());
    $first = $result->first();
    Assert::assertNotNull($first);
    Assert::assertSame('prefix-test-comp', $first->name);
    $jsonCache = $tempDir.'/_components.json';
    Assert::assertTrue(File::exists($jsonCache));
    $result2 = $action->execute($tempDir, 'My/Test/Comps', 'prefix-');
    Assert::assertSame(1, $result2->count());
    File::deleteDirectory($tempDir);
});

it('skips abstract classes', function (): void {
    $tempDir = sys_get_temp_dir().'/test_comps_abstract_'.uniqid();
    File::makeDirectory($tempDir);

    $compPath = $tempDir.'/AbstractComp.php';
    File::put($compPath, "namespace My\Test\Comps; abstract class AbstractComp {}");

    if (! class_exists('My\Test\Comps\AbstractComp')) {
        eval("namespace My\Test\Comps; abstract class AbstractComp {}");
    }

    $action = app(GetComponentsAction::class);
    $result = $action->execute($tempDir, 'My/Test/Comps', 'prefix-');

    Assert::assertSame(0, $result->count());
    File::deleteDirectory($tempDir);
});
