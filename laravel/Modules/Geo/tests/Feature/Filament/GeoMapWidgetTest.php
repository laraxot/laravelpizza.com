<?php

declare(strict_types=1);

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

use function Safe\file_get_contents;

test('geo map widget blade renders dataset powered custom element without inline asset tag', function (): void {
    $html = file_get_contents(__DIR__.'/../../../resources/views/filament/widgets/geo-map-widget.blade.php');

    // The title text moved to lang/*/geo_map_widget.php ("farmshops.eu Replica" in it/en).
    Assert::assertStringContainsString("__('geo::geo_map_widget.sections.title.title')", $html);
    Assert::assertStringContainsString('<geo-map-widget', $html);
    Assert::assertStringContainsString('data-config=', $html);
    Assert::assertStringContainsString('data-dataset=', $html);
    // geo-map-widget.js is bundled by the module assets, never injected inline by the Blade.
    Assert::assertStringNotContainsString('<script', $html);
    Assert::assertStringNotContainsString('geo-map-widget.js', $html);
    /** @var array{sections: array{title: array{title: string}}} $lang */
    $lang = require __DIR__.'/../../../lang/en/geo_map_widget.php';
    Assert::assertSame('farmshops.eu Replica', $lang['sections']['title']['title']);
});

test('geo map widget uses the expected blade view', function (): void {
    $widget = new GeoMapWidget;
    $reflection = new ReflectionClass($widget);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    Assert::assertSame('geo::filament.widgets.geo-map-widget', $property->getValue($widget));
});
