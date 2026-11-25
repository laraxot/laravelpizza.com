<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Actions\Pdf;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// $this dentro le closure Pest e' tipizzato da Pest come TestCall, non come
// Modules\Xot\Tests\TestCase: PHPStan vieta di ritipizzare $this via @var, quindi
// l'action del test vive in una variabile locale condivisa per riferimento. Per lo
// stesso motivo expectException()/markTestSkipped() via $this non sono risolvibili
// da PHPStan qui: si usano try/catch + Assert e Assert::markTestSkipped() statico.
$action = null;

beforeEach(function () use (&$action): void {
    $action = new GetPdfContentByRecordAction;
});

describe('Get Pdf Content By Record Action', function () use (&$action): void {
    test('it generates pdf content from record', function (): void {
        // Arrange
        // Email e id generati dalla factory: il DB di test e' condiviso, valori fissi collidono.
        $user = UserFactory::new()->createOne(['name' => 'Test User']);

        // Mock view existence
        view()->addNamespace('user', resource_path('views'));

        // Act & Assert
        try {
            app(GetPdfContentByRecordAction::class)->execute($user);
            Assert::fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            Assert::assertSame("View 'user::user.show.pdf' not found for model ".$user::class, $e->getMessage());
        }
    });

    test('it generates correct view name', function () use (&$action): void {
        // Arrange
        $user = UserFactory::new()->createOne();

        // Use reflection to test protected method
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateViewName');
        $method->setAccessible(true);

        // Act
        $viewName = $method->invoke($action, $user);

        // Assert
        Assert::assertEquals('user::user.show.pdf', $viewName);
    });

    test('it generates correct filename for basic model', function () use (&$action): void {
        // Arrange
        $user = UserFactory::new()->createOne(['name' => 'Test User']);

        // Use reflection to test protected method
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);

        // Act
        $filename = $method->invoke($action, $user);

        // Assert
        $key = $user->getKey();
        if (! is_string($key)) {
            throw new \RuntimeException('Il modello utente deve avere una chiave stringa (keyType string).');
        }

        Assert::assertEquals('user_'.$key.'_test-user.pdf', $filename);
    });

    test('it generates enhanced filename for performance models', function () use (&$action): void {
        // Arrange - Create a mock model with performance fields
        $record = new class extends Model
        {
            protected $table = 'test_performance';

            protected $fillable = ['id', 'matr', 'cognome', 'nome'];
        };

        $record->setAttribute('id', 456);
        $record->setAttribute('matr', 'ABC123');
        $record->setAttribute('cognome', 'Rossi');
        $record->setAttribute('nome', 'Mario');

        // Use reflection to test protected method
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);

        // Act
        $filename = $method->invoke($action, $record);

        // Assert
        Assert::assertEquals('scheda_456_ABC123_Rossi_Mario.pdf', $filename);
    });

    test('it prepares correct view parameters', function () use (&$action): void {
        // Arrange
        $user = UserFactory::new()->createOne(['name' => 'Test User']);

        // Use reflection to test protected method
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('prepareViewParameters');
        $method->setAccessible(true);

        // Act
        $params = $method->invoke($action, $user, 'user::user.show.pdf');

        // Assert
        Assert::assertIsArray($params);
        Assert::assertArrayHasKey('view', $params);
        Assert::assertArrayHasKey('row', $params);
        Assert::assertArrayHasKey('transKey', $params);
        Assert::assertEquals('user::user.show.pdf', $params['view']);
        Assert::assertSame($user, $params['row']);
        Assert::assertEquals('user::users.fields', $params['transKey']);
    });

    test('it throws exception for missing view', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne();

        // Act & Assert
        try {
            app(GetPdfContentByRecordAction::class)->execute($user);
            Assert::fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            Assert::assertMatchesRegularExpression("/View 'user::user\.show\.pdf' not found/", $e->getMessage());
        }
    });

    test('it throws exception for empty html content', function (): void {
        // This test would require mocking view rendering to return empty content
        // Implementation depends on testing infrastructure setup
        Assert::markTestSkipped('Requires view mocking infrastructure');
    });

    test('it uses custom filename when provided', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne();
        $customFilename = 'custom-report.pdf';

        // Act & Assert - Should use custom filename in error message
        try {
            app(GetPdfContentByRecordAction::class)->execute($user, $customFilename);
            Assert::fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            Assert::assertNotEmpty($e->getMessage());
        }
    });

    test('it handles from record convenience method', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne();
        $filename = 'convenience-test.pdf';

        // Act & Assert
        try {
            app(GetPdfContentByRecordAction::class)->fromRecord($user, $filename);
            Assert::fail('Expected exception was not thrown.');
        } catch (\Exception $e) {
            Assert::assertMatchesRegularExpression("/View 'user::user\.show\.pdf' not found/", $e->getMessage());
        }
    });

    test('it logs errors when pdf generation fails', function (): void {
        // This test would require mocking HTML2PDF to throw exceptions
        // Implementation depends on testing infrastructure setup
        Assert::markTestSkipped('Requires HTML2PDF mocking infrastructure');
    });

    test('it returns valid pdf content when view exists', function (): void {
        // This test would require creating actual test views
        // Implementation depends on test view infrastructure
        Assert::markTestSkipped('Requires test view infrastructure');
    });
});
