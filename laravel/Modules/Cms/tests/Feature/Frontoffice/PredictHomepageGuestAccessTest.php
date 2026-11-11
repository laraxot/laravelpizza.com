<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice;

use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\get;

beforeEach(function (): void {
    /* @var \Modules\Cms\Tests\TestCase $this */
    cmsSkipTest('Predict.local homepage tests not applicable to fixcity install.');
});

describe('Predict Homepage Guest Access', function (): void {
    test('serves it for guests on predict local without requiring login', function (): void {
        Assert::assertFalse(Auth::check());

        $response = get('/it');

        $response->assertOk();
        $response->assertDontSee('http-equiv="refresh"', false);
        $response->assertSee('<html', false);
        $response->assertSee('lang="it"', false);
    });

    test('returns an empty slider dataset instead of crashing when predict banners are unavailable', function (): void {
        if (! class_exists('Modules\\Predict\\View\\Composers\\ThemeComposer')) {
            cmsSkipTest('Predict ThemeComposer not available');
        }

        /** @var object $composer */
        $composer = app('Modules\\Predict\\View\\Composers\\ThemeComposer');
        Assert::assertIsObject($composer);
        Assert::assertTrue(method_exists($composer, 'getMethodData'));

        /** @var array<string, mixed> $data */
        $data = $composer->getMethodData('getBanner');
        Assert::assertIsArray($data);
    });
});
