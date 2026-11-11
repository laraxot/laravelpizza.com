<?php

declare(strict_types=1);

namespace Modules\Media\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Schema;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\Media\Providers\MediaServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBasePest;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;
use Spatie\QueueableAction\QueueableAction;

/**
 * Base test case for Media module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    public static function mockExpectation(MockInterface $mock, string $method): Expectation
    {
        return self::singleExpectation($mock, $method);
    }

    /**
     * @param  array<string, mixed>  $where
     */
    public function assertMediaTableHas(string $table, array $where, string $connection = 'media'): void
    {
        $this->assertDatabaseHas($table, $where, $connection);
    }

    /**
     * Controparte di {@see self::assertMediaTableHas()}: la riga non deve esistere.
     *
     * @param  array<string, mixed>  $where
     */
    public function assertMediaTableMissing(string $table, array $where, string $connection = 'media'): void
    {
        $this->assertDatabaseMissing($table, $where, $connection);
    }

    /**
     * Colonne della tabella `media`, filtrate e riindicizzate per l'inferenza PHPStan.
     *
     * @return array<int, string>
     */
    public static function mediaTableColumns(): array
    {
        $columns = Schema::getColumnListing('media');

        return array_values(array_filter(
            $columns,
            static fn (mixed $column): bool => is_string($column) && $column !== '', // mixed: getColumnListing() non dichiara value type
        ));
    }

    /**
     * Aggiunge `$column` al payload solo se la tabella `media` ha davvero quella colonna:
     * lo schema varia fra installazioni e un insert cieco fallirebbe.
     *
     * @param  array<string, mixed>  $payload
     * @param  array<int, string>  $columns
     * @param  mixed  $value  Valore di colonna eterogeneo (string, int, Carbon, null)
     * @return array<string, mixed>
     */
    public static function mediaPayloadSet(array $payload, array $columns, string $column, mixed $value): array
    {
        if (in_array($column, $columns, true)) {
            $payload[$column] = $value;
        }

        return $payload;
    }

    /**
     * @param  class-string  $class
     */
    public static function assertMediaUsesQueueableAction(string $class): void
    {
        XotBasePest::assertListContains(
            QueueableAction::class,
            (new ReflectionClass($class))->getTraitNames(),
        );
    }

    /**
     * @param  class-string  $class
     */
    public static function assertMediaDeclaresStrictTypes(string $class): void
    {
        Assert::assertStringContainsString(
            'declare(strict_types=1);',
            XotBasePest::reflectionSource($class),
        );
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $class
     * @return T&MockObject
     */
    public function makeTestMock(string $class): object
    {
        return $this->createMock($class);
    }

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            MediaServiceProvider::class,
        ];
    }
}
