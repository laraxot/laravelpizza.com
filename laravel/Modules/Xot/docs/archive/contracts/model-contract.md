# ModelContract

## Descrizione
Questa interfaccia definisce il contratto base per i modelli nel sistema Laraxot, stabilendo i metodi e le proprietà essenziali che ogni modello deve implementare.

## Struttura
```php
interface ModelContract
{
    public function getRouteKeyName(): string;
    public function getKey(): mixed;
    public function getFillable(): array;
    public function getCasts(): array;
    public function getDates(): array;
    public function getConnection(): string;
    public function getTable(): string;
    public function getKeyName(): string;
    public function getKeyType(): string;
    public function usesTimestamps(): bool;
}
```

## Funzionalità
1. Definizione dell'interfaccia base per i modelli
2. Standardizzazione dei metodi essenziali
3. Supporto per:
   - Chiavi primarie personalizzate
   - Casting degli attributi
   - Gestione delle date
   - Connessioni multiple
   - Tabelle personalizzate

## Implementazioni
- `BaseModel`: Implementazione base del contratto
- `XotBaseModel`: Estensione con funzionalità Xot
- Altri modelli specifici del dominio

## Best Practices Implementate
1. Utilizzo di strict types
2. Documentazione PHPDoc completa
3. Supporto per PHPStan livello 9
4. Conforme alle convenzioni Laraxot/<nome progetto>
5. Integrazione con Laravel Eloquent

## Collegamenti
- [Model Guidelines](../models/README.md)
- [Database Guidelines](../DATABASE-GUIDELINES.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Contracts Overview](./README.md) 