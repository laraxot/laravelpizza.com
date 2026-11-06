<?php

declare(strict_types=1);

/**
 * Module Model Test Suite
 *
 * Scopo: verificare il contratto del registry Sushi dei moduli nwidart
 * (Modules\Xot\Models\Module): tabella, fillable, enable/disable, lookup per
 * name/slug, timestamp di BaseModel, factory tipizzata via HasXotFactory.
 */

namespace Modules\Xot\Tests\Unit\Models;

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Xot\Database\Factories\ModuleFactory;
use Modules\Xot\Models\Module;
use PHPUnit\Framework\Assert;
use Tests\TestCase;

class ModuleTest extends TestCase
{
    use WithFaker;

    protected Module $module;

    protected function setUp(): void
    {
        parent::setUp();
        $this->module = new Module;
    }

    /** @test Module has correct table name */
    public function it_has_correct_table_name(): void
    {
        Assert::assertSame('modules', $this->module->getTable());
    }

    /** @test Module has correct primary key */
    public function it_has_correct_primary_key(): void
    {
        Assert::assertSame('id', $this->module->getKeyName());
    }

    /** @test Module can be created with valid data */
    public function it_can_create_module_with_valid_data(): void
    {
        $data = [
            'name' => 'TestModule',
            'slug' => 'test-module',
            'description' => 'Test module description',
            'enabled' => true,
        ];

        $module = Module::create($data);

        Assert::assertInstanceOf(Module::class, $module);
        Assert::assertSame('TestModule', $module->name);
        Assert::assertSame('test-module', $module->slug);
        Assert::assertTrue((bool) $module->enabled);
    }

    /** @test Module can be updated */
    public function it_can_update_module_attributes(): void
    {
        $module = Module::create([
            'name' => 'OriginalName',
            'slug' => 'original-slug',
            'enabled' => true,
        ]);

        $module->update([
            'name' => 'UpdatedName',
            'enabled' => false,
        ]);

        $fresh = $module->fresh();
        Assert::assertInstanceOf(Module::class, $fresh);
        Assert::assertSame('UpdatedName', $fresh->name);
        Assert::assertFalse((bool) $fresh->enabled);
    }

    /** @test Module can be enabled */
    public function it_can_enable_module(): void
    {
        $module = Module::create([
            'name' => 'TestModule',
            'slug' => 'test-module',
            'enabled' => false,
        ]);

        $module->update(['enabled' => true]);

        $fresh = $module->fresh();
        Assert::assertInstanceOf(Module::class, $fresh);
        Assert::assertTrue((bool) $fresh->enabled);
    }

    /** @test Module can be disabled */
    public function it_can_disable_module(): void
    {
        $module = Module::create([
            'name' => 'TestModule',
            'slug' => 'test-module',
            'enabled' => true,
        ]);

        $module->update(['enabled' => false]);

        $fresh = $module->fresh();
        Assert::assertInstanceOf(Module::class, $fresh);
        Assert::assertFalse((bool) $fresh->enabled);
    }

    /** @test Module can be found by name */
    public function it_can_be_found_by_name(): void
    {
        Module::create([
            'name' => 'BlogModule',
            'slug' => 'blog',
        ]);

        $found = Module::where('name', 'BlogModule')->first();

        Assert::assertInstanceOf(Module::class, $found);
        Assert::assertSame('BlogModule', $found->name);
    }

    /** @test Module can be found by slug (nwidart alias surface) */
    public function it_can_be_found_by_slug(): void
    {
        Module::create([
            'name' => 'UserModule',
            'slug' => 'user-management',
        ]);

        $found = Module::where('slug', 'user-management')->first();

        Assert::assertInstanceOf(Module::class, $found);
        Assert::assertSame('UserModule', $found->name);
    }

    /** @test Can query only enabled modules */
    public function it_can_query_only_enabled_modules(): void
    {
        Module::create(['name' => 'Module1', 'slug' => 'mod1', 'enabled' => true]);
        Module::create(['name' => 'Module2', 'slug' => 'mod2', 'enabled' => false]);
        Module::create(['name' => 'Module3', 'slug' => 'mod3', 'enabled' => true]);

        $enabled = Module::where('enabled', true)->get();

        Assert::assertCount(2, $enabled);
    }

    /** @test Module uses timestamps */
    public function it_uses_timestamps(): void
    {
        Assert::assertTrue($this->module->usesTimestamps());
    }

    /** @test Module has created_at and updated_at timestamps */
    public function it_has_timestamps(): void
    {
        $module = Module::create([
            'name' => 'TestModule',
            'slug' => 'test',
        ]);

        Assert::assertNotNull($module->created_at);
        Assert::assertNotNull($module->updated_at);
    }

    /** @test Module can be deleted */
    public function it_can_be_deleted(): void
    {
        $module = Module::create([
            'name' => 'ToDelete',
            'slug' => 'to-delete',
        ]);

        $moduleId = $module->id;
        $module->delete();

        $this->assertDatabaseMissing('modules', ['id' => $moduleId]);
    }

    /** @test Module can be counted */
    public function it_can_be_counted(): void
    {
        // Factory concreta: HasXotFactory risolve a runtime e PHPStan vede mixed su ::factory()
        ModuleFactory::new()->count(5)->create();

        $count = Module::count();

        Assert::assertGreaterThanOrEqual(5, $count);
    }

    /** @test Module can be retrieved with limit */
    public function it_can_be_limited(): void
    {
        ModuleFactory::new()->count(10)->create();

        $limited = Module::limit(3)->get();

        Assert::assertCount(3, $limited);
    }
}
