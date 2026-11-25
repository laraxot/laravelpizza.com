<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Mockery;
use Modules\Xot\App\Filament\Traits\HasXotTable;
use PHPUnit\Framework\TestCase;

class HasXotTableTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    /**
     * Test the table method with all methods implemented.
     */
    public function testTableMethodWithAllMethodsImplemented(): void
    {
        // Create mock object that uses HasXotTable trait
        $mock = \Mockery::mock(HasTableWithXot::class);

        // Expect getTableHeaderActions to be called
        $mock->shouldReceive('getTableHeaderActions')
            ->once()
            ->andReturn([]);

        // Expect getTableActions to be called
        $mock->shouldReceive('getTableActions')
            ->once()
            ->andReturn([]);

        // Expect getTableBulkActions to be called
        $mock->shouldReceive('getTableBulkActions')
            ->once()
            ->andReturn([]);

        // Other required method stubs
        $mock->shouldReceive('getModelClass')
            ->andReturn(DummyModel::class);
        $mock->shouldReceive('getTableRecordTitleAttribute')
            ->andReturn('name');
        $mock->shouldReceive('getTableHeading')
            ->andReturn('Test Table');
        $mock->shouldReceive('getTableFilters')
            ->andReturn([]);
        $mock->shouldReceive('getTableFiltersFormColumns')
            ->andReturn(1);
        $mock->shouldReceive('getTableEmptyStateActions')
            ->andReturn([]);

        // Create a mock for Table
        $tableMock = \Mockery::mock(Table::class);
        $tableMock->shouldReceive('recordTitleAttribute')->andReturnSelf();
        $tableMock->shouldReceive('heading')->andReturnSelf();
        $tableMock->shouldReceive('columns')->andReturnSelf();
        $tableMock->shouldReceive('contentGrid')->andReturnSelf();
        $tableMock->shouldReceive('filters')->andReturnSelf();
        $tableMock->shouldReceive('filtersLayout')->andReturnSelf();
        $tableMock->shouldReceive('filtersFormColumns')->andReturnSelf();
        $tableMock->shouldReceive('persistFiltersInSession')->andReturnSelf();
        $tableMock->shouldReceive('headerActions')->andReturnSelf();
        $tableMock->shouldReceive('actions')->andReturnSelf();
        $tableMock->shouldReceive('bulkActions')->andReturnSelf();
        $tableMock->shouldReceive('actionsPosition')->andReturnSelf();
        $tableMock->shouldReceive('emptyStateActions')->andReturnSelf();
        $tableMock->shouldReceive('striped')->andReturnSelf();

        // Call the table method
        $result = $mock->table($tableMock);

        // Assert the result is a Table instance
        $this->assertSame($tableMock, $result);
    }

    /**
     * Test the table method without any of the optional methods implemented.
     */
    public function testTableMethodWithNoOptionalMethodsImplemented(): void
    {
        // Create mock object that uses HasXotTable trait but doesn't implement optional methods
        $mock = \Mockery::mock(HasTableWithoutOptionalMethods::class);

        // Other required method stubs
        $mock->shouldReceive('getModelClass')
            ->andReturn(DummyModel::class);
        $mock->shouldReceive('getTableRecordTitleAttribute')
            ->andReturn('name');
        $mock->shouldReceive('getTableHeading')
            ->andReturn('Test Table');
        $mock->shouldReceive('getTableFilters')
            ->andReturn([]);
        $mock->shouldReceive('getTableFiltersFormColumns')
            ->andReturn(1);
        $mock->shouldReceive('getTableEmptyStateActions')
            ->andReturn([]);

        // Create a mock for Table
        $tableMock = \Mockery::mock(Table::class);
        $tableMock->shouldReceive('recordTitleAttribute')->andReturnSelf();
        $tableMock->shouldReceive('heading')->andReturnSelf();
        $tableMock->shouldReceive('columns')->andReturnSelf();
        $tableMock->shouldReceive('contentGrid')->andReturnSelf();
        $tableMock->shouldReceive('filters')->andReturnSelf();
        $tableMock->shouldReceive('filtersLayout')->andReturnSelf();
        $tableMock->shouldReceive('filtersFormColumns')->andReturnSelf();
        $tableMock->shouldReceive('persistFiltersInSession')->andReturnSelf();
        // headerActions, actions, and bulkActions should NOT be called
        $tableMock->shouldReceive('actionsPosition')->andReturnSelf();
        $tableMock->shouldReceive('emptyStateActions')->andReturnSelf();
        $tableMock->shouldReceive('striped')->andReturnSelf();

        // Call the table method
        $result = $mock->table($tableMock);

        // Assert the result is a Table instance
        $this->assertSame($tableMock, $result);
    }
}

/**
 * Dummy class that uses HasTable and HasXotTable traits for testing.
 */
class HasTableWithXot implements HasTable
{
    use HasXotTable;

    // Implement the methods required by HasTable interface
    public function getLayoutView()
    {
        $mock = \Mockery::mock();
        $mock->shouldReceive('getTableColumns')->andReturn([]);
        $mock->shouldReceive('getTableContentGrid')->andReturn([]);

        return $mock;
    }
}

/**
 * Dummy class without the optional methods.
 */
class HasTableWithoutOptionalMethods implements HasTable
{
    use HasXotTable;

    // Implement the methods required by HasTable interface
    public function getLayoutView()
    {
        $mock = \Mockery::mock();
        $mock->shouldReceive('getTableColumns')->andReturn([]);
        $mock->shouldReceive('getTableContentGrid')->andReturn([]);

        return $mock;
    }

    // Purposely NOT implementing:
    // - getTableHeaderActions
    // - getTableActions
    // - getTableBulkActions
}

/**
 * Dummy model class for testing.
 */
class DummyModel
{
    // Empty dummy model
}
