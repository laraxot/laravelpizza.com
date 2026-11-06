---
type: decision-log
title: "Decision Log: Xot"
links: {github_issue: "#XXX", discussion: "#XXX"}
status: draft
updated: 2026-10-23
tags: [docs, xot]
qmd: "decision log   xot xot"
---
# Decision Log: Xot

## Decisions

### 2026-10-14: Un solo indice del docs; i documenti smentiti si marcano `stale`, non si riscrivono
- **Choose**: `00-INDEX.md` e' l'unico indice del modulo e dichiara cartelle canoniche, evidence e legacy; `wiki/index.md` e `bmad/index.md` restano indici di sezione; i documenti che contraddicono il codice (`wiki/architecture.md`, `wiki/Architecture.md`, `standards/README.md`, `standards/readme.md`, `governance/docs-structure.md`) sono marcati `status: stale` con il motivo; i link non risolti delle pagine di primo livello sono annotati `target mancante`.
- **Over**: Creare un `index.md` alla radice (vietato dal contratto), riscrivere i documenti smentiti o inventare bersagli per i link.
- **Because**: 738 riferimenti non risolti in 254 file `.md`; i bersagli non esistono e nessuna fonte dice dove siano andati. 24 story hanno marker di merge: la policy vieta di riscriverle.
- **Verifica**: `phpstan analyse Modules/Xot` exit 0; conteggi del codice da `find`; `docs-organizer.py --busy-minutes 0 links --by-name` (dry-run). Story: [2026-10-14-docs-xot-studio-e-ingressi](stories/docs-xot-studio-e-ingressi.story.md).

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `cadb1578e`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `cadb1578e` (06/10 18:00, commit irraggiungibile: la linea buona di Xot e' stata sostituita dal re-import senza genitori `2dc9faf42` del 07/10 13:11). Tra il 06/10 18:00 e il re-import non ci sono altri commit su Xot.
- **Over**: Lo stato del monorepo al 06/10 (`51570adf3`), usato stamattina per i primi 8 file: coincide con `cadb1578e` su tutti i 1771 file in comune, ma non traccia 94 file (immagini, `.old`, `.bak`, alcuni `.php`).
- **Because**: Ogni contenuto sovrascritto o eliminato e' stato verificato come gia' esistente prima del 06/10 18:00, contando anche i 1092 commit irraggiungibili (313 + 221 su 534).
  - 313 toccati solo dal re-import: contenuto da `cadb1578e`. Tra questi `XotBaseRouteServiceProvider`, che nella copia vecchia aveva `mapWebRoutes()`/`mapApiRoutes()` disattivati ("using Folio + Volt"): nessun modulo caricava piu' `routes/web.php` e `routes/api.php` (in locale `Route [quaeris.dashboard-v3.pdf-snapshots.start] not defined`, rotte `socialite.*` mancanti nei test User).
  - 8 tolti dal re-import e ripristinati: `tests/pest.php` (minuscolo, non caricato da Pest) e `tests/graphify-out/*` (oggi ignorati dal `.gitignore`).
  - 221 aggiunti solo dal re-import: eliminati. 218 nella cartella annidata `lang/lang`; `app/Actions/ContextCompressor.php`, che dichiarava la stessa classe `ContextCompressorAction` di `ContextCompressorAction.php`; i probe `app/Phpstan/TraitProbes.php` e `tests/Fixtures/Traits/HasCustomModelLabelProbes.php`.
  - Lavoro di Marco dell'08/10 `bea6f0b31` (story `2026-10-08-services-to-actions-xot-{artisan,route,small}`, `phpstan-xot-app-regressions`, `phpstan-xot-tests-without-assertions`): mantenuto. Restano eliminati 54 file (`Services/Artisan`, `Services/Translators`, `Services/Trend`, 11 action Artisan sostituite da `HandleArtisanActRequestAction` + `ArtisanActEnum`), restano i 9 file nuovi, 45 file uniti a tre vie senza conflitti.
  - `HasRecursiveRelationshipsContract` e `AssetAction`: tenuta la versione del commit di stamattina (tipi solo nel `@return` per la compatibilita' con Cms).
- **Effetto su altri moduli**: l'API buona di `XotBaseViewRecord` non ha `getInfolistSchema()`; tre pagine di Geo ancora alla copia del 28/09 lo ridefinivano con `#[\Override]` e l'app non partiva. Riportate alla linea buona di Geo (vedi decision-log Geo).
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; `php artisan about` si avvia; `route:list` torna a registrare le rotte dei moduli; PHPStan su `Modules` senza errori in Xot e nessun errore nuovo negli altri moduli. Pest prima/dopo a 10 blocchi, confronto JUnit: 0 peggiorati, 11 test nuovi passano. La maggior parte dei test Xot fallisce in entrambi gli stati per il bootstrap del modulo dalla root.

### 2026-10-08: Ripristino file regrediti e contratto HasRecursiveRelationships compatibile con Cms
- **Choose**: Ripristinare dallo stato del monorepo al 06/10 `TypedHasRecursiveRelationships`, `BaseTreeModel`, `XotBaseTreeModel`, `HasRecursiveRelationshipsContract`, `Actions/File/AssetAction` (tornano `isUpToDate()`/`copyAtomically()`), le tabelle `LogsTable` ed `ExtrasTable`, `resources/svg/files/xlsx.svg`. Nel contratto, tipi di ritorno solo nel `@return` (non nativi) sui 12 metodi che il trait vendor `HasRecursiveRelationships` dichiara senza tipo.
- **Over**: Contratto del 06/10 così com'era (con tipi nativi), oppure contratto del sotto-repo senza la riscrittura del 06/10.
- **Because**: Il commit `2dc9faf42` (07/10 13:11, senza genitori, 9633 file) aveva riportato i modelli ad albero alla versione di marzo 2026. La riscrittura del 06/10 (trait Typed, contratto tipizzato) esisteva solo nel monorepo e in commit locali di Xot oggi irraggiungibili (06/10 15:14-18:00). Nel frattempo Cms (`9d61081b`, 06/10 18:48) è passato al trait vendor: con i tipi nativi nel contratto il caricamento di `Cms\Models\Menu` era un errore fatale. Scelta dell'utente: tenere entrambi i lavori; PHPStan legge il `@return`, il trait Typed resta covariante.
- **Verifica**: `php -l`; i cinque modelli ad albero (Cms, Xot, Limesurvey) si caricano; PHPStan su `Modules` senza errori in Xot; test prima/dopo identici.

<!--
GateGuard facts:
1. Supersedes nothing: adds one decision entry for docs spine wave1; does not rewrite prior decisions.
2. Linked from README.md, INDEX.md, conventions/docs-organization.md, Hindsight page Docs spine Modules e Themes.
3. Edit existing decision-log.md: not a new file.
4. User verbatim: "aggiorna studia e migliora e organizza meglio le cartelle docs dentro i moduli e dentro i temi e migliora il tuo second brain"
-->

### 2026-10-20: Docs spine Modules/Themes (wave1)

- **Choose**: SSoT [conventions/docs-organization.md](conventions/docs-organization.md); `README.md` ingresso; elimina `readme.md` duplicati; Geo kebab canon + stub alias; spine Xot/Geo/Notify/Zero; ingest Hindsight.
- **Over**: rename massivo UPPERCASE o fusione INDEX/00-INDEX senza mappa link.
- **Because**: doppi ingressi spezzano retrieval; richiesta utente di organizzare docs moduli/temi e second brain.
- **Verifica**: 0 coppie `readme.md`+`README.md` sotto `*/docs/`.

## Open Questions

