# ErrorFormatterContract

## Descrizione
Questa interfaccia definisce il contratto per i formattatori di errori nel sistema Laraxot.

## Struttura
```php
interface ErrorFormatterContract
{
    public function __construct(\Throwable $exception);

    /**
     * @return array<string, mixed>
     */
    public function format(): array;
}
```

## Funzionalità
1. Definizione del contratto per la formattazione degli errori
2. Standardizzazione dell'output degli errori
3. Supporto per:
   - Formattazione consistente
   - Gestione eccezioni
   - Metadati personalizzati

## Implementazioni
- `WebhookErrorFormatter`: Formatta gli errori per l'invio tramite webhook
- Altri formattatori personalizzati

## Best Practices
1. Utilizzo di strict types
2. Documentazione PHPDoc completa
3. Supporto per PHPStan livello 9
4. Conforme alle convenzioni Laraxot/<nome progetto>

## Collegamenti
- [Error Handling Guidelines](../exception-handling-guide.md)
- [Error Formatters](../exceptions/formatters/readme.md)
- [PHPStan Level 9 Guide](../phpstan-level9-guide.md)
