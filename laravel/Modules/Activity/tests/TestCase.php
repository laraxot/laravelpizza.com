<?php

declare(strict_types=1);

namespace Modules\Activity\Tests;

use Filament\Notifications\Notification;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\ServiceProvider;
use Mockery\CompositeExpectation;
use Mockery\Expectation;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Models\Activity;
use Modules\Activity\Providers\ActivityServiceProvider;
use Modules\Activity\Providers\EventServiceProvider;
use Modules\User\Contracts\UserContract;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Activity module.
 *
 * Uses shared fixcity_data.sqlite (no RefreshDatabase / migrate:fresh).
 * prepareSharedFixcitySqliteForTesting() runs before transactions begin.
 *
 * @property ListLogActivities|null $page
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    public ?ListLogActivities $page = null;

    /**
     * Shared test data for Activity entity.
     *
     * @var array<string, mixed>
     */
    public array $activityData = [];

    /**
     * Shared test data for stored event entity.
     *
     * @var array<string, mixed>
     */
    public array $storedEventData = [];

    /**
     * Shared test data for snapshot entity.
     *
     * @var array<string, mixed>
     */
    public array $snapshotData = [];

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'activity', 'user'];

    protected function setUp(): void
    {
        $this->prepareSharedSqliteForTesting();

        parent::setUp();

        config(['auth.providers.users.model' => User::class]);
    }

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            ActivityServiceProvider::class,
            EventServiceProvider::class,
        ];
    }

    /**
     * Mockery 1.6 returns a CompositeExpectation from shouldReceive()/allows(), which forwards
     * once()/with()/andReturn() via __call and so is opaque to PHPStan. The composite holds no
     * public accessor, so its single Expectation is read once here to keep chained calls typed.
     *
     * Sta qui e non in tests/Helpers.php: Pest carica `Pest.php`/`Helpers.php` solo dal
     * `--test-directory` della run (laravel/tests), quindi in una run scoped sul modulo le
     * funzioni globali dichiarate li' non esistono. Stessa scelta di Modules\Pdnd\Tests\TestCase.
     */
    public static function mockeryExpect(object $expectation): Expectation
    {
        if ($expectation instanceof CompositeExpectation) {
            $expectations = (fn (): array => $this->_expectations)->call($expectation);
            assert(count($expectations) === 1, 'mockeryExpect() supports a single expected method');
            $expectation = reset($expectations);
        }

        assert($expectation instanceof Expectation);

        return $expectation;
    }

    /**
     * Crea un utente di test via factory.
     *
     * Sta qui e non in tests/Helpers.php per lo stesso motivo di mockeryExpect():
     * Pest carica `Pest.php`/`Helpers.php` solo dal `--test-directory` della run,
     * quindi in una run scoped sul modulo le funzioni globali dichiarate li' non
     * esistono. Specchio di `activityCreateUser()` in tests/Helpers.php.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function activityCreateUser(array $attributes = []): User
    {
        $user = UserFactory::new()->createOne($attributes);
        assert($user instanceof UserContract);

        return $user;
    }

    /**
     * Crea un'attivita' di test via factory.
     *
     * Specchio di `activityCreateActivity()` in tests/Helpers.php.
     *
     * @param  array<string, mixed>  $attributes
     */
    public static function activityCreateActivity(array $attributes = []): Activity
    {
        $activity = ActivityFactory::new()->createOne($attributes);
        assert($activity instanceof Activity);

        return $activity;
    }

    public function requirePage(): ListLogActivities
    {
        if ($this->page === null) {
            $this->fail('ListLogActivities page is not initialized.');
        }

        return $this->page;
    }

    /**
     * Builds a fresh ListLogActivities page instance exposing the
     * restore-notification helpers for coverage tests.
     *
     * Static so it can be called directly from within Pest test closures
     * (including nested describe()/test() closures) without relying on
     * $this, which PHPStan/Larastan cannot type-infer in that context.
     */
    public static function makeListLogActivitiesPage(): ListLogActivities
    {
        return new class extends ListLogActivities
        {
            public static function getResource(): string
            {
                return ActivityResource::class;
            }

            public function exposeRestoreSuccess(): Notification
            {
                return $this->sendRestoreSuccessNotification();
            }

            public function exposeRestoreFailure(?string $message = null): Notification
            {
                return $this->sendRestoreFailureNotification($message);
            }
        };
    }
}
