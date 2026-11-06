<?php

declare(strict_types=1);

use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;
use PHPUnit\Framework\Assert;

/*
 * Smoke tests for Section and PageContent view components.
 *
 * Page component tests are in:
 *
 * @see \Modules\Cms\Tests\Unit\View\Components\PageComponentTest
 */
test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

    Assert::assertSame('test-slug', $component->slug);
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

    Assert::assertSame('test-slug', $component->slug);
});
