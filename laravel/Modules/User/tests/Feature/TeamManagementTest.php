<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature;

use Illuminate\Support\Str;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('Team Management', function () {
    it('can create a team and assign owner', function () {
        $user = User::factory()->create(['email' => self::generateUniqueEmail()]);

        $teamName = 'Team '.Str::random(5);
        $team = Team::factory()->create([
            'user_id' => $user->id,
            'name' => $teamName,
            'personal_team' => false,
        ]);

        expect($team->name)->toBe($teamName);
        expect($team->user_id)->toBe($user->id);
        expect($team->owner->id)->toBe($user->id);
    });

    it('can add members to a team', function () {
        $owner = User::factory()->create(['email' => self::generateUniqueEmail()]);
        $member = User::factory()->create(['email' => self::generateUniqueEmail()]);

        $team = Team::factory()->create(['user_id' => $owner->id]);

        $team->users()->attach($member->id, ['role' => 'member']);

        expect($team->users)->toHaveCount(1);
        expect($team->users->first()->id)->toBe($member->id);
    });

    it('can switch current team for a user', function () {
        $user = User::factory()->create(['email' => self::generateUniqueEmail()]);
        $team1 = Team::factory()->create(['user_id' => $user->id]);
        $team2 = Team::factory()->create(['user_id' => $user->id]);

        $user->switchTeam($team2);

        expect((string) $user->current_team_id)->toBe((string) $team2->id);
    });

    it('can check if a user owns a team', function () {
        $user = User::factory()->create(['email' => self::generateUniqueEmail()]);
        $otherUser = User::factory()->create(['email' => self::generateUniqueEmail()]);

        $team = Team::factory()->create(['user_id' => $user->id]);

        expect($user->ownsTeam($team))->toBeTrue();
        expect($otherUser->ownsTeam($team))->toBeFalse();
    });
});
