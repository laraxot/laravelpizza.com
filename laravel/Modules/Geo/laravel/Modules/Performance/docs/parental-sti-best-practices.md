# Parental STI (Single Table Inheritance) - Best Practices

In questo progetto utilizziamo il pacchetto [tighten/parental](https://github.com/tighten/parental) per gestire l'ereditarietà su singola tabella (STI).

## Come Funziona

Il pattern STI permette di mappare diverse classi (figli) su una singola tabella di database, utilizzando una colonna discriminante (solitamente `type`) per distinguere i tipi di record.

### 1. Il Modello Padre
Il modello padre deve utilizzare il trait `HasChildren` e definire la colonna discriminante e la mappatura dei figli.

```php
class Individuale extends Model
{
    use HasChildren;

    protected $childColumn = 'type';

    protected array $childTypes = [
        'po' => IndividualePo::class,
        'dip' => IndividualeDip::class,
        'regionale' => IndividualeRegionale::class,
    ];
}
```

### 2. I Modelli Figli
Ogni modello figlio deve estendere il padre e utilizzare il trait `HasParent`.

```php
class IndividualeRegionale extends Individuale
{
    use HasParent;
    
    // NON serve il metodo boot() con addGlobalScope!
}
```

## Regola d'Oro: No Global Scopes Manuali

**ERRORE COMUNE**: Aggiungere manualmente un global scope nel metodo `boot()` del figlio per filtrare il tipo.

```php
// ❌ SBAGLIATO - Ridondante
protected static function boot(): void
{
    parent::boot();
    static::addGlobalScope(fn($q) => $query->where('type', 'regionale'));
}
```

**PERCHÉ EVITARLO**: 
Il trait `HasParent` aggiunge **automaticamente** il global scope corretto. Aggiungerne uno manuale causa:
1.  **Query Duplicate**: SQL con `where type = ? and type = ?`.
2.  **Codice Inutile**: Maggiore manutenzione e rischio di errori di battitura.

## Vantaggi del Pattern Corretto
-   **Trasparenza**: `IndividualeRegionale::all()` restituisce solo i regionali automaticamente.
-   **Polimorfismo**: `Individuale::all()` restituisce una collezione di istanze delle classi figlie corrette basandosi sul valore della colonna `type`.
-   **Integrazione Filament**: Le risorse Filament che puntano ai modelli figli ereditano il filtraggio senza configurazioni extra.

---
**Riferimenti**:
- [Documento Canonico AI Agents](../../../../.agents/docs/parental-sti-best-practices.md) (Coming soon)
- [tighten/parental GitHub](https://github.com/tighten/parental)
