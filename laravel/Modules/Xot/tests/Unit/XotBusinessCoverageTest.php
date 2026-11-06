<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Mockery;
use Modules\Xot\Tests\ModuleBusinessCoverage;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

/** @return array{string, string} */
/** @return list{string, string} */
function xotBusinessContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Xot\\'];
}

describe('Xot business coverage', function (): void {
    test('all policies execute authorization methods', function (): void {
        [$appRoot, $ns] = xotBusinessContext();
        ModuleBusinessCoverage::testAllPolicies($appRoot, $ns);
    });

    test('all models expose table and fillable', function (): void {
        [$appRoot, $ns] = xotBusinessContext();
        ModuleBusinessCoverage::testAllModels($appRoot, $ns);
    });

    test('all actions are resolvable', function (): void {
        [$appRoot, $ns] = xotBusinessContext();
        ModuleBusinessCoverage::testAllActions($appRoot, $ns);
    });

    test('all datas are loadable', function (): void {
        [$appRoot, $ns] = xotBusinessContext();
        ModuleBusinessCoverage::testAllDatas($appRoot, $ns);
    });
});
