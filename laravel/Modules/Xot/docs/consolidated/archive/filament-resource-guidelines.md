# Linee Guida per le Risorse Filament nel Progetto <nome progetto>

## Regole Generali

1. **Estensione di XotBaseResource**: Tutte le risorse Filament devono estendere `Modules\Xot\Filament\Resources\XotBaseResource` invece di `Filament\Resources\Resource` per mantenere coerenza e centralizzare comportamenti comuni.
2. **Proprietà di Navigazione**: Le classi che estendono `XotBaseResource` non devono includere proprietà come `navigationIcon`, `navigationGroup`, `navigationSort` se non strettamente necessarie, poiché queste sono gestite dalla classe base.
3. **Metodi di Configurazione**: Non definire metodi come `getTableColumns()`, `getRelations()` o `getPages()` se restituiscono solo valori predefiniti o standard (ad esempio, `getPages()` con solo `index`, `create`, `edit`).
4. **Etichette e Traduzioni**: Non utilizzare `->label()` per le etichette dei componenti Filament. Utilizzare i file di traduzione del modulo in `Modules/<nome modulo>/lang/<lingua>` per gestire le etichette automaticamente tramite `LangServiceProvider`.

## Collegamenti Bidirezionali

- [Documentazione Principale sui Problemi di Namespace](../../../../project_docs/references/namespace-issues.md)
- [Documentazione del Modulo Patient](../Patient/project_docs/errors/undefined-type-pending.md)
- [Riferimento alle Linee Guida nel Modulo Patient](../Patient/project_docs/references/filament-guidelines-link.md)

## Note

Queste linee guida sono centrali per tutti i moduli del progetto <nome progetto>. Ogni modulo deve fare riferimento a questo documento per garantire coerenza nello sviluppo delle risorse Filament.
