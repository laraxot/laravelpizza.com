<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Modules\Gdpr\Providers\GdprServiceProvider;
use Modules\User\Models\User;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

/**
 * Base test case for Gdpr module.
 *
 * Uses the shared sqlite file of XotBaseTestCase::sharedSqlitePath() (no RefreshDatabase / migrate:fresh).
 * prepareSharedSqliteForTesting() runs before transactions begin.
 *
 * `$currentTest` espone il test in esecuzione alle funzioni helper di `tests/PestHelpers.php`
 * (`gdprGet()`, `gdprPost()`, ...), che vivono fuori dalla closure Pest e quindi senza `$this`.
 * Sostituisce `test()` di Pest, che restituisce la classe `@internal` `HigherOrderTapProxy`.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    public static ?self $currentTest = null;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite'];

    protected function setUp(): void
    {
        $this->prepareSharedSqliteForTesting();

        parent::setUp();

        self::$currentTest = $this;

        config(['auth.providers.users.model' => User::class]);
    }

    protected function tearDown(): void
    {
        self::$currentTest = null;

        parent::tearDown();
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            GdprServiceProvider::class,
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseMissingRow(string $table, array $data, ?string $connection = null): void
    {
        $query = DB::connection($connection)->table($table);

        foreach ($data as $column => $value) {
            $query->where((string) $column, $value);
        }

        Assert::assertFalse($query->exists());
    }

    /**
     * @param  class-string<\Throwable>  $exceptionClass
     */
    public function expectApplicationException(string $exceptionClass, ?string $message = null): void
    {
        $this->expectException($exceptionClass);
        if ($message !== null) {
            $this->expectThrowableMessage($message);
        }
    }

    protected static function uniqueTreatmentName(string $prefix = 'treatment'): string
    {
        return $prefix.'-'.uniqid('', true);
    }
}
