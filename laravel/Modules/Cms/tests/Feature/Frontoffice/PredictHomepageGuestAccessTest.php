<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Modules\Cms\Tests\TestCase;
use Modules\Predict\View\Composers\ThemeComposer as PredictThemeComposer;
use Modules\Xot\Datas\XotData;

uses(TestCase::class);

beforeEach(function (): void {
    config([
        'app.url' => 'http://predict.local',
        'xra.pub_theme' => 'TwentyOne',
        'xra.main_module' => 'Predict',
    ]);

    XotData::make()->update([
        'pub_theme' => 'TwentyOne',
        'main_module' => 'Predict',
    ]);

    $this->withServerVariables([
        'HTTP_HOST' => 'predict.local',
        'HTTPS' => 'off',
    ]);
});

it('serves /it for guests on predict.local without requiring login', function (): void {
    expect(Auth::check())->toBeFalse();

    $response = $this->get('/it');

    $response->assertOk();
    $response->assertDontSee('http-equiv="refresh"', false);
    $response->assertSee('<html', false);
    $response->assertSee('lang="it"', false);
});

it('returns an empty slider dataset instead of crashing when Predict banners are unavailable', function (): void {
    $data = app(PredictThemeComposer::class)->getMethodData('getBanner');

    expect($data)->toBeArray();
});
