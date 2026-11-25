<?php

declare(strict_types=1);

use Modules\Xot\Tests\Fixtures\Models\TestConcreteXotBaseModel;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

test('tableMorphMany filters the related rows by the owner table name', function (): void {
    // Arrange
    $owner = new TestConcreteXotBaseModel;
    $owner->setTable('lett_f');

    // Act
    $relation = $owner->tableMorphMany(TestConcreteXotBaseModel::class);

    // Assert
    expect($relation->getForeignKeyName())->toBe('id_tbl');
    expect($relation->getQuery()->toBase()->wheres)->toContain(
        ['type' => 'Basic', 'column' => 'tbl', 'operator' => '=', 'value' => 'lett_f', 'boolean' => 'and'],
    );
});

test('tableMorphMany accepts custom discriminator and key columns', function (): void {
    // Arrange
    $owner = new TestConcreteXotBaseModel;
    $owner->setTable('performance_x');

    // Act
    $relation = $owner->tableMorphMany(TestConcreteXotBaseModel::class, 'tipo', 'owner_id');

    // Assert
    expect($relation->getForeignKeyName())->toBe('owner_id');
    expect($relation->getQuery()->toBase()->wheres)->toContain(
        ['type' => 'Basic', 'column' => 'tipo', 'operator' => '=', 'value' => 'performance_x', 'boolean' => 'and'],
    );
});
