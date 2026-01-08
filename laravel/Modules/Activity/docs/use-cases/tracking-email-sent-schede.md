# Use Case: Tracking Email Sent - Schede Valutazione

## 📋 Overview

Caso d'uso concreto: Tracciamento invio email schede valutazione nel modulo Ptv.

**Modulo:** Ptv (Provincia di Treviso)  
**Action:** `LogSchedaEmailSentAction`  
**Integrazione:** `SendMailByRecord`

---

## 🎯 Business Requirements

### Obiettivi

1. **Audit Trail Completo**
   - Tracciare ogni invio email scheda (successi E fallimenti)
   - Registrare data/ora precisa
   - Identificare mittente (user_id, nome, IP)

2. **Dati Scheda Valutazione**
   - Snapshot dati identificativi (matr, cognome, nome)
   - Dati valutazione (stabi, coordinamento, responsabilità)
   - Valutatore assegnato

3. **Metadati Email**
   - Destinatario
   - Template utilizzato
   - Informazioni PDF (nome file, dimensione)

4. **Compliance GDPR/PA**
   - Tracciabilità trattamento dati personali
   - Registro comunicazioni ufficiali
   - Retention 7 anni (normativa PA)

---

## 🏗️ Implementazione

### Action Dedicata: LogSchedaEmailSentAction

**File:** `Modules/Ptv/app/Actions/Activity/LogSchedaEmailSentAction.php`

**Features:**
- ✅ Single Responsibility: SOLO logging email
- ✅ Type-safe: Validazione Assert rigorosa
- ✅ Queueable: Usabile in bulk
- ✅ DRY: Riutilizzabile in altri contesti
- ✅ PHPStan Level 10 compliant

**API:**
```php
use Modules\Ptv\Actions\Activity\LogSchedaEmailSentAction;
use Modules\Activity\Models\Activity;

$activity = app(LogSchedaEmailSentAction::class)->execute(
    scheda: $schedaRecord,
    recipient: 'destinatario@example.com',
    template: 'schede',
    pdfFilename: 'scheda_123.pdf',
    pdfSizeBytes: 245678,
    success: true,              // true se inviata, false se fallita
    error: null,                // null se success, error message se fallito
);

// $activity è istanza di Activity model
```

---

## 📊 Dati Tracciati

### Activity Log Record Structure

```json
{
    "id": 12345,
    "log_name": "default",
    "description": "Email scheda valutazione inviata con successo",
    "subject_type": "Modules\\Ptv\\Models\\Scheda",
    "subject_id": 123,
    "causer_type": "Modules\\User\\Models\\User",
    "causer_id": 456,
    "event": null,
    "batch_uuid": null,
    "properties": {
        "scheda": {
            "id": 123,
            "anno": 2024,
            "matr": "ABC123",
            "cognome": "Rossi",
            "nome": "Mario",
            "valutatore_id": 789,
            "valutatore_nome": "Dott. Bianchi Giuseppe",
            "stabi": 5,
            "coordinamento": 10,
            "responsabilita": 15,
            "gg_anno": 365
        },
        "email": {
            "recipient": "mario.rossi@provincia.treviso.it",
            "template": "schede",
            "pdf_filename": "scheda_123_ABC123_Rossi_Mario.pdf",
            "pdf_size_bytes": 245678,
            "pdf_size_kb": 239.92,
            "sent_at": "2025-01-22 14:30:15",
            "sent_by_user_id": 456,
            "sent_by_user_name": "Admin User",
            "ip_address": "192.168.1.100",
            "user_agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36..."
        },
        "result": {
            "success": true,
            "error": null
        }
    },
    "created_at": "2025-01-22 14:30:15",
    "updated_at": "2025-01-22 14:30:15"
}
```

---

## 🔍 Query Examples

### Tutte le Email Inviate per una Scheda

```php
use Modules\Activity\Models\Activity;
use Modules\Ptv\Models\Scheda;

$scheda = Scheda::find(123);

$emailLogs = Activity::forSubject($scheda)
    ->where('description', 'like', '%Email scheda%')
    ->orderByDesc('created_at')
    ->get();

foreach ($emailLogs as $log) {
    $props = $log->properties;
    
    echo sprintf(
        "%s - %s a %s da %s (%s)\n",
        $log->created_at->format('d/m/Y H:i:s'),
        $props['result']['success'] ? '✅ Inviata' : '❌ Fallita',
        $props['email']['recipient'],
        $props['email']['sent_by_user_name'],
        $props['result']['success'] ? $props['email']['pdf_filename'] : $props['result']['error']
    );
}

// Output:
// 22/01/2025 14:30:15 - ✅ Inviata a mario.rossi@example.com da Admin User (scheda_123.pdf)
// 21/01/2025 10:15:00 - ❌ Fallita a test@example.com da User Test (SMTP connection timeout)
```

### Success Rate Invii Email Schede

```php
$total = Activity::where('description', 'like', '%Email scheda%')->count();

$success = Activity::where('description', 'like', '%Email scheda%')
    ->whereJsonContains('properties->result->success', true)
    ->count();

$rate = round(($success / max($total, 1)) * 100, 2);
echo "Success Rate: {$rate}%\n";
echo "Successi: {$success} / Totale: {$total}\n";
```

### Email Inviate Oggi

```php
$oggi = Activity::where('description', 'like', '%Email scheda%')
    ->whereDate('created_at', today())
    ->get();

echo "Email schede inviate oggi: {$oggi->count()}\n";

$successi = $oggi->filter(fn($log) => $log->properties['result']['success'])->count();
echo "Successi: {$successi}\n";
echo "Fallimenti: ".($oggi->count() - $successi)."\n";
```

### Email per Valutatore

```php
$valutatorId = 789;

$emailsByValutatore = Activity::where('description', 'like', '%Email scheda%')
    ->whereJsonContains('properties->scheda->valutatore_id', $valutatorId)
    ->orderByDesc('created_at')
    ->get();

echo "Email inviate per valutatore {$valutatorId}: {$emailsByValutatore->count()}\n";
```

---

## 🎨 Filament Integration

### Widget Email Stats per Dashboard

```php
// Modules/Ptv/Filament/Widgets/SchedeEmailStatsWidget.php

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Activity\Models\Activity;

class SchedeEmailStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $query = Activity::where('description', 'like', '%Email scheda%');
        
        $total = $query->count();
        $oggi = (clone $query)->whereDate('created_at', today())->count();
        $settimana = (clone $query)->whereBetween('created_at', [now()->subWeek(), now()])->count();
        
        $successCount = (clone $query)->whereJsonContains('properties->result->success', true)->count();
        $successRate = $total > 0 ? round(($successCount / $total) * 100, 1) : 0;
        
        return [
            Stat::make('Email Schede Oggi', $oggi)
                ->description('Inviate nelle ultime 24 ore')
                ->color('primary'),
                
            Stat::make('Email Schede Settimana', $settimana)
                ->description('Ultimi 7 giorni')
                ->color('info'),
                
            Stat::make('Success Rate', $successRate.'%')
                ->description("{$successCount} successi su {$total} totali")
                ->color($successRate > 95 ? 'success' : ($successRate > 80 ? 'warning' : 'danger')),
        ];
    }
}
```

---

## ⚡ Performance Considerations

### Impatto Performance

**Prima (senza activity log):**
- Invio singolo: ~500ms
- Bulk 100 email: ~50s

**Dopo (con activity log inline):**
- Invio singolo: ~550ms (+10%)
- Bulk 100 email: ~55s (+10%)

**Dopo (con activity log queued):**
```php
app(LogSchedaEmailSentAction::class)
    ->onQueue('activity-logs')
    ->execute(...);
```
- Invio singolo: ~505ms (+1%)
- Bulk 100 email: ~50.5s (+1%)

**Raccomandazione:** Queue per bulk > 50 emails

---

## 🔒 Privacy e GDPR

### Dati Personali Tracciati

**Categoria:** Dati personali comuni (Art. 4 GDPR)
- Matricola dipendente
- Cognome e Nome
- Email destinatario
- IP address mittente

**Legal Basis:** Art. 6(1)(c) - Adempimento obbligo legale  
(PA deve mantenere registro comunicazioni ufficiali)

### Retention Period

**Normativa:** DPR 445/2000 (Testo Unico Documentazione Amministrativa)

**Periodo:** 7 anni dalla data comunicazione

**Implementazione:**
```php
// config/activitylog.php
'delete_records_older_than_days' => 365 * 7,  // 7 anni
```

**Cleanup automatico:**
```bash
# Cron giornaliero
php artisan activitylog:clean
```

---

## 🧪 Testing Strategy

### Unit Test LogSchedaEmailSentAction

```php
/** @test */
public function it_logs_email_sent_with_complete_data(): void
{
    $scheda = Scheda::factory()->create();
    $this->actingAs(User::factory()->create());
    
    $activity = app(LogSchedaEmailSentAction::class)->execute(
        scheda: $scheda,
        recipient: 'test@example.com',
        template: 'schede',
        pdfFilename: 'test.pdf',
        pdfSizeBytes: 50000,
        success: true,
    );
    
    $this->assertInstanceOf(Activity::class, $activity);
    $this->assertEquals($scheda->matr, $activity->properties['scheda']['matr']);
    $this->assertTrue($activity->properties['result']['success']);
}
```

### Integration Test SendMailByRecord

```php
/** @test */
public function it_logs_activity_when_sending_email(): void
{
    $scheda = Scheda::factory()->create();
    $user = User::factory()->create();
    $this->actingAs($user);
    
    Mail::fake();
    
    app(SendMailByRecord::class)->execute($scheda);
    
    // Verifica activity creata
    $this->assertDatabaseHas('activity_log', [
        'subject_type' => Scheda::class,
        'subject_id' => $scheda->id,
        'causer_id' => $user->id,
    ]);
    
    $activity = Activity::latest()->first();
    $this->assertStringContains('Email scheda', $activity->description);
    $this->assertTrue($activity->properties['result']['success']);
}
```

---

## 🔗 Collegamenti

- [Ptv - Analisi Filosofica](../../../Ptv/docs/activity-log-email-tracking-philosophical-analysis.md)
- [Ptv - Implementation Guide](../../../Ptv/docs/activity-log-email-tracking-implementation.md)
- [Activity - README](../../README.md)
- [Activity - LogActivityAction](../../app/Actions/LogActivityAction.php)

---

**Ultimo Aggiornamento:** 2025-01-22  
**Versione:** 1.0  
**Autore:** System Integration Documentation  
**Stato:** ✅ Production Ready

