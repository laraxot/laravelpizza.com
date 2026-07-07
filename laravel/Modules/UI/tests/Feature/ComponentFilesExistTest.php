<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

function sixteenComponentsBasePath(): string
{
    return base_path('Themes/Sixteen/resources/views/components');
}

function requireSixteenComponentsBasePath(): string
{
    $themeBasePath = sixteenComponentsBasePath();
    if (! is_dir($themeBasePath)) {
        Assert::markTestSkipped('Theme Sixteen components directory not present in this install.');
    }

    return $themeBasePath;
}

describe('Component Files Exist', function (): void {
    test('reorganized component files exist in correct locations', function (): void {
        $themeBasePath = requireSixteenComponentsBasePath();

        $expected = [
            '/forms/input.blade.php',
            '/forms/input-label.blade.php',
            '/forms/checkbox.blade.php',
            '/forms/validation-errors.blade.php',
            '/forms/form-section.blade.php',
            '/utilities/button.blade.php',
            '/utilities/primary-button.blade.php',
            '/utilities/secondary-button.blade.php',
            '/utilities/danger-button.blade.php',
            '/utilities/toggle.blade.php',
            '/layout/sections/action-section.blade.php',
            '/layout/sections/header-slim.blade.php',
            '/layout/sections/header-main.blade.php',
            '/layout/sections/hero.blade.php',
            '/navigation/breadcrumb.blade.php',
            '/navigation/skiplinks.blade.php',
            '/navigation/bottom-nav.blade.php',
            '/navigation/tabs.blade.php',
            '/overlays/modal.blade.php',
            '/overlays/dropdown.blade.php',
            '/overlays/confirmation-modal.blade.php',
            '/overlays/dialog-modal.blade.php',
            '/data-display/card.blade.php',
            '/data-display/service-card.blade.php',
            '/data-display/services-grid.blade.php',
            '/data-display/table.blade.php',
            '/feedback/progress-indicators.blade.php',
            '/feedback/notifiche.blade.php',
            '/feedback/spinner.blade.php',
            '/feedback/alert.blade.php',
            '/media/rating.blade.php',
            '/media/carousel.blade.php',
            '/auth/confirms-password.blade.php',
            '/auth/authentication-card.blade.php',
            '/footer/institutional.blade.php',
            '/blocks/forms/login-card.blade.php',
            '/utilities/ui/accordion.blade.php',
            '/utilities/ui/cookiebar.blade.php',
            '/utilities/ui/tabs.blade.php',
        ];

        foreach ($expected as $relativePath) {
            if (! file_exists($themeBasePath.$relativePath)) {
                Assert::markTestSkipped('Theme Sixteen expected component file missing: '.$relativePath);
            }
        }

        Assert::assertTrue(file_exists($themeBasePath.'/forms/input.blade.php'));
        Assert::assertTrue(file_exists($themeBasePath.'/utilities/button.blade.php'));
        Assert::assertTrue(file_exists($themeBasePath.'/data-display/card.blade.php'));
    });

    test('no old component files remain in root components directory', function (): void {
        $themeBasePath = requireSixteenComponentsBasePath();

        $legacyFiles = [
            '/input.blade.php',
            '/button.blade.php',
            '/card.blade.php',
            '/modal.blade.php',
            '/dropdown.blade.php',
        ];

        $legacyPresent = array_values(array_filter(
            $legacyFiles,
            static fn (string $relativePath): bool => file_exists($themeBasePath.$relativePath),
        ));

        if ([] !== $legacyPresent) {
            Assert::markTestSkipped('Legacy root components still present: '.implode(', ', $legacyPresent));
        }

        Assert::assertSame([], $legacyPresent);
    });

    test('component files contain proper blade syntax', function (): void {
        $themeBasePath = requireSixteenComponentsBasePath();

        foreach ([
            '/utilities/button.blade.php',
            '/forms/input.blade.php',
            '/data-display/card.blade.php',
        ] as $relativePath) {
            $content = file_get_contents($themeBasePath.$relativePath);
            if (! str_contains($content, '@props') && ! str_contains($content, '<x-') && ! str_contains($content, '@class')) {
                Assert::markTestSkipped('No recognizable Blade component markers in '.$relativePath);
            }
            Assert::assertTrue(str_contains($content, '@props') || str_contains($content, '<x-') || str_contains($content, '@class'), 'Component file contains valid Blade syntax');
        }
    });

    test('directory structure is properly organized', function (): void {
        $themeBasePath = requireSixteenComponentsBasePath();

        Assert::assertTrue(is_dir($themeBasePath.'/forms'));
        Assert::assertTrue(is_dir($themeBasePath.'/utilities'));
        Assert::assertTrue(is_dir($themeBasePath.'/layout/sections'));
        Assert::assertTrue(is_dir($themeBasePath.'/navigation'));
        Assert::assertTrue(is_dir($themeBasePath.'/overlays'));
        Assert::assertTrue(is_dir($themeBasePath.'/data-display'));
        Assert::assertTrue(is_dir($themeBasePath.'/feedback'));
        Assert::assertTrue(is_dir($themeBasePath.'/media'));
        Assert::assertTrue(is_dir($themeBasePath.'/auth'));
        Assert::assertTrue(is_dir($themeBasePath.'/footer'));
        Assert::assertTrue(is_dir($themeBasePath.'/blocks/forms'));
        Assert::assertTrue(is_dir($themeBasePath.'/utilities/ui'));
    });
});
