# ModelWithStatusContract

## Descrizione
Questa interfaccia estende `ModelContract` aggiungendo funzionalità per la gestione degli stati dei modelli nel sistema Laraxot, utilizzando il pacchetto Spatie Laravel Model Status.

## Struttura
```php
interface ModelWithStatusContract extends ModelContract
{
    public function getStatus(): ?string;
    public function setStatus(string $status, ?string $reason = null): self;
    public function hasStatus(string $status): bool;
    public function latestStatus(?string $status = null): ?Status;
    public function statuses(): MorphMany;
}
```

## Funzionalità
1. Gestione degli stati dei modelli
2. Supporto per:
   - Stati multipli
   - Storico degli stati
   - Motivi dei cambi di stato
   - Timestamp delle transizioni
3. Integrazione con:
   - Spatie Laravel Model Status
   - Sistema di audit
   - Notifiche di cambio stato

## Proprietà
- `status`: string|null - Stato corrente del modello
- `statuses`: Collection|Status[] - Collezione degli stati
- `created_at`: Carbon|null - Data e ora di creazione
- `updated_at`: Carbon|null - Data e ora dell'ultima modifica

## Best Practices Implementate
1. Utilizzo di strict types
2. Documentazione PHPDoc completa
3. Supporto per PHPStan livello 9
4. Conforme alle convenzioni Laraxot/<nome progetto>
5. Gestione null-safety

## Schema Database
```sql
CREATE TABLE model_statuses (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    status VARCHAR(255) NOT NULL,
    reason TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX model_statuses_model_type_model_id_index(model_type, model_id)
);
```

## Esempio di Utilizzo
```php
class Order extends Model implements ModelWithStatusContract
{
    use HasStatuses;

    public static array $statuses = [
        'draft',
        'pending',
        'processing',
        'completed',
        'cancelled'
    ];
}

// Utilizzo
$order->setStatus('processing', 'Order is being processed');
$order->hasStatus('completed'); // false
$latestStatus = $order->latestStatus();
```

## Note di Sviluppo
- Definire sempre gli stati validi come array statico
- Validare gli stati prima del cambio
- Gestire le transizioni di stato in modo atomico
- Documentare il flusso degli stati possibili

## Collegamenti
- [ModelContract](model-contract.md)
- [Status Management](../features/STATUS-MANAGEMENT.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Contracts Overview](./README.md) 