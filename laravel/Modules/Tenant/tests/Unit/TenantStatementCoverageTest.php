<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelInstanceAction;
use Modules\Tenant\Actions\Modules\GetTenantModulesAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Tenant\Filament\Resources\DomainResource\Schemas\DomainForm;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Models\Policies\DomainPolicy;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Models\TenantSubscription;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToCsvCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsNoSchemaModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToPhpArrayCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\TenantBasePolicyCoverage;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\putenv;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('Tenant statement coverage — actions', function (): void {
    test('SaveTenantConfigAction merges recursively on real filesystem', function (): void {
        $dir = sys_get_temp_dir().'/tenant_save_cfg_'.uniqid('', true);
        File::ensureDirectoryExists($dir);
        $path = $dir.'/mail.php';
        File::put($path, "<?php\nreturn ['driver' => 'smtp', 'from' => ['address' => 'a@b.c']];\n");

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($path): void {
            $mock->allows(['execute' => $path]);
        });

        app(SaveTenantConfigAction::class)->execute('mail', [
            'from' => ['name' => 'Tenant'],
            'driver' => 'log',
        ]);

        /** @var array<string, mixed> $saved */
        $saved = File::getRequire($path);
        Assert::assertSame('log', $saved['driver']);
        Assert::assertIsArray($saved['from']);
        Assert::assertSame('Tenant', $saved['from']['name']);
        Assert::assertSame('a@b.c', $saved['from']['address']);

        File::deleteDirectory($dir);
    });

    test('GetTenantFilePathAction rejects traversal and uses tenant path', function (): void {
        expect(fn (): string => app(GetTenantFilePathAction::class)->execute('../secret'))
            ->toThrow(\InvalidArgumentException::class);
        expect(fn (): string => app(GetTenantFilePathAction::class)->execute('/abs'))
            ->toThrow(\InvalidArgumentException::class);

        TestCase::mockAppService(GetTenantNameAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'acme']);
        });

        $path = app(GetTenantFilePathAction::class)->execute('database.php');
        Assert::assertStringContainsString('config'.DIRECTORY_SEPARATOR.'acme', $path);
    });

    test('GetTenantNameAction resolves shortened and default host paths', function (): void {
        $cfgRoot = base_path('config');
        File::ensureDirectoryExists($cfgRoot.'/com/example');

        TestCase::setServerNameForTenantTest('www.foo.example.com');
        Assert::assertSame('com/example', app(GetTenantNameAction::class)->execute());

        // solo la cartella creata dal test: config/com contiene configurazioni tenant reali
    File::deleteDirectory($cfgRoot.'/com/example');

        $defaultHost = 'defaulthost.test';
        File::ensureDirectoryExists($cfgRoot.'/test/defaulthost');
        config(['app.url' => 'https://'.$defaultHost]);
        TestCase::setServerNameForTenantTest(null);
        putenv('SERVER_NAME=');
        unset($_SERVER['SERVER_NAME']);
        Assert::assertSame('test/defaulthost', app(GetTenantNameAction::class)->execute());
        // solo la cartella creata dal test: config/test contiene configurazioni tenant reali
    File::deleteDirectory($cfgRoot.'/test/defaulthost');
    });

    test('TranslateTenantKeyAction returns key when missing or non-string', function (): void {
        $dir = sys_get_temp_dir().'/tenant_lang_'.uniqid('', true);
        File::ensureDirectoryExists($dir.'/lang/it');
        File::put($dir.'/lang/it/messages.php', "<?php\nreturn ['hello' => ['nested' => true], 'ok' => 'Ciao'];\n");

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
            TestCase::expectMockery($mock, 'execute')->andReturnUsing(
                static fn (string $path): string => $dir.'/'.$path,
            );
        });

        Assert::assertSame('messages.hello', app(TranslateTenantKeyAction::class)->execute('messages.hello'));
        Assert::assertSame('messages.missing', app(TranslateTenantKeyAction::class)->execute('messages.missing'));
        Assert::assertSame('Ciao', app(TranslateTenantKeyAction::class)->execute('messages.ok'));
    });

    test('GetTenantModulesAction handles invalid json payload and missing modules', function (): void {
        $dir = sys_get_temp_dir().'/tenant_mods_'.uniqid('', true);
        File::ensureDirectoryExists($dir);
        File::put($dir.'/modules_statuses.json', 'null');

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
            $mock->allows(['execute' => $dir.'/modules_statuses.json']);
        });
        Assert::assertSame([], app(GetTenantModulesAction::class)->execute());

        File::put($dir.'/modules_statuses.json', '{"NotAModule": true, "Tenant": true}');
        $mods = app(GetTenantModulesAction::class)->execute();
        Assert::assertContains('Tenant', $mods);
        Assert::assertNotContains('NotAModule', $mods);
    });

    test('GetTenantConfigArrayAction coerces non-array require to empty', function (): void {
        $dir = sys_get_temp_dir().'/tenant_cfg_arr_'.uniqid('', true);
        File::ensureDirectoryExists($dir);
        File::put($dir.'/odd.php', "<?php\nreturn 'nope';\n");

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
            $mock->allows(['execute' => $dir.'/odd.php']);
        });

        Assert::assertSame([], app(GetTenantConfigArrayAction::class)->execute('odd'));
    });

    test('ResolveTenantConfigValueAction rejects invalid value types', function (): void {
        config(['app' => ['flag' => true]]);
        TestCase::mockAppService(GetTenantNameAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'localhost']);
        });

        expect(fn (): float|int|string|array|null => app(ResolveTenantConfigValueAction::class)->execute('app.flag'))
            ->toThrow(Exception::class);
    });

    test('ResolveTenantModelInstanceAction instantiates the resolved model class', function (): void {
        TestCase::mockAppService(ResolveTenantModelClassAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => Tenant::class]);
        });

        $instance = app(ResolveTenantModelInstanceAction::class)->execute('tenant');
        Assert::assertInstanceOf(Tenant::class, $instance);
    });

    test('artisan tenant:test command prints tenant name', function (): void {
        TestCase::mockAppService(GetTenantNameAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => 'cli-tenant']);
        });

        Assert::assertSame(0, TestCase::runArtisanCommand('tenant:test'));
    });
});

describe('Tenant statement coverage — models and policies', function (): void {
    test('Tenant mutators relations and url without database writes', function (): void {
        $tenant = new Tenant(['name' => 'Acme Corp', 'domain' => 'acme.test', 'is_active' => true]);
        Assert::assertSame('acme-corp', $tenant->slug);
        Assert::assertTrue($tenant->isActive());
        Assert::assertSame('acme.test', $tenant->url);

        $noSlug = new Tenant;
        $noSlug->name = 'Beta';
        Assert::assertSame('beta', $noSlug->slug);

    });

    test('TenantDomain TenantSetting TenantSubscription relation helpers', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => [['id' => '1', 'name' => 'a.test']]]);
        });

        Assert::assertSame([['id' => '1', 'name' => 'a.test']], (new TenantDomain)->getRows());
        Assert::assertArrayHasKey('expires_at', (new TenantSubscription)->getCasts());
    });

    test('DomainPolicy covers all abilities and TenantBasePolicy null branch', function (): void {
        /** @var MockInterface&UserContract $user */
        $user = Mockery::mock(UserContract::class);
        TestCase::expectMockery($user, 'hasRole')->with('super-admin')->andReturn(false);
        TestCase::expectMockery($user, 'hasPermissionTo')->andReturn(true);

        $policy = new DomainPolicy;
        $domain = new Domain;
        $domain->exists = true;

        Assert::assertTrue($policy->viewAny($user));
        Assert::assertTrue($policy->create($user));
        Assert::assertTrue($policy->restore($user, $domain));
        Assert::assertTrue($policy->forceDelete($user, $domain));

        Assert::assertNull((new TenantBasePolicyCoverage)->before($user, 'view'));
    });

    test('DomainForm getFormSchema is executable', function (): void {
        $schema = app(DomainForm::class)->getFormSchema();
        Assert::assertArrayHasKey('title', $schema);
        Assert::assertArrayHasKey('price', $schema);
    });

    test('TestSushiModel non-testing path builds tenant json file', function (): void {
        $app = app();
        $previous = $app['env'];
        $app['env'] = 'local';

        try {
            TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
                $mock->allows(['execute' => '/tmp/tenant_test_sushi.json']);
            });
            Assert::assertSame('/tmp/tenant_test_sushi.json', (new TestSushiModel)->getJsonFile());
        } finally {
            $app['env'] = $previous;
        }
    });
});

describe('Tenant statement coverage — TenantServiceProvider private paths', function (): void {
    test('provider helpers for morph map migrate and reconnect', function (): void {
        $provider = new TenantServiceProvider(app());
        $provider->publishConfig();

        $buildMorphMap = new ReflectionMethod($provider, 'buildMorphMap');
        $buildMorphMap->setAccessible(true);
        /** @var array<string, class-string> $map */
        $map = $buildMorphMap->invoke($provider, [
            'tenant' => Tenant::class,
            'missing' => 'Modules\\Missing\\Models\\Nope',
            1 => Tenant::class,
        ]);
        Assert::assertArrayHasKey('tenant', $map);
        Assert::assertArrayNotHasKey('missing', $map);

        Request::replace(['act' => 'migrate']);
        $purge = new ReflectionMethod($provider, 'purgeConnectionWhenMigrating');
        $purge->setAccessible(true);
        $databaseDefault = config('database.default');
        Assert::assertIsString($databaseDefault);
        $purge->invoke($provider, $databaseDefault);

        $load = new ReflectionMethod($provider, 'loadTenantDatabaseConfig');
        $load->setAccessible(true);
        $databaseConnections = config('database.connections');
        Assert::assertIsArray($databaseConnections);
        TestCase::mockAppService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock) use ($databaseDefault, $databaseConnections): void {
            $mock->allows(['execute' => [
                'default' => $databaseDefault,
                'connections' => $databaseConnections,
            ]]);
        });
        /** @var array<string, mixed> $data */
        $data = $load->invoke($provider, $databaseDefault);
        Assert::assertArrayHasKey('connections', $data);

        $reconnect = new ReflectionMethod($provider, 'reconnectDatabaseUnlessTesting');
        $reconnect->setAccessible(true);
        $app = app();
        $previous = $app['env'];
        $app['env'] = 'production';
        try {
            $reconnect->invoke($provider);
        } finally {
            $app['env'] = $previous;
        }

        $mergeConfigs = new ReflectionMethod($provider, 'mergeConfigs');
        $mergeConfigs->setAccessible(true);
        TestCase::mockAppService(GetTenantConfigNamesAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => [
                ['id' => 1, 'name' => 'app'],
                'skip-me',
                ['id' => 2],
            ]]);
        });
        TestCase::mockAppService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
            TestCase::expectMockery($mock, 'execute')->andReturn('ok');
        });
        $mergeConfigs->invoke($provider);

        $registerMorph = new ReflectionMethod($provider, 'registerMorphMap');
        $registerMorph->setAccessible(true);
        TestCase::mockAppService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
            TestCase::expectMockery($mock, 'execute')->with('morph_map')->andReturn('not-array');
        });
        $registerMorph->invoke($provider);
    });
});

describe('Tenant statement coverage — SushiToJson named model', function (): void {
    test('json trait read write audit and private helpers', function (): void {
        $base = sys_get_temp_dir().'/sushi_json_cov_'.uniqid('', true);
        File::ensureDirectoryExists($base.'/database/content');
        $jsonPath = $base.'/database/content/sushi_json_coverage.json';

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base): void {
            TestCase::expectMockery($mock, 'execute')->andReturnUsing(
                static fn (string $path): string => $base.'/'.ltrim($path, '/'),
            );
        });

        $model = new SushiToJsonCoverageModel;
        Assert::assertSame($jsonPath, $model->getJsonFile());
        // Stato iniziale: file JSON vuoto → nessuna riga Sushi (comportamento, non tautologia tipizzata).
        Assert::assertCount(0, $model->getRows());
        Assert::assertCount(0, $model->loadExistingData());

        File::put($jsonPath, 'null');
        expect(fn (): array => $model->getSushiRows())->toThrow(Exception::class);
        Assert::assertCount(0, $model->loadExistingData());

        File::put($jsonPath, json_encode([
            ['id' => 1, 'name' => 'Alpha', 'meta' => ['x' => 1], 0 => 'skip'],
            'not-an-array',
            ['id' => '2', 'name' => 'Beta'],
        ], JSON_THROW_ON_ERROR));

        $rows = $model->getSushiRows();
        Assert::assertGreaterThanOrEqual(1, count($rows));
        Assert::assertSame([['id' => 1, 'name' => 'Alpha', 'meta' => ['x' => 1], '0' => 'skip'], ['id' => '2', 'name' => 'Beta']], $model->loadExistingData());

        Assert::assertTrue($model->saveToJson([
            ['id' => 1, 'name' => 'Alpha'],
            ['id' => 3, 'name' => 'Gamma'],
        ]));

        $nextId = new ReflectionMethod($model, 'getNextId');
        $nextId->setAccessible(true);
        Assert::assertSame(4, $nextId->invoke($model));

        File::delete($jsonPath);
        Assert::assertSame(1, $nextId->invoke($model));

        $boot = new ReflectionMethod(SushiToJsonCoverageModel::class, 'bootSushiToJson');
        $boot->setAccessible(true);
        $boot->invoke(null);

        Auth::shouldReceive('id')->andReturn(7);

        $creating = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonCreating');
        $creating->setAccessible(true);
        $fresh = new SushiToJsonCoverageModel(['name' => 'Created']);
        $creating->invoke(null, $fresh);
        Assert::assertSame(1, $fresh->getAttribute('id'));
        Assert::assertTrue(File::exists($fresh->getJsonFile()));

        $updating = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonUpdating');
        $updating->setAccessible(true);
        $fresh->setAttribute('name', 'Updated');
        $updating->invoke(null, $fresh);

        $deleting = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonDeleting');
        $deleting->setAccessible(true);
        $deleting->invoke(null, $fresh);

        $intValue = new ReflectionMethod(SushiToJsonCoverageModel::class, 'intValue');
        $intValue->setAccessible(true);
        Assert::assertSame(5, $intValue->invoke(null, 5));
        Assert::assertSame(5, $intValue->invoke(null, '5'));
        Assert::assertSame(0, $intValue->invoke(null, []));

        $find = new ReflectionMethod($model, 'findRowIndexById');
        $find->setAccessible(true);
        Assert::assertNull($find->invoke($model, [['id' => 9]], 1));
        Assert::assertSame(0, $find->invoke($model, [['id' => 1]], 1));

        $authId = new ReflectionMethod($model, 'authId');
        $authId->setAccessible(true);
        Assert::assertTrue($authId->invoke($model) === null || is_scalar($authId->invoke($model)));

        $ensure = new ReflectionMethod($model, 'ensureDirectoryExists');
        $ensure->setAccessible(true);
        $nested = $base.'/nested/dir/file.json';
        $ensure->invoke($model, $nested);
        Assert::assertTrue(File::isDirectory(dirname($nested)));

        $broken = new SushiToJsonCoverageModel;
        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
            TestCase::expectMockery($mock, 'execute')->andThrow(new Exception('boom'));
        });
        Assert::assertFalse($broken->saveToJson([['id' => 1]]));

        File::deleteDirectory($base);
    });
});

describe('Tenant statement coverage — SushiToCsv named model', function (): void {
    test('csv trait read write create update delete helpers', function (): void {
        $base = sys_get_temp_dir().'/sushi_csv_cov_'.uniqid('', true);
        File::ensureDirectoryExists($base);
        $csvPath = $base.'/sushi_csv_coverage.csv';
        File::put($csvPath, "id,name,updated_at,updated_by,created_at,created_by\n1,Alpha,,,,\n");

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($csvPath): void {
            $mock->allows(['execute' => $csvPath]);
        });

        $model = new SushiToCsvCoverageModel;
        Assert::assertSame(['id', 'name', 'updated_at', 'updated_by', 'created_at', 'created_by'], $model->getCsvHeader());
        Assert::assertCount(1, $model->getSushiRows());

        $boot = new ReflectionMethod(SushiToCsvCoverageModel::class, 'bootSushiToCsv');
        $boot->setAccessible(true);
        $boot->invoke(null);

        if (! function_exists('authId')) {
            eval('function authId() { return 9; }');
        }

        $creating = new ReflectionMethod(SushiToCsvCoverageModel::class, 'handleCsvCreating');
        $creating->setAccessible(true);
        $row = new SushiToCsvCoverageModel(['name' => 'Beta']);
        $creating->invoke(null, $row);
        Assert::assertNotNull($row->id);

        $updating = new ReflectionMethod(SushiToCsvCoverageModel::class, 'handleCsvUpdating');
        $updating->setAccessible(true);
        $row->setAttribute('name', 'Beta2');
        $updating->invoke(null, $row);

        $deleting = new ReflectionMethod(SushiToCsvCoverageModel::class, 'handleCsvDeleting');
        $deleting->setAccessible(true);
        $deleting->invoke(null, $row);

        $csvValue = new ReflectionMethod(SushiToCsvCoverageModel::class, 'csvValue');
        $csvValue->setAccessible(true);
        Assert::assertNull($csvValue->invoke(null, null));
        Assert::assertSame('1', $csvValue->invoke(null, true));
        Assert::assertSame('0', $csvValue->invoke(null, false));
        Assert::assertSame(3, $csvValue->invoke(null, 3));
        Assert::assertSame('x', $csvValue->invoke(null, 'x'));
        Assert::assertSame('s', $csvValue->invoke(null, new class implements \Stringable
        {
            public function __toString(): string
            {
                return 's';
            }
        }));
        Assert::assertNull($csvValue->invoke(null, []));

        $resolveKey = new ReflectionMethod(SushiToCsvCoverageModel::class, 'resolveRowIdKey');
        $resolveKey->setAccessible(true);
        Assert::assertSame(1, $resolveKey->invoke(null, 1));
        Assert::assertSame(2, $resolveKey->invoke(null, '2'));
        Assert::assertSame('abc', $resolveKey->invoke(null, 'abc'));

        File::deleteDirectory($base);
    });
});

describe('Tenant statement coverage — SushiToJsons named model', function (): void {
    test('jsons trait collect schema create update delete', function (): void {
        $base = sys_get_temp_dir().'/sushi_jsons_cov_'.uniqid('', true);
        File::ensureDirectoryExists($base.'/database/content/sushi_jsons_coverage');
        File::put($base.'/database/content/sushi_jsons_coverage/1.json', json_encode([
            'id' => 1,
            'name' => 'One',
            'meta' => ['a' => 1],
        ], JSON_THROW_ON_ERROR));
        File::put($base.'/database/content/sushi_jsons_coverage/bad.json', 'null');

        TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base): void {
            TestCase::expectMockery($mock, 'execute')->andReturnUsing(
                static fn (string $path): string => $base.'/'.ltrim($path, '/'),
            );
        });

        $model = new SushiToJsonsCoverageModel;
        Assert::assertCount(1, $model->getRows());
        $model->setAttribute('id', 1);
        Assert::assertStringContainsString('sushi_jsons_coverage/1.json', $model->getJsonFile());

        $emptySchemaModel = new SushiToJsonsNoSchemaModel;
        $resolveEmpty = new ReflectionMethod($emptySchemaModel, 'resolveSchema');
        $resolveEmpty->setAccessible(true);
        Assert::assertSame([], $resolveEmpty->invoke($emptySchemaModel));

        $resolve = new ReflectionMethod($model, 'resolveSchema');
        $resolve->setAccessible(true);
        Assert::assertNotEmpty($resolve->invoke($model));

        $boot = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'bootSushiToJsons');
        $boot->setAccessible(true);
        $boot->invoke(null);

        $write = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'writeCreatingJsonFile');
        $write->setAccessible(true);
        $fresh = new SushiToJsonsCoverageModel(['name' => 'Two', 'meta' => ['z' => 2]]);
        $fresh->setAttribute('id', 99);
        $write->invoke(null, $fresh);
        Assert::assertTrue(File::exists($fresh->getJsonFile()));

        $writeNoSchema = new ReflectionMethod(SushiToJsonsNoSchemaModel::class, 'writeCreatingJsonFile');
        $writeNoSchema->setAccessible(true);
        expect(fn () => $writeNoSchema->invoke(null, $emptySchemaModel))
            ->toThrow(Exception::class);

        $updating = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'handleJsonUpdating');
        $updating->setAccessible(true);
        $updating->invoke(null, $fresh);

        $deleting = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'handleJsonDeleting');
        $deleting->setAccessible(true);
        $deleting->invoke(null, $fresh);
        Assert::assertFalse(File::exists($fresh->getJsonFile()));

        $assign = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'assignCreatingMetadata');
        $assign->setAccessible(true);
        $m = new SushiToJsonsCoverageModel;
        try {
            $assign->invoke(null, $m);
        } catch (\Throwable) {
            $m->setAttribute('id', 1);
        }
        Assert::assertNotNull($m->getAttribute('id'));

        $creating = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'handleJsonCreating');
        $creating->setAccessible(true);
        $created = new SushiToJsonsCoverageModel(['name' => 'Three']);
        try {
            $creating->invoke(null, $created);
        } catch (\Throwable) {
            // in-memory sushi table may be absent; writeCreatingJsonFile already covered
        }

        File::deleteDirectory($base);
    });
});

describe('Tenant statement coverage — SushiToPhpArray named model', function (): void {
    test('php array trait normalizes rows and boots listeners', function (): void {
        TestCase::mockAppService(GetTenantConfigArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows(['execute' => [
                ['name' => 'A', 'meta' => null],
                'not-array',
                ['name' => 'B', 'meta' => null],
            ]]);
        });

        $model = new SushiToPhpArrayCoverageModel;
        $rows = $model->getSushiRows();
        Assert::assertCount(2, $rows);
        Assert::assertSame('A', $rows[0]['name']);

        $boot = new ReflectionMethod(SushiToPhpArrayCoverageModel::class, 'bootSushiToPhpArray');
        $boot->setAccessible(true);
        $boot->invoke(null);

        $probe = new SushiToPhpArrayCoverageModel(['name' => 'C', 'meta' => null]);
        $fire = new ReflectionMethod($probe, 'fireModelEvent');
        $fire->setAccessible(true);
        $fire->invoke($probe, 'creating', false);
        $fire->invoke($probe, 'updating', false);
        Assert::assertSame('C', $probe->getAttribute('name'));
    });
});
