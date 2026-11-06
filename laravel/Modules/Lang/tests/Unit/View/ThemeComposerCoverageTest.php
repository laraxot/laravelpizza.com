<?php

declare(strict_types=1);
use Modules\Lang\Datas\LangData;
use Modules\Lang\Tests\TestCase;
use Modules\Lang\View\Composers\ThemeComposer;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ThemeComposer languages usa fallback quando manca config', function (): void {
    config(['laravellocalization' => []]);

    $composer = new ThemeComposer;
    $langs = $composer->languages();

    Assert::assertGreaterThanOrEqual(2, $langs->count());
});

test('ThemeComposer languages rifiuta config non array', function (): void {
    config(['laravellocalization.supportedLocales' => 'invalid']);

    try {
        (new ThemeComposer)->languages();
        Assert::fail('Expected Exception');
    } catch (Exception $e) {
        Assert::assertStringContainsString('Invalid config', $e->getMessage());
    }
});

test('ThemeComposer languages rifiuta item non array', function (): void {
    config(['laravellocalization.supportedLocales' => ['it' => 'bad']]);

    try {
        (new ThemeComposer)->languages();
        Assert::fail('Expected InvalidArgumentException');
    } catch (InvalidArgumentException $e) {
        Assert::assertStringContainsString('Expected array at locale', $e->getMessage());
    }
});

test('ThemeComposer languages rifiuta item senza name/regional', function (): void {
    config(['laravellocalization.supportedLocales' => ['it' => ['foo' => 'bar']]]);

    try {
        (new ThemeComposer)->languages();
        Assert::fail('Expected InvalidArgumentException');
    } catch (InvalidArgumentException $e) {
        Assert::assertStringContainsString('regional', $e->getMessage());
    }
});

test('ThemeComposer otherLanguages esclude locale corrente', function (): void {
    config([
        'laravellocalization.supportedLocales' => [
            'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
            'en' => ['name' => 'English', 'regional' => 'en_US'],
        ],
    ]);
    app()->setLocale('it');

    $others = (new ThemeComposer)->otherLanguages();
    $ids = $others->toCollection()->map(fn (LangData $d): string => $d->id)->all();

    Assert::assertNotContains('it', $ids);
    Assert::assertContains('en', $ids);
});

test('ThemeComposer currentLang restituisce name e gestisce campo non stringa', function (): void {
    config([
        'laravellocalization.supportedLocales' => [
            'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
        ],
    ]);
    app()->setLocale('it');

    $composer = new ThemeComposer;
    Assert::assertSame('Italiano', $composer->currentLang('name'));
    Assert::assertSame('it', $composer->currentLang('id'));
});

test('ThemeComposer buildAdminLanguageUrl senza route corrente torna hash', function (): void {
    Assert::assertSame('#', (new ThemeComposer)->buildAdminLanguageUrl('en'));
});

test('ThemeComposer languages mappa en regional a flag gb', function (): void {
    config([
        'laravellocalization.supportedLocales' => [
            'en' => ['name' => 'English', 'regional' => 'en_US'],
        ],
    ]);

    $lang = (new ThemeComposer)->languages()->toCollection()->first();
    Assert::assertInstanceOf(LangData::class, $lang);
    Assert::assertStringContainsString('iti__gb', $lang->flag);
});
