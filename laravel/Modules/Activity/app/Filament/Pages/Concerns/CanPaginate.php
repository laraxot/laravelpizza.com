<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Pages\Concerns;

use Filament\Tables\Enums\PaginationMode;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

trait CanPaginate
{
    public int|string|null $recordsPerPage = null;

    protected int|string|null $defaultRecordsPerPageSelectOption = null;

    public function updatedRecordsPerPage(): void
    {
        session()->put([
            $this->getPerPageSessionKey() => $this->getRecordsPerPage(),
        ]);

        $this->resetLivewirePage();
    }

    public function getRecordsPerPage(): int|string
    {
        if ($this->recordsPerPage !== null) {
            return $this->recordsPerPage;
        }

        return $this->getDefaultRecordsPerPageSelectOption();
    }

    public function getTablePage(): int
    {
        $page = $this->getPage($this->getPaginationPageName());
        if (is_numeric($page)) {
            return (int) $page;
        }
        return 1;
    }

    public function getDefaultRecordsPerPageSelectOption(): int|string
    {
        $option = session()->get(
            $this->getPerPageSessionKey(),
            $this->defaultRecordsPerPageSelectOption,
        );

        $pageOptions = $this->getRecordsPerPageSelectOptions();

        if (is_numeric($option) && in_array($option, $pageOptions)) {
            return (int) $option;
        }

        session()->remove($this->getPerPageSessionKey());

        $firstOption = $pageOptions[0] ?? 10;
        return is_numeric($firstOption) ? (int) $firstOption : 10;
    }

    public function getPaginationPageName(): string
    {
        return 'recordsPerPage';
    }

    public function getPerPageSessionKey(): string
    {
        $name = md5($this::class);

        return "pages.{$name}_per_page";
    }

    /**
     * @template TModel of Model
     *
     * @param  Builder<TModel>  $query
     * @return Paginator<int, TModel>|CursorPaginator<int, TModel>|LengthAwarePaginator<int, TModel>
     */
    protected function paginateQuery(Builder $query): Paginator|CursorPaginator|LengthAwarePaginator
    {
        $perPage = $this->getRecordsPerPage();

        $mode = $this->getPaginationMode();

        if ($mode === PaginationMode::Simple) {
            return $query->simplePaginate(
                perPage: $perPage === 'all' ? $query->toBase()->getCountForPagination() : (int) $perPage,
                pageName: $this->getPaginationPageName(),
            );
        }

        if ($mode === PaginationMode::Cursor) {
            return $query->cursorPaginate(
                perPage: $perPage === 'all' ? $query->toBase()->getCountForPagination() : (int) $perPage,
                cursorName: $this->getPaginationPageName(),
            );
        }

        $total = $query->toBase()->getCountForPagination();

        /** @var LengthAwarePaginator<int, TModel> $records */
        $records = $query->paginate(
            perPage: $perPage === 'all' ? $total : (int) $perPage,
            pageName: $this->getPaginationPageName(),
            total: $total,
        );

        return $records->onEachSide(0);
    }

    /**
     * @return array<int|string>
     */
    protected function getRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50];
    }
}
