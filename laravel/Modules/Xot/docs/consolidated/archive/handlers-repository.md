# HandlersRepository

## Descrizione
Questa classe gestisce il repository dei gestori di eccezioni nel sistema Laraxot, fornendo un meccanismo flessibile per registrare e recuperare handler personalizzati per diversi tipi di eccezioni.

## Struttura
```php
class HandlersRepository
{
    private array $reporters = [];
    private array $renderers = [];
    private array $consoleRenderers = [];

    public function addReporter(callable $reporter): int;
    public function addRenderer(callable $renderer): int;
    public function addConsoleRenderer(callable $renderer): int;
    public function getReportersByException(\Throwable $e): array;
    public function getRenderersByException(\Throwable $e): array;
    public function getConsoleRenderersByException(\Throwable $e): array;
}
```

## Funzionalità
1. Gestione centralizzata dei gestori di eccezioni
2. Supporto per:
   - Reporter personalizzati
   - Renderer per HTTP
   - Renderer per console
   - Filtri per tipo di eccezione
3. Integrazione con:
   - Sistema di logging
   - Notifiche
   - Webhook
   - Monitoring

## Metodi Principali

### Reporter
- `addReporter()`: Registra un nuovo reporter per le eccezioni
- `getReportersByException()`: Ottiene i reporter applicabili a una specifica eccezione

### Renderer HTTP
- `addRenderer()`: Registra un nuovo renderer per le risposte HTTP
- `getRenderersByException()`: Ottiene i renderer HTTP applicabili a una specifica eccezione

### Renderer Console
- `addConsoleRenderer()`: Registra un nuovo renderer per l'output console
- `getConsoleRenderersByException()`: Ottiene i renderer console applicabili a una specifica eccezione

## Best Practices Implementate
1. Utilizzo di strict types
2. Gestione efficiente delle collezioni di handler
3. Supporto per PHPStan livello 9
4. Pattern Repository
5. Dependency Injection

## Esempio di Utilizzo
```php
$repository = new HandlersRepository();

// Aggiunta di un reporter personalizzato
$repository->addReporter(function (\Throwable $e) {
    Log::error($e->getMessage());
});

// Aggiunta di un renderer HTTP
$repository->addRenderer(function (\Throwable $e) {
    return response()->json([
        'error' => $e->getMessage()
    ], 500);
});

// Aggiunta di un renderer console
$repository->addConsoleRenderer(function (\Throwable $e, $output) {
    $output->writeln("<error>{$e->getMessage()}</error>");
});
```

## Note di Sviluppo
- Registrare i handler all'avvio dell'applicazione
- Implementare filtri specifici per tipo di eccezione
- Mantenere l'ordine di priorità dei handler
- Gestire correttamente le eccezioni annidate

## Collegamenti
- [Exception Handling Guide](../EXCEPTION-HANDLING-GUIDE.md)
- [Error Formatters](../formatters/README.md)
- [PHPStan Level 9 Guide](../../PHPSTAN-LEVEL9-GUIDE.md)
- [Handlers Overview](./README.md) 