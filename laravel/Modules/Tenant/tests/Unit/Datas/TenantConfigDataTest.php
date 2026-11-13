<?php

declare(strict_types=1);

use Filament\Forms\Components\TextInput;
use Filament\Panel;
use Illuminate\Support\Facades\Validator;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Datas\TenantConfigData;
use Modules\Tenant\Filament\Pages\SettingPage;
use Modules\Xot\Actions\Panel\ApplyMetatagToPanelAction;
use Modules\Xot\Datas\MetatagData;
use Webmozart\Assert\Assert;

use function Safe\preg_match;

uses()->group('no-tenant-db');

/**
 * Fa leggere un file `metatag` finto a chi usa GetTenantConfigArrayAction (MetatagData e SettingPage), senza scrivere in `config/{tenant}`.
 *
 * @param  array<string, mixed>  $config  contenuto di `config/{tenant}/metatag.php`
 */
function tenantFakeMetatagConfig(array $config): void
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
            return $name === 'metatag' ? $this->config : [];
        }
    });
}

/** MetatagData tiene l'istanza in una proprieta' statica privata: senza azzerarla un test vedrebbe il file del precedente. */
function tenantForgetMetatagInstance(): void
{
    (new ReflectionProperty(MetatagData::class, 'instance'))->setValue(null, null);
}

beforeEach(function (): void {
    tenantForgetMetatagInstance();
});

afterEach(function (): void {
    tenantForgetMetatagInstance();
});

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('metatag')
        ->and(SettingPage::getConfigDataClass())->toBe(TenantConfigData::class);
});

test('config data reads the metatag file, the one MetatagData reads', function (): void {
    expect(TenantConfigData::tenantConfigName())->toBe('metatag');
});

test('the defaults are the ones MetatagData uses when the file says nothing', function (): void {
    $data = TenantConfigData::from([]);
    $reader = MetatagData::from([]);

    expect($data->title)->toBe($reader->title)
        ->and($data->logo_height)->toBe($reader->logo_height);
});

test('values from the metatag file override the defaults', function (): void {
    tenantFakeMetatagConfig([
        'title' => 'Acme',
        'logo_height' => '3rem',
    ]);

    $data = TenantConfigData::make();

    expect($data->title)->toBe('Acme')
        ->and($data->logo_height)->toBe('3rem');
});

test('the saved title and logo height reach the readers: brand name and panel', function (): void {
    tenantFakeMetatagConfig([
        'title' => 'Acme',
        'logo_height' => '3rem',
    ]);

    $meta = MetatagData::make();
    $panel = Panel::make()->id('probe')->path('probe');
    app(ApplyMetatagToPanelAction::class)->execute($panel);

    expect($meta->getBrandName())->toBe('Acme')
        ->and($meta->getBrandLogoHeight())->toBe('3rem')
        ->and($panel->getBrandName())->toBe('Acme')
        ->and($panel->getBrandLogoHeight())->toBe('3rem');
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(TenantConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});

test('no setting can switch tenant resolution or domain routing off', function (): void {
    $properties = array_map(
        static fn (ReflectionProperty $property): string => $property->getName(),
        (new ReflectionClass(TenantConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
    );

    expect($properties)->not->toContain('enabled')
        ->and($properties)->not->toContain('domain_routing')
        ->and($properties)->not->toContain('default_locale');
});

test('the logo height accepts a short css length and nothing else', function (string $value, bool $valid): void {
    expect(preg_match(SettingPage::LOGO_HEIGHT_PATTERN, $value) === 1)->toBe($valid);
})->with([
    'em' => ['2em', true],
    'px' => ['32px', true],
    'decimal rem' => ['1.5rem', true],
    'no unit' => ['2', false],
    'calc' => ['calc(1px + 2px)', false],
    'style injection' => ['2em;color:red', false],
    'markup' => ['<b>2em</b>', false],
    'huge' => ['99999em', false],
    'trailing newline' => ["2em\n", false],
]);

test('the logo height field enforces that pattern when the form is validated', function (): void {
    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);
    $field = $schema['logo_height'];
    Assert::isInstanceOf($field, TextInput::class);

    $rules = $field->getValidationRules();

    expect(Validator::make(['logo_height' => '2em'], ['logo_height' => $rules])->passes())->toBeTrue()
        ->and(Validator::make(['logo_height' => '2em;color:red'], ['logo_height' => $rules])->passes())->toBeFalse()
        ->and(Validator::make(['logo_height' => ''], ['logo_height' => $rules])->passes())->toBeFalse();
});

test('every field of the page has a label in italian and english', function (string $locale): void {
    $lang = require dirname(__DIR__, 3).'/lang/'.$locale.'/setting.php';
    Assert::isArray($lang);
    $fields = $lang['fields'];
    Assert::isArray($fields);

    foreach (['title', 'logo_height'] as $field) {
        expect($fields)->toHaveKey($field);
        $entry = $fields[$field];
        Assert::isArray($entry);
        expect($entry['label'])->toBeString()->not->toBeEmpty();
    }
})->with(['it', 'en']);
