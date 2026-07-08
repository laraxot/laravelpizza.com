#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * LARAXOT Documentation Validator
 * 
 * Validatore qualità documentazione moduli seguendo principi:
 * DRY + KISS + ROBUST + SOLID + LARAXOT
 * 
 * @category Documentation
 * @package  Bashscripts\Documentation\Validators
 * @author   Laraxot Team
 * @license  MIT
 * @version  1.0.0
 */

/**
 * Usage:
 *   php validate-docs.php [module] [--fix] [--report=format] [--coverage]
 * 
 * Examples:
 *   php validate-docs.php                    # Valida tutti i moduli
 *   php validate-docs.php User               # Valida solo modulo User
 *   php validate-docs.php User --fix         # Valida e applica fix automatici
 *   php validate-docs.php --report=json      # Report in formato JSON
 *   php validate-docs.php --coverage         # Mostra coverage documentazione
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
 * Documentation Validation CLI
 * 
 * KISS: Interfaccia semplice per validazione documentazione
 * SOLID: Single Responsibility per validation logic
 */
class DocumentationValidatorCLI
{
    private array $options;
    private string $basePath;
    private array $validationRules;
    private array $qualityMetrics;
    
    public function __construct(array $argv)
    {
        $this->basePath = dirname(__DIR__, 3) . '/laravel';
        $this->parseArguments($argv);
        $this->loadValidationRules();
        $this->initializeMetrics();
        $this->displayBanner();
    }
    
    /**
     * DRY: Entry point principale
     */
    public function run(): int
    {
        try {
            if ($this->options['coverage']) {
                return $this->showCoverage();
            }
            
            if ($this->options['module']) {
                return $this->validateSingleModule($this->options['module']);
            }
            
            return $this->validateAllModules();
            
        } catch (Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            if ($this->options['verbose']) {
                $this->error("Stack trace: " . $e->getTraceAsString());
            }
            return 1;
        }
    }
    
    /**
     * ROBUST: Validazione singolo modulo
     */
    private function validateSingleModule(string $moduleName): int
    {
        $this->info("🔍 Validating documentation for {$moduleName}...\n");
        
        if (!$this->moduleExists($moduleName)) {
            $this->error("Module {$moduleName} not found!");
            return 1;
        }
        
        $report = $this->validateModule($moduleName);
        
        $this->displayModuleReport($moduleName, $report);
        
        if ($this->options['fix'] && !empty($report['fixable_issues'])) {
            $this->applyFixes($moduleName, $report['fixable_issues']);
        }
        
        if ($this->options['report']) {
            $this->generateReport([$moduleName => $report]);
        }
        
        return $report['score'] >= $this->validationRules['min_score'] ? 0 : 1;
    }
    
    /**
     * LARAXOT: Validazione batch per tutti i moduli
     */
    private function validateAllModules(): int
    {
        $this->info("🔍 Validating documentation for all modules...\n");
        
        $modules = $this->discoverModules();
        $reports = [];
        $totalScore = 0;
        $moduleCount = 0;
        $failedModules = [];
        
        foreach ($modules as $moduleName) {
            $this->info("Validating {$moduleName}...");
            
            try {
                $report = $this->validateModule($moduleName);
                $reports[$moduleName] = $report;
                
                $score = $report['score'];
                $totalScore += $score;
                $moduleCount++;
                
                $status = $this->getScoreStatus($score);
                $this->output("  {$status} {$moduleName}: {$score}% ({$report['summary']})");
                
                if ($score < $this->validationRules['min_score']) {
                    $failedModules[] = $moduleName;
                }
                
                // Auto-fix se richiesto
                if ($this->options['fix'] && !empty($report['fixable_issues'])) {
                    $fixed = $this->applyFixes($moduleName, $report['fixable_issues']);
                    if ($fixed > 0) {
                        $this->output("    🔧 Applied {$fixed} automatic fixes");
                    }
                }
                
            } catch (Exception $e) {
                $this->output("  ❌ {$moduleName}: " . $e->getMessage());
                $failedModules[] = $moduleName;
            }
        }
        
        $avgScore = $moduleCount > 0 ? round($totalScore / $moduleCount) : 0;
        
        $this->displayValidationSummary($avgScore, $failedModules, $reports);
        
        if ($this->options['report']) {
            $this->generateReport($reports);
        }
        
        return count($failedModules) === 0 ? 0 : 1;
    }
    
    /**
     * Core Validation Logic
     * 
     * SOLID: Validazione modulare con responsabilità separate
     */
    private function validateModule(string $moduleName): array
    {
        $docsPath = $this->basePath . "/Modules/{$moduleName}/docs";
        $modulePath = $this->basePath . "/Modules/{$moduleName}";
        
        $report = [
            'module' => $moduleName,
            'score' => 0,
            'max_score' => 100,
            'issues' => [],
            'fixable_issues' => [],
            'warnings' => [],
            'suggestions' => [],
            'metrics' => [],
            'files_checked' => 0,
            'summary' => '',
        ];
        
        // 1. STRUCTURAL VALIDATION (25 points)
        $structuralScore = $this->validateStructure($moduleName, $docsPath, $report);
        
        // 2. CONTENT QUALITY VALIDATION (35 points)  
        $contentScore = $this->validateContent($moduleName, $docsPath, $report);
        
        // 3. CONSISTENCY VALIDATION (20 points)
        $consistencyScore = $this->validateConsistency($moduleName, $docsPath, $report);
        
        // 4. LINKS & REFERENCES VALIDATION (10 points)
        $linkScore = $this->validateLinks($moduleName, $docsPath, $report);
        
        // 5. TECHNICAL COMPLIANCE VALIDATION (10 points)
        $complianceScore = $this->validateCompliance($moduleName, $modulePath, $report);
        
        $report['score'] = $structuralScore + $contentScore + $consistencyScore + $linkScore + $complianceScore;
        $report['summary'] = $this->generateSummary($report);
        
        return $report;
    }
    
    /**
     * ROBUST: Validazione strutturale documentazione
     */
    private function validateStructure(string $moduleName, string $docsPath, array &$report): int
    {
        $score = 0;
        $maxScore = 25;
        
        // Check docs directory exists (5 points)
        if (!is_dir($docsPath)) {
            $report['issues'][] = 'Missing docs directory';
            $report['fixable_issues'][] = 'create_docs_directory';
            return 0;
        }
        $score += 5;
        
        // Check README.md exists (10 points)
        $readmePath = $docsPath . '/README.md';
        if (!file_exists($readmePath)) {
            $report['issues'][] = 'Missing README.md';
            $report['fixable_issues'][] = 'create_readme';
        } else {
            $score += 10;
            $report['files_checked']++;
            
            // Check README.md size and content
            $readmeContent = file_get_contents($readmePath);
            $wordCount = str_word_count($readmeContent);
            
            if ($wordCount < $this->validationRules['min_readme_words']) {
                $report['issues'][] = "README.md too short ({$wordCount} words, minimum {$this->validationRules['min_readme_words']})";
                $report['fixable_issues'][] = 'expand_readme';
            } elseif ($wordCount > $this->validationRules['max_readme_words']) {
                $report['warnings'][] = "README.md very long ({$wordCount} words, consider splitting)";
            }
        }
        
        // Check recommended files (5 points each, max 10)
        $recommendedFiles = ['getting-started.md', 'configuration.md', 'troubleshooting.md', 'api-reference.md'];
        $foundRecommended = 0;
        
        foreach ($recommendedFiles as $file) {
            if (file_exists($docsPath . '/' . $file)) {
                $foundRecommended++;
                $report['files_checked']++;
            }
        }
        
        $recommendedScore = min(10, $foundRecommended * 2.5);
        $score += $recommendedScore;
        
        if ($foundRecommended === 0) {
            $report['suggestions'][] = 'Consider adding recommended documentation files: ' . implode(', ', $recommendedFiles);
        }
        
        $report['metrics']['structural_score'] = $score;
        $report['metrics']['files_found'] = $report['files_checked'];
        
        return (int)$score;
    }
    
    /**
     * KISS: Validazione contenuto semplificata
     */
    private function validateContent(string $moduleName, string $docsPath, array &$report): int
    {
        $score = 0;
        $maxScore = 35;
        
        $readmePath = $docsPath . '/README.md';
        if (!file_exists($readmePath)) {
            return 0;
        }
        
        $content = file_get_contents($readmePath);
        
        // Check required sections (15 points)
        $requiredSections = $this->validationRules['required_sections'];
        $foundSections = 0;
        
        foreach ($requiredSections as $section) {
            if (preg_match('/##\s+' . preg_quote($section, '/') . '/i', $content)) {
                $foundSections++;
            }
        }
        
        $sectionScore = (count($requiredSections) > 0) ? 
            round(($foundSections / count($requiredSections)) * 15) : 15;
        $score += $sectionScore;
        
        if ($foundSections < count($requiredSections)) {
            $missingSections = array_diff($requiredSections, 
                array_filter($requiredSections, function($section) use ($content) {
                    return preg_match('/##\s+' . preg_quote($section, '/') . '/i', $content);
                })
            );
            $report['issues'][] = 'Missing required sections: ' . implode(', ', $missingSections);
            $report['fixable_issues'][] = 'add_missing_sections';
        }
        
        // Check code examples (10 points)
        if (preg_match('/```[\s\S]*?```/', $content)) {
            $score += 10;
        } else {
            $report['issues'][] = 'No code examples found in README';
            $report['suggestions'][] = 'Add practical code examples to improve documentation quality';
        }
        
        // Check badges (5 points)
        if (preg_match('/\[\!\[.*?\]\(.*?\)\]\(.*?\)/', $content)) {
            $score += 5;
        } else {
            $report['fixable_issues'][] = 'add_badges';
            $report['warnings'][] = 'Consider adding status badges for better presentation';
        }
        
        // Check external links (5 points)
        $linkCount = preg_match_all('/\[.*?\]\(https?:\/\/.*?\)/', $content);
        if ($linkCount >= $this->validationRules['external_links_required']) {
            $score += 5;
        } else {
            $report['suggestions'][] = "Add more external links (found {$linkCount}, recommended {$this->validationRules['external_links_required']})";
        }
        
        $report['metrics']['content_score'] = $score;
        $report['metrics']['sections_found'] = $foundSections;
        $report['metrics']['code_examples'] = preg_match_all('/```[\s\S]*?```/', $content);
        
        return (int)$score;
    }
    
    /**
     * DRY: Validazione consistency centralizzata
     */
    private function validateConsistency(string $moduleName, string $docsPath, array &$report): int
    {
        $score = 20; // Start with full score, subtract for issues
        
        if (!is_dir($docsPath)) {
            return 0;
        }
        
        $files = glob($docsPath . '/*.md');
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $filename = basename($file);
            
            // Check header format consistency (5 points potential deduction)
            if (!preg_match('/^#\s+/', $content)) {
                $report['warnings'][] = "{$filename}: Missing or inconsistent main header format";
                $score = max(0, $score - 2);
            }
            
            // Check file naming consistency (5 points potential deduction)
            if (!preg_match('/^[a-z][a-z0-9-]*\.md$/', $filename)) {
                $report['warnings'][] = "{$filename}: Inconsistent file naming (use kebab-case)";
                $score = max(0, $score - 2);
            }
            
            // Check internal link format (5 points potential deduction)
            if (preg_match('/\[.*?\]\([A-Z]/', $content)) {
                $report['warnings'][] = "{$filename}: Use lowercase for internal links";
                $score = max(0, $score - 1);
            }
            
            // Check section heading consistency (5 points potential deduction)
            $headings = [];
            if (preg_match_all('/^(#{2,6})\s+(.*)$/m', $content, $matches)) {
                foreach ($matches[2] as $heading) {
                    if (!preg_match('/^[A-Z]/', trim($heading))) {
                        $report['warnings'][] = "{$filename}: Inconsistent heading capitalization: '{$heading}'";
                        $score = max(0, $score - 1);
                    }
                }
            }
        }
        
        $report['metrics']['consistency_score'] = $score;
        
        return (int)$score;
    }
    
    /**
     * ROBUST: Validazione links con error handling
     */
    private function validateLinks(string $moduleName, string $docsPath, array &$report): int
    {
        $score = 0;
        $maxScore = 10;
        
        if (!is_dir($docsPath)) {
            return 0;
        }
        
        $files = glob($docsPath . '/*.md');
        $totalLinks = 0;
        $brokenLinks = 0;
        $internalLinks = 0;
        $externalLinks = 0;
        
        foreach ($files as $file) {
            $content = file_get_contents($file);
            $filename = basename($file);
            
            // Find all markdown links
            if (preg_match_all('/\[([^\]]*)\]\(([^)]+)\)/', $content, $matches)) {
                foreach ($matches[2] as $i => $url) {
                    $totalLinks++;
                    $linkText = $matches[1][$i];
                    
                    if (strpos($url, 'http') === 0) {
                        // External link
                        $externalLinks++;
                        // Skip actual HTTP checks in this implementation for performance
                        // In production, we could implement async HTTP checks
                    } elseif (strpos($url, '#') === 0) {
                        // Anchor link - check if section exists
                        $internalLinks++;
                        $anchor = substr($url, 1);
                        $anchorRegex = '/^#{1,6}\s+.*?' . preg_quote(str_replace('-', '[ -]', $anchor), '/') . '/im';
                        if (!preg_match($anchorRegex, $content)) {
                            $report['issues'][] = "{$filename}: Broken anchor link '{$url}'";
                            $brokenLinks++;
                        }
                    } else {
                        // Relative link - check if file exists
                        $internalLinks++;
                        $targetPath = dirname($file) . '/' . $url;
                        if (!file_exists($targetPath)) {
                            $report['issues'][] = "{$filename}: Broken relative link '{$url}'";
                            $brokenLinks++;
                        }
                    }
                }
            }
        }
        
        // Score based on broken link percentage
        if ($totalLinks === 0) {
            $score = 5; // Neutral score for no links
            $report['suggestions'][] = 'Consider adding more documentation links';
        } else {
            $brokenPercentage = ($brokenLinks / $totalLinks) * 100;
            if ($brokenPercentage === 0) {
                $score = 10; // Perfect score
            } elseif ($brokenPercentage <= 10) {
                $score = 8; // Good score
            } elseif ($brokenPercentage <= 25) {
                $score = 5; // Acceptable
            } else {
                $score = 0; // Poor
            }
        }
        
        $report['metrics']['link_score'] = $score;
        $report['metrics']['total_links'] = $totalLinks;
        $report['metrics']['broken_links'] = $brokenLinks;
        $report['metrics']['internal_links'] = $internalLinks;
        $report['metrics']['external_links'] = $externalLinks;
        
        if ($brokenLinks > 0) {
            $report['fixable_issues'][] = 'fix_broken_links';
        }
        
        return (int)$score;
    }
    
    /**
     * LARAXOT: Validazione compliance con standard framework
     */
    private function validateCompliance(string $moduleName, string $modulePath, array &$report): int
    {
        $score = 0;
        $maxScore = 10;
        
        // Check module.json exists (3 points)
        if (file_exists($modulePath . '/module.json')) {
            $score += 3;
            $moduleConfig = json_decode(file_get_contents($modulePath . '/module.json'), true);
            
            if (isset($moduleConfig['version'])) {
                $score += 1;
            } else {
                $report['suggestions'][] = 'Add version to module.json';
            }
            
            if (isset($moduleConfig['description'])) {
                $score += 1;
            } else {
                $report['suggestions'][] = 'Add description to module.json';
            }
        } else {
            $report['warnings'][] = 'Missing module.json file';
        }
        
        // Check for PHPStan configuration (2 points)
        $phpstanFiles = ['phpstan.neon', 'phpstan.neon.dist'];
        $hasPhpstan = false;
        foreach ($phpstanFiles as $file) {
            if (file_exists($modulePath . '/' . $file)) {
                $hasPhpstan = true;
                break;
            }
        }
        
        if ($hasPhpstan) {
            $score += 2;
        } else {
            $report['suggestions'][] = 'Add PHPStan configuration for code quality';
        }
        
        // Check for tests directory (2 points)
        if (is_dir($modulePath . '/tests')) {
            $score += 2;
        } else {
            $report['suggestions'][] = 'Add tests directory for better code quality';
        }
        
        // Check for lang directory (1 point)
        if (is_dir($modulePath . '/lang')) {
            $score += 1;
        } else {
            $report['suggestions'][] = 'Add lang directory for internationalization support';
        }
        
        $report['metrics']['compliance_score'] = $score;
        
        return (int)$score;
    }
    
    /**
     * SOLID: Auto-fix per problemi risolvibili automaticamente
     */
    private function applyFixes(string $moduleName, array $fixableIssues): int
    {
        $fixedCount = 0;
        $docsPath = $this->basePath . "/Modules/{$moduleName}/docs";
        
        foreach ($fixableIssues as $issue) {
            try {
                switch ($issue) {
                    case 'create_docs_directory':
                        if (!is_dir($docsPath)) {
                            mkdir($docsPath, 0755, true);
                            $fixedCount++;
                        }
                        break;
                        
                    case 'create_readme':
                        $readmePath = $docsPath . '/README.md';
                        if (!file_exists($readmePath)) {
                            $template = $this->getReadmeTemplate($moduleName);
                            file_put_contents($readmePath, $template);
                            $fixedCount++;
                        }
                        break;
                        
                    case 'add_badges':
                        $this->addBadgesToReadme($docsPath . '/README.md');
                        $fixedCount++;
                        break;
                        
                    // Add more auto-fixes as needed
                }
            } catch (Exception $e) {
                $this->error("Failed to apply fix '{$issue}': " . $e->getMessage());
            }
        }
        
        return $fixedCount;
    }
    
    /**
     * Helper Methods
     */
    private function parseArguments(array $argv): void
    {
        $this->options = [
            'module' => null,
            'fix' => false,
            'report' => null,
            'coverage' => false,
            'verbose' => false,
        ];
        
        for ($i = 1; $i < count($argv); $i++) {
            $arg = $argv[$i];
            
            if ($arg === '--fix') {
                $this->options['fix'] = true;
            } elseif ($arg === '--coverage') {
                $this->options['coverage'] = true;
            } elseif ($arg === '--verbose' || $arg === '-v') {
                $this->options['verbose'] = true;
            } elseif (str_starts_with($arg, '--report=')) {
                $this->options['report'] = substr($arg, 9);
            } elseif (!str_starts_with($arg, '--') && !$this->options['module']) {
                $this->options['module'] = $arg;
            }
        }
    }
    
    private function loadValidationRules(): void
    {
        $this->validationRules = [
            'min_score' => 80,
            'min_readme_words' => 200,
            'max_readme_words' => 2000,
            'required_sections' => ['Overview', 'Features', 'Quick Start'],
            'external_links_required' => 3,
        ];
    }
    
    private function initializeMetrics(): void
    {
        $this->qualityMetrics = [
            'total_modules' => 0,
            'validated_modules' => 0,
            'average_score' => 0,
            'modules_above_threshold' => 0,
        ];
    }
    
    // ... (rest of helper methods similar to generate-docs.php)
    
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
        return is_dir($this->basePath . "/Modules/{$moduleName}");
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
    
    private function generateSummary(array $report): string
    {
        $issueCount = count($report['issues']);
        $warningCount = count($report['warnings']);
        
        if ($issueCount === 0 && $warningCount === 0) {
            return 'Excellent';
        } elseif ($issueCount === 0) {
            return "{$warningCount} warning(s)";
        } else {
            return "{$issueCount} issue(s)";
        }
    }
    
    // Output methods (similar to generate-docs.php)
    private function displayBanner(): void
    {
        $this->output("");
        $this->output("🔍 LARAXOT Documentation Validator");
        $this->output("   Framework: DRY + KISS + ROBUST + SOLID + LARAXOT");
        $this->output("   Version: 1.0.0");
        $this->output("   Base Path: " . $this->basePath);
        $this->output("");
    }
    
    private function displayModuleReport(string $moduleName, array $report): void
    {
        $status = $this->getScoreStatus($report['score']);
        $this->output("{$status} {$moduleName}: {$report['score']}/100 ({$report['summary']})");
        
        if (!empty($report['issues'])) {
            $this->output("\n🔴 Issues:");
            foreach ($report['issues'] as $issue) {
                $this->output("  - {$issue}");
            }
        }
        
        if (!empty($report['warnings'])) {
            $this->output("\n⚠️  Warnings:");
            foreach ($report['warnings'] as $warning) {
                $this->output("  - {$warning}");
            }
        }
        
        if (!empty($report['suggestions'])) {
            $this->output("\n💡 Suggestions:");
            foreach ($report['suggestions'] as $suggestion) {
                $this->output("  - {$suggestion}");
            }
        }
        
        $this->output("\n📊 Metrics:");
        foreach ($report['metrics'] as $metric => $value) {
            $this->output("  - {$metric}: {$value}");
        }
    }
    
    private function displayValidationSummary(int $avgScore, array $failedModules, array $reports): void
    {
        $totalModules = count($reports);
        $passedModules = $totalModules - count($failedModules);
        $passRate = $totalModules > 0 ? round(($passedModules / $totalModules) * 100) : 0;
        
        $this->output("\n📊 Validation Summary:");
        $this->output("   Total Modules: {$totalModules}");
        $this->output("   Average Score: {$avgScore}%");
        $this->output("   Passed Modules: {$passedModules}");
        $this->output("   Failed Modules: " . count($failedModules));
        $this->output("   Pass Rate: {$passRate}%");
        
        if (!empty($failedModules)) {
            $this->output("\n🔧 Failed Modules:");
            foreach ($failedModules as $module) {
                $score = $reports[$module]['score'] ?? 0;
                $this->output("   - {$module} ({$score}%)");
            }
        }
    }
    
    // Additional helper methods for fixes
    private function getReadmeTemplate(string $moduleName): string
    {
        return "# {$moduleName} Module

> Module description for {$moduleName}

## Overview

The {$moduleName} module provides functionality for the Laraxot PTVX framework.

## Features

- Core functionality
- Integration support
- Configuration options

## Quick Start

```bash
# Enable the module
php artisan module:enable {$moduleName}

# Run migrations
php artisan migrate
```

### Basic Usage

```php
// Add usage examples here
```

## Requirements

- PHP 8.4+
- Laravel 11.x
- Filament 3.x

## Links

- [Laraxot Documentation](../../../docs/)

---

**Version**: 1.0.0  
**Last Updated**: " . date('F j, Y') . "
";
    }
    
    private function addBadgesToReadme(string $readmePath): void
    {
        if (!file_exists($readmePath)) {
            return;
        }
        
        $content = file_get_contents($readmePath);
        $badges = '[![Laravel 11.x](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com/)
[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-Ready-green.svg)](https://laravel.com/docs/localization)

';
        
        // Add badges after the first heading
        $content = preg_replace('/^(#[^#\n]*\n)/', '$1' . "\n" . $badges, $content);
        
        file_put_contents($readmePath, $content);
    }
    
    private function showCoverage(): int
    {
        $this->info("📊 Documentation Coverage Report\n");
        
        $modules = $this->discoverModules();
        $totalModules = count($modules);
        $documentedModules = 0;
        $coverageByCategory = [];
        
        foreach ($modules as $moduleName) {
            $docsPath = $this->basePath . "/Modules/{$moduleName}/docs";
            $hasReadme = file_exists($docsPath . '/README.md');
            
            if ($hasReadme) {
                $documentedModules++;
            }
            
            // Simple category detection - in production would be more sophisticated
            $category = $this->guessModuleCategory($moduleName);
            if (!isset($coverageByCategory[$category])) {
                $coverageByCategory[$category] = ['total' => 0, 'documented' => 0];
            }
            $coverageByCategory[$category]['total']++;
            if ($hasReadme) {
                $coverageByCategory[$category]['documented']++;
            }
            
            $status = $hasReadme ? '✅' : '❌';
            $this->output("  {$status} {$moduleName}");
        }
        
        $overallCoverage = $totalModules > 0 ? round(($documentedModules / $totalModules) * 100) : 0;
        
        $this->output("\n📈 Coverage Summary:");
        $this->output("   Overall Coverage: {$overallCoverage}% ({$documentedModules}/{$totalModules})");
        
        $this->output("\n📊 Coverage by Category:");
        foreach ($coverageByCategory as $category => $data) {
            $categoryPercent = $data['total'] > 0 ? round(($data['documented'] / $data['total']) * 100) : 0;
            $this->output("   {$category}: {$categoryPercent}% ({$data['documented']}/{$data['total']})");
        }
        
        if ($this->options['report'] === 'json') {
            echo json_encode([
                'overall_coverage' => $overallCoverage,
                'total_modules' => $totalModules,
                'documented_modules' => $documentedModules,
                'coverage_by_category' => $coverageByCategory,
            ]);
        }
        
        return 0;
    }
    
    private function generateReport(array $reports): void
    {
        $format = $this->options['report'] ?? 'text';
        
        switch ($format) {
            case 'json':
                echo json_encode($reports, JSON_PRETTY_PRINT);
                break;
                
            case 'markdown':
                $this->generateMarkdownReport($reports);
                break;
                
            default:
                // Text format already handled by normal output
                break;
        }
    }
    
    private function generateMarkdownReport(array $reports): void
    {
        $markdown = "# Documentation Quality Report\n\n";
        $markdown .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
        
        $markdown .= "## Summary\n\n";
        $totalModules = count($reports);
        $totalScore = array_sum(array_column($reports, 'score'));
        $avgScore = $totalModules > 0 ? round($totalScore / $totalModules) : 0;
        
        $markdown .= "- **Total Modules**: {$totalModules}\n";
        $markdown .= "- **Average Score**: {$avgScore}%\n\n";
        
        $markdown .= "## Module Details\n\n";
        $markdown .= "| Module | Score | Issues | Warnings | Files |\n";
        $markdown .= "|--------|-------|--------|----------|-------|\n";
        
        foreach ($reports as $moduleName => $report) {
            $issueCount = count($report['issues']);
            $warningCount = count($report['warnings']);
            $fileCount = $report['files_checked'];
            
            $markdown .= "| {$moduleName} | {$report['score']}% | {$issueCount} | {$warningCount} | {$fileCount} |\n";
        }
        
        echo $markdown;
    }
    
    private function guessModuleCategory(string $moduleName): string
    {
        $coreModules = ['Xot', 'Lang', 'Setting'];
        $businessModules = ['User', 'Activity', 'Notify', 'Job'];
        $uiModules = ['UI', 'Media'];
        
        if (in_array($moduleName, $coreModules)) return 'core';
        if (in_array($moduleName, $businessModules)) return 'business';
        if (in_array($moduleName, $uiModules)) return 'ui';
        
        return 'utility';
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
}

// Execute CLI Application
if (php_sapi_name() === 'cli') {
    $cli = new DocumentationValidatorCLI($argv);
    exit($cli->run());
} else {
    echo "This script must be run from command line.\n";
    exit(1);
}