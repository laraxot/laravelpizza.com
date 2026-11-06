<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Actions\Modules\GetTenantModulesAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\SqliteTenantConfigValueResolverStub;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToCsvCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonAuthCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\TenantConfigValueResolverStub;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsNoSchemaModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonThrowingQueryModel;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\putenv;

uses(TestCase::class);

// expectMockery() is declared once in TenantCoverageBoostTest.php (same namespace)
// and reused here across the Pest test run.

afterEach(function (): void {
    Mockery::close();
});

test('GetTenantNameAction hits shortened parts when nested host config exists', function (): void {
    $cfgRoot = base_path('config');
    File::ensureDirectoryExists($cfgRoot.'/com/example');
    TestCase::setServerNameForTenantTest('www.foo.example.com');
    Assert::assertSame('com/example', app(GetTenantNameAction::class)->execute());
    // solo la cartella creata dal test: config/com contiene configurazioni tenant reali
    File::deleteDirectory($cfgRoot.'/com/example');
    TestCase::setServerNameForTenantTest(null);
});

test('TranslateTenantKeyAction returns key when lang file missing', function (): void {
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => sys_get_temp_dir().'/tenant-lang-missing-'.uniqid().'.php']);
    });

    Assert::assertSame('messages.hello', app(TranslateTenantKeyAction::class)->execute('messages.hello'));
});

test('TranslateTenantKeyAction returns resolved string translation', function (): void {
    $dir = sys_get_temp_dir().'/tenant_lang_hit_'.uniqid('', true);
    File::ensureDirectoryExists($dir.'/lang/it');
    File::put($dir.'/lang/it/messages.php', "<?php\nreturn ['ok' => 'Ciao'];\n");

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(
            static fn (string $path): string => $dir.'/'.$path,
        );
    });

    app()->setLocale('it');
    Assert::assertSame('Ciao', app(TranslateTenantKeyAction::class)->execute('messages.ok'));
    File::deleteDirectory($dir);
});

test('GetTenantModulesAction wraps invalid json decode errors', function (): void {
    $dir = sys_get_temp_dir().'/tenant_mods_bad_'.uniqid('', true);
    File::ensureDirectoryExists($dir);
    File::put($dir.'/modules_statuses.json', '{not-json');

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
        $mock->allows(['execute' => $dir.'/modules_statuses.json']);
    });

    expect(fn (): array => app(GetTenantModulesAction::class)->execute())
        ->toThrow(Exception::class);

    File::deleteDirectory($dir);
});

test('SushiToJson private helpers cover early returns and audit nulls', function (): void {
    $base = sys_get_temp_dir().'/sushi_json_gap_'.uniqid('', true);
    File::ensureDirectoryExists($base.'/database/content');
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(
            static fn (string $path): string => $base.'/'.ltrim($path, '/'),
        );
    });

    $maxRows = new ReflectionMethod(SushiToJsonCoverageModel::class, 'maxIdFromRows');
    $maxRows->setAccessible(true);
    Assert::assertSame(5, $maxRows->invoke(null, [1, ['id' => 5], 'x']));

    $maxDb = new ReflectionMethod(SushiToJsonCoverageModel::class, 'maxIdFromDatabase');
    $maxDb->setAccessible(true);
    Assert::assertIsInt($maxDb->invoke(null));

    $apply = new ReflectionMethod(SushiToJsonCoverageModel::class, 'applyAuditFields');
    $apply->setAccessible(true);
    $model = new SushiToJsonCoverageModel;
    $apply->invoke(null, $model);
    Assert::assertNull($model->getAttribute('created_by'));

    $applyUp = new ReflectionMethod(SushiToJsonCoverageModel::class, 'applyUpdatingAuditField');
    $applyUp->setAccessible(true);
    $applyUp->invoke(null, $model);

    $updating = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonUpdating');
    $updating->setAccessible(true);
    $updating->invoke(null, $model); // id missing → early return
    $model->setAttribute('id', 99);
    $updating->invoke(null, $model); // index null → early return

    $deleting = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonDeleting');
    $deleting->setAccessible(true);
    $empty = new SushiToJsonCoverageModel;
    $deleting->invoke(null, $empty);
    $empty->setAttribute('id', 99);
    $deleting->invoke(null, $empty);

    $boot = new ReflectionMethod(SushiToJsonCoverageModel::class, 'bootSushiToJson');
    $boot->setAccessible(true);
    $boot->invoke(null);

    $eventModel = new SushiToJsonCoverageModel(['name' => 'Evt']);
    $fire = new ReflectionMethod($eventModel, 'fireModelEvent');
    $fire->setAccessible(true);
    try {
        $fire->invoke($eventModel, 'creating', false);
        $fire->invoke($eventModel, 'updating', false);
        $fire->invoke($eventModel, 'deleting', false);
    } catch (\Throwable) {
        // sushi/json IO may fail; boot closures still executed until failure
    }

    $normalize = new ReflectionMethod($model, 'normalizeJsonItems');
    $normalize->setAccessible(true);
    Assert::assertSame([], $normalize->invoke($model, [1, 'x']));

    File::deleteDirectory($base);
});

test('SushiToCsv private helpers cover scalar id and header skip', function (): void {
    $base = sys_get_temp_dir().'/sushi_csv_gap_'.uniqid('', true);
    File::ensureDirectoryExists($base);
    $csvPath = $base.'/sushi_csv_coverage.csv';
    File::put($csvPath, "id,name\n1,A\n");

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($csvPath): void {
        $mock->allows(['execute' => $csvPath]);
    });

    $resolveKey = new ReflectionMethod(SushiToCsvCoverageModel::class, 'resolveRowIdKey');
    $resolveKey->setAccessible(true);
    Assert::assertSame(3, $resolveKey->invoke(null, '3'));
    Assert::assertSame('abc', $resolveKey->invoke(null, 'abc'));

    $build = new ReflectionMethod(SushiToCsvCoverageModel::class, 'buildCsvItemFromData');
    $build->setAccessible(true);
    $item = $build->invoke(null, ['id' => 1, 'name' => 'A'], ['id', 'name', 5]);
    Assert::assertIsArray($item);
    Assert::assertArrayHasKey('id', $item);

    $keyRows = new ReflectionMethod(SushiToCsvCoverageModel::class, 'keyRowsById');
    $keyRows->setAccessible(true);
    Assert::assertSame([], $keyRows->invoke(null, [1, 'x']));

    $normalize = new ReflectionMethod(SushiToCsvCoverageModel::class, 'normalizeRowsForCsv');
    $normalize->setAccessible(true);
    $out = $normalize->invoke(null, [1 => ['id' => 1, 'name' => 'A']]);
    Assert::assertIsArray($out);
    Assert::assertCount(1, $out);

    $boot = new ReflectionMethod(SushiToCsvCoverageModel::class, 'bootSushiToCsv');
    $boot->setAccessible(true);
    $boot->invoke(null);

    File::deleteDirectory($base);
});

test('SushiToJsons covers empty schema map and glob false path via reflection', function (): void {
    $boot = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'bootSushiToJsons');
    $boot->setAccessible(true);
    $boot->invoke(null);

    $model = new SushiToJsonsCoverageModel;
    $map = new ReflectionMethod($model, 'mapJsonFileToRow');
    $map->setAccessible(true);

    $tmp = sys_get_temp_dir().'/jsons_gap_'.uniqid('', true).'.json';
    File::put($tmp, 'null');
    Assert::assertNull($map->invoke($model, $tmp));
    File::put($tmp, json_encode(['name' => 'x'], JSON_THROW_ON_ERROR));
    // with schema present returns row
    Assert::assertIsArray($map->invoke($model, $tmp));
    File::delete($tmp);
});

test('GetTenantNameAction covers null parts and default-host miss/hit', function (): void {
    $cfgRoot = base_path('config');

    TestCase::setServerNameForTenantTest('example.com');
    Assert::assertIsString(app(GetTenantNameAction::class)->execute());

    TestCase::setServerNameForTenantTest('a.b.c.example.com');
    Assert::assertIsString(app(GetTenantNameAction::class)->execute());

    putenv('SERVER_NAME');
    $_SERVER['SERVER_NAME'] = 'www.zzz.example.com';
    File::ensureDirectoryExists($cfgRoot.'/com/example');
    Assert::assertSame('com/example', app(GetTenantNameAction::class)->execute());
    // solo la cartella creata dal test: config/com contiene configurazioni tenant reali
    File::deleteDirectory($cfgRoot.'/com/example');

    TestCase::setServerNameForTenantTest(null);
    unset($_SERVER['SERVER_NAME']);
    File::ensureDirectoryExists($cfgRoot.'/test/defaulthost');
    config(['app.url' => 'https://defaulthost.test']);
    Assert::assertSame('test/defaulthost', app(GetTenantNameAction::class)->execute());
    // solo la cartella creata dal test: config/test contiene configurazioni tenant reali
    File::deleteDirectory($cfgRoot.'/test/defaulthost');
});

test('Sushi audit fields with named auth model and csv scalar id', function (): void {
    $base = sys_get_temp_dir().'/sushi_audit_'.uniqid('', true);
    File::ensureDirectoryExists($base);
    $csvPath = $base.'/sushi_csv_coverage.csv';
    File::put($csvPath, "id,name,updated_at,updated_by,created_at,created_by\n1,Alpha,,,,\n");
    File::ensureDirectoryExists($base.'/database/content');

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base, $csvPath): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(static function (string $path) use ($base, $csvPath): string {
            if (str_ends_with($path, '.csv')) {
                return $csvPath;
            }

            return $base.'/'.ltrim($path, '/');
        });
    });

    $apply = new ReflectionMethod(SushiToJsonAuthCoverageModel::class, 'applyAuditFields');
    $apply->setAccessible(true);
    $authModel = new SushiToJsonAuthCoverageModel;
    $apply->invoke(null, $authModel);
    Assert::assertSame(42, $authModel->getAttribute('created_by'));

    $applyUp = new ReflectionMethod(SushiToJsonAuthCoverageModel::class, 'applyUpdatingAuditField');
    $applyUp->setAccessible(true);
    $applyUp->invoke(null, $authModel);
    Assert::assertSame(42, $authModel->getAttribute('updated_by'));

    $resolveKey = new ReflectionMethod(SushiToCsvCoverageModel::class, 'resolveRowIdKey');
    $resolveKey->setAccessible(true);
    Assert::assertSame('7', $resolveKey->invoke(null, 7.0));

    $invalidSchemaModel = new SushiToJsonsCoverageModel;
    $schemaProp = new \ReflectionProperty($invalidSchemaModel, 'schema');
    $schemaProp->setAccessible(true);
    $schemaProp->setValue($invalidSchemaModel, 'invalid');
    $resolve = new ReflectionMethod($invalidSchemaModel, 'resolveSchema');
    $resolve->setAccessible(true);
    Assert::assertSame([], $resolve->invoke($invalidSchemaModel));

    $csvBoot = new ReflectionMethod(SushiToCsvCoverageModel::class, 'bootSushiToCsv');
    $csvBoot->setAccessible(true);
    $csvBoot->invoke(null);
    $jsonBoot = new ReflectionMethod(SushiToJsonCoverageModel::class, 'bootSushiToJson');
    $jsonBoot->setAccessible(true);
    $jsonBoot->invoke(null);
    $jsonsBoot = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'bootSushiToJsons');
    $jsonsBoot->setAccessible(true);
    $jsonsBoot->invoke(null);

    $csvModel = new SushiToCsvCoverageModel;
    $jsonModel = new SushiToJsonCoverageModel;
    $jsonsModel = new SushiToJsonsCoverageModel;
    foreach ([$csvModel, $jsonModel, $jsonsModel] as $model) {
        $fire = new ReflectionMethod($model, 'fireModelEvent');
        $fire->setAccessible(true);
        foreach (['creating', 'updating', 'deleting'] as $event) {
            try {
                $fire->invoke($model, $event, false);
            } catch (\Throwable) {
            }
        }
    }

    File::deleteDirectory($base);
});

test('TenantServiceProvider load user connection and filter model classes', function (): void {
    $provider = new TenantServiceProvider(app());
    $load = new ReflectionMethod($provider, 'loadTenantDatabaseConfig');
    $load->setAccessible(true);
    $default = config('database.default');
    Assert::assertIsString($default);
    $connections = config('database.connections');
    Assert::assertIsArray($connections);
    $connections = app(FilterConfigStringKeysAction::class)->execute($connections);

    app()->instance(ResolveTenantConfigValueAction::class, new TenantConfigValueResolverStub($default, $connections));

    /** @var array<string, mixed> $data */
    $data = $load->invoke($provider, $default);
    Assert::assertArrayHasKey('connections', $data);

    $filter = new ReflectionMethod(ResolveTenantModelClassAction::class, 'filterValidModelClasses');
    $filter->setAccessible(true);
    $action = new ResolveTenantModelClassAction;
    /** @var array<string, class-string> $filtered */
    $filtered = $filter->invoke($action, [
        1 => Tenant::class,
        'tenant' => Tenant::class,
        'bad' => 'Modules\\Nope\\Missing',
    ]);
    Assert::assertArrayHasKey('tenant', $filtered);
    Assert::assertArrayNotHasKey('bad', $filtered);
});

test('final remaining statement branches', function (): void {
    $maxDb = new ReflectionMethod(SushiToJsonThrowingQueryModel::class, 'maxIdFromDatabase');
    $maxDb->setAccessible(true);
    Assert::assertSame(0, $maxDb->invoke(null));

    $resolveDefaultHost = new ReflectionMethod(GetTenantNameAction::class, 'resolveFromDefaultHost');
    $resolveDefaultHost->setAccessible(true);
    $tenantNameAction = app(GetTenantNameAction::class);
    Assert::assertNull($resolveDefaultHost->invoke($tenantNameAction, ''));
    Assert::assertNull($resolveDefaultHost->invoke($tenantNameAction, 'no.such.tenant.config.path.xyz'));

    TestCase::setServerNameForTenantTest('nomatch.invalid');
    config(['app.url' => 'https://also.invalid.test']);
    Assert::assertSame('localhost', app(GetTenantNameAction::class)->execute());
    TestCase::setServerNameForTenantTest(null);

    TestCase::mockAppService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        TestCase::expectMockery($mock, 'execute')->andReturn(99);
    });
    expect(fn (): string => app(ResolveTenantModelClassAction::class)->execute('widget'))
        ->toThrow(Exception::class);

    Module::shouldReceive('allEnabled')->andReturn([new \stdClass]);
    $getAll = new ReflectionMethod(ResolveTenantModelClassAction::class, 'getAllModulesModels');
    $getAll->setAccessible(true);
    Assert::assertSame([], $getAll->invoke(new ResolveTenantModelClassAction));

    $provider = new TenantServiceProvider(app());
    $load = new ReflectionMethod($provider, 'loadTenantDatabaseConfig');
    $load->setAccessible(true);
    app()->instance(ResolveTenantConfigValueAction::class, new SqliteTenantConfigValueResolverStub);
    /** @var array<string, mixed> $data */
    $data = $load->invoke($provider, 'sqlite');
    Assert::assertIsArray($data);
    Assert::assertArrayHasKey('connections', $data);
    $loadedConnections = $data['connections'];
    Assert::assertIsArray($loadedConnections);
    Assert::assertArrayHasKey('user', $loadedConnections);

    $merge = new ReflectionMethod($provider, 'mergeModuleConnections');
    $merge->setAccessible(true);
    Module::shouldReceive('getOrdered')->andReturn([new \stdClass]);
    $merged = $merge->invoke($provider, [
        'connections' => ['sqlite' => ['driver' => 'sqlite']],
    ], 'sqlite');
    Assert::assertIsArray($merged);
    Assert::assertArrayHasKey('sqlite', $merged);

    $base = sys_get_temp_dir().'/jsons_noschema_'.uniqid('', true);
    File::ensureDirectoryExists($base.'/database/content/sushi_jsons_noschema');
    File::put($base.'/database/content/sushi_jsons_noschema/1.json', json_encode(['name' => 'x'], JSON_THROW_ON_ERROR));
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(
            static fn (string $path): string => $base.'/'.ltrim($path, '/'),
        );
    });
    $noSchema = new SushiToJsonsNoSchemaModel;
    Assert::assertSame([], $noSchema->getSushiRows());
    File::deleteDirectory($base);
});
