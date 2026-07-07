<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Filament\Tables\Enums\PaginationMode;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\Fixtures\CanPaginateHarness;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

function makeCanPaginateHarness(): CanPaginateHarness
{
    return new CanPaginateHarness;
}

test('can paginate trait manages session, defaults and page helpers', function (): void {
    $harness = makeCanPaginateHarness();
    $harness->recordsPerPage = 25;

    $harness->updatedRecordsPerPage();

    expect($harness->recordsPerPage)->toBe(25);
    expect($harness->pageResetCount)->toBe(1);
    expect($harness->getRecordsPerPage())->toBe(25);
    expect($harness->getTablePage())->toBe(2);
    expect($harness->getPaginationPageName())->toBe('recordsPerPage');
    expect($harness->getPerPageSessionKey())->toStartWith('pages.');
});

test('can paginate default option fallback behaves correctly', function (): void {
    $harness = makeCanPaginateHarness();
    $harness->setDefaultPerPage(25);

    expect($harness->getDefaultRecordsPerPageSelectOption())->toBe(25);
    expect($harness->exposeOptions())->toEqual([10, 25, 50]);
    session()->put([$harness->getPerPageSessionKey() => 999]);

    expect($harness->getDefaultRecordsPerPageSelectOption())->toBe(10);
    expect(session()->has($harness->getPerPageSessionKey()))->toBeFalse();
});

test('can paginate trait covers default, simple and cursor modes', function (): void {
    ActivityFactory::new()->createOne([
        'log_name' => 'default',
        'description' => 'paginate default',
        'event' => 'paginate-default',
    ]);

    $query = Activity::query()->orderBy('id');

    $defaultHarness = makeCanPaginateHarness();
    $defaultHarness->recordsPerPage = 10;
    $defaultHarness->setMode(PaginationMode::Default);
    $defaultPaginator = $defaultHarness->exposePaginateQuery(clone $query);

    expect($defaultPaginator)->toBeInstanceOf(LengthAwarePaginator::class);

    $simpleHarness = makeCanPaginateHarness();
    $simpleHarness->recordsPerPage = 10;
    $simpleHarness->setMode(PaginationMode::Simple);
    $simplePaginator = $simpleHarness->exposePaginateQuery(clone $query);

    expect($simplePaginator)->toBeInstanceOf(Paginator::class);

    $cursorHarness = makeCanPaginateHarness();
    $cursorHarness->recordsPerPage = 10;
    $cursorHarness->setMode(PaginationMode::Cursor);
    $cursorPaginator = $cursorHarness->exposePaginateQuery(clone $query);

    expect($cursorPaginator)->toBeInstanceOf(CursorPaginator::class);
});
