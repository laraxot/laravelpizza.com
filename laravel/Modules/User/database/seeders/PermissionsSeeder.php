<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea i permessi
        $permissions = [
            // Doctor permissions
            'moderate_doctors' => 'Can moderate doctor registrations',
            'view_doctors' => 'Can view doctors',
            'create_doctors' => 'Can create doctors',
            'edit_doctors' => 'Can edit doctors',
            'delete_doctors' => 'Can delete doctors',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        // Assegna i permessi ai ruoli
        $role = Role::firstOrCreate([
            'name' => 'moderator',
            'guard_name' => 'web',
        ]);

        $role->givePermissionTo([
            'moderate_doctors',
            'view_doctors',
        ]);
    }
}
