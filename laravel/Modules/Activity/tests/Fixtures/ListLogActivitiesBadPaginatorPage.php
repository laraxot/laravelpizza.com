<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator as ContractsPaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

final class ListLogActivitiesBadPaginatorPage extends ListLogActivitiesPageHarness
{
    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $query
     * @return ContractsPaginator<int, TModel>|CursorPaginator<int, TModel>|LengthAwarePaginator<int, TModel>
     */
    protected function paginateQuery(Builder $query): ContractsPaginator|CursorPaginator|LengthAwarePaginator
    {
        return new Paginator([], 10, 1);
    }
}
