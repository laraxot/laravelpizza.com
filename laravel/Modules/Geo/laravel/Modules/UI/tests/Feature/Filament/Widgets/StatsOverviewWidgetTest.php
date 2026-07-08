<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as FilamentStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\UI\Filament\Widgets\StatsOverviewWidget;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

test('stats overview widget extends correct base class', function (): void {
    $widget = new StatsOverviewWidget();
    Assert::assertInstanceOf(FilamentStatsOverviewWidget::class, $widget);
});

test('stats overview widget has correct namespace', function (): void {
    Assert::assertStringContainsString('Modules\\UI\\Filament\\Widgets', StatsOverviewWidget::class);
});

test('stats overview widget has getStats method', function (): void {
    $widget = new StatsOverviewWidget();
    $reflection = new \ReflectionClass($widget);
    Assert::assertTrue($reflection->hasMethod('getStats'));
});

test('stats overview widget returns correct stats', function (): void {
    $widget = new StatsOverviewWidget();
    $reflection = new \ReflectionClass($widget);
    $method = $reflection->getMethod('getStats');
    Assert::assertTrue($method->isProtected());

    $method->setAccessible(true);
    $stats = $method->invoke($widget);

    Assert::assertIsArray($stats);
    foreach ($stats as $stat) {
        Assert::assertInstanceOf(Stat::class, $stat);
    }
});

test('stats overview widget can be instantiated', function (): void {
    $widget = new StatsOverviewWidget();
    Assert::assertInstanceOf(StatsOverviewWidget::class, $widget);
});

test('stats overview widget has correct strict types declaration', function (): void {
    $reflection = new \ReflectionClass(StatsOverviewWidget::class);
    $filename = $reflection->getFileName();

    if (false !== $filename) {
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    }
});

test('stats overview widget getStats method is protected', function (): void {
    $reflection = new \ReflectionClass(StatsOverviewWidget::class);
    $getStatsMethod = $reflection->getMethod('getStats');
    Assert::assertTrue($getStatsMethod->isProtected());
});

test('stats overview widget getStats method has correct return type', function (): void {
    $reflection = new \ReflectionClass(StatsOverviewWidget::class);
    $getStatsMethod = $reflection->getMethod('getStats');
    $returnType = $getStatsMethod->getReturnType();

    Assert::assertNotNull($returnType);
    Assert::assertSame('array', $returnType instanceof \ReflectionNamedType ? $returnType->getName() : (string) $returnType);
});

test('stats overview widget has correct use statements', function (): void {
    $reflection = new \ReflectionClass(StatsOverviewWidget::class);
    $filename = $reflection->getFileName();

    if (false !== $filename) {
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('use Filament\\Widgets\\StatsOverviewWidget as BaseWidget;', $content);
    }
});
