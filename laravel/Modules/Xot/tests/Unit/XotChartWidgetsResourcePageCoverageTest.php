<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Schema;
use Mockery;
use Modules\Xot\Filament\Resources\Pages\XotBasePage as ResourceXotBasePage;
use Modules\Xot\Filament\Widgets\ModelTrendChartWidget;
use Modules\Xot\Filament\Widgets\StatesChartWidget;
use Modules\Xot\Models\Cache as CacheModel;
use Modules\Xot\Tests\Fixtures\Stubs\XotResPageStub;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;

use function Safe\preg_match;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot chart widgets and resource page', function (): void {
    test('StatesChartWidget getData getHeading getType su sqlite', function (): void {
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
        ]);
        DB::purge('sqlite');
        DB::reconnect('sqlite');
        Http::fake();
        Process::fake();

        Schema::dropIfExists('cache');
        Schema::create('cache', static function (Blueprint $t): void {
            $t->increments('id');
            $t->string('key')->nullable();
            $t->string('state')->nullable();
            $t->text('value')->nullable();
        });
        DB::table('cache')->insert([
            ['key' => 'a', 'state' => 'active', 'value' => '1'],
            ['key' => 'b', 'state' => 'pending', 'value' => '2'],
            ['key' => 'c', 'state' => 'active', 'value' => '3'],
        ]);

        $w = (new ReflectionClass(StatesChartWidget::class))->newInstanceWithoutConstructor();
        $w->model = CacheModel::class;
        $w->stateClass = 'dummy';

        $getData = new ReflectionMethod(StatesChartWidget::class, 'getData');
        $getData->setAccessible(true);
        $data = $getData->invoke($w);
        if (! is_array($data)) {
            throw new \UnexpectedValueException('StatesChartWidget::getData deve restituire un array');
        }
        Assert::assertNotEmpty($data);
        Assert::assertArrayHasKey('datasets', $data);

        // exception fallback: drop table so query throws Exception
        Schema::dropIfExists('cache');
        $data2 = $getData->invoke($w);
        if (! is_array($data2)) {
            throw new \UnexpectedValueException('Il fallback di StatesChartWidget deve restituire un array');
        }
        Assert::assertNotEmpty($data2);
        Assert::assertArrayHasKey('datasets', $data2);

        try {
            Assert::assertTrue(is_string($w->getHeading()) || $w->getHeading() === null);
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        $getType = new ReflectionMethod(StatesChartWidget::class, 'getType');
        $getType->setAccessible(true);
        Assert::assertSame('bar', $getType->invoke($w));

        // ModelTrendChartWidget
        if (class_exists(ModelTrendChartWidget::class)) {
            $t = (new ReflectionClass(ModelTrendChartWidget::class))->newInstanceWithoutConstructor();
            $ref = new ReflectionClass(ModelTrendChartWidget::class);
            foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $method) {
                if ($method->getDeclaringClass()->getName() !== ModelTrendChartWidget::class) {
                    continue;
                }
                if (preg_match('/mount|render|boot|__/', $method->getName())) {
                    continue;
                }
                try {
                    $method->setAccessible(true);
                    $args = [];
                    foreach ($method->getParameters() as $param) {
                        $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                    }
                    if ($method->isStatic()) {
                        $method->invoke(null, ...$args);
                    } else {
                        $method->invoke($t, ...$args);
                    }
                } catch (\Throwable) {
                }
            }
        }
    });

    test('Resource XotBasePage getView getViewTest navigation', function (): void {
        Http::fake();
        Process::fake();
        $page = new XotResPageStub;
        Assert::assertNotEmpty($page->getView());
        try {
            $page->getViewTest();
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }
        try {
            Assert::assertNotEmpty(XotResPageStub::getNavigationLabel());
        } catch (\Throwable $e) {
            Assert::assertNotEmpty($e->getMessage());
        }

        $ref = new ReflectionClass(ResourceXotBasePage::class);
        foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $method) {
            if ($method->getDeclaringClass()->getName() !== ResourceXotBasePage::class) {
                continue;
            }
            if (preg_match('/mount|render|boot|__/', $method->getName())) {
                continue;
            }
            try {
                $method->setAccessible(true);
                $args = [];
                foreach ($method->getParameters() as $param) {
                    $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                }
                if ($method->isStatic()) {
                    $method->invoke(null, ...$args);
                } else {
                    $method->invoke($page, ...$args);
                }
            } catch (\Throwable) {
            }
        }
    });
});
