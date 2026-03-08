<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\File;

use Illuminate\Support\Facades\File;
use Modules\Xot\Actions\File\GetComponentsAction;
use Spatie\LaravelData\DataCollection;

it('gets and caches components correctly', function (): void {
    $tempDir = sys_get_temp_dir().'/test_comps_'.uniqid();
    File::makeDirectory($tempDir);

    $compPath = $tempDir.'/TestComp.php';
    $compContent = "<?php

namespace My\Test\Comps;

class TestComp {}";
    File::put($compPath, $compContent);

    // We need the class to exist for reflection
    if (! class_exists('My\Test\Comps\TestComp')) {
        eval("namespace My\Test\Comps; class TestComp {}");
    }

    $action = app(GetComponentsAction::class);
    $result = $action->execute($tempDir, 'My/Test/Comps', 'prefix-');

    expect($result)->toBeInstanceOf(DataCollection::class);
    expect($result->count())->toBe(1);
    expect($result->first()->name)->toBe('prefix-test-comp');

    // Check if json cache was created
    $jsonCache = $tempDir.'/_components.json';
    expect(File::exists($jsonCache))->toBeTrue();

    // Test loading from cache
    $result2 = $action->execute($tempDir, 'My/Test/Comps', 'prefix-');
    expect($result2->count())->toBe(1);

    File::deleteDirectory($tempDir);
});

it('skips abstract classes', function (): void {
    $tempDir = sys_get_temp_dir().'/test_comps_abstract_'.uniqid();
    File::makeDirectory($tempDir);

    $compPath = $tempDir.'/AbstractComp.php';
    File::put($compPath, "<?php

namespace My\Test\Comps; abstract class AbstractComp {}");

    if (! class_exists('My\Test\Comps\AbstractComp')) {
        eval("namespace My\Test\Comps; abstract class AbstractComp {}");
    }

    $action = app(GetComponentsAction::class);
    $result = $action->execute($tempDir, 'My/Test/Comps', 'prefix-');

    expect($result->count())->toBe(0);

    File::deleteDirectory($tempDir);
});
