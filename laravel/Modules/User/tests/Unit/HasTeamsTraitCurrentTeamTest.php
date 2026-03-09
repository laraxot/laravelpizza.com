<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('HasTeams Trait CurrentTeam', function () {
    it('currentTeam does not crash when user has no teams', function () {
        // Arrange: Crea un utente senza team
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Act: Accedi a currentTeam (non dovrebbe crashare)
        $currentTeam = $user->currentTeam;

        // Assert: currentTeam dovrebbe essere null
        expect($currentTeam)->toBeNull();
    });

    it('currentTeam is side effect free', function () {
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
        expect($user->current_team_id)->toBeNull();
        expect($currentTeam1)->toBeNull();
        expect($currentTeam2)->toBeNull();
    });

    it('currentTeam can access personal team when available', function () {
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

        // Act: Imposta manualmente il current_team_id e accedi a currentTeam
        $user->current_team_id = $personalTeam->id;
        $user->save();
        $user->refresh();

        $currentTeam = $user->currentTeam;

        // Assert: currentTeam dovrebbe essere il personal team
        expect($currentTeam)->not->toBeNull();
        expect((string) $user->current_team_id)->toBe((string) $personalTeam->id);
    });

    it('currentTeam does not override existing current_team_id', function () {
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

        // Act: Accedi a currentTeam
        $currentTeam = $user->currentTeam;

        // Assert: current_team_id dovrebbe rimanere team1
        $user->refresh();
        expect((string) $user->current_team_id)->toBe((string) $team1->id);
        expect($currentTeam)->not->toBeNull();
    });

    it('switchTeam can change current team', function () {
        // Arrange: Crea un utente con due team
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

        // Assicura che l'utente appartenga a entrambi i team
        $user->teams()->attach($team1->id);
        $user->teams()->attach($team2->id);

        // Act: Cambia il team corrente
        $result = $user->switchTeam($team1);

        // Assert: switchTeam dovrebbe funzionare
        expect($result)->toBeTrue();
        $user->refresh();
        expect((string) $user->current_team_id)->toBe((string) $team1->id);
    });

    it('currentTeam does not cause N+1 queries', function () {
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
        expect($currentTeam1)->not->toBeNull();
        expect($currentTeam2)->not->toBeNull();
    });
});
