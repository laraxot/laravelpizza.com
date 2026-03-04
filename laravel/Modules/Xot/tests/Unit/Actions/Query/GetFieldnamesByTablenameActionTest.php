<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Query;

use Modules\Xot\Actions\Query\GetFieldnamesByTablenameAction;
use Modules\Xot\Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

uses(TestCase::class);

it('gets fieldnames correctly', function (): void {
    Schema::create('test_fields_table', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });

    $action = app(GetFieldnamesByTablenameAction::class);
    $fields = $action->execute('test_fields_table');

    expect($fields)->toContain('id', 'name', 'created_at', 'updated_at');

    Schema::dropIfExists('test_fields_table');
});

it('throws exception for empty table name', function (): void {
    $action = app(GetFieldnamesByTablenameAction::class);
    expect(fn() => $action->execute(' '))->toThrow(\InvalidArgumentException::class);
});

it('throws exception for invalid connection', function (): void {
    $action = app(GetFieldnamesByTablenameAction::class);
    expect(fn() => $action->execute('users', 'invalid_conn'))->toThrow(\InvalidArgumentException::class);
});

it('throws exception for missing table', function (): void {
    $action = app(GetFieldnamesByTablenameAction::class);
    expect(fn() => $action->execute('non_existent_table'))->toThrow(\InvalidArgumentException::class);
});
