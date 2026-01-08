# HandlerDecorator

## Descrizione
Questa classe implementa il pattern Decorator per la gestione delle eccezioni in Laravel, fornendo funzionalità aggiuntive al gestore delle eccezioni predefinito.

## Struttura
```php
class HandlerDecorator implements ExceptionHandlerContract
{
    public function __construct(
        private readonly ExceptionHandlerContract $handler
    ) {}
}
```

## Funzionalità
1. Decorazione del gestore eccezioni standard di Laravel
2. Gestione personalizzata delle eccezioni
3. Supporto per:
   - Log dettagliati
   - Formattazione personalizzata
   - Notifiche
   - Webhook
4. Integrazione con sistemi di monitoraggio

## Best Practices Implementate
1. Utilizzo del pattern Decorator
2. Strict typing per type safety
3. Readonly properties per immutabilità
4. Gestione errori robusta
5. Supporto per PHPStan livello 9

## Metodi Principali
- `report`: Gestisce il reporting delle eccezioni
- `shouldReport`: Determina se un'eccezione deve essere riportata
- `render`: Renderizza la risposta per un'eccezione
- `renderForConsole`: Renderizza l'eccezione per l'output console

## Collegamenti
- [Exception Handling Guidelines](../EXCEPTION-HANDLING-GUIDE.md)
- [Logging Best Practices](../LOGGING-BEST-PRACTICES.md)
- [PHPStan Level 9 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Error Formatters](./formatters/README.md) 