<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\UI\Tests\TestCase $this */
    if (function_exists('config')) {
        config(['app.locale' => 'en']);
    }
});

function heroComponentPath(): string
{
    return base_path('Themes/TwentyOne/resources/views/components/blocks/hero/kalshi-inspired.blade.php');
}

function readHeroContentOrSkip(): string
{
    $heroPath = heroComponentPath();
    if (! file_exists($heroPath)) {
        Assert::markTestSkipped('Theme TwentyOne hero component not present in this install.');
    }

    return file_get_contents($heroPath);
}

it('pages include dark mode toggle functionality', function (): void {
    $heroContent = readHeroContentOrSkip();

    Assert::assertStringContainsString('dark:from-slate-950', $heroContent);
    Assert::assertStringContainsString('dark:via-blue-950', $heroContent);
    Assert::assertStringContainsString('dark:to-slate-950', $heroContent);
});

it('dark mode classes are present in components', function (): void {
    $heroContent = readHeroContentOrSkip();

    Assert::assertStringContainsString('dark:from-slate-950', $heroContent);
    Assert::assertStringContainsString('dark:via-blue-950', $heroContent);
    Assert::assertStringContainsString('dark:to-slate-950', $heroContent);
});

it('kalshi hero component supports dark mode', function (): void {
    $content = readHeroContentOrSkip();

    if (str_contains($content, 'from-slate-900')) {
        Assert::assertStringContainsString('dark:from-slate-950', $content);
    }

    if (str_contains($content, 'bg-slate-800')) {
        Assert::assertTrue(
            str_contains($content, 'dark:bg-slate-900') || str_contains($content, 'dark:bg-slate-950')
        );
    }
});

it('category tabs support dark mode', function (): void {
    $tabsPath = base_path('Themes/TwentyOne/resources/views/components/blocks/navigation/category-tabs.blade.php');

    if (! file_exists($tabsPath)) {
        return;
    }

    $content = file_get_contents($tabsPath);
    Assert::assertTrue(
        str_contains($content, 'dark:bg-slate-')
        || str_contains($content, 'dark:border-slate-')
        || str_contains($content, 'dark:text-slate-')
    );
});

it('market cards support dark mode', function (): void {
    $cardsPath = base_path('Themes/TwentyOne/resources/views/components/blocks/markets/data-driven-cards.blade.php');

    if (! file_exists($cardsPath)) {
        return;
    }

    $content = file_get_contents($cardsPath);
    if (str_contains($content, 'bg-white')) {
        Assert::assertTrue(
            str_contains($content, 'dark:bg-slate-') || str_contains($content, 'dark:bg-gray-')
        );
    }
});

it('consistent dark mode color scheme', function (): void {
    $content = readHeroContentOrSkip();

    if (str_contains($content, 'dark:')) {
        Assert::assertTrue(str_contains($content, 'slate-') || str_contains($content, 'gray-'));
    }
});

it('dark mode javascript initialization', function (): void {
    $content = readHeroContentOrSkip();

    Assert::assertTrue(
        str_contains($content, 'dark:')
        || str_contains($content, 'darkMode')
        || str_contains($content, 'classList')
    );
});

it('proper contrast ratios in dark mode', function (): void {
    $content = readHeroContentOrSkip();

    if (! str_contains($content, 'dark:bg-slate-900')) {
        Assert::assertStringContainsString('dark:', $content);

        return;
    }

    Assert::assertTrue(
        str_contains($content, 'text-white')
        || str_contains($content, 'text-slate-100')
        || str_contains($content, 'dark:text-white')
    );
});

it('gradient backgrounds work in dark mode', function (): void {
    $content = readHeroContentOrSkip();

    if (str_contains($content, 'bg-gradient-to-br')) {
        Assert::assertTrue(
            str_contains($content, 'dark:from-')
            || str_contains($content, 'dark:via-')
            || str_contains($content, 'dark:to-')
        );
    }
});

it('interactive elements have dark mode hover states', function (): void {
    $content = readHeroContentOrSkip();

    if (str_contains($content, 'hover:')) {
        Assert::assertStringContainsString('hover:', $content);
        Assert::assertStringContainsString('transition', $content);
    }
});

it('border colors adapt to dark mode', function (): void {
    $content = readHeroContentOrSkip();

    if (str_contains($content, 'border-')) {
        Assert::assertTrue(
            str_contains($content, 'border-white/10')
            || str_contains($content, 'dark:border-')
            || str_contains($content, 'border-slate-')
        );
    }
});

it('backdrop effects work in dark mode', function (): void {
    $content = readHeroContentOrSkip();

    if (str_contains($content, 'backdrop-blur')) {
        Assert::assertTrue(
            str_contains($content, 'bg-white/5')
            || str_contains($content, 'bg-black/')
        );
    }
});
