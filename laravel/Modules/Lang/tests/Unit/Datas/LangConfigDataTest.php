<?php

declare(strict_types=1);

use Modules\Lang\Actions\ListLocaleOptionsAction;
use Modules\Lang\Actions\ResolveDefaultTranslatableLocaleAction;
use Modules\Lang\Actions\ResolveTranslatableLocalesAction;
use Modules\Lang\Datas\LangConfigData;
use Modules\Lang\Filament\Actions\LocaleSwitcherRefresh;
use Modules\Lang\Filament\Pages\SettingPage;
use Modules\Lang\Filament\Resources\TranslationFileResource;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\EditTranslationFile;
use Modules\Lang\Tests\Fixtures\LangBaseResourceStub;
use Modules\Lang\Tests\Support\FakeTenantLangConfig;
use Modules\Lang\Tests\TestCase;
use Webmozart\Assert\Assert;

uses(TestCase::class)->group('no-lang-db');

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('lang')
        ->and(SettingPage::getConfigDataClass())->toBe(LangConfigData::class)
        ->and(LangConfigData::tenantConfigName())->toBe('lang');
});

test('without a saved value the editors keep the languages they had hard coded', function (): void {
    $data = LangConfigData::from([]);

    expect($data->default_locale)->toBeNull()
        ->and($data->supported_locales)->toBe(['it', 'en']);
});

test('values from the tenant file override the defaults', function (): void {
    FakeTenantLangConfig::bind([
        'default_locale' => 'en',
        'supported_locales' => ['en', 'es'],
    ]);

    $data = LangConfigData::make();

    expect($data->default_locale)->toBe('en')
        ->and($data->supported_locales)->toBe(['en', 'es']);
});

test('every editor takes its languages from the settings', function (): void {
    FakeTenantLangConfig::bind([
        'default_locale' => 'es',
        'supported_locales' => ['it', 'en', 'es'],
    ]);

    expect(TranslationFileResource::getTranslatableLocales())->toBe(['it', 'en', 'es'])
        ->and(LangBaseResourceStub::getTranslatableLocales())->toBe(['it', 'en', 'es'])
        ->and((new EditTranslationFile)->getTranslatableLocales())->toBe(['it', 'en', 'es'])
        ->and(TranslationFileResource::getDefaultTranslatableLocale())->toBe('es')
        ->and(LangBaseResourceStub::getDefaultTranslatableLocale())->toBe('es');
});

test('until someone saves, the resources answer exactly as before', function (): void {
    FakeTenantLangConfig::bind([]);
    config(['app.locale' => 'en']);

    expect(TranslationFileResource::getTranslatableLocales())->toBe(['it', 'en'])
        ->and(TranslationFileResource::getDefaultTranslatableLocale())->toBe('en');
});

test('a default language outside the chosen ones is ignored', function (): void {
    FakeTenantLangConfig::bind([
        'default_locale' => 'de',
        'supported_locales' => ['it', 'en'],
    ]);

    expect(app(ResolveDefaultTranslatableLocaleAction::class)->execute('it'))->toBe('it');
});

test('an empty list of languages never reaches the editors', function (): void {
    FakeTenantLangConfig::bind(['supported_locales' => []]);

    expect(app(ResolveTranslatableLocalesAction::class)->execute())->toBe(['it', 'en']);
});

test('the language switcher offers the chosen languages and starts from the saved default', function (): void {
    FakeTenantLangConfig::bind([
        'default_locale' => 'en',
        'supported_locales' => ['en', 'it'],
    ]);
    session()->forget('locale');

    $action = LocaleSwitcherRefresh::make('locale_switch_settings');

    expect($action->lang)->toBe('en');
});

test('locale options show flag and native name, in the order asked', function (): void {
    config([
        'laravellocalization.supportedLocales' => [
            'it' => [
                'native' => 'italiano',
                'regional' => 'it_IT',
            ],
            'en' => [
                'native' => 'English',
                'regional' => 'en_GB',
            ],
        ],
    ]);

    $action = app(ListLocaleOptionsAction::class);

    expect($action->execute(['en', 'it']))->toBe([
        'en' => '🇬🇧 English',
        'it' => '🇮🇹 Italiano',
    ])
        ->and(array_keys($action->execute()))->toBe(['it', 'en'])
        ->and($action->execute(['xx']))->toBe(['xx' => 'xx']);
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(LangConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});
