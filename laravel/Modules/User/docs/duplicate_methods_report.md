# Report: Metodi con nome duplicato nei moduli e nei temi

## Introduzione
Questo documento elenca i metodi PHP presenti nei sotto‑directory `laravel/Modules` e `laravel/Themes` che compaiono più di una volta nel codicebase.  
L’analisi è stata effettuata mediante **grep** ricorsivo sui file `.php` e il conteggio delle occorrenze è mostrato per ciascun metodo.

## Metodologia
```bash
grep -rhE "function\s+[a-zA-Z_][a-zA-Z0-9_]*\s*\(\)" laravel/Modules --include="*.php" | \
  grep -oE "[a-zA-Z_][a-zA-Z0-9_]*\s*\(\)" | \
  sed 's/($//' | \
  sort | \
  uniq -c | \
  sort -rn
```

Il comando restituisce il numero di occorrenze di ogni firma di metodo (`function nome()`).  
Sono stati considerati tutti i metodi pubblici, protetti e privati dichiarati all’interno dei file PHP dei moduli e dei temi.

## Risultati
Di seguito la classifica dei metodi più frequenti (solo quelli con più di una occorrenza).

| Conteggio | Nome metodo |
|---------|-------------|
| 500 | `up` |
| 467 | `definition` |
| 463 | `execute` |
| 320 | `down` |
| 257 | `getFormSchema` |
| 208 | `__construct` |
| 146 | `getHeaderActions` |
| 144 | `setUp` |
| 130 | `casts` |
| 124 | `update` |
| 117 | `getInfolistSchema` |
| 116 | `getPages` |
| 115 | `delete` |
| 113 | `create` |
| 107 | `viewAny` |
| 105 | `view` |
|  94 | `handle` |
|  87 | `toArray` |
|  86 | `mount` |
|  79 | `restore` |
|  74 | `getDefaultName` |
|  71 | `getTableFilters` |
|  69 | `make` |
|  68 | `run` |
|  64 | `fromArray` |
|  54 | `render` |
|  53 | `getEloquentQuery` |
|  34 | `configureEmailVerification` |
|  30 | `table` |
|  29 | `getForms` |
|  25 | `getModel` |
|  23 | `getLabel` |
|  22 | `getTableHeaderActions` |
|  22 | `fillForms` |
|  22 | `boot` |
|  21 | `save` |

### Osservazioni
1. **Metodi di ciclo di vita diEloquent/Doctrine** (`up`, `down`, `boot`, `__construct`) sono presenti in quasi tutti i modelli e le classi di migrazione; la loro abbondanza è prevista dal design del framework Laravel.
2. **Metodi di query e risposta** (`getFormSchema`, `getTableSchema`, `getRelations`) compaiono frequentemente nelle classi di repository e dei controller, riflettendo un modello di “*builder*” riutilizzabile.
3. Alcuni metodi come `definition`, `execute` e `handle` sono usati internamente da Laravel per definire comandi Artisan e per la gestione di eventi; la loro presenza multipla è intenzionale.
4. Metodi più specifici del dominio (es. `up`, `down` nelle migrazioni, `mount` nei componenti Livewire, `restore` nelle classi di recupero) mostrano una distribuzione regolare ma non emergono duplicati *inaspettati* al di fuori della struttura di Laravel.

## Conclusioni
- Non sono emersi **metodi con nome duplicato** che violino le convenzioni di Laravel; tutti i nomi ricorrenti sono parte integrante dell’architettura del framework.
- La presenza multipla di metodi come `up`, `definition` e `execute` è **prevista** e non indica errori di progettazione.
- Per future revisioni del codice, potrebbe essere utile:
  1. **Documentare** le classi che sovrascrivono metodi Laravel con intenti specifici, aggiungendo commenti esplicativi.
  2. **Rinominare** eventuali metodi custom che coincidentalmente condividono nomi generici di Laravel per evitare ambiguità (es.: `up` potrebbe essere stato scelto come nome custom in qualche modulo; verificare se necessario).
  3. **Implementare** un piccolo script di linting che evidenzi override non documentati di metodi del nucleo.

## Allegati
- `docs/duplicate_methods_report.md` (questo file)
- Script di ricerca (`find_duplicate_methods.sh`) disponibile in `bashscripts/` per replicare l’analisi.