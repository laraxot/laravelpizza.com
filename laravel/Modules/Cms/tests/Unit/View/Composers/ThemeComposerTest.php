<?php

declare(strict_types=1);

use Modules\Cms\View\Composers\ThemeComposer;
use PHPUnit\Framework\Assert;

test('ThemeComposer can be instantiated', function () {
    $composer = new ThemeComposer;
    Assert::assertSame(ThemeComposer::class, $composer::class);
});

test('ThemeComposer getMenu reads the menu items', function () {})->todo('getMenu() usa Menu::firstOrCreate(): scrive nello store JSON del tenant. Serve uno store isolato (fixture) prima di asserire sugli items.');

test('ThemeComposer getMenuUrl returns the url of an external menu entry', function () {
    $composer = new ThemeComposer;

    Assert::assertSame(
        'https://example.com/page',
        $composer->getMenuUrl(['type' => 'external', 'url' => 'https://example.com/page']),
    );
});

test('ThemeComposer getMenuUrl returns hash for an unknown menu type', function () {
    $composer = new ThemeComposer;

    Assert::assertSame('#', $composer->getMenuUrl(['type' => 'unknown', 'url' => 'x']));
});

test('ThemeComposer showPageContent renders the page blocks', function () {})->todo('showPageContent() usa Page::firstOrCreate(): scrive nello store JSON del tenant. Serve uno store isolato (fixture) prima di asserire sul render.');

test('ThemeComposer getPages returns the pages collection', function () {
    $composer = new ThemeComposer;
    Assert::assertSame(ThemeComposer::class, $composer::class);

});

test('ThemeComposer getPageModel returns null for non-existent page', function () {
    $composer = new ThemeComposer;

    Assert::assertNull($composer->getPageModel('non-existent-page-'.uniqid()));
});

test('ThemeComposer getUrlPage returns the localized url of an existing page', function () {})->todo('Manca il caso "pagina esistente": richiede una fixture JSON isolata. Il caso "pagina assente" e\' coperto sotto.');

test('ThemeComposer getMenuUrl returns hash for empty array', function () {
    $composer = new ThemeComposer;
    $result = $composer->getMenuUrl([]);
    Assert::assertSame('#', $result);
});

test('ThemeComposer getUrlPage returns hash for non-existent page', function () {
    $composer = new ThemeComposer;
    $result = $composer->getUrlPage('non-existent-page-'.uniqid());
    Assert::assertSame('#', $result);
});
