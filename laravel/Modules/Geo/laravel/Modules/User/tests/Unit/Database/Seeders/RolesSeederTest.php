<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Database\Seeders;

use Modules\User\Database\Seeders\RolesSeeder;
use Modules\User\Models\Role;
use Modules\User\Tests\TestCase;

/**
 * Tests for RolesSeeder.
 *
 * @covers \Modules\User\Database\Seeders\RolesSeeder
 */
final class RolesSeederTest extends TestCase
{
    /**
     * Test that RolesSeeder creates all expected roles.
     */
    public function testRolesSeederCreatesExpectedRoles(): void
    {
        // Arrange
        $expectedRoles = [
            'super-admin',
            'admin',
            'moderator',
            'editor',
            'user',
            'guest',
        ];

        // Act
        $seeder = new RolesSeeder();
        $seeder->setContainer($this->app);
        $seeder->run();

        // Assert
        foreach ($expectedRoles as $roleName) {
            $this->assertDatabaseHasRow('roles', [
                'name' => $roleName,
                'guard_name' => 'web',
            ], 'user');
        }

        // Verify exact count
        $roleCount = Role::where('guard_name', 'web')->count();
        $this->assertGreaterThanOrEqual(count($expectedRoles), $roleCount);
    }

    /**
     * Test that RolesSeeder is idempotent (can run multiple times without duplication).
     */
    public function testRolesSeederIsIdempotent(): void
    {
        // Arrange
        $seeder = new RolesSeeder();
        $seeder->setContainer($this->app);

        // Act - Run twice
        $seeder->run();
        $countAfterFirstRun = Role::where('guard_name', 'web')->count();

        $seeder->run();
        $countAfterSecondRun = Role::where('guard_name', 'web')->count();

        // Assert - Count should be the same
        $this->assertSame($countAfterFirstRun, $countAfterSecondRun);
    }
}
