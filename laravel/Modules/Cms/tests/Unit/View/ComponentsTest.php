<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\View;

use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;

/*
 * Smoke tests for Section and PageContent view components.
 *
 * Page component tests are in:
 *
 * @see \Modules\Cms\Tests\Unit\View\Components\PageComponentTest
 */
test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

    expect($component)->toBeInstanceOf(Section::class);
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

    expect($component)->toBeInstanceOf(PageContent::class);
});
