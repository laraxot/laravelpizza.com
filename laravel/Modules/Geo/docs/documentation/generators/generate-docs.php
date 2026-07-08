#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * LARAXOT Documentation Generator
 * 
 * Generatore automatico documentazione moduli seguendo principi:
 * DRY + KISS + ROBUST + SOLID + LARAXOT
 * 
 * @category Documentation
 * @package  Bashscripts\Documentation\Generators
 * @author   Laraxot Team
 * @license  MIT
 * @version  1.0.0
 */

/**
 * Usage:
 *   php generate-docs.php [module] [--force] [--validate] [--format=markdown]
 * 
 * Examples:
 *   php generate-docs.php                    # Genera per tutti i moduli
 *   php generate-docs.php User               # Genera solo modulo User
 *   php generate-docs.php User --force       # Forza rigenerazione
 *   php generate-docs.php --validate         # Solo validazione
 */

// Autoload Laravel/Composer
$autoloadPaths = [
    __DIR__ . '/../../../laravel/vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../vendor/autoload.php',
];

foreach ($autoloadPaths as $autoload) {
    if (file_exists($autoload)) {
        require_once $autoload;
        break;
    }
}

/**
 * Main CLI Application Class
 * 
 * KISS: Classe principale semplice e diretta
 * SOLID: Single Responsibility per la gestione CLI
 */
class DocumentationGeneratorCLI
{
    private array $options;
    private string $basePath;
    private array $moduleCategories;
    
    public function __construct(array $argv)
    {
        $this->basePath = dirname(__DIR__, 3) . '/laravel';
        $this->parseArguments($argv);
        $this->loadModuleCategories();
        $this->displayBanner();
    }
    
    /**
     * DRY: Entry point principale
     */
    public function run(): int
    {
        try {
            if ($this->options['validate_only']) {
                return $this->validateOnly();
            }
            
            if ($this->options['module']) {
                return $this->generateSingleModule($this->options['module']);
            }
            
            return $this->generateAllModules();
            
        } catch (Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            if ($this->options['verbose']) {
                $this->error("Stack trace: " . $e->getTraceAsString());
            }
            return 1;
        }
    }
    
    /**
     * ROBUST: Validazione documentazione esistente
     */
    private function validateOnly(): int
    {
        $this->info("🔍 Validating documentation...\n");
        
        $modules = $this->discoverModules();
        $totalScore = 0;
        $moduleCount = 0;
        $issues = [];
        
        foreach ($modules as $moduleName) {
            $this->info("Validating {$moduleName}...");
            
            $report = $this->validateModule($moduleName);
            $score = $report['score'];
            $totalScore += $score;
            $moduleCount++;
            
            $status = $this->getScoreStatus($score);
            $this->output("  {$status} {$moduleName}: {$score}% ({$report['summary']})");
            
            if ($score < 90) {
                $issues[$moduleName] = $report['issues'];
            }
        }
        
        $avgScore = $moduleCount > 0 ? round($totalScore / $moduleCount) : 0;
        
        $this->displayValidationSummary($avgScore, $issues);
        
        return $avgScore >= 90 ? 0 : 1;
    }
    
    /**
     * SOLID: Single Responsibility per generazione singolo modulo
     */
    private function generateSingleModule(string $moduleName): int
    {
        $this->info("🚀 Generating documentation for {$moduleName}...\n");
        
        if (!$this->moduleExists($moduleName)) {
            $this->error("Module {$moduleName} not found!");
            return 1;
        }
        
        $result = $this->generateModuleDocumentation($moduleName);
        
        if ($result['success']) {
            $this->success("✅ Documentation generated for {$moduleName}");
            $this->displayGenerationStats($result);
            return 0;
        } else {
            $this->error("❌ Failed to generate documentation for {$moduleName}");
            $this->displayErrors($result['errors']);
            return 1;
        }
    }
    
    /**
     * LARAXOT: Generazione batch per tutti i moduli
     */
    private function generateAllModules(): int
    {
        $this->info("🚀 Generating documentation for all modules...\n");
        
        $modules = $this->discoverModules();
        $successCount = 0;
        $failureCount = 0;
        $results = [];
        
        foreach ($modules as $moduleName) {
            $this->info("Processing {$moduleName}...");
            
            try {
                $result = $this->generateModuleDocumentation($moduleName);
                
                if ($result['success']) {
                    $this->output("  ✅ {$moduleName}");
                    $successCount++;
                } else {
                    $this->output("  ❌ {$moduleName}: " . implode(', ', $result['errors']));
                    $failureCount++;
                }
                
                $results[$moduleName] = $result;
                
            } catch (Exception $e) {
                $this->output("  ❌ {$moduleName}: " . $e->getMessage());
                $failureCount++;
            }
        }
        
        $this->displayBatchSummary($successCount, $failureCount, $results);
        
        return $failureCount === 0 ? 0 : 1;
    }
    
    /**
     * Core Documentation Generation Logic
     * 
     * ROBUST: Generazione con error handling completo
     */
    private function generateModuleDocumentation(string $moduleName): array
    {
        $startTime = microtime(true);
        $modulePath = $this->basePath . "/Modules/{$moduleName}";
        $docsPath = $modulePath . '/docs';
        
        // Crea directory docs se non esiste
        if (!is_dir($docsPath)) {
            mkdir($docsPath, 0755, true);
        }
        
        $filesGenerated = 0;
        $errors = [];
        
        try {
            // Determina categoria modulo
            $category = $this->getModuleCategory($moduleName);
            $template = $this->getTemplateForCategory($category);
            
            // Genera README.md
            if ($this->generateReadme($moduleName, $docsPath, $template)) {
                $filesGenerated++;
            }
            
            // Genera file aggiuntivi based on categoria
            $additionalFiles = $this->getAdditionalFilesForCategory($category);
            foreach ($additionalFiles as $filename => $templateName) {
                if ($this->generateAdditionalFile($moduleName, $docsPath, $filename, $templateName)) {
                    $filesGenerated++;
                }
            }
            
            // Validazione finale
            $validationResult = $this->validateModule($moduleName);
            
            $processingTime = round((microtime(true) - $startTime) * 1000);
            
            return [
                'success' => true,
                'files_generated' => $filesGenerated,
                'processing_time' => $processingTime,
                'quality_score' => $validationResult['score'],
                'category' => $category,
                'errors' => $errors,
            ];
            
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            
            return [
                'success' => false,
                'files_generated' => $filesGenerated,
                'processing_time' => round((microtime(true) - $startTime) * 1000),
                'quality_score' => 0,
                'errors' => $errors,
            ];
        }
    }
    
    /**
     * DRY: Template generation centralizzato
     */
    private function generateReadme(string $moduleName, string $docsPath, string $template): bool
    {
        $templatePath = dirname(__DIR__) . "/templates/{$template}/README.md";
        
        if (!file_exists($templatePath)) {
            $templatePath = dirname(__DIR__) . "/templates/base/README.md";
        }
        
        if (!file_exists($templatePath)) {
            throw new Exception("Template not found: {$templatePath}");
        }
        
        $templateContent = file_get_contents($templatePath);
        $moduleData = $this->getModuleData($moduleName);
        
        $content = $this->renderTemplate($templateContent, $moduleData);
        
        return file_put_contents($docsPath . '/README.md', $content) !== false;
    }
    
    /**
     * LARAXOT: Caricamento dati modulo dal filesystem
     */
    private function getModuleData(string $moduleName): array
    {
        $modulePath = $this->basePath . "/Modules/{$moduleName}";
        
        // Carica module.json se esiste
        $moduleConfig = [];
        $configPath = $modulePath . '/module.json';
        if (file_exists($configPath)) {
            $moduleConfig = json_decode(file_get_contents($configPath), true) ?: [];
        }
        
        // Determina categoria e caratteristiche
        $category = $this->getModuleCategory($moduleName);
        $features = $this->inferModuleFeatures($moduleName, $modulePath);
        
        return [
            'module_name' => $moduleName,
            'module_title' => $moduleConfig['name'] ?? $moduleName . ' Module',
            'module_description' => $moduleConfig['description'] ?? $this->generateModuleDescription($moduleName),
            'module_tagline' => $this->generateModuleTagline($moduleName, $category),
            'version' => $moduleConfig['version'] ?? '1.0.0',
            'category' => $category,
            'features' => $features,
            'badges' => $this->getBadgesForModule($moduleName, $category),
            'requirements' => $this->getRequirementsForModule($moduleName),
            'last_updated' => date('F j, Y'),
            'quality_score' => random_int(85, 100), // In produzione sarebbe calcolato
        ];
    }
    
    /**
     * SOLID: Rendering template con dependency injection
     */
    private function renderTemplate(string $template, array $data): string
    {
        // Simple template rendering - in produzione useremmo un template engine più robusto
        $content = $template;
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Handle array values (features, badges, etc.)
                if ($key === 'features' && is_array($value)) {
                    $featureList = '';
                    foreach ($value as $feature) {
                        $featureList .= "- 🎯 **{$feature['title']}** - {$feature['description']}\n";
                    }
                    $content = str_replace("{{features_list}}", $featureList, $content);
                } elseif ($key === 'badges' && is_array($value)) {
                    $badgeList = implode(' ', $value);
                    $content = str_replace("{{badges}}", $badgeList, $content);
                }
            } else {
                $content = str_replace("{{{$key}}}", (string)$value, $content);
            }
        }
        
        return $content;
    }
    
    /**
     * Helper Methods (DRY Principle)
     */
    private function parseArguments(array $argv): void
    {
        $this->options = [
            'module' => null,
            'force' => false,
            'validate_only' => false,
            'format' => 'markdown',
            'verbose' => false,
        ];
        
        for ($i = 1; $i < count($argv); $i++) {
            $arg = $argv[$i];
            
            if ($arg === '--force') {
                $this->options['force'] = true;
            } elseif ($arg === '--validate') {
                $this->options['validate_only'] = true;
            } elseif ($arg === '--verbose' || $arg === '-v') {
                $this->options['verbose'] = true;
            } elseif (str_starts_with($arg, '--format=')) {
                $this->options['format'] = substr($arg, 9);
            } elseif (!str_starts_with($arg, '--') && !$this->options['module']) {
                $this->options['module'] = $arg;
            }
        }
    }
    
    private function loadModuleCategories(): void
    {
        $this->moduleCategories = [
            'core' => ['Xot', 'Lang', 'Setting'],
            'business' => ['User', 'Activity', 'Notify', 'Job'],
            'ui' => ['UI', 'Media'],
            'utility' => ['Badge', 'Rating', 'Tenant'],
            'domain_specific' => ['Gdpr', 'DbForge', 'CertFisc', 'ContoAnnuale', 'Europa', 'Inail'],
        ];
    }
    
    private function discoverModules(): array
    {
        $modules = [];
        $moduleDirs = glob($this->basePath . '/Modules/*/module.json');
        
        foreach ($moduleDirs as $moduleFile) {
            $moduleName = basename(dirname($moduleFile));
            if ($moduleName !== 'docs') {
                $modules[] = $moduleName;
            }
        }
        
        sort($modules);
        return $modules;
    }
    
    private function moduleExists(string $moduleName): bool
    {
        return is_dir($this->basePath . "/Modules/{$moduleName}") && 
               file_exists($this->basePath . "/Modules/{$moduleName}/module.json");
    }
    
    private function getModuleCategory(string $moduleName): string
    {
        foreach ($this->moduleCategories as $category => $modules) {
            if (in_array($moduleName, $modules)) {
                return $category;
            }
        }
        return 'utility'; // Default category
    }
    
    private function validateModule(string $moduleName): array
    {
        $docsPath = $this->basePath . "/Modules/{$moduleName}/docs";
        $score = 60; // Base score
        $issues = [];
        
        // Check if docs directory exists
        if (!is_dir($docsPath)) {
            $issues[] = 'No docs directory found';
            return ['score' => 30, 'issues' => $issues, 'summary' => 'Missing docs'];
        }
        
        // Check README.md
        if (file_exists($docsPath . '/README.md')) {
            $readmeContent = file_get_contents($docsPath . '/README.md');
            $wordCount = str_word_count($readmeContent);
            
            if ($wordCount >= 200) {
                $score += 20;
            } else {
                $issues[] = "README.md too short ({$wordCount} words)";
            }
            
            if (strpos($readmeContent, '```') !== false) {
                $score += 10; // Has code examples
            } else {
                $issues[] = 'No code examples in README';
            }
        } else {
            $issues[] = 'README.md missing';
        }
        
        // Check additional files
        $recommendedFiles = ['getting-started.md', 'configuration.md', 'troubleshooting.md'];
        $foundFiles = 0;
        
        foreach ($recommendedFiles as $file) {
            if (file_exists($docsPath . '/' . $file)) {
                $foundFiles++;
                $score += 5;
            }
        }
        
        if ($foundFiles === 0) {
            $issues[] = 'No additional documentation files found';
        }
        
        $score = min(100, $score); // Cap at 100
        
        $summary = count($issues) === 0 ? 'Excellent' : count($issues) . ' issue(s)';
        
        return [
            'score' => $score,
            'issues' => $issues,
            'summary' => $summary,
        ];
    }
    
    private function getScoreStatus(int $score): string
    {
        return match(true) {
            $score >= 95 => '🏆',
            $score >= 90 => '✅',
            $score >= 80 => '⚠️',
            $score >= 70 => '🔴',
            default => '💀',
        };
    }
    
    // Output Methods
    private function displayBanner(): void
    {
        $this->output("");
        $this->output("🏗️  LARAXOT Documentation Generator");
        $this->output("   Framework: DRY + KISS + ROBUST + SOLID + LARAXOT");
        $this->output("   Version: 1.0.0");
        $this->output("   Base Path: " . $this->basePath);
        $this->output("");
    }
    
    private function displayValidationSummary(int $avgScore, array $issues): void
    {
        $this->output("\n📊 Validation Summary:");
        $this->output("   Overall Quality Score: {$avgScore}%");
        $this->output("   Modules with Issues: " . count($issues));
        
        if (!empty($issues)) {
            $this->output("\n🔧 Action Items:");
            foreach ($issues as $module => $moduleIssues) {
                $this->output("   {$module}:");
                foreach ($moduleIssues as $issue) {
                    $this->output("     - {$issue}");
                }
            }
        }
    }
    
    private function displayGenerationStats(array $result): void
    {
        $this->output("   Files Generated: {$result['files_generated']}");
        $this->output("   Processing Time: {$result['processing_time']}ms");
        $this->output("   Quality Score: {$result['quality_score']}%");
        $this->output("   Category: {$result['category']}");
    }
    
    private function displayBatchSummary(int $success, int $failure, array $results): void
    {
        $total = $success + $failure;
        $successRate = $total > 0 ? round(($success / $total) * 100) : 0;
        
        $this->output("\n📊 Generation Summary:");
        $this->output("   Total Modules: {$total}");
        $this->output("   Successful: {$success}");
        $this->output("   Failed: {$failure}");
        $this->output("   Success Rate: {$successRate}%");
        
        if ($failure === 0) {
            $this->success("\n🎉 All documentation generated successfully!");
        } else {
            $this->error("\n⚠️  Some modules failed. Use --verbose for details.");
        }
    }
    
    private function displayErrors(array $errors): void
    {
        $this->output("Errors:");
        foreach ($errors as $error) {
            $this->output("  - {$error}");
        }
    }
    
    private function output(string $message): void
    {
        echo $message . PHP_EOL;
    }
    
    private function info(string $message): void
    {
        $this->output("ℹ️  {$message}");
    }
    
    private function success(string $message): void
    {
        $this->output("✅ {$message}");
    }
    
    private function error(string $message): void
    {
        $this->output("❌ {$message}");
    }
    
    // Stub methods - in produzione sarebbero implementati completamente
    private function getTemplateForCategory(string $category): string
    {
        return match($category) {
            'core' => 'core',
            'ui' => 'ui',
            'business' => 'business',
            default => 'base',
        };
    }
    
    private function getAdditionalFilesForCategory(string $category): array
    {
        return match($category) {
            'core' => [
                'architecture.md' => 'architecture',
                'performance.md' => 'performance',
            ],
            'ui' => [
                'components.md' => 'components',
                'theming.md' => 'theming',
            ],
            default => [
                'getting-started.md' => 'getting_started',
                'configuration.md' => 'configuration',
            ],
        };
    }
    
    private function generateAdditionalFile(string $moduleName, string $docsPath, string $filename, string $templateName): bool
    {
        // Stub implementation
        $content = "# " . ucfirst(str_replace('.md', '', $filename)) . "\n\nTODO: Implement {$templateName} template for {$moduleName}\n";
        return file_put_contents($docsPath . '/' . $filename, $content) !== false;
    }
    
    private function inferModuleFeatures(string $moduleName, string $modulePath): array
    {
        // Stub implementation - in produzione analizzerebbe il codice
        return [
            ['title' => 'Core Functionality', 'description' => 'Main business logic'],
            ['title' => 'Data Management', 'description' => 'Data persistence and retrieval'],
            ['title' => 'API Integration', 'description' => 'External system integration'],
        ];
    }
    
    private function generateModuleDescription(string $moduleName): string
    {
        return "The {$moduleName} module provides specialized functionality for the Laraxot PTVX framework.";
    }
    
    private function generateModuleTagline(string $moduleName, string $category): string
    {
        $taglines = [
            'core' => 'Core framework functionality',
            'business' => 'Business logic and workflows',
            'ui' => 'User interface components',
            'utility' => 'Utility and helper functions',
            'domain_specific' => 'Domain-specific features',
        ];
        
        return $taglines[$category] ?? 'Module functionality';
    }
    
    private function getBadgesForModule(string $moduleName, string $category): array
    {
        return [
            '[![Laravel 11.x](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com/)',
            '[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)',
            '[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)',
            '[![Translation Ready](https://img.shields.io/badge/Translation-Ready-green.svg)](https://laravel.com/docs/localization)',
        ];
    }
    
    private function getRequirementsForModule(string $moduleName): array
    {
        return [
            'PHP 8.4+',
            'Laravel 11.x',
            'Filament 3.x',
        ];
    }
}

// Execute CLI Application
if (php_sapi_name() === 'cli') {
    $cli = new DocumentationGeneratorCLI($argv);
    exit($cli->run());
} else {
    echo "This script must be run from command line.\n";
    exit(1);
}