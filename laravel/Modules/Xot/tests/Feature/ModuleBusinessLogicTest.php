<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Xot\Models\Module;
use Tests\TestCase;

class ModuleBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_module(): void
    {
        // Arrange
        $moduleData = [
            'name' => 'TestModule',
            'slug' => 'test-module',
            'version' => '1.0.0',
            'description' => 'Test module for testing',
            'enabled' => true,
        ];

        // Act
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
    }

    /** @test */
    public function it_can_enable_and_disable_module(): void
    {
        // Arrange
        $module = Module::factory()->create(['enabled' => false]);

        // Act - Enable module
        $module->update(['enabled' => true]);

        // Assert
        $this->assertTrue($module->fresh()->enabled);

        // Act - Disable module
        $module->update(['enabled' => false]);

        // Assert
        $this->assertFalse($module->fresh()->enabled);
    }

    /** @test */
    public function it_can_update_module_version(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_dependencies(): void
    {
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
    }

    /** @test */
    public function it_can_validate_module_slug_uniqueness(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_configuration(): void
    {
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
    }

    /** @test */
    public function it_can_check_module_status(): void
    {
        // Arrange
        $enabledModule = Module::factory()->create(['enabled' => true]);
        $disabledModule = Module::factory()->create(['enabled' => false]);

        // Act & Assert
        $this->assertTrue($enabledModule->isEnabled());
        $this->assertFalse($disabledModule->isEnabled());
        $this->assertFalse($enabledModule->isDisabled());
        $this->assertTrue($disabledModule->isDisabled());
    }

    /** @test */
    public function it_can_manage_module_metadata(): void
    {
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
    }

    /** @test */
    public function it_can_validate_module_version_format(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_installation_date(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_update_history(): void
    {
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
    }

    /** @test */
    public function it_can_check_module_compatibility(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_permissions(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_routes(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_assets(): void
    {
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
    }

    /** @test */
    public function it_can_manage_module_settings(): void
    {
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
    }

    /** @test */
    public function it_can_validate_module_required_fields(): void
    {
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
            $this->expectException(QueryException::class);

            Module::create($moduleData);
        }
    }

    /** @test */
    public function it_can_manage_module_activation_workflow(): void
    {
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
    }

    /** @test */
    public function it_can_track_module_usage_statistics(): void
    {
        // Arrange
        $usageStats = [
            'total_requests' => 1000,
            'unique_users' => 150,
            'last_used' => now()->subHours(2),
            'popular_features' => ['feature1', 'feature2'],
        ];

        $module = Module::factory()->create(['usage_statistics' => $usageStats]);

        // Act
        $moduleUsageStats = $module->usage_statistics;

        // Assert
        $this->assertIsArray($moduleUsageStats);
        $this->assertEquals(1000, $moduleUsageStats['total_requests']);
        $this->assertEquals(150, $moduleUsageStats['unique_users']);
        $this->assertNotNull($moduleUsageStats['last_used']);
        $this->assertContains('feature1', $moduleUsageStats['popular_features']);
        $this->assertContains('feature2', $moduleUsageStats['popular_features']);
    }

    /** @test */
    public function it_can_manage_module_error_logging(): void
    {
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
        $moduleErrorLog = $module->error_log;

        // Assert
        $this->assertIsArray($moduleErrorLog);
        $this->assertCount(1, $moduleErrorLog);
        $this->assertEquals('error', $moduleErrorLog[0]['level']);
        $this->assertEquals('Test error message', $moduleErrorLog[0]['message']);
        $this->assertEquals('test.php', $moduleErrorLog[0]['context']['file']);
        $this->assertEquals(42, $moduleErrorLog[0]['context']['line']);
    }
}
