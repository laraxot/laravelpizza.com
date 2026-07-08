# HTML2PDF Migration Guide for Progressioni

## 📋 Overview

This guide provides step-by-step instructions for migrating Progressioni module PDF generation to use HTML2PDF best practices, avoiding common parsing errors and ensuring reliable PDF generation.

---

## 🚨 Common Issues in Progressioni

### 1. HTML Parsing Errors

The Progressioni module frequently encounters these HTML2PDF parsing errors:

- **HtmlParsingException**: "Too many tag closures found for [style]"
- **ImageException**: Missing or invalid image paths
- **TableException**: Tables with complex structures
- **LongSentenceException**: Text content exceeding limits

### 2. Root Causes

1. **CSS Style Tags**: Using `<style>` blocks instead of inline CSS
2. **Malformed HTML**: Unclosed tags or invalid nesting
3. **Complex Layouts**: CSS float/position not supported
4. **Large Content**: Exceeding memory limits

---

## 🔄 Migration Strategy

### Phase 1: Audit Existing Templates

```bash
# Find all PDF templates in Progressioni
find Modules/Progressioni/resources/views -name "*.pdf.blade.php" -o -name "*pdf*.blade.php"

# Validate HTML syntax
find Modules/Progressioni/resources/views -name "*.pdf.blade.php" -exec tidy -q -e {} \;
```

### Phase 2: Identify Problematic Patterns

Search for these anti-patterns:
```bash
# Find style tags
grep -r "<style" Modules/Progressioni/resources/views/

# Find external stylesheets
grep -r "link.*stylesheet" Modules/Progressioni/resources/views/

# Find complex CSS
grep -r "float:\|position:\|display:" Modules/Progressioni/resources/views/
```

---

## 🔧 Step-by-Step Migration

### Step 1: Clean HTML Structure

**Before (Problematic):**
```blade
<!DOCTYPE html>
<html>
<head>
    <style>
        .title { font-size: 18pt; color: #333; }
        .content { margin: 10px; }
        table { width: 100%; }
    </style>
</head>
<body>
    <div class="title">{{ $title }}</div>
    <div class="content">
        <table style="float: left;">
            <!-- Table content -->
        </table>
    </div>
</body>
</html>
```

**After (HTML2PDF Compatible):**
```blade
<page backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm">
    <page_header>
        <h1 style="font-size: 18pt; color: #333;">{{ $title }}</h1>
    </page_header>
    
    <div style="margin: 10mm 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <!-- Table content -->
        </table>
    </div>
    
    <page_footer>
        <p style="font-size: 10pt; text-align: center;">Pagina [[page_cu]] di [[page_nb]]</p>
    </page_footer>
</page>
```

### Step 2: Convert CSS to Inline

**CSS Conversion Helper:**
```php
// Modules/Progressioni/app/Services/CssConverter.php
class CssConverter
{
    public static function convertToInline(string $html): string
    {
        // Define style mappings
        $styles = [
            '.title' => 'font-size: 18pt; color: #333; font-weight: bold;',
            '.content' => 'margin: 10mm 0;',
            '.table' => 'width: 100%; border-collapse: collapse;',
            '.text-center' => 'text-align: center;',
            '.text-right' => 'text-align: right;',
            '.mb-10' => 'margin-bottom: 10mm;',
            '.mt-10' => 'margin-top: 10mm;',
        ];
        
        // Replace class attributes with inline styles
        foreach ($styles as $class => $style) {
            $html = preg_replace(
                '/class=["\"]' . str_replace('.', '', $class) . '["\"]/',
                'style="' . $style . '"',
                $html
            );
        }
        
        return $html;
    }
}
```

### Step 3: Fix Image Handling

**Before:**
```blade
<img src="{{ asset('images/logo.png') }}" style="width: 50mm;" />
```

**After:**
```blade
@php
$imageBase64 = app(\Modules\Progressioni\Services\ImageService::class)->getBase64('images/logo.png');
@endphp

@if($imageBase64)
    <img src="{{ $imageBase64 }}" style="width: 50mm;" />
@endif
```

**Image Service:**
```php
// Modules/Progressioni/app/Services/ImageService.php
class ImageService
{
    public function getBase64(string $relativePath): ?string
    {
        $fullPath = public_path($relativePath);
        
        if (!file_exists($fullPath)) {
            Log::warning("Image not found: {$fullPath}");
            return null;
        }
        
        $imageData = file_get_contents($fullPath);
        $mimeType = mime_content_type($fullPath);
        
        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }
}
```

### Step 4: Optimize Tables

**Before (Problematic):**
```html
<table style="float: left; width: 48%;">
    <tr>
        <td colspan="2" style="background-color: #f0f0f0;">
            <div style="position: relative; top: 5px;">
                Complex content
            </div>
        </td>
    </tr>
</table>
```

**After (HTML2PDF Compatible):**
```html
<table style="width: 100%; border-collapse: collapse;">
    <tr>
        <td style="width: 48%; vertical-align: top; padding: 2mm;">
            <div style="background-color: #f0f0f0; padding: 5mm;">
                Simple content
            </div>
        </td>
        <td style="width: 4%;"></td>
        <td style="width: 48%; vertical-align: top; padding: 2mm;">
            <!-- Second column -->
        </td>
    </tr>
</table>
```

---

## 📄 Template Updates

### 1. Progressione Report Template

```blade
{{-- resources/views/pdf/progressione-report.blade.php --}}
<page backtop="20mm" backbottom="20mm" backleft="25mm" backright="25mm">
    <page_header>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 50%;">
                    @if($logo)
                        <img src="{{ $logo }}" style="width: 30mm; height: auto;" />
                    @endif
                </td>
                <td style="width: 50%; text-align: right; font-size: 10pt;">
                    Report Progressioni<br>
                    Data: {{ now()->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </page_header>

    <h1 style="font-size: 16pt; text-align: center; margin: 15mm 0;">
        Progressione {{ $progressione->matricola }}
    </h1>

    <!-- Dati Anagrafici -->
    <div style="margin: 10mm 0;">
        <h2 style="font-size: 14pt; border-bottom: 1px solid #000; padding-bottom: 3mm;">
            Dati Anagrafici
        </h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 3mm; font-weight: bold;">Matricola</td>
                <td style="width: 70%; padding: 3mm;">{{ $progressione->matricola }}</td>
            </tr>
            <tr style="background-color: #f5f5f5;">
                <td style="width: 30%; padding: 3mm; font-weight: bold;">Nome</td>
                <td style="width: 70%; padding: 3mm;">{{ $progressione->nome }}</td>
            </tr>
            <tr>
                <td style="width: 30%; padding: 3mm; font-weight: bold;">Posizione</td>
                <td style="width: 70%; padding: 3mm;">{{ $progressione->posizione }}</td>
            </tr>
        </table>
    </div>

    <!-- Storico Progressioni -->
    <div style="margin: 10mm 0;">
        <h2 style="font-size: 14pt; border-bottom: 1px solid #000; padding-bottom: 3mm;">
            Storico Progressioni
        </h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #e0e0e0;">
                    <th style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">Data</th>
                    <th style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">Livello</th>
                    <th style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">Note</th>
                </tr>
            </thead>
            <tbody>
                @foreach($progressione->storico as $item)
                <tr>
                    <td style="border: 1px solid #000; padding: 3mm; font-size: 9pt;">
                        {{ $item->data->format('d/m/Y') }}
                    </td>
                    <td style="border: 1px solid #000; padding: 3mm; font-size: 9pt;">
                        {{ $item->livello }}
                    </td>
                    <td style="border: 1px solid #000; padding: 3mm; font-size: 9pt;">
                        {{ $item->note }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <page_footer>
        <table style="width: 100%; font-size: 9pt;">
            <tr>
                <td style="width: 50%;">Documento Riservato</td>
                <td style="width: 50%; text-align: right;">Pagina [[page_cu]] di [[page_nb]]</td>
            </tr>
        </table>
    </page_footer>
</page>
```

### 2. Simple Progressione List

```blade
{{-- resources/views/pdf/progressione-list.blade.php --}}
<page>
    <h1 style="font-size: 16pt; text-align: center; margin-bottom: 15mm;">
        Elenco Progressioni
    </h1>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #333; color: white;">
                <th style="border: 1px solid #000; padding: 5mm; text-align: left;">Matricola</th>
                <th style="border: 1px solid #000; padding: 5mm; text-align: left;">Nome</th>
                <th style="border: 1px solid #000; padding: 5mm; text-align: left;">Posizione</th>
                <th style="border: 1px solid #000; padding: 5mm; text-align: left;">Livello</th>
            </tr>
        </thead>
        <tbody>
            @foreach($progressioni as $prog)
            <tr style="{{ $loop->index % 2 == 0 ? 'background-color: #f9f9f9;' : '' }}">
                <td style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">
                    {{ $prog->matricola }}
                </td>
                <td style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">
                    {{ $prog->nome }}
                </td>
                <td style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">
                    {{ $prog->posizione }}
                </td>
                <td style="border: 1px solid #000; padding: 4mm; font-size: 10pt;">
                    {{ $prog->livello_attuale }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</page>
```

---

## 🔧 Service Updates

### 1. Progressioni PDF Service

```php
<?php

namespace Modules\Progressioni\Services;

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

class ProgressioniPdfService
{
    private ImageService $imageService;
    
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    
    public function generateReport($progressione): string
    {
        try {
            // Prepare data
            $data = [
                'progressione' => $progressione,
                'logo' => $this->imageService->getBase64('images/logo.png'),
                'storico' => $progressione->storico()->orderBy('data', 'desc')->get(),
            ];
            
            // Generate HTML
            $html = view('pdf.progressione-report', $data)->render();
            
            // Clean HTML
            $html = $this->cleanHtml($html);
            
            // Create PDF
            $html2pdf = new Html2Pdf('P', 'A4', 'it', true, 'UTF-8', [20, 25, 20, 25]);
            $html2pdf->setTestTdInOnePage(false);
            $html2pdf->writeHTML($html);
            
            return $html2pdf->output('', 'S');
            
        } catch (Html2PdfException $e) {
            $html2pdf->clean();
            
            $formatter = new ExceptionFormatter($e);
            Log::error('Progressioni PDF generation failed', [
                'progressione_id' => $progressione->id,
                'error' => $formatter->getHtmlMessage(),
            ]);
            
            throw new PdfGenerationException('Failed to generate progressione PDF');
        }
    }
    
    private function cleanHtml(string $html): string
    {
        // Remove style tags
        $html = preg_replace('/<style\b[^<]*(?:(?!<\/style>)<[^<]*)*<\/style>/mi', '', $html);
        
        // Remove script tags
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);
        
        // Fix common issues
        $html = str_replace('&nbsp;', ' ', $html);
        $html = preg_replace('/\s+/', ' ', $html);
        
        return $html;
    }
}
```

### 2. Action Class Update

```php
<?php

namespace Modules\Progressioni\Actions;

use Modules\Progressioni\Services\ProgressioniPdfService;
use Modules\Xot\Actions\Pdf\ContentPdfAction;

class GenerateProgressionePdfAction
{
    private ProgressioniPdfService $pdfService;
    
    public function __construct(ProgressioniPdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }
    
    public function execute($progressione, string $filename = null): string
    {
        $filename = $filename ?? 'progressione_' . $progressione->matricola . '.pdf';
        
        return app(ContentPdfAction::class)->execute(
            view: 'pdf.progressione-report',
            data: [
                'progressione' => $progressione,
                'logo' => $this->pdfService->getLogoBase64(),
            ],
            filename: $filename
        );
    }
}
```

---

## 🧪 Testing Migration

### 1. Unit Tests

```php
<?php

namespace Modules\Progressioni\Tests\Unit;

use Tests\TestCase;
use Modules\Progressioni\Services\ProgressioniPdfService;
use Modules\Progressioni\Models\Progressione;

class PdfGenerationTest extends TestCase
{
    /** @test */
    public function it_generates_pdf_without_parsing_errors()
    {
        $progressione = Progressione::factory()->create();
        
        $service = app(ProgressioniPdfService::class);
        $pdfContent = $service->generateReport($progressione);
        
        // Verify PDF format
        $this->assertStringStartsWith('%PDF', $pdfContent);
        $this->assertGreaterThan(1000, strlen($pdfContent));
        
        // Verify no HTML2PDF errors
        $this->assertStringNotContainsString('HTML2PDF', $pdfContent);
        $this->assertStringNotContainsString('HtmlParsingException', $pdfContent);
    }
    
    /** @test */
    public function it_handles_missing_images_gracefully()
    {
        $progressione = Progressione::factory()->create();
        
        // Mock missing image
        $service = mock(ProgressioniPdfService::class);
        $service->shouldReceive('generateReport')
                ->andReturn(app(ContentPdfAction::class)->execute(
                    view: 'pdf.progressione-report',
                    data: ['progressione' => $progressione, 'logo' => null]
                ));
        
        $pdfContent = $service->generateReport($progressione);
        
        $this->assertStringStartsWith('%PDF', $pdfContent);
    }
}
```

### 2. Integration Tests

```php
/** @test */
public function progressione_pdf_endpoint_works()
{
    $progressione = Progressione::factory()->create();
    
    $response = $this->get("/progressioni/{$progressione->id}/pdf");
    
    $response->assertSuccessful();
    $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
}
```

---

## 📊 Performance Monitoring

### 1. Track PDF Generation Metrics

```php
// In ProgressioniPdfService
public function generateReportWithMetrics($progressione): string
{
    $startTime = microtime(true);
    $startMemory = memory_get_usage();
    
    try {
        $result = $this->generateReport($progressione);
        
        $duration = microtime(true) - $startTime;
        $memoryUsed = memory_get_usage() - $startMemory;
        
        // Log metrics
        Log::info('Progressioni PDF generated', [
            'progressione_id' => $progressione->id,
            'duration_ms' => round($duration * 1000, 2),
            'memory_mb' => round($memoryUsed / 1024 / 1024, 2),
            'pdf_size_kb' => round(strlen($result) / 1024, 2),
        ]);
        
        return $result;
        
    } catch (Exception $e) {
        Log::error('Progressioni PDF failed', [
            'progressione_id' => $progressione->id,
            'error' => $e->getMessage(),
            'duration_ms' => round((microtime(true) - $startTime) * 1000, 2),
        ]);
        
        throw $e;
    }
}
```

---

## 🚀 Rollback Plan

If migration causes issues:

1. **Immediate Rollback:**
   ```bash
   git checkout HEAD~1 -- Modules/Progressioni/resources/views/pdf/
   ```

2. **Partial Rollback:**
   - Keep working templates
   - Revert problematic ones
   - Use fallback PDF generation

3. **Emergency Fallback:**
   ```php
   public function emergencyPdf($progressione): string
   {
       // Simple text-based PDF
       $content = "Progressione Report\n\n";
       $content .= "Matricola: " . $progressione->matricola . "\n";
       $content .= "Nome: " . $progressione->nome . "\n";
       // ... minimal content
       
       $html2pdf = new Html2Pdf();
       $html2pdf->writeHTML('<pre>' . $content . '</pre>');
       return $html2pdf->output('', 'S');
   }
   ```

---

## 📋 Migration Checklist

- [ ] Audit all PDF templates
- [ ] Remove all `<style>` tags
- [ ] Convert CSS to inline styles
- [ ] Fix image handling (use base64)
- [ ] Simplify table structures
- [ ] Update service classes
- [ ] Add comprehensive error handling
- [ ] Write unit tests
- [ ] Performance testing
- [ ] Documentation update
- [ ] User acceptance testing
- [ ] Deploy to staging
- [ ] Monitor for issues
- [ ] Production deployment

---

## 📚 Resources

- [HTML2PDF Best Practices](../../Xot/docs/html2pdf-best-practices.md)
- [HTML2PDF Complete Guide](../../Xot/docs/html2pdf-complete-guide.md)
- [Progressioni Module Documentation](./README.md)
- [Laraxot PDF Actions](../../Xot/docs/actions/pdf-actions-overview.md)

---

**Last Updated:** December 2025  
**Module:** Progressioni  
**HTML2PDF Version:** 5.2.x  
**Migration Status:** In Progress