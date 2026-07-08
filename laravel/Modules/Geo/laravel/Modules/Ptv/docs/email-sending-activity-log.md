# Activity Log per Invio Email Schede - Spatie Activity Log Integration

## 🎯 Obiettivo

Registrare **ogni invio di email** per schede di valutazione utilizzando `spatie/laravel-activitylog`, tracciando:
- Data e ora dell'invio
- Dati di valutazione del record (valutatore, matricola, cognome, nome, anno, etc.)
- Template email utilizzato
- Destinatario email
- Filename PDF allegato
- Stato invio (successo/errore)

## ✅ Implementazione Completata

L'activity logging è stato implementato seguendo il pattern **Spatie QueueableAction** con separazione delle responsabilità:

- ✅ **PrepareEvaluationDataAction** - Estrae dati valutazione
- ✅ **LogEmailSentAction** - Registra invii riusciti
- ✅ Logging automatico ogni invio email riuscito
- ✅ Dati di valutazione completi nelle properties
- ✅ Codice semplificato seguendo principio KISS (rimosso try-catch superfluo)
- ✅ PHPStan livello 10 compliant
- ✅ PHPMD e PHPInsights compliant

### Architettura Actions

```php
// SendMailByRecord - Orchestratore principale
// Semplicità: se l'invio ha successo, loggiamo. Se fallisce, l'eccezione risale naturalmente.
// Clean Code: max 3 parametri per metodo - usiamo EmailSentLogData DTO

Notification::route('mail', $recipient)->notify($notify);

// Registra activity log per invio riuscito con DTO (Clean Code compliant)
// Se l'invio fallisce, l'eccezione risale e questa action non viene eseguita
app(LogEmailSentAction::class)->execute(
    new EmailSentLogData(
        record: $record,
        user: $user,
        template: $template,
        recipient: $recipient,
        filename: $filename,
        pdfContent: $pdfContent,
    )
);

return true;
```

**Nota**: Il try-catch è stato rimosso seguendo il principio KISS. Se l'invio fallisce, l'eccezione risale naturalmente e viene gestita dal sistema di notifiche Laravel. Gli errori vengono comunque loggati nei log standard di Laravel.

**Clean Code Compliance**: `LogEmailSentAction::execute()` accetta un solo parametro (`EmailSentLogData` DTO) invece di 6 parametri separati, seguendo il principio Clean Code di non superare mai 3 parametri per metodo.

### Actions Create

#### 1. PrepareEvaluationDataAction

**Path**: `Modules/Ptv/app/Actions/Scheda/PrepareEvaluationDataAction.php`

Estrae tutti i dati di valutazione da un record scheda per logging e audit trail.

```php
app(PrepareEvaluationDataAction::class)->execute($record);
```

**Ritorna**:
```php
[
    'matr' => '12345',
    'cognome' => 'Rossi',
    'nome' => 'Mario',
    'anno' => 2024,
    'ente' => 'Ente',
    'stabi' => 'STABI001',
    'repar' => 'REPAR001',
    'valutatore_id' => 42,
    'valutatore_nome' => 'Valutatore Nome',
]
```

#### 2. LogEmailSentAction

**Path**: `Modules/Ptv/app/Actions/Scheda/LogEmailSentAction.php`

Registra activity log per invii email riusciti.

**Clean Code Compliance**: Accetta un solo parametro (`EmailSentLogData` DTO) invece di 6 parametri separati.

```php
app(LogEmailSentAction::class)->execute(
    new EmailSentLogData(
        record: $record,
        user: $user,
        template: $template,
        recipient: $recipient,
        filename: $filename,
        pdfContent: $pdfContent,
    )
);
```

**Nota**: Questa action viene chiamata solo se l'invio ha successo. Se l'invio fallisce, l'eccezione risale naturalmente e il logging non viene eseguito.

#### 3. EmailSentLogData (DTO)

**Path**: `Modules/Ptv/app/Data/EmailSentLogData.php`

Data Transfer Object che incapsula tutti i dati necessari per il logging dell'invio email, seguendo il principio Clean Code di non superare mai 3 parametri per metodo.

```php
use Modules\Ptv\Data\EmailSentLogData;

new EmailSentLogData(
    record: $record,
    user: $user,
    template: $template,
    recipient: $recipient,
    filename: $filename,
    pdfContent: $pdfContent,
);
```

### Vantaggi del Refactoring

1. **Separazione Responsabilità** - Ogni action ha uno scopo ben definito
2. **Riutilizzabilità** - Actions possono essere usate in altri contesti
3. **Testabilità** - Facile testare ogni action in isolamento
4. **DRY + KISS** - Logica centralizzata, codice semplice e chiaro (rimosso try-catch superfluo)
5. **Queueable** - Actions possono essere accodate se necessario
6. **Semplicità** - Se l'invio fallisce, l'eccezione risale naturalmente senza logging aggiuntivo
7. **Clean Code** - Max 3 parametri per metodo rispettato tramite DTO (`EmailSentLogData`)
8. **Type Safety** - DTO garantisce tipizzazione stretta e immutabilità

### Codice Legacy (Rimosso)

```php
// ❌ RIMOSSO - Try-catch superfluo rimosso seguendo KISS
try {
    Notification::route('mail', $recipient)->notify($notify);
    app(LogEmailSentAction::class)->execute(...);
    return true;
} catch (\Exception $e) {
    app(LogEmailErrorAction::class)->execute(..., $e);
    throw $e; // Rilancia comunque l'eccezione
}

// ❌ RIMOSSO - Metodi helper spostati in actions dedicate
protected function logEmailSent(...) { }
protected function logEmailError(...) { }
protected function prepareEvaluationData(...) { }
```
        ->withProperties([
            'template' => $template,
            'recipient' => $recipient,
            'filename' => $filename,
            'evaluation_data' => $this->prepareEvaluationData($record),
            'pdf_size' => strlen($pdfContent),
            'error' => $e->getMessage(),
            'error_class' => get_class($e),
        ])
        ->log('Errore invio email per scheda');

    throw $e;
}
```

### Metodo Helper

```php
protected function prepareEvaluationData(SchedaContract $record): array
{
    // Estrae tutti i dati di valutazione in modo sicuro
    // Gestisce valutatore se caricato
    // PHPStan livello 10 compliant
}
```

## 📚 Studio del Pacchetto Spatie Activity Log

### Documentazione Ufficiale
- **GitHub**: https://github.com/spatie/laravel-activitylog
- **Documentazione**: https://spatie.be/docs/laravel-activitylog

### Pattern Fondamentale

Il pacchetto fornisce l'helper `activity()` per registrare attività manuali:

```php
activity()
    ->performedOn($model)      // Soggetto dell'azione
    ->causedBy($user)           // Chi ha causato l'azione
    ->withProperties(['key' => 'value'])  // Dati aggiuntivi
    ->log('Description');       // Descrizione dell'azione
```

### Struttura Database

La tabella `activity_log` contiene:
- `log_name`: Nome del log (es. 'email_sent')
- `description`: Descrizione dell'azione
- `subject_type`: Classe del modello soggetto
- `subject_id`: ID del modello soggetto
- `causer_type`: Classe dell'utente che ha causato l'azione
- `causer_id`: ID dell'utente
- `properties`: JSON con dati aggiuntivi
- `created_at`: Timestamp automatico

## 🏗️ Architettura della Soluzione

### Business Logic

**Problema da Risolvere**:
- Audit trail completo degli invii email
- Tracciamento dati di valutazione per compliance
- Debug e troubleshooting invii falliti
- Reportistica invii per periodo/dipendente

**Soluzione**:
- Utilizzare `activity()` helper direttamente in `SendMailByRecord`
- Registrare PRIMA dell'invio (tentativo) e DOPO (successo/errore)
- Includere tutti i dati di valutazione nelle properties
- Log name specifico: `'email_schede_sent'`

### Dati da Registrare

#### Properties Essenziali
```php
[
    'template' => 'schede',                    // Template email usato
    'recipient' => 'marco.sottana@gmail.com',  // Destinatario
    'filename' => 'scheda_123_456_Rossi_Mario.pdf', // Nome file PDF
    'evaluation_data' => [
        'matr' => $record->matr,              // Matricola
        'cognome' => $record->cognome,        // Cognome
        'nome' => $record->nome,               // Nome
        'anno' => $record->anno,               // Anno valutazione
        'ente' => $record->ente,               // Codice ente
        'stabi' => $record->stabi,             // Stabilimento
        'repar' => $record->repar,             // Reparto
        'valutatore_id' => $record->valutatore?->id,  // ID valutatore
        'valutatore_nome' => $record->valutatore?->nome_diri, // Nome valutatore
    ],
    'pdf_size' => strlen($pdfContent),         // Dimensione PDF in bytes
]
```

## 🔧 Implementazione

### Pattern di Logging

**Opzione 1: Log Singolo dopo Invio** (Raccomandato)
- ✅ Semplice e diretto
- ✅ Un solo record per invio
- ✅ Timestamp automatico da `created_at`

**Opzione 2: Log Doppio (Tentativo + Risultato)**
- ⚠️ Più complesso
- ✅ Permette tracking tentativi falliti
- ⚠️ Due record per invio

**Scelta**: **Opzione 1** per semplicità e perché Notification gestisce già gli errori internamente.

### Codice Implementazione

```php
// In SendMailByRecord::execute()

// Dopo preparazione dati ma PRIMA dell'invio
activity()
    ->performedOn($record)
    ->causedBy($user)
    ->withProperties([
        'template' => $template,
        'recipient' => $recipient,
        'filename' => $filename,
        'evaluation_data' => [
            'matr' => $record->matr ?? null,
            'cognome' => $record->cognome ?? null,
            'nome' => $record->nome ?? null,
            'anno' => $record->anno ?? null,
            'ente' => $record->ente ?? null,
            'stabi' => $record->stabi ?? null,
            'repar' => $record->repar ?? null,
            'valutatore_id' => $record->valutatore?->id ?? null,
            'valutatore_nome' => $record->valutatore?->nome_diri ?? null,
        ],
        'pdf_size' => strlen($pdfContent),
    ])
    ->log('Email inviata per scheda');
```

### Gestione Errori

```php
try {
    Notification::route('mail', $recipient)->notify($notify);
    
    activity()
        ->performedOn($record)
        ->causedBy($user)
        ->withProperties([...])
        ->log('Email inviata per scheda');
        
    return true;
} catch (\Exception $e) {
    activity()
        ->performedOn($record)
        ->causedBy($user)
        ->withProperties([
            ...,
            'error' => $e->getMessage(),
            'error_class' => get_class($e),
        ])
        ->log('Errore invio email per scheda');
        
    throw $e;
}
```

## 📊 Query Utili

### Recuperare Tutti gli Invii di una Scheda

```php
use Modules\Activity\Models\Activity;
use Spatie\Activitylog\Models\Activity;

$activities = Activity::where('subject_type', get_class($record))
    ->where('subject_id', $record->id)
    ->where('log_name', 'email_schede_sent')
    ->get();
```

### Recuperare Invii per Valutatore

```php
$activities = Activity::where('log_name', 'email_schede_sent')
    ->whereJsonContains('properties->evaluation_data->valutatore_id', $valutatoreId)
    ->get();
```

### Recuperare Invii per Periodo

```php
$activities = Activity::where('log_name', 'email_schede_sent')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->get();
```

### Recuperare Invii per Dipendente (Matricola)

```php
$activities = Activity::where('log_name', 'email_schede_sent')
    ->whereJsonContains('properties->evaluation_data->matr', $matr)
    ->get();
```

## 🔍 Verifica e Testing

### Test Manuale

```php
// Test invio email
$record = Schede::find(123);
app(SendMailByRecord::class)->execute($record);

// Verifica log creato
$activity = Activity::latest()->first();
assert($activity->log_name === 'email_schede_sent');
assert($activity->subject_id === $record->id);
assert($activity->properties['evaluation_data']['matr'] === $record->matr);
```

### Verifica Properties

```php
$activity = Activity::latest()->first();
$properties = $activity->properties;

// Verifica struttura
assert(isset($properties['template']));
assert(isset($properties['recipient']));
assert(isset($properties['filename']));
assert(isset($properties['evaluation_data']));
assert(isset($properties['evaluation_data']['matr']));
assert(isset($properties['evaluation_data']['valutatore_id']));
```

## 📈 Reportistica

### Dashboard Filament

Creare widget per visualizzare:
- Invii email per periodo
- Invii per valutatore
- Invii per dipendente
- Rate successo/errore

### Esportazione Report

```php
use Modules\Activity\Models\Activity;

$activities = Activity::where('log_name', 'email_schede_sent')
    ->whereBetween('created_at', [$startDate, $endDate])
    ->get()
    ->map(function ($activity) {
        return [
            'data' => $activity->created_at->format('d/m/Y H:i'),
            'destinatario' => $activity->properties['recipient'],
            'matr' => $activity->properties['evaluation_data']['matr'],
            'cognome' => $activity->properties['evaluation_data']['cognome'],
            'nome' => $activity->properties['evaluation_data']['nome'],
            'valutatore' => $activity->properties['evaluation_data']['valutatore_nome'],
            'filename' => $activity->properties['filename'],
        ];
    });
```

## 🔗 Collegamenti

- [Spatie Activity Log - GitHub](https://github.com/spatie/laravel-activitylog)
- [Spatie Activity Log - Docs](https://spatie.be/docs/laravel-activitylog)
- [Spatie QueueableAction - GitHub](https://github.com/spatie/laravel-queueable-action)
- [SendMailByRecord Action](../app/Actions/Scheda/SendMailByRecord.php)
- [PrepareEvaluationDataAction](../app/Actions/Scheda/PrepareEvaluationDataAction.php)
- [LogEmailSentAction](../app/Actions/Scheda/LogEmailSentAction.php)
- [LogEmailErrorAction](../app/Actions/Scheda/LogEmailErrorAction.php)
- [Activity Module Docs](../../Activity/docs/README.md)
- [BaseScheda Activity Log](./models/base-scheda-activity-log.md)
- [GetFilenameBySchedaAction](./get-filename-by-scheda-action.md)

## 📝 Note Implementative

### Timestamp Automatico
- `created_at` viene impostato automaticamente da Activity Log
- Non serve aggiungere `sent_at` manualmente (redundante)
- Usare `created_at` per tutte le query temporali

### Performance
- Activity Log è ottimizzato per inserimenti veloci
- Properties JSON vengono indicizzati automaticamente
- Query con `whereJsonContains` sono supportate

### Sicurezza
- Nessun dato sensibile (password, token) nelle properties
- Email destinatario è già pubblico (email dipendente)
- Dati valutazione sono interni al sistema

---

**Ultimo aggiornamento**: Gennaio 2025  
**Stato**: Proposta implementazione  
**Prossimi Step**: Implementazione in SendMailByRecord

