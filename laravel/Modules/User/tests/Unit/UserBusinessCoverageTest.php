<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Tests\TestCase;
use Modules\Xot\Tests\ModuleBusinessCoverage;

uses(TestCase::class)->group('no-user-db');

afterEach(function (): void {
    \Mockery::close();
});

/** @return array{string, string} */
/** @return list{string, string} */
function userBusinessContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\User\\'];
}

describe('User business coverage', function (): void {
    test('all policies execute authorization methods', function (): void {
        [$appRoot, $ns] = userBusinessContext();
        ModuleBusinessCoverage::testAllPolicies($appRoot, $ns);
    });

    test('all models expose table and fillable', function (): void {
        [$appRoot, $ns] = userBusinessContext();
        ModuleBusinessCoverage::testAllModels($appRoot, $ns);
    });

    test('all actions are resolvable', function (): void {
        [$appRoot, $ns] = userBusinessContext();
        ModuleBusinessCoverage::testAllActions($appRoot, $ns);
    });

    test('all datas are loadable', function (): void {
        [$appRoot, $ns] = userBusinessContext();
        ModuleBusinessCoverage::testAllDatas($appRoot, $ns);
    });
});
