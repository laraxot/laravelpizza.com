---
qmd: "xot decision log md"
type: decision-log
title: "Decision Log — Xot"
<<<<<<< .merge_file_RbkTMg
links: {github_issue: "#XXX", discussion: "#XXX"}
=======
links: {github_issue: #XXX, discussion: #XXX}
>>>>>>> .merge_file_rmVKQ9
---
# Decision Log — Xot

## Decisions

<<<<<<< .merge_file_RbkTMg
=======
<<<<<<< HEAD
>>>>>>> .merge_file_rmVKQ9
### 2026-11-24: Vietato `require` di `Modules/Xot/routes/empty.php`
- **Choose**: stub locale minimo in `routes/web.php` / `routes/api.php` quando non ci sono rotte; ADR `docs/adr/no-shared-empty-route-file.md`.
- **Over**: file condiviso `empty.php` in Xot, oppure omettere i file routes.
- **Because**: `empty.php` non esisteva; il require era coupling a zero comportamento e residuo di merge conflict (UI/Lang/Cms). `XotBaseRouteServiceProvider` già fa `Route::group` sul file del modulo.
- **Verifica**: `rg "Xot/routes/empty" laravel/Modules` vuoto; test `NoSharedEmptyRouteFileTest`.

=======
>>>>>>> laraxot/dev
### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `cadb1578e`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `cadb1578e` (06/10 18:00, commit irraggiungibile: la linea buona di Xot e' stata sostituita dal re-import senza genitori `2dc9faf42` del 07/10 13:11). Tra il 06/10 18:00 e il re-import non ci sono altri commit su Xot.
- **Over**: Lo stato del monorepo al 06/10 (`51570adf3`), usato stamattina per i primi 8 file: coincide con `cadb1578e` su tutti i 1771 file in comune, ma non traccia 94 file (immagini, `.old`, `.bak`, alcuni `.php`).
- **Because**: Ogni contenuto sovrascritto o eliminato e' stato verificato come gia' esistente prima del 06/10 18:00, contando anche i 1092 commit irraggiungibili (313 + 221 su 534).
  - 313 toccati solo dal re-import: contenuto da `cadb1578e`. Tra questi `XotBaseRouteServiceProvider`, che nella copia vecchia aveva `mapWebRoutes()`/`mapApiRoutes()` disattivati ("using Folio + Volt"): nessun modulo caricava piu' `routes/web.php` e `routes/api.php` (in locale `Route [<nome progetto>.dashboard-v3.pdf-snapshots.start] not defined`, rotte `socialite.*` mancanti nei test User).
  - 8 tolti dal re-import e ripristinati: `tests/pest.php` (minuscolo, non caricato da Pest) e `tests/graphify-out/*` (oggi ignorati dal `.gitignore`).
  - 221 aggiunti solo dal re-import: eliminati. 218 nella cartella annidata `lang/lang`; `app/Actions/ContextCompressor.php`, che dichiarava la stessa classe `ContextCompressorAction` di `ContextCompressorAction.php`; i probe `app/Phpstan/TraitProbes.php` e `tests/Fixtures/Traits/HasCustomModelLabelProbes.php`.
  - Lavoro di Marco dell'08/10 `bea6f0b31` (story `2026-10-08-services-to-actions-xot-{artisan,route,small}`, `phpstan-xot-app-regressions`, `phpstan-xot-tests-without-assertions`): mantenuto. Restano eliminati 54 file (`Services/Artisan`, `Services/Translators`, `Services/Trend`, 11 action Artisan sostituite da `HandleArtisanActRequestAction` + `ArtisanActEnum`), restano i 9 file nuovi, 45 file uniti a tre vie senza conflitti.
  - `HasRecursiveRelationshipsContract` e `AssetAction`: tenuta la versione del commit di stamattina (tipi solo nel `@return` per la compatibilita' con Cms).
- **Effetto su altri moduli**: l'API buona di `XotBaseViewRecord` non ha `getInfolistSchema()`; tre pagine di Geo ancora alla copia del 28/09 lo ridefinivano con `#[\Override]` e l'app non partiva. Riportate alla linea buona di Geo (vedi decision-log Geo).
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; `php artisan about` si avvia; `route:list` torna a registrare le rotte dei moduli; PHPStan su `Modules` senza errori in Xot e nessun errore nuovo negli altri moduli. Pest prima/dopo a 10 blocchi, confronto JUnit: 0 peggiorati, 11 test nuovi passano. La maggior parte dei test Xot fallisce in entrambi gli stati per il bootstrap del modulo dalla root.

### 2026-10-08: Ripristino file regrediti e contratto HasRecursiveRelationships compatibile con Cms
<<<<<<< HEAD
- **Choose**: Ripristinare dallo stato del monorepo al 06/10 `TypedHasRecursiveRelationships`, `BaseTreeModel`, `XotBaseTreeModel`, `HasRecursiveRelationshipsContract`, `Actions/File/AssetAction` (tornano `isUpToDate()`/`copyAtomically()`), le tabelle `LogsTable` ed `ExtrasTable`, `resources/svg/files/xlsx.svg`. Nel contratto, tipi di ritorno solo nel `@return` (non nativi) sui 12 metodi che il trait vendor `HasRecursiveRelationships` dichiara senza tipo.
=======
<<<<<<< HEAD
- **Choose**: Ripristinare dallo stato del monorepo al 06/10 `TypedHasRecursiveRelationships`, `BaseTreeModel`, `XotBaseTreeModel`, `HasRecursiveRelationshipsContract`, `Actions/File/AssetAction` (tornano `isUpToDate()`/`copyAtomically()`), le tabelle `LogsTable` ed `ExtrasTable`, `resources/svg/files/xlsx.svg`. Nel contratto, tipi di ritorno solo nel `@return` (non nativi) sui 12 metodi che il trait vendor `HasRecursiveRelationships` dichiara senza tipo.
=======
- **Choose**: Ripristinare dallo stato del monorepo al 06/10 `TypedHasRecursiveRelationships`, `BaseTreeModel`, `XotBaseTreeModel`, `HasRecursiveRelationshipsContract`, `Actions/File/AssetAction` (tornano `isUpToDate()`/`copyAtomically()`; **superato il 2026-11-17**: `AssetAction` non copia più, vedi [public-html-symlink-assets](wiki/concepts/public-html-symlink-assets.md)), le tabelle `LogsTable` ed `ExtrasTable`, `resources/svg/files/xlsx.svg`. Nel contratto, tipi di ritorno solo nel `@return` (non nativi) sui 12 metodi che il trait vendor `HasRecursiveRelationships` dichiara senza tipo.
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
- **Over**: Contratto del 06/10 così com'era (con tipi nativi), oppure contratto del sotto-repo senza la riscrittura del 06/10.
- **Because**: Il commit `2dc9faf42` (07/10 13:11, senza genitori, 9633 file) aveva riportato i modelli ad albero alla versione di marzo 2026. La riscrittura del 06/10 (trait Typed, contratto tipizzato) esisteva solo nel monorepo e in commit locali di Xot oggi irraggiungibili (06/10 15:14-18:00). Nel frattempo Cms (`9d61081b`, 06/10 18:48) è passato al trait vendor: con i tipi nativi nel contratto il caricamento di `Cms\Models\Menu` era un errore fatale. Scelta dell'utente: tenere entrambi i lavori; PHPStan legge il `@return`, il trait Typed resta covariante.
- **Verifica**: `php -l`; i cinque modelli ad albero (Cms, Xot, Limesurvey) si caricano; PHPStan su `Modules` senza errori in Xot; test prima/dopo identici.
## Open Questions

