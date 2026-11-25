<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\ModuleDeepCoverage;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class)->group('no-xot-db');

/** @return array{string, string} */
/** @return list{string, string} */
function xotDeepContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Xot\\'];
}

describe('Xot deep coverage', function (): void {
    test('all actions execute method is invoked', function (): void {
        [$appRoot, $ns] = xotDeepContext();
        ModuleDeepCoverage::testExecuteAllActions($appRoot, $ns);
    });

    test('all events are instantiable', function (): void {
        [$appRoot, $ns] = xotDeepContext();
        ModuleDeepCoverage::testInstantiateAllEvents($appRoot, $ns);
    });

    test('all datas from or construct', function (): void {
        [$appRoot, $ns] = xotDeepContext();
        ModuleDeepCoverage::testFromAllDatas($appRoot, $ns);
    });

    test('providers register without fatal', function (): void {
        [$appRoot, $ns] = xotDeepContext();
        ModuleDeepCoverage::testRegisterAllProviders($appRoot, $ns);
    });

    test('filament columns and widgets instantiate', function (): void {
        [$appRoot, $ns] = xotDeepContext();
        ModuleDeepCoverage::testInstantiateFilamentColumns($appRoot, $ns);
    });
});
