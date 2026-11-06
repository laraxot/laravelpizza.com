<?php

declare(strict_types=1);

use Livewire\Wireable;
use Modules\Cms\Datas\HeadernavData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

test('HeadernavData can be instantiated', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertSame('cms::components.headernav', $headernavData->view);
});

test('HeadernavData extends Spatie Data', function (): void {
    $parent = (new ReflectionClass(HeadernavData::class))->getParentClass();

    Assert::assertInstanceOf(ReflectionClass::class, $parent);
    Assert::assertSame(Data::class, $parent->getName());
});

test('HeadernavData implements Wireable interface', function (): void {
    $interfaces = \Safe\class_implements(HeadernavData::class);

    Assert::assertContains(Wireable::class, $interfaces);
});

test('HeadernavData has default view path', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertSame('cms::components.headernav', $headernavData->view);
});

test('HeadernavData has nullable background_color property', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertNull($headernavData->background_color);
});

test('HeadernavData has nullable background property', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertNull($headernavData->background);
});

test('HeadernavData has nullable overlay_color property', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertNull($headernavData->overlay_color);
});

test('HeadernavData has nullable overlay_opacity property', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertNull($headernavData->overlay_opacity);
});

test('HeadernavData has nullable class property', function (): void {
    $headernavData = new HeadernavData;

    Assert::assertNull($headernavData->class);
});

test('HeadernavData has nullable style property', function (): void {
    $headernavData = new HeadernavData;

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

    /** @var list<string> $overlayRules */
    $overlayRules = $rules['overlay_opacity'];

    Assert::assertContains('numeric', $overlayRules);
    Assert::assertContains('min:0', $overlayRules);
    Assert::assertContains('max:100', $overlayRules);
});
