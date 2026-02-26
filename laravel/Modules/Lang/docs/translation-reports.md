# Translation Module PDF Reports

## 📋 Overview

Guida completa per generare report PDF delle traduzioni utilizzando HTML2PDF con integrazione nativa nel modulo Lang.

---

## 🎯 Tipi di Report Disponibili

### 1. Translation Coverage Report

Report completo sulla copertura delle traduzioni:

```php
use Modules\Lang\Actions\GenerateTranslationCoverageReportAction;

// Generate coverage report
$pdf = app(GenerateTranslationCoverageReportAction::class)->execute([
    'locales' => ['it', 'en', 'de', 'fr'],
    'modules' => ['all'], // o ['User', 'Activity', 'Gdpr']
    'include_sections' => [
        'statistics' => true,
        'missing_translations' => true,
        'unused_translations' => true,
        'locale_comparison' => true,
    ],
    'format' => 'detailed', // 'summary' or 'detailed'
]);
```

### 2. Translation Usage Report

Report sull'utilizzo delle traduzioni nell'applicazione:

```php
// Generate usage report
$pdf = app(GenerateTranslationUsageReportAction::class)->execute([
    'date_range' => [
        'start' => now()->subMonth(),
        'end' => now(),
    ],
    'include_components' => [
        'fields' => true,
        'actions' => true,
        'notifications' => true,
        'validations' => true,
    ],
    'group_by' => 'module', // 'module', 'locale', 'type'
]);
```

### 3. Translation Quality Report

Report sulla qualità e consistenza delle traduzioni:

```php
// Generate quality report
$pdf = app(GenerateTranslationQualityReportAction::class)->execute([
    'locales' => ['it', 'en'],
    'quality_checks' => [
        'consistency' => true,
        'length_variance' => true,
        'missing_placeholders' => true,
        'formatting_issues' => true,
    ],
    'thresholds' => [
        'max_length_variance' => 30, // percentage
        'min_consistency_score' => 80,
    ],
]);
```

---

## 🏗️ Architettura Report PDF

### 1. Translation Report Service

```php
<?php

namespace Modules\Lang\Services;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Modules\Lang\Models\Translation;

class TranslationReportService
{
    public function generateCoverageReport(array $options = []): string
    {
        try {
            $data = $this->prepareCoverageData($options);

            $html = view('lang::pdf.translation-coverage', [
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
                'reportId' => $this->generateReportId(),
            ])->render();

            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]);
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new TranslationReportException('Failed to generate coverage report: ' . $e->getMessage());
        }
    }

    private function prepareCoverageData(array $options): array
    {
        return [
            'coverage_statistics' => $this->getCoverageStatistics($options),
            'missing_translations' => $this->getMissingTranslations($options),
            'unused_translations' => $this->getUnusedTranslations($options),
            'locale_comparison' => $this->getLocaleComparison($options),
            'module_coverage' => $this->getModuleCoverage($options),
            'recommendations' => $this->generateRecommendations($options),
        ];
    }

    private function getCoverageStatistics(array $options): array
    {
        $locales = $options['locales'] ?? ['it', 'en'];
        $modules = $options['modules'] ?? ['all'];

        $statistics = [];

        foreach ($locales as $locale) {
            $totalKeys = $this->getTotalKeys($locale, $modules);
            $translatedKeys = $this->getTranslatedKeys($locale, $modules);
            $missingKeys = $totalKeys - $translatedKeys;

            $statistics[$locale] = [
                'total_keys' => $totalKeys,
                'translated_keys' => $translatedKeys,
                'missing_keys' => $missingKeys,
                'coverage_rate' => $totalKeys > 0 ? round(($translatedKeys / $totalKeys) * 100, 2) : 0,
            ];
        }

        return [
            'by_locale' => $statistics,
            'overall' => [
                'total_keys' => array_sum(array_column($statistics, 'total_keys')),
                'translated_keys' => array_sum(array_column($statistics, 'translated_keys')),
                'missing_keys' => array_sum(array_column($statistics, 'missing_keys')),
                'average_coverage' => round(array_sum(array_column($statistics, 'coverage_rate')) / count($statistics), 2),
            ],
        ];
    }

    private function getMissingTranslations(array $options): array
    {
        $locales = $options['locales'] ?? ['it', 'en'];
        $missing = [];

        foreach ($locales as $locale) {
            $localeMissing = $this->findMissingTranslations($locale);

            foreach ($localeMissing as $key => $context) {
                $missing[] = [
                    'key' => $key,
                    'locale' => $locale,
                    'context' => $context['file'] ?? 'Unknown',
                    'type' => $context['type'] ?? 'field',
                    'module' => $context['module'] ?? 'Unknown',
                ];
            }
        }

        return array_slice($missing, 0, 100); // Limit to 100 for PDF
    }

    private function getLocaleComparison(array $options): array
    {
        $locales = $options['locales'] ?? ['it', 'en'];
        $comparison = [];

        if (count($locales) >= 2) {
            $baseLocale = $locales[0];
            $compareLocale = $locales[1];

            $baseKeys = $this->getAllKeys($baseLocale);
            $compareKeys = $this->getAllKeys($compareLocale);

            $comparison = [
                'base_locale' => $baseLocale,
                'compare_locale' => $compareLocale,
                'only_in_base' => array_diff($baseKeys, $compareKeys),
                'only_in_compare' => array_diff($compareKeys, $baseKeys),
                'common_keys' => array_intersect($baseKeys, $compareKeys),
            ];
        }

        return $comparison;
    }

    private function generateRecommendations(array $options): array
    {
        $recommendations = [];

        $stats = $this->getCoverageStatistics($options);

        // Coverage recommendations
        foreach ($stats['by_locale'] as $locale => $data) {
            if ($data['coverage_rate'] < 90) {
                $recommendations[] = [
                    'type' => 'coverage',
                    'priority' => 'high',
                    'locale' => $locale,
                    'message' => "Locale '{$locale}' has only {$data['coverage_rate']}% coverage. {$data['missing_keys']} translations missing.",
                    'action' => 'Complete missing translations',
                ];
            }
        }

        // Unused translations
        $unused = $this->getUnusedTranslations($options);
        if (count($unused) > 50) {
            $recommendations[] = [
                'type' => 'cleanup',
                'priority' => 'medium',
                'message' => count($unused) . ' unused translations found. Consider removing them.",
                'action' => 'Clean up unused translations',
            ];
        }

        return $recommendations;
    }
}
```

### 2. Usage Report Service

```php
class TranslationUsageReportService
{
    public function generateUsageReport(array $options = []): string
    {
        try {
            $data = $this->prepareUsageData($options);

            $html = view('lang::pdf.translation-usage', [
                'data' => $data,
                'options' => $options,
                'generatedAt' => now(),
            ])->render();

            $html2pdf = new Html2Pdf('L', 'A4', 'it', true, 'UTF-8', [15, 20, 15, 20]); // Landscape for tables
            $html2pdf->setDefaultFont('Helvetica');
            $html2pdf->writeHTML($html);

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new TranslationReportException('Failed to generate usage report: ' . $e->getMessage());
        }
    }

    private function prepareUsageData(array $options): array
    {
        return [
            'usage_statistics' => $this->getUsageStatistics($options),
            'component_usage' => $this->getComponentUsage($options),
            'module_usage' => $this->getModuleUsage($options),
            'locale_usage' => $this->getLocaleUsage($options),
            'trending_keys' => $this->getTrendingKeys($options),
        ];
    }

    private function getUsageStatistics(array $options): array
    {
        // Analyze codebase for translation usage
        $usage = [];

        if ($options['include_components']['fields'] ?? true) {
            $usage['fields'] = $this->analyzeFieldUsage();
        }

        if ($options['include_components']['actions'] ?? true) {
            $usage['actions'] = $this->analyzeActionUsage();
        }

        if ($options['include_components']['notifications'] ?? true) {
            $usage['notifications'] = $this->analyzeNotificationUsage();
        }

        if ($options['include_components']['validations'] ?? true) {
            $usage['validations'] = $this->analyzeValidationUsage();
        }

        return $usage;
    }

    private function analyzeFieldUsage(): array
    {
        // Scan PHP files for Field::make() calls
        $files = $this->findPhpFiles(base_path('modules'));
        $fieldUsage = [];

        foreach ($files as $file) {
            $content = file_get_contents($file);

            // Find Field::make('field_name') patterns
            preg_match_all('/Field::make\([\'"]([^\'"]+)[\'"]/', $content, $matches);

            foreach ($matches[1] as $fieldName) {
                $key = "txt.{$fieldName}";
                if (!isset($fieldUsage[$key])) {
                    $fieldUsage[$key] = [
                        'key' => $key,
                        'field_name' => $fieldName,
                        'usage_count' => 0,
                        'files' => [],
                    ];
                }

                $fieldUsage[$key]['usage_count']++;
                $fieldUsage[$key]['files'][] = str_replace(base_path(), '', $file);
            }
        }

        return array_values($fieldUsage);
    }
}
```

---

## 📄 Template PDF

### 1. Coverage Report Template

```blade
{{-- resources/views/pdf/translation-coverage.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 60%;">
                    <h1 style="font-size: 16pt; margin: 0; color: #2c3e50;">
                        Translation Coverage Report
                    </h1>
                    <p style="font-size: 10pt; margin: 3mm 0 0 0; color: #7f8c8d;">
                        Report ID: {{ $reportId }}
                    </p>
                </td>
                <td style="width: 40%; text-align: right; font-size: 9pt;">
                    Generated: {{ $generatedAt->format('d/m/Y H:i') }}<br>
                    Locales: {{ implode(', ', $options['locales']) }}
                </td>
            </tr>
        </table>
        <div style="border-bottom: 2px solid #2c3e50; margin-top: 5mm;"></div>
    </page_header>

    <!-- Coverage Overview -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Coverage Overview</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 25%; padding: 8mm; background-color: #d4edda; border: 1px solid #dee2e6;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['coverage_statistics']['overall']['total_keys'] }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">Total Keys</div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #d4edda; border: 1px solid #dee2e6;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['coverage_statistics']['overall']['translated_keys'] }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">Translated</div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #fff3cd; border: 1px solid #dee2e6;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['coverage_statistics']['overall']['missing_keys'] }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">Missing</div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #f8d7da; border: 1px solid #dee2e6;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center; color: #2c3e50;">
                        {{ $data['coverage_statistics']['overall']['average_coverage'] }}%
                    </div>
                    <div style="font-size: 9pt; text-align: center;">Avg Coverage</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Coverage by Locale -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Coverage by Locale</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Locale
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Total
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Translated
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Missing
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Coverage
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: center;">
                    Status
                </th>
            </tr>
            @foreach($data['coverage_statistics']['by_locale'] as $locale => $stats)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ strtoupper($locale) }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['total_keys'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['translated_keys'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['missing_keys'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $stats['coverage_rate'] }}%
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    @if($stats['coverage_rate'] >= 95)
                        <span style="color: #27ae60;">✓ Excellent</span>
                    @elseif($stats['coverage_rate'] >= 80)
                        <span style="color: #f39c12;">⚠ Good</span>
                    @else
                        <span style="color: #e74c3c;">✗ Poor</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Missing Translations -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Missing Translations (Top 100)</h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Key
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Locale
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Module
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Context
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 10pt; text-align: left;">
                    Type
                </th>
            </tr>
            @foreach($data['missing_translations'] as $missing)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 8pt; font-family: monospace;">
                    {{ $missing['key'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ strtoupper($missing['locale']) }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ $missing['module'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ $missing['context'] }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ $missing['type'] }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Recommendations -->
    <div style="margin: 15mm 0;">
        <h2 style="font-size: 14pt; color: #2c3e50; margin-bottom: 8mm;">Recommendations</h2>

        @foreach($data['recommendations'] as $recommendation)
        <div style="margin-bottom: 8mm; padding: 8mm; background-color: #f8f9fa; border-left: 4px solid {{ $recommendation['priority'] == 'high' ? '#e74c3c' : '#f39c12' }};">
            <div style="font-size: 11pt; font-weight: bold; margin-bottom: 3mm;">
                {{ $recommendation['message'] }}
            </div>
            <div style="font-size: 9pt; color: #7f8c8d;">
                Action: {{ $recommendation['action'] }} | Priority: {{ $recommendation['priority'] }} | Locale: {{ $recommendation['locale'] ?? 'All' }}
            </div>
        </div>
        @endforeach
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    Lang Module Report - Generated by PTVX System
                </td>
                <td style="width: 50%; text-align: right;">
                    Page [[page_cu]] of [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

---

## 🔧 Filament Integration

### 1. Translation Report Action

```php
<?php

namespace Modules\Lang\Filament\Actions;

use Filament\Actions\Action;
use Modules\Lang\Actions\GenerateTranslationCoverageReportAction;

class ExportTranslationReportAction extends Action
{
    public static function make(string $name = 'export_translation_report'): static
    {
        return parent::make($name)
            ->label('Export Translation Report')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            ->action(function (array $data) {
                $pdf = app(GenerateTranslationCoverageReportAction::class)->execute([
                    'locales' => $data['locales'] ?? ['it', 'en'],
                    'modules' => $data['modules'] ?? ['all'],
                    'include_sections' => $data['sections'] ?? [],
                    'format' => $data['format'] ?? 'detailed',
                ]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "translation_coverage_report_{$data['format']}.pdf");
            })
            ->form([
                \Filament\Forms\Components\CheckboxList::make('locales')
                    ->label('Locales')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                        'fr' => 'Français',
                    ])
                    ->default(['it', 'en']),

                \Filament\Forms\Components\CheckboxList::make('modules')
                    ->label('Modules')
                    ->options([
                        'all' => 'All Modules',
                        'User' => 'User Module',
                        'Activity' => 'Activity Module',
                        'Gdpr' => 'GDPR Module',
                        'Job' => 'Job Module',
                    ])
                    ->default(['all']),

                \Filament\Forms\Components\CheckboxList::make('sections')
                    ->label('Include Sections')
                    ->options([
                        'statistics' => 'Coverage Statistics',
                        'missing_translations' => 'Missing Translations',
                        'unused_translations' => 'Unused Translations',
                        'locale_comparison' => 'Locale Comparison',
                    ])
                    ->default(['statistics', 'missing_translations']),

                \Filament\Forms\Components\Select::make('format')
                    ->label('Report Format')
                    ->options([
                        'summary' => 'Summary',
                        'detailed' => 'Detailed',
                    ])
                    ->default('detailed'),
            ]);
    }
}
```

### 2. Usage Report Action

```php
class ExportUsageReportAction extends Action
{
    public static function make(string $name = 'export_usage_report'): static
    {
        return parent::make($name)
            ->label('Export Usage Report')
            ->icon('heroicon-o-chart-bar')
            ->color('success')
            ->action(function (array $data) {
                $pdf = app(GenerateTranslationUsageReportAction::class)->execute([
                    'date_range' => [
                        'start' => \Carbon\Carbon::parse($data['start_date']),
                        'end' => \Carbon\Carbon::parse($data['end_date']),
                    ],
                    'include_components' => $data['components'] ?? [],
                    'group_by' => $data['group_by'] ?? 'module',
                ]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, "translation_usage_report_{$data['start_date']}_to_{$data['end_date']}.pdf");
            })
            ->form([
                \Filament\Forms\Components\DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required()
                    ->default(now()->subMonth()),

                \Filament\Forms\Components\DatePicker::make('end_date')
                    ->label('End Date')
                    ->required()
                    ->default(now()),

                \Filament\Forms\Components\CheckboxList::make('components')
                    ->label('Include Components')
                    ->options([
                        'fields' => 'Form Fields',
                        'actions' => 'Actions',
                        'notifications' => 'Notifications',
                        'validations' => 'Validations',
                    ])
                    ->default(['fields', 'actions']),

                \Filament\Forms\Components\Select::make('group_by')
                    ->label('Group By')
                    ->options([
                        'module' => 'Module',
                        'locale' => 'Locale',
                        'type' => 'Type',
                    ])
                    ->default('module'),
            ]);
    }
}
```

---

## 🧪 Testing

### 1. Unit Tests

```php
<?php

namespace Modules\Lang\Tests\Unit;

use Tests\TestCase;
use Modules\Lang\Services\TranslationReportService;

class TranslationReportTest extends TestCase
{
    /** @test */
    public function it_generates_coverage_report()
    {
        // Create test translations
        Translation::factory()->count(100)->create();

        $service = app(TranslationReportService::class);
        $pdfContent = $service->generateCoverageReport([
            'locales' => ['it', 'en'],
        ]);

        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(2000, strlen($pdfContent));
        $this->assertStringContainsString('Translation Coverage Report', $pdfContent);
        $this->assertStringContainsString('Coverage Overview', $pdfContent);
    }

    /** @test */
    public function it_includes_missing_translations()
    {
        Translation::factory()->create([
            'key' => 'test.key',
            'locale' => 'it',
            'value' => 'Test Value',
        ]);

        $service = app(TranslationReportService::class);
        $pdfContent = $service->generateCoverageReport([
            'locales' => ['it', 'en'],
            'include_sections' => ['missing_translations'],
        ]);

        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertStringContainsString('Missing Translations', $pdfContent);
    }

    /** @test */
    public function it_handles_large_translation_sets()
    {
        // Create large dataset
        Translation::factory()->count(2000)->create();

        $startTime = microtime(true);

        $service = app(TranslationReportService::class);
        $pdfContent = $service->generateCoverageReport();

        $duration = microtime(true) - $startTime;

        // Should generate within reasonable time
        $this->assertLessThan(10, $duration);
        $this->assertStringStartsWith('%PDF', $pdfContent);
    }
}
```

---

## 📊 Performance Optimization

### 1. Caching Strategy

```php
class TranslationReportService
{
    public function generateCachedCoverageReport(array $options = []): string
    {
        $cacheKey = 'translation_coverage_report_' . md5(json_encode([
            'options' => $options,
            'last_translation' => Translation::max('updated_at'),
        ]));

        return Cache::remember($cacheKey, 3600, function () use ($options) { // 1 hour
            return $this->generateCoverageReport($options);
        });
    }
}
```

### 2. Memory Management

```php
private function optimizeForLargeTranslationSets($query)
{
    // Use chunking for large datasets
    $query->chunk(500, function ($translations) {
        // Process in chunks
    });

    // Limit data for PDF
    return $query->limit(1000)->get();
}
```

---

## 🚀 Error Handling

```php
public function generateWithErrorHandling(array $options = []): string
{
    try {
        return $this->generateCoverageReport($options);

    } catch (Html2PdfException $e) {
        Log::error('Translation PDF generation failed', [
            'error' => $e->getMessage(),
            'options' => $options,
        ]);

        // Generate simplified fallback
        return $this->generateFallbackReport($options);

    } catch (Exception $e) {
        Log::error('Unexpected error in translation PDF generation', [
            'error' => $e->getMessage(),
        ]);

        throw new TranslationReportException('Failed to generate translation report');
    }
}
```

---

## 📚 References

- [HTML2PDF Best Practices](../Xot/docs/html2pdf-best-practices.md)
- [Lang Module README](./README.md)
- [Spatie Translatable Documentation](https://github.com/spatie/laravel-translatable)
- [Laravel Localization](https://laravel.com/docs/localization)

---

**Last Updated:** 2025-12-09
**Version:** 1.0.0
**HTML2PDF Version:** 5.2.x
**PHPStan Level:** 10 ✅
