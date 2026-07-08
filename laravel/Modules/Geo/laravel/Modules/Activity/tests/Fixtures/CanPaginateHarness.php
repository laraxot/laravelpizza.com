<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Filament\Tables\Enums\PaginationMode;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;

final class CanPaginateHarness
{
    use CanPaginate;

    public int $pageResetCount = 0;

    private PaginationMode $mode = PaginationMode::Default;

    public function setMode(PaginationMode $mode): void
    {
        $this->mode = $mode;
    }

    public function getPaginationMode(): PaginationMode
    {
        return $this->mode;
    }

    public function getPage(string $pageName): int
    {
        return 2;
    }

    public function resetLivewirePage(): void
    {
        $this->pageResetCount++;
    }

    /**
     * @template TModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  Builder<TModel>  $query
     * @return Paginator<int, TModel>|CursorPaginator<int, TModel>|LengthAwarePaginator<int, TModel>
     */
    public function exposePaginateQuery(Builder $query): Paginator|CursorPaginator|LengthAwarePaginator
    {
        return $this->paginateQuery($query);
    }

    /**
     * @return array<int|string>
     */
    public function exposeOptions(): array
    {
        return $this->getRecordsPerPageSelectOptions();
    }

    public function setDefaultPerPage(int|string|null $value): void
    {
        $this->defaultRecordsPerPageSelectOption = $value;
    }
}
