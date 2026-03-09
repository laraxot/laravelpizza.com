<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Datas;

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Datas\HeadernavData;

test('HeadernavData can be instantiated', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData)->toBeInstanceOf(HeadernavData::class);
});

test('HeadernavData extends Spatie Data', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData)->toBeInstanceOf(Spatie\LaravelData\Data::class);
});

test('HeadernavData implements Wireable interface', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData)->toBeInstanceOf(Livewire\Wireable::class);
});

test('HeadernavData has default view path', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->view)->toBe('cms::components.headernav');
});

test('HeadernavData has nullable background_color property', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->background_color)->toBeNull();
});

test('HeadernavData has nullable background property', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->background)->toBeNull();
});

test('HeadernavData has nullable overlay_color property', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->overlay_color)->toBeNull();
});

test('HeadernavData has nullable overlay_opacity property', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->overlay_opacity)->toBeNull();
});

test('HeadernavData has nullable class property', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->class)->toBeNull();
});

test('HeadernavData has nullable style property', function (): void {
    $headernavData = new HeadernavData();

    expect($headernavData->style)->toBeNull();
});

test('HeadernavData rules method returns validation rules', function (): void {
    $rules = HeadernavData::rules();

    expect($rules)->toBeArray()
        ->and($rules)->toHaveKey('background_color')
        ->and($rules)->toHaveKey('background')
        ->and($rules)->toHaveKey('overlay_color')
        ->and($rules)->toHaveKey('overlay_opacity')
        ->and($rules)->toHaveKey('class')
        ->and($rules)->toHaveKey('style')
        ->and($rules)->toHaveKey('view');
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

    expect($headernavData)->toBeInstanceOf(HeadernavData::class)
        ->and($headernavData->background_color)->toBe('#ffffff')
        ->and($headernavData->background)->toBe('header.jpg')
        ->and($headernavData->overlay_color)->toBe('rgba(0,0,0,0.5)')
        ->and($headernavData->overlay_opacity)->toBe(50)
        ->and($headernavData->class)->toBe('custom-header')
        ->and($headernavData->style)->toBe('margin-top: 10px');
});

test('HeadernavData can be converted to array', function (): void {
    $headernavData = HeadernavData::from([
        'background_color' => '#000000',
    ]);

    $array = $headernavData->toArray();

    expect($array)->toBeArray()
        ->and($array)->toHaveKey('background_color');
});

test('HeadernavData overlay_opacity validates numeric range', function (): void {
    $rules = HeadernavData::rules();

    expect($rules['overlay_opacity'])->toContain('numeric')
        ->and($rules['overlay_opacity'])->toContain('min:0')
        ->and($rules['overlay_opacity'])->toContain('max:100');
});
