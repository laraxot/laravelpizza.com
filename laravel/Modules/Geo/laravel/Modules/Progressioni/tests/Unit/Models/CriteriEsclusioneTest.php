<?php

declare(strict_types=1);

use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Ptv\Models\CriteriEsclusione as PtvCriteriEsclusione;

it('extends correct base model', function () {
    $model = new CriteriEsclusione;
    expect($model)->toBeInstanceOf(CriteriEsclusione::class);
    expect($model)->toBeInstanceOf(PtvCriteriEsclusione::class);
});

it('uses correct database connection', function () {
    $model = new CriteriEsclusione;
    expect($model->getConnectionName())->toBe('progressione');
});

it('has correct table name', function () {
    $model = new CriteriEsclusione;
    expect($model->getTable())->toBe('criteri_esclusione');
});

it('has correct fillable attributes', function () {
    $model = new CriteriEsclusione;
    $fillable = $model->getFillable();

    expect($fillable)->toBeArray();
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('field_name');
    expect($fillable)->toContain('op');
    expect($fillable)->toContain('value');
    expect($fillable)->toContain('type');
    expect($fillable)->toContain('anno');
});

it('has correct casts', function () {
    $model = new CriteriEsclusione;
    $casts = $model->getCasts();

    expect($casts)->toBeArray();
    expect($casts)->toHaveKey('is_enabled');
    expect($casts['is_enabled'])->toBe('boolean');
    expect($casts)->toHaveKey('created_at');
    expect($casts['created_at'])->toBe('datetime');
    expect($casts)->toHaveKey('updated_at');
    expect($casts['updated_at'])->toBe('datetime');
});

it('can check if criteria is enabled', function () {
    $model = new CriteriEsclusione;

    $model->is_enabled = true;
    expect($model->isEnabled())->toBeTrue();

    $model->is_enabled = false;
    expect($model->isEnabled())->toBeFalse();
});

it('can get criteria type description', function () {
    $model = new CriteriEsclusione;

    $model->type = 'absence';
    expect($model->getTypeDescription())->toBe('Assenze');

    $model->type = 'evaluation';
    expect($model->getTypeDescription())->toBe('Valutazione');

    $model->type = 'seniority';
    expect($model->getTypeDescription())->toBe('Anzianità');

    $model->type = 'unknown';
    expect($model->getTypeDescription())->toBe('Sconosciuto');
});

it('can validate criteria operator', function () {
    $model = new CriteriEsclusione;

    $model->op = '>';
    expect($model->isValidOperator())->toBeTrue();

    $model->op = '<';
    expect($model->isValidOperator())->toBeTrue();

    $model->op = '=';
    expect($model->isValidOperator())->toBeTrue();

    $model->op = 'invalid';
    expect($model->isValidOperator())->toBeFalse();
});

it('can check if criteria applies for specific year', function () {
    $model = new CriteriEsclusione;

    $model->anno = 2023;
    expect($model->appliesForYear(2023))->toBeTrue();
    expect($model->appliesForYear(2024))->toBeFalse();

    $model->anno = null;
    expect($model->appliesForYear(2023))->toBeTrue(); // Null means all years
});

test('scope for enabled criteria works', function () {
    $query = CriteriEsclusione::query()->enabled();

    $sql = $query->toSql();
    expect($sql)->toContain('is_enabled = ?');

    $bindings = $query->getBindings();
    expect($bindings)->toContain(1);
});

test('scope for specific year works', function () {
    $query = CriteriEsclusione::query()->forYear(2023);

    $sql = $query->toSql();
    expect($sql)->toContain('anno = ?');

    $bindings = $query->getBindings();
    expect($bindings)->toContain(2023);
});

test('scope for criteria type works', function () {
    $query = CriteriEsclusione::query()->ofType('absence');

    $sql = $query->toSql();
    expect($sql)->toContain('type = ?');

    $bindings = $query->getBindings();
    expect($bindings)->toContain('absence');
});

it('can convert to array for API responses', function () {
    $model = new CriteriEsclusione;
    $model->id = 1;
    $model->name = 'Test Criteria';
    $model->field_name = 'test_field';
    $model->op = '>';
    $model->value = '10';
    $model->type = 'test';
    $model->anno = 2023;
    $model->is_enabled = true;

    $array = $model->toArray();

    expect($array)->toBeArray();
    expect($array)->toHaveKey('id', 1);
    expect($array)->toHaveKey('name', 'Test Criteria');
    expect($array)->toHaveKey('field_name', 'test_field');
    expect($array)->toHaveKey('op', '>');
    expect($array)->toHaveKey('value', '10');
    expect($array)->toHaveKey('type', 'test');
    expect($array)->toHaveKey('anno', 2023);
    expect($array)->toHaveKey('is_enabled', true);
    expect($array)->toHaveKey('is_enabled_description');
});
