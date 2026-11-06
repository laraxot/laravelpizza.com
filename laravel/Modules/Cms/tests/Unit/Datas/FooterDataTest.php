<?php

declare(strict_types=1);

use Livewire\Wireable;
use Modules\Cms\Datas\FooterData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

test('FooterData can be instantiated', function (): void {
    $footerData = new FooterData;

    Assert::assertSame('cms::components.footer', $footerData->view);
});

test('FooterData extends Spatie Data', function (): void {
    $parent = (new ReflectionClass(FooterData::class))->getParentClass();

    Assert::assertNotFalse($parent);
    Assert::assertSame(Data::class, $parent->getName());
});

test('FooterData implements Wireable interface', function (): void {
    $interfaces = \Safe\class_implements(FooterData::class);

    Assert::assertContains(Wireable::class, $interfaces);
});

test('FooterData has default view path', function (): void {
    $footerData = new FooterData;

    Assert::assertSame('cms::components.footer', $footerData->view);
});

test('FooterData has nullable background_color property', function (): void {
    $footerData = new FooterData;

    Assert::assertNull($footerData->background_color);
});

test('FooterData has nullable background property', function (): void {
    $footerData = new FooterData;

    Assert::assertNull($footerData->background);
});

test('FooterData has nullable overlay_color property', function (): void {
    $footerData = new FooterData;

    Assert::assertNull($footerData->overlay_color);
});

test('FooterData rules method returns validation rules', function (): void {
    $rules = FooterData::rules();
    /* @var array<string, mixed> $rules */
    Assert::assertArrayHasKey('background_color', $rules);

    Assert::assertArrayHasKey('background', $rules);

    Assert::assertArrayHasKey('overlay_color', $rules);

    Assert::assertArrayHasKey('view', $rules);
});

test('FooterData can be created from array using from method', function (): void {
    $data = [
        'background_color' => '#ffffff',
        'background' => 'image.jpg',
        'overlay_color' => 'rgba(0,0,0,0.5)',
    ];

    $footerData = FooterData::from($data);

    Assert::assertSame('#ffffff', $footerData->background_color);

    Assert::assertSame('image.jpg', $footerData->background);

    Assert::assertSame('rgba(0,0,0,0.5)', $footerData->overlay_color);
});

test('FooterData can be converted to array', function (): void {
    $footerData = FooterData::from([
        'background_color' => '#000000',
    ]);

    $array = $footerData->toArray();
    /* @var array<string, mixed> $array */
    Assert::assertArrayHasKey('background_color', $array);
});
