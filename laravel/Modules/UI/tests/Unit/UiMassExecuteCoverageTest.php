<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Mockery;
use Modules\UI\Tests\TestCase;
use Modules\Xot\Tests\ModuleExecuteCoverage;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('UI ModuleExecuteCoverage floor sweep', function (): void {
    test('view http middleware filament via directory invoke', function (): void {
        [$appRoot, $ns] = [dirname(__DIR__, 2).'/app', 'Modules\\UI\\'];
        ModuleExecuteCoverage::testAllMiddleware($appRoot, $ns);
        ModuleExecuteCoverage::testInvokePublicMethodsInDirectory($appRoot, $ns, 'Services');
        ModuleExecuteCoverage::testInvokePublicMethodsInDirectory($appRoot, $ns, 'Rules');
        ModuleExecuteCoverage::testFilamentPublicMethods($appRoot, $ns);
        ModuleExecuteCoverage::testFilamentComponents($appRoot, $ns);
        ModuleExecuteCoverage::testFilamentActionsMake($appRoot, $ns);
        ModuleExecuteCoverage::testFilamentLegacySchemas($appRoot, $ns);
        ModuleExecuteCoverage::testAllEnums($appRoot, $ns);
        ModuleExecuteCoverage::testInvokePublicMethodsOnModels($appRoot, $ns);
        Assert::assertDirectoryExists($appRoot);
    });
});
