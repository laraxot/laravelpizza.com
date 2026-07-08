# PHPStan level-max: percorso verso zero errori su tutto Modules/

Stato reale al 2026-07-03, misurato con:
`./vendor/bin/phpstan analyse Modules --memory-limit=-1 --error-format=json`

## Inventario totale (baseline)

1891 errori su 693 file, 17 moduli. Non e' un obiettivo raggiungibile in una sola sessione:
richiede giudizio ingegneristico per-caso (non e' scriptabile in massa), non solo type hint meccanici.

| Modulo | Errori | Note |
|---|---|---|
| Xot | 465 | dipendenza di quasi tutti gli altri moduli: priorita' alta |
| Notify | 295 | |
| User | 258 | |
| Geo | 200 | |
| Blog | 199 | |
| Employee | 83 | |
| UI | 77 (era 92, poi bloccato da 20 file con syntax error) | vedi sotto |
| Cms | 72 | |
| Lang | 68 | |
| Tenant | 43 | |
| TechPlanner | 42 | |
| Comment | 38 | |
| Rating | 25 | |
| Gdpr | 19 | |
| Activity | 4 -> 1 | fixato (vedi sotto) |
| Media | 2 -> 0 | fixato |
| Job | 1 -> 0 | fixato |

Distribuzione per categoria (top):
- 858 `missingType.iterableValue` — richiede di leggere ogni metodo/proprieta' e capire cosa contiene l'array, non automatizzabile in blocco
- 657 `missingType.generics` — molti risolvibili con pattern ripetuti (Factory, Collection, Builder, Relation) una volta capito il modello coinvolto
- 239 `larastan.noEnvCallsOutsideOfConfig` — spostare `env()` fuori dai file non-config verso `config()`, verificando che la chiave esista nel config file corrispondente
- resto (~140) sparso su piu' identificatori, da trattare caso per caso

## Regole vincolanti (da CLAUDE.md/phpstan.neon)

- **Non modificare `phpstan.neon`**, non aggiungere `ignoreErrors`/baseline/`@phpstan-ignore`.
- Nessun cast o `@var` inline solo per zittire l'errore: va risolto il tipo reale.
- Se un test si aspetta qualcosa che non esiste, si corregge il TEST, non si inventa codice di produzione.
- Protocollo lock: prima di editare `path/File.php`, verificare `path/File.php.lock`. Se esiste, saltare il file (altro processo al lavoro). Se non esiste, crearlo, editare, verificare con phpstan (+ pint, + pest se pertinente), poi cancellarlo.

## Root cause fix gia' applicati (alto leverage, bassi file singoli)

1. **`Modules/Xot/app/Models/Traits/HasXotFactory.php`** — il trait non era dichiarato generico (`@template TFactory of Factory`), causando `generics.notGeneric` ovunque un model facesse `@use HasXotFactory<XFactory>`. Un fix, 6 file puliti (Activity::Activity/Snapshot/StoredEvent, Job::Task, Media::Media/TemporaryUpload).
2. **`Modules/Xot/app/Contracts/HasRecursiveRelationshipsContract.php`** — 23 errori `missingType.generics` sulle relation di Staudenmeir AdjacencyList (Ancestors, Descendants, Siblings, ecc.) senza generics. Risolto tipizzando tutte le return type con `<Model, Model>` (l'interfaccia e' generica per costruzione, implementata da modelli diversi via `@phpstan-require-extends Model`; `static` non funziona qui perche' un'interfaccia non e' un subtype di Model per PHPStan). Verificare che gli implementor (`BaseTreeModel`, `XotBaseTreeModel`, `TypedHasRecursiveRelationships`, `Cms\Menu`, ecc.) restino puliti dopo ogni modifica correlata.

## Modulo UI (fuori da questo file, gia' trattato in sessione precedente)

20 file avevano syntax error puri (refactor troncati: firme di metodo mancanti, closure non chiuse). Tutti ricostruiti e verificati a zero errori phpstan. Rimangono i restanti ~77 errori level-max "normali" del modulo UI, stessa natura di quelli sopra.

## Aggiornamento sessione 2026-07-03 (seconda parte)

Xot: 465 -> 147 errori. Vedi `docs/chat/phpstan-zero-errors.md` (root del progetto) per il log
dettagliato di coordinamento multi-agente e i fix applicati in questa sessione (ExtraContract,
CollectionExport, LazyCollectionExport). Issue GitHub di tracking:
https://github.com/laraxot/base_techplanner_fila5/issues/34

## Come continuare

Lavorare modulo per modulo partendo da Xot (e' una dipendenza), file per file in ordine di errori decrescenti, seguendo il protocollo lock. Ogni fix va verificato singolarmente con:

```
php -l <file>
./vendor/bin/phpstan analyse <file> --memory-limit=-1 --error-format=table
./vendor/bin/pint <file>
```

php-md non e' installato in vendor/bin nonostante `phpmd.xml` esista — non e' un gate disponibile finche' non viene aggiunto a composer.json (richiede approvazione utente per nuova dipendenza). phpinsights e' disponibile (`vendor/bin/phpinsights`).
