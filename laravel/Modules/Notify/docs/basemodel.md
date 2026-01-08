# BaseModel: Regola obbligatoria e motivazione

## Regola
**Tutti i model del modulo devono estendere BaseModel (già presente nel namespace), mai direttamente Model.**

## Motivazione
- Permette di centralizzare override, comportamenti comuni, trait, policy, logica multi-tenant e metodi utility.
- Migliora la manutenibilità: ogni modifica globale si fa in un solo punto.
- Evita errori e duplicazione di codice.
- Rende il codice più leggibile e conforme alle regole di progetto.

## Convenzione
- BaseModel deve essere già presente nel namespace (es: `Modules\Notify\Models\BaseModel`).
- Non serve alcun `use` per BaseModel nei model dello stesso namespace.
- Estendere direttamente Model è un errore bloccante e va evitato in tutte le PR.

## Esempio corretto
```php
namespace Modules\Notify\Models;

class NotificationTemplate extends BaseModel {}
```

## Collegamenti
- [../module_notify.md](../module_notify.md)
- [../../Patient/docs/basemodel.md](../../Patient/docs/basemodel.md)
- Regola "evita override inutili" nei prompt e docs root.

---
**Nota:** Se trovi un model che estende Model invece di BaseModel, correggi subito e segnala l’errore nella PR.
