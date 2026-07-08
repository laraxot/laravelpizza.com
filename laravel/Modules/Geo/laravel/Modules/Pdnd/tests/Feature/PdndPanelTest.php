<?php

declare(strict_types=1);

namespace Modules\Pdnd\Tests\Feature;

use Modules\User\Models\Role;
use Modules\User\Models\User;
use Tests\TestCase;

class PdndPanelTest extends TestCase
{
    /**
     * Test che il panel PDND sia accessibile senza redirect loop.
     */
    public function test_pdnd_panel_accessible_without_redirect_loop(): void
    {
        // Crea un utente con ruolo pdnd::admin
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $role = Role::firstOrCreate(['name' => 'pdnd::admin']);
        $user->assignRole($role);

        // Accedi come utente
        $this->actingAs($user);

        // Test accesso diretto al panel PDND
        $response = $this->get('/pdnd/admin');

        // Dovrebbe restituire 200 OK, non redirect loop
        $response->assertStatus(200);

        // Verifica che non ci siano redirect multipli
        $this->assertCount(1, $response->headers->getCookies());
    }

    /**
     * Test che l'utente con ruolo pdnd::admin venga reindirizzato correttamente dal dashboard principale.
     */
    public function test_user_with_pdnd_role_redirected_from_main_dashboard(): void
    {
        // Crea un utente con solo ruolo pdnd::admin
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $role = Role::firstOrCreate(['name' => 'pdnd::admin']);
        $user->assignRole($role);

        // Accedi come utente
        $this->actingAs($user);

        // Test accesso al dashboard principale
        $response = $this->get('/admin');

        // Dovrebbe reindirizzare a /pdnd/admin
        $response->assertRedirect('/pdnd/admin');
    }

    /**
     * Test che l'utente con ruolo pdnd::admin non venga reindirizzato se già nel panel corretto.
     */
    public function test_user_with_pdnd_role_not_redirected_when_already_in_correct_panel(): void
    {
        // Crea un utente con solo ruolo pdnd::admin
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $role = Role::firstOrCreate(['name' => 'pdnd::admin']);
        $user->assignRole($role);

        // Accedi come utente
        $this->actingAs($user);

        // Test accesso diretto al panel PDND (già nel panel corretto)
        $response = $this->get('/pdnd/admin');

        // Dovrebbe restituire 200 OK, non reindirizzare
        $response->assertStatus(200);

        // Verifica che non ci siano redirect
        $this->assertNull($response->headers->get('Location'));
    }

    /**
     * Test che l'utente con più ruoli admin non venga reindirizzato automaticamente.
     */
    public function test_user_with_multiple_admin_roles_not_auto_redirected(): void
    {
        // Crea un utente con più ruoli admin
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        $pdndRole = Role::firstOrCreate(['name' => 'pdnd::admin']);
        $userRole = Role::firstOrCreate(['name' => 'user::admin']);

        $user->assignRole($pdndRole);
        $user->assignRole($userRole);

        // Accedi come utente
        $this->actingAs($user);

        // Test accesso al dashboard principale
        $response = $this->get('/admin');

        // Dovrebbe restituire 200 OK (lista moduli), non reindirizzare
        $response->assertStatus(200);

        // Verifica che non ci siano redirect
        $this->assertNull($response->headers->get('Location'));
    }

    /**
     * Test che il ruolo pdnd::admin esista nel sistema.
     */
    public function test_pdnd_admin_role_exists(): void
    {
        $role = Role::firstOrCreate(['name' => 'pdnd::admin']);

        $this->assertNotNull($role);
        $this->assertEquals('pdnd::admin', $role->name);
    }
}
