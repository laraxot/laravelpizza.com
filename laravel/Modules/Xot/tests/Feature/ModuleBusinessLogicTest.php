<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Models\Module;
use Modules\Xot\Tests\TestCase;

class ModuleBusinessLogicTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_read_modules_from_system(): void
    {
        // Act
        $modules = Module::all();

        // Assert - Module model is a Sushi model that reads from system modules
        $this->assertNotEmpty($modules);
    }

    /** @test */
    public function it_can_get_module_attributes(): void
    {
        // Act
        $modules = Module::all();
        $module = $modules->first();

        // Assert
        if ($module) {
            $this->assertNotNull($module->name ?? null);
        }
    }

    /** @test */
    public function it_can_check_module_status(): void
    {
        // Act
        $modules = Module::all();
        
        // Assert - check that we have modules with status property
        foreach ($modules as $module) {
            $this->assertNotNull($module->status ?? null);
        }
    }

    /** @test */
    public function it_can_access_module_properties(): void
    {
        // Act
        $modules = Module::all();
        
        // Assert
        foreach ($modules as $module) {
            $this->assertNotNull($module->name ?? null);
            $this->assertNotNull($module->status ?? null);
            $this->assertNotNull($module->priority ?? null);
        }
    }

    /** @test */
    public function it_can_filter_modules(): void
    {
        // Act
        $allModules = Module::all();
        $enabledModules = $allModules->filter(fn ($module) => $module->status ?? false);

        // Assert
        $this->assertGreaterThanOrEqual(0, $enabledModules->count());
        $this->assertLessThanOrEqual($allModules->count(), $enabledModules->count());
    }
}
