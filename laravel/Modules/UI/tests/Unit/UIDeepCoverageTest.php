<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Tests\TestCase;
use Modules\Xot\Tests\ModuleDeepCoverage;

uses(TestCase::class);

/** @return list{string, string} */
function uiDeepContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\UI\\'];
}

describe('UI deep coverage', function (): void {
    test('all actions execute method is invoked', function (): void {
        [$appRoot, $ns] = uiDeepContext();
        ModuleDeepCoverage::testExecuteAllActions($appRoot, $ns);
    });

    test('all events are instantiable', function (): void {
        [$appRoot, $ns] = uiDeepContext();
        ModuleDeepCoverage::testInstantiateAllEvents($appRoot, $ns);
    });

    test('all datas from or construct', function (): void {
        [$appRoot, $ns] = uiDeepContext();
        ModuleDeepCoverage::testFromAllDatas($appRoot, $ns);
    });

    test('providers register without fatal', function (): void {
        [$appRoot, $ns] = uiDeepContext();
        ModuleDeepCoverage::testRegisterAllProviders($appRoot, $ns);
    });

    test('filament columns and widgets instantiate', function (): void {
        [$appRoot, $ns] = uiDeepContext();
        ModuleDeepCoverage::testInstantiateFilamentColumns($appRoot, $ns);
    });
});
