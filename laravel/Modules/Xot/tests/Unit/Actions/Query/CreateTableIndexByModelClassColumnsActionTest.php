<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Query;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\User\Models\User;
use Modules\Xot\Actions\Query\CreateTableIndexByModelClassColumnsAction;
use Modules\Xot\Models\XotBaseModel;

it('creates table index correctly', function (): void {
    // We use User model for testing as it surely has 'id' and 'email'
    // but we might want to avoid touching production tables.
    // Let's create a temporary table.
    Schema::create('test_index_table', function (Blueprint $table) {
        $table->id();
        $table->string('test_col');
    });

    $modelClass = new class extends XotBaseModel {
        protected $table = 'test_index_table';
    };
    $modelClassName = get_class($modelClass);

    $action = app(CreateTableIndexByModelClassColumnsAction::class);

    // First creation
    $result = $action->execute($modelClassName, ['test_col']);
    expect($result)->toBeTrue();

    // Duplicate creation should skip
    $result2 = $action->execute($modelClassName, ['test_col']);
    expect($result2)->toBeFalse();

    Schema::dropIfExists('test_index_table');
});

it('throws exception for invalid model class', function (): void {
    $action = app(CreateTableIndexByModelClassColumnsAction::class);
    expect(fn () => $action->execute(\stdClass::class, ['col']))->toThrow(\InvalidArgumentException::class);
});

it('throws exception for missing table', function (): void {
    $modelClass = new class extends XotBaseModel {
        protected $table = 'missing_table';
    };
    $modelClassName = get_class($modelClass);

    $action = app(CreateTableIndexByModelClassColumnsAction::class);
    expect(fn () => $action->execute($modelClassName, ['col']))->toThrow(\RuntimeException::class);
});
