# ModelWithAuthorContract

Il `ModelWithAuthorContract` è un'interfaccia che estende `ModelContract` e definisce il contratto per i modelli che necessitano di tracciare l'autore e l'editor delle modifiche.

## Firma aggiornata (2025-04-16)

```php
interface ModelWithAuthorContract extends ModelContract
{
    public function getCreatedBy(): ?string;
    public function getUpdatedBy(): ?string;
    public function setCreatedBy(?string $userId): self;
    public function setUpdatedBy(?string $userId): self;
    public function author(): BelongsTo;
    public function editor(): BelongsTo;
}
```

## Best Practices
- Utilizzare sempre type hints e PHPDoc completi.
- Garantire la compatibilità con PHPStan livello 9.
- Implementare la logica di tracciamento utente in ogni modello che estende questo contract.

## Fix/Modifiche recenti
- [2025-04-16] Correzione conflitti git, uniformazione tipizzazione, aggiunta firme metodi autore/editor, aggiornamento PHPDoc e struttura secondo convenzioni Laraxot/<nome progetto>.
- Link bidirezionale: [Vai a PHPSTAN-FIXES-SUMMARY.md](../../../project_docs/PHPSTAN-FIXES-SUMMARY.md)

## Collegamenti
- [ModelContract](model-contract.md)
- [Database Guidelines](../DATABASE-GUIDELINES.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Contracts Overview](./README.md)
- [Documentazione root](../../../project_docs/PHPSTAN-FIXES-SUMMARY.md)

    $table->foreign('deleter_id')->references('id')->on('users');
});
```

## Best Practices

1. **Implementazione**
   - Utilizzare il trait `HasAuthorTrait` per implementazione standard
   - Definire le relazioni con il modello User
   - Gestire correttamente i casi null

2. **Validazione**
   - Verificare l'esistenza degli utenti referenziati
   - Gestire i casi di utenti eliminati
   - Validare i permessi di modifica

3. **Performance**
   - Utilizzare eager loading per le relazioni
   - Indicizzare le colonne foreign key
   - Ottimizzare le query di join

## Dipendenze

- Illuminate\Database\Eloquent\Relations\BelongsTo
- Illuminate\Database\Eloquent\Model
- Modules\User\Models\User

## Esempio di Utilizzo

```php
class Article extends Model implements ModelWithAuthorContract
{
    use HasAuthorTrait;

    protected $fillable = [
        'title',
        'content',
        'author_id',
        'updater_id',
        'deleter_id'
    ];
}
```

## Note di Sviluppo

- Implementare sempre tutte le relazioni richieste
- Gestire correttamente i casi di soft delete
- Mantenere la consistenza dei dati nelle relazioni
- Documentare eventuali personalizzazioni 