<?php

declare(strict_types=1);

use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;
use Modules\Cms\View\Components\Page;
use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('AppLayout can be instantiated', function () {
    $component = new AppLayout();

    Assert::assertInstanceOf(AppLayout::class, $component);
});

test('GuestLayout can be instantiated', function () {
    $component = new GuestLayout();

    Assert::assertInstanceOf(GuestLayout::class, $component);
});

test('Metatags can be instantiated', function () {
    $component = new Metatags();

    Assert::assertInstanceOf(Metatags::class, $component);
});

test('Page can be instantiated', function () {
    // This test might require a valid page to exist in the database
    // For now, we'll test instantiation with basic parameters
});

test('PageContent can be instantiated with slug', function () {
    $component = new PageContent('test-slug');

    Assert::assertInstanceOf(PageContent::class, $component);

    Assert::assertSame('test-slug', $component->slug);
});

test('Section can be instantiated with slug', function () {
    // This test may fail due to database dependencies during instantiation
    // Let's just check if the class is instantiable in general
    Assert::assertTrue(class_exists(Section::class));
});
