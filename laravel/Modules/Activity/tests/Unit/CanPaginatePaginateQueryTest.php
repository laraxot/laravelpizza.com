<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Filament\Tables\Enums\PaginationMode;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Pagination\CursorPaginator as LaravelCursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator as LaravelPaginator;
use Mockery;
use Mockery\MockInterface;
use Modules\Activity\Tests\Fixtures\CanPaginateHarness;
<<<<<<< .merge_file_wdjLj4
use PHPUnit\Framework\Assert;

=======
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

>>>>>>> .merge_file_VG7gqQ
afterEach(function (): void {
    Mockery::close();
});

/**
 * @return Builder<Model>&MockInterface
 */
function makePaginateQueryMock(int $total = 0): Builder&MockInterface
{
    $baseQuery = Mockery::mock(QueryBuilder::class);
    mockeryExpect($baseQuery->shouldReceive('getCountForPagination'))->andReturn($total);

    /** @var Builder<Model>&MockInterface $query */
    $query = Mockery::mock(Builder::class);
    mockeryExpect($query->shouldReceive('toBase'))->andReturn($baseQuery);

    return $query;
}

test('CanPaginate paginateQuery usa LengthAwarePaginator in modalità default', function (): void {
<<<<<<< .merge_file_wdjLj4
    $harness = new CanPaginateHarness();
=======
    $harness = new CanPaginateHarness;
>>>>>>> .merge_file_VG7gqQ
    $harness->recordsPerPage = 10;

    $query = makePaginateQueryMock(0);
    mockeryExpect($query->shouldReceive('paginate'))
        ->once()
        ->andReturn(new LengthAwarePaginator([], 0, 10, 1));

    $result = $harness->exposePaginateQuery($query);

    Assert::assertInstanceOf(LengthAwarePaginator::class, $result);
});

test('CanPaginate paginateQuery usa simplePaginate in modalità simple', function (): void {
<<<<<<< .merge_file_wdjLj4
    $harness = new CanPaginateHarness();
=======
    $harness = new CanPaginateHarness;
>>>>>>> .merge_file_VG7gqQ
    $harness->recordsPerPage = 10;
    $harness->setMode(PaginationMode::Simple);

    $query = makePaginateQueryMock(0);
    mockeryExpect($query->shouldReceive('simplePaginate'))
        ->once()
        ->andReturn(new LaravelPaginator([], 10, 1));

    $result = $harness->exposePaginateQuery($query);

    Assert::assertInstanceOf(Paginator::class, $result);
});

test('CanPaginate paginateQuery usa cursorPaginate in modalità cursor', function (): void {
<<<<<<< .merge_file_wdjLj4
    $harness = new CanPaginateHarness();
=======
    $harness = new CanPaginateHarness;
>>>>>>> .merge_file_VG7gqQ
    $harness->recordsPerPage = 10;
    $harness->setMode(PaginationMode::Cursor);

    $query = makePaginateQueryMock(0);
    mockeryExpect($query->shouldReceive('cursorPaginate'))
        ->once()
        ->andReturn(new LaravelCursorPaginator([], 10));

    $result = $harness->exposePaginateQuery($query);

    Assert::assertInstanceOf(CursorPaginator::class, $result);
});

test('CanPaginate paginateQuery gestisce recordsPerPage all', function (): void {
<<<<<<< .merge_file_wdjLj4
    $harness = new CanPaginateHarness();
=======
    $harness = new CanPaginateHarness;
>>>>>>> .merge_file_VG7gqQ
    $harness->recordsPerPage = 'all';

    $query = makePaginateQueryMock(3);
    mockeryExpect($query->shouldReceive('paginate'))
        ->once()
        ->andReturn(new LengthAwarePaginator([], 3, 3, 1));

    $result = $harness->exposePaginateQuery($query);

    Assert::assertInstanceOf(LengthAwarePaginator::class, $result);
});
