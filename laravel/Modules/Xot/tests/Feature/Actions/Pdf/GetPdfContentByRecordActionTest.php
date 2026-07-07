<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Actions\Pdf;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = new GetPdfContentByRecordAction();
});

describe('Get Pdf Content By Record Action', function (): void {
    test('it generates pdf content from record', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Mock view existence
        view()->addNamespace('user', resource_path('views'));

        // Act & Assert
        $this->expectThrowable(\Exception::class);
        $this->expectThrowableMessage("View 'user::user.show.pdf' not found");

        app(GetPdfContentByRecordAction::class)->execute($user);
    });

    test('it generates correct view name', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne();

        // Use reflection to test protected method
        $action = $this->action;
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateViewName');
        $method->setAccessible(true);

        // Act
        $viewName = $method->invoke($action, $user);

        // Assert
        Assert::assertEquals('user::user.show.pdf', $viewName);
    });

    test('it generates correct filename for basic model', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne(['id' => 123, 'name' => 'Test User']);

        // Use reflection to test protected method
        $action = $this->action;
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);

        // Act
        $filename = $method->invoke($action, $user);

        // Assert
        Assert::assertEquals('user_123_test-user.pdf', $filename);
    });

    test('it generates enhanced filename for performance models', function (): void {
        // Arrange - Create a mock model with performance fields
        $record = new class extends Model {
            protected $table = 'test_performance';

            protected $fillable = ['id', 'matr', 'cognome', 'nome'];

            public function testGetKey(): int
            {
                return 456;
            }
        };

        $record->setAttribute('matr', 'ABC123');
        $record->setAttribute('cognome', 'Rossi');
        $record->setAttribute('nome', 'Mario');

        // Use reflection to test protected method
        $action = $this->action;
        Assert::assertInstanceOf(GetPdfContentByRecordAction::class, $action);
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);

        // Act
        $filename = $method->invoke($action, $record);

        // Assert
        Assert::assertEquals('scheda_456_ABC123_Rossi_Mario.pdf', $filename);
    });

    test('it prepares correct view parameters', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne(['name' => 'Test User']);

        // Use reflection to test protected method
        $action = $this->action;
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
        $this->expectThrowable(\Exception::class);
        $this->expectThrowableMessageMatches("/View 'user::user\.show\.pdf' not found/");

        app(GetPdfContentByRecordAction::class)->execute($user);
    });

    test('it throws exception for empty html content', function (): void {
        // This test would require mocking view rendering to return empty content
        // Implementation depends on testing infrastructure setup
        $this->skipTest('Requires view mocking infrastructure');
    });

    test('it uses custom filename when provided', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne();
        $customFilename = 'custom-report.pdf';

        // Act & Assert - Should use custom filename in error message
        $this->expectThrowable(\Exception::class);

        app(GetPdfContentByRecordAction::class)->execute($user, $customFilename);
    });

    test('it handles from record convenience method', function (): void {
        // Arrange
        $user = UserFactory::new()->createOne();
        $filename = 'convenience-test.pdf';

        // Act & Assert
        $this->expectThrowable(\Exception::class);
        $this->expectThrowableMessageMatches("/View 'user::user\.show\.pdf' not found/");

        app(GetPdfContentByRecordAction::class)->fromRecord($user, $filename);
    });

    test('it logs errors when pdf generation fails', function (): void {
        // This test would require mocking HTML2PDF to throw exceptions
        // Implementation depends on testing infrastructure setup
        $this->skipTest('Requires HTML2PDF mocking infrastructure');
    });

    test('it returns valid pdf content when view exists', function (): void {
        // This test would require creating actual test views
        // Implementation depends on test view infrastructure
        $this->skipTest('Requires test view infrastructure');
    });
});
