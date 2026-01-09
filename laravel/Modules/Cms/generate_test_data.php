<?php

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Modules\Cms\Database\Factories\ConfFactory;
use Modules\Cms\Database\Factories\MenuFactory;
use Modules\Cms\Database\Factories\ModuleFactory;
use Modules\Cms\Database\Factories\PageContentFactory;
use Modules\Cms\Database\Factories\PageFactory;
use Modules\Cms\Database\Factories\SectionFactory;
use Modules\Gdpr\Database\Factories\ConsentFactory;
use Modules\Gdpr\Database\Factories\EventFactory;
use Modules\Gdpr\Database\Factories\ProfileFactory;
use Modules\Gdpr\Database\Factories\TreatmentFactory;
use Modules\Lang\Database\Factories\PostFactory;
use Modules\Lang\Database\Factories\TranslationFactory;
use Modules\Lang\Database\Factories\TranslationFileFactory;
use Modules\Media\Database\Factories\MediaConvertFactory;
use Modules\Media\Database\Factories\MediaFactory;
use Modules\Media\Database\Factories\TemporaryUploadFactory;

/**
 * Test Data Generation Script
 * Creates 100 records for each business model using their factories.
 */

require_once __DIR__.'/laravel/vendor/autoload.php';

/** @var \Illuminate\Contracts\Foundation\Application $app */
$app = require_once __DIR__.'/laravel/bootstrap/app.php';
assert($app instanceof \Illuminate\Contracts\Foundation\Application);
$app->make(Kernel::class)->bootstrap();

class TestDataGenerator
{
    private array $businessModels = [
        '<main module>' => [
            'Patient' => 'Modules\<main module>\Database\Factories\PatientFactory',
            'Doctor' => 'Modules\<main module>\Database\Factories\DoctorFactory',
            'Admin' => 'Modules\<main module>\Database\Factories\AdminFactory',
            'Studio' => 'Modules\<main module>\Database\Factories\StudioFactory',
            'Appointment' => 'Modules\<main module>\Database\Factories\AppointmentFactory',
            'Report' => 'Modules\<main module>\Database\Factories\ReportFactory',
            'Profile' => 'Modules\<main module>\Database\Factories\ProfileFactory',
            'User' => 'Modules\<main module>\Database\Factories\UserFactory',
        ],
        'Cms' => [
            'Conf' => ConfFactory::class,
            'Menu' => MenuFactory::class,
            'Module' => ModuleFactory::class,
            'Page' => PageFactory::class,
            'PageContent' => PageContentFactory::class,
            'Section' => SectionFactory::class,
        ],
        'Gdpr' => [
            'Consent' => ConsentFactory::class,
            'Event' => EventFactory::class,
            'Profile' => ProfileFactory::class,
            'Treatment' => TreatmentFactory::class,
        ],
        'Lang' => [
            'Post' => PostFactory::class,
            'Translation' => TranslationFactory::class,
            'TranslationFile' => TranslationFileFactory::class,
        ],
        'Media' => [
            'Media' => MediaFactory::class,
            'MediaConvert' => MediaConvertFactory::class,
            'TemporaryUpload' => TemporaryUploadFactory::class,
        ],
    ];

    private array $results = [];

    public function generateTestData(): void
    {
        echo "🚀 Starting test data generation for business models...\n\n";

        foreach ($this->businessModels as $module => $models) {
            /** @var string $module */
            /** @var array<string, string> $models */
            echo "📦 Module: {$module}\n";

            foreach ($models as $modelName => $factoryClass) {
                /** @var string $modelName */
                /** @var string $factoryClass */
                $this->generateModelData($module, $modelName, $factoryClass);
            }

            echo "\n";
        }

        $this->printSummary();
    }

    private function generateModelData(string $module, string $modelName, string $factoryClass): void
    {
        try {
            echo "  🔄 Generating {$modelName} records... ";

            // Check if factory class exists
            if (! class_exists($factoryClass)) {
                echo "❌ Factory class not found: {$factoryClass}\n";
                /** @var array{status: string, reason: string} $resultData */
                $resultData = ['status' => 'failed', 'reason' => 'Factory not found'];
                /** @var array<string, array{status: string, count?: int, reason?: string, factory?: string}> $moduleResults */
                $moduleResults = $this->results[$module] ?? [];
                $moduleResults[$modelName] = $resultData;
                $this->results[$module] = $moduleResults;

                return;
            }

            // Create factory instance and generate records
            /** @var object $factory */
            $factory = new $factoryClass();

            // Check if the factory has the count method (Laravel Factory pattern)
            if (method_exists($factory, 'count')) {
                /** @var \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>|array<int, \Illuminate\Database\Eloquent\Model> $records */
                $records = $factory->count(100)->create();
            } else {
                // Fallback for custom factories
                $records = [];
                for ($i = 0; $i < 100; ++$i) {
                    if (method_exists($factory, 'create')) {
                        // Use call_user_func to avoid mixed type issues
                        /** @var \Illuminate\Database\Eloquent\Model $record */
                        $record = call_user_func([$factory, 'create']);
                        $records[] = $record;
                    } else {
                        throw new Exception("Factory {$factoryClass} doesn't have create() method");
                    }
                }
            }

            if (is_countable($records)) {
                $count = count($records);
            } else {
                // For single models or collections, use reflection or assume 100
                $count = 100; // We requested 100 records from factory
            }
            echo "✅ Created {$count} records\n";

            /** @var array{status: string, count: int, factory: string} $resultData */
            $resultData = [
                'status' => 'success',
                'count' => $count,
                'factory' => $factoryClass,
            ];
            /** @var array<string, array{status: string, count?: int, reason?: string, factory?: string}> $moduleResults */
            $moduleResults = $this->results[$module] ?? [];
            $moduleResults[$modelName] = $resultData;
            $this->results[$module] = $moduleResults;
        } catch (Exception $e) {
            echo '❌ Error: '.$e->getMessage()."\n";
            /** @var array{status: string, reason: string, factory: string} $resultData */
            $resultData = [
                'status' => 'failed',
                'reason' => $e->getMessage(),
                'factory' => $factoryClass,
            ];
            /** @var array<string, array{status: string, count?: int, reason?: string, factory?: string}> $moduleResults */
            $moduleResults = $this->results[$module] ?? [];
            $moduleResults[$modelName] = $resultData;
            $this->results[$module] = $moduleResults;
        }
    }

    private function printSummary(): void
    {
        echo "📊 GENERATION SUMMARY\n";
        echo str_repeat('=', 50)."\n\n";

        $totalSuccess = 0;
        $totalFailed = 0;
        $totalRecords = 0;

        foreach ($this->results as $module => $models) {
            /** @var string $module */
            /** @var array<string, array{status: string, count?: int, reason?: string, factory?: string}> $models */
            echo "Module: {$module}\n";

            foreach ($models as $modelName => $result) {
                /** @var string $modelName */
                /** @var array{status: string, count?: int, reason?: string, factory?: string} $result */
                $status = 'success' === $result['status'] ? '✅' : '❌';
                echo "  {$status} {$modelName}";

                if ('success' === $result['status']) {
                    /** @var int $count */
                    $count = $result['count'] ?? 0;
                    echo " - {$count} records";
                    ++$totalSuccess;
                    $totalRecords += $count;
                } else {
                    /** @var string $reason */
                    $reason = $result['reason'] ?? 'Unknown error';
                    echo " - Failed: {$reason}";
                    ++$totalFailed;
                }
                echo "\n";
            }
            echo "\n";
        }

        echo "TOTALS:\n";
        echo "✅ Successful: {$totalSuccess} models\n";
        echo "❌ Failed: {$totalFailed} models\n";
        echo "📈 Total records created: {$totalRecords}\n";
    }

    public function generateTinkerCommands(): void
    {
        echo "\n🔧 TINKER COMMANDS FOR MANUAL EXECUTION\n";
        echo str_repeat('=', 50)."\n\n";

        foreach ($this->businessModels as $module => $models) {
            /** @var string $module */
            /** @var array<string, string> $models */
            echo "// Module: {$module}\n";

            foreach ($models as $modelName => $factoryClass) {
                /** @var string $modelName */
                /** @var string $factoryClass */
                // Convert factory class to model class
                /** @var string $modelClass */
                $modelClass = str_replace('\Database\Factories\\', '\Models\\', $factoryClass);
                $modelClass = str_replace('Factory', '', $modelClass);

                echo "// {$modelName}\n";
                echo "(new {$factoryClass}())->count(100)->create();\n";
                echo "// Alternative: {$modelClass}::factory()->count(100)->create(); // if HasFactory trait is added\n\n";
            }
        }
    }
}

// Execute the generator
try {
    $generator = new TestDataGenerator();
    $generator->generateTestData();
    $generator->generateTinkerCommands();
} catch (Exception $e) {
    echo '💥 Fatal Error: '.$e->getMessage()."\n";
    echo "Stack trace:\n".$e->getTraceAsString()."\n";
}
