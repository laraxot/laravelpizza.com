# GetPdfContentByRecordAction - Documentazione Tecnica

## 📋 Overview

`GetPdfContentByRecordAction` è l'action core per la generazione di contenuto PDF binario da record Eloquent.  
È progettato specificamente per **allegati email, storage e operazioni che richiedono contenuto binario PDF**.

---

## 🎯 Business Logic

### Scopo

Genera contenuto PDF binario da qualsiasi record Eloquent seguendo le convenzioni Laraxot per:
- **Email attachments** (uso primario)
- **Storage operations**
- **API responses**
- **Download dinamici**

### Principi DRY + KISS

1. **Convention over configuration** - Nomi viste automatici
2. **Single Responsibility** - Solo generazione PDF, nessuna logica business
3. **Zero Dependencies** - Non dipende da moduli specifici
4. **Extensible** - Parametri personalizzabili via override

---

## 🏗️ Architettura

### Input/Output

```php
/**
 * @param Model $record - Qualsiasi Model Eloquent
 * @param string|null $filename - Nome file opzionale (default: auto-generato)
 * @return string - Contenuto binario PDF
 * @throws Exception - Se vista non esiste o errori generazione
 */
public function execute(Model $record, ?string $filename = null): string
```

### Flow Diagram

```
Input: Model $record
    │
    ├─► generateViewName($record)
    │   └─> 'modulename::model-kebab.show.pdf'
    │
    ├─► prepareViewParameters($record, $viewName)
    │   └─> ['view', 'row', 'transKey', 'firma'?]
    │
    ├─► Validate view existence
    │   └─> throw Exception if not exists
    │
    ├─► view($viewName, $viewParams)->render()
    │   └─> HTML string
    │
    ├─► Validate HTML content
    │   └─> throw Exception if empty
    │
    ├─► generateFilename($record)
    │   └─> 'model_123_field1_field2.pdf'
    │
    └─► generatePdfContent($html, $filename)
        └─> Binary PDF string (spipu/html2pdf)

Output: Binary PDF string
```

---

## 🔧 Implementazione Dettagliata

### 1. Generazione Nome Vista (Convenzioni Laraxot)

```php
/**
 * Pattern: {module}::{model-kebab}.show.pdf
 *
 * Esempi:
 * - Modules\Ptv\Models\Scheda      → ptv::scheda.show.pdf
 * - Modules\User\Models\User       → user::user.show.pdf
 * - Modules\Performance\Models\ValutazioneAnnuale → performance::valutazione-annuale.show.pdf
 */
protected function generateViewName(Model $record): string
{
    $modelClass = get_class($record);
    // Result: 'Modules\Ptv\Models\Scheda'
    
    $modelName = class_basename($modelClass);
    // Result: 'Scheda'
    
    $module = Str::between($modelClass, 'Modules\\', '\\Models');
    // Result: 'Ptv'
    
    return mb_strtolower($module).'::'.Str::kebab($modelName).'.show.pdf';
    // Result: 'ptv::scheda.show.pdf'
}
```

**Path Vista Fisico:**
```
Modules/Ptv/resources/views/scheda/show/pdf.blade.php
```

### 2. Preparazione Parametri Vista

```php
/**
 * Parametri standard per tutte le viste PDF
 */
protected function prepareViewParameters(Model $record, string $viewName): array
{
    $modelClass = get_class($record);
    $modelName = class_basename($modelClass);
    $module = Str::between($modelClass, 'Modules\\', '\\Models');
    
    $params = [
        'view' => $viewName,                  // Nome vista completo
        'row' => $record,                     // Record Eloquent
        'transKey' => mb_strtolower($module).'::'.Str::plural(mb_strtolower($modelName)).'.fields',
    ];
    
    // Gestione relazione 'valutatore' (pattern specifico Laraxot)
    if (
        method_exists($record, 'valutatore') &&
        $record->relationLoaded('valutatore') &&
        isset($record->valutatore)
    ) {
        $valutatore = $record->valutatore;
        if (is_object($valutatore) && isset($valutatore->nome_diri)) {
            $params['firma'] = $valutatore->nome_diri;
        }
    }
    
    return $params;
}
```

**Esempio Output:**
```php
[
    'view' => 'ptv::scheda.show.pdf',
    'row' => Scheda {id: 123, matr: 'ABC123', ...},
    'transKey' => 'ptv::schedas.fields',
    'firma' => 'Dott. Mario Rossi' // se valutatore caricato
]
```

### 3. Generazione Nome File

```php
/**
 * Strategy per generazione nome file basata su campi disponibili
 */
protected function generateFilename(Model $record): string
{
    $modelName = class_basename(get_class($record));
    $recordKey = $record->getKey();
    $baseFilename = mb_strtolower($modelName).'_'.((string)($recordKey ?? 'unknown'));
    
    // PRIORITÀ 1: Record con identificativi personali (schede, anagrafiche)
    if (isset($record->matr, $record->cognome, $record->nome)) {
        $matr = is_string($record->matr) ? $record->matr : 'unknown';
        $cognome = is_string($record->cognome) ? $record->cognome : 'unknown';
        $nome = is_string($record->nome) ? $record->nome : 'unknown';
        
        return 'scheda_'.((string)($recordKey ?? 'unknown')).'_'.$matr.'_'.$cognome.'_'.$nome.'.pdf';
        // Result: 'scheda_123_ABC123_Rossi_Mario.pdf'
    }
    
    // PRIORITÀ 2: Record con campo 'name'
    if (isset($record->name) && is_string($record->name)) {
        return $baseFilename.'_'.Str::slug($record->name).'.pdf';
        // Result: 'user_456_mario-rossi.pdf'
    }
    
    // PRIORITÀ 3: Default (solo ID)
    return $baseFilename.'.pdf';
    // Result: 'model_123.pdf'
}
```

### 4. Generazione PDF Binario (spipu/html2pdf)

```php
/**
 * Configurazione standard spipu/html2pdf
 */
protected function generatePdfContent(string $html, string $filename): string
{
    try {
        // Crea istanza Html2Pdf con configurazione A4 standard
        $html2pdf = new Html2Pdf(
            orientation: 'P',           // Portrait (verticale)
            format: 'A4',              // Formato A4 (210x297mm)
            lang: 'it',                // Lingua italiana
            unicode: true,             // Supporto Unicode (caratteri speciali)
            encoding: 'UTF-8',         // Encoding UTF-8
            margins: [10, 10, 10, 10]  // Margini 10mm su tutti i lati [top, right, bottom, left]
        );
        
        // Configurazioni aggiuntive
        $html2pdf->setTestTdInOnePage(false);  // Permette celle tabella su più pagine
        
        // Scrive HTML nel PDF
        $html2pdf->writeHTML($html);
        
        // Genera e restituisce contenuto binario
        // 'S' = String mode (restituisce contenuto binario come stringa)
        return $html2pdf->output('', 'S');
        
    } catch (Exception $e) {
        // Log dettagliato errore
        Log::error('PDF generation failed in GetPdfContentByRecordAction', [
            'filename' => $filename,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        
        throw new Exception('Failed to generate PDF content: '.$e->getMessage(), 0, $e);
    }
}
```

---

## 📦 Utilizzo

### Caso 1: Email Attachment (Principale)

```php
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

// Genera PDF binario
$pdfBinaryContent = app(GetPdfContentByRecordAction::class)
    ->execute($record);

// Usa in allegato email
$attachments = [
    [
        'data' => $pdfBinaryContent,
        'as' => 'documento.pdf',
        'mime' => 'application/pdf',
    ],
];
```

### Caso 2: Storage

```php
use Illuminate\Support\Facades\Storage;

$pdfContent = app(GetPdfContentByRecordAction::class)
    ->execute($record, 'custom_name.pdf');

Storage::disk('public')->put('pdfs/documento.pdf', $pdfContent);
```

### Caso 3: Download Diretto

```php
$pdfContent = app(GetPdfContentByRecordAction::class)
    ->execute($record);

return response($pdfContent)
    ->header('Content-Type', 'application/pdf')
    ->header('Content-Disposition', 'attachment; filename="documento.pdf"');
```

### Caso 4: API Response

```php
$pdfContent = app(GetPdfContentByRecordAction::class)
    ->execute($record);

return response()->json([
    'filename' => 'documento.pdf',
    'content' => base64_encode($pdfContent),
    'mime' => 'application/pdf',
]);
```

---

## 🎨 Vista PDF Template

### Struttura Minima

```blade
{{-- Modules/ModuleName/resources/views/model-name/show/pdf.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $row->title ?? 'Documento PDF' }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; }
        .header { text-align: center; margin-bottom: 20px; }
        .content { margin: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ __($transKey.'.title') }}</h1>
    </div>
    
    <div class="content">
        <p><strong>ID:</strong> {{ $row->id }}</p>
        <p><strong>Data:</strong> {{ $row->created_at->format('d/m/Y') }}</p>
        
        {{-- Contenuto dinamico --}}
        @if(isset($row->matr))
            <p><strong>Matricola:</strong> {{ $row->matr }}</p>
        @endif
        
        {{-- Firma (se disponibile) --}}
        @if(isset($firma))
            <div style="margin-top: 50px; text-align: right;">
                <p>{{ $firma }}</p>
            </div>
        @endif
    </div>
</body>
</html>
```

### Best Practices Template

1. **Usa inline CSS** - spipu/html2pdf non supporta CSS esterni
2. **Evita float/position** - Usa table per layout
3. **Font sicure** - Arial, Times, Courier
4. **Dimensioni fisse** - No responsive, usa mm/pt
5. **Immagini base64** - O path assoluti
6. **No JavaScript** - PDF è statico

---

## ⚠️ Gestione Errori

### Errore: Vista Non Trovata

```php
// Exception lanciata se vista non esiste
throw new Exception("View '{$viewName}' not found for model ".get_class($record));
```

**Soluzione:**
1. Verifica path: `Modules/{Module}/resources/views/{model-kebab}/show/pdf.blade.php`
2. Check naming: `scheda.show.pdf` non `scheda-show-pdf`
3. Verifica namespace module corretto

### Errore: HTML Vuoto

```php
throw new Exception("Generated HTML content is empty for view '{$viewName}'");
```

**Soluzione:**
1. Controlla dati record ($row)
2. Verifica condizioni @if nella vista
3. Check traduzioni mancanti

### Errore: PDF Generation Failed

```php
throw new Exception('Failed to generate PDF content: '.$e->getMessage(), 0, $e);
```

**Cause comuni:**
- HTML malformato (tag non chiusi)
- Tabelle troppo larghe
- Immagini non trovate
- CSS non supportato

**Debug:**
```php
// In config/app.php metti debug = true
// Poi testa:
$html = view('module::model.show.pdf', ['row' => $record])->render();
dd($html); // Verifica HTML generato
```

---

## 🚀 Performance

### Ottimizzazioni Applicate

1. **Lazy View Resolution** - Vista caricata solo quando necessario
2. **String Assertions** - Validazione rapida con Webmozart Assert
3. **Exception Early** - Fallisce veloce se vista non esiste
4. **No File I/O** - Tutto in memoria (nessun file temporaneo)
5. **Reusable** - Istanza Action riutilizzabile

### Benchmark Tipici

```
Record semplice (1 pagina):    50-100ms
Record complesso (5 pagine):   200-400ms
Record con immagini:           500-1000ms
```

### Ottimizzazione Eager Loading

```php
// ❌ LENTO - N+1 query
foreach ($records as $record) {
    $pdf = app(GetPdfContentByRecordAction::class)->execute($record);
}

// ✅ VELOCE - Eager loading
$records = Model::with('valutatore')->get();
foreach ($records as $record) {
    $pdf = app(GetPdfContentByRecordAction::class)->execute($record);
}
```

---

## 🧪 Testing

### Unit Test

```php
use Tests\TestCase;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

class GetPdfContentByRecordActionTest extends TestCase
{
    /** @test */
    public function it_generates_pdf_binary_content(): void
    {
        // Arrange
        $record = Model::factory()->create();
        
        // Act
        $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
        
        // Assert
        $this->assertIsString($pdfContent);
        $this->assertStringStartsWith('%PDF', $pdfContent); // PDF magic number
        $this->assertGreaterThan(100, strlen($pdfContent));
    }
    
    /** @test */
    public function it_throws_exception_if_view_not_found(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('View');
        
        $record = new class extends \Illuminate\Database\Eloquent\Model {
            protected $table = 'fake_table';
        };
        
        app(GetPdfContentByRecordAction::class)->execute($record);
    }
}
```

---

## 📊 Monitoraggio

### Logging Pattern

```php
use Illuminate\Support\Facades\Log;

$startTime = microtime(true);

try {
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
    
    $elapsedTime = microtime(true) - $startTime;
    
    Log::info('PDF generated successfully', [
        'record_id' => $record->id,
        'model' => get_class($record),
        'size_bytes' => strlen($pdfContent),
        'time_ms' => round($elapsedTime * 1000, 2),
    ]);
    
} catch (\Exception $e) {
    Log::error('PDF generation failed', [
        'record_id' => $record->id,
        'model' => get_class($record),
        'error' => $e->getMessage(),
    ]);
    throw $e;
}
```

---

## 🔗 Collegamenti

### Documentazione Correlata
- [Ptv - SendMailByRecord Complete Guide](../../../Ptv/docs/pdf-email-attachments-complete-guide.md)
- [Notify - Email Attachments](../../../Notify/docs/email-sending/attachments_usage.md)
- [Xot - View Conventions](../conventions/view-naming.md)

### File Correlati
- `Modules/Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php`
- `Modules/Xot/app/Enums/PdfEngineEnum.php`
- `Modules/Xot/app/Datas/PdfData.php`

### Risorse Esterne
- [spipu/html2pdf GitHub](https://github.com/spipu/html2pdf)
- [HTML2PDF Wiki](https://github.com/spipu/html2pdf/wiki)

---

**Ultimo aggiornamento:** 2025-01-22  
**Versione:** 1.0  
**Stato:** ✅ Production Ready  
**PHPStan Level:** 10

