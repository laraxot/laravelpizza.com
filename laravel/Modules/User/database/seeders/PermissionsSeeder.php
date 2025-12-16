<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crea i permessi
        $permissions = [
            'moderate_doctors' => 'Può moderare le registrazioni dei medici',
            'view_doctors' => 'Può visualizzare i medici',
            'create_doctors' => 'Può creare medici',
            'edit_doctors' => 'Può modificare i medici',
            'delete_doctors' => 'Può eliminare i medici',
        ];

        foreach ($permissions as $name => $description) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
                'description' => $description,
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
