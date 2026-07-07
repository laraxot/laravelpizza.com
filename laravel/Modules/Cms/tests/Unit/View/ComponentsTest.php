<?php

declare(strict_types=1);

use Modules\Cms\View\Components\PageContent;
use Modules\Cms\View\Components\Section;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
/*
 * Smoke tests for Section and PageContent view components.
 *
 * Page component tests are in:
 *
 * @see \Modules\Cms\Tests\Unit\View\Components\PageComponentTest
 */
test('Section component can be instantiated', function () {
    $component = new Section('test-slug');

    Assert::assertInstanceOf(Section::class, $component);
});

test('PageContent component can be instantiated', function () {
    $component = new PageContent('test-slug');

    Assert::assertInstanceOf(PageContent::class, $component);
});
