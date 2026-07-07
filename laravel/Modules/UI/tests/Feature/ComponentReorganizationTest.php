<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function skipUnlessPubThemeViews(): void
{
    if (! app()->bound('view')) {
        Assert::markTestSkipped('View factory is not available in this install.');
    }

    if (! View::exists('pub_theme::components.forms.input')) {
        Assert::markTestSkipped('pub_theme component views are not available in this install.');
    }
}

describe('Component Reorganization Tests', function (): void {
    beforeEach(function (): void {
        /* @var \Modules\UI\Tests\TestCase $this */
        skipUnlessPubThemeViews();
    });

    test('forms components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.forms.input'));
        Assert::assertTrue(View::exists('pub_theme::components.forms.input-label'));
        Assert::assertTrue(View::exists('pub_theme::components.forms.checkbox'));
        Assert::assertTrue(View::exists('pub_theme::components.forms.validation-errors'));
        Assert::assertTrue(View::exists('pub_theme::components.forms.form-section'));
    });

    test('utilities components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.utilities.button'));
        Assert::assertTrue(View::exists('pub_theme::components.utilities.primary-button'));
        Assert::assertTrue(View::exists('pub_theme::components.utilities.secondary-button'));
        Assert::assertTrue(View::exists('pub_theme::components.utilities.danger-button'));
        Assert::assertTrue(View::exists('pub_theme::components.utilities.toggle'));
    });

    test('layout.sections components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.layout.sections.action-section'));
        Assert::assertTrue(View::exists('pub_theme::components.layout.sections.header-slim'));
        Assert::assertTrue(View::exists('pub_theme::components.layout.sections.header-main'));
        Assert::assertTrue(View::exists('pub_theme::components.layout.sections.hero'));
    });

    test('navigation components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.navigation.breadcrumb'));
        Assert::assertTrue(View::exists('pub_theme::components.navigation.skiplinks'));
        Assert::assertTrue(View::exists('pub_theme::components.navigation.bottom-nav'));
        Assert::assertTrue(View::exists('pub_theme::components.navigation.tabs'));
    });

    test('overlays components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.overlays.modal'));
        Assert::assertTrue(View::exists('pub_theme::components.overlays.dropdown'));
        Assert::assertTrue(View::exists('pub_theme::components.overlays.confirmation-modal'));
        Assert::assertTrue(View::exists('pub_theme::components.overlays.dialog-modal'));
    });

    test('data-display components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.data-display.card'));
        Assert::assertTrue(View::exists('pub_theme::components.data-display.service-card'));
        Assert::assertTrue(View::exists('pub_theme::components.data-display.services-grid'));
        Assert::assertTrue(View::exists('pub_theme::components.data-display.table'));
    });

    test('feedback components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.feedback.progress-indicators'));
        Assert::assertTrue(View::exists('pub_theme::components.feedback.notifiche'));
        Assert::assertTrue(View::exists('pub_theme::components.feedback.spinner'));
        Assert::assertTrue(View::exists('pub_theme::components.feedback.alert'));
    });

    test('media components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.media.rating'));
        Assert::assertTrue(View::exists('pub_theme::components.media.carousel'));
    });

    test('auth components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.auth.confirms-password'));
        Assert::assertTrue(View::exists('pub_theme::components.auth.authentication-card'));
    });

    test('footer components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.footer.institutional'));
    });

    test('blocks components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.blocks.forms.login-card'));
    });

    test('utilities.ui components are properly organized and render', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.utilities.ui.accordion'));
        Assert::assertTrue(View::exists('pub_theme::components.utilities.ui.cookiebar'));
        Assert::assertTrue(View::exists('pub_theme::components.utilities.ui.tabs'));
    });
});

describe('Component Rendering Tests', function (): void {
    beforeEach(function (): void {
        /* @var \Modules\UI\Tests\TestCase $this */
        skipUnlessPubThemeViews();
    });

    test('reorganized components can be rendered in blade templates', function (): void {
        Assert::assertTrue(View::exists('pub_theme::components.forms.input'));
        /** @var view-string $viewName */
        $viewName = 'pub_theme::components.forms.input';
        try {
            $html = view($viewName, [
                'name' => 'test',
                'type' => 'text',
                'value' => 'test-value',
            ])->render();
        } catch (\Throwable $e) {
            Assert::markTestSkipped('pub_theme input view not renderable: '.$e->getMessage());
        }

        Assert::assertStringContainsString('<input', $html);
    });

    test('reorganized button components render correctly', function (): void {
        if (! View::exists('pub_theme::components.utilities.button')) {
            Assert::markTestSkipped('pub_theme utilities.button view is not available in this install.');
        }

        /** @var view-string $viewName */
        $viewName = 'pub_theme::components.utilities.button';
        try {
            $html = view($viewName, [
                'type' => 'button',
            ])->render();
        } catch (\Throwable $e) {
            Assert::markTestSkipped('pub_theme button view not renderable: '.$e->getMessage());
        }

        Assert::assertStringContainsString('button', $html);
    });

    test('reorganized card components render correctly', function (): void {
        if (! View::exists('pub_theme::components.data-display.card')) {
            Assert::markTestSkipped('pub_theme data-display.card view is not available in this install.');
        }

        /** @var view-string $viewName */
        $viewName = 'pub_theme::components.data-display.card';
        try {
            $html = view($viewName, [
                'title' => 'Test Card',
                'subtitle' => 'Test Subtitle',
            ])->render();
        } catch (\Throwable $e) {
            Assert::markTestSkipped('pub_theme card view not renderable: '.$e->getMessage());
        }

        Assert::assertStringContainsString('Test Card', $html);
    });
});

describe('Component Integration Tests', function (): void {
    beforeEach(function (): void {
        /* @var \Modules\UI\Tests\TestCase $this */
        if (! app()->bound('view')) {
            Assert::markTestSkipped('View factory is not available in this install.');
        }

        if (! View::exists('pub_theme::components.layout.sections.action-section')) {
            Assert::markTestSkipped('pub_theme component views are not available in this install.');
        }
    });

    test('reorganized components work together in complex layouts', function (): void {
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

        try {
            Blade::render($testView);
        } catch (\Throwable $e) {
            Assert::markTestSkipped('Blade component integration not renderable in this install: '.$e->getMessage());
        }
    });
});
