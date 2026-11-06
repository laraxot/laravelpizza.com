<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Mockery;
use Modules\User\Models\Policies\RolePolicy;
use Modules\User\Models\Policies\TeamPolicy;
use Modules\User\Models\Role;
use Modules\User\Models\Team;
use Modules\User\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class)->group('no-user-db');

/**
 * @param  list<string>  $roles
 * @return Mockery\MockInterface&UserContract
 */
function userBehaviorUser(
    array $roles = [],
    bool $ownsTeam = false,
    bool $belongsToTeam = false,
): UserContract {
    /** @var Mockery\MockInterface&UserContract $user */
    $user = Mockery::mock(UserContract::class);
    mockeryExpect($user->shouldReceive('hasRole'))
        ->andReturnUsing(static function (array|string $richiesti) use ($roles): bool {
            /** @var list<string> $normalizzati */
            $normalizzati = is_array($richiesti) ? $richiesti : [$richiesti];

            return array_intersect($normalizzati, $roles) !== [];
        });
    mockeryExpect($user->shouldReceive('ownsTeam'))->andReturn($ownsTeam);
    mockeryExpect($user->shouldReceive('belongsToTeam'))->andReturn($belongsToTeam);

    return $user;
}

afterEach(function (): void {
    Mockery::close();
});

test('RolePolicy: viewAny false, view/create/update/delete true', function (): void {
    $policy = new RolePolicy;
    $role = new Role;
    $user = userBehaviorUser();

    Assert::assertFalse($policy->viewAny($user));
    Assert::assertTrue($policy->view($user, $role));
    Assert::assertTrue($policy->create($user));
    Assert::assertTrue($policy->update($user, $role));
    Assert::assertTrue($policy->delete($user, $role));
    Assert::assertTrue($policy->addTeamMember($user, $role));
});

test('TeamPolicy: view legato a belongsToTeam, mutazioni a ownsTeam', function (): void {
    $policy = new TeamPolicy;
    $team = new Team;
    $outsider = userBehaviorUser();
    $member = userBehaviorUser(belongsToTeam: true);
    $owner = userBehaviorUser(ownsTeam: true, belongsToTeam: true);

    Assert::assertFalse($policy->viewAny($outsider));
    Assert::assertFalse($policy->view($outsider, $team));
    Assert::assertTrue($policy->view($member, $team));
    Assert::assertTrue($policy->create($outsider));

    Assert::assertFalse($policy->update($member, $team));
    Assert::assertTrue($policy->update($owner, $team));
    Assert::assertTrue($policy->addTeamMember($owner, $team));
    Assert::assertTrue($policy->removeTeamMember($owner, $team));
    Assert::assertTrue($policy->delete($owner, $team));
    Assert::assertFalse($policy->delete($member, $team));
});

test('UserBasePolicy before: super-admin bypass', function (): void {
    $policy = new RolePolicy;
    Assert::assertTrue($policy->before(userBehaviorUser(['super-admin']), 'viewAny'));
    Assert::assertNull($policy->before(userBehaviorUser(), 'viewAny'));
});
