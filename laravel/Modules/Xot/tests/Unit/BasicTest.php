<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\UI\Models\Asset;

uses(TestCase::class)->in(__DIR__);

it('basic test works', function () {
    $this->assertTrue(true);
});

it('can create a test asset', function () {
    $asset = Asset::factory()->create([
        'name' => 'Test Asset',
        'path' => '/test/path',
    ]);

    expect($asset)->toBeInstanceOf(Asset::class);
    expect($asset->name)->toBe('Test Asset');
    expect($asset->path)->toBe('/test/path');
});
