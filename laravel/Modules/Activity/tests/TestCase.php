<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;
use Spatie\EventSourcing\StoredEvents\EventSubscriber;
use Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository;

/**
 * Base test case for Activity module.
 *
 * Uses MySQL from .env.testing.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected static bool $migrated = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(EventSubscriber::class, function (): EventSubscriber {
            return new EventSubscriber(EloquentStoredEventRepository::class);
        });

        if (! self::$migrated) {
            $this->artisan('migrate:fresh', [
                '--force' => true,
            ]);

            $this->artisan('module:migrate', [
                '--force' => true,
            ]);

            self::$migrated = true;
        }
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActivityServiceProvider::class,
            UserServiceProvider::class,
            XotServiceProvider::class,
        ];
    }
}
