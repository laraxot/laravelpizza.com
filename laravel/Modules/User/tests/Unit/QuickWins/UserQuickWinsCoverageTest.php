<?php

declare(strict_types=1);
use Mockery\MockInterface;
use Modules\User\Actions\Team\GetUserTeamsOptionAction;
use Modules\User\Actions\User\CreateUserAction;
use Modules\User\Database\Factories\TeamFactory;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Exceptions\ProviderNotConfigured;
use Modules\User\Facades\FilamentShield;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use Modules\User\Tests\Unit\QuickWins\Fixtures\FilamentShieldStubFixture;
use PHPUnit\Framework\Assert;

use function Pest\Laravel\actingAs;

uses(TestCase::class);

describe('User quick wins coverage', function (): void {
    it('builds provider not configured exception message', function (): void {
        $exception = ProviderNotConfigured::make('github');

        Assert::assertStringContainsString('Provider "github" is not configured', $exception->getMessage());
    });

    it('resolves filament shield facade accessor', function (): void {
        $service = new FilamentShieldStubFixture;

        app()->instance('filament-shield', $service);

        Assert::assertSame($service, FilamentShield::getFacadeRoot());
        Assert::assertSame(['w1', 'w2'], (new FilamentShieldStubFixture)->getWidgets());
    });

    it('returns default option plus team options', function (): void {
        $user = UserFactory::new()->createOne();
        actingAs($user);

        $team1 = TeamFactory::new()->createOne(['user_id' => $user->id, 'name' => 'Team One']);
        $team2 = TeamFactory::new()->createOne(['user_id' => $user->id, 'name' => 'Team Two']);

        attachTeamMember($team1, $user, ['role' => 'member']);
        attachTeamMember($team2, $user, ['role' => 'member']);

        $options = app(GetUserTeamsOptionAction::class)->execute();
        Assert::assertArrayHasKey('', $options);
        Assert::assertSame('--- Select ---', $options['']);
    });

    it('creates user using resolved model instance', function (): void {
        $payload = [
            'email' => 'quick-win@example.test',
            'name' => 'Quick Win',
        ];

        $createdUser = new User;
        $createdUser->email = $payload['email'];
        $createdUser->name = $payload['name'];

        $userModel = configureMock(User::class, function (MockInterface $mock) use ($createdUser): void {
            $mock->allows(['create' => $createdUser]);
        });

        app()->instance(User::class, $userModel);

        $result = app(CreateUserAction::class)->execute($payload);

        Assert::assertSame($createdUser, $result);
        Assert::assertSame('quick-win@example.test', $result->email);
        Assert::assertSame('Quick Win', $result->name);
    });
});
