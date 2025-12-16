<?php

declare(strict_types=1);

use Illuminate\Support\Facades\View;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    // Ensure we're using the correct theme
    if (function_exists('config')) {
        config(['app.locale' => 'en']);
    }
});

test('kalshi inspired hero component renders without errors', function () {
    $componentData = [
        'title' => 'Test Prediction Platform',
        'subtitle' => 'Trade on real events with confidence',
        'cta_text' => 'Start Trading',
        'cta_link' => '/markets',
        'secondary_cta_text' => 'View Markets',
        'secondary_cta_link' => '/markets',
        'show_stats' => true,
        'show_categories' => true,
    ];

    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', $componentData);

    expect($view)->not()->toBeNull();

    $html = $view->render();
    expect($html)->toContain('Test Prediction Platform');
    expect($html)->toContain('Trade on real events with confidence');
    expect($html)->toContain('Start Trading');
    expect($html)->toContain('View Markets');
});

test('kalshi hero shows statistics when enabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_stats' => true,
    ]);

    $html = $view->render();
    expect($html)->toContain('250+');
    expect($html)->toContain('Active Markets');
    expect($html)->toContain('50K+');
    expect($html)->toContain('Total Predictions');
    expect($html)->toContain('89%');
    expect($html)->toContain('Accuracy Rate');
    expect($html)->toContain('5K+');
    expect($html)->toContain('Active Traders');
});

test('kalshi hero hides statistics when disabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_stats' => false,
    ]);

    $html = $view->render();
    expect($html)->not()->toContain('Active Markets');
    expect($html)->not()->toContain('Total Predictions');
});

test('kalshi hero shows categories when enabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_categories' => true,
    ]);

    $html = $view->render();
    expect($html)->toContain('Popular Categories');
    expect($html)->toContain('Politics');
    expect($html)->toContain('Sports');
    expect($html)->toContain('Economics');
    expect($html)->toContain('Technology');
    expect($html)->toContain('Entertainment');
    expect($html)->toContain('Crypto');
});

test('kalshi hero hides categories when disabled', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired', [
        'show_categories' => false,
    ]);

    $html = $view->render();
    expect($html)->not()->toContain('Popular Categories');
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
    expect($html)->toContain('Custom Market Title');
    expect($html)->toContain('Custom trading platform description');
    expect($html)->toContain('Join Now');
    expect($html)->toContain('Learn More');
    expect($html)->toContain('href="/register"');
    expect($html)->toContain('href="/about"');
});

test('kalshi hero has proper css classes and styling', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired');

    $html = $view->render();
    expect($html)->toContain('bg-gradient-to-br from-slate-900');
    expect($html)->toContain('animate-gradient-x');
    expect($html)->toContain('bg-grid-pattern');
    expect($html)->toContain('dark:from-slate-950');
});

test('kalshi hero includes required css animations', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired');

    $html = $view->render();
    expect($html)->toContain('@keyframes gradient-x');
    expect($html)->toContain('.animate-gradient-x');
    expect($html)->toContain('.bg-grid-pattern');
});

test('kalshi hero has responsive design classes', function () {
    $view = View::make('pub_theme::components.blocks.hero.kalshi-inspired');

    $html = $view->render();
    expect($html)->toContain('md:text-7xl lg:text-8xl');
    expect($html)->toContain('grid-cols-2 md:grid-cols-4');
    expect($html)->toContain('md:grid-cols-3 lg:grid-cols-6');
    expect($html)->toContain('flex-col sm:flex-row');
});
