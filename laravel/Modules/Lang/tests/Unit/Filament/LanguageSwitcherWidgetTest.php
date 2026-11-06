<?php

declare(strict_types=1);
use Livewire\Livewire;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Lang\Filament\Widgets\LanguageSwitcherWidget;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

test('LanguageSwitcherWidget is not auto-discovered as dashboard card', function (): void {
    Assert::assertFalse(LanguageSwitcherWidget::isDiscovered());
});

test('LanguageSwitcherWidget getAvailableLocales riflette LaravelLocalization non it/en/de hardcoded', function (): void {
    $previous = LaravelLocalization::getSupportedLocales();

    LaravelLocalization::setSupportedLocales([
        'fr' => [
            'name' => 'French',
            'script' => 'Latn',
            'native' => 'Français',
            'regional' => 'fr_FR',
        ],
        'es' => [
            'name' => 'Spanish',
            'script' => 'Latn',
            'native' => 'Español',
            'regional' => 'es_ES',
        ],
    ]);

    try {
        $widget = new LanguageSwitcherWidget;
        $locales = $widget->getAvailableLocales();
        $codes = $locales->pluck('code')->all();
        Assert::assertSame(['fr', 'es'], $codes);
        Assert::assertNotContains('it', $codes);
        Assert::assertNotContains('en', $codes);
        Assert::assertNotContains('de', $codes);
        $first = $locales->first();
        Assert::assertNotNull($first);
        Assert::assertSame('French', $first['name']);
        Assert::assertSame('Français', $first['native_name']);
        Assert::assertNull($first['flag']);
        Assert::assertSame([], $widget->getFormSchema());
    } finally {
        LaravelLocalization::setSupportedLocales($previous);
    }
});

test('LanguageSwitcher HTTP Switcher and Change non esistono più', function (): void {
    $httpLangDir = dirname(__DIR__, 3).'/app/Http/Livewire/Lang';
    Assert::assertFileDoesNotExist($httpLangDir.'/Switcher.php');
    Assert::assertFileDoesNotExist($httpLangDir.'/Change.php');
});

test('LanguageSwitcherWidget changeLanguage redirect 303 su URL localizzato', function (): void {
    Livewire::test(LanguageSwitcherWidget::class)
        ->call('changeLanguage', 'en')
        ->assertRedirect();
});

test('LanguageSwitcherWidget getLanguageUrl usa LaravelLocalization con fallback stringa', function (): void {
    LaravelLocalization::shouldReceive('getLocalizedURL')
        ->once()
        ->andReturn(false);

    $widget = new LanguageSwitcherWidget;
    Assert::assertSame('/fr', $widget->getLanguageUrl('fr'));
});
