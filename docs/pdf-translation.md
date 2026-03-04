# PDF Translation Guide - HTML2PDF Integration

## 📋 Overview

Guida completa per generare documenti PDF multilingua utilizzando HTML2PDF con il sistema di traduzione del modulo Lang.

---

## 🎯 Funzionalità PDF Multilingua

### 1. Traduzione Automatica Template

Generazione PDF con traduzione automatica basata sulla lingua corrente:

```php
use Modules\Lang\Services\PdfTranslationService;

// Generate PDF with current locale
$pdf = app(PdfTranslationService::class)->generatePdf([
    'template' => 'invoice',
    'data' => $invoiceData,
    'auto_translate' => true,
]);
```

### 2. PDF Multi-Lingua

Generazione dello stesso PDF in più lingue:

```php
// Generate PDF in multiple languages
$pdfService = app(PdfTranslationService::class);

foreach (['it', 'en', 'de'] as $locale) {
    $pdf = $pdfService->generatePdf([
        'template' => 'contract',
        'locale' => $locale,
        'data' => $contractData,
    ]);

    // Save PDF with locale suffix
    file_put_contents("contract_{$locale}.pdf", $pdf);
}
```

### 3. PDF con Placeholder Dinamici

Utilizzo di placeholder con parametri tradotti:

```blade
{{-- resources/views/pdf/dynamic-content.blade.php --}}
<page>
    <div>
        <h1>{{ __('lang::pdf.welcome', ['name' => $user->name]) }}</h1>
        <p>{{ __('lang::pdf.document_date', ['date' => now()->format('d/m/Y')]) }}</p>

        @foreach($items as $item)
        <div>
            <strong>{{ __('lang::pdf.item') }}:</strong> {{ $item->name }}
            <span>{{ __('lang::pdf.price') }}:</span> €{{ number_format($item->price, 2) }}
        </div>
        @endforeach
    </div>
</page>
```

---

## 🏗️ Architettura PDF Translation

### 1. PDF Translation Service

```php
<?php

namespace Modules\Lang\Services;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;

class PdfTranslationService
{
    public function generatePdf(array $options = []): string
    {
        try {
            // Set locale for translations
            $locale = $options['locale'] ?? app()->getLocale();
            app()->setLocale($locale);

            // Prepare translated data
            $translatedData = $this->translateData($options['data'], $locale);

            // Render template with translations
            $html = view($options['template'], [
                'data' => $translatedData,
                'locale' => $locale,
                'translations' => $this->getTranslations($locale),
            ])->render();

            // Clean HTML for HTML2PDF
            $html = $this->cleanHtmlForPdf($html);

            // Generate PDF
            $html2pdf = new Html2Pdf(
                $options['orientation'] ?? 'P',
                $options['format'] ?? 'A4',
                $locale,
                true,
                'UTF-8',
                $options['margins'] ?? [15, 20, 15, 20]
            );

            $html2pdf->setDefaultFont($this->getFontForLocale($locale));
            $html2pdf->writeHTML($html);

            return $html2pdf->output('', 'S');

        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            throw new PdfTranslationException('Failed to generate translated PDF: ' . $e->getMessage());
        }
    }

    private function translateData(array $data, string $locale): array
    {
        $translator = app('translator');

        return collect($data)->mapWithKeys(function ($value, $key) use ($translator, $locale) {
            if (is_string($value) && str_starts_with($value, 'lang::')) {
                return [$key => $translator->get($value, [], $locale)];
            }

            if (is_array($value)) {
                return [$key => $this->translateData($value, $locale)];
            }

            return [$key => $value];
        })->toArray();
    }

    private function getTranslations(string $locale): array
    {
        return [
            'months' => [
                'january' => __('lang::months.january', [], $locale),
                'february' => __('lang::months.february', [], $locale),
                // ... other months
            ],
            'formats' => [
                'date' => __('lang::formats.date', [], $locale),
                'datetime' => __('lang::formats.datetime', [], $locale),
                'currency' => __('lang::formats.currency', [], $locale),
            ],
        ];
    }

    private function getFontForLocale(string $locale): string
    {
        return match($locale) {
            'it', 'de', 'fr' => 'Helvetica',
            'en' => 'Times-Roman',
            default => 'Helvetica',
        };
    }

    private function cleanHtmlForPdf(string $html): string
    {
        // Remove script tags
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);

        // Remove style tags (HTML2PDF doesn't support them)
        $html = preg_replace('/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/mi', '', $html);

        // Convert special characters
        $html = str_replace('&nbsp;', ' ', $html);

        return $html;
    }
}
```

### 2. Multi-Lingua PDF Generator

```php
class MultiLinguaPdfGenerator
{
    public function generateForAllLocales(array $options): array
    {
        $locales = $options['locales'] ?? ['it', 'en'];
        $results = [];

        foreach ($locales as $locale) {
            try {
                $pdf = app(PdfTranslationService::class)->generatePdf([
                    'template' => $options['template'],
                    'locale' => $locale,
                    'data' => $options['data'],
                    'filename' => str_replace('.pdf', "_{$locale}.pdf", $options['filename'] ?? 'document.pdf'),
                ]);

                $results[$locale] = [
                    'success' => true,
                    'content' => $pdf,
                    'size' => strlen($pdf),
                ];

            } catch (Exception $e) {
                $results[$locale] = [
                    'success' => false,
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }
}
```

---

## 📄 Template PDF Multilingua

### 1. Fattura Multilingua

```blade
{{-- resources/views/pdf/invoice.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;">
                    <h1 style="font-size: 14pt; margin: 0;">
                        {{ __('lang::invoice.title') }}
                    </h1>
                    <p style="font-size: 10pt; margin: 3mm 0 0 0;">
                        {{ __('lang::invoice.number') }}: {{ $invoice->number }}
                    </p>
                </td>
                <td style="width: 50%; text-align: right; font-size: 9pt;">
                    {{ __('lang::invoice.date') }}: {{ $invoice->date->format('d/m/Y') }}<br>
                    {{ __('lang::invoice.due_date') }}: {{ $invoice->due_date->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </page_header>

    <div style="margin: 15mm 0;">
        <!-- Client Information -->
        <div style="margin-bottom: 10mm;">
            <h2 style="font-size: 12pt;">
                {{ __('lang::invoice.billing_address') }}
            </h2>
            <div style="font-size: 10pt;">
                {{ $client->name }}<br>
                {{ $client->address }}<br>
                {{ $client->city }}, {{ $client->postal_code }}<br>
                {{ $client->country }}
            </div>
        </div>

        <!-- Invoice Items -->
        <h2 style="font-size: 12pt; margin-bottom: 5mm;">
            {{ __('lang::invoice.items') }}
        </h2>

        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #e9ecef;">
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 9pt; text-align: left;">
                    {{ __('lang::invoice.description') }}
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 9pt; text-align: center;">
                    {{ __('lang::invoice.quantity') }}
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 9pt; text-align: right;">
                    {{ __('lang::invoice.unit_price') }}
                </th>
                <th style="border: 1px solid #dee2e6; padding: 5mm; font-size: 9pt; text-align: right;">
                    {{ __('lang::invoice.total') }}
                </th>
            </tr>
            @foreach($invoice->items as $item)
            <tr>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                    {{ $item->description }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: center;">
                    {{ $item->quantity }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: right;">
                    €{{ number_format($item->unit_price, 2) }}
                </td>
                <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt; text-align: right;">
                    €{{ number_format($item->total, 2) }}
                </td>
            </tr>
            @endforeach
        </table>

        <!-- Totals -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 10mm;">
            <tr>
                <td style="width: 70%; padding: 4mm; font-size: 10pt; text-align: right;">
                    {{ __('lang::invoice.subtotal') }}:
                </td>
                <td style="width: 30%; padding: 4mm; font-size: 10pt; text-align: right;">
                    €{{ number_format($invoice->subtotal, 2) }}
                </td>
            </tr>
            <tr>
                <td style="width: 70%; padding: 4mm; font-size: 10pt; text-align: right;">
                    {{ __('lang::invoice.vat') }} ({{ $invoice->vat_rate }}%):
                </td>
                <td style="width: 30%; padding: 4mm; font-size: 10pt; text-align: right;">
                    €{{ number_format($invoice->vat_amount, 2) }}
                </td>
            </tr>
            <tr style="background-color: #f8f9fa; font-weight: bold;">
                <td style="width: 70%; padding: 4mm; font-size: 11pt; text-align: right;">
                    {{ __('lang::invoice.total') }}:
                </td>
                <td style="width: 30%; padding: 4mm; font-size: 11pt; text-align: right;">
                    €{{ number_format($invoice->total, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    {{ __('lang::invoice.footer_text') }}
                </td>
                <td style="width: 50%; text-align: right;">
                    {{ __('lang::invoice.page') }} [[page_cu]] {{ __('lang::invoice.of') }} [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

### 2. Report Analitico Multilingua

```blade
{{-- resources/views/pdf/analytics-report.blade.php --}}
<page>
    <page_header>
        <h1 style="font-size: 16pt; text-align: center;">
            {{ __('lang::reports.analytics.title') }}
        </h1>
        <p style="text-align: center; font-size: 10pt;">
            {{ __('lang::reports.period') }}: {{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}
        </p>
    </page_header>

    <div style="margin: 15mm 0;">
        <!-- Summary Cards -->
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15mm;">
            <tr>
                <td style="width: 25%; padding: 8mm; background-color: #3498db; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $totalUsers }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        {{ __('lang::reports.metrics.total_users') }}
                    </div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #27ae60; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $activeUsers }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        {{ __('lang::reports.metrics.active_users') }}
                    </div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #f39c12; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        {{ $conversionRate }}%
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        {{ __('lang::reports.metrics.conversion_rate') }}
                    </div>
                </td>
                <td style="width: 25%; padding: 8mm; background-color: #e74c3c; color: white;">
                    <div style="font-size: 18pt; font-weight: bold; text-align: center;">
                        €{{ number_format($revenue, 0) }}
                    </div>
                    <div style="font-size: 9pt; text-align: center;">
                        {{ __('lang::reports.metrics.revenue') }}
                    </div>
                </td>
            </tr>
        </table>

        <!-- Charts Section -->
        <h2 style="font-size: 14pt; margin-bottom: 8mm;">
            {{ __('lang::reports.charts.title') }}
        </h2>

        <div style="margin-bottom: 10mm;">
            <h3 style="font-size: 12pt;">
                {{ __('lang::reports.charts.user_growth') }}
            </h3>
            <p style="font-size: 10px; color: #7f8c8d;">
                {{ __('lang::reports.charts.description', ['period' => 'monthly']) }}
            </p>

            <!-- Simple chart representation -->
            <table style="width: 100%; border-collapse: collapse;">
                @foreach($monthlyData as $month => $count)
                <tr>
                    <td style="width: 30%; padding: 3mm; font-size: 9pt;">
                        {{ __('lang::months.' . strtolower($month)) }}
                    </td>
                    <td style="width: 70%; padding: 3mm;">
                        <div style="background-color: #ecf0f1; height: 8mm;">
                            <div style="background-color: #3498db; height: 100%; width: {{ ($count / $maxUsers) * 100 }}%;"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</page>
```

---

## 📚 File di Traduzione PDF

### 1. Italiano (it)

```php
// Modules/Lang/lang/it/pdf.php
return [
    // General PDF terms
    'page' => 'Pagina',
    'of' => 'di',
    'generated_at' => 'Generato il',
    'confidential' => 'Riservato',

    // Invoice translations
    'invoice' => [
        'title' => 'Fattura',
        'number' => 'Numero Fattura',
        'date' => 'Data',
        'due_date' => 'Data Scadenza',
        'billing_address' => 'Indirizzo di Fatturazione',
        'items' => 'Articoli',
        'description' => 'Descrizione',
        'quantity' => 'Quantità',
        'unit_price' => 'Prezzo Unitario',
        'total' => 'Totale',
        'subtotal' => 'Subtotale',
        'vat' => 'IVA',
        'vat_rate' => 'Aliquota IVA',
        'footer_text' => 'Grazie per il vostro business',
    ],

    // Reports translations
    'reports' => [
        'analytics' => [
            'title' => 'Report Analitico',
            'period' => 'Periodo',
        ],
        'metrics' => [
            'total_users' => 'Utenti Totali',
            'active_users' => 'Utenti Attivi',
            'conversion_rate' => 'Tasso di Conversione',
            'revenue' => 'Fatturato',
        ],
        'charts' => [
            'title' => 'Grafici',
            'user_growth' => 'Crescita Utenti',
            'description' => 'Andamento :period',
        ],
    ],

    // Common terms
    'welcome' => 'Benvenuto :name',
    'document_date' => 'Data documento: :date',
    'item' => 'Articolo',
    'price' => 'Prezzo',
];
```

### 2. English (en)

```php
// Modules/Lang/lang/en/pdf.php
return [
    // General PDF terms
    'page' => 'Page',
    'of' => 'of',
    'generated_at' => 'Generated on',
    'confidential' => 'Confidential',

    // Invoice translations
    'invoice' => [
        'title' => 'Invoice',
        'number' => 'Invoice Number',
        'date' => 'Date',
        'due_date' => 'Due Date',
        'billing_address' => 'Billing Address',
        'items' => 'Items',
        'description' => 'Description',
        'quantity' => 'Quantity',
        'unit_price' => 'Unit Price',
        'total' => 'Total',
        'subtotal' => 'Subtotal',
        'vat' => 'VAT',
        'vat_rate' => 'VAT Rate',
        'footer_text' => 'Thank you for your business',
    ],

    // Reports translations
    'reports' => [
        'analytics' => [
            'title' => 'Analytics Report',
            'period' => 'Period',
        ],
        'metrics' => [
            'total_users' => 'Total Users',
            'active_users' => 'Active Users',
            'conversion_rate' => 'Conversion Rate',
            'revenue' => 'Revenue',
        ],
        'charts' => [
            'title' => 'Charts',
            'user_growth' => 'User Growth',
            'description' => ':period trend',
        ],
    ],

    // Common terms
    'welcome' => 'Welcome :name',
    'document_date' => 'Document date: :date',
    'item' => 'Item',
    'price' => 'Price',
];
```

---

## 🔧 Filament Integration

### 1. PDF Export with Language Selection

```php
use Modules\Lang\Filament\Actions\ExportTranslatedPdfAction;

class InvoiceResource extends XotBaseResource
{
    public static function getActions(): array
    {
        return [
            ExportTranslatedPdfAction::make(),
            // ... other actions
        ];
    }
}
```

### 2. Multi-Language PDF Action

```php
class ExportTranslatedPdfAction extends Action
{
    public static function make(string $name = 'export_translated_pdf'): static
    {
        return parent::make($name)
            ->label('Export PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->color('primary')
            ->action(function (array $data, $record) {
                $pdfService = app(PdfTranslationService::class);

                $pdf = $pdfService->generatePdf([
                    'template' => 'invoice',
                    'locale' => $data['locale'],
                    'data' => [
                        'invoice' => $record,
                        'client' => $record->client,
                    ],
                ]);

                $filename = "invoice_{$record->number}_{$data['locale']}.pdf";

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf;
                }, $filename);
            })
            ->form([
                Select::make('locale')
                    ->label('Language')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                        'fr' => 'Français',
                    ])
                    ->required()
                    ->default(app()->getLocale()),
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
use Modules\Lang\Services\PdfTranslationService;

class PdfTranslationTest extends TestCase
{
    /** @test */
    public function it_generates_pdf_with_italian_translations()
    {
        $service = app(PdfTranslationService::class);

        $pdf = $service->generatePdf([
            'template' => 'test.invoice',
            'locale' => 'it',
            'data' => [
                'invoice' => [
                    'number' => 'INV-001',
                    'date' => now(),
                ],
            ],
        ]);

        $this->assertStringStartsWith('%PDF', $pdf);
        $this->assertStringContainsString('Fattura', $pdf);
        $this->assertStringContainsString('Numero Fattura', $pdf);
    }

    /** @test */
    public function it_generates_pdf_with_english_translations()
    {
        $service = app(PdfTranslationService::class);

        $pdf = $service->generatePdf([
            'template' => 'test.invoice',
            'locale' => 'en',
            'data' => [
                'invoice' => [
                    'number' => 'INV-001',
                    'date' => now(),
                ],
            ],
        ]);

        $this->assertStringStartsWith('%PDF', $pdf);
        $this->assertStringContainsString('Invoice', $pdf);
        $this->assertStringContainsString('Invoice Number', $pdf);
    }

    /** @test */
    public function it_handles_missing_translations_gracefully()
    {
        $service = app(PdfTranslationService::class);

        $pdf = $service->generatePdf([
            'template' => 'test.invoice',
            'locale' => 'fr', // Missing translations
            'data' => [
                'invoice' => [
                    'number' => 'INV-001',
                ],
            ],
        ]);

        $this->assertStringStartsWith('%PDF', $pdf);
        // Should fallback to key or default value
    }
}
```

---

## 📊 Performance Optimization

### 1. Translation Caching

```php
class PdfTranslationService
{
    private array $translationCache = [];

    private function getTranslations(string $locale): array
    {
        if (!isset($this->translationCache[$locale])) {
            $this->translationCache[$locale] = [
                'months' => $this->loadMonthTranslations($locale),
                'formats' => $this->loadFormatTranslations($locale),
                'common' => $this->loadCommonTranslations($locale),
            ];
        }

        return $this->translationCache[$locale];
    }
}
```

### 2. Batch PDF Generation

```php
class BatchPdfGenerator
{
    public function generateBatch(array $documents): array
    {
        $results = [];

        foreach ($documents as $document) {
            try {
                $pdf = app(PdfTranslationService::class)->generatePdf($document);
                $results[] = [
                    'success' => true,
                    'filename' => $document['filename'],
                    'content' => $pdf,
                ];
            } catch (Exception $e) {
                $results[] = [
                    'success' => false,
                    'filename' => $document['filename'],
                    'error' => $e->getMessage(),
                ];
            }
        }

        return $results;
    }
}
```

---

## 📚 References

- [HTML2PDF Best Practices](../xot/docs/html2pdf-best-practices.md)
- [Lang Module README](./readme.md)
- [Filament Internationalization](https://filamentphp.com/docs/3.x/panels/translations)
- [Laravel Localization](https://laravel.com/docs/localization)

---

**
**Version:** 1.0.0
**HTML2PDF Version:** 5.2.x
**PHPStan Level:** 10 ✅
