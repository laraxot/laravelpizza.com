<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Modules\Job\Actions\GetTaskFrequenciesAction;
use Modules\Job\Tests\TestCase;
use Modules\Xot\Tests\ModuleDeepCoverage;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-job-db');

/** @return array{0: string, 1: string} */
/** @return list{string, string} */
function jobDeepContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Job\\'];
}

describe('Job deep coverage — execute code paths', function (): void {
    test('GetTaskFrequenciesAction execute returns config array', function (): void {
        config(['totem.frequencies' => ['daily' => 'Daily']]);
        $result = (new GetTaskFrequenciesAction)->execute();
        Assert::assertSame(['daily' => 'Daily'], $result);
    });

    // testExecuteAllActions rimosso: hang illimitato (stesso anti-pattern Ptv/Xot).

    test('all events are instantiable', function (): void {
        [$appRoot, $ns] = jobDeepContext();
        ModuleDeepCoverage::testInstantiateAllEvents($appRoot, $ns);
    });

    test('all datas from or construct', function (): void {
        [$appRoot, $ns] = jobDeepContext();
        ModuleDeepCoverage::testFromAllDatas($appRoot, $ns);
    });

    test('providers register without fatal', function (): void {
        [$appRoot, $ns] = jobDeepContext();
        ModuleDeepCoverage::testRegisterAllProviders($appRoot, $ns);
    });

    test('filament columns and widgets instantiate', function (): void {
        [$appRoot, $ns] = jobDeepContext();
        ModuleDeepCoverage::testInstantiateFilamentColumns($appRoot, $ns);
    });
});
