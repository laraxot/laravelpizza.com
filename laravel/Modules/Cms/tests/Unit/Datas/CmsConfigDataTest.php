<?php

declare(strict_types=1);

use Modules\Cms\Actions\ListInstalledThemesAction;
use Modules\Cms\Datas\CmsConfigData;
use Modules\Cms\Filament\Pages\SettingPage;
use Webmozart\Assert\Assert;

test('cms settings live in the xra tenant file because XotData reads the theme from there', function (): void {
    expect(CmsConfigData::tenantConfigName())->toBe('xra')
        ->and(SettingPage::getConfigName())->toBe('xra');
});

test('without a saved value the public theme is empty and theme registration stays off', function (): void {
    $data = CmsConfigData::from([]);

    expect($data->pub_theme)->toBe('')
        ->and($data->register_pub_theme)->toBeFalse();
});

test('values from the tenant file override the defaults', function (): void {
    $data = CmsConfigData::from([
        'pub_theme' => 'Four',
        'register_pub_theme' => true,
        'adm_theme' => 'AdminLTE',
    ]);

    expect($data->pub_theme)->toBe('Four')
        ->and($data->register_pub_theme)->toBeTrue();
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(CmsConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});

test('the theme choices are the installed themes and nothing else', function (): void {
    $themes = app(ListInstalledThemesAction::class)->execute();

    // Il modulo Cms e' condiviso tra progetti con temi diversi: niente nome di tema scritto qui, si guarda il disco.
    expect($themes)->not->toBeEmpty()
        ->and($themes)->not->toHaveKey('public');

    foreach ($themes as $key => $name) {
        expect($name)->toBe($key)
            ->and(base_path("Themes/{$name}/resources/views"))->toBeDirectory();
    }
});
