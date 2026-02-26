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
            // Doctor permissions
            'moderate_doctors' => 'Può moderare le registrazioni dei medici',
            'view_doctors' => 'Può visualizzare i medici',
            'create_doctors' => 'Può creare medici',
            'edit_doctors' => 'Può modificare i medici',
            'delete_doctors' => 'Può eliminare i medici',

            // Authentication Log permissions
            'authentication-log.view.any' => 'Può visualizzare tutti gli accessi di autenticazione',
            'authentication-log.view' => 'Può visualizzare i propri accessi di autenticazione',
            'authentication-log.create' => 'Può creare accessi di autenticazione',
            'authentication-log.update' => 'Può aggiornare accessi di autenticazione',
            'authentication-log.delete' => 'Può eliminare accessi di autenticazione',
            'authentication-log.restore' => 'Può ripristinare accessi di autenticazione eliminati',
            'authentication-log.force-delete' => 'Può eliminare permanentemente accessi di autenticazione',

            // OAuth Access Token permissions
            'oauth-access-token.view.any' => 'Può visualizzare tutti i token di accesso OAuth',
            'oauth-access-token.view' => 'Può visualizzare i propri token di accesso OAuth',
            'oauth-access-token.create' => 'Può creare token di accesso OAuth',
            'oauth-access-token.update' => 'Può aggiornare token di accesso OAuth',
            'oauth-access-token.delete' => 'Può eliminare token di accesso OAuth',
            'oauth-access-token.restore' => 'Può ripristinare token di accesso OAuth eliminati',
            'oauth-access-token.force-delete' => 'Può eliminare permanentemente token di accesso OAuth',

            // OAuth Refresh Token permissions
            'oauth-refresh-token.view.any' => 'Può visualizzare tutti i token di refresh OAuth',
            'oauth-refresh-token.view' => 'Può visualizzare i propri token di refresh OAuth',
            'oauth-refresh-token.create' => 'Può creare token di refresh OAuth',
            'oauth-refresh-token.update' => 'Può aggiornare token di refresh OAuth',
            'oauth-refresh-token.delete' => 'Può eliminare token di refresh OAuth',
            'oauth-refresh-token.restore' => 'Può ripristinare token di refresh OAuth eliminati',
            'oauth-refresh-token.force-delete' => 'Può eliminare permanentemente token di refresh OAuth',

            // OAuth Auth Code permissions
            'oauth-auth-code.view.any' => 'Può visualizzare tutti i codici di autorizzazione OAuth',
            'oauth-auth-code.view' => 'Può visualizzare i propri codici di autorizzazione OAuth',
            'oauth-auth-code.create' => 'Può creare codici di autorizzazione OAuth',
            'oauth-auth-code.update' => 'Può aggiornare codici di autorizzazione OAuth',
            'oauth-auth-code.delete' => 'Può eliminare codici di autorizzazione OAuth',
            'oauth-auth-code.restore' => 'Può ripristinare codici di autorizzazione OAuth eliminati',
            'oauth-auth-code.force-delete' => 'Può eliminare permanentemente codici di autorizzazione OAuth',
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
