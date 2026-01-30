<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Models\Module;
use Webmozart\Assert\Assert;

uses(DatabaseTransactions::class);

it('can create module', function () {
    // Arrange
    $moduleData = [
        'name' => 'TestModule',
        'slug' => 'test-module',
        'version' => '1.0.0',
        'description' => 'Test module for testing',
        'enabled' => true,
    ];

    // Act
    /** @var Modules\Xot\Models\Module $module */
    $module = Module::create($moduleData);

    // Assert
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
    // Arrange
    /** @var Modules\Xot\Models\Module $module */
    $module = Module::factory()->create(['enabled' => false]);

    // Act - Enable module
    $module->update(['enabled' => true]);

    // Assert
    $this->assertTrue($module->fresh()->enabled);

    // Act - Disable module
    $module->update(['enabled' => false]);

    // Assert
    $this->assertFalse($module->fresh()->enabled);
});

it('can update module version', function () {
    // Arrange
    $module = Module::factory()->create(['version' => '1.0.0']);

    // Act
    $module->update(['version' => '2.0.0']);

    // Assert
    $this->assertEquals('2.0.0', $module->fresh()->version);
    $this->assertDatabaseHas('modules', [
        'id' => $module->id,
        'version' => '2.0.0',
    ]);
});

it('can manage module dependencies', function () {
    // Arrange
    $module = Module::factory()->create([
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
    // Arrange
    Module::factory()->create(['slug' => 'unique-module']);

    // Act & Assert - Try to create module with same slug
    $this->expectException(QueryException::class);

    Module::create([
        'name' => 'Another Module',
        'slug' => 'unique-module', // Same slug
        'version' => '1.0.0',
        'enabled' => true,
    ]);
});

it('can manage module configuration', function () {
    // Arrange
    $config = [
        'setting1' => 'value1',
        'setting2' => 'value2',
        'nested' => [
            'key' => 'value',
        ],
    ];

    $module = Module::factory()->create(['config' => $config]);

    // Act
    $moduleConfig = $module->config;

    // Assert
    $this->assertIsArray($moduleConfig);
    $this->assertEquals('value1', $moduleConfig['setting1']);
    $this->assertEquals('value2', $moduleConfig['setting2']);
    $this->assertEquals('value', $moduleConfig['nested']['key']);
});

it('can check module status', function () {
    // Arrange
    $enabledModule = Module::factory()->create(['enabled' => true]);
    $disabledModule = Module::factory()->create(['enabled' => false]);

    // Act & Assert
    $this->assertTrue($enabledModule->isEnabled());
    $this->assertFalse($disabledModule->isEnabled());
    $this->assertFalse($enabledModule->isDisabled());
    $this->assertTrue($disabledModule->isDisabled());
});

it('can manage module metadata', function () {
    // Arrange
    $metadata = [
        'author' => 'Test Author',
        'website' => 'https://example.com',
        'license' => 'MIT',
        'tags' => ['test', 'example'],
    ];

    $module = Module::factory()->create(['metadata' => $metadata]);

    // Act
    $moduleMetadata = $module->metadata;

    // Assert
    $this->assertIsArray($moduleMetadata);
    $this->assertEquals('Test Author', $moduleMetadata['author']);
    $this->assertEquals('https://example.com', $moduleMetadata['website']);
    $this->assertEquals('MIT', $moduleMetadata['license']);
    $this->assertContains('test', $moduleMetadata['tags']);
    $this->assertContains('example', $moduleMetadata['tags']);
});

it('can validate module version format', function () {
    // Arrange
    $validVersions = ['1.0.0', '2.1.3', '10.5.2', '0.1.0'];

    foreach ($validVersions as $version) {
        // Act
        $module = Module::factory()->create(['version' => $version]);

        // Assert
        $this->assertEquals($version, $module->version);
        $this->assertDatabaseHas('modules', [
            'id' => $module->id,
            'version' => $version,
        ]);
    }
});

it('can manage module installation date', function () {
    // Arrange
    $installationDate = now()->subDays(30);
    $module = Module::factory()->create([
        'installed_at' => $installationDate,
    ]);

    // Act
    $moduleInstalledAt = $module->installed_at;

    // Assert
    $this->assertEquals($installationDate, $moduleInstalledAt);
    $this->assertDatabaseHas('modules', [
        'id' => $module->id,
        'installed_at' => $installationDate,
    ]);
});

it('can manage module update history', function () {
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

    $module = Module::factory()->create(['update_history' => $updateHistory]);

    // Act
    $moduleUpdateHistory = $module->update_history;

    // Assert
    $this->assertIsArray($moduleUpdateHistory);
    $this->assertCount(2, $moduleUpdateHistory);
    $this->assertEquals('1.0.0', $moduleUpdateHistory[0]['version']);
    $this->assertEquals('Initial release', $moduleUpdateHistory[0]['changes']);
    $this->assertEquals('1.1.0', $moduleUpdateHistory[1]['version']);
    $this->assertEquals('Bug fixes and improvements', $moduleUpdateHistory[1]['changes']);
});

it('can check module compatibility', function () {
    // Arrange
    $module = Module::factory()->create([
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
    // Arrange
    $permissions = [
        'module.read',
        'module.write',
        'module.delete',
    ];

    $module = Module::factory()->create(['permissions' => $permissions]);

    // Act
    $modulePermissions = $module->permissions;

    // Assert
    $this->assertIsArray($modulePermissions);
    $this->assertContains('module.read', $modulePermissions);
    $this->assertContains('module.write', $modulePermissions);
    $this->assertContains('module.delete', $modulePermissions);
    $this->assertCount(3, $modulePermissions);
});

it('can manage module routes', function () {
    // Arrange
    $routes = [
        'web' => ['prefix' => 'module', 'middleware' => ['web']],
        'api' => ['prefix' => 'api/module', 'middleware' => ['api']],
    ];

    $module = Module::factory()->create(['routes' => $routes]);

    // Act
    $moduleRoutes = $module->routes;

    // Assert
    $this->assertIsArray($moduleRoutes);
    $this->assertArrayHasKey('web', $moduleRoutes);
    $this->assertArrayHasKey('api', $moduleRoutes);
    $this->assertEquals('module', $moduleRoutes['web']['prefix']);
    $this->assertEquals('api/module', $moduleRoutes['api']['prefix']);
});

it('can manage module assets', function () {
    // Arrange
    $assets = [
        'css' => ['app.css', 'vendor.css'],
        'js' => ['app.js', 'vendor.js'],
        'images' => ['logo.png', 'icon.svg'],
    ];

    $module = Module::factory()->create(['assets' => $assets]);

    // Act
    $moduleAssets = $module->assets;

    // Assert
    $this->assertIsArray($moduleAssets);
    $this->assertArrayHasKey('css', $moduleAssets);
    $this->assertArrayHasKey('js', $moduleAssets);
    $this->assertArrayHasKey('images', $moduleAssets);
    $this->assertContains('app.css', $moduleAssets['css']);
    $this->assertContains('app.js', $moduleAssets['js']);
    $this->assertContains('logo.png', $moduleAssets['images']);
});

it('can manage module settings', function () {
    // Arrange
    $settings = [
        'debug' => false,
        'cache' => true,
        'timeout' => 30,
        'features' => ['feature1', 'feature2'],
    ];

    $module = Module::factory()->create(['settings' => $settings]);

    // Act
    $moduleSettings = $module->settings;

    // Assert
    $this->assertIsArray($moduleSettings);
    $this->assertFalse($moduleSettings['debug']);
    $this->assertTrue($moduleSettings['cache']);
    $this->assertEquals(30, $moduleSettings['timeout']);
    $this->assertContains('feature1', $moduleSettings['features']);
    $this->assertContains('feature2', $moduleSettings['features']);
});

it('can validate module required fields', function () {
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
            Module::create($moduleData);
            $this->fail("Expected QueryException for missing field: $field");
        } catch (QueryException $e) {
            $this->assertTrue(true);
        }
    }
});

it('can manage module activation workflow', function () {
    // Arrange
    $module = Module::factory()->create([
        'enabled' => false,
        'activation_date' => null,
    ]);

    // Act - Activate module
    $module->update([
        'enabled' => true,
        'activation_date' => now(),
    ]);

    // Assert
    $this->assertTrue($module->fresh()->enabled);
    $this->assertNotNull($module->fresh()->activation_date);

    // Act - Deactivate module
    $module->update([
        'enabled' => false,
        'deactivation_date' => now(),
    ]);

    // Assert
    $this->assertFalse($module->fresh()->enabled);
    $this->assertNotNull($module->fresh()->deactivation_date);
});

it('can track module usage statistics', function () {
    // Arrange
    $usageStats = [
        'total_requests' => 1000,
        'unique_users' => 150,
        'last_used' => now()->subHours(2),
        'popular_features' => ['feature1', 'feature2'],
    ];

    $module = Module::factory()->create(['usage_statistics' => $usageStats]);

    // Act
    $usage_statistics = $module->usage_statistics;

    // Assert
    $this->assertIsArray($usage_statistics);
    $this->assertEquals(1000, $usage_statistics['total_requests']);
    $this->assertEquals(150, $usage_statistics['unique_users']);
    $this->assertNotNull($usage_statistics['last_used']);
    $this->assertContains('feature1', $usage_statistics['popular_features']);
    $this->assertContains('feature2', $usage_statistics['popular_features']);
});

it('can manage module error logging', function () {
    // Arrange
    $errorLog = [
        [
            'level' => 'error',
            'message' => 'Test error message',
            'timestamp' => now()->subMinutes(5),
            'context' => ['file' => 'test.php', 'line' => 42],
        ],
    ];

    $module = Module::factory()->create(['error_log' => $errorLog]);

    // Act
    $module_error_log = $module->error_log;

    // Assert
    $this->assertIsArray($module_error_log);
    $this->assertCount(1, $module_error_log);
    
    // Type narrowing per array access sicuro
    $logEntry = $module_error_log[0] ?? null;
    $this->assertIsArray($logEntry);
    $this->assertEquals('error', $logEntry['level']);
    $this->assertEquals('Test error message', $logEntry['message']);
    
    $context = $logEntry['context'] ?? null;
    $this->assertIsArray($context);
    $this->assertEquals('test.php', $context['file']);
    $this->assertEquals(42, $context['line']);
});
