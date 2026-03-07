<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Tenant\Tests\TestCase;
use Symfony\Component\Finder\SplFileInfo;

uses(TestCase::class);

it('gets tenant config names', function (): void {
    $action = app(GetTenantConfigNamesAction::class);

    // We can't easily mock config_path() as it's a global helper,
    // but we can mock File::files()
    $file1 = mock(SplFileInfo::class);
    $file1->shouldReceive('getExtension')->andReturn('php');
    $file1->shouldReceive('getFilenameWithoutExtension')->andReturn('database');

    $file2 = mock(SplFileInfo::class);
    $file2->shouldReceive('getExtension')->andReturn('php');
    $file2->shouldReceive('getFilenameWithoutExtension')->andReturn('app');

    $file3 = mock(SplFileInfo::class);
    $file3->shouldReceive('getExtension')->andReturn('txt'); // Should be filtered out

    File::shouldReceive('files')->andReturn([$file1, $file2, $file3]);

    $result = $action->execute();

    expect($result)->toBeArray()
        ->toHaveCount(2)
        ->and($result[0])->toBe(['id' => 1, 'name' => 'database'])
        ->and($result[1])->toBe(['id' => 2, 'name' => 'app']);
});
