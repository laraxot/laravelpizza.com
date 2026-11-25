<?php

declare(strict_types=1);

use Modules\Xot\Actions\ListMainModuleCandidatesAction;
use Modules\Xot\Actions\ListSupportedLocalesAction;
use Modules\Xot\Datas\XotConfigData;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Pages\SettingPage;
use Modules\Xot\Tests\TestCase;
use Nwidart\Modules\Facades\Module;
use Webmozart\Assert\Assert;

uses(TestCase::class)->group('no-xot-db');

/**
 * @return list<string>
 */
function xotConfigDataProperties(): array
{
    return array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(XotConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );
}

test('xot settings live in the xra tenant file because XotData reads them from there', function (): void {
    expect(XotConfigData::tenantConfigName())->toBe('xra')
        ->and(SettingPage::getConfigName())->toBe('xra')
        ->and(SettingPage::getConfigDataClass())->toBe(XotConfigData::class);
});

test('every default equals the default of XotData so an untouched site keeps today behaviour', function (): void {
    foreach (xotConfigDataProperties() as $name) {
        $setting = new ReflectionProperty(XotConfigData::class, $name);
        $runtime = new ReflectionProperty(XotData::class, $name);

        expect($setting->hasDefaultValue())->toBeTrue("{$name} has no default in XotConfigData")
            ->and($setting->getDefaultValue())->toBe($runtime->getDefaultValue(), "{$name} differs from XotData");
    }
});

test('values from the tenant file override the defaults', function (): void {
    $data = XotConfigData::from([
        'main_module' => 'Trade',
        'primary_lang' => 'en',
        'force_ssl' => true,
        'disable_database_notifications' => false,
    ]);

    expect($data->main_module)->toBe('Trade')
        ->and($data->primary_lang)->toBe('en')
        ->and($data->force_ssl)->toBeTrue()
        ->and($data->disable_database_notifications)->toBeFalse();
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect($schema)->not->toBeEmpty()
        ->and(array_keys($schema))->toEqualCanonicalizing(xotConfigDataProperties());
});

test('the main module can only be one that has an admin panel', function (): void {
    $candidates = app(ListMainModuleCandidatesAction::class)->execute();

    expect($candidates)->not->toBeEmpty()
        ->and(array_keys($candidates))->toBe(array_values($candidates));

    foreach ($candidates as $name) {
        $module = Module::find($name);
        Assert::notNull($module);

        expect(is_file($module->getPath().'/app/Providers/Filament/AdminPanelProvider.php'))->toBeTrue("{$name} has no admin panel");
    }
});

test('the primary language can only be one the site supports', function (): void {
    $locales = app(ListSupportedLocalesAction::class)->execute();

    expect($locales)->toHaveKeys(['it', 'en']);
});
