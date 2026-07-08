<?php

declare(strict_types=1);

namespace Modules\AI\Tests;

use Illuminate\Foundation\Application;
use Modules\AI\Providers\AIServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for AI module.
 *
 * Unit tests here do not require database migrations.
 * Vietato RefreshDatabase / DatabaseMigrations (dati sacri).
 */
abstract class TestCase extends XotBaseTestCase
{
    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            AIServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.openai.api_key' => 'test-openai-key',
            'services.openai.model' => 'gpt-3.5-turbo-instruct',
            'ai.model' => 'gpt-3.5-turbo-instruct',
            'ai.temperature' => 0.7,
            'ai.max_tokens' => 1500,
        ]);
    }
}
