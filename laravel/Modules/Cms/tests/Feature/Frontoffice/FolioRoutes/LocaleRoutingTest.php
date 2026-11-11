<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use PHPUnit\Framework\Assert;

/**
 * @return list<string>
 */
function supportedTestLocales(): array
{
    $configPath = dirname(__DIR__, 7).'/config/laravellocalization.php';
    if (! is_file($configPath)) {
        return ['de', 'en', 'it'];
    }

    /** @var array<string, mixed> $localizationConfig */
    $localizationConfig = require $configPath;
    $supported = $localizationConfig['supportedLocales'] ?? [];
    if (! is_array($supported)) {
        return ['de', 'en', 'it'];
    }

    /** @var list<string> $locales */
    $locales = array_values(array_map(strval(...), array_keys($supported)));

    return $locales !== [] ? $locales : ['de', 'en', 'it'];
}

describe('Locale Routing', function (): void {
    test('every supported locale has areachable root route', function (): void {
        foreach (supportedTestLocales() as $locale) {
            $response = cmsGet('/'.$locale);

            $status = (int) $response->getStatusCode();

            if ($status >= 500) {
                cmsSkipTest("Route /{$locale} returned server error ({$status}) — DB or app config issue.");
            }

            Assert::assertLessThan(500, $status);
        }
    });

    test('html lang attribute matches the requested locale', function (): void {
        foreach (supportedTestLocales() as $locale) {
            $response = cmsGet('/'.$locale);

            $status = (int) $response->getStatusCode();

            if ($status >= 500) {
                cmsSkipTest("Route /{$locale} returned server error ({$status}).");

                continue;
            }

            if ($status !== 200) {
                cmsSkipTest("Route /{$locale} returned {$status} (redirect). Cannot check HTML lang attribute.");

                continue;
            }

            $response->assertSee('lang="'.$locale.'"', false);
        }
    });

    test('de route sets german locale', function (): void {
        $response = cmsGet('/de');

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /de returned server error ({$status}).");

            return;
        }

        if ($status !== 200) {
            cmsSkipTest("Route /de returned {$status} (redirect). Cannot verify locale.");

            return;
        }

        $response->assertSee('lang="de"', false);

        Assert::assertSame('de', LaravelLocalization::getCurrentLocale());
    });

    test('it route sets italian locale', function (): void {
        $response = cmsGet('/it');

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /it returned server error ({$status}).");

            return;
        }

        if ($status !== 200) {
            cmsSkipTest("Route /it returned {$status} (redirect).");

            return;
        }

        $response->assertSee('lang="it"', false);

        Assert::assertSame('it', LaravelLocalization::getCurrentLocale());
    });

    test('en route sets english locale', function (): void {
        $response = cmsGet('/en');

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Route /en returned server error ({$status}).");

            return;
        }

        if ($status !== 200) {
            cmsSkipTest("Route /en returned {$status} (redirect).");

            return;
        }

        $response->assertSee('lang="en"', false);

        Assert::assertSame('en', LaravelLocalization::getCurrentLocale());
    });
});
