<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;

<<<<<<< .merge_file_iKm6gA
=======
use Illuminate\Database\Eloquent\Collection;
>>>>>>> .merge_file_fCzWik
use Mockery;
use Modules\Activity\Actions\ActivityLogger as ActivityLoggerAction;
use Modules\Activity\Adapters\ActivityLogger as ActivityLoggerAdapter;
use Modules\Activity\Models\Activity;
<<<<<<< .merge_file_iKm6gA
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

=======
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_fCzWik
afterEach(function (): void {
    Mockery::close();
});

test('ActivityLogger Action custom delega a log', function (): void {
<<<<<<< .merge_file_iKm6gA
    $activity = new Activity();
=======
    $activity = new Activity;
>>>>>>> .merge_file_fCzWik

    /** @var ActivityLoggerAction&Mockery\MockInterface $logger */
    $logger = Mockery::mock(ActivityLoggerAction::class)->makePartial();
    mockeryExpect($logger->shouldReceive('log'))
        ->once()
        ->with('evt', null, null, null, 'Descrizione')
        ->andReturn($activity);

    Assert::assertSame($activity, $logger->custom('evt', 'Descrizione'));
});

test('ActivityLogger Action getByType rifiuta type vuoto', function (): void {
<<<<<<< .merge_file_iKm6gA
    expect(fn (): mixed => (new ActivityLoggerAction())->getByType(''))
=======
    expect(fn (): Collection => (new ActivityLoggerAction)->getByType(''))
>>>>>>> .merge_file_fCzWik
        ->toThrow(\InvalidArgumentException::class);
});

test('ActivityLogger Adapter login e logout sono invocabili con partial mock', function (): void {
<<<<<<< .merge_file_iKm6gA
    $activity = new Activity();
    $user = new User();
=======
    $activity = new Activity;
    $user = new User;
>>>>>>> .merge_file_fCzWik

    /** @var ActivityLoggerAdapter&Mockery\MockInterface $logger */
    $logger = Mockery::mock(ActivityLoggerAdapter::class)->makePartial();
    mockeryExpect($logger->shouldReceive('login'))->once()->with($user)->andReturn($activity);
    mockeryExpect($logger->shouldReceive('logout'))->once()->with($user)->andReturn($activity);

    Assert::assertSame($activity, $logger->login($user));
    Assert::assertSame($activity, $logger->logout($user));
});
