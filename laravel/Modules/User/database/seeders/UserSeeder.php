<?php

declare(strict_types=1);

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\Team;

/**
 * Seeder per il modulo User.
 *
 * Popola il database con dati di base per:
 * - Ruoli e permessi di sistema
 * - Team di default
 */
class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $command->info('👤 Inizializzazione seeding User...');

        // Disabilita i controlli di foreign key (solo per MySQL)
        if ('sqlite' !== DB::getDriverName()) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0);');
        }

        try {
            $this->seedSystemRolesAndPermissions();
            $this->seedSystemTeams();

            $command->info('✅ Seeding User completato con successo!');
        } finally {
            // Riabilita i controlli di foreign key (solo per MySQL)
            if ('sqlite' !== DB::getDriverName()) {
                DB::statement('SET FOREIGN_KEY_CHECKS=1);');
            }
        }
    }

    /**
     * Crea ruoli e permessi di sistema.
     */
    private function seedSystemRolesAndPermissions(): void
    {
        $command->info('🔐 Creazione ruoli e permessi di sistema...');

        // Permessi di sistema
        $systemPermissions = [
            // User management
            'manage users',
            'create users',
            'edit users',
            'delete users',
            'view users',
            'impersonate users',
            // Role management
            'manage roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view roles',
            // Permission management
            'manage permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'view permissions',
            // Team management
            'manage teams',
            'create teams',
            'edit teams',
            'delete teams',
            'view teams',
            'join teams',
            'leave teams',
            // System settings
            'manage system settings',
            'view system settings',
            'manage modules',
            'view system logs',
            'manage backups',
            // Analytics and reporting
            'view analytics',
            'export data',
            'generate reports',
        ];

        foreach ($systemPermissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Ruoli di sistema
        $superAdminRole = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $systemAdminRole = Role::firstOrCreate([
            'name' => 'system-admin',
            'guard_name' => 'web',
        ]);

        $moderatorRole = Role::firstOrCreate([
            'name' => 'moderator',
            'guard_name' => 'web',
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // Assegna permessi ai ruoli
        $superAdminRole->givePermissionTo(Permission::all());

        $systemAdminRole->givePermissionTo([
            'manage users',
            'create users',
            'edit users',
            'view users',
            'manage roles',
            'view roles',
            'manage teams',
            'view teams',
            'view system settings',
            'view analytics',
            'generate reports',
        ]);

        $moderatorRole->givePermissionTo([
            'view users',
            'edit users',
            'view roles',
            'view teams',
            'join teams',
            'leave teams',
            'view analytics',
        ]);

        $userRole->givePermissionTo([
            'view users',
            'view teams',
            'join teams',
            'leave teams',
        ]);

        $command->info('   ✓ Creati '.count($systemPermissions));
        $command->info('   ✓ Creati 4 ruoli di sistema (super-admin, system-admin, moderator, user));
    }

    /**
     * Crea team di sistema.
     */
    private function seedSystemTeams(): void
    {
        $command->info('👥 Creazione team di sistema...');

        $adminTeam = $this->createTeam('Amministratori');
        $devTeam = $this->createTeam('Sviluppatori');
        $supportTeam = $this->createTeam('Supporto Clienti');
        $marketingTeam = $this->createTeam('Marketing');
        $generalTeam = $this->createTeam('Team Generale');

        $command->info('   ✓ Creati 5 team di sistema');
    }

    private function createTeam(string $name): Team
    {
        $factory = \Modules\User\Database\Factories\TeamFactory::new();
        /** @var Team $team */
        $team = $factory->create([
            'name' => $name,
            'personal_team' => false,
        ]);

        return $team;
    }
}
