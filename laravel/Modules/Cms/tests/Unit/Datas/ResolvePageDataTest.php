<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Datas;

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Datas\ResolvePageData;

test('ResolvePageData can be instantiated with constructor', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    expect($data)->toBeInstanceOf(ResolvePageData::class);
});

test('ResolvePageData stores renderMode correctly', function (): void {
    $data = new ResolvePageData('cms', null, 'about');

    expect($data->renderMode)->toBe('cms');
});

test('ResolvePageData stores pageSlug correctly', function (): void {
    $data = new ResolvePageData('folio', null, 'contact');

    expect($data->pageSlug)->toBe('contact');
});

test('ResolvePageData can store null item', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    expect($data->item)->toBeNull();
});

test('ResolvePageData can store object item', function (): void {
    $item = new stdClass();
    $item->title = 'Test Page';

    $data = new ResolvePageData('cms', $item, 'test');

    expect($data->item)->toBe($item)
        ->and($data->item->title)->toBe('Test Page');
});

test('ResolvePageData can store array cast as object', function (): void {
    $item = (object) ['id' => 1, 'slug' => 'test'];

    $data = new ResolvePageData('cms', $item, 'test');

    expect($data->item)->toBeInstanceOf(stdClass::class);
});

test('ResolvePageData extends Spatie Data', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    expect($data)->toBeInstanceOf(Spatie\LaravelData\Data::class);
});

test('ResolvePageData with different renderModes', function (): void {
    $modes = ['folio', 'cms', 'static', 'dynamic'];

    foreach ($modes as $mode) {
        $data = new ResolvePageData($mode, null, 'test');

        expect($data->renderMode)->toBe($mode);
    }
});

test('ResolvePageData handles various page slugs', function (): void {
    $slugs = ['home', 'about-us', 'contact', 'blog/post-1', 'deep/nested/page'];

    foreach ($slugs as $slug) {
        $data = new ResolvePageData('cms', null, $slug);

        expect($data->pageSlug)->toBe($slug);
    }
});
