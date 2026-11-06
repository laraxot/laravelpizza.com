<?php

declare(strict_types=1);

use Laravel\Passport\Passport;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\User\Datas\UserConfigData;
use Modules\User\Filament\Pages\SettingPage;
use Modules\User\Providers\PassportServiceProvider;
use Modules\User\Tests\Support\FakeTenantUserConfig;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-user-db');

/**
 * @return list<string>
 */
function userConfigPropertyNames(): array
{
    return array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(UserConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );
}

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('user')
        ->and(SettingPage::getConfigDataClass())->toBe(UserConfigData::class);
});

test('config data reads the tenant file named after the module', function (): void {
    expect(UserConfigData::tenantConfigName())->toBe('user');
});

test('defaults equal what the readers did before the settings existed', function (): void {
    FakeTenantUserConfig::bind([]);

    $data = UserConfigData::make();

    expect($data->create_personal_team)->toBeFalse()
        ->and($data->passport_enable_password_grant)->toBeTrue();
});

test('a tenant array overrides the defaults', function (): void {
    FakeTenantUserConfig::bind([
        'create_personal_team' => true,
        'passport_enable_password_grant' => false,
    ]);

    $data = UserConfigData::make();

    expect($data->create_personal_team)->toBeTrue()
        ->and($data->passport_enable_password_grant)->toBeFalse();
});

test('a missing tenant file gives the defaults', function (): void {
    if (is_file(app(GetTenantFilePathAction::class)->execute('user.php'))) {
        Assert::markTestSkipped('Il tenant corrente ha un file user.php: i default non sono osservabili.');
    }

    expect(UserConfigData::make()->toArray())->toBe(UserConfigData::from([])->toArray())
        ->and(UserConfigData::make()->passport_enable_password_grant)->toBeTrue();
});

test('the passport password grant follows the saved tenant setting', function (): void {
    $grantEnabled = static fn (): bool => Passport::$passwordGrantEnabled;
    $previous = $grantEnabled();
    $configure = new ReflectionMethod(PassportServiceProvider::class, 'configurePasswordGrant');
    $provider = new PassportServiceProvider(app());

    try {
        Passport::$passwordGrantEnabled = false;
        FakeTenantUserConfig::bind(['passport_enable_password_grant' => false]);
        $configure->invoke($provider);
        expect($grantEnabled())->toBeFalse();

        FakeTenantUserConfig::bind([]);
        $configure->invoke($provider);
        expect($grantEnabled())->toBeTrue();
    } finally {
        Passport::$passwordGrantEnabled = $previous;
    }
});

test('the passport provider boots when the tenant has no user file', function (): void {
    FakeTenantUserConfig::bind([]);
    $grantEnabled = static fn (): bool => Passport::$passwordGrantEnabled;
    $previous = $grantEnabled();

    try {
        (new PassportServiceProvider(app()))->boot();
        expect($grantEnabled())->toBeTrue();
    } finally {
        Passport::$passwordGrantEnabled = $previous;
    }
});

test('setting page form keys equal the public properties of the data', function (): void {
    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))->invoke(new SettingPage);
    $keys = array_keys(is_array($schema) ? $schema : []);
    $properties = userConfigPropertyNames();
    sort($keys);
    sort($properties);

    expect($keys)->not->toBe([])
        ->and($keys)->toBe($properties);
});

test('the data holds no passport structures, secrets or invented fields', function (): void {
    foreach (userConfigPropertyNames() as $name) {
        expect($name)->not->toContain('token')
            ->and($name)->not->toContain('scope')
            ->and($name)->not->toContain('model')
            ->and($name)->not->toContain('secret')
            ->and($name)->not->toBeIn(['enabled', 'registration_enabled', 'email_verification_required']);
    }
});

test('every setting field has a label in it and en', function (): void {
    foreach (['it', 'en'] as $locale) {
        $lang = require dirname(__DIR__, 3).'/lang/'.$locale.'/setting.php';

        foreach (userConfigPropertyNames() as $property) {
            expect(data_get($lang, 'fields.'.$property.'.label', ''))->not->toBe('');
        }
    }
});
