# Deep Dive Tecnico: Campo 'data' negli Allegati Email

## 🎯 Domanda Principale

**Come viene popolato il campo 'data' alla linea 102 di `SendMailByRecord.php`?**

---

## 📊 Analisi Dettagliata

### Linea 102 - SendMailByRecord.php

```php
$attachments = [
    [
        'data' => $pdfContent,           // ⭐ QUESTA È LA LINEA CRITICA
        'as' => $filename,               
        'mime' => 'application/pdf',     
    ],
];
```

### Risposta: Flusso Completo Step-by-Step

---

## 🔍 STEP 1: Generazione Contenuto PDF Binario

**File:** `Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php`  
**Linee:** 79-80

```php
$pdfContent = app(GetPdfContentByRecordAction::class)
    ->execute($record);
```

**Cosa succede:**
1. Laravel service container risolve `GetPdfContentByRecordAction`
2. Chiama metodo `execute()` passando il `$record` (SchedaContract)
3. Restituisce **string binaria** contenente il PDF completo

**Tipo:** `string` (contenuto binario, non testo leggibile)

---

## 🔍 STEP 2: Dentro GetPdfContentByRecordAction

**File:** `Modules/Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php`

### 2.1 Genera Nome Vista (Convenzioni Laraxot)

```php
// Linea 43
$viewName = $this->generateViewName($record);

// Implementazione (linee 90-97)
protected function generateViewName(Model $record): string
{
    $modelClass = get_class($record);
    // Example: 'Modules\Ptv\Models\Scheda'
    
    $modelName = class_basename($modelClass);
    // Example: 'Scheda'
    
    $module = Str::between($modelClass, 'Modules\\', '\\Models');
    // Example: 'Ptv'
    
    return mb_strtolower($module).'::'.Str::kebab($modelName).'.show.pdf';
    // Result: 'ptv::scheda.show.pdf'
}
```

**Output:** `'ptv::scheda.show.pdf'`

---

### 2.2 Prepara Parametri Vista

```php
// Linea 46
$viewParams = $this->prepareViewParameters($record, $viewName);

// Implementazione (linee 106-131)
protected function prepareViewParameters(Model $record, string $viewName): array
{
    $params = [
        'view' => $viewName,
        'row' => $record,
        'transKey' => 'ptv::schedas.fields',
    ];
    
    // Se esiste relazione 'valutatore' caricata
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

**Output:**
```php
[
    'view' => 'ptv::scheda.show.pdf',
    'row' => Scheda {#123 id: 123, matr: 'ABC123', cognome: 'Rossi', ...},
    'transKey' => 'ptv::schedas.fields',
    'firma' => 'Dott. Mario Verdi' // se valutatore presente
]
```

---

### 2.3 Valida Esistenza Vista

```php
// Linee 49-51
if (!view()->exists($viewName)) {
    throw new Exception("View '{$viewName}' not found for model ".get_class($record));
}
```

**Path Vista Fisico:**
```
Modules/Ptv/resources/views/scheda/show/pdf.blade.php
```

Laravel risolve `ptv::scheda.show.pdf` → path sopra

---

### 2.4 Renderizza Vista → HTML

```php
// Linea 54
$html = view($viewName, $viewParams)->render();
```

**Cosa succede:**
1. Laravel carica template Blade `scheda/show/pdf.blade.php`
2. Passa variabili: `$view`, `$row`, `$transKey`, `$firma`
3. Esegue rendering Blade → HTML completo
4. Restituisce string HTML

**Output Example:**
```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial; font-size: 12pt; }
        table { width: 100%; border-collapse: collapse; }
    </style>
</head>
<body>
    <h1>Scheda Valutazione - Rossi Mario</h1>
    <p>Matricola: ABC123</p>
    <!-- ... più contenuto ... -->
    <div class="firma">
        <p>Dott. Mario Verdi</p>
    </div>
</body>
</html>
```

---

### 2.5 Valida HTML Generato

```php
// Linee 57-61
Assert::string($html, 'Generated HTML content must be a valid string');

if (empty(trim($html))) {
    throw new Exception("Generated HTML content is empty for view '{$viewName}'");
}
```

**Controlli:**
- HTML è stringa valida
- HTML non è vuoto (dopo trim)

---

### 2.6 Genera Nome File

```php
// Linee 64-66
if ($filename === null) {
    $filename = $this->generateFilename($record);
}

// Implementazione (linee 139-162)
protected function generateFilename(Model $record): string
{
    // Priorità 1: Record con identificativi personali
    if (isset($record->matr, $record->cognome, $record->nome)) {
        $matr = is_string($record->matr) ? $record->matr : 'unknown';
        $cognome = is_string($record->cognome) ? $record->cognome : 'unknown';
        $nome = is_string($record->nome) ? $record->nome : 'unknown';
        
        return 'scheda_'.((string)($record->getKey())).'_'.$matr.'_'.$cognome.'_'.$nome.'.pdf';
    }
    
    // Priorità 2: Record con 'name'
    if (isset($record->name) && is_string($record->name)) {
        return 'model_'.$record->getKey().'_'.Str::slug($record->name).'.pdf';
    }
    
    // Default
    return 'model_'.$record->getKey().'.pdf';
}
```

**Output Example:** `'scheda_123_ABC123_Rossi_Mario.pdf'`

---

### 2.7 Conversione HTML → PDF Binario ⭐

**File:** `Modules/Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php`  
**Linee:** 173-203

```php
protected function generatePdfContent(string $html, string $filename): string
{
    try {
        // STEP 1: Crea istanza Html2Pdf con configurazione
        $html2pdf = new Html2Pdf(
            orientation: 'P',           // Portrait
            format: 'A4',              // A4 (210x297mm)
            lang: 'it',                // Italiano
            unicode: true,             // Unicode support
            encoding: 'UTF-8',         // UTF-8
            margins: [10, 10, 10, 10]  // 10mm margini
        );
        
        // STEP 2: Configurazioni aggiuntive
        $html2pdf->setTestTdInOnePage(false);  // Tabelle multi-pagina
        
        // STEP 3: Scrive HTML nel PDF
        $html2pdf->writeHTML($html);
        
        // STEP 4: Genera e restituisce contenuto binario
        return $html2pdf->output('', 'S');
        //                       │   │
        //                       │   └─ 'S' = String mode (binary content)
        //                       └───── Filename vuoto (non serve per mode 'S')
        
    } catch (Exception $e) {
        // Log dettagliato errore
        Log::error('PDF generation failed', [
            'filename' => $filename,
            'error' => $e->getMessage(),
        ]);
        
        throw new Exception('Failed to generate PDF: '.$e->getMessage(), 0, $e);
    }
}
```

**Output:** String binaria tipo:
```
%PDF-1.4
%âãÏÓ
1 0 obj
<< /Type /Catalog /Pages 2 0 R >>
endobj
2 0 obj
...
```

**Dimensione tipica:** 50KB - 500KB (dipende da contenuto)

---

## 🔍 STEP 3: Assegnazione al Campo 'data'

**Torniamo a:** `Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php`

```php
// Linea 79-80: Genera PDF binario
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
// $pdfContent = "%PDF-1.4\n%âãÏÓ\n1 0 obj..." (string binaria)

// Linee 83-89: Genera nome file dinamico
$filename = 'scheda.pdf';
if (isset($record->id, $record->matr, $record->cognome, $record->nome)) {
    $filename = 'scheda_'.$record->id.'_'.$record->matr.'_'.$record->cognome.'_'.$record->nome.'.pdf';
}
// $filename = "scheda_123_ABC123_Rossi_Mario.pdf"

// Linea 92: Inizializza array dati vuoto (per template email)
$data = [];

// Linee 100-106: Prepara array allegati ⭐⭐⭐
$attachments = [
    [
        'data' => $pdfContent,           // ⭐ CONTENUTO BINARIO PDF
        'as' => $filename,               // Nome file: "scheda_123_ABC123_Rossi_Mario.pdf"
        'mime' => 'application/pdf',     // MIME type
    ],
];
```

**Riepilogo:**
- `'data'` contiene la **string binaria del PDF** generato da spipu/html2pdf
- **NON** è un path a file
- **NON** è HTML
- **È** il contenuto binario completo del PDF (come se avessi fatto `file_get_contents('file.pdf')`)

---

## 🔍 STEP 4: Gestione Allegati in RecordNotification

**File:** `Modules/Notify/app/Notifications/RecordNotification.php`

```php
// Linea 109: Crea notifica
$notify = new RecordNotification($record, $template);

// Linea 110: Merge dati extra (opzionale)
$notify = $notify->mergeData($data);

// Linea 111: Aggiunge allegati ⭐
$notify = $notify->addAttachments($attachments);

// Implementazione addAttachments (linee 127-132)
public function addAttachments(array $attachments): self
{
    // Merge con allegati esistenti
    $this->attachments = array_merge($this->attachments, $attachments);
    //                   │
    //                   └─ Proprietà: array<int, array<string, string>>
    
    return $this;
}
```

**Stato dopo STEP 4:**
```php
$notify->attachments = [
    [
        'data' => "%PDF-1.4\n%âãÏÓ...",           // Binary PDF
        'as' => 'scheda_123_ABC123_Rossi_Mario.pdf',
        'mime' => 'application/pdf',
    ],
];
```

---

## 🔍 STEP 5: Conversione in SpatieEmail

**File:** `Modules/Notify/app/Notifications/RecordNotification.php`  
**Linee:** 55-60

```php
public function toMail($notifiable): SpatieEmail
{
    $email = new SpatieEmail($this->record, $this->slug);
    $email = $email->mergeData($this->data);
    
    // Passa allegati a SpatieEmail
    $email = $email->addAttachments($this->attachments);
    //                               │
    //                               └─ [['data' => binary, 'as' => name, 'mime' => type]]
    
    return $email;
}
```

---

## 🔍 STEP 6: Creazione Attachment da Binary Data

**File:** `Modules/Notify/app/Emails/SpatieEmail.php`  
**Linee:** 199-235

```php
public function getAttachmentFromData(array $attachment): Attachment
{
    // Valida parametri obbligatori
    Assert::keyExists($attachment, 'data', 'Attachment must have data');
    Assert::keyExists($attachment, 'as', 'Attachment must have filename (as)');
    Assert::string($attachment['as'], 'Attachment filename must be string');
    
    // ⭐ CREA ATTACHMENT DA CLOSURE CHE RESTITUISCE BINARY DATA
    $res = Attachment::fromData(fn () => $attachment['data']);
    //                            │
    //                            └─ Closure anonima che restituisce il contenuto binario
    //                               Questo permette a Laravel di gestire lazy loading
    
    $as = $attachment['as'];
    // Example: 'scheda_123_ABC123_Rossi_Mario.pdf'
    
    // Determina MIME type
    $mime = Arr::get($attachment, 'mime', null);
    
    if ($mime === null) {
        // Tenta da estensione filename
        $info = pathinfo($as);
        if (isset($info['extension'])) {
            $detectedMime = Arr::first(MimeTypes::getDefault()->getMimeTypes($info['extension']));
            $mime = is_string($detectedMime) ? $detectedMime : null;
        }
    }
    
    if ($mime === null) {
        $mime = 'application/octet-stream';
    }
    
    // Cast finale sicurezza
    if (!is_string($mime)) {
        $mime = 'application/octet-stream';
    }
    
    // Applica configurazioni all'attachment
    $res = $res->as($as)->withMime($mime);
    //         │         │
    //         │         └─ Imposta MIME type
    //         └─────────── Imposta nome file
    
    return $res;
}
```

**Output:**
```php
Attachment {
    name: 'scheda_123_ABC123_Rossi_Mario.pdf',
    mime: 'application/pdf',
    content: closure() → "%PDF-1.4\n%âãÏÓ..." (lazy loaded)
}
```

---

## 🔍 STEP 7: Attachment in Mailable

**File:** `Modules/Notify/app/Emails/SpatieEmail.php`  
**Linee:** 211-233

```php
public function addAttachments(array $attachments): self
{
    $attachmentObjects = [];
    
    foreach ($attachments as $item) {
        $attachment = null;
        
        // Priorità 1: File esistente
        if (isset($item['path']) && file_exists($item['path'])) {
            $attachment = $this->getAttachmentFromPath($item);
        }
        
        // Priorità 2: Contenuto binario ⭐ NOSTRO CASO
        if ($attachment === null && isset($item['data'])) {
            $attachment = $this->getAttachmentFromData($item);
        }
        
        if ($attachment) {
            $attachmentObjects[] = $attachment;
        }
    }
    
    $this->customAttachments = $attachmentObjects;
    //                          │
    //                          └─ array<int, Attachment>
    
    return $this;
}
```

---

## 🔍 STEP 8: Laravel Mail System

Quando Laravel invia l'email (via `Notification::route('mail', ...)->notify($notify)`):

```php
// Laravel internamente fa:
foreach ($email->attachments() as $attachment) {
    $swiftAttachment = new Swift_Attachment(
        $attachment->content(),      // ⭐ Chiama closure, ottiene binary data
        $attachment->as,             // Nome file
        $attachment->mime            // MIME type
    );
    $swiftMessage->attach($swiftAttachment);
}
```

**Il contenuto binario viene:**
1. Letto dalla closure (lazy loading)
2. Codificato in base64
3. Inserito nel MIME multipart/mixed email
4. Inviato via SMTP al destinatario

---

## 📊 Riepilogo Visuale

```
┌─────────────────────────────────────────────────────────────────┐
│                   SendMailByRecord.php                          │
│                                                                 │
│  $pdfContent = GetPdfContentByRecordAction->execute($record)   │
│      │                                                          │
│      └─► String binaria PDF (50-500KB)                          │
│                                                                 │
│  $attachments = [                                               │
│      [                                                          │
│          'data' => $pdfContent,  ◄─── STRING BINARIA PDF       │
│          'as' => 'scheda_123_ABC123_Rossi_Mario.pdf',          │
│          'mime' => 'application/pdf',                           │
│      ],                                                         │
│  ];                                                             │
│                                                                 │
│  RecordNotification->addAttachments($attachments)               │
└──────────────────┬──────────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────────┐
│              RecordNotification->toMail()                       │
│                                                                 │
│  SpatieEmail->addAttachments($this->attachments)                │
└──────────────────┬──────────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────────┐
│           SpatieEmail->getAttachmentFromData()                  │
│                                                                 │
│  Attachment::fromData(fn () => $attachment['data'])             │
│      │                          │                               │
│      │                          └─► Closure → Binary PDF        │
│      │                                                          │
│      └─► Attachment::as('scheda_123.pdf')                       │
│           ->withMime('application/pdf')                         │
└──────────────────┬──────────────────────────────────────────────┘
                   │
                   ▼
┌─────────────────────────────────────────────────────────────────┐
│                 Laravel Mail System                             │
│                                                                 │
│  1. Chiama closure → ottiene binary data                        │
│  2. Codifica base64                                             │
│  3. Crea MIME multipart/mixed                                   │
│  4. Invia via SMTP                                              │
└─────────────────────────────────────────────────────────────────┘
```

---

## 💡 Concetti Chiave

### 1. Binary String vs Text String

```php
// ❌ SBAGLIATO - Questo è testo HTML
$data = "<html><body>Ciao</body></html>";

// ✅ CORRETTO - Questo è binario PDF
$data = "%PDF-1.4\n%âãÏÓ\n1 0 obj\n<< /Type /Catalog...";
```

### 2. Closure per Lazy Loading

```php
// Laravel usa closure per lazy loading del contenuto
Attachment::fromData(fn () => $binaryContent);

// Vantaggi:
// - Contenuto caricato solo quando serve
// - Risparmio memoria per email con allegati multipli
// - Serializzabile per queue
```

### 3. MIME Type Importance

```php
// MIME corretto → Client email riconosce tipo file
'mime' => 'application/pdf'  // → Icona PDF, apertura diretta

// MIME generico → Client email mostra attachment generico
'mime' => 'application/octet-stream'
```

---

## 🧪 Testing

### Test Manuale

```bash
php artisan tinker
```

```php
// 1. Ottieni record
$scheda = \Modules\Ptv\Models\Scheda::with('valutatore')->first();

// 2. Genera PDF
$pdf = app(\Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction::class)->execute($scheda);

// 3. Verifica
echo "PDF Size: ".strlen($pdf)." bytes\n";
echo "Starts with: ".substr($pdf, 0, 10)."\n";
// Output: "PDF Size: 156789 bytes"
//         "Starts with: %PDF-1.4

// 4. Salva per test
file_put_contents('/tmp/test.pdf', $pdf);
// Poi apri /tmp/test.pdf con PDF viewer
```

### Test Automatico

```php
/** @test */
public function data_field_contains_valid_pdf_binary(): void
{
    $record = Scheda::factory()->create();
    
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
    
    // Verifica è string
    $this->assertIsString($pdfContent);
    
    // Verifica è PDF valido (magic number)
    $this->assertStringStartsWith('%PDF-', $pdfContent);
    
    // Verifica dimensione ragionevole
    $this->assertGreaterThan(1000, strlen($pdfContent));
    $this->assertLessThan(10000000, strlen($pdfContent)); // < 10MB
    
    // Verifica può essere usato in attachment
    $attachments = [
        [
            'data' => $pdfContent,
            'as' => 'test.pdf',
            'mime' => 'application/pdf',
        ],
    ];
    
    $this->assertCount(1, $attachments);
    $this->assertEquals('test.pdf', $attachments[0]['as']);
}
```

---

## 🎓 Conclusioni

### Risposta Sintetica

**Il campo `'data'` viene popolato con:**

**Contenuto binario PDF** generato da:
1. Rendering vista Blade → HTML
2. Conversione HTML → PDF (spipu/html2pdf)
3. Output in modalità 'S' (string) → Binary content

**NON è:**
- ❌ Un path a file
- ❌ HTML
- ❌ Testo normale
- ❌ Base64

**È:**
- ✅ Contenuto binario PDF completo
- ✅ Pronto per allegato email
- ✅ In memoria (no filesystem)
- ✅ Type-safe (validato con Assert)

### Filosofia del Design

**Perché binary data invece di path?**

1. **No File Temporanei** - Meno I/O, meno pulizia
2. **Thread-Safe** - No race conditions su file condivisi
3. **Scalabile** - Funziona in ambiente distribuito
4. **Atomico** - Generazione e invio in singola transazione
5. **Testabile** - Più facile da testare (no filesystem mock)

**Trade-off:**
- ✅ Pro: Performance, scalabilità, pulizia
- ⚠️ Con: Uso memoria per PDF grandi (mitigabile con queue)

---

## 🔗 Collegamenti

- [Ptv - Complete PDF Email Guide](../../Ptv/docs/pdf-email-attachments-complete-guide.md)
- [Xot - GetPdfContentByRecordAction Technical](../../Xot/docs/actions/pdf-content-generation-technical.md)
- [Notify - Email Attachments Usage](../../Notify/docs/email-sending/attachments_usage.md)
- [spipu/html2pdf Documentation](https://github.com/spipu/html2pdf)

---

**Ultimo aggiornamento:** 2025-01-22  
**Versione:** 1.0  
**Autore:** Analisi Tecnica Approfondita  
**Stato:** ✅ Verificato con PHPStan Level 10

