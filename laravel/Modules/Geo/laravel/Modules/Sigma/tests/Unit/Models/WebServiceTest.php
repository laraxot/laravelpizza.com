<?php

declare(strict_types=1);

namespace Modules\Sigma\Tests\Unit\Models;

use Illuminate\Support\Facades\File;
use Modules\Sigma\Tests\TestModels\TestWebService;
use Tests\TestCase;

/**
 * @covers \Modules\Sigma\Models\WebService
 */
class WebServiceTest extends TestCase
{
    protected string $csvPath;

    protected string $testCsvPath;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up a test CSV directory in the test directory
        $this->csvPath = __DIR__.'/testdata';
        $this->testCsvPath = $this->csvPath.'/web_services.csv';

        // Ensure the directory exists
        if (! File::exists($this->csvPath)) {
            File::makeDirectory($this->csvPath, 0755, true);
        }

        // Initialize the test CSV file with header
        if (! File::exists($this->testCsvPath)) {
            File::put($this->testCsvPath, "id,name,endpoint,description,is_active,created_at,updated_at,created_by,updated_by\n");
        }

        // Set the test CSV path for our test model
        TestWebService::setTestCsvPath($this->testCsvPath);

        // Clear the Sushi cache
        if (File::exists(storage_path('framework/cache/sushi'))) {
            File::cleanDirectory(storage_path('framework/cache/sushi'));
        }

        // Clear the model cache between tests
        TestWebService::clearBootedModels();
    }

    protected function tearDown(): void
    {
        // Clean up the test CSV file
        if (File::exists($this->testCsvPath)) {
            File::delete($this->testCsvPath);
        }

        // Clean up the test directory if empty
        if (File::exists($this->csvPath) && is_dir($this->csvPath)) {
            // Remove all files in the directory
            $files = glob($this->csvPath.'/*');
            foreach ($files as $file) {
                if (! (is_file($file))) {
                    continue;
                }

                File::delete($file);
            }

            // Remove the directory if it's empty
            if (count(glob($this->csvPath.'/*')) === 0) {
                File::deleteDirectory($this->csvPath);
            }
        }

        // Clear the Sushi cache
        if (File::exists(storage_path('framework/cache/sushi'))) {
            File::cleanDirectory(storage_path('framework/cache/sushi'));
        }

        parent::tearDown();
    }

    /** @test */
    public function it_can_be_instantiated_with_attributes(): void
    {
        $service = new TestWebService([
            'name' => 'Test Service',
            'endpoint' => 'https://api.example.com',
            'is_active' => true,
        ]);

        $this->assertInstanceOf(TestWebService::class, $service);
        $this->assertEquals('Test Service', $service->name);
        $this->assertEquals('https://api.example.com', $service->endpoint);
        $this->assertTrue($service->is_active);
    }

    /** @test */
    public function it_has_fillable_attributes(): void
    {
        $service = new TestWebService;
        $fillable = $service->getFillable();

        $this->assertContains('name', $fillable);
        $this->assertContains('endpoint', $fillable);
        $this->assertContains('description', $fillable);
        $this->assertContains('is_active', $fillable);
    }

    /** @test */
    public function it_has_casts_defined(): void
    {
        $service = new TestWebService;
        $casts = $service->getCasts();

        $this->assertArrayHasKey('is_active', $casts);
        $this->assertEquals('boolean', $casts['is_active']);
        $this->assertArrayHasKey('created_at', $casts);
        $this->assertEquals('datetime', $casts['created_at']);
        $this->assertArrayHasKey('updated_at', $casts);
        $this->assertEquals('datetime', $casts['updated_at']);
    }

    /** @test */
    public function it_returns_validation_rules(): void
    {
        $rules = TestWebService::rules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertContains('required', $rules['name']);
        $this->assertContains('string', $rules['name']);

        $this->assertArrayHasKey('endpoint', $rules);
        $this->assertContains('required', $rules['endpoint']);
        $this->assertContains('url', $rules['endpoint']);

        $this->assertArrayHasKey('is_active', $rules);
        $this->assertContains('boolean', $rules['is_active']);
    }

    /** @test */
    public function it_can_save_and_retrieve_web_service(): void
    {
        // Create a new service
        $service = new TestWebService([
            'name' => 'Test Service',
            'endpoint' => 'https://api.example.com',
            'description' => 'A test service',
            'is_active' => true,
        ]);

        // Save the service
        $saved = $service->save();
        $this->assertTrue($saved);

        // Verify the CSV file was created and has content
        $this->assertFileExists($this->testCsvPath);
        $csvContent = File::get($this->testCsvPath);
        $lines = array_filter(explode("\n", $csvContent), 'strlen');

        // Should have header + 1 data row
        $this->assertGreaterThanOrEqual(2, count($lines));

        // Check if the data was saved correctly
        $header = str_getcsv($lines[0]);
        $data = str_getcsv($lines[1]);
        $data = array_combine($header, $data);

        $this->assertEquals('Test Service', $data['name']);
        $this->assertEquals('https://api.example.com', $data['endpoint']);
        $this->assertEquals('A test service', $data['description']);
        $this->assertEquals('1', $data['is_active']);

        // Test retrieving the service
        $retrieved = TestWebService::first();
        $this->assertNotNull($retrieved);
        $this->assertEquals('Test Service', $retrieved->name);
        $this->assertEquals('https://api.example.com', $retrieved->endpoint);
        $this->assertTrue($retrieved->is_active);
    }
}
