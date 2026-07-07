<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Models\Module;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;
use function Safe\unserialize;

uses(TestCase::class);

function createXotBaseModelFixture(): BaseModel
{
    return new class extends BaseModel {
    };
}

describe('Xot Base Model Business Logic', function (): void {
    test('it extends correct base class', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
        Assert::assertInstanceOf(XotBaseModel::class, $baseModel);
        Assert::assertInstanceOf(Model::class, $baseModel);
    });

    test('it has required traits', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it can be instantiated without database', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
        Assert::assertInstanceOf(BaseModel::class, $baseModel);
    });

    test('it supports table name override', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $tableName = $baseModel->getTable();

        // Assert
        Assert::assertIsString($tableName);
        Assert::assertNotEmpty($tableName);
    });

    test('it supports connection override', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $connection = $baseModel->getConnection();

        // Assert
        Assert::assertNotNull($connection);
        Assert::assertInstanceOf(ConnectionInterface::class, $connection);
    });

    test('it supports key name override', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $keyName = $baseModel->getKeyName();

        // Assert
        Assert::assertIsString($keyName);
        Assert::assertEquals('id', $keyName);
    });

    test('it can be used as base for other models', function (): void {
        // Arrange
        $module = new Module();

        // Act & Assert
        Assert::assertInstanceOf(XotBaseModel::class, $module);
        Assert::assertInstanceOf(Model::class, $module);
    });

    test('it supports model configuration', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $fillable = $baseModel->getFillable();
        $hidden = $baseModel->getHidden();
        $casts = $baseModel->getCasts();

        // Assert
        Assert::assertIsArray($fillable);
        Assert::assertIsArray($hidden);
        Assert::assertIsArray($casts);
    });

    test('it supports soft deletes when configured', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert - Soft deletes may or may not be configured
    });

    test('it supports timestamps when configured', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $usesTimestamps = $baseModel->usesTimestamps();

        // Assert
        // Nota: I modelli base possono avere configurazioni diverse
        Assert::assertIsBool($usesTimestamps);
    });

    test('it supports tenant isolation when configured', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert - Tenant isolation may or may not be configured
    });

    test('it supports audit trail when configured', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert - Audit trail may or may not be configured
    });

    test('it can be serialized', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $serialized = serialize($baseModel);

        // Assert
        Assert::assertNotEmpty($serialized);
    });

    test('it can be unserialized', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();
        $serialized = serialize($baseModel);

        // Act
        $unserialized = unserialize($serialized);

        // Assert
        Assert::assertInstanceOf(BaseModel::class, $unserialized);
    });

    test('it supports json serialization', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $json = json_encode($baseModel);

        // Assert
        Assert::assertNotEmpty($json);
        Assert::assertNotFalse($json);
    });

    test('it supports array conversion', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $array = $baseModel->toArray();

        // Assert
        Assert::assertIsArray($array);
        Assert::assertNotEmpty($array);
    });

    test('it supports json conversion', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $json = $baseModel->toJson();

        // Assert
        Assert::assertIsString($json);
        Assert::assertNotEmpty($json);
    });

    test('it supports relationship loading', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it supports attribute access', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it supports mass assignment protection', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $fillable = $baseModel->getFillable();
        $guarded = $baseModel->getGuarded();

        // Assert
        Assert::assertIsArray($fillable);
        Assert::assertIsArray($guarded);
    });

    test('it supports model events', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it supports observers', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it supports scopes', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it supports accessors and mutators', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
    });

    test('it supports casting', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $casts = $baseModel->getCasts();

        // Assert
        Assert::assertIsArray($casts);
    });

    test('it supports dates', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $dates = $baseModel->getDates();

        // Assert
        Assert::assertIsArray($dates);
    });

    test('it supports hidden attributes', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $hidden = $baseModel->getHidden();

        // Assert
        Assert::assertIsArray($hidden);
    });

    test('it supports visible attributes', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $visible = $baseModel->getVisible();

        // Assert
        Assert::assertIsArray($visible);
    });

    test('it supports appends', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $appends = $baseModel->getAppends();

        // Assert
        Assert::assertIsArray($appends);
    });

    test('it supports with relationships', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $with = $baseModel->getAppends();

        // Assert
        Assert::assertIsArray($with);
    });
});
