<?php

declare(strict_types=1);

use Livewire\Wireable;
use Modules\Cms\Datas\HeadernavData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(Modules\Cms\Tests\TestCase::class);
test('HeadernavData can be instantiated', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertInstanceOf(HeadernavData::class, $headernavData);
});

test('HeadernavData extends Spatie Data', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertInstanceOf(Data::class, $headernavData);
});

test('HeadernavData implements Wireable interface', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertInstanceOf(Wireable::class, $headernavData);
});

test('HeadernavData has default view path', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertSame('cms::components.headernav', $headernavData->view);
});

test('HeadernavData has nullable background_color property', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertNull($headernavData->background_color);
});

test('HeadernavData has nullable background property', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertNull($headernavData->background);
});

test('HeadernavData has nullable overlay_color property', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertNull($headernavData->overlay_color);
});

test('HeadernavData has nullable overlay_opacity property', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertNull($headernavData->overlay_opacity);
});

test('HeadernavData has nullable class property', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertNull($headernavData->class);
});

test('HeadernavData has nullable style property', function (): void {
    $headernavData = new HeadernavData();

    Assert::assertNull($headernavData->style);
});

test('HeadernavData rules method returns validation rules', function (): void {
    $rules = HeadernavData::rules();
    /* @var array<string, mixed> $rules */
    Assert::assertArrayHasKey('background_color', $rules);

    Assert::assertArrayHasKey('background', $rules);

    Assert::assertArrayHasKey('overlay_color', $rules);

    Assert::assertArrayHasKey('overlay_opacity', $rules);

    Assert::assertArrayHasKey('class', $rules);

    Assert::assertArrayHasKey('style', $rules);

    Assert::assertArrayHasKey('view', $rules);
});

test('HeadernavData can be created from array using from method', function (): void {
    $data = [
        'background_color' => '#ffffff',
        'background' => 'header.jpg',
        'overlay_color' => 'rgba(0,0,0,0.5)',
        'overlay_opacity' => 50,
        'class' => 'custom-header',
        'style' => 'margin-top: 10px',
    ];

    $headernavData = HeadernavData::from($data);

    Assert::assertInstanceOf(HeadernavData::class, $headernavData);

    Assert::assertSame('#ffffff', $headernavData->background_color);

    Assert::assertSame('header.jpg', $headernavData->background);

    Assert::assertSame('rgba(0,0,0,0.5)', $headernavData->overlay_color);
});

test('HeadernavData can be converted to array', function (): void {
    $headernavData = HeadernavData::from([
        'background_color' => '#000000',
    ]);

    $array = $headernavData->toArray();
    /* @var array<string, mixed> $array */
    Assert::assertArrayHasKey('background_color', $array);
});

test('HeadernavData overlay_opacity validates numeric range', function (): void {
    $rules = HeadernavData::rules();

    Assert::assertStringContainsString((string) 'numeric', (string) $rules['overlay_opacity']);

    Assert::assertStringContainsString((string) 'min:0', (string) $rules['overlay_opacity']);

    Assert::assertStringContainsString((string) 'max:100', (string) $rules['overlay_opacity']);
});
