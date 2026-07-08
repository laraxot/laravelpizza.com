# Activity Log Email Tracking - Implementazione Completa

## 📋 Overview

Implementazione completa del sistema di tracciamento invio email schede valutazione utilizzando `spatie/laravel-activitylog`.

**Prerequisito:** Lettura [Analisi Filosofica](./activity-log-email-tracking-philosophical-analysis.md)

---

## 🎯 Obiettivi Business

### Requisiti Funzionali

1. **Audit Trail Completo**
   - Tracciare OGNI invio email (successi E fallimenti)
   - Registrare data/ora precisa invio
   - Identificare utente che ha inviato

2. **Dati Scheda Valutazione**
   - Snapshot dati business-critical al momento invio
   - Valutatore assegnato
   - Metriche valutazione (stabi, coordinamento, responsabilità)

3. **Metadati Email**
   - Destinatario email
   - Template utilizzato
   - Informazioni PDF allegato (nome, dimensione)

4. **Compliance**
   - GDPR: Tracciabilità trattamento dati personali
   - Normativa PA: Audit trail comunicazioni ufficiali

---

## 🏗️ Architettura Soluzione

### Componenti

```
┌────────────────────────────────────────────────────────┐
│         SendMailByRecord (Orchestrator)                │
│                                                        │
│  1. Verifica permessi                                  │
│  2. Genera PDF                                         │
│  3. try {                                              │
│       Invia email                                      │
│       success = true                                   │
│    } catch {                                           │
│       success = false                                  │
│    }                                                   │
│  4. Log activity (SEMPRE)                              │
└─────────────────┬──────────────────────────────────────┘
                  │
                  ▼
┌────────────────────────────────────────────────────────┐
│      LogSchedaEmailSentAction (Dedicated Logger)       │
│                                                        │
│  • Extract scheda data (NO accessor problematici)      │
│  • Prepare email metadata                              │
│  • Create Activity record                              │
│  • Return Activity model                               │
└────────────────────────────────────────────────────────┘
```

---

## 💻 Implementazione Codice

### STEP 1: Creare LogSchedaEmailSentAction

**File:** `Modules/Ptv/app/Actions/Activity/LogSchedaEmailSentAction.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Activity;

use Modules\Activity\Models\Activity;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Log invio email scheda valutazione.
 *
 * Traccia ogni invio email (success/failure) con dati business-critical
 * per compliance, audit trail e analytics.
 */
class LogSchedaEmailSentAction
{
    use QueueableAction;

    /**
     * Logga invio email scheda.
     *
     * @param  SchedaContract  $scheda  Record scheda inviata
     * @param  string  $recipient  Destinatario email
     * @param  string  $template  Template email utilizzato
     * @param  string  $pdfFilename  Nome file PDF allegato
     * @param  int  $pdfSizeBytes  Dimensione PDF in bytes
     * @param  bool  $success  Se invio è riuscito
     * @param  string|null  $error  Messaggio errore (se fallito)
     * @return Activity Activity record creato
     */
    public function execute(
        SchedaContract $scheda,
        string $recipient,
        string $template,
        string $pdfFilename,
        int $pdfSizeBytes,
        bool $success = true,
        ?string $error = null,
    ): Activity {
        // Valida parametri critici
        Assert::email($recipient, 'Recipient must be valid email');
        Assert::greaterThan($pdfSizeBytes, 0, 'PDF size must be greater than 0');

        // Estrai dati scheda (safe, no accessor)
        $schedaData = $this->extractSchedaData($scheda);

        // Prepara metadati email
        $emailData = $this->prepareEmailMetadata(
            recipient: $recipient,
            template: $template,
            pdfFilename: $pdfFilename,
            pdfSizeBytes: $pdfSizeBytes,
        );

        // Prepara result data
        $resultData = [
            'success' => $success,
            'error' => $error,
        ];

        // Merge tutte le properties
        $properties = [
            'scheda' => $schedaData,
            'email' => $emailData,
            'result' => $resultData,
        ];

        // Crea activity log
        return activity()
            ->performedOn($scheda)
            ->causedBy(auth()->user())
            ->withProperties($properties)
            ->log($success
                ? 'Email scheda valutazione inviata con successo'
                : 'Tentativo invio email scheda fallito: '.$error
            );
    }

    /**
     * Estrae dati business-critical dalla scheda.
     *
     * IMPORTANTE: Usa getAttributes() per evitare accessor problematici.
     *
     * @param  SchedaContract  $scheda
     * @return array<string, mixed>
     */
    private function extractSchedaData(SchedaContract $scheda): array
    {
        // Usa getAttributes() per accesso diretto ai campi database
        // EVITA accessor che chiamano save() (problema SchedaTrait)
        $attributes = $scheda->getAttributes();

        // Dati identificativi
        $data = [
            'id' => $attributes['id'] ?? null,
            'anno' => $attributes['anno'] ?? null,
            'matr' => $attributes['matr'] ?? null,
            'cognome' => $attributes['cognome'] ?? null,
            'nome' => $attributes['nome'] ?? null,
        ];

        // Dati valutazione
        $data['valutatore_id'] = $attributes['valutatore_id'] ?? null;
        $data['stabi'] = $attributes['stabi'] ?? null,
        $data['coordinamento'] = $attributes['coordinamento'] ?? null;
        $data['responsabilita'] = $attributes['responsabilita'] ?? null;
        $data['gg_anno'] = $attributes['gg_anno'] ?? null;

        // Se valutatore è caricato, aggiungi nome
        if ($scheda->relationLoaded('valutatore') && $scheda->valutatore) {
            $data['valutatore_nome'] = $scheda->valutatore->nome ?? null;
        }

        return $data;
    }

    /**
     * Prepara metadati email.
     *
     * @return array<string, mixed>
     */
    private function prepareEmailMetadata(
        string $recipient,
        string $template,
        string $pdfFilename,
        int $pdfSizeBytes,
    ): array {
        return [
            'recipient' => $recipient,
            'template' => $template,
            'pdf_filename' => $pdfFilename,
            'pdf_size_bytes' => $pdfSizeBytes,
            'pdf_size_kb' => round($pdfSizeBytes / 1024, 2),
            'sent_at' => now()->toDateTimeString(),
            'sent_by_user_id' => auth()->id(),
            'sent_by_user_name' => auth()->user()?->name ?? 'System',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }
}
```

---

### STEP 2: Aggiornare SendMailByRecord

**File:** `Modules/Ptv/app/Actions/Scheda/SendMailByRecord.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Scheda;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Modules\Notify\Notifications\RecordNotification;
use Modules\Ptv\Actions\Activity\LogSchedaEmailSentAction;
use Modules\Ptv\Actions\Scheda\GetFilenameBySchedaAction;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\User\Models\User;
use Modules\Xot\Actions\Pdf\GetPdfContentByRecordAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class SendMailByRecord
{
    use QueueableAction;

    /**
     * Invia una mail relativa al record della scheda.
     *
     * @param  SchedaContract  $record  Il record della scheda per cui inviare la mail
     * @param  string  $template  Template email da utilizzare
     * @return bool True se l'invio è andato a buon fine
     *
     * @throws AuthorizationException Se l'utente non ha i permessi
     */
    public function execute(SchedaContract $record, string $template = 'schede'): bool
    {
        /** @var User $user */
        $user = Auth::user();

        if (! $user->can('sendMail', $record)) {
            abort(403, 'Unauthorized action.');
        }

        Assert::isInstanceOf($record, Model::class);

        // Carica relazione valutatore per PDF generation
        if (
            method_exists($record, 'valutatore') &&
            ! $record->relationLoaded('valutatore')
        ) {
            $record->load('valutatore');
        }

        // Genera PDF binario
        $pdfContent = app(GetPdfContentByRecordAction::class)
            ->execute($record);

        // Genera filename dinamico
        $filename = app(GetFilenameBySchedaAction::class)
            ->execute($record);

        // Prepara allegati
        $attachments = [
            [
                'data' => $pdfContent,
                'as' => $filename,
                'mime' => 'application/pdf',
            ],
        ];

        // Prepara dati template email
        $data = [];

        // Destinatario (TODO: ricavare da record o config)
        $recipient = 'marco.sottana@gmail.com';

        // Variabili per activity log
        $success = false;
        $error = null;

        try {
            // Crea e invia notifica
            $notify = new RecordNotification($record, $template);
            $notify = $notify->mergeData($data);
            $notify = $notify->addAttachments($attachments);

            Notification::route('mail', $recipient)
                // ->locale('it')
                ->notify($notify);

            $success = true;
        } catch (Exception $e) {
            $success = false;
            $error = $e->getMessage();

            // Re-throw per gestione errore a livello superiore
            throw $e;
        } finally {
            // ⭐ ACTIVITY LOG: Traccia SEMPRE (success o failure)
            app(LogSchedaEmailSentAction::class)->execute(
                scheda: $record,
                recipient: $recipient,
                template: $template,
                pdfFilename: $filename,
                pdfSizeBytes: strlen($pdfContent),
                success: $success,
                error: $error,
            );
        }

        return $success;
    }
}
```

---

### STEP 3: Test

**File:** `Modules/Ptv/tests/Feature/Actions/Activity/LogSchedaEmailSentActionTest.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Feature\Actions\Activity;

use Modules\Activity\Models\Activity;
use Modules\Ptv\Actions\Activity\LogSchedaEmailSentAction;
use Modules\Ptv\Models\Scheda;
use Modules\User\Models\User;
use Tests\TestCase;

class LogSchedaEmailSentActionTest extends TestCase
{
    /** @test */
    public function it_logs_successful_email_sent(): void
    {
        // Arrange
        $user = User::factory()->create();
        $scheda = Scheda::factory()->create([
            'matr' => 'ABC123',
            'cognome' => 'Rossi',
            'nome' => 'Mario',
            'anno' => 2024,
        ]);

        $this->actingAs($user);

        // Act
        $activity = app(LogSchedaEmailSentAction::class)->execute(
            scheda: $scheda,
            recipient: 'test@example.com',
            template: 'schede',
            pdfFilename: 'scheda_1.pdf',
            pdfSizeBytes: 50000,
            success: true,
            error: null,
        );

        // Assert
        $this->assertInstanceOf(Activity::class, $activity);
        $this->assertEquals('Modules\Ptv\Models\Scheda', $activity->subject_type);
        $this->assertEquals($scheda->id, $activity->subject_id);
        $this->assertEquals($user->id, $activity->causer_id);

        // Verifica properties
        $properties = $activity->properties;
        $this->assertEquals('ABC123', $properties['scheda']['matr']);
        $this->assertEquals('test@example.com', $properties['email']['recipient']);
        $this->assertEquals('schede', $properties['email']['template']);
        $this->assertTrue($properties['result']['success']);
        $this->assertNull($properties['result']['error']);
    }

    /** @test */
    public function it_logs_failed_email_sent(): void
    {
        // Arrange
        $user = User::factory()->create();
        $scheda = Scheda::factory()->create();
        $this->actingAs($user);

        // Act
        $activity = app(LogSchedaEmailSentAction::class)->execute(
            scheda: $scheda,
            recipient: 'invalid@example.com',
            template: 'schede',
            pdfFilename: 'scheda_1.pdf',
            pdfSizeBytes: 50000,
            success: false,
            error: 'SMTP connection failed',
        );

        // Assert
        $this->assertFalse($activity->properties['result']['success']);
        $this->assertEquals('SMTP connection failed', $activity->properties['result']['error']);
        $this->assertStringContains('fallito', $activity->description);
    }

    /** @test */
    public function it_extracts_scheda_data_safely(): void
    {
        // Arrange
        $scheda = Scheda::factory()->create([
            'matr' => 'TEST123',
            'cognome' => 'Test',
            'nome' => 'User',
            'stabi' => 5,
        ]);
        $this->actingAs(User::factory()->create());

        // Act
        $activity = app(LogSchedaEmailSentAction::class)->execute(
            scheda: $scheda,
            recipient: 'test@example.com',
            template: 'schede',
            pdfFilename: 'test.pdf',
            pdfSizeBytes: 1000,
        );

        // Assert - Verifica NO accessor triggerati
        $schedaData = $activity->properties['scheda'];
        $this->assertEquals('TEST123', $schedaData['matr']);
        $this->assertEquals(5, $schedaData['stabi']);
    }
}
```

---

### STEP 4: Documentazione Activity Module

**File:** `Modules/Activity/docs/use-cases/tracking-email-sent.md`

```markdown
# Use Case: Tracking Email Sent

## Overview

Pattern generico per tracciare invio email con allegati e metadati completi.

## Implementazione Reference

**Modulo:** Ptv  
**Action:** `LogSchedaEmailSentAction`  
**File:** `Modules/Ptv/app/Actions/Activity/LogSchedaEmailSentAction.php`

## Pattern Generale

\`\`\`php
// 1. Crea action dedicata per il tuo caso d'uso
class LogMyEmailSentAction
{
    use QueueableAction;

    public function execute(
        Model $record,
        string $recipient,
        string $template,
        bool $success,
        ?string $error = null
    ): Activity {
        return activity()
            ->performedOn($record)
            ->causedBy(auth()->user())
            ->withProperties([
                'recipient' => $recipient,
                'template' => $template,
                'success' => $success,
                'error' => $error,
            ])
            ->log($success ? 'Email sent' : 'Email failed');
    }
}

// 2. Usa in try/finally per tracciare SEMPRE
try {
    // Invio email
    $success = true;
} catch (Exception $e) {
    $success = false;
    $error = $e->getMessage();
} finally {
    app(LogMyEmailSentAction::class)->execute(...);
}
\`\`\`

## Dati Raccomandati

- Identificatori record
- Destinatario email
- Template utilizzato
- Allegati info (nomi, dimensioni)
- Success/failure flag
- Error message (se fallito)
- Timestamp invio
- User che ha inviato
- IP address
- User agent

## Collegamenti

- [Ptv Implementation](../../../Ptv/docs/activity-log-email-tracking-implementation.md)
- [Activity Logger](../../app/Actions/ActivityLogger.php)
```

---

## 📊 Database Schema

### Activity Log Record Example

```json
{
    "id": 12345,
    "log_name": "scheda_email",
    "description": "Email scheda valutazione inviata con successo",
    "subject_type": "Modules\\Ptv\\Models\\Scheda",
    "subject_id": 123,
    "causer_type": "Modules\\User\\Models\\User",
    "causer_id": 456,
    "event": "email_sent",
    "batch_uuid": null,
    "properties": {
        "scheda": {
            "id": 123,
            "anno": 2024,
            "matr": "ABC123",
            "cognome": "Rossi",
            "nome": "Mario",
            "valutatore_id": 789,
            "valutatore_nome": "Dott. Bianchi",
            "stabi": 5,
            "coordinamento": 10,
            "responsabilita": 15,
            "gg_anno": 365
        },
        "email": {
            "recipient": "mario.rossi@example.com",
            "template": "schede",
            "pdf_filename": "scheda_123_ABC123_Rossi_Mario.pdf",
            "pdf_size_bytes": 240128,
            "pdf_size_kb": 234.5,
            "sent_at": "2025-01-22 14:30:00",
            "sent_by_user_id": 456,
            "sent_by_user_name": "Admin User",
            "ip_address": "192.168.1.100",
            "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)..."
        },
        "result": {
            "success": true,
            "error": null
        }
    },
    "created_at": "2025-01-22 14:30:00",
    "updated_at": "2025-01-22 14:30:00"
}
```

---

## 🔍 Query Audit Trail

### Recuperare Tutte le Email Inviate per una Scheda

```php
use Modules\Activity\Models\Activity;

$scheda = Scheda::find(123);

$emailLogs = Activity::forSubject($scheda)
    ->where('log_name', 'scheda_email')
    ->orderByDesc('created_at')
    ->get();

foreach ($emailLogs as $log) {
    echo sprintf(
        "%s - Inviata a %s da %s - %s\n",
        $log->created_at->format('d/m/Y H:i'),
        $log->properties['email']['recipient'],
        $log->properties['email']['sent_by_user_name'],
        $log->properties['result']['success'] ? '✅ Success' : '❌ Failed'
    );
}
```

### Success Rate Invii

```php
$totalSent = Activity::where('log_name', 'scheda_email')->count();
$successSent = Activity::where('log_name', 'scheda_email')
    ->whereJsonContains('properties->result->success', true)
    ->count();

$successRate = round(($successSent / $totalSent) * 100, 2);
echo "Success Rate: {$successRate}%\n";
```

### Email Inviate Oggi

```php
$today = Activity::where('log_name', 'scheda_email')
    ->whereDate('created_at', today())
    ->count();

echo "Email inviate oggi: {$today}\n";
```

---

## 🎨 Filament Integration (Opzionale)

### Visualizzare Activity Log in Scheda Resource

```php
// Modules/Ptv/Filament/Resources/SchedaResource.php

use Modules\Activity\Filament\Actions\ListLogActivitiesAction;

protected function getTableActions(): array
{
    return [
        // ... altre actions
        
        ListLogActivitiesAction::make(),  // ⭐ Cronologia completa
    ];
}
```

### Widget Email Stats

```php
// Modules/Ptv/Filament/Widgets/EmailStatsWidget.php

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Modules\Activity\Models\Activity;

class EmailStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSent = Activity::where('log_name', 'scheda_email')->count();
        $sentToday = Activity::where('log_name', 'scheda_email')
            ->whereDate('created_at', today())
            ->count();
        $successRate = Activity::where('log_name', 'scheda_email')
            ->whereJsonContains('properties->result->success', true)
            ->count() / max($totalSent, 1) * 100;

        return [
            Stat::make('Email Inviate Totali', $totalSent),
            Stat::make('Email Inviate Oggi', $sentToday),
            Stat::make('Success Rate', number_format($successRate, 1).'%')
                ->color($successRate > 95 ? 'success' : 'warning'),
        ];
    }
}
```

---

## ⚡ Performance Considerations

### Impatto su Performance

**Before (senza activity log):**
- Tempo invio: ~500ms

**After (con activity log):**
- Tempo invio: ~550ms (+10%)
- DB write: +1 INSERT activity_log

**Mitigazioni:**

1. **Queue Activity Log** (per bulk invii):
   ```php
   app(LogSchedaEmailSentAction::class)
       ->onQueue('activity-logs')
       ->execute(...);
   ```

2. **Batch UUID** (per invii multipli):
   ```php
   $batchUuid = (string) Str::uuid();
   
   foreach ($schedeToBulkSend as $scheda) {
       // ... invio email
       
       activity()
           ->inLog('scheda_email')
           ->withBatch($batchUuid)
           ->performedOn($scheda)
           // ... properties
           ->log('Bulk email sent');
   }
   ```

---

## 🔐 Privacy e GDPR

### Dati Personali Tracciati

**Dati scheda:**
- `matr` - Matricola dipendente
- `cognome` - Cognome dipendente
- `nome` - Nome dipendente

**Dati email:**
- `recipient` - Email destinatario
- `ip_address` - IP mittente
- `user_agent` - Browser mittente

### Compliance

✅ **GDPR Article 5.2** - Accountability  
   Activity log fornisce tracciabilità trattamento dati

✅ **GDPR Article 30** - Records of processing  
   Registro completo attività di trattamento

✅ **GDPR Article 32** - Security of processing  
   Audit trail per security monitoring

### Retention Policy

```php
// config/activitylog.php

return [
    'delete_records_older_than_days' => 365 * 7,  // 7 anni (normativa PA)
];
```

---

## 🔗 Collegamenti

### Documentazione Ptv
- [Analisi Filosofica](./activity-log-email-tracking-philosophical-analysis.md) - Il litigio feroce
- [PDF Email Complete Guide](./pdf-email-attachments-complete-guide.md) - Sistema PDF/Email
- [SendMailByRecord Source](../../app/Actions/Scheda/SendMailByRecord.php) - Codice corrente

### Documentazione Activity
- [Activity Module README](../../../Activity/docs/README.md)
- [LogActivityAction](../../../Activity/app/Actions/LogActivityAction.php)
- [Use Cases](../../../Activity/docs/use-cases/)

### Documentazione Xot
- [Actions Pattern](../../../Xot/docs/actions-pattern.md)
- [QueueableActions](../../../Xot/docs/development/queueable-actions.md)

---

**Ultimo Aggiornamento:** 2025-01-22  
**Versione:** 1.0  
**Stato:** 📝 Pronto per implementazione  
**PHPStan Level:** 10 (target)

