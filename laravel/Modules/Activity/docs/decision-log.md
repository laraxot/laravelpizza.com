---
type: decision-log
title: "Decision Log: Activity"
links: {github_issue: "#XXX", discussion: "#XXX"}
status: draft
updated: 2026-10-20
tags: [docs, activity]
qmd: "decision log   activity activity"
---
# Decision Log — Activity

## Decisions

### 2026-10-28: LogViewer e `Adapters\ActivityLogger` sono stati cancellati da un rebase, non da una scelta

- **Choose:** ricostruire in avanti (lang, download Folio, test) cio' che il rebase fermo ha tolto; `LogActivityAction`/`Actions\ActivityLogger` su `UserContract`.
- **Over:** riscrivere i test sul codice mutilato (avrebbe tolto copertura a una funzione documentata in `README.md` e `wiki/log.md`).
- **Because:** `git diff <orig-head> <onto>` e' vuoto, quindi l'albero corretto e' `7083148f`, che contiene tutto; il commit `36463864` e' l'auto-commit di un conflitto. Dettaglio: [story](./stories/phpstan-zero-errors-activity.story.md).
- **Open:** concludere o abortire il rebase (utente); unificare i due `ActivityLogger`; scegliere una sola forma (costruttore o `execute($model)`) per le Action `LogModel*`/`LogUser*`.

### 2026-10-20: PHPStan `variable.unused` nei test: scopo prima del fix

- **Choose:** ripulire assegnazioni morte nei test (skeleton post-merge) senza inventare asserzioni o schema DB; documentare famiglia e file in [bmad-variable-unused.md](./bmad-variable-unused.md).
- **Over:** `@phpstan-ignore`, stub vuoti extra, escludere test dal neon.
- **Because:** l'errore segnala test che non verificano nulla; zittire PHPStan lascia falsi verdi. Gate unico: [ordine permanente](../../../../bashscripts/docs/prompts/00-start.md#ordine-permanente-dellutente), memoria [phpstan-modules-zero-standing-order](../../Xot/docs/wiki/memories/phpstan-modules-zero-standing-order.md).
- **Track:** [filament-blueprint](./bmad/filament-blueprint.md) (Actions, no Service).

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `bc3d22ca`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `bc3d22ca` (07/10 06:35), l'ultimo commit prima degli eventi del 07/10 (copia vecchia fusa alle 10:59, re-import).
- **Over**: Tenere le versioni portate dagli eventi, o il commit `68803a66` di Marco dell'08/10 sui 4 file che tocca.
- **Because**: Ogni contenuto sovrascritto e' stato verificato come gia' esistente prima del 07/10 (241 su 241).
  - 241 toccati solo dagli eventi: contenuto da `bc3d22ca`. Tra questi tornano le firme con `UserContract` al posto della classe concreta `User` (`ActivityLogger`, `GetActivityStatisticsAction`, `GetUserActivitiesAction`), necessarie per gli utenti `Modules\Quaeris\Models\User`, classe sorella e non sottoclasse.
  - 4 toccati da `68803a66` (08/10): contenuto da `bc3d22ca`. Il commit toglieva variabili e asserzioni (`ActivityBusinessLogicTest`, `LogViewerPageTest`) e accorciava i messaggi degli stub in `PestStubs`, che in `bc3d22ca` sono piu' informativi.
  - `tests/Fixtures/CanPaginateHarness.php` lasciato com'e': un commit della finestra degli eventi (07/10 12:53) l'aveva cambiato in modo solo estetico (import di `Model`, nome corto nel `@template`), contenuto mai esistito prima, equivalente.
- **Correzione aggiunta**: `tests/Unit/Actions/QueryAndValidationTest.php` si aspettava il messaggio `User must be an instance of User`, mentre `LogActivityAction` e l'adapter `ActivityLogger` di `bc3d22ca` lanciano `User must implement UserContract`. Test e codice erano gia' in contrasto in `bc3d22ca`: aggiornate le due attese, l'eccezione resta `InvalidArgumentException`.
- **Verifica**: `php -l` pulito; PHPStan su `Modules/Activity` senza errori. Pest prima/dopo a blocchi con lo stesso `vendor/`, confronto JUnit: nessun peggioramento, i due test di validazione ora passano (prima uno solo). Il primo confronto e' stato interrotto e rifatto perche' durante l'esecuzione era in corso un `composer update -W`.
- **Nota PHPStan**: `vendor/` aggiornato l'08/10 alle 15:52 (`phpstan-deprecation-rules`, plugin PHPStan di Pest, PHPStan 2.3.0) aggiunge errori in Chart, CloudStorage, DbForge e Quaeris, moduli non toccati da questo riallineamento.

## Open Questions

