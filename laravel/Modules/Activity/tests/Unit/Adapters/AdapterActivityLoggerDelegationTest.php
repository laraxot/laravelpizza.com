<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Adapters;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Mockery;
use Modules\Activity\Actions\ActivityMaintenanceAction;
use Modules\Activity\Actions\Query\GetActivitiesByTypeAction;
use Modules\Activity\Actions\Query\GetActivityStatisticsAction;
use Modules\Activity\Actions\Query\GetModelActivitiesAction;
use Modules\Activity\Actions\Query\GetRecentActivitiesAction;
use Modules\Activity\Actions\Query\GetUserActivitiesAction;
use Modules\Activity\Adapters\ActivityLogger as ActivityLoggerAdapter;
use Modules\Activity\Models\Activity;
<<<<<<< .merge_file_UKH0Y6
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

=======
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_WV3a9M
afterEach(function (): void {
    Mockery::close();
});

test('Adapter ActivityLogger custom delega a log', function (): void {
<<<<<<< .merge_file_UKH0Y6
    $activity = new Activity();
=======
    $activity = new Activity;
>>>>>>> .merge_file_WV3a9M

    /** @var ActivityLoggerAdapter&Mockery\MockInterface $logger */
    $logger = Mockery::mock(ActivityLoggerAdapter::class)->makePartial();
    mockeryExpect($logger->shouldReceive('log'))
        ->once()
        ->with('custom_type', null, null, ['key' => 'val'], 'Custom description')
        ->andReturn($activity);

    $result = $logger->custom('custom_type', 'Custom description', null, ['key' => 'val']);

    Assert::assertSame($activity, $result);
});

test('Adapter ActivityLogger getUserActivities delega al container', function (): void {
    /** @var Collection<int, Activity> $expected */
<<<<<<< .merge_file_UKH0Y6
    $expected = new Collection();
    $user = new User();
=======
    $expected = new Collection;
    $user = new User;
>>>>>>> .merge_file_WV3a9M

    $mock = Mockery::mock(GetUserActivitiesAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with($user, 25)->andReturn($expected);
    app()->instance(GetUserActivitiesAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    $result = (new ActivityLoggerAdapter())->getUserActivities($user, 25);
=======
    $result = (new ActivityLoggerAdapter)->getUserActivities($user, 25);
>>>>>>> .merge_file_WV3a9M

    Assert::assertSame($expected, $result);
});

test('Adapter ActivityLogger getModelActivities delega al container', function (): void {
    /** @var Collection<int, Activity> $expected */
<<<<<<< .merge_file_UKH0Y6
    $expected = new Collection();
    $model = new class() extends Model
=======
    $expected = new Collection;
    $model = new class extends Model
>>>>>>> .merge_file_WV3a9M
    {
        protected $table = 'stub_models';
    };

    $mock = Mockery::mock(GetModelActivitiesAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with($model, 10)->andReturn($expected);
    app()->instance(GetModelActivitiesAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    $result = (new ActivityLoggerAdapter())->getModelActivities($model, 10);
=======
    $result = (new ActivityLoggerAdapter)->getModelActivities($model, 10);
>>>>>>> .merge_file_WV3a9M

    Assert::assertSame($expected, $result);
});

test('Adapter ActivityLogger getByType delega al container', function (): void {
    /** @var Collection<int, Activity> $expected */
<<<<<<< .merge_file_UKH0Y6
    $expected = new Collection();
=======
    $expected = new Collection;
>>>>>>> .merge_file_WV3a9M

    $mock = Mockery::mock(GetActivitiesByTypeAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with('login', 5)->andReturn($expected);
    app()->instance(GetActivitiesByTypeAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    $result = (new ActivityLoggerAdapter())->getByType('login', 5);
=======
    $result = (new ActivityLoggerAdapter)->getByType('login', 5);
>>>>>>> .merge_file_WV3a9M

    Assert::assertSame($expected, $result);
});

test('Adapter ActivityLogger getRecent delega al container', function (): void {
    /** @var Collection<int, Activity> $expected */
<<<<<<< .merge_file_UKH0Y6
    $expected = new Collection();
=======
    $expected = new Collection;
>>>>>>> .merge_file_WV3a9M

    $mock = Mockery::mock(GetRecentActivitiesAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with(50)->andReturn($expected);
    app()->instance(GetRecentActivitiesAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    $result = (new ActivityLoggerAdapter())->getRecent(50);
=======
    $result = (new ActivityLoggerAdapter)->getRecent(50);
>>>>>>> .merge_file_WV3a9M

    Assert::assertSame($expected, $result);
});

test('Adapter ActivityLogger cleanOld delega al container', function (): void {
    $mock = Mockery::mock(ActivityMaintenanceAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with(30)->andReturn(3);
    app()->instance(ActivityMaintenanceAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    $deleted = (new ActivityLoggerAdapter())->cleanOld(30);
=======
    $deleted = (new ActivityLoggerAdapter)->cleanOld(30);
>>>>>>> .merge_file_WV3a9M

    Assert::assertSame(3, $deleted);
});

test('Adapter ActivityLogger getStatistics delega al container', function (): void {
<<<<<<< .merge_file_UKH0Y6
    $user = new User();
=======
    $user = new User;
>>>>>>> .merge_file_WV3a9M
    $stats = [
        'total' => 1,
        'by_type' => ['login' => 1],
        'today' => 1,
        'this_week' => 1,
        'this_month' => 1,
    ];

    $mock = Mockery::mock(GetActivityStatisticsAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with($user)->andReturn($stats);
    app()->instance(GetActivityStatisticsAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    $result = (new ActivityLoggerAdapter())->getStatistics($user);
=======
    $result = (new ActivityLoggerAdapter)->getStatistics($user);
>>>>>>> .merge_file_WV3a9M

    Assert::assertSame($stats, $result);
});

test('Adapter ActivityLogger getRecent propaga InvalidArgumentException', function (): void {
    $mock = Mockery::mock(GetRecentActivitiesAction::class);
    mockeryExpect($mock->shouldReceive('execute'))->once()->with(0)->andThrow(new InvalidArgumentException('Limit must be positive'));
    app()->instance(GetRecentActivitiesAction::class, $mock);

<<<<<<< .merge_file_UKH0Y6
    expect(fn (): Collection => (new ActivityLoggerAdapter())->getRecent(0))
=======
    expect(fn (): Collection => (new ActivityLoggerAdapter)->getRecent(0))
>>>>>>> .merge_file_WV3a9M
        ->toThrow(InvalidArgumentException::class, 'Limit must be positive');
});
