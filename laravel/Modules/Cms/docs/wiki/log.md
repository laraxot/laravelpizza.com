- 2026-06-10: folio-filesystem-routing-no-web-php + troubleshooting folio-route-not-found
## [2026-06-05] docs | Folio routing — mount() tipizzato + @volt statico

- `folio_routing_system.md`: `mount(string $container0, string $slug0 = '')`; anti-pattern senza `request()->route()`
- Shell: [concepts/folio-page-shell-pattern.md](concepts/folio-page-shell-pattern.md)

## [2026-06-05] docs | HackerNoon harness — tips 001-022 in wiki locale

- Stub/checklist: second-brain → canon Xot, ai-harness, [hackernoon map](../../../../../docs/wiki/concepts/hackernoon-ai-coding-tips-fixcity-map.md), [llm-wiki.txt](../../../../../bashscripts/tools/prompts/llm-wiki.txt)
- GitHub: [#272](https://github.com/laraxot/base_fixcity_fila5/issues/272) / [D#273](https://github.com/laraxot/base_fixcity_fila5/discussions/273)

# Cms Wiki Log

## [2026-06-05] architecture | Folio page shell — mount + x-page + volt statico

- Nuovo: [folio-page-shell-pattern.md](concepts/folio-page-shell-pattern.md)
- Aggiornato: `folio_routing_system.md` — no `@volt($pageSlug)`, es. `container1.index`

## [2026-05-26] docs | ridondanza ThemeComposer — copia fuori da PSR-4

- **Codice**: `app/View/Composers/ThemeComposer.php` (autoload) vs `resources/views/Composers/ThemeComposer.php` (fantasma quasi gemello) — vedere **[`docs/redundancy-report.md`](../redundancy-report.md)** §5 e hub Xot [`audit-profondo-ridondanze-holistic.md`](../../../Xot/docs/wiki/redundancy/audit-profondo-ridondanze-holistic.md) § analisi nominale.

## [2026-04-21] fix | merge conflict code-quality-analysis.md
- Rimossa copia integrale duplicata introdotta dal merge (blocco `--- Merged from code-quality-analysis-2025-11-24.md ---`).
- Preservata unica riga aggiuntiva utile: `**Status:** ❌ CRITICAL - Requires Immediate Fixes`.
- File: `laravel/Modules/Cms/docs/code-quality-analysis.md`.

## [2026-04-15] init | wiki bootstrap
- Struttura wiki/log.md inizializzata.
- Layer raw: tutti i file in `docs/` (eccetto `wiki/`).
- Layer wiki: `docs/wiki/` — LLM-maintained, sintesi ad alto riuso.
- Schema: `docs/.schema/WIKI_SCHEMA.md`
- Adozione moduli: `docs/project/llm-wiki-module-adoption.md`

## [2026-04-21] conflict-resolution-batch-1 | cms
- Risolti manualmente marker Git in:
  - `app/Actions/ResolvePageAction.php`
  - `app/View/Components/Page.php`
  - `tests/Feature/FilamentBuilderBlocksTest.php`
- Ripristinata la logica di risoluzione pagina (`container0/slug0`, slug esplicito, fallback da data).
- Verifica eseguita:
  - `php -l` sui file corretti
  - `./vendor/bin/pest Modules/Cms/tests/Feature/FilamentBuilderBlocksTest.php` (pass)

## [2026-04-21] runtime-fix-home-it | cms
- Verificato endpoint `http://127.0.0.1:8000/it` con errore runtime iniziale: `ParseError` in `app/View/Components/Section.php`.
- Corretto componente `Section`:
  - rimozione frammenti corrotti da merge conflict;
  - ripristino assegnazioni proprietà in costruttore;
  - ripristino risoluzione view `pub_theme::components.sections.{slug}.{tpl}`;
  - passaggio parametri view coerenti (`blocks`, `slug`, `class`, `id`).
- Verifica finale:
  - `php -l app/View/Components/Section.php` (pass)
  - `curl http://127.0.0.1:8000/it` -> `HTTP 200`

## [2026-04-21] conflict-resolution-batch-2 | cms
- Risolti manualmente marker Git in:
  - `app/View/Components/Page.php`
  - `database/seeders/CmsMassSeeder.php`
- Scelte di merge:
  - `Page` mantiene fallback slug da `data`, prefisso `type`, compatibilita con `container0/slug0`, e view params puliti.
  - `CmsMassSeeder` ripristina il flusso reale (`create*`) rimuovendo frammenti corrotti/commenti pseudo-codice.
- Verifica:
  - `php -l app/View/Components/Page.php` (pass)
  - `php -l database/seeders/CmsMassSeeder.php` (pass)

## [2026-04-21] fix | Footer Filament page `$data` vs `XotBasePage`
- **Errore**: `FatalError: Type of ...\Footer::$data must be array (as in class ...\XotBasePage)`.
- **Fix**: ripristinato `public array $data = []` in `app/Filament/Clusters/Appearance/Pages/Footer.php` (allineato a `Headernav` e a `statePath('data')`); i dati dominio restano in `public FooterData $footerData`.
- **Verifica**: `php -l` sul file (pass).

## [2026-04-21] fix | BlockData costruttore (ParseError / stato form)
- **Errore**: `ParseError: Unclosed '(' ...` segnalato su `app/Datas/BlockData.php` (caricamento via `HasBlocks` / pagina test `segnalazione-crea`).
- **Fix**: costruttore ripulito — risoluzione `view` da `data`, validazione `view()->exists`, assegnazione esplicita di `$this->data` e `$this->view` prima di `detectLivewire`; rimosso ramo con `return` nel costruttore e variabili inutilizzate.
- **Verifica**: `php -l app/Datas/BlockData.php` (pass).

## [2026-04-21] fix | Section view component (syntax + costruttore)
- **Errore**: `syntax error, unexpected token "]"` in `app/View/Components/Section.php` (layout `Themes/Sixteen/.../app.blade.php` → pagina test `/it/tests/segnalazione-crea`).
- **Causa**: frammenti corrotti (commenti inline su concatenazioni/array) lasciati dopo merge.
- **Fix**: ripristino costruttore (`$slug`, `$class`, `$id`, `$tpl`), `getBlocksBySlug` su `$this->slug`, `render()` con `pub_theme::components.sections.{slug}.{tpl}` e `viewParams` validi (`blocks`, `section`).
- **Verifica**: `curl http://127.0.0.1:8000/it/tests/segnalazione-crea` -> HTTP 200.

## 2026-06-10 — Folio learnings documentati

- `folio-list-vs-route-list.md`, patch filesystem routing + troubleshooting
- INDEX concepts ripulito; cross-link User/Sixteen
