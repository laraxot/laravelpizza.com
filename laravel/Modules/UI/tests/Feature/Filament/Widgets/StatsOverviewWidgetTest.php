<?php

declare(strict_types=1);

use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\UI\Filament\Widgets\StatsOverviewWidget;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function (): void {
    $this->widget = new StatsOverviewWidget();
});

test('stats overview widget extends correct base class', function (): void {
    expect($this->widget)->toBeInstanceOf(Filament\Widgets\StatsOverviewWidget::class);
});

test('stats overview widget has correct namespace', function (): void {
    expect(StatsOverviewWidget::class)->toContain('Modules\UI\Filament\Widgets');
});

test('stats overview widget has getStats method', function (): void {
    $reflection = new ReflectionClass($this->widget);
    $this->assertTrue($reflection->hasMethod('getStats'));
});

test('stats overview widget returns correct stats', function (): void {
    $reflection = new ReflectionClass($this->widget);
    $method = $reflection->getMethod('getStats');
    $this->assertTrue($method->isProtected());

    // Filament widgets are Livewire components; invoking protected methods directly via magic can fail.
    // Use reflection to safely call the method for a smoke test.
    $method->setAccessible(true);
    $stats = $method->invoke($this->widget);

    $this->assertIsArray($stats);

    foreach ($stats as $stat) {
        $this->assertInstanceOf(Stat::class, $stat);
    }
});

test('stats overview widget stats are instances of Stat class', function (): void {
    $reflection = new ReflectionClass($this->widget);
    $method = $reflection->getMethod('getStats');
    $method->setAccessible(true);
    $stats = $method->invoke($this->widget);

    foreach ($stats as $stat) {
        expect($stat)->toBeInstanceOf(Stat::class);
    }
});

test('stats overview widget can be instantiated', function (): void {
    expect($this->widget)->toBeInstanceOf(StatsOverviewWidget::class);
});

test('stats overview widget has correct strict types declaration', function (): void {
    $reflection = new ReflectionClass(StatsOverviewWidget::class);
    $filename = $reflection->getFileName();

    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    }
});

test('stats overview widget getStats method is protected', function (): void {
    $reflection = new ReflectionClass(StatsOverviewWidget::class);
    $getStatsMethod = $reflection->getMethod('getStats');

    expect($getStatsMethod->isProtected())->toBeTrue();
});

test('stats overview widget getStats method has correct return type', function (): void {
    $reflection = new ReflectionClass(StatsOverviewWidget::class);
    $getStatsMethod = $reflection->getMethod('getStats');

    $returnType = $getStatsMethod->getReturnType();
    if (null !== $returnType) {
        expect($returnType->getName())->toBe('array');
    }
});

test('stats overview widget has correct use statements', function (): void {
    $reflection = new ReflectionClass(StatsOverviewWidget::class);
    $filename = $reflection->getFileName();

    if ($filename) {
        $content = file_get_contents($filename);
        expect($content)->toContain('use Filament\Widgets\StatsOverviewWidget as BaseWidget;');
    }
});
