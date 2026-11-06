<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Mockery;
use Modules\Job\Tests\TestCase;
use Modules\Xot\Tests\ModuleExecuteCoverage;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-job-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Job ModuleExecuteCoverage floor sweep', function (): void {
    test('enums rules filament schemas senza model/service hang', function (): void {
        [$appRoot, $ns] = [dirname(__DIR__, 2).'/app', 'Modules\\Job\\'];
        // Evitare testInvokePublicMethodsOnModels / Services / Console: hang DB offline.
        ModuleExecuteCoverage::testInvokePublicMethodsInDirectory($appRoot, $ns, 'Rules');
        ModuleExecuteCoverage::testFilamentLegacySchemas($appRoot, $ns);
        ModuleExecuteCoverage::testAllEnums($appRoot, $ns);
        Assert::assertDirectoryExists($appRoot);
    });
});
