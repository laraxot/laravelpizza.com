<?php

declare(strict_types=1);

use Modules\Rating\Datas\RatingConfigData;
use Modules\Rating\Filament\Pages\SettingPage;
use Modules\Rating\Tests\TestCase;

uses(TestCase::class)->group('no-rating-db');

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('rating')
        ->and(SettingPage::getConfigDataClass())->toBe(RatingConfigData::class);
});

test('config data reads the tenant file named after the module', function (): void {
    expect(RatingConfigData::tenantConfigName())->toBe('rating');
});
