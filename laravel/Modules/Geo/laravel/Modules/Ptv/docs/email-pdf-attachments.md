# Invio Email con Allegati PDF - SendMailByRecord

## Panoramica

Il metodo `SendMailByRecord::execute()` gestisce l'invio di email con allegati PDF generati dinamicamente da record di tipo `SchedaContract`. Il sistema utilizza `spatie/laravel-database-mail-templates` per la gestione dei template email e `GetPdfContentByRecordAction` per la generazione del contenuto PDF binario.

## Business Logic

### Scopo

L'action `SendMailByRecord` è progettata per:
1. **Generare PDF dinamici**: Creare PDF da record seguendo le convenzioni Laraxot
2. **Allegare PDF alle email**: Inviare PDF come allegati senza salvare file su filesystem
3. **Gestire relazioni**: Caricare automaticamente relazioni necessarie (es. `valutatore`)
4. **Naming dinamico**: Generare nomi file significativi basati sui dati del record

### Perché Generare PDF Binario?

**Scenario**: Email transazionali con documenti PDF personalizzati

- **Problema tradizionale**: Salvare PDF su filesystem, poi allegare il file
  - Gestione file temporanei
  - Pulizia storage
  - Permessi filesystem
  - Performance su file system condivisi

- **Soluzione**: Generare PDF in memoria e allegarlo direttamente
  - Nessun file temporaneo
  - Performance migliori
  - Più sicuro (no file residui)
  - Ideale per email transazionali

## Architettura

### Flusso di Esecuzione

```
SendMailByRecord::execute()
    ↓
1. Verifica autorizzazione utente
    ↓
2. Verifica che record sia Model
    ↓
3. Carica relazione valutatore (se necessario)
    ↓
4. GetPdfContentByRecordAction::execute()
    ├─ Genera nome view automatico
    ├─ Prepara parametri view
    ├─ Renderizza view Blade → HTML
    └─ Converte HTML → PDF binario (spipu/html2pdf)
    ↓
5. Genera nome file dinamico
    ↓
6. Prepara array allegati con campo 'data'
    ↓
7. RecordNotification::addAttachments()
    ↓
8. SpatieEmail::addAttachments()
    ├─ getAttachmentFromData()
    └─ Attachment::fromData() → Attachment object
    ↓
9. Invio email con allegato PDF
```

## Implementazione

### Codice Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Webmozart\Assert\Assert;
use Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;

class SendMailByRecord
{
    use QueueableAction;

    /**
     * Invia una mail relativa al record della scheda con allegato PDF.
     *
     * @param SchedaContract $record Il record della scheda per cui inviare la mail
     * @param string $template Slug del template email nel database
     *
     * @throws AuthorizationException Se l'utente non ha i permessi
     *
     * @return bool True se l'invio è andato a buon fine
     */
    public function execute(SchedaContract $record, string $template = 'schede'): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->can('sendMail', $record)) {
            abort(403, 'Unauthorized action.');
        }

        // Verifica che il record sia un Model per compatibilità con GetPdfContentByRecordAction
        Assert::isInstanceOf($record, Model::class);
        
        // Carica la relazione valutatore se esiste e non è già caricata
        if (
            method_exists($record, 'valutatore') &&
            ! $record->relationLoaded('valutatore')
        ) {
            $record->load('valutatore');
        }
        
        // Genera il contenuto PDF binario utilizzando GetPdfContentByRecordAction
        $pdfContent = app(GetPdfContentByRecordAction::class)
            ->execute($record);
        
        // Genera nome file dinamico utilizzando GetFilenameBySchedaAction
        // Questa action centralizza la logica di generazione del nome file,
        // garantendo coerenza e riutilizzabilità in tutto il modulo
        $filename = app(GetFilenameBySchedaAction::class)
            ->execute($record);
        
        // Prepara gli allegati con il contenuto PDF binario
        $attachments = [
            [
                'data' => $pdfContent, // Contenuto binario del PDF
                'as' => $filename, // Nome file dinamico
                'mime' => 'application/pdf', // Tipo MIME
            ],
        ];
        
        // Crea la notifica e aggiunge dati e allegati
        $notify = new RecordNotification($record, $template);
        $notify = $notify->addAttachments($attachments);
        
        // Invia la notifica
        $to = 'marco.sottana@gmail.com'; // TODO: Sostituire con email reale
        Notification::route('mail', $to)
            ->notify($notify);

        return true;
    }
}
```

## Componenti Utilizzati

### GetFilenameBySchedaAction

**Namespace**: `Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction`

**Funzionalità**:
- Genera nomi file PDF dinamici basati sui dati della scheda
- Pattern: `scheda_{id}_{matr}_{cognome}_{nome}.pdf`
- Sanitizza automaticamente caratteri problematici nei nomi file
- Gestisce fallback quando i campi identificativi non sono disponibili
- Centralizza la logica di naming per garantire coerenza

**Vantaggi**:
- ✅ DRY: Logica di naming in un solo punto
- ✅ Coerenza: Stesso pattern ovunque
- ✅ Manutenibilità: Modifiche in un solo punto
- ✅ Testabilità: Test unitari dedicati

**Documentazione**: [GetFilenameBySchedaAction](./get-filename-by-scheda-action.md)

### GetPdfContentByRecordAction

**Namespace**: `Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction`

**Funzionalità**:
- Genera automaticamente il nome della view seguendo le convenzioni Laraxot
- Prepara i parametri per la view (incluso `valutatore` se caricato)
- Renderizza la view Blade in HTML
- Converte HTML in PDF utilizzando `spipu/html2pdf`
- Restituisce il contenuto binario del PDF come stringa

**Convenzione View**:
- Pattern: `{module}::{model-kebab}.show.pdf`
- Esempio: `ptv::progressioni-schede.show.pdf`

### SpatieEmail::addAttachments()

**Formato Allegati Supportato**:

```php
// Formato 1: Allegato da file esistente
$attachments = [
    [
        'path' => '/path/to/file.pdf',
        'as' => 'nome_file.pdf',
        'mime' => 'application/pdf',
    ],
];

// Formato 2: Allegato da contenuto binario (usato qui)
$attachments = [
    [
        'data' => $pdfContent, // Contenuto binario del PDF
        'as' => 'nome_file.pdf',
        'mime' => 'application/pdf',
    ],
];
```

**Metodo Interno**: `getAttachmentFromData()`
- Utilizza `Attachment::fromData()` di Laravel
- Gestisce automaticamente il tipo MIME
- Supporta callback per contenuti pesanti

## Gestione Relazioni

### Relazione Valutatore

Il sistema gestisce automaticamente la relazione `valutatore`:

1. **Verifica esistenza**: Controlla se il record ha il metodo `valutatore()`
2. **Lazy loading**: Carica la relazione solo se non è già caricata
3. **Parametri view**: `GetPdfContentByRecordAction` inserisce automaticamente `firma` se `valutatore` è disponibile

```php
// Carica relazione se necessario
if (
    method_exists($record, 'valutatore') &&
    ! $record->relationLoaded('valutatore')
) {
    $record->load('valutatore');
}

// GetPdfContentByRecordAction prepara automaticamente:
// $params['firma'] = $valutatore->nome_diri ?? null;
```

## Naming File PDF

### Pattern di Naming

Il sistema genera nomi file dinamici seguendo questo pattern:

```php
// Se disponibili: id, matr, cognome, nome
scheda_{id}_{matr}_{cognome}_{nome}.pdf

// Esempio:
scheda_123_45678_Rossi_Mario.pdf

// Fallback se mancano campi
scheda.pdf
```

### Benefici

- **Tracciabilità**: Nome file identifica immediatamente il record
- **Organizzazione**: Facile identificare allegati nelle email
- **Debug**: Nome file informativo per troubleshooting

## Best Practices

### 1. Eager Loading Relazioni

**✅ DO**: Caricare relazioni necessarie prima di generare PDF

```php
// Carica valutatore se necessario
if (method_exists($record, 'valutatore') && ! $record->relationLoaded('valutatore')) {
    $record->load('valutatore');
}
```

**❌ DON'T**: Assumere che le relazioni siano già caricate

```php
// Non fare questo
$pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
// Se valutatore non è caricato, la view potrebbe non avere 'firma'
```

### 2. Gestione Errori

**✅ DO**: Gestire eccezioni durante generazione PDF

```php
try {
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
} catch (Exception $e) {
    Log::error('PDF generation failed', [
        'record_id' => $record->id,
        'error' => $e->getMessage(),
    ]);
    throw $e;
}
```

### 3. Memoria e Performance

**✅ DO**: Considerare memory limit per PDF grandi

```php
// Per PDF molto grandi, considera di aumentare memory limit temporaneamente
$originalLimit = ini_get('memory_limit');
ini_set('memory_limit', '512M');

try {
    $pdfContent = app(GetPdfContentByRecordAction::class)->execute($record);
} finally {
    ini_set('memory_limit', $originalLimit);
}
```

### 4. Validazione Record

**✅ DO**: Verificare che il record sia un Model valido

```php
Assert::isInstanceOf($record, Model::class);
```

## Integrazione con Template Email

### Template Database

Il template email viene caricato dal database tramite `RecordNotification`:

```php
// Il template viene cercato con:
// - mailable: SpatieEmail::class
// - slug: 'schede' (o il valore passato)
```

### Variabili Template Disponibili

Il template può utilizzare tutte le proprietà del record come variabili Mustache:

```mustache
<!-- Template email -->
<p>Gentile {{ cognome }} {{ nome }},</p>
<p>In allegato trovi la tua scheda di valutazione.</p>
```

## Testing

### Test Unitario Esempio

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Feature\Actions\Scheda;

use Tests\TestCase;
use Modules\Ptv\Models\Schede;
use Modules\User\Models\User;
use Modules\Ptv\Actions\Scheda\SendMailByRecord;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

class SendMailByRecordTest extends TestCase
{
    /** @test */
    public function it_generates_pdf_and_sends_email_with_attachment(): void
    {
        // Arrange
        Queue::fake();
        Notification::fake();
        
        $user = User::factory()->create();
        $record = Schede::factory()->create();
        
        // Act
        $action = new SendMailByRecord();
        $result = $action->execute($record, 'schede');
        
        // Assert
        $this->assertTrue($result);
        
        Notification::assertSentTo(
            $user,
            function ($notification) use ($record) {
                return $notification->record->id === $record->id;
            }
        );
    }
}
```

## Troubleshooting

### Problema: View non trovata

**Errore**: `View 'ptv::schede.show.pdf' not found`

**Soluzione**:
1. Verificare che la view esista in `Modules/Ptv/resources/views/schede/show.pdf.blade.php`
2. Verificare che il nome del modello corrisponda alle convenzioni Laraxot
3. Controllare il namespace del modello

### Problema: Valutatore non disponibile nella view

**Errore**: Variabile `firma` non definita nella view

**Soluzione**:
```php
// Assicurarsi di caricare la relazione prima
if (method_exists($record, 'valutatore') && ! $record->relationLoaded('valutatore')) {
    $record->load('valutatore');
}
```

### Problema: PDF non viene allegato

**Errore**: Email inviata ma senza allegato

**Soluzione**:
1. Verificare che il campo `data` contenga contenuto binario valido
2. Verificare che il tipo MIME sia corretto (`application/pdf`)
3. Controllare che `RecordNotification::addAttachments()` sia chiamato correttamente

### Problema: Memory limit exceeded

**Errore**: `Allowed memory size exhausted`

**Soluzione**:
```php
// Aumentare memory limit temporaneamente
ini_set('memory_limit', '512M');
```

## Collegamenti

### Documentazione Correlata

- [GetFilenameBySchedaAction](./get-filename-by-scheda-action.md) - Generazione nomi file PDF
- [Email Attachments Usage](../../../Notify/docs/email-sending/attachments_usage.md)
- [Spatie Database Mail Templates](../../../Notify/docs/spatie-database-mail-templates-deep-dive.md)
- [GetPdfContentByRecordAction](../../../Xot/docs/pdf-generation.md)
- [RecordNotification](../../../Notify/docs/notifications/record-notification.md)

### Repository di Riferimento

- [spatie/laravel-database-mail-templates](https://github.com/spatie/laravel-database-mail-templates)
- [spipu/html2pdf](https://github.com/spipu/html2pdf)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 1.0.0  
**Compatibilità**: PHPStan livello 10 ✅

