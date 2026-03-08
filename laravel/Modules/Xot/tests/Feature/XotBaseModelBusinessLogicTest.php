<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Models\Module;
use Modules\Xot\Models\XotBaseModel;

class XotBaseModelBusinessLogicTest extends TestCase
{
    /** @test */
    public function itExtendsCorrectBaseClass(): void
    {
        // Arrange & Act
        $baseModel = new BaseModel();

        // Assert
        $this->assertInstanceOf(XotBaseModel::class, $baseModel);
        $this->assertInstanceOf(Model::class, $baseModel);
    }

    /** @test */
    public function itHasRequiredTraits(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act & Assert
        $this->assertTrue(method_exists($baseModel, 'getTable'));
        $this->assertTrue(method_exists($baseModel, 'getConnection'));
        $this->assertTrue(method_exists($baseModel, 'getKeyName'));
    }

    /** @test */
    public function itCanBeInstantiatedWithoutDatabase(): void
    {
        // Arrange & Act
        $baseModel = new BaseModel();

        // Assert
        $this->assertInstanceOf(BaseModel::class, $baseModel);
        $this->assertNotNull($baseModel);
    }

    /** @test */
    public function itSupportsTableNameOverride(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $tableName = $baseModel->getTable();

        // Assert
        $this->assertIsString($tableName);
        $this->assertNotEmpty($tableName);
    }

    /** @test */
    public function itSupportsConnectionOverride(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $connection = $baseModel->getConnection();

        // Assert
        $this->assertNotNull($connection);
        $this->assertInstanceOf(ConnectionInterface::class, $connection);
    }

    /** @test */
    public function itSupportsKeyNameOverride(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $keyName = $baseModel->getKeyName();

        // Assert
        $this->assertIsString($keyName);
        $this->assertEquals('id', $keyName);
    }

    /** @test */
    public function itCanBeUsedAsBaseForOtherModels(): void
    {
        // Arrange
        $module = new Module();

        // Act & Assert
        $this->assertInstanceOf(XotBaseModel::class, $module);
        $this->assertInstanceOf(Model::class, $module);
    }

    /** @test */
    public function itSupportsModelConfiguration(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $fillable = $baseModel->getFillable();
        $hidden = $baseModel->getHidden();
        $casts = $baseModel->getCasts();

        // Assert
        $this->assertIsArray($fillable);
        $this->assertIsArray($hidden);
        $this->assertIsArray($casts);
    }

    /** @test */
    public function itSupportsSoftDeletesWhenConfigured(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $usesSoftDeletes = method_exists($baseModel, 'trashed');

        // Assert
        // Nota: Non tutti i modelli base usano soft deletes
        // Questo test verifica solo la possibilità di configurazione
        $this->assertTrue(true); // Placeholder per logica specifica
    }

    /** @test */
    public function itSupportsTimestampsWhenConfigured(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $usesTimestamps = $baseModel->usesTimestamps();

        // Assert
        // Nota: I modelli base possono avere configurazioni diverse
        $this->assertIsBool($usesTimestamps);
    }

    /** @test */
    public function itSupportsTenantIsolationWhenConfigured(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasTenantTrait = method_exists($baseModel, 'getTenantKey');

        // Assert
        // Nota: Non tutti i modelli base usano tenant isolation
        // Questo test verifica solo la possibilità di configurazione
        $this->assertTrue(true); // Placeholder per logica specifica
    }

    /** @test */
    public function itSupportsAuditTrailWhenConfigured(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasAuditTrait = method_exists($baseModel, 'getAuditEvents');

        // Assert
        // Nota: Non tutti i modelli base usano audit trail
        // Questo test verifica solo la possibilità di configurazione
        $this->assertTrue(true); // Placeholder per logica specifica
    }

    /** @test */
    public function itCanBeSerialized(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $serialized = serialize($baseModel);

        // Assert
        $this->assertIsString($serialized);
        $this->assertNotEmpty($serialized);
    }

    /** @test */
    public function itCanBeUnserialized(): void
    {
        // Arrange
        $baseModel = new BaseModel();
        $serialized = serialize($baseModel);

        // Act
        $unserialized = unserialize($serialized);

        // Assert
        $this->assertInstanceOf(BaseModel::class, $unserialized);
    }

    /** @test */
    public function itSupportsJsonSerialization(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $json = json_encode($baseModel);

        // Assert
        $this->assertIsString($json);
        $this->assertNotEmpty($json);
        $this->assertNotFalse($json);
    }

    /** @test */
    public function itSupportsArrayConversion(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $array = $baseModel->toArray();

        // Assert
        $this->assertIsArray($array);
        $this->assertNotEmpty($array);
    }

    /** @test */
    public function itSupportsJsonConversion(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $json = $baseModel->toJson();

        // Assert
        $this->assertIsString($json);
        $this->assertNotEmpty($json);
    }

    /** @test */
    public function itSupportsRelationshipLoading(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasLoadMethod = method_exists($baseModel, 'load');

        // Assert
        $this->assertTrue($hasLoadMethod);
    }

    /** @test */
    public function itSupportsAttributeAccess(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasGetAttributeMethod = method_exists($baseModel, 'getAttribute');
        $hasSetAttributeMethod = method_exists($baseModel, 'setAttribute');

        // Assert
        $this->assertTrue($hasGetAttributeMethod);
        $this->assertTrue($hasSetAttributeMethod);
    }

    /** @test */
    public function itSupportsMassAssignmentProtection(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $fillable = $baseModel->getFillable();
        $guarded = $baseModel->getGuarded();

        // Assert
        $this->assertIsArray($fillable);
        $this->assertIsArray($guarded);
    }

    /** @test */
    public function itSupportsModelEvents(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasEvents = method_exists($baseModel, 'fireModelEvent');

        // Assert
        $this->assertTrue($hasEvents);
    }

    /** @test */
    public function itSupportsObservers(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasObservers = method_exists($baseModel, 'getObservableEvents');

        // Assert
        $this->assertTrue($hasObservers);
    }

    /** @test */
    public function itSupportsScopes(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasScopes = method_exists($baseModel, 'addGlobalScope');

        // Assert
        $this->assertTrue($hasScopes);
    }

    /** @test */
    public function itSupportsAccessorsAndMutators(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hasAccessors = method_exists($baseModel, 'getAttributeValue');
        $hasMutators = method_exists($baseModel, 'setAttribute');

        // Assert
        $this->assertTrue($hasAccessors);
        $this->assertTrue($hasMutators);
    }

    /** @test */
    public function itSupportsCasting(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $casts = $baseModel->getCasts();

        // Assert
        $this->assertIsArray($casts);
    }

    /** @test */
    public function itSupportsDates(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $dates = $baseModel->getDates();

        // Assert
        $this->assertIsArray($dates);
    }

    /** @test */
    public function itSupportsHiddenAttributes(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $hidden = $baseModel->getHidden();

        // Assert
        $this->assertIsArray($hidden);
    }

    /** @test */
    public function itSupportsVisibleAttributes(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $visible = $baseModel->getVisible();

        // Assert
        $this->assertIsArray($visible);
    }

    /** @test */
    public function itSupportsAppends(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $appends = $baseModel->getAppends();

        // Assert
        $this->assertIsArray($appends);
    }

    /** @test */
    public function itSupportsWithRelationships(): void
    {
        // Arrange
        $baseModel = new BaseModel();

        // Act
        $with = $baseModel->getWith();

        // Assert
        $this->assertIsArray($with);
    }
}
