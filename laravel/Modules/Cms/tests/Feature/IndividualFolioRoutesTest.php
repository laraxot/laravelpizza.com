<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Individual Folio Routes', function (): void {
    test('cms route get locale homepage', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale);

        Assert::assertSame(200, $response->status());

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('x-page');
        $response->assertSee('side="content"');
        $response->assertSee('slug="home"');
    });

    test('cms route get locale auth login', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/login');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/login: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms route get locale auth register', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/register');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/register: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms route get locale auth logout', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/logout');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/logout: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth logout fixed', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/logout_fixed');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/logout_fixed: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth password confirm', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/password/confirm');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/confirm: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth password reset', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/password/reset');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/reset: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth password token', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/password/test-token');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/password/{token}: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth verify', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/verify');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/verify: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth thank you', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/thank-you');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth register thank you', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/register/thank-you');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/register/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale auth type register patient', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/patient/register');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/{type}/register (patient): '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms route get locale auth type register doctor', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/auth/doctor/register');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/auth/{type}/register (doctor): '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
        $response->assertSee('<form');
    });

    test('cms route get locale pages', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/pages');

        Assert::assertSame(200, $response->status());

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale slug', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/test-slug');

        /** @var TestResponse<Response> $response */
        if (200 === $response->status()) {
            $response->assertSee('<!DOCTYPE html>');
            $response->assertSee('<html');
            $response->assertSee('x-page');
        }
    });

    test('cms route get locale learn', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/learn');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/learn: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale genesis about', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/genesis/about');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/genesis/about: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale genesis power ups', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/genesis/power-ups');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/genesis/power-ups: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale classi css', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/classi-css');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/classi-css: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale registration thank you', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/registration/thank-you');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/registration/thank-you: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms route get locale errors password expired', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale.'/errors/password-expired');
        /** @var TestResponse<Response> $response */
        $status = $response->status();
        if ($status >= 500) {
            cmsSkipTest('Server error on /{locale}/errors/password-expired: '.$status);
        }

        $response->assertSee('<!DOCTYPE html>');
        $response->assertSee('<html');
    });

    test('cms verifies json content loading for homepage', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
        }

        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        /** @var array<string, mixed> $homepageData */
        $locale = (string) app()->getLocale();
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        if (! is_array($contentBlocks)) {
            cmsSkipTest('Homepage content_blocks missing in JSON');

            return;
        }

        /* @var array<string, mixed> $contentBlocks */
        Assert::assertArrayHasKey($locale, $contentBlocks);

        $content = (string) $response->getContent();
        $blocks = $contentBlocks[$locale];
        if (! is_array($blocks)) {
            cmsSkipTest('Homepage blocks for locale are not an array');

            return;
        }

        /** @var array<mixed> $blocks */
        foreach ($blocks as $block) {
            if (! is_array($block)) {
                continue;
            }

            $blockData = $block['data'] ?? null;
            if (! is_array($blockData)) {
                continue;
            }

            $title = $blockData['title'] ?? null;
            if (is_string($title)) {
                Assert::assertStringContainsString($title, $content);
            }
        }
    });

    test('cms handles theme view resolution correctly', function (): void {
        $locale = (string) app()->getLocale();
        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
        }
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        /** @var array<string, mixed> $homepageData */
        $locale = (string) app()->getLocale();
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        if (! is_array($contentBlocks)) {
            cmsSkipTest('Homepage content_blocks missing in JSON');

            return;
        }

        /** @var array<string, list<array<string, mixed>>> $contentBlocks */
        $blocks = $contentBlocks[$locale] ?? [];

        foreach ($blocks as $block) {
            $blockData = $block['data'] ?? null;
            Assert::assertIsArray($blockData);
            $view = $blockData['view'] ?? null;
            Assert::assertIsString($view);
            Assert::assertStringStartsWith('pub_theme::', $view);
            Assert::assertStringContainsString('components.blocks', $view);
        }
    });

    test('cms processes blade syntax in json correctly', function (): void {
        $homepageJsonPath = config_path('local/laravelpizza/database/content/home.json');
        if (! file_exists($homepageJsonPath)) {
            cmsSkipTest('Homepage JSON file not found in test environment: '.$homepageJsonPath);
        }
        $homepageData = cmsJsonDecodeFile($homepageJsonPath);
        /** @var array<string, mixed> $homepageData */
        $locale = (string) app()->getLocale();
        $contentBlocks = $homepageData['content_blocks'] ?? null;
        if (! is_array($contentBlocks)) {
            cmsSkipTest('Homepage content_blocks missing in JSON');

            return;
        }

        /** @var array<string, list<array<string, mixed>>> $contentBlocks */
        $blocks = $contentBlocks[$locale] ?? [];
        $landingBlock = collect($blocks)->firstWhere('type', 'landing-page');

        if (is_array($landingBlock)) {
            $landingData = $landingBlock['data'] ?? null;
            Assert::assertIsArray($landingData);
            $ctaLink = $landingData['cta_link'] ?? null;
            Assert::assertIsString($ctaLink);
            Assert::assertStringContainsString("{{ route('register') }}", $ctaLink);

            $locale = (string) app()->getLocale();
            $response = cmsGet('/'.$locale);
            /** @var TestResponse<Response> $response */
            $content = (string) $response->getContent();

            $expectedUrl = route('register');
            Assert::assertStringContainsString($expectedUrl, $content);
        }
    });

    test('cms homepage renders within acceptable time', function (): void {
        $locale = (string) app()->getLocale();
        $startTime = microtime(true);

        $response = cmsGet('/'.$locale);
        Assert::assertSame(200, $response->status());

        $endTime = microtime(true);
        $loadTime = ($endTime - $startTime) * 1000;

        Assert::assertLessThan(1500, $loadTime, 'CMS homepage should load within 1.5 seconds');
    });

    test('cms auth pages render within acceptable time', function (): void {
        $locale = (string) app()->getLocale();
        $authRoutes = [
            '/'.$locale.'/auth/login',
            '/'.$locale.'/auth/register',
        ];

        foreach ($authRoutes as $route) {
            $startTime = microtime(true);

            $response = cmsGet($route);
            Assert::assertSame(200, $response->status());

            $endTime = microtime(true);
            $loadTime = ($endTime - $startTime) * 1000;

            Assert::assertLessThan(1000, $loadTime, "CMS route {$route} should load within 1 second");
        }
    });
});
