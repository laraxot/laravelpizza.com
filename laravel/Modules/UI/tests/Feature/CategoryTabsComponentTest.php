<?php

declare(strict_types=1);

use Illuminate\Support\Facades\View;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    if (function_exists('config')) {
        config(['app.locale' => 'en']);
    }
});

test('category tabs component renders without errors', function () {
    $componentData = [
        'base_url' => '/markets',
        'show_counts' => true,
        'mobile_scrollable' => true,
        'active_category' => 'all',
    ];

    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', $componentData);

    expect($view)->not()->toBeNull();

    $html = $view->render();
    expect($html)->toContain('/markets');
    expect($html)->toContain('All Markets');
});

test('category tabs shows all expected categories', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', [
        'base_url' => '/markets',
        'show_counts' => true,
    ]);

    $html = $view->render();

    // Check for all category names
    expect($html)->toContain('All Markets');
    expect($html)->toContain('Politics');
    expect($html)->toContain('Sports');
    expect($html)->toContain('Economics');
    expect($html)->toContain('Technology');
    expect($html)->toContain('Entertainment');
    expect($html)->toContain('Crypto');
});

test('category tabs shows counts when enabled', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', [
        'show_counts' => true,
    ]);

    $html = $view->render();

    // Should contain count indicators
    expect($html)->toContain('250'); // All markets count
    expect($html)->toContain('45'); // Politics count
    expect($html)->toContain('67'); // Sports count
    expect($html)->toContain('34'); // Economics count
    expect($html)->toContain('28'); // Technology count
    expect($html)->toContain('23'); // Entertainment count
    expect($html)->toContain('19'); // Crypto count
});

test('category tabs hides counts when disabled', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', [
        'show_counts' => false,
    ]);

    $html = $view->render();

    // Should not contain specific count numbers in count badges
    expect($html)
        ->not()
        ->toContain('<span class="ml-1 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">45</span>');
    expect($html)
        ->not()
        ->toContain('<span class="ml-1 px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">67</span>');
});

test('category tabs has mobile scrollable styling', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', [
        'mobile_scrollable' => true,
    ]);

    $html = $view->render();

    expect($html)->toContain('overflow-x-auto');
    expect($html)->toContain('scrollbar-hide');
});

test('category tabs has proper responsive classes', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs');

    $html = $view->render();

    expect($html)->toContain('flex-nowrap md:flex-wrap');
    expect($html)->toContain('justify-start md:justify-center');
});

test('category tabs generates correct urls', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', [
        'base_url' => '/markets',
    ]);

    $html = $view->render();

    expect($html)->toContain('href="/markets"'); // All markets
    expect($html)->toContain('href="/markets?category=politics"');
    expect($html)->toContain('href="/markets?category=sports"');
    expect($html)->toContain('href="/markets?category=economics"');
    expect($html)->toContain('href="/markets?category=technology"');
    expect($html)->toContain('href="/markets?category=entertainment"');
    expect($html)->toContain('href="/markets?category=crypto"');
});

test('category tabs highlights active category', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs', [
        'active_category' => 'politics',
    ]);

    $html = $view->render();

    // Should contain active state styling for politics
    expect($html)->toContain('bg-blue-600 text-white');
});

test('category tabs has proper dark mode classes', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs');

    $html = $view->render();

    expect($html)->toContain('dark:bg-slate-800');
    expect($html)->toContain('dark:border-slate-700');
    expect($html)->toContain('dark:text-slate-300');
    expect($html)->toContain('dark:hover:text-white');
});

test('category tabs has sticky positioning', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs');

    $html = $view->render();

    expect($html)->toContain('sticky top-0');
    expect($html)->toContain('z-40');
});

test('category tabs has proper category icons', function () {
    $view = View::make('pub_theme::components.blocks.navigation.category-tabs');

    $html = $view->render();

    // Check for emoji icons used in categories
    expect($html)->toContain('🗳️'); // Politics
    expect($html)->toContain('⚽'); // Sports
    expect($html)->toContain('📈'); // Economics
    expect($html)->toContain('💻'); // Technology
    expect($html)->toContain('🎬'); // Entertainment
    expect($html)->toContain('₿'); // Crypto
});
