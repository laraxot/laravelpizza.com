# LogEmailSentAction

## 📋 Descrizione

Action per registrare activity log di invio email riuscito per schede di valutazione.

**Path**: `Modules/Ptv/app/Actions/Scheda/LogEmailSentAction.php`

## 🎯 Scopo

Centralizzare la logica di logging per invii email riusciti, garantendo:
- Coerenza nel formato dei log
- Dati completi per audit trail
- Riutilizzabilità in contesti diversi

## 📝 Utilizzo

```php
use Modules\Ptv\Actions\Scheda\LogEmailSentAction;

app(LogEmailSentAction::class)
    ->execute(
        $record,           // SchedaContract
        $user,             // User che invia
        $template,         // Template email (es: 'schede')
        $recipient,        // Destinatario email
        $filename,         // Nome file PDF allegato
        $pdfContent        // Contenuto PDF binario (per dimensione)
    );
```

## 📊 Dati Registrati in Activity Log

```php
[
    'template' => 'schede',
    'recipient' => 'user@example.com',
    'filename' => 'scheda_123_456_Rossi_Mario.pdf',
    'evaluation_data' => [
        'matr' => '12345',
        'cognome' => 'Rossi',
        'nome' => 'Mario',
        // ... altri dati valutazione
    ],
    'pdf_size' => 123456,  // Byte
]
```

## 🔍 Logica Implementazione

1. Verifica che il record sia un `Model` (per `performedOn()`)
2. Chiama `PrepareEvaluationDataAction` per estrarre dati valutazione
3. Registra activity log con Spatie Activity Log
4. Includere tutti i metadati necessari per audit trail

## ✅ Vantaggi

- **Separazione Responsabilità** - Logica logging isolata
- **Riutilizzabile** - Usabile in qualsiasi contesto di invio email
- **DRY** - Evita duplicazione codice logging
- **Testabile** - Facile da testare in isolamento
- **Queueable** - Può essere accodata se necessario

## 🔗 Collegamenti

- [Email Sending Activity Log](./email-sending-activity-log.md)
- [PrepareEvaluationDataAction](./prepare-evaluation-data-action.md)
- [LogEmailErrorAction](./log-email-error-action.md)
- [SendMailByRecord Action](../app/Actions/Scheda/SendMailByRecord.php)

