# Pattern DRY: Composizione Actions Bulk → Single

**Data**: 2025-01-18  
**Modulo**: Notify  
**Status**: ✅ Pattern consolidato

## Principio Fondamentale

Le Actions bulk devono **sempre comporre** le Actions single invece di duplicare la logica di business.

## Filosofia

### DRY (Don't Repeat Yourself)

- **Un'Action per un singolo record**: Gestisce tutta la logica di business per un record
- **Un'Action per più record**: Orchestrazione che compone la single-action per ogni record
- **Zero duplicazione**: La logica di business esiste in un solo posto

### Single Responsibility

- **Single Action**: Responsabile solo dell'invio a un record
- **Bulk Action**: Responsabile solo dell'orchestrazione e aggregazione risultati

### KISS (Keep It Simple, Stupid)

- **Bulk Action semplice**: Solo loop e aggregazione
- **Logica complessa nella single**: Estrazione contatti, normalizzazione, gestione canali

## Pattern Corretto

### ✅ CORRETTO - Composizione DRY

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Database\Eloquent\Collection;
use Spatie\QueueableAction\QueueableAction;

class SendRecordsNotificationBulkAction
{
    use QueueableAction;

    public function execute(Collection $records, string $templateSlug, array $channels): SendNotificationBulkResultData
    {
        $successCount = 0;
        $errorCount = 0;
        $errors = collect();

        // ✅ Compone SendRecordNotificationAction per ogni record
        $singleRecordAction = app(SendRecordNotificationAction::class);

        foreach ($records as $record) {
            foreach ($channels as $channel) {
                try {
                    $success = $singleRecordAction->execute($record, $templateSlug, [$channel]);
                    if ($success) {
                        $successCount++;
                    } else {
                        // Gestione fallimento silenzioso
                        $errorCount++;
                    }
                } catch (Exception $e) {
                    // Gestione eccezioni
                    $errorCount++;
                }
            }
        }

        return new SendNotificationBulkResultData(...);
    }
}
```

### ❌ ERRATO - Duplicazione Logica

```php
<?php

class SendRecordsNotificationBulkAction
{
    use QueueableAction;

    public function execute(Collection $records, string $templateSlug, array $channels): SendNotificationBulkResultData
    {
        foreach ($records as $record) {
            foreach ($channels as $channel) {
                // ❌ Duplica logica di SendRecordNotificationAction
                $this->sendMail($record, $templateSlug); // Duplicato!
                $this->sendSms($record, $templateSlug);  // Duplicato!
                $this->sendWhatsApp($record, $templateSlug); // Duplicato!
            }
        }
    }

    // ❌ Metodi duplicati - stessa logica di SendRecordNotificationAction
    private function sendMail(...) { }
    private function sendSms(...) { }
    private function sendWhatsApp(...) { }
}
```

## Esempi dal Codebase

### SendMailByRecordsAction (Xot Module)

```php
class SendMailByRecordsAction
{
    use QueueableAction;

    public function execute(Collection $records, string $mail_class): bool
    {
        foreach ($records as $record) {
            // ✅ Compone SendMailByRecordAction
            app(SendMailByRecordAction::class)->execute($record, $mail_class);
        }
        
        return true;
    }
}
```

### SendRecordsNotificationBulkAction (Notify Module)

```php
class SendRecordsNotificationBulkAction
{
    use QueueableAction;

    public function execute(Collection $records, string $templateSlug, array $channels): SendNotificationBulkResultData
    {
        $singleRecordAction = app(SendRecordNotificationAction::class);

        foreach ($records as $record) {
            foreach ($channels as $channel) {
                // ✅ Compone SendRecordNotificationAction
                $singleRecordAction->execute($record, $templateSlug, [$channel]);
            }
        }
    }
}
```

## Vantaggi della Composizione

### 1. DRY - Zero Duplicazione
- Logica di business in un solo punto
- Modifiche in un solo file
- Meno codice da mantenere

### 2. Testabilità
- Testare single-action separatamente
- Bulk action testabile con mock della single
- Test più semplici e focalizzati

### 3. Manutenibilità
- Bug fix in un solo posto
- Miglioramenti immediatamente disponibili per bulk
- Codice più pulito e leggibile

### 4. Riutilizzabilità
- Single-action riutilizzabile in altri contesti
- Bulk action specifica per orchestrazione
- Composizione flessibile

### 5. Single Responsibility
- Single Action: "Invia notifica a un record"
- Bulk Action: "Orchestra invio a più record"

## Checklist Pre-Implementazione

Prima di creare una bulk action:

- [ ] Esiste già una single-action per un singolo record?
- [ ] La single-action gestisce tutti i casi necessari?
- [ ] Se sì, la bulk compone la single-action?
- [ ] Se no, estendo la single-action prima di creare la bulk?
- [ ] La bulk non duplica logica della single?

## Naming Convention

### Single Action (Singolo Record)
- `SendRecordNotificationAction` - invia a UN record
- `SendMailByRecordAction` - invia a UN record
- `UpdateCoordinatesAction` - aggiorna coordinate di record singoli

### Bulk Action (Più Record)
- `SendRecordsNotificationBulkAction` - invia a PIÙ record (plurale "Records")
- `SendMailByRecordsAction` - invia a PIÙ record (plurale "Records")
- `UpdateCoordinatesAction` - già gestisce collection, quindi OK

**Pattern**: Se la bulk itera su più record, il nome deve avere il plurale.

## Documentazione Correlata

- [Actions Calling Actions Pattern](./actions-calling-actions-pattern.md) - Pattern per chiamare Actions con `app()`
- [SendNotificationBulkAction](./send-notification-bulk-action.md) - Implementazione completa
- [Geo Module Architectural Philosophy](../Geo/docs/architectural-philosophy.md) - Filosofia architetturale modulare

---

**Filosofia**: "Una volta, una sola volta, in un solo posto" - DRY Principle  
**Pattern**: Bulk Action compone Single Action  
**Naming**: Bulk Action con plurale nel nome (Records, not Record)
