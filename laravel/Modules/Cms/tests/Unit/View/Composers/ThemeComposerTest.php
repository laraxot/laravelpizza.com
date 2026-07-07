<?php

declare(strict_types=1);

use Modules\Cms\View\Composers\ThemeComposer;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('ThemeComposer can be instantiated', function () {
    $composer = new ThemeComposer();
    Assert::assertInstanceOf(ThemeComposer::class, $composer);
});

test('ThemeComposer has getMenu method', function () {
    $composer = new ThemeComposer();
});

test('ThemeComposer has getMenuUrl method', function () {
    $composer = new ThemeComposer();
});

test('ThemeComposer has showPageContent method', function () {
    $composer = new ThemeComposer();
});

test('ThemeComposer has getPages method', function () {
    $composer = new ThemeComposer();
});

test('ThemeComposer has getPageModel method', function () {
    $composer = new ThemeComposer();
});

test('ThemeComposer has getUrlPage method', function () {
    $composer = new ThemeComposer();
});

test('ThemeComposer getMenuUrl returns hash for empty array', function () {
    $composer = new ThemeComposer();
    $result = $composer->getMenuUrl([]);
    Assert::assertSame('#', $result);
});

test('ThemeComposer getUrlPage returns hash for non-existent page', function () {
    $composer = new ThemeComposer();
    $result = $composer->getUrlPage('non-existent-page-'.uniqid());
    Assert::assertSame('#', $result);
});
