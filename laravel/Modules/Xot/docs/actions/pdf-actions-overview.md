# PDF Actions - Panoramica Tecnica

## 📋 Overview

Il modulo **Xot** fornisce un sistema completo e modulare per la generazione di PDF da record Eloquent.  
Sistema progettato con principi **DRY + KISS** per massima riutilizzabilità e manutenibilità.

---

## 🎯 Actions Disponibili

### 1. GetPdfContentByRecordAction ⭐ PRINCIPALE

**Scopo:** Genera contenuto PDF binario da record Eloquent per allegati email

**Input:**
- `Model $record` - Qualsiasi record Eloquent
- `string|null $filename` - Nome file opzionale

**Output:**
- `string` - Contenuto binario PDF

**Uso principale:**
```php
$pdfBinary = app(GetPdfContentByRecordAction::class)->execute($record);

// Usa in allegato email
$attachments = [
    [
        'data' => $pdfBinary,
        'as' => 'documento.pdf',
        'mime' => 'application/pdf',
    ],
];
```

**Documentazione completa:** [pdf-content-generation-technical.md](./pdf-content-generation-technical.md)

---

### 2. ContentPdfAction

**Scopo:** Genera PDF binario da HTML/View custom

**Input:**
- `string|null $html` - HTML diretto
- `string|null $view` - Nome vista Blade
- `array|null $data` - Dati per vista
- `string $filename` - Nome file

**Output:**
- `string` - Contenuto binario PDF

**Uso:**
```php
// Da HTML diretto
$pdf = app(ContentPdfAction::class)->execute(
    html: '<h1>Titolo</h1><p>Contenuto</p>',
    filename: 'custom.pdf'
);

// Da vista Blade
$pdf = app(ContentPdfAction::class)->execute(
    view: 'module::custom.pdf',
    data: ['title' => 'Titolo', 'content' => 'Contenuto'],
    filename: 'custom.pdf'
);
```

---

### 3. StreamDownloadPdfAction

**Scopo:** Genera PDF e restituisce download response

**Input:**
- `Model $record` - Record Eloquent
- `string|null $filename` - Nome file download

**Output:**
- `StreamedResponse` - Response download HTTP

**Uso:**
```php
// In Controller
public function downloadPdf($id)
{
    $record = Model::findOrFail($id);
    
    return app(StreamDownloadPdfAction::class)->execute($record);
    // → Download automatico PDF
}
```

---

### 4. PdfByHtmlAction

**Scopo:** Genera PDF da HTML con diverse modalità output

**Input:**
- `string $html` - Contenuto HTML
- `string $filename` - Nome file
- `string $disk` - Disco storage
- `string $out` - Modalità output (download, path)
- `string $orientation` - Orientamento (P/L)

**Output:**
- `string|BinaryFileResponse` - Path o download response

**Uso:**
```php
$result = app(PdfByHtmlAction::class)->execute(
    html: $htmlContent,
    filename: 'report.pdf',
    disk: 'public',
    out: 'download',
    orientation: 'P'
);
```

---

## 🏗️ Architettura

### Dependency Graph

```
GetPdfContentByRecordAction (Email Attachments)
    │
    ├─► generateViewName()         # Convenzioni Laraxot
    ├─► prepareViewParameters()    # Parametri standard
    ├─► view()->render()           # Blade rendering
    └─► generatePdfContent()       # spipu/html2pdf
             │
             └─► Html2Pdf->output('', 'S')  # Binary string

ContentPdfAction (Custom HTML/View)
    │
    ├─► HTML diretto o view rendering
    └─► generatePdfContent()       # spipu/html2pdf

StreamDownloadPdfAction (Direct Download)
    │
    ├─► GetPdfContentByRecordAction
    └─► StreamedResponse

PdfByHtmlAction (Multi-Output)
    │
    ├─► PdfData DTO
    └─► Multiple output modes
```

---

## 🔧 Configurazione

### Engine PDF

Enum `PdfEngineEnum`:
- **SPIPU** - spipu/html2pdf (default, raccomandato)
- **SPATIE** - spatie/laravel-pdf (alternativo)

```php
use Modules\Xot\Enums\PdfEngineEnum;

$action->engine = PdfEngineEnum::SPIPU;
```

### spipu/html2pdf Settings

```php
new Html2Pdf(
    orientation: 'P',           // P=Portrait, L=Landscape
    format: 'A4',              // A4, Letter, Legal, A3, etc.
    lang: 'it',                // Lingua
    unicode: true,             // Unicode support
    encoding: 'UTF-8',         // Encoding
    margins: [10, 10, 10, 10]  // [top, right, bottom, left] mm
);
```

### Output Modes (spipu/html2pdf)

```php
$html2pdf->output($filename, $dest);

// Dest options:
// 'I' - Inline browser
// 'D' - Download forzato
// 'F' - Save to file
// 'S' - String (binary) ⭐ PER EMAIL
// 'FI' - Save + Inline
// 'FD' - Save + Download
// 'E' - Base64 MIME
```

---

## 📦 Dipendenze

### Composer Packages

```json
{
    "require": {
        "spipu/html2pdf": "^5.2",
        "spatie/laravel-queueable-action": "^2.0",
        "webmozart/assert": "^1.11"
    }
}
```

### Laravel Packages

- `illuminate/mail` - Sistema email
- `illuminate/notifications` - Sistema notifiche
- `illuminate/support` - Helpers e facades

---

## 🧪 Testing Strategies

### Unit Tests

```php
/** @test */
public function it_generates_valid_pdf_binary(): void
{
    $record = Model::factory()->create();
    $pdf = app(GetPdfContentByRecordAction::class)->execute($record);
    
    $this->assertIsString($pdf);
    $this->assertStringStartsWith('%PDF', $pdf);
    $this->assertGreaterThan(100, strlen($pdf));
}
```

### Integration Tests

```php
/** @test */
public function it_sends_email_with_generated_pdf(): void
{
    Mail::fake();
    
    $record = Model::factory()->create();
    app(SendMailByRecord::class)->execute($record);
    
    Mail::assertSent(function ($mail) {
        return count($mail->attachments()) === 1 &&
               $mail->attachments()[0]->mime === 'application/pdf';
    });
}
```

---

## 🎨 Template PDF Best Practices

### 1. CSS Inline Only

```blade
{{-- ✅ CORRETTO --}}
<div style="font-family: Arial; font-size: 12pt;">
    Contenuto
</div>

{{-- ❌ ERRATO - CSS esterni non supportati --}}
<link rel="stylesheet" href="/css/pdf.css">
```

### 2. Layout con Tabelle

```blade
{{-- ✅ CORRETTO - Usa tabelle per layout --}}
<table width="100%">
    <tr>
        <td width="50%">Colonna 1</td>
        <td width="50%">Colonna 2</td>
    </tr>
</table>

{{-- ❌ EVITA - Float/Position non affidabili --}}
<div style="float: left;">...</div>
```

### 3. Immagini

```blade
{{-- ✅ CORRETTO - Base64 embedded --}}
<img src="data:image/png;base64,iVBORw0KGgoAAAANS..." />

{{-- ✅ ACCETTABILE - Path assoluto --}}
<img src="{{ public_path('images/logo.png') }}" />

{{-- ❌ EVITA - URL esterni (lenti) --}}
<img src="https://example.com/logo.png" />
```

---

## 🔗 Collegamenti Esterni

### Librerie
- [spipu/html2pdf GitHub](https://github.com/spipu/html2pdf)
- [spipu/html2pdf Wiki](https://github.com/spipu/html2pdf/wiki)
- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Laravel Notifications](https://laravel.com/docs/notifications)

### Moduli
- [Ptv - Complete Guide](../../Ptv/docs/pdf-email-attachments-complete-guide.md)
- [Notify - Email System](../../Notify/docs/README.md)

---

**Ultimo aggiornamento:** 2025-01-22  
**Versione:** 1.0.0  
**Stato:** ✅ Production Ready  
**PHPStan Level:** 10

