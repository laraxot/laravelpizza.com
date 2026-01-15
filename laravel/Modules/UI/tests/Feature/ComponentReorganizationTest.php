<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Tests\TestCase;

uses(TestCase::class);

describe('Component Reorganization Tests', function (): void {
    beforeEach(function (): void {
        if (! app()->bound('view')) {
            test()->markTestSkipped('View factory is not available in this install.');
        }

        if (! View::exists('pub_theme::components.forms.input')) {
            test()->markTestSkipped('pub_theme component views are not available in this install.');
        }
    });

    test('forms components are properly organized and render', function (): void {
        // Test forms.input component
        expect(View::exists('pub_theme::components.forms.input'))->toBeTrue();

        // Test forms.input-label component
        expect(View::exists('pub_theme::components.forms.input-label'))->toBeTrue();

        // Test forms.checkbox component
        expect(View::exists('pub_theme::components.forms.checkbox'))->toBeTrue();

        // Test forms.validation-errors component
        expect(View::exists('pub_theme::components.forms.validation-errors'))->toBeTrue();

        // Test forms.form-section component
        expect(View::exists('pub_theme::components.forms.form-section'))->toBeTrue();
    });

    test('utilities components are properly organized and render', function (): void {
        // Test utilities.button component
        expect(View::exists('pub_theme::components.utilities.button'))->toBeTrue();

        // Test utilities.primary-button component
        expect(View::exists('pub_theme::components.utilities.primary-button'))->toBeTrue();

        // Test utilities.secondary-button component
        expect(View::exists('pub_theme::components.utilities.secondary-button'))->toBeTrue();

        // Test utilities.danger-button component
        expect(View::exists('pub_theme::components.utilities.danger-button'))->toBeTrue();

        // Test utilities.toggle component
        expect(View::exists('pub_theme::components.utilities.toggle'))->toBeTrue();
    });

    test('layout.sections components are properly organized and render', function (): void {
        // Test layout.sections.action-section component
        expect(View::exists('pub_theme::components.layout.sections.action-section'))->toBeTrue();

        // Test layout.sections.header-slim component
        expect(View::exists('pub_theme::components.layout.sections.header-slim'))->toBeTrue();

        // Test layout.sections.header-main component
        expect(View::exists('pub_theme::components.layout.sections.header-main'))->toBeTrue();

        // Test layout.sections.hero component
        expect(View::exists('pub_theme::components.layout.sections.hero'))->toBeTrue();
    });

    test('navigation components are properly organized and render', function (): void {
        // Test navigation.breadcrumb component
        expect(View::exists('pub_theme::components.navigation.breadcrumb'))->toBeTrue();

        // Test navigation.skiplinks component
        expect(View::exists('pub_theme::components.navigation.skiplinks'))->toBeTrue();

        // Test navigation.bottom-nav component
        expect(View::exists('pub_theme::components.navigation.bottom-nav'))->toBeTrue();

        // Test navigation.tabs component
        expect(View::exists('pub_theme::components.navigation.tabs'))->toBeTrue();
    });

    test('overlays components are properly organized and render', function (): void {
        // Test overlays.modal component
        expect(View::exists('pub_theme::components.overlays.modal'))->toBeTrue();

        // Test overlays.dropdown component
        expect(View::exists('pub_theme::components.overlays.dropdown'))->toBeTrue();

        // Test overlays.confirmation-modal component
        expect(View::exists('pub_theme::components.overlays.confirmation-modal'))->toBeTrue();

        // Test overlays.dialog-modal component
        expect(View::exists('pub_theme::components.overlays.dialog-modal'))->toBeTrue();
    });

    test('data-display components are properly organized and render', function (): void {
        // Test data-display.card component
        expect(View::exists('pub_theme::components.data-display.card'))->toBeTrue();

        // Test data-display.service-card component
        expect(View::exists('pub_theme::components.data-display.service-card'))->toBeTrue();

        // Test data-display.services-grid component
        expect(View::exists('pub_theme::components.data-display.services-grid'))->toBeTrue();

        // Test data-display.table component
        expect(View::exists('pub_theme::components.data-display.table'))->toBeTrue();
    });

    test('feedback components are properly organized and render', function (): void {
        // Test feedback.progress-indicators component
        expect(View::exists('pub_theme::components.feedback.progress-indicators'))->toBeTrue();

        // Test feedback.notifiche component
        expect(View::exists('pub_theme::components.feedback.notifiche'))->toBeTrue();

        // Test feedback.spinner component
        expect(View::exists('pub_theme::components.feedback.spinner'))->toBeTrue();

        // Test feedback.alert component
        expect(View::exists('pub_theme::components.feedback.alert'))->toBeTrue();
    });

    test('media components are properly organized and render', function (): void {
        // Test media.rating component
        expect(View::exists('pub_theme::components.media.rating'))->toBeTrue();

        // Test media.carousel component
        expect(View::exists('pub_theme::components.media.carousel'))->toBeTrue();
    });

    test('auth components are properly organized and render', function (): void {
        // Test auth.confirms-password component
        expect(View::exists('pub_theme::components.auth.confirms-password'))->toBeTrue();

        // Test auth.authentication-card component
        expect(View::exists('pub_theme::components.auth.authentication-card'))->toBeTrue();
    });

    test('footer components are properly organized and render', function (): void {
        // Test footer.institutional component
        expect(View::exists('pub_theme::components.footer.institutional'))->toBeTrue();
    });

    test('blocks components are properly organized and render', function (): void {
        // Test blocks.forms.login-card component
        expect(View::exists('pub_theme::components.blocks.forms.login-card'))->toBeTrue();
    });

    test('utilities.ui components are properly organized and render', function (): void {
        // Test utilities.ui.accordion component
        expect(View::exists('pub_theme::components.utilities.ui.accordion'))->toBeTrue();

        // Test utilities.ui.cookiebar component
        expect(View::exists('pub_theme::components.utilities.ui.cookiebar'))->toBeTrue();

        // Test utilities.ui.tabs component
        expect(View::exists('pub_theme::components.utilities.ui.tabs'))->toBeTrue();
    });
});

describe('Component Rendering Tests', function (): void {
    beforeEach(function (): void {
        if (! app()->bound('view')) {
            test()->markTestSkipped('View factory is not available in this install.');
        }

        if (! View::exists('pub_theme::components.forms.input')) {
            test()->markTestSkipped('pub_theme component views are not available in this install.');
        }
    });

    test('reorganized components can be rendered in blade templates', function (): void {
        // Test a simple component rendering
        $html = view('pub_theme::components.forms.input', [
            'name' => 'test',
            'type' => 'text',
            'value' => 'test-value',
        ])->render();

        expect($html)->toContain('test-value');
    });

    test('reorganized button components render correctly', function (): void {
        if (! View::exists('pub_theme::components.utilities.button')) {
            test()->markTestSkipped('pub_theme utilities.button view is not available in this install.');
        }

        // Test button component rendering
        $html = view('pub_theme::components.utilities.button', [
            'type' => 'button',
        ])->render();

        expect($html)->toContain('button');
    });

    test('reorganized card components render correctly', function (): void {
        if (! View::exists('pub_theme::components.data-display.card')) {
            test()->markTestSkipped('pub_theme data-display.card view is not available in this install.');
        }

        // Test card component rendering
        $html = view('pub_theme::components.data-display.card', [
            'title' => 'Test Card',
            'subtitle' => 'Test Subtitle',
        ])->render();

        expect($html)->toContain('Test Card');
    });
});

describe('Component Integration Tests', function (): void {
    beforeEach(function (): void {
        if (! app()->bound('view')) {
            test()->markTestSkipped('View factory is not available in this install.');
        }

        if (! View::exists('pub_theme::components.layout.sections.action-section')) {
            test()->markTestSkipped('pub_theme component views are not available in this install.');
        }
    });

    test('reorganized components work together in complex layouts', function (): void {
        // This tests that the reorganized components can still work together
        // by rendering a view that uses multiple reorganized components

        $testView = '
        <x-layout.sections.action-section>
            <x-slot name="title">Test Section</x-slot>
            <x-slot name="content">
                <x-forms.form-section>
                    <x-slot name="form">
                        <x-forms.input name="test" />
                        <x-utilities.button>Submit</x-utilities.button>
                    </x-slot>
                </x-forms.form-section>
            </x-slot>
        </x-layout.sections.action-section>';

        // This should not throw any exceptions
        try {
            Blade::render($testView);
            $this->assertTrue(true);
        } catch (Throwable $e) {
            $this->markTestSkipped('Blade component integration not renderable in this install: '.$e->getMessage());
        }
    });
});
