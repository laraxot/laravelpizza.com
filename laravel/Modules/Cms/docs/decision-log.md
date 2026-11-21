---
type: decision-log
title: "Decision Log — Cms Homepage Audit"
links: {github_issue: #500, discussion: #501}
---
# Decision Log — Cms Homepage Audit

## Decisions

### 2026-10-08: Riallineamento dell'intero modulo all'ultimo commit buono `0dbc5d19`
- **Choose**: Confronto a tre vie dell'intero modulo (app, config, routes, resources, lang, database, tests) con `0dbc5d19` (07/10 06:35), l'ultimo commit prima degli eventi del 07/10 (copia vecchia fusa e re-import).
- **Over**: Tenere le versioni portate dagli eventi, o il commit `a9201218` di Marco dell'08/10 sui 47 file che tocca.
- **Because**: Ogni contenuto sovrascritto e' stato verificato come gia' esistente prima del 07/10 (296 su 296).
  - 296 toccati solo dagli eventi: contenuto da `0dbc5d19`. 3 file che gli eventi avevano tolto tornano: `tests/pest.php` (minuscolo, diverso da `tests/Pest.php` e non caricato da Pest) e i report in `tests/.claude-audit/`, oggi ignorati dal `.gitignore`.
  - 1 aggiunto solo dalle copie vecchie: `app/Filament/FrontPanelProvider.php`, eliminato. Dichiarava la stessa classe di `app/Providers/Filament/FrontPanelProvider.php`, quello usato.
  - 47 toccati da `a9201218` (08/10): contenuto da `0dbc5d19`. Il commit univa la rimozione meccanica di variabili "inutilizzate" (istruzioni unite sulla stessa riga, asserzioni tolte dai test) a riscritture di 18 test gia' presenti in `0dbc5d19` in forma piu' accurata: `AttachmentDiskEnumTest` controlla anche le chiavi grezze `fix:`, `ThemeComposerTest` marca `todo` i test che scriverebbero nello store JSON del tenant, `CmsContentManagementTest` mantiene le asserzioni. Lo stesso lavoro rifatto sulla copia vecchia, come per Notify e User.
  - `BaseTreeModel` e `Menu`: tenuta la versione del commit di stamattina (trait vendor senza `@template`/`@implements` generici). Il merge a tre vie avrebbe rimesso le annotazioni che davano `generics.notGeneric`.
- **Verifica**: `php -l` pulito, nessun marcatore di conflitto; PHPStan su `Modules` senza errori in Cms (spariti anche i 2 errori segnalati prima in `FolioVoltServiceProvider` e `LoginTest`, che con `0dbc5d19` si risolvono). Pest prima/dopo a blocchi, confronto JUnit: nessun peggioramento dovuto al codice. La maggior parte dei test Cms fallisce in entrambi gli stati per il bootstrap del modulo non caricato dalla root; l'unico test che passa a fallire (`HasBlocksTest`) e i test nuovi di `0dbc5d19` falliscono per lo stesso motivo (*A facade root has not been set*, helper non definiti).

### 2026-10-08: BaseTreeModel e Menu: trait vendor (lavoro del 06/10 sera) senza annotazioni generiche
- **Choose**: Tenere `BaseTreeModel` e `Menu` all'ultima versione buona (blob `6b4adee6` e `e2a5c3ef`: trait vendor `HasRecursiveRelationships`, pulizia PHPStan della story `2026-10-06-phpstan-cleanup-cms`), togliendo solo `@template`/`@implements HasRecursiveRelationshipsContract<…>`.
- **Over**: Tornare al trait `TypedHasRecursiveRelationships` della versione del 06/10 del monorepo.
- **Because**: Il passaggio al trait vendor (`9d61081b`) è lavoro nuovo e voluto; il merge del 07/10 l'aveva solo spogliato delle annotazioni. `HasRecursiveRelationshipsContract` non è mai stato generico in nessuna versione, nemmeno nei commit irraggiungibili di Xot: le annotazioni davano `generics.notGeneric`. Il contratto in Xot è stato reso compatibile con il trait vendor (vedi decision-log Xot).
- **Aperti, non toccati**: `FolioVoltServiceProvider` referenzia `App\Http\Middleware\BlockLegacyPublicPages`, assente in questo progetto; `tests/Feature/Auth/LoginTest.php:163` `argument.templateType`. Nessuno dei due è una regressione.

### 2026-10-07: Audit della homepage
- **Choose**: Audit e miglioramento homepage del modulo Cms come priorità, basato sui documenti homepage-*.md esistenti e su competitor analysis.
- **Over**: Creazione di nuovi moduli o refactoring di altri moduli (priorità più bassa).
- **Because**: La homepage è il punto di ingresso del portale; un miglioramento della UI/UX ha impatto immediato sugli utenti.

### 2026-10-07: BMAD docs per homepage
- **Choose**: Creare story, investigation e decision-log nel modulo Cms (docs/stories, docs/investigation, docs/decision-log.md).
- **Over**: Creazione in un modulo separato o in root.
- **Because**: Regole del progetto (AGENTS.md): documenti nel modulo, frontmatter YAML con link GitHub/Discussion, ragionati a mano, non generati da script.

## Open Questions
- Quali KPI mostrare sulla homepage? (volume segnalazioni, MTTR, compliance SLA, distribuzione geografica?)
- Quale stack UI? (DaisyUI / Tailwind con DESIGN.md tokens?)
- Come integrare i dati real-time? (Filament widgets? Action che aggrega dati dal DB?)

## Evidence
- Competitor analysis (vedi docs/stories/homepage-audit-story.md)
- Documentazione esistente (docs/homepage-*.md)
- Regole architettura (no controller, action-based)
