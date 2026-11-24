<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function () {
    $this->model = new TestSushiModel;
    $this->testJsonPath = storage_path('tests/sushi-json/test_sushi.json');

    // Pulisce eventuali file di test esistenti
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    // Rimuove la directory se esiste
    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});

afterEach(function () {
    // Pulisce i file di test
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }

    Mockery::close();
});

/**
 * Invoca il metodo Eloquent protetto fireModelEvent per simulare gli eventi del ciclo di vita.
 */
function fireSushiModelEvent(TestSushiModel $model, string $event): void
{
    $method = new ReflectionMethod($model, 'fireModelEvent');
    $method->setAccessible(true);
    $method->invoke($model, $event);
}

it('returns correct json file path', function (): void {
    $expectedPath = storage_path('tests/sushi-json/test_sushi.json');
    $actualPath = $this->model->getJsonFile();

    expect($actualPath)->toBe($expectedPath);
});

it('returns empty array when json file not exists', function (): void {
    $rows = $this->model->getSushiRows();

    expect($rows)->toBe([]);
});

it('throws exception when json data is invalid', function (): void {
    // Crea un file JSON con dati non validi come array di record
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, '"just a string"');

    expect(fn () => $this->model->getSushiRows())
        ->toThrow(Exception::class, 'Data is not array ['.$this->testJsonPath.']');
});

it('loads valid json data correctly', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key' => 'value1'],
        ],
        '2' => [
            'id' => 2,
            'name' => 'Test Item 2',
            'description' => 'Description 2',
            'status' => 'inactive',
            'metadata' => ['key' => 'value2'],
        ],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();

    expect($rows)->toBe($testData);
});

it('normalizes nested arrays in json data', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item',
            'metadata' => ['nested' => ['deep' => 'value']],
            'tags' => ['tag1', 'tag2'],
        ],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();
    $row = $this->jsonRecordAt($rows, '1');

    $metadata = $row['metadata'] ?? null;
    $tags = $row['tags'] ?? null;
    Assert::assertIsString($metadata);
    Assert::assertIsString($tags);

    Assert::assertSame(['nested' => ['deep' => 'value']], json_decode($metadata, true));
    Assert::assertSame(['tag1', 'tag2'], json_decode($tags, true));
});

it('saves data to json file successfully', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Test Item'],
        '2' => ['id' => 2, 'name' => 'Another Item'],
    ];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();
    expect(File::exists($this->testJsonPath))->toBeTrue();

    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);
    Assert::assertIsArray($savedData);

    expect($savedData)->toBe($testData);
});

it('creates directory if not exists when saving', function (): void {
    $testData = ['1' => ['id' => 1, 'name' => 'Test']];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();
    expect(File::exists(dirname($this->testJsonPath)))->toBeTrue();
    expect(File::exists($this->testJsonPath))->toBeTrue();
});

it('returns false when saving fails', function (): void {
    // Mock del metodo getJsonFile per simulare un errore
    /** @var TestSushiModel&MockInterface $mockModel */
    $mockModel = Mockery::mock(TestSushiModel::class)->makePartial();
    $mockModel->shouldReceive('getJsonFile')->andReturn('/invalid/path/that/cannot/be/created');

    $result = $mockModel->saveToJson([['test' => 'data']]);

    expect($result)->toBeFalse();
});

it('loads existing data correctly', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Existing Item'],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $existingData = $this->model->loadExistingData();

    expect($existingData)->toBe($testData);
});

it('returns empty array when no existing data', function (): void {
    $existingData = $this->model->loadExistingData();

    expect($existingData)->toBe([]);
});

it('returns next available id correctly', function (): void {
    // Test con dati esistenti
    $testData = [
        '1' => ['id' => 1, 'name' => 'Item 1'],
        '5' => ['id' => 5, 'name' => 'Item 5'],
        '10' => ['id' => 10, 'name' => 'Item 10'],
    ];

    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $nextId = $this->model->getNextId();

    expect($nextId)->toBe(11);
});

it('returns id 1 when no existing data', function (): void {
    $nextId = $this->model->getNextId();

    expect($nextId)->toBe(1);
});

it('returns auth id when user is authenticated', function (): void {
    Auth::shouldReceive('id')->once()->andReturn(123);

    $authId = $this->model->authId();

    expect($authId)->toBe(123);
});

it('returns null when user is not authenticated', function (): void {
    Auth::shouldReceive('id')->once()->andReturn(null);

    $authId = $this->model->authId();

    expect($authId)->toBeNull();
});

it('handles creating event correctly', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Existing Item'],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Mock dell'utente autenticato
    Auth::shouldReceive('id')->andReturn(456);

    // Crea un nuovo modello
    $newModel = new TestSushiModel;
    $newModel->name = 'New Item';
    $newModel->description = 'New Description';

    // Simula l'evento creating
    fireSushiModelEvent($newModel, 'creating');

    // Verifica che i dati siano stati salvati nel file JSON
    expect(File::exists($this->testJsonPath))->toBeTrue();

    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);
    Assert::assertIsArray($savedData);

    expect($savedData)->toHaveKey('2'); // Nuovo ID dovrebbe essere 2
    $newRow = $this->jsonRecordAt($savedData, '2');
    Assert::assertSame('New Item', $newRow['name'] ?? null);
    Assert::assertSame(456, $newRow['created_by'] ?? null);
    Assert::assertSame(456, $newRow['updated_by'] ?? null);
});

it('handles updating event correctly', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Original Name',
            'description' => 'Original Description',
            'created_at' => now()->subDay()->toISOString(),
            'updated_at' => now()->subDay()->toISOString(),
        ],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Mock dell'utente autenticato
    Auth::shouldReceive('id')->andReturn(789);

    // Carica il modello esistente
    $existingModel = new TestSushiModel;
    $existingModel->id = 1;
    $existingModel->name = 'Updated Name';
    $existingModel->description = 'Updated Description';

    // Simula l'evento updating
    fireSushiModelEvent($existingModel, 'updating');

    // Verifica che i dati siano stati aggiornati nel file JSON
    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);
    Assert::assertIsArray($savedData);

    $updatedRow = $this->jsonRecordAt($savedData, '1');
    Assert::assertSame('Updated Name', $updatedRow['name'] ?? null);
    Assert::assertSame('Updated Description', $updatedRow['description'] ?? null);
    Assert::assertSame(789, $updatedRow['updated_by'] ?? null);
});

it('handles deleting event correctly', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Item to Delete'],
        '2' => ['id' => 2, 'name' => 'Item to Keep'],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Carica il modello da eliminare
    $modelToDelete = new TestSushiModel;
    $modelToDelete->id = 1;

    // Simula l'evento deleting
    fireSushiModelEvent($modelToDelete, 'deleting');

    // Verifica che il record sia stato rimosso dal file JSON
    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);
    Assert::assertIsArray($savedData);

    expect($savedData)->not->toHaveKey('1');
    expect($savedData)->toHaveKey('2');
    $keptRow = $this->jsonRecordAt($savedData, '2');
    Assert::assertSame('Item to Keep', $keptRow['name'] ?? null);
});

it('works with sushi package integration', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Sushi Item 1',
            'description' => 'Description 1',
            'status' => 'active',
        ],
        '2' => [
            'id' => 2,
            'name' => 'Sushi Item 2',
            'description' => 'Description 2',
            'status' => 'inactive',
        ],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0o755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Testa l'integrazione con Sushi
    $rows = $this->model->getSushiRows();

    expect($rows)->toBe($testData);
    expect($rows)->toHaveCount(2);
    $row1 = $this->jsonRecordAt($rows, '1');
    $row2 = $this->jsonRecordAt($rows, '2');
    Assert::assertSame('Sushi Item 1', $row1['name'] ?? null);
    Assert::assertSame('Sushi Item 2', $row2['name'] ?? null);
});
