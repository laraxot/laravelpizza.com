<?php

declare(strict_types=1);

use Modules\Geo\Filament\Widgets\GeoMapWidget;
use Modules\Geo\Tests\LightTestCase;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

use function Safe\file_get_contents;

uses(LightTestCase::class);

test('geo map widget blade renders dataset powered custom element without inline asset tag', function (): void {
    $html = file_get_contents(__DIR__.'/../../../resources/views/filament/widgets/geo-map-widget.blade.php');

<<<<<<< HEAD
    expect($html)
        ->toContain('farmshops.eu Replica')
        ->toContain('<geo-map-widget')
        ->toContain('data-config=')
        ->toContain('data-dataset=')
        ->not->toContain('geo-map-widget.js');
=======
    Assert::assertStringContainsString('farmshops.eu Replica', $html);
    Assert::assertStringContainsString('<geo-map-widget', $html);
    Assert::assertStringContainsString('data-config=', $html);
    Assert::assertStringContainsString('data-dataset=', $html);
    Assert::assertStringContainsString('geo-map-widget.js', $html);
>>>>>>> 40b96bcd6 (.)
});

test('geo map widget uses the expected blade view', function (): void {
    $widget = new GeoMapWidget();
    $reflection = new ReflectionClass($widget);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

<<<<<<< HEAD
    expect($property->getValue($widget))->toBe('geo::filament.widgets.geo-map-widget');
=======
    Assert::assertSame('geo::filament.widgets.geo-map-widget', $property->getValue($widget));
>>>>>>> 40b96bcd6 (.)
});
