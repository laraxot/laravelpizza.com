Fix verificato il 2026-03-09 sul dettaglio eventi.

Root cause reale:

- il route `/it/events/{slug}` arrivava correttamente al template `events.view`;
- il block `events/detail` restava in fallback `Nessun evento trovato` perche' `ResolvePageAction` non risolveva mai il modello dinamico;
- in `ResolvePageAction::queryModel()` c'era un check `method_exists($modelClass, 'where')`, ma `where()` sugli Eloquent model arriva via magic method, quindi il check falliva sempre.

Correzione applicata:

- `ResolvePageAction` ora usa `is_subclass_of(..., Model::class)` e `newQuery()->where('slug', ...)`;
- il Folio page `Themes/Meetup/resources/views/pages/[container0]/[slug0]/index.blade.php` risolve l'item una volta sola e lo passa a `x-page`;
- il block `events/detail.blade.php` non interroga piu' il DB nel percorso standard del dettaglio.

Verifiche eseguite:

- request Laravel interna su `/it/events/ut-quae-facere-placeat-labore-expedita-TwKN`: `200`
- il contenuto contiene il titolo evento atteso
- il contenuto non contiene piu `Nessun evento trovato`
- Pest verde:
  - `Modules/Cms/tests/Unit/Actions/ResolvePageActionTest.php`
  - `Modules/Meetup/tests/Feature/EventDetailPageTest.php`

Gate aggiuntivi:

- `phpstan` OK sui file PHP toccati
- `phpinsights` eseguito: i file toccati stanno bene a livello code/architecture, ma il report segnala ancora rumore storico del repository in style/syntax fuori da questo fix
- `phpmd` non disponibile nel repository (`./vendor/bin/phpmd` mancante)
