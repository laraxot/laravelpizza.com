<?php

declare(strict_types=1);

use Modules\Cms\Datas\ResolvePageData;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\Data;

uses(Modules\Cms\Tests\TestCase::class);
test('ResolvePageData can be instantiated with constructor', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    Assert::assertInstanceOf(ResolvePageData::class, $data);
});

test('ResolvePageData stores renderMode correctly', function (): void {
    $data = new ResolvePageData('cms', null, 'about');

    Assert::assertSame('cms', $data->renderMode);
});

test('ResolvePageData stores pageSlug correctly', function (): void {
    $data = new ResolvePageData('folio', null, 'contact');

    Assert::assertSame('contact', $data->pageSlug);
});

test('ResolvePageData can store null item', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    Assert::assertNull($data->item);
});

test('ResolvePageData can store object item', function (): void {
    $item = new stdClass();
    $item->title = 'Test Page';

    $data = new ResolvePageData('cms', $item, 'test');

    Assert::assertSame($item, $data->item);

    Assert::assertSame('Test Page', $data->item->title);
});

test('ResolvePageData can store array cast as object', function (): void {
    $item = (object) ['id' => 1, 'slug' => 'test'];

    $data = new ResolvePageData('cms', $item, 'test');

    Assert::assertInstanceOf(stdClass::class, $data->item);
});

test('ResolvePageData extends Spatie Data', function (): void {
    $data = new ResolvePageData('folio', null, 'home');

    Assert::assertInstanceOf(Data::class, $data);
});

test('ResolvePageData with different renderModes', function (): void {
    $modes = ['folio', 'cms', 'static', 'dynamic'];

    foreach ($modes as $mode) {
        $data = new ResolvePageData($mode, null, 'test');

        Assert::assertSame($mode, $data->renderMode);
    }
});

test('ResolvePageData handles various page slugs', function (): void {
    $slugs = ['home', 'about-us', 'contact', 'blog/post-1', 'deep/nested/page'];

    foreach ($slugs as $slug) {
        $data = new ResolvePageData('cms', null, $slug);

        Assert::assertSame($slug, $data->pageSlug);
    }
});
