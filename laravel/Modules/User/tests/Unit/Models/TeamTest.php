<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models;

use Modules\User\Models\Team;
use Modules\User\Models\User;
use Tests\TestCase;

uses(\Modules\User\Tests\TestCase::class);

class TeamTest extends TestCase
{
    public function test_can_create_team_with_minimal_data(): void
    {
        $user = User::factory()->create();

        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Team',
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'user_id' => $user->id,
            'name' => 'Test Team',
        ]);
    }

    public function test_can_create_team_with_all_fields(): void
    {
        $user = User::factory()->create();

        $teamData = [
            'user_id' => $user->id,
            'name' => 'Full Team',
            'personal_team' => 0,
            'code' => 'TEAM001',
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'owner_id' => $user->id,
        ];

        $team = Team::factory()->create($teamData);

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'user_id' => $user->id,
            'name' => 'Full Team',
            'personal_team' => 0,
            'code' => 'TEAM001',
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'owner_id' => $user->id,
        ]);
    }

    public function test_team_delete_is_hard_delete(): void
    {
        // SoftDeletes e' commentato su Team: delete() rimuove la riga, non soft-delete.
        $user = User::factory()->create();
        $team = Team::factory()->create(['user_id' => $user->id]);
        $teamId = $team->id;

        $team->delete();

        $this->assertDatabaseMissing('teams', ['id' => $teamId]);
        static::assertNull(Team::find($teamId));
    }

    public function test_can_restore_soft_deleted_team(): void
    {
        $this->markTestSkipped('Team model does not use SoftDeletes (trait commentato).');
    }

    public function test_can_find_team_by_name(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Unique Team Name',
        ]);

        $foundTeam = Team::where('name', 'Unique Team Name')->first();

        static::assertNotNull($foundTeam);
        static::assertSame($team->id, $foundTeam->id);
    }

    public function test_can_find_team_by_code(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'code' => 'TEAM123',
        ]);

        $foundTeam = Team::where('code', 'TEAM123')->first();

        static::assertNotNull($foundTeam);
        static::assertSame($team->id, $foundTeam->id);
    }

    public function test_can_find_team_by_uuid(): void
    {
        $user = User::factory()->create();
        $uuid = '550e8400-e29b-41d4-a716-446655440000';
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'uuid' => $uuid,
        ]);

        $foundTeam = Team::where('uuid', $uuid)->first();

        static::assertNotNull($foundTeam);
        static::assertSame($team->id, $foundTeam->id);
    }

    public function test_can_find_team_by_owner_id(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'owner_id' => $user->id,
        ]);

        $foundTeam = Team::where('owner_id', $user->id)->first();

        static::assertNotNull($foundTeam);
        static::assertSame($team->id, $foundTeam->id);
    }

    public function test_can_find_personal_teams(): void
    {
        $user = User::factory()->create();
        Team::factory()->create([
            'user_id' => $user->id,
            'personal_team' => 1,
        ]);
        Team::factory()->create([
            'user_id' => $user->id,
            'personal_team' => 0,
        ]);

        $personalTeams = Team::where('personal_team', 1)->get();

        static::assertCount(1, $personalTeams);
        static::assertSame(1, $personalTeams->firstOrFail()->personal_team);
    }

    public function test_can_find_teams_by_user_id(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Team::factory()->create(['user_id' => $user1->id]);
        Team::factory()->create(['user_id' => $user1->id]);
        Team::factory()->create(['user_id' => $user2->id]);

        $user1Teams = Team::where('user_id', $user1->id)->get();

        static::assertCount(2, $user1Teams);
        static::assertTrue($user1Teams->every(fn (Team $team): bool => $team->user_id === $user1->id));
    }

    public function test_can_find_teams_by_name_pattern(): void
    {
        $user = User::factory()->create();
        Team::factory()->create(['user_id' => $user->id, 'name' => 'Development Team']);
        Team::factory()->create(['user_id' => $user->id, 'name' => 'Marketing Team']);
        Team::factory()->create(['user_id' => $user->id, 'name' => 'Sales Team']);

        $devTeams = Team::where('name', 'like', '%Team%')->get();

        static::assertCount(3, $devTeams);
        static::assertTrue($devTeams->every(fn (Team $team): bool => str_contains($team->name, 'Team')));
    }

    public function test_can_update_team(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Old Name',
        ]);

        $team->update(['name' => 'New Name']);

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_handle_null_values(): void
    {
        $user = User::factory()->create();
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Test Team',
            'code' => null,
            'uuid' => null,
            'owner_id' => null,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $team->id,
            'code' => null,
            'uuid' => null,
            'owner_id' => null,
        ]);
    }

    public function test_can_find_teams_by_multiple_criteria(): void
    {
        $user = User::factory()->create();
        Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Development Team',
            'personal_team' => 0,
        ]);

        Team::factory()->create([
            'user_id' => $user->id,
            'name' => 'Personal Team',
            'personal_team' => 1,
        ]);

        $teams = Team::where('user_id', $user->id)->where('personal_team', 0)->get();

        static::assertCount(1, $teams);
        $team = $teams->firstOrFail();
        static::assertSame('Development Team', $team->name);
        static::assertSame(0, $team->personal_team);
    }
}
