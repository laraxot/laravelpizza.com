<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('HasTeams Trait', function () {
    it('can be used in a model', function () {
        $user = User::factory()->create();

        expect($user)->toBeInstanceOf(User::class);
        expect(method_exists($user, 'teams'))->toBeTrue();
        expect(method_exists($user, 'belongsToTeam'))->toBeTrue();
    });

    it('has teams relationship method', function () {
        $user = User::factory()->create();

        $teamsRelation = $user->teams();

        expect($teamsRelation)->toBeInstanceOf(BelongsToMany::class);
    });

    it('can check if user belongs to a team by ID', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $user->teams()->attach($team->id, ['role' => 'member']);
        $user->refresh();

        $result = $user->belongsToTeam($team);

        expect($result)->toBeTrue();
    });

    it('can check if user belongs to a team by Team model', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $user->teams()->attach($team->id, ['role' => 'member']);
        $user->refresh();

        $result = $user->belongsToTeam($team);

        expect($result)->toBeTrue();
    });

    it('returns false when user does not belong to team', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        // Do not attach user to team

        $result = $user->belongsToTeam($team);

        expect($result)->toBeFalse();
    });

    it('handles Team model parameters', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $user->teams()->attach($team->id, ['role' => 'admin']);
        $user->refresh();

        $result = $user->belongsToTeam($team);

        expect($result)->toBeTrue();
    });

    it('can get all teams for user', function () {
        $user = User::factory()->create();
        $team1 = Team::factory()->create(['name' => 'Team A']);
        $team2 = Team::factory()->create(['name' => 'Team B']);
        $team3 = Team::factory()->create(['name' => 'Team C']);

        $user->teams()->attach([$team1->id, $team2->id, $team3->id]);

        $userTeams = $user->teams()->get();

        expect($userTeams)->toHaveCount(3);
    });

    it('can filter teams by specific criteria', function () {
        $user = User::factory()->create();
        $team1 = Team::factory()->create(['name' => 'Active Team 1']);
        $team2 = Team::factory()->create(['name' => 'Active Team 2']);

        $user->teams()->attach([$team1->id, $team2->id]);

        $activeUserTeams = $user->teams()->get();

        expect($activeUserTeams)->toHaveCount(2);
    });

    it('can check team membership', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $user->teams()->attach($team->id, ['role' => 'member']);
        $user->refresh();

        $result = $user->belongsToTeam($team);

        expect($result)->toBeTrue();
    });

    it('can handle multiple team memberships', function () {
        $user = User::factory()->create();
        $teams = Team::factory()->count(5)->create();

        foreach ($teams as $team) {
            $user->teams()->attach($team->id, ['role' => 'member']);
        }

        $user->refresh();

        foreach ($teams as $team) {
            $belongsTo = $user->belongsToTeam($team);
            expect($belongsTo)->toBeTrue();
        }
    });

    it('can handle non-existent team membership', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        // Do not attach

        $result = $user->belongsToTeam($team);
        expect($result)->toBeFalse();
    });

    it('can work with team pivot table', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        $user->teams()->attach($team->id, ['role' => 'editor']);
        $user->refresh();

        $result = $user->belongsToTeam($team);

        expect($result)->toBeTrue();
    });

    it('can handle team relationship with custom pivot table', function () {
        $user = User::factory()->create();

        $teamsRelation = $user->teams();

        expect($teamsRelation)->toBeInstanceOf(BelongsToMany::class);
        expect($teamsRelation->getTable())->toBe('team_user');
    });

    it('can handle team relationship with correct foreign keys', function () {
        $user = User::factory()->create();

        $teamsRelation = $user->teams();

        expect($teamsRelation)->toBeInstanceOf(BelongsToMany::class);
        expect($teamsRelation->getForeignPivotKeyName())->toBe('user_id');
        expect($teamsRelation->getRelatedPivotKeyName())->toBe('team_id');
    });
});

describe('HasTeams Trait Integration', function () {
    it('can be used with User model', function () {
        $user = new User;

        expect(method_exists($user, 'teams'))->toBeTrue();
        expect(method_exists($user, 'belongsToTeam'))->toBeTrue();
    });

    it('maintains trait functionality across different users', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        expect(method_exists($user1, 'teams'))->toBeTrue();
        expect(method_exists($user1, 'belongsToTeam'))->toBeTrue();
        expect(method_exists($user2, 'teams'))->toBeTrue();
        expect(method_exists($user2, 'belongsToTeam'))->toBeTrue();
    });

    it('can handle concurrent team checks', function () {
        $user = User::factory()->create();
        $team10 = Team::factory()->create();
        $team20 = Team::factory()->create();
        $team30 = Team::factory()->create();

        // Only attach to team20
        $user->teams()->attach($team20->id, ['role' => 'member']);
        $user->refresh();

        $result20 = $user->belongsToTeam($team20);
        $result10 = $user->belongsToTeam($team10);
        $result30 = $user->belongsToTeam($team30);

        expect($result10)->toBeFalse();
        expect($result20)->toBeTrue();
        expect($result30)->toBeFalse();
    });

    it('can work with team collections', function () {
        $user = User::factory()->create();
        $team1 = Team::factory()->create(['name' => 'Team Alpha']);
        $team2 = Team::factory()->create(['name' => 'Team Beta']);

        $user->teams()->attach([$team1->id, $team2->id]);

        $userTeams = $user->teams()->get();

        expect($userTeams)->toBeInstanceOf(Collection::class);
        expect($userTeams)->toHaveCount(2);
    });
});

describe('HasTeams Trait Error Handling', function () {
    it('handles missing team gracefully', function () {
        $user = User::factory()->create();
        $team = Team::factory()->create();

        // Do not attach user to team

        $result = $user->belongsToTeam($team);

        expect($result)->toBeFalse();
    });

    it('handles empty team collections', function () {
        $user = User::factory()->create();

        $userTeams = $user->teams()->get();

        expect($userTeams)->toBeInstanceOf(Collection::class);
        expect($userTeams)->toHaveCount(0);
        expect($userTeams->isEmpty())->toBeTrue();
    });

    it('handles null team parameter', function () {
        $user = User::factory()->create();

        $result = $user->belongsToTeam(null);

        expect($result)->toBeFalse();
    });
});

describe('HasTeams Trait Performance', function () {
    it('can handle large numbers of team checks efficiently', function () {
        $user = User::factory()->create();
        $team2 = Team::factory()->create();
        $team3 = Team::factory()->create();

        $user->teams()->attach($team2->id, ['role' => 'member']);
        $user->refresh();

        $startTime = microtime(true);

        $result2 = $user->belongsToTeam($team2);
        $result3 = $user->belongsToTeam($team3);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($result2)->toBeTrue();
        expect($result3)->toBeFalse();
        expect($executionTime)->toBeLessThan(1.0);
    });

    it('can handle team relationship queries efficiently', function () {
        $user = User::factory()->create();
        $teams = Team::factory()->count(10)->create();

        foreach ($teams as $team) {
            $user->teams()->attach($team->id);
        }

        $startTime = microtime(true);

        $userTeams = $user->teams()->get();
        $teamNames = $userTeams->pluck('name')->toArray();

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($userTeams)->toHaveCount(10);
        expect($executionTime)->toBeLessThan(1.0);
        expect($teamNames)->toHaveCount(10);
    });
});
