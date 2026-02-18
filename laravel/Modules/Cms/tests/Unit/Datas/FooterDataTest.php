<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Datas\FooterData;

test('FooterData can be instantiated', function (): void {
    $footerData = new FooterData;

    expect($footerData)->toBeInstanceOf(FooterData::class);
});

test('FooterData extends Spatie Data', function (): void {
    $footerData = new FooterData;

    expect($footerData)->toBeInstanceOf(Spatie\LaravelData\Data::class);
});

test('FooterData implements Wireable interface', function (): void {
    $footerData = new FooterData;

    expect($footerData)->toBeInstanceOf(Livewire\Wireable::class);
});

test('FooterData has default view path', function (): void {
    $footerData = new FooterData;

    expect($footerData->view)->toBe('cms::components.footer');
});

test('FooterData has nullable background_color property', function (): void {
    $footerData = new FooterData;

    expect($footerData->background_color)->toBeNull();
});

test('FooterData has nullable background property', function (): void {
    $footerData = new FooterData;

    expect($footerData->background)->toBeNull();
});

test('FooterData has nullable overlay_color property', function (): void {
    $footerData = new FooterData;

    expect($footerData->overlay_color)->toBeNull();
});

test('FooterData rules method returns validation rules', function (): void {
    $rules = FooterData::rules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveKey('background_color')
        ->and($rules)->toHaveKey('background')
        ->and($rules)->toHaveKey('overlay_color')
        ->and($rules)->toHaveKey('view');
});

test('FooterData can be created from array using from method', function (): void {
    $data = [
        'background_color' => '#ffffff',
        'background' => 'image.jpg',
        'overlay_color' => 'rgba(0,0,0,0.5)',
    ];

    $footerData = FooterData::from($data);

    expect($footerData)->toBeInstanceOf(FooterData::class)
        ->and($footerData->background_color)->toBe('#ffffff')
        ->and($footerData->background)->toBe('image.jpg')
        ->and($footerData->overlay_color)->toBe('rgba(0,0,0,0.5)');
});

test('FooterData can be converted to array', function (): void {
    $footerData = FooterData::from([
        'background_color' => '#000000',
    ]);

    $array = $footerData->toArray();

    expect($array)->toBeArray()
        ->and($array)->toHaveKey('background_color');
});
