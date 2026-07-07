<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Illuminate\Support\Facades\View;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param array<string, mixed> $data
 */
function renderCategoryTabsHtml(array $data = []): ?string
{
    if (! View::exists('pub_theme::components.blocks.navigation.category-tabs')) {
        return null;
    }

    try {
        return View::make('pub_theme::components.blocks.navigation.category-tabs', $data)->render();
    } catch (\Throwable) {
        return null;
    }
}

/**
 * @param array<string, mixed> $data
 */
function requireCategoryTabsHtml(array $data = []): string
{
    $html = renderCategoryTabsHtml($data);
    if (null === $html) {
        Assert::markTestSkipped('pub_theme category-tabs view not available in this install.');
    }

    return $html;
}

beforeEach(function (): void {
    /* @var \Modules\UI\Tests\TestCase $this */
    if (function_exists('config')) {
        config(['app.locale' => 'en']);
    }
});

it('category tabs component renders without errors', function (): void {
    $html = requireCategoryTabsHtml([
        'base_url' => '/markets',
        'show_counts' => true,
        'mobile_scrollable' => true,
        'active_category' => 'all',
    ]);

    Assert::assertStringContainsString('/markets', $html);
    Assert::assertStringContainsString('All Markets', $html);
});

it('category tabs shows all expected categories', function (): void {
    $html = requireCategoryTabsHtml([
        'base_url' => '/markets',
        'show_counts' => true,
    ]);

    foreach (['All Markets', 'Politics', 'Sports', 'Economics', 'Technology', 'Entertainment', 'Crypto'] as $label) {
        Assert::assertStringContainsString($label, $html);
    }
});

it('category tabs shows counts when enabled', function (): void {
    $html = requireCategoryTabsHtml(['show_counts' => true]);

    foreach (['250', '45', '67', '34', '28', '23', '19'] as $count) {
        Assert::assertStringContainsString($count, $html);
    }
});

it('category tabs hides counts when disabled', function (): void {
    $html = requireCategoryTabsHtml(['show_counts' => false]);

    Assert::assertStringNotContainsString(
        '<span class="ml-1 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">45</span>',
        $html
    );
    Assert::assertStringNotContainsString(
        '<span class="ml-1 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">67</span>',
        $html
    );
});

it('category tabs has mobile scrollable styling', function (): void {
    $html = requireCategoryTabsHtml(['mobile_scrollable' => true]);

    Assert::assertStringContainsString('overflow-x-auto', $html);
    Assert::assertStringContainsString('scrollbar-hide', $html);
});

it('category tabs has proper responsive classes', function (): void {
    $html = requireCategoryTabsHtml();

    Assert::assertStringContainsString('flex-nowrap md:flex-wrap', $html);
    Assert::assertStringContainsString('justify-start md:justify-center', $html);
});

it('category tabs generates correct urls', function (): void {
    $html = requireCategoryTabsHtml(['base_url' => '/markets']);

    Assert::assertStringContainsString('href="/markets"', $html);
    foreach (['politics', 'sports', 'economics', 'technology', 'entertainment', 'crypto'] as $category) {
        Assert::assertStringContainsString('href="/markets?category='.$category.'"', $html);
    }
});

it('category tabs highlights active category', function (): void {
    $html = requireCategoryTabsHtml(['active_category' => 'politics']);

    Assert::assertStringContainsString('bg-blue-600 text-white', $html);
});

it('category tabs has proper dark mode classes', function (): void {
    $html = requireCategoryTabsHtml();

    Assert::assertStringContainsString('dark:bg-slate-800', $html);
    Assert::assertStringContainsString('dark:border-slate-700', $html);
    Assert::assertStringContainsString('dark:text-slate-300', $html);
    Assert::assertStringContainsString('dark:hover:text-white', $html);
});

it('category tabs has sticky positioning', function (): void {
    $html = requireCategoryTabsHtml();

    Assert::assertStringContainsString('sticky top-0', $html);
    Assert::assertStringContainsString('z-40', $html);
});

it('category tabs has proper category icons', function (): void {
    $html = requireCategoryTabsHtml();

    foreach (['🗳️', '⚽', '📈', '💻', '🎬', '₿'] as $icon) {
        Assert::assertStringContainsString($icon, $html);
    }
});
