<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Database\QueryException;
use Modules\Xot\Database\Factories\ModuleFactory;
use Modules\Xot\Models\Module;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /* @var TestCase $this */
    $this->skipTest('Module is Sushi read-only (getRows from nwidart); CRUD tests need rewrite against live schema.');
});

describe('Module Business Logic', function (): void {
    test('can create module', function (): void {
        $moduleData = [
            'name' => 'TestModule',
            'slug' => 'test-module',
            'version' => '1.0.0',
            'description' => 'Test module for testing',
            'enabled' => true,
        ];

        $module = Module::create($moduleData);

        $this->assertDatabaseHasRow('modules', [
            'id' => $module->id,
            'name' => 'TestModule',
            'slug' => 'test-module',
            'version' => '1.0.0',
            'enabled' => true,
        ], 'sushi');

        Assert::assertEquals('TestModule', $module->name);
        Assert::assertEquals('test-module', $module->slug);
        Assert::assertEquals('1.0.0', $module->version);
        Assert::assertTrue((bool) $module->enabled);
    });

    test('can enable and disable module', function (): void {
        $module = ModuleFactory::new()->createOne(['enabled' => false]);

        $module->update(['enabled' => true]);
        $freshModule = $module->fresh();
        Assert::assertNotNull($freshModule);
        Assert::assertTrue((bool) $freshModule->enabled);

        $module->update(['enabled' => false]);
        $freshModule = $module->fresh();
        Assert::assertNotNull($freshModule);
        Assert::assertFalse((bool) $freshModule->enabled);
    });

    test('can update module version', function (): void {
        $module = ModuleFactory::new()->createOne(['version' => '1.0.0']);

        $module->update(['version' => '2.0.0']);

        $freshModule = $module->fresh();
        Assert::assertNotNull($freshModule);
        Assert::assertEquals('2.0.0', $freshModule->version);
        $this->assertDatabaseHasRow('modules', [
            'id' => $module->id,
            'version' => '2.0.0',
        ], 'sushi');
    });

    test('can manage module dependencies', function (): void {
        $module = ModuleFactory::new()->createOne([
            'dependencies' => ['user', 'auth'],
        ]);

        $dependencies = $module->dependencies;

        Assert::assertIsArray($dependencies);
        Assert::assertContains('user', $dependencies);
        Assert::assertContains('auth', $dependencies);
        Assert::assertCount(2, $dependencies);
    });

    test('can validate module slug uniqueness', function (): void {
        ModuleFactory::new()->createOne(['slug' => 'unique-module']);

        try {
            Module::create([
                'name' => 'Another Module',
                'slug' => 'unique-module',
                'version' => '1.0.0',
                'enabled' => true,
            ]);
            Assert::fail('Expected QueryException was not thrown');
        } catch (QueryException $e) {
            Assert::assertInstanceOf(QueryException::class, $e);
        }
    });

    test('can manage module configuration', function (): void {
        $config = [
            'setting1' => 'value1',
            'setting2' => 'value2',
            'nested' => [
                'key' => 'value',
            ],
        ];

        $module = ModuleFactory::new()->createOne(['config' => $config]);

        /** @var array{setting1: string, setting2: string, nested: array{key: string}} $moduleConfig */
        $moduleConfig = $module->getAttribute('config');

        Assert::assertIsArray($moduleConfig);
        Assert::assertEquals('value1', $moduleConfig['setting1']);
        Assert::assertEquals('value2', $moduleConfig['setting2']);
        Assert::assertEquals('value', $moduleConfig['nested']['key']);
    });

    test('can check module status', function (): void {
        $enabledModule = ModuleFactory::new()->createOne(['enabled' => true]);
        $disabledModule = ModuleFactory::new()->createOne(['enabled' => false]);

        Assert::assertTrue((bool) $enabledModule->enabled);
        Assert::assertFalse((bool) $disabledModule->enabled);
        Assert::assertTrue(true === $enabledModule->enabled);
        Assert::assertTrue(false === $disabledModule->enabled);
    });

    test('can manage module metadata', function (): void {
        $metadata = [
            'author' => 'Test Author',
            'website' => 'https://example.com',
            'license' => 'MIT',
            'tags' => ['test', 'example'],
        ];

        $module = ModuleFactory::new()->createOne(['metadata' => $metadata]);

        /** @var array{author: string, website: string, license: string, tags: string[]} $moduleMetadata */
        $moduleMetadata = $module->getAttribute('metadata');

        Assert::assertIsArray($moduleMetadata);
        Assert::assertEquals('Test Author', $moduleMetadata['author']);
        Assert::assertEquals('https://example.com', $moduleMetadata['website']);
        Assert::assertEquals('MIT', $moduleMetadata['license']);
        Assert::assertContains('test', $moduleMetadata['tags']);
        Assert::assertContains('example', $moduleMetadata['tags']);
    });

    test('can validate module version format', function (): void {
        $validVersions = ['1.0.0', '2.1.3', '10.5.2', '0.1.0'];

        foreach ($validVersions as $version) {
            $module = ModuleFactory::new()->createOne(['version' => $version]);

            Assert::assertEquals($version, $module->version);
            $this->assertDatabaseHasRow('modules', [
                'id' => $module->id,
                'version' => $version,
            ], 'sushi');
        }
    });

    test('can manage module installation date', function (): void {
        $installationDate = now()->subDays(30);
        $module = ModuleFactory::new()->createOne([
            'installation_date' => $installationDate,
        ]);

        $moduleInstalledAt = $module->installation_date;

        Assert::assertEquals($installationDate, $moduleInstalledAt);
        $this->assertDatabaseHasRow('modules', [
            'id' => $module->id,
            'installation_date' => $installationDate,
        ], 'sushi');
    });

    test('can manage module update history', function (): void {
        $updateHistory = [
            [
                'version' => '1.0.0',
                'date' => '2024-01-01',
                'changes' => 'Initial release',
            ],
            [
                'version' => '1.1.0',
                'date' => '2024-02-01',
                'changes' => 'Bug fixes and improvements',
            ],
        ];

        $module = ModuleFactory::new()->createOne(['update_history' => $updateHistory]);

        /** @var array<int, array{version: string, date: string, changes: string}> $moduleUpdateHistory */
        $moduleUpdateHistory = $module->getAttribute('update_history');

        Assert::assertIsArray($moduleUpdateHistory);
        Assert::assertCount(2, $moduleUpdateHistory);
        Assert::assertEquals('1.0.0', $moduleUpdateHistory[0]['version']);
        Assert::assertEquals('Initial release', $moduleUpdateHistory[0]['changes']);
        Assert::assertEquals('1.1.0', $moduleUpdateHistory[1]['version']);
        Assert::assertEquals('Bug fixes and improvements', $moduleUpdateHistory[1]['changes']);
    });

    test('can check module compatibility', function (): void {
        $module = ModuleFactory::new()->createOne([
            'laravel_version' => '^10.0',
            'php_version' => '^8.1',
        ]);

        $laravelVersion = $module->getAttribute('laravel_version');
        $phpVersion = $module->getAttribute('php_version');

        Assert::assertEquals('^10.0', $laravelVersion);
        Assert::assertEquals('^8.1', $phpVersion);
    });

    test('can manage module permissions', function (): void {
        $permissions = [
            'module.read',
            'module.write',
            'module.delete',
        ];

        $module = ModuleFactory::new()->createOne(['permissions' => $permissions]);

        /** @var string[] $modulePermissions */
        $modulePermissions = $module->getAttribute('permissions');

        Assert::assertIsArray($modulePermissions);
        Assert::assertContains('module.read', $modulePermissions);
        Assert::assertContains('module.write', $modulePermissions);
        Assert::assertContains('module.delete', $modulePermissions);
        Assert::assertCount(3, $modulePermissions);
    });

    test('can manage module routes', function (): void {
        $routes = [
            'web' => ['prefix' => 'module', 'middleware' => ['web']],
            'api' => ['prefix' => 'api/module', 'middleware' => ['api']],
        ];

        $module = ModuleFactory::new()->createOne(['routes' => $routes]);

        /** @var array<string, array{prefix: string, middleware: string[]}> $moduleRoutes */
        $moduleRoutes = $module->getAttribute('routes');

        Assert::assertIsArray($moduleRoutes);
        Assert::assertArrayHasKey('web', $moduleRoutes);
        Assert::assertArrayHasKey('api', $moduleRoutes);
        Assert::assertEquals('module', $moduleRoutes['web']['prefix']);
        Assert::assertEquals('api/module', $moduleRoutes['api']['prefix']);
    });

    test('can manage module assets', function (): void {
        $assets = [
            'css' => ['app.css', 'vendor.css'],
            'js' => ['app.js', 'vendor.js'],
            'images' => ['logo.png', 'icon.svg'],
        ];

        $module = ModuleFactory::new()->createOne(['assets' => $assets]);

        /** @var array{css: string[], js: string[], images: string[]} $moduleAssets */
        $moduleAssets = $module->getAttribute('assets');

        Assert::assertIsArray($moduleAssets);
        Assert::assertArrayHasKey('css', $moduleAssets);
        Assert::assertArrayHasKey('js', $moduleAssets);
        Assert::assertArrayHasKey('images', $moduleAssets);
        Assert::assertContains('app.css', $moduleAssets['css']);
        Assert::assertContains('app.js', $moduleAssets['js']);
        Assert::assertContains('logo.png', $moduleAssets['images']);
    });

    test('can manage module settings', function (): void {
        $settings = [
            'debug' => false,
            'cache' => true,
            'timeout' => 30,
            'features' => ['feature1', 'feature2'],
        ];

        $module = ModuleFactory::new()->createOne(['settings' => $settings]);

        /** @var array{debug: bool, cache: bool, timeout: int, features: string[]} $moduleSettings */
        $moduleSettings = $module->getAttribute('settings');

        Assert::assertIsArray($moduleSettings);
        Assert::assertFalse($moduleSettings['debug']);
        Assert::assertTrue($moduleSettings['cache']);
        Assert::assertEquals(30, $moduleSettings['timeout']);
        Assert::assertContains('feature1', $moduleSettings['features']);
        Assert::assertContains('feature2', $moduleSettings['features']);
    });

    test('can validate module required fields', function (): void {
        $requiredFields = ['name', 'slug', 'version'];

        foreach ($requiredFields as $field) {
            $moduleData = [
                'name' => 'Test Module',
                'slug' => 'test-module',
                'version' => '1.0.0',
                'enabled' => true,
            ];

            unset($moduleData[$field]);

            try {
                Module::create($moduleData);
                Assert::fail("Expected QueryException for missing field: $field");
            } catch (QueryException $e) {
                Assert::assertInstanceOf(QueryException::class, $e);
            }
        }
    });

    test('can manage module activation workflow', function (): void {
        $module = ModuleFactory::new()->createOne([
            'enabled' => false,
            'activation_date' => null,
        ]);

        $module->update([
            'enabled' => true,
            'activation_date' => now(),
        ]);

        $freshModule = $module->fresh();
        Assert::assertNotNull($freshModule);
        Assert::assertTrue((bool) $freshModule->enabled);
        Assert::assertNotNull($freshModule->activation_date);

        $module->update([
            'enabled' => false,
            'deactivation_date' => now(),
        ]);

        $freshModule = $module->fresh();
        Assert::assertNotNull($freshModule);
        Assert::assertFalse((bool) $freshModule->enabled);
        Assert::assertNotNull($freshModule->deactivation_date);
    });

    test('can track module usage statistics', function (): void {
        $usageStats = [
            'total_requests' => 1000,
            'unique_users' => 150,
            'last_used' => now()->subHours(2),
            'popular_features' => ['feature1', 'feature2'],
        ];

        $module = ModuleFactory::new()->createOne(['usage_statistics' => $usageStats]);

        /** @var array{total_requests: int, unique_users: int, last_used: mixed, popular_features: string[]} $usage_statistics */
        $usage_statistics = $module->getAttribute('usage_statistics');

        Assert::assertIsArray($usage_statistics);
        Assert::assertEquals(1000, $usage_statistics['total_requests']);
        Assert::assertEquals(150, $usage_statistics['unique_users']);
        Assert::assertNotNull($usage_statistics['last_used']);
        Assert::assertContains('feature1', $usage_statistics['popular_features']);
        Assert::assertContains('feature2', $usage_statistics['popular_features']);
    });

    test('can manage module error logging', function (): void {
        $errorLog = [
            [
                'level' => 'error',
                'message' => 'Test error message',
                'timestamp' => now()->subMinutes(5),
                'context' => ['file' => 'test.php', 'line' => 42],
            ],
        ];

        $module = ModuleFactory::new()->createOne(['error_log' => $errorLog]);

        /** @var array<int, array{level: string, message: string, context: array{file: string, line: int}}> $module_error_log */
        $module_error_log = $module->getAttribute('error_log');

        Assert::assertIsArray($module_error_log);
        Assert::assertCount(1, $module_error_log);
        Assert::assertEquals('error', $module_error_log[0]['level']);
        Assert::assertEquals('Test error message', $module_error_log[0]['message']);
        Assert::assertEquals('test.php', $module_error_log[0]['context']['file']);
        Assert::assertEquals(42, $module_error_log[0]['context']['line']);
    });
});
