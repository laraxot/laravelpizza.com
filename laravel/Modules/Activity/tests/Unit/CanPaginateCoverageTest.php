<?php

declare(strict_types=1);

use Filament\Tables\Enums\PaginationMode;
use Illuminate\Database\Eloquent\Builder;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

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

    public function exposePaginateQuery(Builder $query)
    {
        return $this->paginateQuery($query);
    }

    public function exposeOptions(): ?array
    {
        return $this->getRecordsPerPageSelectOptions();
    }

    public function setDefaultPerPage(int|string|null $value): void
    {
        $this->defaultRecordsPerPageSelectOption = $value;
    }
}

test('can paginate trait manages session, defaults and page helpers', function (): void {
    $harness = new CanPaginateHarness();
    $harness->recordsPerPage = 25;

    $harness->updatedRecordsPerPage();

    expect(session()->get($harness->getPerPageSessionKey()))->toBe(25)
        ->and($harness->pageResetCount)->toBe(1)
        ->and($harness->getRecordsPerPage())->toBe(25)
        ->and($harness->getTablePage())->toBe(2)
        ->and($harness->getPaginationPageName())->toBe('recordsPerPage')
        ->and($harness->getPerPageSessionKey())->toStartWith('pages.');
});

test('can paginate default option fallback behaves correctly', function (): void {
    $harness = new CanPaginateHarness();
    $harness->setDefaultPerPage(25);

    expect($harness->getDefaultRecordsPerPageSelectOption())->toBe(25)
        ->and($harness->exposeOptions())->toBe([10, 25, 50]);

    session()->put([$harness->getPerPageSessionKey() => 999]);

    expect($harness->getDefaultRecordsPerPageSelectOption())->toBe(10)
        ->and(session()->has($harness->getPerPageSessionKey()))->toBeFalse();
});

test('can paginate trait covers default, simple and cursor modes', function (): void {
    Activity::query()->create([
        'log_name' => 'default',
        'description' => 'paginate default',
        'event' => 'paginate-default',
    ]);

    $query = Activity::query()->orderBy('id');

    $defaultHarness = new CanPaginateHarness();
    $defaultHarness->recordsPerPage = 10;
    $defaultHarness->setMode(PaginationMode::Default);
    $defaultPaginator = $defaultHarness->exposePaginateQuery(clone $query);

    expect($defaultPaginator)->toBeInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class);

    $simpleHarness = new CanPaginateHarness();
    $simpleHarness->recordsPerPage = 10;
    $simpleHarness->setMode(PaginationMode::Simple);
    $simplePaginator = $simpleHarness->exposePaginateQuery(clone $query);

    expect($simplePaginator)->toBeInstanceOf(\Illuminate\Contracts\Pagination\Paginator::class);

    $cursorHarness = new CanPaginateHarness();
    $cursorHarness->recordsPerPage = 10;
    $cursorHarness->setMode(PaginationMode::Cursor);
    $cursorPaginator = $cursorHarness->exposePaginateQuery(clone $query);

    expect($cursorPaginator)->toBeInstanceOf(\Illuminate\Contracts\Pagination\CursorPaginator::class);
});
