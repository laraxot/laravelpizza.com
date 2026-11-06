<?php

declare(strict_types=1);

use Filament\Forms\Components\FileUpload;
use Modules\Media\Actions\GetAttachmentsSchemaAction;
use Modules\Media\Datas\MediaConfigData;
use Modules\Media\Filament\Pages\SettingPage;
use Modules\Media\Tests\TestCase;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Webmozart\Assert\Assert;

uses(TestCase::class);

/**
 * Fa leggere a `MediaConfigData::make()` un file tenant finto, senza scrivere in `config/{tenant}`.
 *
 * @param  array<string, mixed>  $config  contenuto di `config/{tenant}/media.php`
 */
function mediaFakeTenantConfig(array $config): void
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
            return $name === 'media' ? $this->config : [];
        }
    });
}

function mediaFirstUploadField(): FileUpload
{
    $fields = app(GetAttachmentsSchemaAction::class)->execute(['document']);

    return $fields[0];
}

test('without a saved value the attachment limits keep the values the code used before', function (): void {
    $data = MediaConfigData::from([]);

    expect($data->attachment_max_size_kb)->toBe(10240)
        ->and($data->attachment_mime_types)->toBe([
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
});

test('values from the tenant file override the defaults', function (): void {
    mediaFakeTenantConfig([
        'attachment_max_size_kb' => 2048,
        'attachment_mime_types' => ['image/png'],
    ]);

    $data = MediaConfigData::make();

    expect($data->attachment_max_size_kb)->toBe(2048)
        ->and($data->attachment_mime_types)->toBe(['image/png']);
});

test('the setting page exposes exactly the properties of the config data', function (): void {
    $properties = array_values(array_diff(
        array_map(
            static fn (ReflectionProperty $property): string => $property->getName(),
            (new ReflectionClass(MediaConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
        ),
        ['name'],
    ));

    $schema = (new ReflectionMethod(SettingPage::class, 'getFormSchema'))
        ->invoke(app(SettingPage::class));
    Assert::isArray($schema);

    expect(array_keys($schema))->toEqualCanonicalizing($properties);
});

test('the attachment upload field keeps 10 MB and pdf doc docx when nothing is saved', function (): void {
    mediaFakeTenantConfig([]);

    $upload = mediaFirstUploadField();

    expect($upload->getMaxSize())->toBe(10240)
        ->and($upload->getAcceptedFileTypes())->toBe(MediaConfigData::from([])->attachment_mime_types);
});

test('the attachment upload field uses the size and types saved in the tenant file', function (): void {
    mediaFakeTenantConfig([
        'attachment_max_size_kb' => 512,
        'attachment_mime_types' => ['image/jpeg', 'image/png'],
    ]);

    $upload = mediaFirstUploadField();

    expect($upload->getMaxSize())->toBe(512)
        ->and($upload->getAcceptedFileTypes())->toBe(['image/jpeg', 'image/png']);
});
