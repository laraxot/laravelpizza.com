<?php

declare(strict_types=1);
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('LocaleSwitcherRefresh applyLocale imposta sessione e locale', function (): void {
    session()->forget('locale');

    $action = LocaleSwitcherRefresh::make('locale_switch');
    $action->applyLocale('en');

    Assert::assertSame('en', session('locale'));
    Assert::assertSame('en', app()->getLocale());
});

test('LocaleSwitcherRefresh normalizeLocale fallback en su locale non stringa', function (): void {
    Assert::assertSame('en', LocaleSwitcherRefresh::normalizeLocale(123));
    Assert::assertSame('en', LocaleSwitcherRefresh::normalizeLocale(null));
    Assert::assertSame('de', LocaleSwitcherRefresh::normalizeLocale('de'));
});

test('LocaleSwitcherRefresh setUp usa it se session locale assente', function (): void {
    session()->forget('locale');

    $action = LocaleSwitcherRefresh::make('locale_switch_3');

    Assert::assertSame('it', $action->lang);
});
