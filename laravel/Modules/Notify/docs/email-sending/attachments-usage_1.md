# Utilizzo Corretto degli Allegati nelle Email Spatie

Questa documentazione descrive come utilizzare correttamente il metodo `addAttachments()` nella classe `SpatieEmail` del modulo Notify.

## Formato degli Allegati

Il metodo `addAttachments()` accetta un array di array, dove ogni array interno rappresenta un singolo allegato con le relative proprietà.

### Formato Corretto

Il metodo `addAttachments()` supporta **due formati** per gli allegati:

#### Formato 1: Allegato da File Esistente (`path`)

```php
// Formato corretto - allegato da file su filesystem
$attachments = [
    [
        'path' => '/var/www/html/<nome progetto>/public_html/images/avatars/default-3.svg',
        'as' => 'logo.svg',  // Opzionale: nome del file da mostrare nell'email
        'mime' => 'image/svg+xml',  // Opzionale: MIME type del file
    ],
    // Eventualmente altri allegati...
    [
        'path' => '/var/www/html/<nome progetto>/public_html/documents/terms.pdf',
        'as' => 'termini.pdf',
        'mime' => 'application/pdf',
    ],
];
```

#### Formato 2: Allegato da Contenuto Binario (`data`)

```php
// Formato corretto - allegato da contenuto binario generato dinamicamente
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

$attachments = [
    [
        'data' => $pdfContent, // Contenuto binario del PDF generato
        'as' => 'scheda_123_Rossi_Mario.pdf', // Nome file dinamico
        'mime' => 'application/pdf', // Tipo MIME obbligatorio per 'data'
    ],
];
```

**Quando usare `data` invece di `path`**:
- ✅ File generati dinamicamente (PDF, immagini, report)
- ✅ Nessun file temporaneo su filesystem
- ✅ Performance migliori per file temporanei
- ✅ Più sicuro (no file residui)
- ❌ Non usare per file molto grandi (> 50MB) - usa `path` con storage dedicato

## Implementazione nella Classe SpatieEmail

La classe `SpatieEmail` utilizza la classe `Illuminate\Mail\Mailables\Attachment` di Laravel per gestire gli allegati in modo robusto:

```php
/**
 * Add attachments to the email
 *
 * @param array<int, array<string, string>> $attachments Array of attachment data
 * @return self
 */
public function addAttachments(array $attachments): self
{
    $attachmentObjects = [];
    
    foreach ($attachments as $item) {
        $attachment = null;
        
        // Priorità 1: Se esiste 'path' e il file esiste, usa getAttachmentFromPath()
        if (isset($item['path']) && file_exists($item['path'])) {
            $attachment = $this->getAttachmentFromPath($item);
        }
        
        // Priorità 2: Se non c'è path o file non esiste, prova con 'data' (contenuto binario)
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

/**
 * Get the attachments for the message.
 *
 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
 */
public function attachments(): array
{
    return $this->customAttachments;
}
```

## Esempio di Utilizzo Completo

### Esempio 1: Allegato da File Esistente

```php
// Creazione di un array di allegati da file esistenti
$attachments = [
    [
        'path' => 'modules/notify/resources/assets/images/logo.png',
        'as' => 'logo.png',
        'mime' => 'image/png',
    ],
];

// Invio email con allegati
Mail::to($recipient)
    ->locale('it')
    ->send((new SpatieEmail($user, 'email_template_slug'))
    ->addAttachments($attachments));
```

### Esempio 2: Allegato PDF Generato Dinamicamente

```php
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

// Genera contenuto PDF binario da un record
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

// Crea array allegati con contenuto binario
$attachments = [
    [
        'data' => $pdfContent, // Contenuto binario del PDF
        'as' => 'scheda_123_Rossi_Mario.pdf', // Nome file dinamico
        'mime' => 'application/pdf', // Tipo MIME obbligatorio
    ],
];

// Invio email con allegato PDF generato dinamicamente
$email = new SpatieEmail($record, 'schede');
$email->addAttachments($attachments);
Mail::to($recipient)->send($email);
```

### Esempio 3: Allegati Misti (File + Binario)

```php
// Combinazione di allegati da file e da contenuto binario
$attachments = [
    // Allegato da file esistente
    [
        'path' => storage_path('app/public/terms.pdf'),
        'as' => 'termini_condizioni.pdf',
        'mime' => 'application/pdf',
    ],
    // Allegato generato dinamicamente
    [
        'data' => $pdfContent,
        'as' => 'scheda_personale.pdf',
        'mime' => 'application/pdf',
    ],
];

$email = new SpatieEmail($record, 'schede');
$email->addAttachments($attachments);
Mail::to($recipient)->send($email);
```

## Opzioni Disponibili per gli Allegati

Ogni allegato può utilizzare **due formati** a seconda della fonte:

### Formato con `path` (File Esistente)

- `path` (**richiesto**): Percorso al file da allegare (può essere percorso relativo o assoluto)
- `as` (opzionale): Nome del file che apparirà nell'email
- `mime` (opzionale): Tipo MIME del file (es. 'image/png', 'application/pdf', ecc.)

### Formato con `data` (Contenuto Binario)

- `data` (**richiesto**): Contenuto binario del file da allegare (stringa binaria)
- `as` (**richiesto**): Nome del file che apparirà nell'email
- `mime` (**richiesto**): Tipo MIME del file (es. 'application/pdf', 'image/png', ecc.)

**Nota**: Il tipo MIME è obbligatorio quando si usa `data` perché il sistema non può dedurlo automaticamente dal contenuto binario.

## Note Aggiuntive

### File Esistenti (`path`)
- Assicurarsi che i file specificati nei percorsi esistano
- Verificare i permessi di lettura sul file
- Per file molto grandi, considerare l'utilizzo di storage dedicato

### Contenuto Binario (`data`)
- Il tipo MIME è **obbligatorio** quando si usa `data`
- Per file molto grandi (> 50MB), considerare di salvare su filesystem e usare `path`
- Gestire memory limit per PDF molto grandi
- Il contenuto binario viene mantenuto in memoria fino all'invio dell'email

### Performance
- Per allegati di grandi dimensioni, considerare l'utilizzo di un job in coda
- Verificare che i tipi MIME siano corretti per evitare problemi di visualizzazione nei client email
- Usare `data` per file generati dinamicamente evita operazioni I/O su filesystem

## Esempi Pratici da Progetti Reali

### Esempio: Email con PDF di Scheda Valutazione

Vedi [Email PDF Attachments](../../../Ptv/docs/email-pdf-attachments.md) per un esempio completo di generazione e invio PDF come allegato email.

## Esempi Completi

### Esempio 1: PDF Generato Dinamicamente (Pattern Raccomandato)

```php
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Modules\Notify\Notifications\RecordNotification;

// Genera PDF binario
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);

// Prepara allegato
$attachments = [
    [
        'data' => $pdfContent,
        'as' => 'documento_'.$record->id.'.pdf',
        'mime' => 'application/pdf',
    ],
];

// Invia email
$notify = new RecordNotification($record, 'template-slug');
$notify = $notify->addAttachments($attachments);

Notification::route('mail', 'destinatario@example.com')->notify($notify);
```

### Esempio 2: File Esistente + PDF Dinamico

```php
$attachments = [
    // File esistente
    [
        'path' => storage_path('documents/contratto.pdf'),
        'as' => 'contratto.pdf',
        'mime' => 'application/pdf',
    ],
    // PDF generato
    [
        'data' => app(GetPdfContentByRecordAction::class)->execute($record),
        'as' => 'dettaglio.pdf',
        'mime' => 'application/pdf',
    ],
];

$email = new SpatieEmail($record, 'multi-attachment');
$email->addAttachments($attachments);
Mail::to($recipient)->send($email);
```

### Esempio 3: Bulk Action con PDF Multipli

```php
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

foreach ($records as $record) {
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
    
    $attachments = [
        [
            'data' => $pdfContent,
            'as' => "scheda_{$record->id}.pdf",
            'mime' => 'application/pdf',
        ],
    ];
    
    $notify = new RecordNotification($record, 'bulk-template');
    $notify->addAttachments($attachments);
    
    Notification::route('mail', $record->email)->notify($notify);
}
```

## Collegamenti alla Documentazione Correlata

### Documentazione Interna
- [Ptv - Complete PDF Email Guide](../../../Ptv/docs/pdf-email-attachments-complete-guide.md)
- [Xot - PDF Generation Technical](../../../Xot/docs/actions/pdf-content-generation-technical.md)
- [EMAIL_LAYOUTS_BEST_PRACTICES.md](../mail-templates/EMAIL_LAYOUTS_BEST_PRACTICES.md)
- [SPATIE_MAIL_TEMPLATES_STRUCTURE.md](../mail-templates/SPATIE_MAIL_TEMPLATES_STRUCTURE.md)
- [EMAIL_TROUBLESHOOTING.md](./EMAIL_TROUBLESHOOTING.md)

### File Correlati
- `Modules/Notify/app/Emails/SpatieEmail.php` - Gestione allegati
- `Modules/Notify/app/Notifications/RecordNotification.php` - Notifiche con allegati
- `Modules/Xot/app/Actions/Pdf/GetPdfContentByRecordAction.php` - Generazione PDF
