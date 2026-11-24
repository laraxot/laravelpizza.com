<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\ExpectationInterface;
use Mockery\MockInterface;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;
use PHPUnit\Framework\Assert;
use Throwable;

use function Safe\json_decode;
use function Safe\putenv;

/**
 * Base test case for Tenant module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    /**
     * Tenant corrente impostato dal test.
     */
    public Tenant $tenant;

    /**
     * Secondo tenant usato dai test di isolamento.
     */
    public Tenant $secondTenant;

    /**
     * Istanza Sushi condivisa dai test del trait.
     */
    public ?TestSushiModel $sushiModel = null;

    /**
     * Modello Sushi istanziato nel beforeEach del file di test.
     */
    public TestSushiModel $model;

    /**
     * Istanza anonima di BaseModel usata dai test unitari dei modelli base.
     */
    public BaseModel $baseModel;

    /**
     * Directory di test per i file JSON Sushi.
     */
    public string $testDirectory = '';

    /**
     * Percorso del file JSON di test.
     */
    public string $testJsonPath = '';

    /**
     * Factory closure che produce il dataset Sushi di default.
     *
     * @var Closure(): array<int|string, array<string, mixed>>
     */
    public Closure $createTestData;

    /**
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
            UserServiceProvider::class,
            TenantServiceProvider::class,
        ];
    }

    /**
     * Verifica se la connessione DB `tenant` e' raggiungibile.
     */
    public function tenantDbUnavailable(): bool
    {
        try {
            DB::connection('tenant')->select('select 1');

            return false;
        } catch (Throwable) {
            return true;
        }
    }

    /**
     * Salta il test corrente con una motivazione.
     */
    public function skipCurrentTest(string $reason): void
    {
        $this->markTestSkipped($reason);
    }

    /**
     * Alias di markTestSkipped usato dai test del modulo.
     */
    public function skipTest(string $reason): void
    {
        $this->markTestSkipped($reason);
    }

    /**
     * Imposta il tenant corrente per il test.
     */
    public function setCurrentTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;

        if ($this->app->bound('tenant')) {
            $context = $this->app->make('tenant');
            if ($context instanceof TenantContextSetter) {
                $context->setCurrent($tenant);
            }
        }
    }

    /**
     * Restituisce il tenant corrente impostato dal test.
     */
    public function tenantModel(): Tenant
    {
        return $this->tenant;
    }

    /**
     * Restituisce il secondo tenant impostato dal test.
     */
    public function secondTenantModel(): Tenant
    {
        return $this->secondTenant;
    }

    /**
     * Restituisce il modello Sushi di test, creandolo se necessario.
     */
    public function sushiModel(): TestSushiModel
    {
        return $this->sushiModel ?? new TestSushiModel;
    }

    /**
     * Percorso del file JSON di test corrente.
     */
    public function sushiJsonPath(): string
    {
        return $this->testJsonPath;
    }

    /**
     * Dataset Sushi di default prodotto dalla closure di test.
     *
     * @return array<int|string, array<string, mixed>>
     */
    public function sushiTestData(): array
    {
        /** @var array<int|string, array<string, mixed>> $data */
        $data = ($this->createTestData)();

        return $data;
    }

    /**
     * Trova una riga per il campo `id`.
     *
     * @param  array<array-key, mixed>  $rows
     * @return array<string, mixed>
     */
    public function sushiRowById(array $rows, int $id): array
    {
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $rowId = $row['id'] ?? null;
            if (is_numeric($rowId) && (int) $rowId === $id) {
                /** @var array<string, mixed> $typedRow */
                $typedRow = $row;

                return $typedRow;
            }
        }

        throw new \RuntimeException("Sushi row with id {$id} not found.");
    }

    /**
     * Estrae il record alla chiave data (i lookup numerici sono normalizzati da PHP).
     *
     * @param  array<array-key, mixed>  $data
     * @return array<string, mixed>
     */
    public function jsonRecordAt(array $data, int|string $key): array
    {
        $record = $data[$key] ?? null;
        Assert::assertIsArray($record);

        /** @var array<string, mixed> $typedRecord */
        $typedRecord = $record;

        return $typedRecord;
    }

    /**
     * Legge un file JSON e lo restituisce come array.
     *
     * @return array<array-key, mixed>
     */
    public function readJsonFileAsArray(string $path): array
    {
        return $this->decodeJsonString(File::get($path));
    }

    /**
     * Decodifica una stringa JSON in array.
     *
     * @return array<array-key, mixed>
     */
    public function decodeJsonString(string $json): array
    {
        $decoded = json_decode($json, true);
        Assert::assertIsArray($decoded);

        return $decoded;
    }

    /**
     * Legge un file JSON tenant e lo restituisce come array.
     *
     * @return array<array-key, mixed>
     */
    public function decodeTenantJsonFile(string $path): array
    {
        return $this->decodeJsonString(File::get($path));
    }

    /**
     * Imposta `$_SERVER['SERVER_NAME']` per simulare il dominio tenant.
     */
    public function setServerNameForTenantTest(?string $serverName): void
    {
        if ($serverName === null) {
            unset($_SERVER['SERVER_NAME']);
            putenv('SERVER_NAME');

            return;
        }

        $_SERVER['SERVER_NAME'] = $serverName;
        putenv('SERVER_NAME='.$serverName);
    }

    /**
     * Esegue un comando Artisan e ne restituisce il codice di uscita.
     */
    public function runArtisanCommand(string $command): int
    {
        return Artisan::call($command);
    }

    /**
     * Mocka un servizio/action nel container e applica la configurazione Mockery.
     *
     * @param  class-string  $class
     * @param  Closure(MockInterface): void  $configure
     */
    public function mockAppService(string $class, Closure $configure): MockInterface
    {
        $mock = Mockery::mock($class);
        $configure($mock);
        $this->app->instance($class, $mock);

        return $mock;
    }

    /**
     * Alias di {@see mockAppService()} usato dai test del modulo.
     *
     * @param  class-string  $class
     * @param  Closure(MockInterface): void  $configure
     */
    public function mockService(string $class, Closure $configure): MockInterface
    {
        return $this->mockAppService($class, $configure);
    }

    /**
     * Crea un'istanza di Tenant tramite factory.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function createTenant(array $attributes = []): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = Tenant::factory()->create($attributes);
        Assert::assertInstanceOf(Tenant::class, $tenant);

        return $tenant;
    }

    /**
     * Registra un'aspettativa Mockery su un mock esistente.
     *
     * Statico: usabile anche dentro closure `static function` dei mock.
     */
    public static function expectMockery(MockInterface $mock, string $method): ExpectationInterface
    {
        // Mockery 1.6 restituisce una CompositeExpectation anche per un solo metodo: si accetta il contratto comune.
        $expectation = $mock->shouldReceive($method);
        Assert::assertInstanceOf(ExpectationInterface::class, $expectation);

        return $expectation;
    }
}
