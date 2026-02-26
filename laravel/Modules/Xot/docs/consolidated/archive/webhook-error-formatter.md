# WebhookErrorFormatter

## Descrizione
Questa classe formatta gli errori per l'invio tramite webhook, implementando le best practices di Laraxot per la gestione degli errori.

## Struttura
```php
class WebhookErrorFormatter implements ErrorFormatterContract
{
    public function format(\Throwable $e): array;
}
```

## Funzionalità
1. Formattazione standardizzata degli errori per webhook
2. Supporto per:
   - Stack trace dettagliato
   - Informazioni di contesto
   - Metadati personalizzati
   - Headers HTTP
3. Integrazione con sistemi di monitoraggio esterni

## Output Formattato
```json
{
    "error": {
        "message": "Descrizione dell'errore",
        "code": 500,
        "type": "Exception",
        "file": "path/to/file.php",
        "line": 123,
        "trace": [],
        "context": {},
        "metadata": {}
    }
}
```

## Best Practices Implementate
1. Utilizzo di strict types
2. Gestione sicura delle informazioni sensibili
3. Formattazione consistente
4. Supporto per PHPStan livello 9
5. Conforme alle convenzioni Laraxot/<nome progetto>

## Collegamenti
- [Error Handling Guidelines](../../EXCEPTION-HANDLING-GUIDE.md)
- [Webhook Integration](../../integrations/WEBHOOK-GUIDE.md)
- [PHPStan level 10 Guide](../../PHPSTAN-LEVEL9-GUIDE.md)
- [Error Formatters Overview](../README.md) 