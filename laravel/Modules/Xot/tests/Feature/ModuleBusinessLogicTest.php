<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Models\Module;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);
uses(DatabaseTransactions::class);

/**
 * Create a Module via factory (typed for PHPStan).
 *
 * @param  array<string, mixed>  $attributes
 */
function createModule(array $attributes = []): Module
{
    /** @var \Illuminate\Database\Eloquent\Factories\Factory<Module> $factory */
    $factory = Module::factory();
    /** @var array<string, mixed> $attributes */
    $module = $factory->create($attributes);
    assert($module instanceof Module);

    return $module;
}

it('can create module', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $moduleData = [
        'name' => 'TestModule',
        'slug' => 'test-module',
        'version' => '1.0.0',
        'description' => 'Test module for testing',
        'enabled' => true,
    ];

    // Act
    /** @var Module $module */
    $module = Module::create($moduleData);

    // Assert
    /** @phpstan-ignore-next-line method.protected (Laravel TestCase trait provides public assertDatabaseHas) */
    $this->assertDatabaseHas('modules', [
        'id' => $module->id,
        'name' => 'TestModule',
        'slug' => 'test-module',
        'version' => '1.0.0',
        'enabled' => true,
    ]);

    $this->assertEquals('TestModule', $module->name);
    $this->assertEquals('test-module', $module->slug);
    $this->assertEquals('1.0.0', $module->version);
    $this->assertTrue($module->enabled);
});

it('can enable and disable module', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $module = createModule(['enabled' => false]);

    // Act - Enable module
    $module->update(['enabled' => true]);

    // Assert
    /** @var Module $freshModule */
    $freshModule = $module->fresh();
    $this->assertTrue($freshModule->enabled);

    // Act - Disable module
    $module->update(['enabled' => false]);

    // Assert
    /** @var Module $freshModule2 */
    $freshModule2 = $module->fresh();
    $this->assertFalse($freshModule2->enabled);
});

it('can update module version', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $module = createModule(['version' => '1.0.0']);

    // Act
    $module->update(['version' => '2.0.0']);

    // Assert
    /** @var Module $freshModule */
    $freshModule = $module->fresh();
    $this->assertEquals('2.0.0', $freshModule->version);
    /** @phpstan-ignore-next-line method.protected */
    $this->assertDatabaseHas('modules', [
        'id' => $module->id,
        'version' => '2.0.0',
    ]);
});

it('can manage module dependencies', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $module = createModule([
        'dependencies' => ['user', 'auth'],
    ]);

    // Act
    $dependencies = $module->dependencies;

    // Assert
    $this->assertIsArray($dependencies);
    $this->assertContains('user', $dependencies);
    $this->assertContains('auth', $dependencies);
    $this->assertCount(2, $dependencies);
});

it('can validate module slug uniqueness', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    createModule(['slug' => 'unique-module']);

    // Act & Assert - Try to create module with same slug
    /** @phpstan-ignore-next-line method.protected (Laravel TestCase provides expectException) */
    $this->expectException(QueryException::class);
    \Modules\Xot\Models\Module::create([
        'name' => 'Another Module',
        'slug' => 'unique-module', // Same slug
        'version' => '1.0.0',
        'enabled' => true,
    ]);
});

it('can manage module configuration', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $config = [
        'setting1' => 'value1',
        'setting2' => 'value2',
        'nested' => [
            'key' => 'value',
        ],
    ];

    $module = createModule(['config' => $config]);

    // Act
    $moduleConfig = $module->config;

    // Assert
    $this->assertIsArray($moduleConfig);
    $this->assertEquals('value1', $moduleConfig['setting1']);
    $this->assertEquals('value2', $moduleConfig['setting2']);
    /** @var array<string, mixed> $moduleConfig */
    $nested = $moduleConfig['nested'] ?? [];
    $this->assertEquals('value', is_array($nested) ? ($nested['key'] ?? null) : null);
});

it('can check module status', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $enabledModule = createModule(['enabled' => true]);
    $disabledModule = createModule(['enabled' => false]);

    // Act & Assert
    $this->assertTrue($enabledModule->isEnabled());
    $this->assertFalse($disabledModule->isEnabled());
    $this->assertFalse($enabledModule->isDisabled());
    $this->assertTrue($disabledModule->isDisabled());
});

it('can manage module metadata', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $metadata = [
        'author' => 'Test Author',
        'website' => 'https://example.com',
        'license' => 'MIT',
        'tags' => ['test', 'example'],
    ];

    $module = createModule(['metadata' => $metadata]);

    // Act
    $moduleMetadata = $module->metadata;

    // Assert
    $this->assertIsArray($moduleMetadata);
    $this->assertEquals('Test Author', $moduleMetadata['author']);
    $this->assertEquals('https://example.com', $moduleMetadata['website']);
    $this->assertEquals('MIT', $moduleMetadata['license']);
    /** @var array<int, string> $tags */
    $tags = $moduleMetadata['tags'];
    $this->assertContains('test', $tags);
    $this->assertContains('example', $tags);
});

it('can validate module version format', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $validVersions = ['1.0.0', '2.1.3', '10.5.2', '0.1.0'];

    foreach ($validVersions as $version) {
        // Act
        $module = createModule(['version' => $version]);

        // Assert
        /** @var Module $freshModule */
        $freshModule = $module->fresh();
        $this->assertEquals($version, $freshModule->version);
        /** @phpstan-ignore-next-line method.protected */
        $this->assertDatabaseHas('modules', [
            'id' => $module->id,
            'version' => $version,
        ]);
    }
});

it('can manage module installation date', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $installationDate = now()->subDays(30);
    $module = createModule([
        'installed_at' => $installationDate,
    ]);

    // Act
    $moduleInstalledAt = $module->installed_at;

    // Assert
    $this->assertEquals($installationDate, $moduleInstalledAt);
    /** @phpstan-ignore-next-line method.protected */
    $this->assertDatabaseHas('modules', [
        'id' => $module->id,
        'installed_at' => $installationDate,
    ]);
});

it('can manage module update history', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
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

    $module = createModule(['update_history' => $updateHistory]);

    // Act
    $moduleUpdateHistory = $module->update_history;

    // Assert
    $this->assertIsArray($moduleUpdateHistory);
    $this->assertCount(2, $moduleUpdateHistory);
    /** @var array<string, mixed> $first */
    $first = $moduleUpdateHistory[0];
    /** @var array<string, mixed> $second */
    $second = $moduleUpdateHistory[1];
    $this->assertEquals('1.0.0', $first['version']);
    $this->assertEquals('Initial release', $first['changes']);
    $this->assertEquals('1.1.0', $second['version']);
    $this->assertEquals('Bug fixes and improvements', $second['changes']);
});

it('can check module compatibility', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $module = createModule([
        'laravel_version' => '^10.0',
        'php_version' => '^8.1',
    ]);

    // Act
    $laravelVersion = $module->laravel_version;
    $phpVersion = $module->php_version;

    // Assert
    $this->assertEquals('^10.0', $laravelVersion);
    $this->assertEquals('^8.1', $phpVersion);
});

it('can manage module permissions', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $permissions = [
        'module.read',
        'module.write',
        'module.delete',
    ];

    $module = createModule(['permissions' => $permissions]);

    // Act
    $modulePermissions = $module->permissions;

    // Assert
    $this->assertIsArray($modulePermissions);
    /** @var array<int, string> $perms */
    $perms = $modulePermissions;
    $this->assertContains('module.read', $perms);
    $this->assertContains('module.write', $perms);
    $this->assertContains('module.delete', $perms);
    $this->assertCount(3, $modulePermissions);
});

it('can manage module routes', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $routes = [
        'web' => ['prefix' => 'module', 'middleware' => ['web']],
        'api' => ['prefix' => 'api/module', 'middleware' => ['api']],
    ];

    $module = createModule(['routes' => $routes]);

    // Act
    $moduleRoutes = $module->routes;

    // Assert
    $this->assertIsArray($moduleRoutes);
    $this->assertArrayHasKey('web', $moduleRoutes);
    $this->assertArrayHasKey('api', $moduleRoutes);
    /** @var array<string, array<string, mixed>> $moduleRoutes */
    $this->assertEquals('module', $moduleRoutes['web']['prefix'] ?? null);
    $this->assertEquals('api/module', $moduleRoutes['api']['prefix'] ?? null);
});

it('can manage module assets', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $assets = [
        'css' => ['app.css', 'vendor.css'],
        'js' => ['app.js', 'vendor.js'],
        'images' => ['logo.png', 'icon.svg'],
    ];

    $module = createModule(['assets' => $assets]);

    // Act
    $moduleAssets = $module->assets;

    // Assert
    $this->assertIsArray($moduleAssets);
    $this->assertArrayHasKey('css', $moduleAssets);
    $this->assertArrayHasKey('js', $moduleAssets);
    $this->assertArrayHasKey('images', $moduleAssets);
    /** @var array<string, array<int, string>> $moduleAssets */
    $this->assertContains('app.css', $moduleAssets['css']);
    $this->assertContains('app.js', $moduleAssets['js']);
    $this->assertContains('logo.png', $moduleAssets['images']);
});

it('can manage module settings', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $settings = [
        'debug' => false,
        'cache' => true,
        'timeout' => 30,
        'features' => ['feature1', 'feature2'],
    ];

    $module = createModule(['settings' => $settings]);

    // Act
    $moduleSettings = $module->settings;

    // Assert
    $this->assertIsArray($moduleSettings);
    $this->assertFalse($moduleSettings['debug']);
    $this->assertTrue($moduleSettings['cache']);
    $this->assertEquals(30, $moduleSettings['timeout']);
    /** @var array<int, string> $features */
    $features = $moduleSettings['features'];
    $this->assertContains('feature1', $features);
    $this->assertContains('feature2', $features);
});

it('can validate module required fields', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $requiredFields = ['name', 'slug', 'version'];

    foreach ($requiredFields as $field) {
        $moduleData = [
            'name' => 'Test Module',
            'slug' => 'test-module',
            'version' => '1.0.0',
            'enabled' => true,
        ];

        // Remove required field
        unset($moduleData[$field]);

        // Act & Assert
        try {
            /** @var Module $created */
            $created = Module::create($moduleData);
            $this->fail("Expected QueryException for missing field: $field");
        } catch (QueryException $e) {
            $this->assertTrue(true);
        }
    }
});

it('can manage module activation workflow', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $module = createModule([
        'enabled' => false,
        'activation_date' => null,
    ]);

    // Act - Activate module
    $module->update([
        'enabled' => true,
        'activation_date' => now(),
    ]);

    // Assert
    /** @var Module $freshModule */
    $freshModule = $module->fresh();
    $this->assertTrue($freshModule->enabled);
    $this->assertNotNull($freshModule->activation_date);

    // Act - Deactivate module
    $module->update([
        'enabled' => false,
        'deactivation_date' => now(),
    ]);

    // Assert
    /** @var Module $freshModule2 */
    $freshModule2 = $module->fresh();
    $this->assertFalse($freshModule2->enabled);
    $this->assertNotNull($freshModule2->deactivation_date);
});

it('can track module usage statistics', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $usageStats = [
        'total_requests' => 1000,
        'unique_users' => 150,
        'last_used' => now()->subHours(2),
        'popular_features' => ['feature1', 'feature2'],
    ];

    $module = createModule(['usage_statistics' => $usageStats]);

    // Act
    $usage_statistics = $module->usage_statistics;

    // Assert
    $this->assertIsArray($usage_statistics);
    $this->assertEquals(1000, $usage_statistics['total_requests']);
    $this->assertEquals(150, $usage_statistics['unique_users']);
    $this->assertNotNull($usage_statistics['last_used']);
    /** @var array<int, string> $popularFeatures */
    $popularFeatures = $usage_statistics['popular_features'];
    $this->assertContains('feature1', $popularFeatures);
    $this->assertContains('feature2', $popularFeatures);
});

it('can manage module error logging', function () {
    /** @var \Modules\Xot\Tests\TestCase $this */
    // Arrange
    $errorLog = [
        [
            'level' => 'error',
            'message' => 'Test error message',
            'timestamp' => now()->subMinutes(5),
            'context' => ['file' => 'test.php', 'line' => 42],
        ],
    ];

    $module = createModule(['error_log' => $errorLog]);

    // Act
    $module_error_log = $module->error_log;

    // Assert
    $this->assertIsArray($module_error_log);
    $this->assertCount(1, $module_error_log);
    /** @var array<int, array<string, mixed>> $module_error_log */
    $firstEntry = $module_error_log[0];
    $this->assertEquals('error', $firstEntry['level'] ?? null);
    $this->assertEquals('Test error message', $firstEntry['message'] ?? null);
    /** @var array<string, mixed> $context */
    $context = $firstEntry['context'] ?? [];
    $this->assertEquals('test.php', isset($context['file']) ? (string) $context['file'] : null);
    $this->assertEquals(42, isset($context['line']) ? (int) $context['line'] : null);
});
