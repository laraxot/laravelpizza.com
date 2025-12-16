<?php

declare(strict_types=1);

describe('Component Files Existence Tests', static function (): void {
    test('reorganized component files exist in correct locations', static function (): void {
        $themeBasePath = '/var/www/html/_bases/base_<nome progetto>_fila3_mono/laravel/Themes/Sixteen/resources/views/components';

        // Test forms components exist
        expect(file_exists($themeBasePath.'/forms/input.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/forms/input-label.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/forms/checkbox.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/forms/validation-errors.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/forms/form-section.blade.php'))->toBeTrue();

        // Test utilities components exist
        expect(file_exists($themeBasePath.'/utilities/button.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/utilities/primary-button.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/utilities/secondary-button.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/utilities/danger-button.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/utilities/toggle.blade.php'))->toBeTrue();

        // Test layout.sections components exist
        expect(file_exists($themeBasePath.'/layout/sections/action-section.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/layout/sections/header-slim.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/layout/sections/header-main.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/layout/sections/hero.blade.php'))->toBeTrue();

        // Test navigation components exist
        expect(file_exists($themeBasePath.'/navigation/breadcrumb.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/navigation/skiplinks.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/navigation/bottom-nav.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/navigation/tabs.blade.php'))->toBeTrue();

        // Test overlays components exist
        expect(file_exists($themeBasePath.'/overlays/modal.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/overlays/dropdown.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/overlays/confirmation-modal.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/overlays/dialog-modal.blade.php'))->toBeTrue();

        // Test data-display components exist
        expect(file_exists($themeBasePath.'/data-display/card.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/data-display/service-card.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/data-display/services-grid.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/data-display/table.blade.php'))->toBeTrue();

        // Test feedback components exist
        expect(file_exists($themeBasePath.'/feedback/progress-indicators.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/feedback/notifiche.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/feedback/spinner.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/feedback/alert.blade.php'))->toBeTrue();

        // Test media components exist
        expect(file_exists($themeBasePath.'/media/rating.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/media/carousel.blade.php'))->toBeTrue();

        // Test auth components exist
        expect(file_exists($themeBasePath.'/auth/confirms-password.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/auth/authentication-card.blade.php'))->toBeTrue();

        // Test footer components exist
        expect(file_exists($themeBasePath.'/footer/institutional.blade.php'))->toBeTrue();

        // Test blocks components exist
        expect(file_exists($themeBasePath.'/blocks/forms/login-card.blade.php'))->toBeTrue();

        // Test nested utilities.ui components exist
        expect(file_exists($themeBasePath.'/utilities/ui/accordion.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/utilities/ui/cookiebar.blade.php'))->toBeTrue();
        expect(file_exists($themeBasePath.'/utilities/ui/tabs.blade.php'))->toBeTrue();
    });

    test('no old component files remain in root components directory', static function (): void {
        $themeBasePath = '/var/www/html/_bases/base_<nome progetto>_fila3_mono/laravel/Themes/Sixteen/resources/views/components';

        // These should NOT exist in the root anymore (they should be in subdirectories)
        expect(file_exists($themeBasePath.'/input.blade.php'))->toBeFalse();
        expect(file_exists($themeBasePath.'/button.blade.php'))->toBeFalse();
        expect(file_exists($themeBasePath.'/card.blade.php'))->toBeFalse();
        expect(file_exists($themeBasePath.'/modal.blade.php'))->toBeFalse();
        expect(file_exists($themeBasePath.'/dropdown.blade.php'))->toBeFalse();
    });

    test('component files contain proper blade syntax', static function (): void {
        $themeBasePath = '/var/www/html/_bases/base_<nome progetto>_fila3_mono/laravel/Themes/Sixteen/resources/views/components';

        // Test a few key components have proper Blade syntax
        $buttonContent = file_get_contents($themeBasePath.'/utilities/button.blade.php');
        expect($buttonContent)->toContain('@props');

        $inputContent = file_get_contents($themeBasePath.'/forms/input.blade.php');
        expect($inputContent)->toContain('@props');

        $cardContent = file_get_contents($themeBasePath.'/data-display/card.blade.php');
        expect($cardContent)->toContain('@props');
    });

    test('directory structure is properly organized', static function (): void {
        $themeBasePath = '/var/www/html/_bases/base_<nome progetto>_fila3_mono/laravel/Themes/Sixteen/resources/views/components';

        // Test that directories exist
        expect(is_dir($themeBasePath.'/forms'))->toBeTrue();
        expect(is_dir($themeBasePath.'/utilities'))->toBeTrue();
        expect(is_dir($themeBasePath.'/layout/sections'))->toBeTrue();
        expect(is_dir($themeBasePath.'/navigation'))->toBeTrue();
        expect(is_dir($themeBasePath.'/overlays'))->toBeTrue();
        expect(is_dir($themeBasePath.'/data-display'))->toBeTrue();
        expect(is_dir($themeBasePath.'/feedback'))->toBeTrue();
        expect(is_dir($themeBasePath.'/media'))->toBeTrue();
        expect(is_dir($themeBasePath.'/auth'))->toBeTrue();
        expect(is_dir($themeBasePath.'/footer'))->toBeTrue();
        expect(is_dir($themeBasePath.'/blocks/forms'))->toBeTrue();
        expect(is_dir($themeBasePath.'/utilities/ui'))->toBeTrue();
    });
});
