# ModelWithUserContract

## Descrizione
Questa interfaccia estende `ModelContract` aggiungendo funzionalità per la gestione delle relazioni con gli utenti nel sistema Laraxot.

## Struttura
```php
interface ModelWithUserContract extends ModelContract
{
    public function getUserId(): ?int;
    public function setUserId(?int $userId): self;
    public function user(): BelongsTo;
    public function hasUser(): bool;
    public function belongsToUser(int $userId): bool;
}
```

## Funzionalità
1. Gestione delle relazioni con gli utenti
2. Supporto per:
   - Proprietà degli elementi
   - Verifica appartenenza
   - Relazioni utente-elemento
   - Autorizzazioni basate su utente
3. Integrazione con:
   - Sistema di autenticazione
   - Gestione permessi
   - Policy e Gate

## Proprietà
- `user_id`: int|null - ID dell'utente proprietario
- `user`: UserContract|null - Relazione con l'utente proprietario
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
ALTER TABLE your_table ADD COLUMN user_id BIGINT UNSIGNED NULL;
ALTER TABLE your_table ADD FOREIGN KEY (user_id) REFERENCES users(id);
```

## Esempio di Utilizzo
```php
class Article extends Model implements ModelWithUserContract
{
    use HasUserTrait;

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];
}
```

## Note di Sviluppo
- Implementare sempre la relazione `user()`
- Gestire correttamente i casi di soft delete
- Mantenere la consistenza dei dati nelle relazioni
- Documentare eventuali personalizzazioni

## Collegamenti
- [ModelContract](model-contract.md)
- [User Management](../features/USER-MANAGEMENT.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Contracts Overview](./README.md) 