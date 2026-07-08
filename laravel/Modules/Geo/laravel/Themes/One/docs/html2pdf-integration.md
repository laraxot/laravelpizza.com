# HTML2PDF Integration for Theme One

## 📋 Overview

This document explains how Theme One integrates with the HTML2PDF library for generating PDF documents that maintain the theme's visual consistency.

---

## 🎨 Theme-Specific PDF Styling

### 1. Color Palette

Theme One uses a consistent color scheme across PDFs:

```php
// config/theme-one.php
return [
    'pdf_colors' => [
        'primary' => '#2c3e50',      // Dark blue-gray
        'secondary' => '#34495e',    // Lighter blue-gray
        'accent' => '#3498db',       // Bright blue
        'success' => '#27ae60',      // Green
        'warning' => '#f39c12',      // Orange
        'danger' => '#e74c3c',       // Red
        'light' => '#ecf0f1',        // Light gray
        'dark' => '#2c3e50',         // Dark blue-gray
        'muted' => '#7f8c8d',        // Muted gray
    ],
];
```

### 2. Typography

```blade
{{-- PDF Typography Helpers --}}
@php
$fontStack = "'Helvetica', 'Arial', sans-serif";
$headingFont = "'Helvetica Bold', 'Arial Bold', sans-serif";
@endphp

<h1 style="font-family: {{ $headingFont }}; font-size: 18pt; color: {{ config('theme-one.pdf_colors.primary') }};">
    {{ $title }}
</h1>

<p style="font-family: {{ $fontStack }}; font-size: 11pt; line-height: 1.4; color: {{ config('theme-one.pdf_colors.dark') }};">
    {{ $content }}
</p>
```

---

## 📄 PDF Layout Templates

### 1. Standard Document Layout

```blade
{{-- resources/views/pdf/standard-document.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm" 
      orientation="P" format="A4" style="font-family: 'Helvetica';">
      
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;">
                    @if($logo)
                        <img src="{{ $logo }}" style="width: 25mm; height: auto;" />
                    @endif
                </td>
                <td style="width: 50%; text-align: right; font-size: 10pt; color: #7f8c8d;">
                    Documento del {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </td>
            </tr>
        </table>
        <div style="border-bottom: 1px solid {{ config('theme-one.pdf_colors.primary') }}; margin-top: 5mm;"></div>
    </page_header>

    <div style="margin: 15mm 0;">
        <h1 style="font-size: 16pt; color: {{ config('theme-one.pdf_colors.primary') }}; margin-bottom: 10mm;">
            {{ $title }}
        </h1>
        
        {!! $content !!}
    </div>

    <page_footer>
        <div style="border-top: 1px solid {{ config('theme-one.pdf_colors.primary') }}; margin-bottom: 5mm;"></div>
        <table style="width: 100%; font-size: 9pt; color: #7f8c8d;">
            <tr>
                <td style="width: 50%;">
                    © {{ date('Y') }} PTVX - Sistema di Gestione
                </td>
                <td style="width: 50%; text-align: right;">
                    Pagina [[page_cu]] di [[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

### 2. Report Layout

```blade
{{-- resources/views/pdf/report.blade.php --}}
<page backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm">
    <page_header>
        <div style="background-color: {{ config('theme-one.pdf_colors.primary') }}; color: white; padding: 5mm;">
            <h1 style="font-size: 14pt; margin: 0;">{{ $reportTitle }}</h1>
            @if($subtitle)
                <p style="font-size: 10pt; margin: 2mm 0 0 0;">{{ $subtitle }}</p>
            @endif
        </div>
    </page_header>

    @if($summary)
    <div style="background-color: {{ config('theme-one.pdf_colors.light') }}; padding: 10mm; margin: 10mm 0; border-left: 3mm solid {{ config('theme-one.pdf_colors.accent') }};">
        <h2 style="font-size: 12pt; margin: 0 0 5mm 0;">Riepilogo</h2>
        {!! $summary !!}
    </div>
    @endif

    <div style="margin: 10mm 0;">
        {!! $content !!}
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 8pt; color: #7f8c8d;">
            <tr>
                <td>
                    Generato il: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
                </td>
                <td style="text-align: right;">
                    PTVX Theme One - Pag. [[page_cu]]/[[page_nb]]
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

---

## 🎯 Component Helpers

### 1. Alert Boxes

```blade
{{-- resources/views/pdf/components/alert.blade.php --}}
@php
$alertColors = [
    'success' => config('theme-one.pdf_colors.success'),
    'warning' => config('theme-one.pdf_colors.warning'),
    'danger' => config('theme-one.pdf_colors.danger'),
    'info' => config('theme-one.pdf_colors.accent'),
];
@endphp

<div style="background-color: {{ $alertColors[$type] ?? '#ecf0f1' }}; 
            color: white; 
            padding: 8mm; 
            margin: 5mm 0; 
            border-radius: 2mm;">
    <strong>{{ $title }}</strong><br>
    <span style="font-size: 10pt;">{{ $message }}</span>
</div>
```

Usage:
```blade
@include('pdf.components.alert', [
    'type' => 'warning',
    'title' => 'Attenzione',
    'message' => 'Questo documento contiene informazioni sensibili'
])
```

### 2. Data Tables

```blade
{{-- resources/views/pdf/components/data-table.blade.php --}}
<table style="width: 100%; border-collapse: collapse; margin: 10mm 0;">
    <thead>
        <tr style="background-color: {{ config('theme-one.pdf_colors.primary') }}; color: white;">
            @foreach($headers as $header)
            <th style="border: 1px solid #2c3e50; padding: 5mm; font-size: 10pt; text-align: left;">
                {{ $header }}
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($rows as $row)
        <tr style="{{ $loop->index % 2 == 0 ? 'background-color: #f8f9fa;' : '' }}">
            @foreach($row as $cell)
            <td style="border: 1px solid #dee2e6; padding: 4mm; font-size: 9pt;">
                {{ $cell }}
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
```

---

## 📊 Chart Integration

### 1. Simple Charts as Tables

```blade
{{-- resources/views/pdf/components/bar-chart.blade.php --}}
<table style="width: 100%; border-collapse: collapse;">
    @foreach($data as $item)
    <tr>
        <td style="width: 30%; padding: 3mm; font-size: 9pt;">{{ $item['label'] }}</td>
        <td style="width: 60%; padding: 3mm;">
            <div style="background-color: #ecf0f1; height: 8mm; position: relative;">
                <div style="background-color: {{ config('theme-one.pdf_colors.accent') }}; 
                            height: 100%; 
                            width: {{ $item['percentage'] }}%; 
                            position: absolute;">
                </div>
            </div>
        </td>
        <td style="width: 10%; padding: 3mm; font-size: 9pt; text-align: right;">
            {{ $item['value'] }}
        </td>
    </tr>
    @endforeach
</table>
```

### 2. QR Codes with Theme Styling

```blade
{{-- resources/views/pdf/components/qr-code.blade.php --}}
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 40mm; padding: 5mm; text-align: center; vertical-align: top;">
            <qrcode value="{{ $url }}" ec="H" style="width: 30mm;"></qrcode>
            <p style="font-size: 8pt; margin: 3mm 0 0 0;">Scansiona per dettagli</p>
        </td>
        <td style="padding: 5mm; vertical-align: top;">
            <h3 style="font-size: 11pt; color: {{ config('theme-one.pdf_colors.primary') }}; margin: 0 0 3mm 0;">
                {{ $title }}
            </h3>
            <p style="font-size: 9pt; margin: 0; color: #7f8c8d;">
                {{ $description }}
            </p>
        </td>
    </tr>
</table>
```

---

## 🔧 Theme Configuration

### 1. PDF Service Provider

```php
<?php

namespace Themes\One\Providers;

use Illuminate\Support\ServiceProvider;
use Spipu\Html2Pdf\Html2Pdf;

class PdfServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('theme-one.pdf', function ($app) {
            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [15, 15, 15, 15]);
            
            // Set default font for theme consistency
            $html2pdf->setDefaultFont('Helvetica');
            
            return $html2pdf;
        });
    }
    
    public function boot()
    {
        // Share theme colors with all views
        view()->share('themeColors', config('theme-one.pdf_colors'));
    }
}
```

### 2. Theme Helper Functions

```php
<?php

// Themes/One/helpers.php

if (!function_exists('theme_pdf_color')) {
    function theme_pdf_color(string $key): string
    {
        return config("theme-one.pdf_colors.{$key}", '#000000');
    }
}

if (!function_exists('theme_pdf_style')) {
    function theme_pdf_style(array $properties): string
    {
        $styles = [];
        
        foreach ($properties as $property => $value) {
            if (str_contains($property, 'color')) {
                $value = theme_pdf_color($value);
            }
            $styles[] = "{$property}: {$value}";
        }
        
        return implode('; ', $styles);
    }
}
```

---

## 📱 Responsive PDF Design

### 1. Adaptive Layouts

```blade
{{-- resources/views/pdf/adaptive.blade.php --}}
<page orientation="{{ $data->count() > 50 ? 'L' : 'P' }}" format="A4">
    @if($data->count() > 50)
        {{-- Landscape layout for large datasets --}}
        <table style="width: 100%; font-size: 8pt;">
            <thead>...</thead>
            <tbody>...</tbody>
        </table>
    @else
        {{-- Portrait layout for standard content --}}
        <div style="font-size: 11pt;">
            {!! $content !!}
        </div>
    @endif
</page>
```

### 2. Dynamic Font Sizing

```php
// In controller
public function generatePdf($data)
{
    $fontSize = $data->count() > 100 ? '8pt' : 
                ($data->count() > 50 ? '9pt' : '10pt');
    
    return view('pdf.adaptive', compact('data', 'fontSize'));
}
```

---

## 🚀 Performance Optimization

### 1. Asset Caching

```php
// Themes/One/Services/PdfAssetService.php
class PdfAssetService
{
    public function getLogoBase64(): string
    {
        return Cache::remember('theme-one.pdf.logo', 86400, function () {
            $path = public_path('themes/one/assets/logo.png');
            if (!file_exists($path)) {
                return '';
            }
            
            $imageData = file_get_contents($path);
            return 'data:image/png;base64,' . base64_encode($imageData);
        });
    }
    
    public function getStyles(): array
    {
        return Cache::remember('theme-one.pdf.styles', 3600, function () {
            return [
                'primary' => config('theme-one.pdf_colors.primary'),
                'secondary' => config('theme-one.pdf_colors.secondary'),
                'font_stack' => "'Helvetica', 'Arial', sans-serif",
            ];
        });
    }
}
```

### 2. Template Pre-compilation

```php
// Pre-compile frequently used PDF templates
public function precompileTemplates(): void
{
    $templates = [
        'pdf.invoice',
        'pdf.report',
        'pdf.certificate',
    ];
    
    foreach ($templates as $template) {
        $compiled = view($template)->render();
        Cache::put("compiled.{$template}", $compiled, 3600);
    }
}
```

---

## 📋 Testing Theme PDFs

### 1. Visual Regression Tests

```php
<?php

namespace Tests\Feature\ThemeOne;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PdfGenerationTest extends TestCase
{
    /** @test */
    public function it_generates_pdf_with_theme_styling()
    {
        $data = [
            'title' => 'Test Document',
            'content' => 'Test content with theme styling',
        ];
        
        $pdf = app(ContentPdfAction::class)->execute(
            view: 'pdf.theme-one-document',
            data: $data
        );
        
        // Verify PDF contains theme colors
        $this->assertStringContainsString('2c3e50', $pdf); // Primary color
        $this->assertStringContainsString('3498db', $pdf); // Accent color
    }
    
    /** @test */
    public function it_applies_correct_typography()
    {
        $pdf = app(ContentPdfAction::class)->execute(
            view: 'pdf.theme-one-document',
            data: ['title' => 'Typography Test']
        );
        
        // Verify Helvetica font is used
        $this->assertStringContainsString('Helvetica', $pdf);
    }
}
```

### 2. Performance Benchmarks

```php
/** @test */
public function pdf_generation_performance_is_acceptable()
{
    $startTime = microtime(true);
    
    app(ContentPdfAction::class)->execute(
        view: 'pdf.large-report',
        data: $this->getLargeDataSet()
    );
    
    $duration = microtime(true) - $startTime;
    
    // Should generate within 5 seconds
    $this->assertLessThan(5.0, $duration);
}
```

---

## 🔄 Migration from Other Themes

### Converting Existing PDFs

```php
// Migration helper to convert existing PDF templates
class ThemePdfMigrator
{
    public function convertTemplate(string $oldTemplate, string $newTemplate): void
    {
        $content = file_get_contents(resource_path("views/{$oldTemplate}"));
        
        // Replace old color scheme
        $content = str_replace([
            '#old-primary',
            '#old-secondary',
        ], [
            config('theme-one.pdf_colors.primary'),
            config('theme-one.pdf_colors.secondary'),
        ], $content);
        
        // Update font references
        $content = str_replace('font-family: Arial', 'font-family: Helvetica', $content);
        
        file_put_contents(resource_path("views/{$newTemplate}"), $content);
    }
}
```

---

## 📚 Resources

### Theme-Specific Documentation
- [Theme One Overview](./README.md)
- [Theme Color System](./color-system.md)
- [Typography Guidelines](./typography.md)

### PDF Integration
- [HTML2PDF Best Practices](../../Modules/Xot/docs/html2pdf-best-practices.md)
- [PDF Actions Overview](../../Modules/Xot/docs/actions/pdf-actions-overview.md)
- [HTML2PDF Complete Guide](../../Modules/Xot/docs/html2pdf-complete-guide.md)

---

**Last Updated:** December 2025  
**Theme Version:** One 1.x  
**Framework:** Laraxot/PTVX  
**HTML2PDF Version:** 5.2.x