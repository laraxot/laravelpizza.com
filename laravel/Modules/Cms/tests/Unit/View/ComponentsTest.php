<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View;

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\View\Components\Page;
use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;

test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

    expect($component)->toBeInstanceOf(Section::class);
});

test('Page component can be instantiated', function () {
    // Page component requires both 'side' and 'slug' parameters
    $component = new Page('content', 'test-slug');

    expect($component)->toBeInstanceOf(Page::class);
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

    expect($component)->toBeInstanceOf(PageContent::class);
});
