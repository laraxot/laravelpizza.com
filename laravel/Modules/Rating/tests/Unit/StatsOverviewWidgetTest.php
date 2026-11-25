<?php

declare(strict_types=1);

namespace Modules\Rating\Tests\Unit;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;
use Mockery;
use Modules\Rating\Actions\HasRating\GetCountByModelRatingIdAction;
use Modules\Rating\Actions\HasRating\GetSumByModelRatingIdAction;
use Modules\Rating\Filament\Widgets\StatsOverview;
use Modules\Rating\Models\Contracts\HasRatingContract;
use Modules\Rating\Models\Rating;
use Modules\Rating\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

/**
 * @param  Collection<int, Rating>  $ratings
 * @return Model&HasRatingContract
 */
function ratingStatsHost(Collection $ratings): Model
{
    /** @var MorphToMany<Rating, Model, MorphPivot, 'pivot'>&Mockery\MockInterface $relation */
    $relation = Mockery::mock(MorphToMany::class);
    $relation->shouldReceive('wherePivot')->with('user_id', null)->andReturnSelf();
    $relation->shouldReceive('get')->andReturn($ratings);

    /** @var Model&HasRatingContract&Mockery\MockInterface $host */
    $host = Mockery::mock(Model::class, HasRatingContract::class);
    $host->shouldReceive('ratings')->andReturn($relation);

    return $host;
}

test('StatsOverview senza record restituisce array vuoto', function (): void {
    $widget = new StatsOverview;
    $widget->record = null;

    $method = new \ReflectionMethod(StatsOverview::class, 'getStats');
    $method->setAccessible(true);

    $stats = $method->invoke($widget);

    Assert::assertSame([], $stats);
});

test('StatsOverview con record costruisce stat per rating e totali', function (): void {
    $rating = new Rating;
    $rating->forceFill(['id' => 4, 'title' => 'Qualità']);

    $sumAction = Mockery::mock(GetSumByModelRatingIdAction::class);
    $sumAction->shouldReceive('execute')->andReturn(12.0, 99.0);

    $countAction = Mockery::mock(GetCountByModelRatingIdAction::class);
    $countAction->shouldReceive('execute')->andReturn(3.0, 15.0);

    app()->instance(GetSumByModelRatingIdAction::class, $sumAction);
    app()->instance(GetCountByModelRatingIdAction::class, $countAction);

    $widget = new StatsOverview;
    $widget->record = ratingStatsHost(collect([$rating]));

    $method = new \ReflectionMethod(StatsOverview::class, 'getStats');
    $method->setAccessible(true);

    $stats = $method->invoke($widget);

    Assert::assertIsArray($stats);
    Assert::assertCount(4, $stats);
    Assert::assertContainsOnlyInstancesOf(Stat::class, $stats);
    $volume = $stats[2] ?? null;
    $players = $stats[3] ?? null;
    Assert::assertInstanceOf(Stat::class, $volume);
    Assert::assertInstanceOf(Stat::class, $players);
    Assert::assertSame('Tot Volume', $volume->getLabel());
    Assert::assertSame('Tot Player', $players->getLabel());
});
