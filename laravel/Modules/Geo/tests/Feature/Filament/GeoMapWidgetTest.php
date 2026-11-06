<?php

declare(strict_types=1);

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

use function Safe\file_get_contents;

test('geo map widget blade renders dataset powered custom element without inline asset tag', function (): void {
    $html = file_get_contents(__DIR__.'/../../../resources/views/filament/widgets/geo-map-widget.blade.php');

    Assert::assertStringContainsString('farmshops.eu Replica', $html);
    Assert::assertStringContainsString('<geo-map-widget', $html);
    Assert::assertStringContainsString('data-config=', $html);
    Assert::assertStringContainsString('data-dataset=', $html);
    Assert::assertStringContainsString('geo-map-widget.js', $html);
});

test('geo map widget uses the expected blade view', function (): void {
    $widget = new GeoMapWidget();
    $reflection = new ReflectionClass($widget);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    Assert::assertSame('geo::filament.widgets.geo-map-widget', $property->getValue($widget));
});
