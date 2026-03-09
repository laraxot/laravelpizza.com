<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Datas\BlockData;
use Spatie\LaravelData\DataCollection;

test('BlockData can be instantiated with type and data', function (): void {
    $blockData = new BlockData('hero', ['view' => 'ui::empty', 'title' => 'Test']);

    expect($blockData)->toBeInstanceOf(BlockData::class)
        ->and($blockData->type)->toBe('hero')
        ->and($blockData->data)->toBeArray()
        ->and($blockData->data['title'])->toBe('Test');
});

test('BlockData uses WireableData trait', function (): void {
    $traits = class_uses_recursive(BlockData::class);

    expect(array_values($traits))->toContain(Spatie\LaravelData\Concerns\WireableData::class);
});

test('BlockData extends Spatie Data', function (): void {
    $blockData = new BlockData('text', ['view' => 'ui::empty']);

    expect($blockData)->toBeInstanceOf(Spatie\LaravelData\Data::class);
});

test('BlockData implements Wireable interface', function (): void {
    $blockData = new BlockData('card', ['view' => 'ui::empty']);

    expect($blockData)->toBeInstanceOf(Livewire\Wireable::class);
});

test('BlockData collection method returns DataCollection', function (): void {
    $data = [
        ['type' => 'hero', 'data' => ['view' => 'ui::empty', 'title' => 'Hero']],
        ['type' => 'text', 'data' => ['view' => 'ui::empty', 'content' => 'Text']],
    ];

    $collection = BlockData::collection(collect($data)->map(fn ($item) => new BlockData($item['type'], $item['data'])));

    expect($collection)->toBeInstanceOf(DataCollection::class);
});

test('BlockData sets default view when not provided', function (): void {
    $blockData = new BlockData('simple', []);

    expect($blockData->view)->toBe('ui::empty');
});

test('BlockData stores type correctly', function (): void {
    $blockData = new BlockData('testimonial', ['view' => 'ui::empty']);

    expect($blockData->type)->toBe('testimonial');
});

test('BlockData stores data array correctly', function (): void {
    $testData = [
        'view' => 'ui::empty',
        'title' => 'Test Title',
        'content' => 'Test Content',
        'image' => 'test.jpg',
    ];

    $blockData = new BlockData('feature', $testData);

    expect($blockData->data)->toEqual($testData);
});
