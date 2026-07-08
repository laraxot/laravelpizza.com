<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Illuminate\Support\Facades\View;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function () {
    /* @var \Modules\UI\Tests\TestCase $this */
    if (! View::exists('pub_theme::components.blocks.hero.kalshi-inspired')) {
        Assert::markTestSkipped('pub_theme kalshi hero view is not available in this install.');
    }

    if (function_exists('config')) {
        config(['app.locale' => 'en']);
    }
});

test('kalshi inspired hero component renders without errors', function () {
    if (! View::exists('pub_theme::components.blocks.hero.kalshi-inspired')) {
        Assert::markTestSkipped('pub_theme kalshi hero view is not available in this install.');
    }
    $componentData = [
        'title' => 'Test <nome progetto>ion Platform',
        'subtitle' => 'Trade on real events with confidence',
        'cta_text' => 'Start Trading',
        'cta_link' => '/markets',
        'secondary_cta_text' => 'View Markets',
        'secondary_cta_link' => '/markets',
        'show_stats' => true,
        'show_categories' => true,
    ];

    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', $componentData);

    $html = $view->render();
    Assert::assertStringContainsString((string) 'Test <nome progetto>ion Platform', (string) $html);
    Assert::assertStringContainsString((string) 'Trade on real events with confidence', (string) $html);
    Assert::assertStringContainsString((string) 'Start Trading', (string) $html);
    Assert::assertStringContainsString((string) 'View Markets', (string) $html);
});

test('kalshi hero shows statistics when enabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_stats' => true,
    ]);

    $html = $view->render();
    Assert::assertStringContainsString((string) '250+', (string) $html);
    Assert::assertStringContainsString((string) 'Active Markets', (string) $html);
    Assert::assertStringContainsString((string) '50K+', (string) $html);
    Assert::assertStringContainsString((string) 'Total <nome progetto>ions', (string) $html);
    Assert::assertStringContainsString((string) '89%', (string) $html);
    Assert::assertStringContainsString((string) 'Accuracy Rate', (string) $html);
    Assert::assertStringContainsString((string) '5K+', (string) $html);
    Assert::assertStringContainsString((string) 'Active Traders', (string) $html);
});

test('kalshi hero hides statistics when disabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_stats' => false,
    ]);

    $html = $view->render();
    Assert::assertStringNotContainsString('Active Markets', $html);
    Assert::assertStringNotContainsString('Total <nome progetto>ions', $html);
});

test('kalshi hero shows categories when enabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_categories' => true,
    ]);

    $html = $view->render();
    Assert::assertStringContainsString((string) 'Popular Categories', (string) $html);
    Assert::assertStringContainsString((string) 'Politics', (string) $html);
    Assert::assertStringContainsString((string) 'Sports', (string) $html);
    Assert::assertStringContainsString((string) 'Economics', (string) $html);
    Assert::assertStringContainsString((string) 'Technology', (string) $html);
    Assert::assertStringContainsString((string) 'Entertainment', (string) $html);
    Assert::assertStringContainsString((string) 'Crypto', (string) $html);
});

test('kalshi hero hides categories when disabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_categories' => false,
    ]);

    $html = $view->render();
    Assert::assertStringNotContainsString('Popular Categories', $html);
});

test('kalshi hero supports custom props', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'title' => 'Custom Market Title',
        'subtitle' => 'Custom trading platform description',
        'cta_text' => 'Join Now',
        'cta_link' => '/register',
        'secondary_cta_text' => 'Learn More',
        'secondary_cta_link' => '/about',
    ]);

    $html = $view->render();
    Assert::assertStringContainsString((string) 'Custom Market Title', (string) $html);
    Assert::assertStringContainsString((string) 'Custom trading platform description', (string) $html);
    Assert::assertStringContainsString((string) 'Join Now', (string) $html);
    Assert::assertStringContainsString((string) 'Learn More', (string) $html);
    Assert::assertStringContainsString((string) 'href="/register"', (string) $html);
    Assert::assertStringContainsString((string) 'href="/about"', (string) $html);
});

test('kalshi hero has proper css classes and styling', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired');

    $html = $view->render();
    Assert::assertStringContainsString((string) 'bg-gradient-to-br from-slate-900', (string) $html);
    Assert::assertStringContainsString((string) 'animate-gradient-x', (string) $html);
    Assert::assertStringContainsString((string) 'bg-grid-pattern', (string) $html);
    Assert::assertStringContainsString((string) 'dark:from-slate-950', (string) $html);
});

test('kalshi hero includes required css animations', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired');

    $html = $view->render();
    Assert::assertStringContainsString((string) '@keyframes gradient-x', (string) $html);
    Assert::assertStringContainsString((string) '.animate-gradient-x', (string) $html);
    Assert::assertStringContainsString((string) '.bg-grid-pattern', (string) $html);
});

test('kalshi hero has responsive design classes', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired');

    $html = $view->render();
    Assert::assertStringContainsString((string) 'md:text-7xl lg:text-8xl', (string) $html);
    Assert::assertStringContainsString((string) 'grid-cols-2 md:grid-cols-4', (string) $html);
    Assert::assertStringContainsString((string) 'md:grid-cols-3 lg:grid-cols-6', (string) $html);
    Assert::assertStringContainsString((string) 'flex-col sm:flex-row', (string) $html);
});
