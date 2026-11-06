<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\UI\Datas\UIConfigData;
use Modules\UI\Filament\Pages\SettingPage;
use Modules\UI\Filament\Widgets\DarkModeSwitcherWidget;
use Modules\UI\Tests\Support\FakeTenantUiConfig;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-ui-db');

/**
 * @return list<string>
 */
function uiConfigPropertyNames(): array
{
    return array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(UIConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );
}

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('ui')
        ->and(SettingPage::getConfigDataClass())->toBe(UIConfigData::class);
});

test('config data reads the tenant file named after the module', function (): void {
    expect(UIConfigData::tenantConfigName())->toBe('ui');
});

test('the dark mode switcher is enabled by default, as before the setting existed', function (): void {
    FakeTenantUiConfig::bind([]);

    expect(UIConfigData::make()->dark_mode_switcher_enabled)->toBeTrue();
});

test('a tenant array overrides the dark mode switcher default', function (): void {
    FakeTenantUiConfig::bind(['dark_mode_switcher_enabled' => false]);

    expect(UIConfigData::make()->dark_mode_switcher_enabled)->toBeFalse();
});

test('a missing tenant file gives the defaults', function (): void {
    if (is_file(app(GetTenantFilePathAction::class)->execute('ui.php'))) {
        Assert::markTestSkipped('Il tenant corrente ha un file ui.php: i default non sono osservabili.');
    }

    expect(UIConfigData::make()->toArray())->toBe(UIConfigData::from([])->toArray())
        ->and(UIConfigData::make()->dark_mode_switcher_enabled)->toBeTrue();
});

test('the dark mode switcher widget follows the saved tenant setting', function (): void {
    FakeTenantUiConfig::bind([]);
    expect(DarkModeSwitcherWidget::canView())->toBeTrue();

    FakeTenantUiConfig::bind(['dark_mode_switcher_enabled' => false]);
    expect(DarkModeSwitcherWidget::canView())->toBeFalse();
});

test('setting page form keys equal the public properties of the data', function (): void {
    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))->invoke(new SettingPage);
    $keys = array_keys(is_array($schema) ? $schema : []);
    $properties = uiConfigPropertyNames();
    sort($keys);
    sort($properties);

    expect($keys)->not->toBe([])
        ->and($keys)->toBe($properties);
});

test('every setting field has a label in it and en', function (): void {
    foreach (['it', 'en'] as $locale) {
        $lang = require dirname(__DIR__, 3).'/lang/'.$locale.'/setting.php';

        foreach (uiConfigPropertyNames() as $property) {
            expect(data_get($lang, 'fields.'.$property.'.label', ''))->not->toBe('');
        }
    }
});
