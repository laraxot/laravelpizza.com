<?php

declare(strict_types=1);

<<<<<<< HEAD
namespace Modules\User\Tests\Unit\QuickWins;

=======
use Mockery;
>>>>>>> 6d3760fe (.)
use Modules\User\Actions\Team\GetUserTeamsOptionAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Exceptions\ProviderNotConfigured;
use Modules\User\Facades\FilamentShield;
use Modules\User\Models\Team;
use Modules\User\Models\TeamUser;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
<<<<<<< HEAD

uses(TestCase::class);
=======
use Modules\User\Tests\Unit\QuickWins\Fixtures\FilamentShieldStubFixture;

use function Pest\Laravel\actingAs;

use PHPUnit\Framework\Assert;
>>>>>>> 6d3760fe (.)

uses(TestCase::class);

describe('User quick wins coverage', function (): void {
    it('builds provider not configured exception message', function (): void {
        $exception = ProviderNotConfigured::make('github');

        expect($exception)->toBeInstanceOf(ProviderNotConfigured::class)
            ->and($exception->getMessage())->toContain('Provider "github" is not configured');
    });

    it('resolves filament shield facade accessor', function (): void {
<<<<<<< HEAD
        $service = new class {
            public function getWidgets(): array
            {
                return ['w1', 'w2'];
            }
        };
=======
        $service = new FilamentShieldStubFixture();
>>>>>>> 6d3760fe (.)

        app()->instance('filament-shield', $service);

        expect(FilamentShield::getFacadeRoot())->toBe($service)
            ->and(FilamentShield::getWidgets())->toBe(['w1', 'w2']);
    });

    it('returns default option plus team options', function (): void {
<<<<<<< HEAD
        $user = User::factory()->create();
        $this->actingAs($user);
=======
        $user = UserFactory::new()->createOne();
        actingAs($user);
>>>>>>> 6d3760fe (.)

        $team1 = Team::factory()->create(['user_id' => $user->id, 'name' => 'Team One']);
        $team2 = Team::factory()->create(['user_id' => $user->id, 'name' => 'Team Two']);

<<<<<<< HEAD
        // Create TeamUser relationships using factories
        TeamUser::factory()->create(['team_id' => $team1->id, 'user_id' => $user->id, 'role' => 'member']);
        TeamUser::factory()->create(['team_id' => $team2->id, 'user_id' => $user->id, 'role' => 'member']);
=======
        attachTeamMember($team1, $user, ['role' => 'member']);
        attachTeamMember($team2, $user, ['role' => 'member']);
>>>>>>> 6d3760fe (.)

        $options = app(GetUserTeamsOptionAction::class)->execute();

        expect($options)->toBeArray()
            ->toHaveKey('')
            ->and($options[''])->toBe('--- Select ---');
    });

    it('creates user using resolved model instance', function (): void {
        $payload = [
            'email' => 'quick-win@example.test',
            'name' => 'Quick Win',
        ];

        $createdUser = new User();
        $createdUser->email = $payload['email'];
        $createdUser->name = $payload['name'];

        $userModel = \Mockery::mock(User::class);
        $userModel->shouldReceive('create')
            ->once()
            ->with($payload)
            ->andReturn($createdUser);

        app()->instance(User::class, $userModel);

        $result = app(CreateUserAction::class)->execute($payload);

        expect($result)->toBe($createdUser)
            ->and($result->email)->toBe('quick-win@example.test')
            ->and($result->name)->toBe('Quick Win');
    });
});
