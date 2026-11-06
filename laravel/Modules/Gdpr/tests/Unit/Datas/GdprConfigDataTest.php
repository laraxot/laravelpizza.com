<?php

declare(strict_types=1);

use Modules\Gdpr\Actions\Cookie\GetCookieInventoryAction;
use Modules\Gdpr\Datas\GdprConfigData;
use Modules\Gdpr\Filament\Pages\SettingPage;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Webmozart\Assert\Assert;

/**
 * Fa leggere a `GdprConfigData::make()` un file tenant finto, senza scrivere in `config/{tenant}`.
 *
 * @param  array<string, mixed>  $config  contenuto di `config/{tenant}/gdpr.php`
 */
function gdprFakeTenantConfig(array $config): void
{
    app()->instance(GetTenantConfigArrayAction::class, new class($config) extends GetTenantConfigArrayAction
    {
        /**
         * @param  array<string, mixed>  $config
         */
        public function __construct(private readonly array $config) {}

        /**
         * @return array<string, mixed>
         */
        public function execute(string $name): array
        {
            return $name === 'gdpr' ? $this->config : [];
        }
    });
}

test('without a saved value the cookie settings keep the values the code used before', function (): void {
    $data = GdprConfigData::from([]);

    expect($data->consent_lifetime)->toBe(180)
        ->and($data->policy_path)->toBe('/cookie-policy');
});

test('values from the tenant file override the defaults', function (): void {
    gdprFakeTenantConfig(['consent_lifetime' => 365, 'policy_path' => '/privacy/cookie']);

    $data = GdprConfigData::make();

    expect($data->consent_lifetime)->toBe(365)
        ->and($data->policy_path)->toBe('/privacy/cookie');
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(GdprConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});

test('the cookie inventory states the consent duration saved in the tenant file', function (): void {
    gdprFakeTenantConfig(['consent_lifetime' => 365]);
    $consentName = config('cookie-consent.cookie_key', '__cookie_consent');
    Assert::string($consentName);

    $inventory = app(GetCookieInventoryAction::class)->execute();
    $consent = collect($inventory->cookies)->first(static fn ($cookie): bool => $cookie->name === $consentName);

    Assert::notNull($consent);

    expect($consent->duration)->toContain('365');
});
