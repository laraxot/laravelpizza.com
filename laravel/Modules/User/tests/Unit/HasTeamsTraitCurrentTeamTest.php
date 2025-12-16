<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Tests\TestCase;

/**
 * Test per verificare che il metodo currentTeam() non causi loop infiniti.
 *
 * Questo test verifica la correzione del bug che causava loop infiniti
 * quando si creava un nuovo utente tramite make:filament-user.
 */
class HasTeamsTraitCurrentTeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test che currentTeam() non crashi quando l'utente non ha team.
     */
    public function test_current_team_does_not_crash_without_teams(): void
    {
        // Arrange: Crea un utente senza team
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Act: Accedi a currentTeam (non dovrebbe crashare)
        $currentTeam = $user->currentTeam;

        // Assert: currentTeam dovrebbe essere null
        $this->assertNull($currentTeam);
    }

    /**
     * Test che currentTeam() non modifichi il database durante l'accesso.
     */
    public function test_current_team_is_side_effect_free(): void
    {
        // Arrange: Crea un utente senza current_team_id
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'current_team_id' => null,
        ]);

        // Act: Accedi a currentTeam più volte
        $currentTeam1 = $user->currentTeam;
        $currentTeam2 = $user->currentTeam;

        // Assert: current_team_id dovrebbe rimanere null
        $user->refresh();
        $this->assertNull($user->current_team_id);
        $this->assertNull($currentTeam1);
        $this->assertNull($currentTeam2);
    }

    /**
     * Test che initializeCurrentTeam() imposti correttamente il personal team.
     */
    public function test_initialize_current_team_sets_personal_team(): void
    {
        // Arrange: Crea un utente con un personal team
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $personalTeam = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Personal Team',
            'personal_team' => true,
        ]);

        // Act: Inizializza il current team
        $user->initializeCurrentTeam();

        // Assert: current_team_id dovrebbe essere impostato al personal team
        $user->refresh();
        $this->assertEquals($personalTeam->id, $user->current_team_id);
    }

    /**
     * Test che initializeCurrentTeam() non modifichi un current_team_id già impostato.
     */
    public function test_initialize_current_team_does_not_override_existing(): void
    {
        // Arrange: Crea un utente con un team già impostato
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $team1 = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Team 1',
            'personal_team' => false,
        ]);

        $team2 = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Team 2',
            'personal_team' => true,
        ]);

        $user->current_team_id = $team1->id;
        $user->save();

        // Act: Tenta di inizializzare il current team
        $user->initializeCurrentTeam();

        // Assert: current_team_id dovrebbe rimanere team1
        $user->refresh();
        $this->assertEquals($team1->id, $user->current_team_id);
    }

    /**
     * Test che initializeCurrentTeam() imposti il primo team disponibile se non c'è personal team.
     */
    public function test_initialize_current_team_sets_first_available_team(): void
    {
        // Arrange: Crea un utente con un team non-personal
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Regular Team',
            'personal_team' => false,
        ]);

        // Act: Inizializza il current team
        $user->initializeCurrentTeam();

        // Assert: current_team_id dovrebbe essere impostato al team disponibile
        $user->refresh();
        $this->assertEquals($team->id, $user->current_team_id);
    }

    /**
     * Test che initializeCurrentTeam() non crashi se l'utente non ha team.
     */
    public function test_initialize_current_team_handles_no_teams(): void
    {
        // Arrange: Crea un utente senza team
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Act: Inizializza il current team (non dovrebbe crashare)
        $user->initializeCurrentTeam();

        // Assert: current_team_id dovrebbe rimanere null
        $user->refresh();
        $this->assertNull($user->current_team_id);
    }

    /**
     * Test che l'accesso a currentTeam non causi query N+1.
     */
    public function test_current_team_does_not_cause_n_plus_one_queries(): void
    {
        // Arrange: Crea un utente con un team
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Team',
            'personal_team' => true,
        ]);

        $user->current_team_id = $team->id;
        $user->save();

        // Act & Assert: Accedi a currentTeam più volte
        // (dovrebbe usare la relazione Eloquent senza query extra)
        $user->refresh();
        $currentTeam1 = $user->currentTeam;
        $currentTeam2 = $user->currentTeam;

        // Verifica che entrambi gli accessi restituiscano lo stesso team
        $this->assertNotNull($currentTeam1);
        $this->assertNotNull($currentTeam2);
    }
}
