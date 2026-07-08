<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Modules\User\Actions\Team\GetUserTeamsOptionAction;
use Modules\User\Models\Team;
use Modules\User\Models\TeamUser;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

it('returns only the placeholder when the authenticated user has no teams', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();
    Auth::login($user);

    $options = app(GetUserTeamsOptionAction::class)->execute();

    Assert::assertSame(['' => '--- Select ---'], $options);
});

it('returns the teams the authenticated user belongs to, keyed by team id', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    $team = new Team();
    $team->forceFill(['user_id' => $user->getKey(), 'name' => 'Engineering']);
    $team->save();

    $teamUser = new TeamUser();
    $teamUser->forceFill([
        'team_id' => $team->getKey(),
        'user_id' => $user->getKey(),
    ]);
    $teamUser->save();

    Auth::login($user);

    $options = app(GetUserTeamsOptionAction::class)->execute();

    Assert::assertArrayHasKey((string) $team->getKey(), $options);
    Assert::assertSame('Engineering', $options[(string) $team->getKey()]);
    Assert::assertArrayHasKey('', $options);
});

it('skips team_user rows whose team no longer exists', function (): void {
    $user = Modules\User\Tests\TestCase::createTestUser();

    $teamUser = new TeamUser();
    $teamUser->forceFill([
        'team_id' => 999999,
        'user_id' => $user->getKey(),
    ]);
    $teamUser->save();

    Auth::login($user);

    $options = app(GetUserTeamsOptionAction::class)->execute();

    Assert::assertSame(['' => '--- Select ---'], $options);
});
