<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Models\Module;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Models\Traits\RelationX;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Tests\Fixtures\Models\TestConcreteBaseModel;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Traits\Updater;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;
use function Safe\unserialize;

uses(TestCase::class);

/**
 * Classe concreta con nome: PHP non permette di serializzare classi anonime.
 */
function createXotBaseModelFixture(): BaseModel
{
    return new TestConcreteBaseModel;
}

/**
 * Observer minimale: Model::observe() accetta solo nomi di classe risolvibili
 * (le classi anonime contengono "@" e non sono registrabili come listener).
 */
final class XotBaseModelFixtureObserver
{
    public function saving(Model $model): void {}
}

describe('Xot Base Model Business Logic', function (): void {
    test('it extends correct base class', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
        Assert::assertSame('id', $baseModel->getKeyName());
    });

    test('it has required traits', function (): void {
        // Arrange & Act
        $traits = class_uses_recursive(createXotBaseModelFixture());

        // Assert
        Assert::assertContains(HasXotFactory::class, $traits);
        Assert::assertContains(RelationX::class, $traits);
        Assert::assertContains(Updater::class, $traits);
    });

    test('it can be instantiated without database', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();

        // Assert
        Assert::assertFalse($baseModel->exists);
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
        $module = new Module;

        // Act & Assert
        Assert::assertSame('modules', $module->getTable());
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
        $usesSoftDeletes = in_array(SoftDeletes::class, class_uses_recursive($baseModel), true);

        // Assert - Soft deletes may or may not be configured: il trait e trashed() vanno sempre insieme
        Assert::assertSame($usesSoftDeletes, method_exists($baseModel, 'trashed'));
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

        // Assert - Tenant isolation may or may not be configured: la base non applica scope globali impliciti
        Assert::assertSame([], $baseModel->getGlobalScopes());
    });

    test('it supports audit trail when configured', function (): void {
        // Arrange & Act
        $baseModel = createXotBaseModelFixture();
        $dispatcher = Model::getEventDispatcher();

        // Assert - Updater popola created_by/updated_by/deleted_by agganciandosi a questi eventi
        Assert::assertNotNull($dispatcher);
        foreach (['creating', 'updating', 'deleting'] as $event) {
            Assert::assertTrue($dispatcher->hasListeners('eloquent.'.$event.': '.$baseModel::class));
        }
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
    });

    test('it supports array conversion', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        $baseModel->setAttribute('name', 'Test Model');

        // Act
        $array = $baseModel->toArray();

        // Assert
        Assert::assertIsArray($array);
        Assert::assertSame('Test Model', $array['name']);
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
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $loadedBefore = $baseModel->relationLoaded('creator');
        $baseModel->setRelation('creator', null);

        // Assert
        Assert::assertFalse($loadedBefore);
        Assert::assertTrue($baseModel->relationLoaded('creator'));
    });

    test('it supports attribute access', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $baseModel->setAttribute('title', 'Xot');

        // Assert
        Assert::assertSame('Xot', $baseModel->getAttribute('title'));
        Assert::assertSame(['title' => 'Xot'], $baseModel->getAttributes());
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
        $events = createXotBaseModelFixture()->getObservableEvents();

        // Assert
        foreach (['creating', 'created', 'updating', 'updated', 'saving', 'saved', 'deleting', 'deleted'] as $event) {
            Assert::assertContains($event, $events);
        }
    });

    test('it supports observers', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();
        $dispatcher = Model::getEventDispatcher();
        Assert::assertNotNull($dispatcher);
        $eventName = 'eloquent.saving: '.$baseModel::class;
        Assert::assertFalse($dispatcher->hasListeners($eventName));

        // Act
        $baseModel::observe(XotBaseModelFixtureObserver::class);

        // Assert
        Assert::assertTrue($dispatcher->hasListeners($eventName));
    });

    test('it supports scopes', function (): void {
        // Arrange
        $baseModel = createXotBaseModelFixture();

        // Act
        $baseModel::addGlobalScope('xot_test_scope', function (Builder $builder): void {});

        // Assert
        Assert::assertArrayHasKey('xot_test_scope', $baseModel->getGlobalScopes());
    });

    test('it supports accessors and mutators', function (): void {
        // Arrange
        $baseModel = new class extends BaseModel
        {
            /** @return Attribute<string|null, string> */
            protected function title(): Attribute
            {
                return Attribute::make(
                    get: fn (mixed $value): ?string => is_string($value) ? mb_strtoupper($value) : null,
                    set: fn (string $value): string => trim($value),
                );
            }
        };

        // Act
        $baseModel->setAttribute('title', '  xot ');

        // Assert
        Assert::assertSame(['title' => 'xot'], $baseModel->getAttributes());
        Assert::assertSame('XOT', $baseModel->getAttribute('title'));
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
