# Guida Completa: Generazione PDF e Allegati Email

## 📋 Indice

1. [Business Logic](#business-logic)
2. [Architettura Sistema](#architettura-sistema)
3. [Pattern Implementativo](#pattern-implementativo)
4. [Librerie Utilizzate](#librerie-utilizzate)
5. [Flusso Completo](#flusso-completo)
6. [Best Practices](#best-practices)
7. [Gestione Errori](#gestione-errori)
8. [Performance e Caching](#performance-e-caching)
9. [Esempi Pratici](#esempi-pratici)
10. [Troubleshooting](#troubleshooting)

---

## Business Logic

### Scopo del Sistema

Il sistema di generazione PDF e allegati email è progettato per:

1. **Generare PDF dinamici** da record del database (schede valutazione, documenti, report)
2. **Allegare PDF alle email** in modo automatico e affidabile
3. **Supportare multiple modalità** di allegato (file esistente, contenuto binario generato)
4. **Garantire performance** attraverso pattern ottimizzati e lazy loading

### Caso d'Uso Principale: Invio Schede Valutazione

```php
// Scenario: Un utente deve inviare una scheda valutazione via email con PDF allegato

// Input: 
// - Record scheda (SchedaContract)
// - Template email ('schede')
// - Destinatario email

// Output:
// - Email inviata con PDF allegato
// - PDF generato dinamicamente dal record
// - Nome file personalizzato (scheda_ID_MATR_COGNOME_NOME.pdf)
```

---

## Architettura Sistema

### Componenti Principali

```
┌─────────────────────────────────────────────────────────────┐
│                    SendMailByRecord                         │
│                  (Ptv/Actions/Scheda/)                      │
│                                                             │
│  1. Verifica permessi utente                                │
│  2. Genera PDF binario                                      │
│  3. Prepara array allegati                                  │
│  4. Invia notifica con allegati                             │
└───────────────┬─────────────────────────────────────────────┘
                │
                ├─────────► GetPdfContentByRecordAction
                │           (Xot/Actions/Pdf/)
                │           │
                │           ├─ Genera nome vista (convenzioni Laraxot)
                │           ├─ Prepara parametri vista
                │           ├─ Renderizza HTML
                │           └─ Converte HTML → PDF (spipu/html2pdf)
                │
                ├─────────► RecordNotification
                │           (Notify/Notifications/)
                │           │
                │           └─ Aggiunge allegati → SpatieEmail
                │                                    │
                └────────────────────────────────────┘
                                                     │
                                    ┌────────────────┴────────────────┐
                                    │      SpatieEmail                │
                                    │   (Notify/Emails/)               │
                                    │                                  │
                                    │  • getAttachmentFromData()      │
                                    │    → Attachment::fromData()     │
                                    │                                  │
                                    │  • getAttachmentFromPath()      │
                                    │    → Attachment::fromPath()     │
                                    └──────────────────────────────────┘
```

### Moduli Coinvolti

1. **Modules/Ptv** - Logica business specifica (schede, azioni)
2. **Modules/Xot** - Generazione PDF core (GetPdfContentByRecordAction)
3. **Modules/Notify** - Sistema notifiche e email (RecordNotification, SpatieEmail)

---

## Pattern Implementativo

### Pattern 1: Allegato da Contenuto Binario (⭐ PATTERN PRINCIPALE)

**Scenario:** PDF generato dinamicamente, non salvato su filesystem

```php
// Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php

use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

public function execute(SchedaContract $record, string $template = 'schede'): bool
{
    // 1. Genera contenuto PDF binario
    $pdfContent = app(GetPdfContentByRecordAction::class)
        ->execute($record);
    
    // 2. Genera nome file dinamico
    $filename = 'scheda.pdf';
    if (isset($record->id, $record->matr, $record->cognome, $record->nome)) {
        $filename = sprintf(
            'scheda_%s_%s_%s_%s.pdf',
            $record->id,
            $record->matr,
            $record->cognome,
            $record->nome
        );
    }
    
    // 3. Prepara array allegato con CONTENUTO BINARIO
    $attachments = [
        [
            'data' => $pdfContent,           // ⭐ Contenuto binario PDF
            'as' => $filename,               // Nome file nell'email
            'mime' => 'application/pdf',     // MIME type
        ],
    ];
    
    // 4. Invia con RecordNotification
    $notify = new RecordNotification($record, $template);
    $notify = $notify->addAttachments($attachments);
    
    Notification::route('mail', $to)->notify($notify);
    
    return true;
}
```

**Vantaggi Pattern 1:**
- ✅ No file temporanei sul filesystem
- ✅ Performance migliori (tutto in memoria)
- ✅ No pulizia file richiesta
- ✅ Scalabile per email multiple
- ✅ Thread-safe

### Pattern 2: Allegato da File Esistente

**Scenario:** PDF già salvato su filesystem

```php
$attachments = [
    [
        'path' => storage_path('pdfs/documento.pdf'),  // Path file esistente
        'as' => 'documento.pdf',
        'mime' => 'application/pdf',
    ],
];

$email = new SpatieEmail($record, 'template-slug');
$email->addAttachments($attachments);
Mail::to($recipient)->send($email);
```

**Vantaggi Pattern 2:**
- ✅ Utile per PDF pre-generati
- ✅ Supporta caching PDF
- ✅ Riduce CPU per re-generazioni

---

## Librerie Utilizzate

### spipu/html2pdf (v5.3.3)

**Aggiornamento Gennaio 2026**: La guida è stata aggiornata con le nuove funzionalità di sicurezza e prestazioni della versione 5.3.3.

#### Nuove Funzionalità v5.3.x

##### 🔒 Security Service Avanzato
```php
// Configurazione sicurezza migliorata
use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'A4', 'it');

// Aggiungere host consentiti per risorse esterne sicure
$html2pdf->getSecurityService()->addAllowedHost('cdn.ptv.trusted.com');
$html2pdf->getSecurityService()->addAllowedHost('images.laraxot.local');

// Reset lista se necessario
$html2pdf->getSecurityService()->resetAllowedHosts();
```

##### 📄 Classe html2pdf-same-page
```html
<!-- Previene divisione tabelle tra pagine -->
<div class="html2pdf-same-page">
    <table>
        <tr><td>Dati che non devono dividersi</td></tr>
        <tr><td>tra più pagine</td></tr>
    </table>
</div>
```

##### 📝 Supporto Readonly Attributes
```html
<!-- Ora supportato negli input -->
<input type="text" name="codice_scheda" value="PTV-001" readonly />
<textarea name="note" readonly>Note importanti</textarea>
```

##### 🎨 CSS con Variabili di Pagina
```html
<style>
    /* Evidenzia pagina corrente */
    .header-page-[[page_cu]] {
        background-color: #E0E0E0;
    }
</style>

<div class="header-page-[[page_cu]]">
    Intestazione pagina corrente
</div>
```

##### 🏷️ Nuovi Tag HTML
```html
<strike>Testo barrato</strike>

<figure>
    <img src="logo.png" />
    <figcaption>Logo Aziendale</figcaption>
</figure>
```

#### Template HTML per Html2Pdf

**Struttura Corretta per Ptv:**

```blade
{{-- resources/views/ptv::scheda.show.pdf.blade.php --}}
<page backtop="15mm" backbottom="15mm" backleft="20mm" backright="20mm">
    <page_header>
        <table width="100%" style="border-bottom: 1px solid #000;">
            <tr>
                <td width="60%">
                    <h1 style="font-size: 14pt; margin: 0;">Sistema PTV</h1>
                </td>
                <td width="40%" align="right">
                    <p style="font-size: 10pt; margin: 0;">Data: [[date_d/m/Y]]</p>
                </td>
            </tr>
        </table>
    </page_header>

    <h1 style="font-size: 16pt; text-align: center; margin: 20pt 0;">
        Scheda Valutazione - {{ $row->matr }}
    </h1>

    {{-- Contenuto principale --}}
    <div style="margin: 10mm 0;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background-color: #F0F0F0;">
                <td style="border: 1px solid #CCC; padding: 5pt; font-weight: bold;">Matr:</td>
                <td style="border: 1px solid #CCC; padding: 5pt;">{{ $row->matr }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #CCC; padding: 5pt; font-weight: bold;">Nome:</td>
                <td style="border: 1px solid #CCC; padding: 5pt;">{{ $row->nome }}</td>
            </tr>
            <tr style="background-color: #F0F0F0;">
                <td style="border: 1px solid #CCC; padding: 5pt; font-weight: bold;">Cognome:</td>
                <td style="border: 1px solid #CCC; padding: 5pt;">{{ $row->cognome }}</td>
            </tr>
        </table>
    </div>

    <page_footer>
        <table width="100%" style="border-top: 1px solid #000; margin-top: 20pt;">
            <tr>
                <td width="60%">
                    <p style="font-size: 8pt; margin: 0;">Documento riservato</p>
                </td>
                <td width="40%" align="right">
                    <p style="font-size: 8pt; margin: 0;">Pag. [[page_cu]]/[[page_nb]]</p>
                </td>
            </tr>
        </table>
    </page_footer>
</page>
```

#### Errori Comuni Html2Pdf

##### 1. Tag `<style>` Non Consentiti

```blade
{{-- ❌ ERRORE - Causano HtmlParsingException --}}
<style type="text/css">
    .header { font-size: 14pt; }
    .table { border-collapse: collapse; }
</style>

{{-- ✅ CORRETTO - Tutto CSS inline --}}
<div style="font-size: 14pt;">Header</div>
<table style="border-collapse: collapse;">...</table>
```

##### 2. HTML Malformato

```blade
{{-- ❌ ERRORE - Tag non bilanciati --}}
<table>
    <tr><td>Cella</td></tr>
{{-- Manca </table> --}}

{{-- ✅ CORRETTO - Tag bilanciati --}}
<table>
    <tbody>
        <tr><td>Cella</td></tr>
    </tbody>
</table>
```

##### 3. Immagini Rotte

```blade
{{-- ✅ SICURO - Base64 --}}
<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('logo.png'))) }}" />

{{-- ❌ RISCHIOSO - Path relativo --}}
<img src="../images/logo.png" />
```

#### Metodi Utili Html2Pdf

```php
// Debug mode - mostra risorse utilizzate
$html2pdf->setModeDebug();

// Disabilita controllo immagini esistenti
$html2pdf->setTestIsImage(false);

// Imposta immagine di fallback
$html2pdf->setFallbackImage('/path/to/fallback.png');

// Permette contenuto tabelle su più pagine
$html2pdf->setTestTdInOnePage(false);

// Font personalizzato
$html2pdf->addFont('MyFont', '', '/path/to/font.ttf');
$html2pdf->setDefaultFont('MyFont');
```

#### Output Modes Html2Pdf

```php
// 1. Browser inline (default)
$pdf = $html2pdf->output();

// 2. Download forzato
$pdf = $html2pdf->output('documento.pdf', 'D');

// 3. Salva su file
$html2pdf->output('/path/to/file.pdf', 'F');

// 4. Stringa binaria (⭐ PER EMAIL)
$binaryContent = $html2pdf->output('', 'S');

// 5. Base64 MIME
$base64Content = $html2pdf->output('', 'E');
```

#### Gestione Eccezioni Html2Pdf

```php
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try {
    $html2pdf = new Html2Pdf('P', 'A4', 'it');
    $html2pdf->writeHTML($htmlContent);
    $pdfBinary = $html2pdf->output('', 'S');
} catch (Html2PdfException $e) {
    $html2pdf->clean();
    
    $formatter = new ExceptionFormatter($e);
    Log::error('Html2Pdf Error', [
        'error' => $e->getMessage(),
        'html_preview' => substr($htmlContent, 0, 500),
        'formatted_error' => $formatter->getHtmlMessage()
    ]);
    
    throw $e;
}
```

#### Ottimizzazioni Performance

```php
// Pool di istanze per generazione massiva
class Html2PdfPool
{
    private array $pool = [];
    
    public function __construct(int $size = 5)
    {
        for ($i = 0; $i < $size; $i++) {
            $this->pool[] = new Html2Pdf('P', 'A4', 'it');
        }
    }
    
    public function getInstance(): Html2Pdf
    {
        return array_pop($this->pool) ?? new Html2Pdf('P', 'A4', 'it');
    }
}

// Compressione PDF (default true)
$html2pdf->setCompression(true); // Riduce dimensione file
```

#### Integrazione con Laraxot Actions

```php
// Modules/Xot/app/Actions/Pdf/Engine/SpipuPdfByHtmlAction.php
public function execute(string $html, string $filename): string
{
    try {
        $html2pdf = new Html2Pdf(
            orientation: 'P',
            format: 'A4', 
            lang: 'it',
            unicode: true,
            encoding: 'UTF-8',
            margins: [10, 10, 10, 10]
        );
        
        $html2pdf->writeHTML($html);
        return $html2pdf->output('', 'S');
        
    } catch (Html2PdfException $e) {
        Log::error('Html2Pdf generation failed', [
            'filename' => $filename,
            'error' => $e->getMessage(),
            'html_length' => strlen($html)
        ]);
        throw $e;
    }
}
```

---

### Laravel Mailables & Attachments

```php
use Illuminate\Mail\Mailables\Attachment;

// Da contenuto binario (per email)
$attachment = Attachment::fromData(fn () => $binaryContent)
    ->as('filename.pdf')
    ->withMime('application/pdf');

// Da file esistente
$attachment = Attachment::fromPath('/path/to/file.pdf')
    ->as('documento.pdf')
    ->withMime('application/pdf');
```

---

## Flusso Completo

### 1. Generazione PDF Binario

```php
// Modules/Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php

public function execute(Model $record, ?string $filename = null): string
{
    // STEP 1: Genera nome vista (convenzioni Laraxot)
    // Esempio: Modules\Ptv\Models\Scheda → ptv::scheda.show.pdf
    $viewName = $this->generateViewName($record);
    // Result: 'ptv::scheda.show.pdf'
    
    // STEP 2: Prepara parametri vista
    $viewParams = $this->prepareViewParameters($record, $viewName);
    // Result: [
    //   'view' => 'ptv::scheda.show.pdf',
    //   'row' => $record,
    //   'transKey' => 'ptv::schedas.fields',
    //   'firma' => 'Nome Valutatore' // se esiste relazione valutatore
    // ]
    
    // STEP 3: Valida esistenza vista
    if (!view()->exists($viewName)) {
        throw new Exception("View '{$viewName}' not found");
    }
    
    // STEP 4: Renderizza HTML
    $html = view($viewName, $viewParams)->render();
    
    // STEP 5: Valida HTML
    Assert::string($html);
    if (empty(trim($html))) {
        throw new Exception("Generated HTML is empty");
    }
    
    // STEP 6: Genera filename se non fornito
    if ($filename === null) {
        $filename = $this->generateFilename($record);
        // Result: 'scheda_123_ABC123_Rossi_Mario.pdf'
    }
    
    // STEP 7: Genera PDF binario
    return $this->generatePdfContent($html, $filename);
    // Result: Binary PDF string
}
```

### 2. Preparazione Allegati

```php
// Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php

// Genera PDF binario
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

// Prepara struttura allegato
$attachments = [
    [
        'data' => $pdfContent,         // Contenuto binario PDF
        'as' => $filename,             // Nome file (scheda_123_ABC123_Rossi_Mario.pdf)
        'mime' => 'application/pdf',   // MIME type
    ],
];
```

### 3. Invio Email con Allegato

```php
// Crea notifica
$notify = new RecordNotification($record, 'schede');
$notify = $notify->mergeData($data);              // Dati extra per template
$notify = $notify->addAttachments($attachments);  // Allegati

// Invia
Notification::route('mail', 'destinatario@example.com')
    ->notify($notify);
```

### 4. Gestione Allegati in SpatieEmail

```php
// Modules/Notify/app/Emails/SpatieEmail.php

public function addAttachments(array $attachments): self
{
    $attachmentObjects = [];
    
    foreach ($attachments as $item) {
        $attachment = null;
        
        // Priorità 1: File esistente
        if (isset($item['path']) && file_exists($item['path'])) {
            $attachment = $this->getAttachmentFromPath($item);
        }
        
        // Priorità 2: Contenuto binario (NOSTRO CASO)
        if ($attachment === null && isset($item['data'])) {
            $attachment = $this->getAttachmentFromData($item);
        }
        
        if ($attachment) {
            $attachmentObjects[] = $attachment;
        }
    }
    
    $this->customAttachments = $attachmentObjects;
    return $this;
}

public function getAttachmentFromData(array $attachment): Attachment
{
    // Crea Attachment da contenuto binario
    $res = Attachment::fromData(fn () => $attachment['data']);
    
    // Imposta nome file
    $as = $attachment['as'];
    
    // Determina MIME type
    $mime = $attachment['mime'] ?? 'application/octet-stream';
    if ($mime === null) {
        $info = pathinfo($attachment['as']);
        if (isset($info['extension'])) {
            $mime = Arr::first(MimeTypes::getDefault()->getMimeTypes($info['extension']));
        }
    }
    
    // Applica configurazioni
    return $res->as($as)->withMime($mime);
}
```

---

## Best Practices

### 1. ✅ Naming File Dinamico

```php
// ❌ ERRATO - Nome generico
$filename = 'scheda.pdf';

// ✅ CORRETTO - Nome descrittivo e univoco
$filename = 'scheda_'.$record->id.'_'.$record->matr.'_'.$record->cognome.'_'.$record->nome.'.pdf';
// Result: scheda_123_ABC123_Rossi_Mario.pdf
```

### 2. ✅ Validazione Record

```php
// Verifica che il record sia un Model
Assert::isInstanceOf($record, Model::class);

// Carica relazioni necessarie
if (method_exists($record, 'valutatore') && !$record->relationLoaded('valutatore')) {
    $record->load('valutatore');
}
```

### 3. ✅ Gestione Permessi

```php
/** @var User $user */
$user = Auth::user();

if (!$user->can('sendMail', $record)) {
    abort(403, 'Unauthorized action.');
}
```

### 4. ✅ Logging Dettagliato

```php
try {
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
} catch (Exception $e) {
    Log::error('PDF generation failed', [
        'record_id' => $record->id,
        'record_class' => get_class($record),
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
    ]);
    throw $e;
}
```

### 5. ✅ Testing Pattern

```php
use Tests\TestCase;

class SendMailByRecordTest extends TestCase
{
    /** @test */
    public function it_sends_email_with_pdf_attachment(): void
    {
        // Arrange
        $user = User::factory()->create();
        $record = Scheda::factory()->create();
        $this->actingAs($user);
        
        // Act
        $result = app(SendMailByRecord::class)->execute($record);
        
        // Assert
        $this->assertTrue($result);
        Mail::assertSent(function ($mail) use ($record) {
            return $mail->hasTo('destinatario@example.com') &&
                   count($mail->attachments()) === 1;
        });
    }
}
```

---

## Gestione Errori

### Errori Comuni

#### 1. Vista PDF non trovata

**Errore:**
```
Exception: View 'ptv::scheda.show.pdf' not found
```

**Cause:**
- File Blade non esiste
- Nome vista errato
- Convenzioni naming non rispettate

**Soluzione:**
```php
// Verifica esistenza vista
if (!view()->exists($viewName)) {
    throw new Exception("View '{$viewName}' not found for model ".get_class($record));
}

// Crea vista seguendo convenzioni:
// Modules/{ModuleName}/resources/views/{model-kebab}/show/pdf.blade.php
// → ptv::scheda.show.pdf
```

#### 2. HTML vuoto generato

**Errore:**
```
Exception: Generated HTML content is empty for view
```

**Cause:**
- Dati record insufficienti
- Errori nella vista Blade
- Parametri mancanti

**Soluzione:**
```php
// Valida HTML prima di generare PDF
Assert::string($html, 'Generated HTML must be string');
if (empty(trim($html))) {
    Log::error('Empty HTML generated', [
        'view' => $viewName,
        'record' => $record->toArray(),
    ]);
    throw new Exception("HTML is empty");
}
```

#### 3. Errore spipu/html2pdf

**Errore:**
```
Spipu\Html2Pdf\Exception\Html2PdfException: HTML parsing error
```

**Cause:**
- HTML malformato
- Tag non chiusi
- Stili CSS non supportati
- Tabelle troppo larghe

**Soluzione:**
```php
try {
    $pdfBinary = $html2pdf->output('', 'S');
} catch (Html2PdfException $e) {
    Log::error('PDF generation failed', [
        'error' => $e->getMessage(),
        'html_preview' => substr($html, 0, 500),
    ]);
    
    // Debug mode: mostra HTML invece di PDF
    if (config('app.debug')) {
        return response($html)->header('Content-Type', 'text/html');
    }
    
    throw new Exception('Failed to generate PDF: '.$e->getMessage(), 0, $e);
}
```

#### 4. Allegato non arriva

**Cause:**
- Array allegati malformato
- MIME type errato
- Contenuto binario corrotto

**Soluzione:**
```php
// Validazione allegati
Assert::isArray($attachments);
foreach ($attachments as $attachment) {
    Assert::keyExists($attachment, 'data', 'Attachment must have data or path');
    Assert::keyExists($attachment, 'as', 'Attachment must have filename');
    Assert::keyExists($attachment, 'mime', 'Attachment must have MIME type');
}
```

### Servizio Esportazione Dashboard PTV

```php
<?php

namespace Modules\Ptv\Services;

use Modules\Analytics\Services\AdvancedChartExportService;
use Illuminate\Support\Facades\Storage;

class PtvDashboardExportService
{
    public function __construct(
        private AdvancedChartExportService $exportService
    ) {}

    /**
     * Esporta dashboard PTV completa
     */
    public function exportDashboard(string $period = 'month'): array
    {
        $charts = [
            'status_overview' => 'ptv-status-chart',
            'approval_trends' => 'ptv-approval-trends',
            'department_performance' => 'ptv-department-chart',
        ];

        $exports = [];
        foreach ($charts as $name => $chartId) {
            $exports[$name] = $this->exportService->saveChartForReport(
                $chartId,
                "ptv-dashboard-{$period}-" . now()->format('Y-m-d')
            );
        }

        return $exports;
    }

    /**
     * Genera report PDF con dashboard esportata
     */
    public function generateDashboardReport(string $period = 'month'): string
    {
        $chartExports = $this->exportDashboard($period);

        $html = view('ptv::reports.dashboard', [
            'period' => $period,
            'charts' => $chartExports,
            'generated_at' => now(),
        ])->render();

        return app(\Modules\Xot\Actions\Pdf\ContentPdfAction::class)
            ->execute(
                html: $html,
                filename: "dashboard-ptv-{$period}-" . now()->format('Y-m-d') . '.pdf'
            );
    }
}
```

---

## 📈 **Performance e Ottimizzazioni**

### Strategia Performance

#### 1. Lazy Loading Relazioni

```php
// ❌ ERRATO - N+1 queries
foreach ($schede as $scheda) {
    $valutatore = $scheda->valutatore; // Query per ogni scheda
}

// ✅ CORRETTO - Eager loading
$schede = Scheda::with('valutatore')->get();
foreach ($schede as $scheda) {
    $valutatore = $scheda->valutatore; // No query extra
}
```

#### 2. Caching PDF (Opzionale)

```php
use Illuminate\Support\Facades\Cache;

public function execute(SchedaContract $record): bool
{
    $cacheKey = "pdf_scheda_{$record->id}_v{$record->updated_at->timestamp}";
    
    // Tenta cache
    $pdfContent = Cache::remember($cacheKey, 3600, function () use ($record) {
        return app(GetPdfContentByRecordAction::class)->execute($record);
    });
    
    // ... resto del codice
}
```

#### 3. Queue per Invii Massivi

```php
use Spatie\QueueableAction\QueueableAction;

class SendMailByRecord
{
    use QueueableAction;
    
    // Invio singolo (sincrono)
    public function execute(SchedaContract $record): bool { /* ... */ }
}

// Uso in bulk action
foreach ($schedeBulk as $scheda) {
    app(SendMailByRecord::class)
        ->onQueue('emails')
        ->execute($scheda);
}
```

### Monitoring Performance

```php
use Illuminate\Support\Facades\Log;

$startTime = microtime(true);

$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

$generationTime = microtime(true) - $startTime;

if ($generationTime > 5.0) {
    Log::warning('Slow PDF generation', [
        'record_id' => $record->id,
        'time' => $generationTime,
    ]);
}
```

---

## Esempi Pratici

### Esempio 1: Invio Email Singola

```php
use Modules\Ptv\Actions\Scheda\SendMailByRecord;

$scheda = Scheda::find(123);
$result = app(SendMailByRecord::class)->execute($scheda, 'schede');

if ($result) {
    Notification::success('Email inviata con successo');
} else {
    Notification::error('Errore invio email');
}
```

### Esempio 2: Bulk Action Filament

```php
use Modules\Ptv\Filament\Actions\Bulk\SendSchedeBulkAction;

Tables\Actions\BulkAction::make('send_schede')
    ->label('Invia Email')
    ->icon('heroicon-o-envelope')
    ->action(function ($records) {
        $sent = 0;
        foreach ($records as $record) {
            try {
                app(SendMailByRecord::class)->execute($record);
                $sent++;
            } catch (\Exception $e) {
                Log::error('Bulk send failed', [
                    'record_id' => $record->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
        Notification::success("Inviate {$sent} email su ".count($records));
    });
```

### Esempio 3: Download Diretto PDF (Senza Email)

```php
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

Route::get('/scheda/{id}/pdf', function ($id) {
    $scheda = Scheda::findOrFail($id);
    
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($scheda);
    $filename = "scheda_{$scheda->id}.pdf";
    
    return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
});
```

### Esempio 4: Creazione ZIP con PDF Multipli

```php
use ZipArchive;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

public function createZipWithPdfs($records): string
{
    $zip = new ZipArchive;
    $zipFile = storage_path('temp/schede_'.time().'.zip');
    
    if ($zip->open($zipFile, ZipArchive::CREATE) === true) {
        foreach ($records as $record) {
            $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
            $filename = "scheda_{$record->id}.pdf";
            $zip->addFromString($filename, $pdfContent);
        }
        $zip->close();
    }
    
    return $zipFile;
}
```

---

## Troubleshooting

### Debug Mode

```php
// In SendMailByRecord.php

if (config('app.debug')) {
    // Mostra HTML invece di generare PDF
    $viewName = 'ptv::scheda.show.pdf';
    $viewParams = ['row' => $record];
    $html = view($viewName, $viewParams)->render();
    return response($html)->header('Content-Type', 'text/html');
}
```

### Test Manual

Verifica generazione PDF:

```bash
php artisan tinker
```

```php
$scheda = Modules\Ptv\Models\Scheda::first();
$pdf = app(Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction::class)->execute($scheda);
echo "PDF size: ".strlen($pdf)." bytes\n";
```

### Checklist Diagnostica

- [ ] Vista PDF esiste (`resources/views/{model}/show/pdf.blade.php`)
- [ ] Record ha dati necessari (id, matr, cognome, nome)
- [ ] Relazioni caricate (valutatore se necessario)
- [ ] Permessi utente corretti
- [ ] Configurazione email corretta (SMTP)
- [ ] Log errori (`storage/logs/laravel.log`)
- [ ] Directory cache scrivibile (`storage/framework/cache`)

---

## Collegamenti

### Documentazione Moduli
- [Xot - GetPdfContentByRecordAction](../../Xot/docs/actions/pdf-generation.md)
- [Notify - Email Attachments](../../Notify/docs/email-sending/attachments_usage.md)
- [Notify - RecordNotification](../../Notify/docs/notifications/record-notification.md)

### Documentazione Esterna
- [spipu/html2pdf Documentation](https://github.com/spipu/html2pdf)
- [Laravel Mailables](https://laravel.com/docs/mail)
- [Laravel Notifications](https://laravel.com/docs/notifications)

### File Correlati
- `Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php` - Action principale
- `Modules/Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php` - Generazione PDF
- `Modules/Notify/app/Notifications/RecordNotification.php` - Notifica con allegati
- `Modules/Notify/app/Emails/SpatieEmail.php` - Gestione allegati email

---

**Ultimo aggiornamento:** Gennaio 2026  
**Autore:** Sistema Laraxot  
**Versione:** 1.0  
**Stato:** ✅ Completo e verificato

