<?php

/**
 * Generic Module Database Seeding Script
 * 
 * This script can be used in any Laravel project with modules.
 * It uses environment variables and configuration to avoid hardcoded references.
 * 
 * USAGE:
 * 1. Set environment variables for customization
 * 2. Run: php bashscripts/database/seeding/generic-module-seeding.php
 * 
 * ENVIRONMENT VARIABLES:
 * - SEEDING_MODULE: Module name to seed (default: User)
 * - SEEDING_COUNT: Number of records to create (default: 100)
 * - SEEDING_MODEL: Model name to seed (default: User)
 * 
 * EXAMPLE:
 * SEEDING_MODULE=<nome progetto> SEEDING_MODEL=Patient SEEDING_COUNT=500 php generic-module-seeding.php
 */

// Configuration from environment or defaults
$moduleName = env('SEEDING_MODULE', 'User');
$modelName = env('SEEDING_MODEL', 'User');
$recordCount = (int) env('SEEDING_COUNT', 100);
$enableForeignKeyChecks = env('SEEDING_FK_CHECKS', true);

/**
 * Generic seeding function that works with any module/model
 */
function seedGenericData(string $module, string $model, int $count): void
{
    echo "🌱 Seeding {$count} records for {$module}\\{$model}...\n";
    
    try {
        // Construct the model class name dynamically
        $modelClass = "\\Modules\\{$module}\\Models\\{$model}";
        
        // Check if the model class exists
        if (!class_exists($modelClass)) {
            throw new Exception("Model class {$modelClass} not found");
        }
        
        // Check if the model has a factory
        if (!method_exists($modelClass, 'factory')) {
            throw new Exception("Model {$modelClass} does not have a factory");
        }
        
        // Disable foreign key checks if configured
        if (!$enableForeignKeyChecks) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }
        
        // Create the records using the factory
        $modelClass::factory()->count($count)->create();
        
        echo "  ✅ Successfully created {$count} {$model} records\n";
        
    } catch (Exception $e) {
        echo "  ❌ Error seeding {$model}: " . $e->getMessage() . "\n";
    } finally {
        // Re-enable foreign key checks
        if (!$enableForeignKeyChecks) {
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (Exception $e) {
                echo "  ⚠️  Warning: Could not re-enable foreign key checks\n";
            }
        }
    }
}

/**
 * Generic function to seed multiple models from a module
 */
function seedModuleModels(string $module, array $models): void
{
    echo "🏗️  Seeding module {$module}...\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    $totalRecords = 0;
    $successfulModels = 0;
    
    foreach ($models as $model => $count) {
        seedGenericData($module, $model, $count);
        $totalRecords += $count;
        $successfulModels++;
    }
    
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📊 Module {$module} seeding completed:\n";
    echo "  - Models seeded: {$successfulModels}\n";
    echo "  - Total records: {$totalRecords}\n";
}

/**
 * Get default model counts based on common patterns
 */
function getDefaultModelCounts(string $model): int
{
    return match ($model) {
        // Heavy entities
        'Appointment', 'Order', 'Transaction' => 1000,
        'User', 'Customer', 'Patient' => 500,
        'Product', 'Service', 'Studio' => 100,
        
        // Medium entities
        'Category', 'Tag', 'Department' => 50,
        'Role', 'Permission' => 20,
        
        // Light entities / Pivot tables
        'Setting', 'Configuration' => 10,
        
        // Default for unknown models
        default => 100,
    };
}

/**
 * Discover models in a module directory
 */
function discoverModuleModels(string $module): array
{
    $modelsPath = "laravel/Modules/{$module}/app/Models";
    $models = [];
    
    if (!is_dir($modelsPath)) {
        echo "⚠️  Models directory not found: {$modelsPath}\n";
        return $models;
    }
    
    $files = glob("{$modelsPath}/*.php");
    
    foreach ($files as $file) {
        $filename = basename($file, '.php');
        
        // Skip base models and other non-concrete models
        if (in_array($filename, ['BaseModel', 'BasePivot', 'BaseUser'])) {
            continue;
        }
        
        // Skip policy directories
        if (strpos($file, '/Policies/') !== false) {
            continue;
        }
        
        $models[$filename] = getDefaultModelCounts($filename);
    }
    
    return $models;
}

// Main execution
try {
    echo "🚀 Generic Module Database Seeding\n";
    echo "====================================\n";
    echo "Module: {$moduleName}\n";
    echo "Model: {$modelName}\n";
    echo "Count: {$recordCount}\n";
    echo "====================================\n\n";
    
    if ($modelName !== 'User') {
        // Seed specific model
        seedGenericData($moduleName, $modelName, $recordCount);
    } else {
        // Auto-discover and seed all models in the module
        $models = discoverModuleModels($moduleName);
        
        if (empty($models)) {
            echo "⚠️  No models found in module {$moduleName}\n";
            exit(1);
        }
        
        echo "📋 Discovered models in {$moduleName}:\n";
        foreach ($models as $model => $count) {
            echo "  - {$model}: {$count} records\n";
        }
        echo "\n";
        
        seedModuleModels($moduleName, $models);
    }
    
    echo "\n✨ Seeding completed successfully!\n";
    
} catch (Exception $e) {
    echo "\n❌ Fatal error: " . $e->getMessage() . "\n";
    exit(1);
}
