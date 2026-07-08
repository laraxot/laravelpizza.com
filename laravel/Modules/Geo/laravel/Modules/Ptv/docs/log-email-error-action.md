# LogEmailErrorAction

## 📋 Descrizione

Action per registrare activity log di errore invio email per schede di valutazione.

**Path**: `Modules/Ptv/app/Actions/Scheda/LogEmailErrorAction.php`

## 🎯 Scopo

Centralizzare la logica di logging per errori di invio email, garantendo:
- Tracciamento completo degli errori
- Dati completi per debugging
- Riutilizzabilità in contesti diversi

## 📝 Utilizzo

```php
use Modules\Ptv\Actions\Scheda\LogEmailErrorAction;

try {
    // Invio email...
} catch (Exception $e) {
    app(LogEmailErrorAction::class)
        ->execute(
            $record,           // SchedaContract
            $user,             // User che ha tentato l'invio
            $template,         // Template email (es: 'schede')
            $recipient,        // Destinatario email
            $filename,         // Nome file PDF allegato
            $pdfContent,       // Contenuto PDF binario (per dimensione)
            $e                 // Exception catturata
        );
    
    throw $e; // Rilancia dopo logging
}
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
    'error' => 'Error message',
    'error_class' => 'Illuminate\\Mail\\Exceptions\\MailException',
]
```

## 🔍 Logica Implementazione

1. Verifica che il record sia un `Model` (per `performedOn()`)
2. Chiama `PrepareEvaluationDataAction` per estrarre dati valutazione
3. Registra activity log con Spatie Activity Log
4. Include dettagli errore (messaggio e classe) per debugging

## ✅ Vantaggi

- **Separazione Responsabilità** - Logica logging errori isolata
- **Riutilizzabile** - Usabile in qualsiasi contesto di gestione errori
- **DRY** - Evita duplicazione codice logging
- **Testabile** - Facile da testare in isolamento
- **Queueable** - Può essere accodata se necessario
- **Debugging** - Include dettagli errore completi

## 🔗 Collegamenti

- [Email Sending Activity Log](./email-sending-activity-log.md)
- [PrepareEvaluationDataAction](./prepare-evaluation-data-action.md)
- [LogEmailSentAction](./log-email-sent-action.md)
- [SendMailByRecord Action](../app/Actions/Scheda/SendMailByRecord.php)

