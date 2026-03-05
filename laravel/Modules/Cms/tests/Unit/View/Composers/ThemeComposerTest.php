<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\View\Composers\ThemeComposer;

test('ThemeComposer can be instantiated', function () {
    $composer = new ThemeComposer();
    expect($composer)->toBeInstanceOf(ThemeComposer::class);
});

test('ThemeComposer has getMenu method', function () {
    $composer = new ThemeComposer();
    expect(method_exists($composer, 'getMenu'))->toBeTrue();
});

test('ThemeComposer has getMenuUrl method', function () {
    $composer = new ThemeComposer();
    expect(method_exists($composer, 'getMenuUrl'))->toBeTrue();
});

test('ThemeComposer has showPageContent method', function () {
    $composer = new ThemeComposer();
    expect(method_exists($composer, 'showPageContent'))->toBeTrue();
});

test('ThemeComposer has getPages method', function () {
    $composer = new ThemeComposer();
    expect(method_exists($composer, 'getPages'))->toBeTrue();
});

test('ThemeComposer has getPageModel method', function () {
    $composer = new ThemeComposer();
    expect(method_exists($composer, 'getPageModel'))->toBeTrue();
});

test('ThemeComposer has getUrlPage method', function () {
    $composer = new ThemeComposer();
    expect(method_exists($composer, 'getUrlPage'))->toBeTrue();
});

test('ThemeComposer getMenuUrl returns hash for empty array', function () {
    $composer = new ThemeComposer();
    $result = $composer->getMenuUrl([]);
    expect($result)->toBe('#');
});

test('ThemeComposer getUrlPage returns hash for non-existent page', function () {
    $composer = new ThemeComposer();
    $result = $composer->getUrlPage('non-existent-page-'.uniqid());
    expect($result)->toBe('#');
});
