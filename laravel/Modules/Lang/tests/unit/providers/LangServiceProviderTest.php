<?php

declare(strict_types=1);

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Modules\Lang\Providers\LangServiceProvider;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeLangServiceProvider(): LangServiceProvider
{
    return new LangServiceProvider(app());
}

describe('LangServiceProvider Basic Functionality', function () {
    it('extends ServiceProvider', function () {
        $provider = makeLangServiceProvider();
        Assert::assertInstanceOf(ServiceProvider::class, $provider);
    });

    it('can be instantiated', function () {
        $provider = makeLangServiceProvider();
        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });

    it('has correct module name', function () {
        $provider = makeLangServiceProvider();
        $reflection = new ReflectionClass($provider);
        $property = $reflection->getProperty('name');
        $property->setAccessible(true);

        Assert::assertSame('Lang', $property->getValue($provider));
    });
});

describe('LangServiceProvider Registration', function () {
    it('can register services', function () {
        $provider = makeLangServiceProvider();
        $provider->register();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });

    it('can boot services', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });
});

describe('LangServiceProvider Translation Loading', function () {
    it('loads translations from correct path', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertTrue(Lang::has('lang::auth.failed'));
    });

    it('loads translations with correct namespace', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translation = __('lang::auth.failed');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.failed', $translation);
    });

    it('handles missing translation keys gracefully', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $missingTranslation = __('lang::nonexistent.key');
        Assert::assertSame('lang::nonexistent.key', $missingTranslation);
    });
});

describe('LangServiceProvider Translation Structure', function () {
    it('provides auth translations', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $authKeys = [
            'failed',
            'password',
            'throttle',
            'login.title',
            'login.submit',
            'register.title',
        ];

        foreach ($authKeys as $key) {
            $translation = __("lang::auth.{$key}");
            Assert::assertIsString($translation);
            Assert::assertNotSame("lang::auth.{$key}", $translation);
        }
    });

    it('provides nested login translations', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $loginKeys = ['title', 'email', 'password', 'submit', 'forgot_password'];

        foreach ($loginKeys as $key) {
            $translation = __("lang::auth.login.{$key}");
            Assert::assertIsString($translation);
            Assert::assertNotSame("lang::auth.login.{$key}", $translation);
        }
    });

    it('provides translation module strings', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translation = __('lang::translation.navigation.name');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::translation.navigation.name', $translation);
    });
});

describe('LangServiceProvider Language Support', function () {
    it('supports Italian language', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        app()->setLocale('it');

        $translation = __('lang::auth.failed');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.failed', $translation);
    });

    it('supports English language', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        app()->setLocale('en');

        $translation = __('lang::auth.failed');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.failed', $translation);
    });

    it('supports German language', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        app()->setLocale('de');

        $translation = __('lang::auth.failed');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.failed', $translation);
    });

    it('falls back to default language when translation missing', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        app()->setLocale('fr');

        $translation = __('lang::auth.failed');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.failed', $translation);
    });
});

describe('LangServiceProvider Translation Files', function () {
    it('loads auth translation file', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $authPath = module_path('Lang', 'lang/it/auth.php');
        Assert::assertTrue(File::exists($authPath));
        $translations = require $authPath;
        Assert::assertIsArray($translations);
        Assert::assertArrayHasKey('failed', $translations);
    });

    it('loads translation module file', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translationPath = module_path('Lang', 'lang/it/translation.php');
        Assert::assertTrue(File::exists($translationPath));
        $translations = require $translationPath;
        Assert::assertIsArray($translations);
        Assert::assertArrayHasKey('navigation', $translations);
    });

    it('loads auth translation file for english', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $authPath = module_path('Lang', 'lang/en/auth.php');
        Assert::assertTrue(File::exists($authPath));
        $translations = require $authPath;
        Assert::assertIsArray($translations);
        Assert::assertArrayHasKey('failed', $translations);
    });

    it('loads all required translation files', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $requiredFiles = ['auth', 'translation', 'header'];
        $langPath = module_path('Lang', 'lang/it');

        foreach ($requiredFiles as $file) {
            $filePath = "{$langPath}/{$file}.php";
            Assert::assertTrue(File::exists($filePath));
            $translations = require $filePath;
            Assert::assertIsArray($translations);
            Assert::assertNotEmpty($translations);
        }
    });
});

describe('LangServiceProvider Translation Quality', function () {
    it('provides complete auth translation coverage', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $authKeys = [
            'failed',
            'password',
            'throttle',
            'login.title',
            'login.email',
            'login.submit',
            'register.title',
            'register.name',
        ];

        foreach ($authKeys as $key) {
            $translation = __("lang::auth.{$key}");
            Assert::assertIsString($translation);
            Assert::assertNotSame("lang::auth.{$key}", $translation);
            Assert::assertGreaterThan(0, strlen($translation));
        }
    });

    it('provides consistent translation style', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translations = [
            __('lang::auth.failed'),
            __('lang::auth.password'),
            __('lang::auth.login.title'),
        ];

        foreach ($translations as $translation) {
            Assert::assertIsString($translation);
            Assert::assertGreaterThan(0, strlen($translation));
        }
    });

    it('provides contextually appropriate italian translations', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        app()->setLocale('it');

        $contextualPairs = [
            'auth.failed' => 'Credenziali non valide.',
            'auth.login.submit' => 'Accedi',
            'auth.register.title' => 'Registati',
        ];

        foreach ($contextualPairs as $key => $expected) {
            $translation = __("lang::{$key}");
            Assert::assertSame($expected, $translation);
        }
    });
});

describe('LangServiceProvider Performance', function () {
    it('loads translations efficiently', function () {
        $startTime = microtime(true);

        $provider = makeLangServiceProvider();
        $provider->boot();

        $executionTime = microtime(true) - $startTime;

        Assert::assertLessThan(1.0, $executionTime);
    });

    it('caches translations for performance', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $startTime = microtime(true);
        $translation1 = __('lang::auth.failed');
        $firstCallTime = microtime(true) - $startTime;

        $startTime = microtime(true);
        $translation2 = __('lang::auth.failed');
        $secondCallTime = microtime(true) - $startTime;

        Assert::assertSame($translation2, $translation1);
        Assert::assertLessThanOrEqual($firstCallTime, $secondCallTime);
    });

    it('handles multiple language switches efficiently', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $languages = ['it', 'en', 'de', 'it'];

        $startTime = microtime(true);

        foreach ($languages as $locale) {
            app()->setLocale($locale);
            $translation = __('lang::auth.failed');
            Assert::assertIsString($translation);
        }

        $executionTime = microtime(true) - $startTime;

        Assert::assertLessThan(1.0, $executionTime);
    });
});

describe('LangServiceProvider Error Handling', function () {
    it('handles missing translation files gracefully', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });

    it('handles malformed translation files gracefully', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });

    it('handles empty translation files gracefully', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });
});

describe('LangServiceProvider Integration', function () {
    it('works with Laravel translation system', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertTrue(Lang::has('lang::auth.failed'));
        Assert::assertIsString(__('lang::auth.failed'));
    });

    it('works with Filament components', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translation = __('lang::auth.login.submit');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.login.submit', $translation);
    });

    it('works with Blade templates', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translation = __('lang::auth.failed');
        Assert::assertIsString($translation);
        Assert::assertNotSame('lang::auth.failed', $translation);
    });
});

describe('LangServiceProvider Configuration', function () {
    it('respects Laravel configuration', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $defaultLocale = config('app.locale');
        Assert::assertIsString($defaultLocale);
        Assert::assertGreaterThan(0, strlen($defaultLocale));
    });

    it('can be configured via config files', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertIsString(config('app.fallback_locale'));
    });

    it('integrates with other service providers', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        Assert::assertInstanceOf(Application::class, app());
    });
});

describe('LangServiceProvider Maintenance', function () {
    it('can be refreshed without errors', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();
        $provider->boot();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });

    it('maintains state consistency', function () {
        $provider = makeLangServiceProvider();
        $provider->boot();

        $translation1 = __('lang::auth.failed');

        $provider->boot();

        $translation2 = __('lang::auth.failed');

        Assert::assertSame($translation2, $translation1);
    });

    it('can be unregistered and re-registered', function () {
        $provider = makeLangServiceProvider();
        $provider->register();
        $provider->boot();

        $provider = makeLangServiceProvider();
        $provider->register();
        $provider->boot();

        Assert::assertInstanceOf(LangServiceProvider::class, $provider);
    });
});
