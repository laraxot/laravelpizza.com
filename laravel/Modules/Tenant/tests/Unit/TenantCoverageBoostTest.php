<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Actions\Config\GetTenantConfigPathAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\MergeRecursiveStringKeyConfigAction;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Filament\Resources\DomainResource;
use Modules\Tenant\Filament\Resources\DomainResource\Schemas\DomainForm;
use Modules\Tenant\Filament\Resources\DomainResource\Schemas\DomainInfolist;
use Modules\Tenant\Filament\Resources\DomainResource\Tables\DomainsTable;
use Modules\Tenant\Models\DatabaseConfig;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Models\Policies\DomainPolicy;
use Modules\Tenant\Models\Policies\TenantBasePolicy;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\Traits\SushiToCsv;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\CatalogSushiCsvModel;
use Modules\Tenant\Tests\Unit\Fixtures\CatalogSushiJsonsModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToPhpArrayCoverageModel;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('Tenant coverage boost — Config actions', function (): void {
    test('FilterConfigStringKeysAction keeps only string keys', function (): void {
        $result = app(FilterConfigStringKeysAction::class)->execute([
            'valid' => 1,
            0 => 'ignored',
            'nested' => ['a' => 1],
        ]);

        Assert::assertSame(['valid' => 1, 'nested' => ['a' => 1]], $result);
        Assert::assertArrayNotHasKey(0, $result);
    });

    test('MergeRecursiveStringKeyConfigAction merges nested configs', function (): void {
        $merged = app(MergeRecursiveStringKeyConfigAction::class)->execute(
            ['mail' => ['driver' => 'smtp', 'host' => 'localhost']],
            ['mail' => ['host' => 'tenant-host'], 1 => 'skip'],
        );

        $mail = $merged['mail'];
        Assert::assertIsArray($mail);
        Assert::assertSame('tenant-host', $mail['host']);
        Assert::assertSame('smtp', $mail['driver']);
    });
});

describe('Tenant coverage boost — Domain sushi', function (): void {
    test('Domain getRows loads from GetDomainsArrayAction', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => [
                ['id' => 1, 'name' => 'tenant.example.com'],
            ]]);
        });

        $rows = (new Domain)->getRows();

        Assert::assertCount(1, $rows);
        Assert::assertSame('tenant.example.com', $rows[0]['name']);
    });
});

describe('Tenant coverage boost — Models and resolvers', function (): void {
    test('Tenant isActive reflects is_active attribute', function (): void {
        $active = new Tenant(['is_active' => true]);
        $inactive = new Tenant(['is_active' => false]);

        Assert::assertTrue($active->isActive());
        Assert::assertFalse($inactive->isActive());
    });
});

describe('Tenant coverage boost — tenant-aware Actions', function (): void {
    test('file path, config path and config value derive from the current tenant name', function (): void {
        TestCase::mockAppService(GetTenantNameAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'tenant/a']);
        });
        config(['app' => ['name' => 'Base App'], 'tenant.a.app' => ['name' => 'Tenant App']]);

        Assert::assertSame(
            str_replace('/', DIRECTORY_SEPARATOR, base_path('config/tenant/a/settings.json')),
            app(GetTenantFilePathAction::class)->execute('settings.json'),
        );
        Assert::assertSame('tenant.a.app', app(GetTenantConfigPathAction::class)->execute('app'));
        Assert::assertSame('Tenant App', app(ResolveTenantConfigValueAction::class)->execute('app.name'));
    });
});

describe('Tenant coverage boost — Filament and policy surface', function (): void {
    test('domain resource schemas and tables are executable', function (): void {
        $resourcePages = DomainResource::getPages();
        $formSchema = app(DomainForm::class)->getFormSchema();
        $infolistSchema = app(DomainInfolist::class)->getInfolistSchema();
        $tableColumns = (new DomainsTable)->getTableColumns();

        Assert::assertArrayHasKey('index', $resourcePages);
        Assert::assertArrayHasKey('title', $formSchema);
        Assert::assertArrayHasKey('id', $infolistSchema);
        Assert::assertArrayHasKey('updated_at', $tableColumns);
        Assert::assertSame([], DomainResource::getRelations());
    });

    test('tenant policies enforce business rules', function (): void {
        /** @var MockInterface&UserContract $superAdmin */
        $superAdmin = Mockery::mock(UserContract::class);
        TestCase::expectMockery($superAdmin, 'hasRole')->with('super-admin')->andReturn(true);
        TestCase::expectMockery($superAdmin, 'hasPermissionTo')->andReturn(false);

        /** @var MockInterface&UserContract $editor */
        $editor = Mockery::mock(UserContract::class);
        TestCase::expectMockery($editor, 'hasRole')->with('super-admin')->andReturn(false);
        TestCase::expectMockery($editor, 'hasPermissionTo')->andReturnUsing(
            static fn (string $permission): bool => in_array($permission, ['domain.view', 'domain.update'], true),
        );

        $policy = new DomainPolicy;
        $domain = new Domain;
        $domain->exists = true;

        Assert::assertTrue((new class extends TenantBasePolicy {})->before($superAdmin, 'viewAny'));
        Assert::assertTrue($policy->view($editor, $domain));
        Assert::assertTrue($policy->update($editor, $domain));
        Assert::assertFalse($policy->delete($editor, $domain));
    });

    test('DatabaseConfig model casts port and options', function (): void {
        $model = new DatabaseConfig;

        Assert::assertSame('integer', $model->getCasts()['port']);
        Assert::assertSame('array', $model->getCasts()['options']);
    });
});

describe('Tenant coverage boost — Sushi file traits', function (): void {
    test('sushi to jsons collects rows from tenant json files', function (): void {
        $baseDir = sys_get_temp_dir().'/tenant_jsons_'.uniqid();
        File::ensureDirectoryExists($baseDir.'/database/content/catalog');
        File::put($baseDir.'/database/content/catalog/1.json', json_encode(['name' => 'Alpha', 'meta' => ['x' => 1]]));

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($baseDir): void {
            TestCase::expectMockery($mock, 'execute')->andReturnUsing(
                static fn (string $path): string => $baseDir.'/'.ltrim($path, '/'),
            );
        });

        $model = new CatalogSushiJsonsModel;

        $rows = $model->getSushiRows();

        Assert::assertCount(1, $rows);
        Assert::assertSame('Alpha', $rows[0]['name']);
        Assert::assertIsString($rows[0]['meta']);
        Assert::assertStringContainsString('"x": 1', $rows[0]['meta']);
    });

    test('sushi to csv reads rows and header from tenant csv file', function (): void {
        $baseDir = sys_get_temp_dir().'/tenant_csv_'.uniqid();
        File::ensureDirectoryExists($baseDir);
        File::put($baseDir.'/catalog.csv', "id,name\n1,Alpha\n2,Beta\n");

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($baseDir): void {
            TestCase::expectMockery($mock, 'execute')->andReturnUsing(
                static fn (string $path): string => $baseDir.'/'.basename($path),
            );
        });

        $model = new CatalogSushiCsvModel;

        Assert::assertSame(['id', 'name'], $model->getCsvHeader());
        Assert::assertCount(2, $model->getSushiRows());
        Assert::assertSame('Alpha', $model->getSushiRows()[0]['name']);
    });

    test('sushi to php array normalizes tenant config rows', function (): void {
        TestCase::mockAppService(GetTenantConfigArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => [
                ['name' => 'Alpha', 'meta' => null, 0 => 'skip'],
                ['name' => 'Beta', 'meta' => '{"x":1}'],
            ]]);
        });
        $model = new SushiToPhpArrayCoverageModel;

        $rows = $model->getSushiRows();

        Assert::assertCount(2, $rows);
        Assert::assertSame(['name' => 'Alpha', 'meta' => null], $rows[0]);
        Assert::assertSame('Beta', $rows[1]['name']);
        Assert::assertSame('{"x":1}', $rows[1]['meta']);
    });
});
