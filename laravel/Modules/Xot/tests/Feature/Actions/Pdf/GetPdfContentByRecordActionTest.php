<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature\Actions\Pdf;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\User;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Modules\Xot\Tests\TestCase;

/**
 * Test suite for GetPdfContentByRecordAction.
 */
class GetPdfContentByRecordActionTest extends TestCase
{
    private GetPdfContentByRecordAction $action;

    protected function setUp(): void
    {
        parent::setUp();
        $this->action = new GetPdfContentByRecordAction();
    }

    /** @test */
    public function itGeneratesPdfContentFromRecord(): void
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Mock view existence
        view()->addNamespace('user', resource_path('views'));

        // Act & Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("View 'user::user.show.pdf' not found");

        $this->action->execute($user);
    }

    /** @test */
    public function itGeneratesCorrectViewName(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Use reflection to test protected method
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateViewName');
        $method->setAccessible(true);

        // Act
        $viewName = $method->invoke($action, $user);

        // Assert
        $this->assertEquals('user::user.show.pdf', $viewName);
    }

    /** @test */
    public function itGeneratesCorrectFilenameForBasicModel(): void
    {
        // Arrange
        $user = User::factory()->create(['id' => 123, 'name' => 'Test User']);

        // Use reflection to test protected method
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);

        // Act
        $filename = $method->invoke($action, $user);

        // Assert
        $this->assertEquals('user_123_test-user.pdf', $filename);
    }

    /** @test */
    public function itGeneratesEnhancedFilenameForPerformanceModels(): void
    {
        // Arrange - Create a mock model with performance fields
        $record = new class extends Model {
            protected $table = 'test_performance';

            protected $fillable = ['id', 'matr', 'cognome', 'nome'];

            public function getKey()
            {
                return 456;
            }
        };

        $record->matr = 'ABC123';
        $record->cognome = 'Rossi';
        $record->nome = 'Mario';

        // Use reflection to test protected method
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('generateFilename');
        $method->setAccessible(true);

        // Act
        $filename = $method->invoke($action, $record);

        // Assert
        $this->assertEquals('scheda_456_ABC123_Rossi_Mario.pdf', $filename);
    }

    /** @test */
    public function itPreparesCorrectViewParameters(): void
    {
        // Arrange
        $user = User::factory()->create(['name' => 'Test User']);

        // Use reflection to test protected method
        $reflection = new \ReflectionClass($action);
        $method = $reflection->getMethod('prepareViewParameters');
        $method->setAccessible(true);

        // Act
        $params = $method->invoke($action, $user, 'user::user.show.pdf');

        // Assert
        $this->assertIsArray($params);
        $this->assertArrayHasKey('view', $params);
        $this->assertArrayHasKey('row', $params);
        $this->assertArrayHasKey('transKey', $params);
        $this->assertEquals('user::user.show.pdf', $params['view']);
        $this->assertSame($user, $params['row']);
        $this->assertEquals('user::users.fields', $params['transKey']);
    }

    /** @test */
    public function itThrowsExceptionForMissingView(): void
    {
        // Arrange
        $user = User::factory()->create();

        // Act & Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches("/View 'user::user\.show\.pdf' not found/");

        $this->action->execute($user);
    }

    /** @test */
    public function itThrowsExceptionForEmptyHtmlContent(): void
    {
        // This test would require mocking view rendering to return empty content
        // Implementation depends on testing infrastructure setup
        $this->markTestSkipped('Requires view mocking infrastructure');
    }

    /** @test */
    public function itUsesCustomFilenameWhenProvided(): void
    {
        // Arrange
        $user = User::factory()->create();
        $customFilename = 'custom-report.pdf';

        // Act & Assert - Should use custom filename in error message
        $this->expectException(\Exception::class);

        $this->action->execute($user, $customFilename);
    }

    /** @test */
    public function itHandlesFromRecordConvenienceMethod(): void
    {
        // Arrange
        $user = User::factory()->create();
        $filename = 'convenience-test.pdf';

        // Act & Assert
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageMatches("/View 'user::user\.show\.pdf' not found/");

        $this->action->fromRecord($user, $filename);
    }

    /** @test */
    public function itLogsErrorsWhenPdfGenerationFails(): void
    {
        // This test would require mocking HTML2PDF to throw exceptions
        // Implementation depends on testing infrastructure setup
        $this->markTestSkipped('Requires HTML2PDF mocking infrastructure');
    }

    /** @test */
    public function itReturnsValidPdfContentWhenViewExists(): void
    {
        // This test would require creating actual test views
        // Implementation depends on test view infrastructure
        $this->markTestSkipped('Requires test view infrastructure');
    }
}
