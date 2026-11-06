<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Tenant model resolution via config files', function (): void {
    afterEach(function (): void {
        if (TestCase::$testDirectory !== '' && File::exists(TestCase::$testDirectory)) {
            File::deleteDirectory(TestCase::$testDirectory);
        }
        Mockery::close();
    });

    it('loads tenant-specific models config array', function (): void {
        $directory = storage_path('tests/tenant-config');
        File::deleteDirectory($directory);
        File::makeDirectory($directory, 0755, true, true);
        TestCase::$testDirectory = $directory;

        $configPath = $directory.'/models.php';
        File::put($configPath, "<?php return ['user' => 'App\\\\Models\\\\CustomUser'];");

        $mock = Mockery::mock(GetTenantFilePathAction::class);
        $mock->allows(['execute' => $configPath]);
        app()->instance(GetTenantFilePathAction::class, $mock);

        $config = app(GetTenantConfigArrayAction::class)->execute('models');

        Assert::assertArrayHasKey('user', $config);
        Assert::assertSame('App\\Models\\CustomUser', $config['user']);
    });

    it('returns empty array when config file is missing', function (): void {
        $mock = Mockery::mock(GetTenantFilePathAction::class);
        $mock->allows(['execute' => storage_path('tests/missing-config.php')]);
        app()->instance(GetTenantFilePathAction::class, $mock);

        $config = app(GetTenantConfigArrayAction::class)->execute('missing');

        Assert::assertSame([], $config);
    });
});
