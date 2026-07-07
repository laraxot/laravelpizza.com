<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Tenant\Services\TenantService;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

/**
 * @property TestSushiModel|null $model
 * @property BaseModel|null $baseModel
 * @property string $testJsonPath
 * @property string $testDirectory
 * @property Closure(): array<array-key, array<string, mixed>>|null $createTestData
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var TestSushiModel */
    public mixed $model;

    /** @var BaseModel|null */
    public mixed $baseModel = null;

    public ?Tenant $tenant = null;

    public ?Tenant $secondTenant = null;

    public string $testJsonPath = '';

    public string $testDirectory = '';

    /** @var Closure(): array<array-key, array<string, mixed>> */
    public Closure $createTestData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new TestSushiModel;
        $this->createTestData = static fn (): array => [];
    }

    public function tenantModel(): Tenant
    {
        Assert::assertInstanceOf(Tenant::class, $this->tenant);

        return $this->tenant;
    }

    public function secondTenantModel(): Tenant
    {
        Assert::assertInstanceOf(Tenant::class, $this->secondTenant);

        return $this->secondTenant;
    }

    public function tenantId(): string
    {
        $id = $this->tenantModel()->id;
        Assert::assertIsString($id);

        return $id;
    }

    public function sushiModel(): TestSushiModel
    {
        Assert::assertInstanceOf(TestSushiModel::class, $this->model);

        return $this->model;
    }

    public function sushiJsonPath(): string
    {
        if ($this->testJsonPath !== '') {
            return $this->testJsonPath;
        }

        return TenantService::filePath('database/content/test_sushi.json');
    }

    public function sushiTestDirectory(): string
    {
        if ($this->testDirectory !== '') {
            return $this->testDirectory;
        }

        return dirname($this->sushiJsonPath());
    }

    /** @return array<array-key, array<string, mixed>> */
    public function sushiTestData(): array
    {
        return ($this->createTestData)();
    }

    public function tenantMockExpectation(MockInterface $mock, string $method): Expectation
    {
        $expectation = $mock->shouldReceive($method);
        Assert::assertInstanceOf(Expectation::class, $expectation);

        return $expectation;
    }

    /**
     * @param  array<array-key, mixed>  $rows
     * @return array<string, mixed>
     */
    public function sushiRowById(array $rows, int|string $key): array
    {
        $id = is_int($key) ? $key : (is_numeric($key) ? SafeIntCastAction::cast($key) : 0);

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $rowId = $row['id'] ?? null;
            if (is_numeric($rowId) && SafeIntCastAction::cast($rowId) === $id) {
                /** @var array<string, mixed> $row */
                return $row;
            }
        }

        if (is_string($key) && array_key_exists($key, $rows)) {
            $candidate = $rows[$key];
            if (is_array($candidate)) {
                /** @var array<string, mixed> $candidate */
                return $candidate;
            }
        }

        return [];
    }

    public function setCurrentTenant(Tenant $tenant): void
    {
        $context = app('tenant');

        if (is_object($context) && method_exists($context, 'setCurrent')) {
            $context->setCurrent($tenant);
        }
    }

    /** @return array<array-key, array<string, mixed>> */
    public function readJsonFileAsArray(string $path): array
    {
        $decoded = json_decode(File::get($path), true);
        Assert::assertIsArray($decoded);

        /** @var array<array-key, array<string, mixed>> $decoded */
        return $decoded;
    }

    public function baseModelInstance(): BaseModel
    {
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);

        return $this->baseModel;
    }

    /**
     * @param  array<array-key, mixed>  $rows
     * @return array<string, mixed>
     */
    public function jsonRecordAt(array $rows, int|string $key): array
    {
        return $this->sushiRowById($rows, $key);
    }

    /**
     * @return array<string, mixed>
     */
    public function decodeJsonString(string $json): array
    {
        $decoded = json_decode($json, true);
        Assert::assertIsArray($decoded);

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

    /** @return array<int, class-string<ServiceProvider>> */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            TenantServiceProvider::class,
        ];
    }
}
