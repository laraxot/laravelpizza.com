<?php

declare(strict_types=1);

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse;
use Modules\Gdpr\Database\Factories\ConsentFactory;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Tests\TestCase;
use Pest\Support\HigherOrderTapProxy;
use PHPUnit\Framework\Assert;

/**
 * Helper Pest/PHPStan — modulo Gdpr.
 *
 * @see Modules/Media/tests/Feature/MediaBusinessLogicTest.php (assertMediaTableHas)
 */
function gdprTest(): TestCase
{
    // @phpstan-ignore-next-line Pest's test() returns mixed in static analysis
    $test = test();
    // @phpstan-ignore-next-line HigherOrderTapProxy is a Pest internal class
    if ($test instanceof HigherOrderTapProxy) {
        $test = $test->target;
    }

    Assert::assertInstanceOf(TestCase::class, $test);

    return $test;
}

/**
 * @param array<string, string> $headers
 *
 * @return TestResponse<Response>
 */
function gdprGet(string $uri, array $headers = []): TestResponse
{
    return gdprTest()->get($uri, $headers);
}

/**
 * @param array<string, mixed>  $data
 * @param array<string, string> $headers
 *
 * @return TestResponse<Response>
 */
function gdprPost(string $uri, array $data = [], array $headers = []): TestResponse
{
    return gdprTest()->post($uri, $data, $headers);
}

function gdprActingAs(Authenticatable $user, ?string $driver = null): TestCase
{
    return gdprTest()->actingAs($user, $driver);
}

/**
 * @param array<string, mixed> $parameters
 */
function gdprArtisan(string $command, array $parameters = []): int
{
    return (int) Artisan::call($command, $parameters);
}

function gdprSkipTest(string $message = ''): void
{
    gdprTest()->markTestSkipped($message);
}

/**
 * @param array<string, mixed> $where
 */
function assertGdprTableHas(string $table, array $where, ?string $connection = 'gdpr'): void
{
    $query = DB::connection($connection)->table($table);

    foreach ($where as $column => $value) {
        $query->where((string) $column, $value);
    }

    Assert::assertTrue($query->exists());
}

/**
 * @param array<string, mixed> $where
 */
function assertGdprTableMissing(string $table, array $where, ?string $connection = 'gdpr'): void
{
    $query = DB::connection($connection)->table($table);

    foreach ($where as $column => $value) {
        $query->where((string) $column, $value);
    }

    Assert::assertFalse($query->exists());
}

/**
 * @param array<string, mixed> $attributes
 */
function createGdprConsent(array $attributes = []): Consent
{
    return ConsentFactory::new()->createOne($attributes);
}

function gdprAssertDatabaseAvailable(): void
{
    try {
        DB::connection()->getPdo();
    } catch (Exception $e) {
        gdprSkipTest('Database not available: '.$e->getMessage());
    }
}

/**
 * @param class-string<Throwable> $exceptionClass
 */
function gdprAssertThrows(string $exceptionClass, callable $callback): void
{
    try {
        $callback();
        Assert::fail('Expected '.$exceptionClass);
    } catch (Throwable $e) {
        Assert::assertInstanceOf($exceptionClass, $e);
    }
}

/**
 * @param class-string<Throwable> $exceptionClass
 */
function gdprAssertDoesNotThrow(string $exceptionClass, callable $callback): void
{
    try {
        $callback();
    } catch (Throwable $e) {
        if ($e instanceof $exceptionClass) {
            Assert::fail('Unexpected '.$exceptionClass.': '.$e->getMessage());
        }

        throw $e;
    }
}

/**
 * @param list<string>  $fields
 * @param array<string> $fillable
 */
function assertFillableContains(array $fields, array $fillable): void
{
    foreach ($fields as $field) {
        Assert::assertContains($field, $fillable, "Fillable should contain {$field}");
    }
}
