<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Datas;

use Modules\AI\Datas\AIConfigData;
use Modules\AI\Filament\Pages\SettingPage;
use Modules\AI\Tests\Support\FakeTenantAiConfig;
use Modules\AI\Tests\TestCase;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

uses(TestCase::class);

describe('AIConfigData defaults', function (): void {
    test('_defaults_equal_the_values_the_readers_used_before_the_setting_existed', function (): void {
        FakeTenantAiConfig::bind([]);

        $data = AIConfigData::make();

        Assert::assertSame('gpt-3.5-turbo-instruct', $data->model);
        Assert::assertSame('gpt-4o-mini', $data->chat_model);
        Assert::assertSame(0.7, $data->temperature);
        Assert::assertSame(0.6, $data->chat_temperature);
        Assert::assertSame(1500, $data->max_tokens);
        Assert::assertSame(30, $data->timeout);
        Assert::assertSame(3, $data->retry_attempts);
        Assert::assertSame('https://api.openai.com/v1', $data->openai_base_url);
    });

    test('_a_tenant_array_overrides_the_defaults', function (): void {
        FakeTenantAiConfig::bind([
            'model' => 'gpt-4o-instruct',
            'chat_model' => 'gpt-4o',
            'temperature' => 0.2,
            'chat_temperature' => 0.9,
            'max_tokens' => 800,
            'timeout' => 90,
            'retry_attempts' => 5,
            'openai_base_url' => 'https://llm.example.test/v1',
        ]);

        $data = AIConfigData::make();

        Assert::assertSame('gpt-4o-instruct', $data->model);
        Assert::assertSame('gpt-4o', $data->chat_model);
        Assert::assertSame(0.2, $data->temperature);
        Assert::assertSame(0.9, $data->chat_temperature);
        Assert::assertSame(800, $data->max_tokens);
        Assert::assertSame(90, $data->timeout);
        Assert::assertSame(5, $data->retry_attempts);
        Assert::assertSame('https://llm.example.test/v1', $data->openai_base_url);
    });

    test('_a_partial_tenant_array_keeps_the_other_defaults', function (): void {
        FakeTenantAiConfig::bind(['timeout' => 45]);

        $data = AIConfigData::make();

        Assert::assertSame(45, $data->timeout);
        Assert::assertSame(3, $data->retry_attempts);
        Assert::assertSame('gpt-3.5-turbo-instruct', $data->model);
    });

    test('_a_form_state_with_numeric_strings_is_normalized_to_the_property_types', function (): void {
        $data = AIConfigData::from([
            'temperature' => '0.4',
            'max_tokens' => '900',
            'timeout' => '60',
            'retry_attempts' => '2',
        ]);

        Assert::assertSame(0.4, $data->temperature);
        Assert::assertSame(900, $data->max_tokens);
        Assert::assertSame(60, $data->timeout);
        Assert::assertSame(2, $data->retry_attempts);
    });

    test('_a_missing_tenant_file_gives_the_defaults', function (): void {
        $path = app(GetTenantFilePathAction::class)->execute('ai.php');
        if (is_file($path)) {
            Assert::markTestSkipped('Il tenant corrente ha un file ai.php: i default non sono osservabili.');
        }

        $data = AIConfigData::make();

        Assert::assertSame(AIConfigData::from([])->toArray(), $data->toArray());
        Assert::assertSame(30, $data->timeout);
    });

    test('_the_secret_api_key_is_never_a_property', function (): void {
        $names = array_map(
            static fn (ReflectionProperty $property): string => $property->getName(),
            (new ReflectionClass(AIConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
        );

        foreach ($names as $name) {
            Assert::assertStringNotContainsString('api_key', $name);
        }
    });
});

describe('AI SettingPage', function (): void {
    test('_form_schema_keys_equal_the_public_properties_of_the_data', function (): void {
        $method = new ReflectionMethod(SettingPage::class, 'getFormSchema');
        $schema = $method->invoke(new SettingPage);
        Assert::assertIsArray($schema);

        $properties = array_map(
            static fn (ReflectionProperty $property): string => $property->getName(),
            (new ReflectionClass(AIConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
        );

        $keys = array_keys($schema);
        sort($keys);
        sort($properties);

        Assert::assertNotSame([], $keys);
        Assert::assertSame($properties, $keys);
    });

    test('_every_field_has_a_label_in_it_and_en', function (): void {
        $properties = array_map(
            static fn (ReflectionProperty $property): string => $property->getName(),
            (new ReflectionClass(AIConfigData::class))->getProperties(ReflectionProperty::IS_PUBLIC),
        );

        foreach (['it', 'en'] as $locale) {
            $lang = require dirname(__DIR__, 3).'/lang/'.$locale.'/setting.php';
            Assert::assertIsArray($lang);
            Assert::assertIsArray($lang['fields']);

            foreach ($properties as $property) {
                Assert::assertIsArray($lang['fields'][$property] ?? null, $locale.': manca fields.'.$property);
                Assert::assertNotSame('', $lang['fields'][$property]['label'] ?? '', $locale.': label vuota per '.$property);
            }
        }
    });
});
