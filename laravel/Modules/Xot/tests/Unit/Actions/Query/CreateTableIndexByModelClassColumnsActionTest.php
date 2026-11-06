<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Actions\Query\CreateTableIndexByModelClassColumnsAction;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// 'xot' e' la connessione di XotBaseModel: la tabella temporanea deve stare dove l'Action la cerca.
beforeEach(function (): void {
    Schema::connection('xot')->dropIfExists('test_index_table');
    Schema::connection('xot')->create('test_index_table', function (Blueprint $table): void {
        $table->id();
        $table->string('test_col');
    });
});

afterEach(function (): void {
    Schema::connection('xot')->dropIfExists('test_index_table');
});

it('creates table index correctly', function (): void {
    $model = new class extends XotBaseModel
    {
        protected $table = 'test_index_table';
    };
    $action = app(CreateTableIndexByModelClassColumnsAction::class);

    // First creation
    Assert::assertTrue($action->execute($model::class, ['test_col']));
    $indexNames = array_column(Schema::connection('xot')->getIndexes('test_index_table'), 'name');
    Assert::assertContains('test_index_table_test_col_index', $indexNames);

    // Duplicate creation should skip
    Assert::assertFalse($action->execute($model::class, ['test_col']));
});

it('throws exception for invalid model class', function (): void {
    $action = app(CreateTableIndexByModelClassColumnsAction::class);

    // `execute()` e' tipizzato class-string<Model>: la guardia runtime si prova passando
    // una classe non-Model via reflection, senza violare il contratto statico.
    $execute = new ReflectionMethod($action, 'execute');

    expect(fn (): mixed => $execute->invoke($action, \stdClass::class, ['id']))
        ->toThrow(\InvalidArgumentException::class, 'must be a subclass of');
});

it('throws exception for missing table', function (): void {
    $model = new class extends XotBaseModel
    {
        protected $table = 'missing_table';
    };
    $action = app(CreateTableIndexByModelClassColumnsAction::class);

    expect(fn (): bool => $action->execute($model::class, ['id']))
        ->toThrow(RuntimeException::class, "Table 'missing_table' does not exist on connection 'xot'.");
});

it('throws exception for missing column and creates no index', function (): void {
    $model = new class extends XotBaseModel
    {
        protected $table = 'test_index_table';
    };
    $action = app(CreateTableIndexByModelClassColumnsAction::class);

    expect(fn (): bool => $action->execute($model::class, ['missing_col']))
        ->toThrow(\RuntimeException::class, "Column 'missing_col' does not exist in table 'test_index_table'.");

    $indexNames = array_column(Schema::connection('xot')->getIndexes('test_index_table'), 'name');
    Assert::assertNotContains('test_index_table_missing_col_index', $indexNames);
});
