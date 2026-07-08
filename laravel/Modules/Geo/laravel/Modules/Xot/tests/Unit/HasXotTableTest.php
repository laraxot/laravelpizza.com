<?php

declare(strict_types=1);

use Filament\Tables\Table;
use Mockery\MockInterface;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Tests\Unit\Support\DummyTestModel;
use Modules\Xot\Tests\Unit\Support\HasTableWithoutOptionalMethodsTestClass;
use Modules\Xot\Tests\Unit\Support\HasTableWithXotTestClass;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param MockInterface&Table $tableMock
 *
 * @return MockInterface&Table
 */
function stubTableChain(MockInterface $tableMock): MockInterface
{
    $chainMethods = [
        'recordTitleAttribute',
        'heading',
        'columns',
        'contentGrid',
        'filters',
        'filtersLayout',
        'filtersFormColumns',
        'persistFiltersInSession',
        'headerActions',
        'actions',
        'bulkActions',
        'actionsPosition',
        'recordActions',
        'toolbarActions',
        'recordActionsPosition',
        'emptyStateActions',
        'striped',
        'paginated',
        'defaultSort',
        'poll',
    ];

    $allows = [];
    foreach ($chainMethods as $method) {
        $allows[$method] = $tableMock;
    }

    $tableMock->allows($allows);

    return $tableMock;
}

afterEach(function (): void {
    Mockery::close();
});

it('tests table method with all methods implemented', function (): void {
    Mockery::mock('overload:Modules\\Xot\\Actions\\Model\\TableExistsByModelClassActions')
        ->allows(['execute' => true]);

    /** @var HasTableWithXotTestClass&MockInterface $mock */
    $mock = Mockery::mock(HasTableWithXotTestClass::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldDeferMissing();
    $mock->allows([
        'getTableHeaderActions' => [],
        'getTableActions' => [],
        'getTableBulkActions' => [],
        'getModelClass' => DummyTestModel::class,
        'getTableRecordTitleAttribute' => 'name',
        'getTableHeading' => 'Test Table',
        'getTableFilters' => [],
        'getTableFiltersFormColumns' => 1,
        'getTableEmptyStateActions' => [],
        'getDefaultTableSortColumn' => null,
        'getDefaultTableSortDirection' => null,
        'getTablePollInterval' => null,
    ]);

    /** @var MockInterface&Table $tableMock */
    $tableMock = Mockery::mock(Table::class);
    stubTableChain($tableMock);

    $result = $mock->table($tableMock);

    Assert::assertSame($tableMock, $result);
});

it('tests table method with no optional methods implemented', function (): void {
    Mockery::mock('overload:Modules\\Xot\\Actions\\Model\\TableExistsByModelClassActions')
        ->allows(['execute' => true]);

    /** @var HasTableWithoutOptionalMethodsTestClass&MockInterface $mock */
    $mock = Mockery::mock(HasTableWithoutOptionalMethodsTestClass::class)
        ->makePartial()
        ->shouldAllowMockingProtectedMethods()
        ->shouldDeferMissing();
    $mock->allows([
        'getModelClass' => DummyTestModel::class,
        'getTableRecordTitleAttribute' => 'name',
        'getTableHeading' => 'Test Table',
        'getTableFilters' => [],
        'getTableHeaderActions' => [],
        'getTableActions' => [],
        'getTableBulkActions' => [],
        'getTableFiltersFormColumns' => 1,
        'getTableEmptyStateActions' => [],
        'getDefaultTableSortColumn' => null,
        'getDefaultTableSortDirection' => null,
        'getTablePollInterval' => null,
    ]);

    /** @var MockInterface&Table $tableMock */
    $tableMock = Mockery::mock(Table::class);
    stubTableChain($tableMock);

    $result = $mock->table($tableMock);

    Assert::assertSame($tableMock, $result);
});
