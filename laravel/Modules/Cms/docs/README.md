---
qmd: "README"
issues: []
discussions: []
title: "Cms: README"
type: documentation
tags: [module, documentation, cms, content-management]
created: 2026-07-14
updated: 2026-10-14
status: active
---

# Modulo Cms

Modulo Laraxot `Modules\Cms` (alias `cms`, priorita' 3 in `module.json`, provider `CmsServiceProvider`, `Filament\AdminPanelProvider`, `FolioVoltServiceProvider`). Verificato sul codice il 2026-10-14. Il testo precedente di questo README (Services `PageService`/`BlockService`/`ContentService`, modello `Block`, `PublishPageAction`, `CreatePageAction`, `Page::addBlock()`, config `config/local/cms/blocks.php`, test `PageCreationTest.php`) descriveva classi e file che non esistono ed e' stato sostituito; i suoi riferimenti a `block-system.md`, `frontend-rendering.md` e `folio-integration.md` puntavano a file mai esistiti.

## Come il sito serve le pagine (verificato)

1. **Il contenuto sono file JSON per tenant.** `Models\Page` estende `BaseModelLang`, usa `HasBlocks` e il trait `SushiToJsons` del modulo Tenant: ogni riga e' un file `laravel/config/<tenant>/database/content/pages/<slug>.json` (per il tenant `local/fixcity`: 99 file al 2026-10-14; `sections/` ne ha 8). Colonne dello schema: `id`, `title` (json per lingua), `slug`, `middleware` (json), `content`, `description`, `layout`, `blocks`, `content_blocks`, `sidebar_blocks`, `footer_blocks` (json per lingua), `created_at/by`, `updated_at/by`. Come si sceglie il tenant: [Tenant](../../Tenant/docs/README.md).
2. **Le rotte sono Folio, non route Laravel.** `Providers\FolioVoltServiceProvider` monta con `Folio::path()` la cartella `resources/views/pages` del tema pubblico (`XotData::getPubThemeViewPath('pages')`, oggi Sixteen) sotto `/{locale}` per ogni lingua di `laravellocalization.supportedLocales` (a runtime `de,en,es,it`), e lo stesso per `resources/views/pages` di ogni modulo; poi `Volt::mount()` su `livewire/` e `components/blocks/` del tema. `routes/web.php` del Cms contiene solo `/` che reindirizza a `/{locale}`.
3. **Lo slug e' l'URL.** Pagina generica `pages/[container0]/[slug0]`: `Actions\ResolvePageAction` prova, in ordine, un modello dinamico (`profile`; `blog` e `events` dal modulo Blog, solo se installato; `xra.container0_model_map`; `Modules\<Container>\Models\<Singolare>`), poi la pagina `<container0>.<slug0>`, poi `<container0>.view`. Il middleware dichiarato nel JSON (`"middleware": ["auth"]`) lo applica `Http\Middleware\PageSlugMiddleware`, agganciato nelle pagine del tema `[container0]/[slug0]/index.blade.php` e `tests/[slug].blade.php`. Da URL a JSON: [DCP-41](./stories/dcp-41-url-to-json-resolver.story.md) e `bashscripts/tools/cms/page-json-for-url.sh <url>`.
4. **I blocchi sono voci JSON con un `type`.** Esempio da `home.json` (lingue `it`, `en`, `de`, `es`, 4 blocchi per lingua): `home.hero`, `ticket.map-preview`, `how-it-works`, `quick-actions`. `Models\Traits\HasBlocks::getBlocks($side)` legge `blocks` o `<side>_blocks` per la lingua primaria e produce `Datas\BlockData`; `Actions\ResolveLocalizedBlockDataAction` risolve i valori per lingua, `Actions\ResolveBlockQueryAction` esegue la query dichiarata nel blocco (`model`, `scope`/`scopes`, `orderBy`, `limit`, `wrap_in`). Il rendering sono componenti Blade in `Themes/Sixteen/resources/views/components/blocks/` (166 voci) e `Modules/Cms/resources/views/components/blocks/`.
5. **Metatag e JSON-LD.** `View\Components\Metatags` legge `Modules\Xot\Datas\MetatagData` e `Actions\BuildPageSchemaAction` costruisce lo schema della pagina. Il modulo Seo non e' coinvolto.

## Amministrazione Filament

Risorse: `PageResource`, `SectionResource`, `MenuResource`, `PageContentResource`, `AttachmentResource`. Blocchi per il Builder in `app/Filament/Blocks/` (17 classi: `HeroBlock`, `CtaBlock`, `ParagraphBlock`, `NavigationBlock`, ...). Cluster `Appearance` con pagine `Breadcrumb`, `Footer`, `Headernav` (salvano con `SaveFooterConfigAction`, `SaveHeadernavConfigAction` nella config del tenant), pagina `Themes`. Componenti Volt di autenticazione in `app/Http/Volt/` (Login, Register, Verify, Password).

## Quick start

```bash
cd laravel
ls config/local/fixcity/database/content/pages | head          # le pagine del tenant corrente
bash ../bashscripts/tools/cms/page-json-for-url.sh http://127.0.0.1:8081/it/tests   # provato: stampa 'slug: tests.index' e i due JSON (richiede il server attivo; su /it/ non trova data-slug)
```

## Debito noto (verificato 2026-10-14, non modificato qui)

- Directory estranee dentro `app/`: `app/docs/` (INDEX, wiki, raw, package.json), `app/Config/` e `app/config/` (due `xra.php`), `app/bashscripts/`, `app/App/` vuota.
- Cartelle di viste duplicate: `resources/views/Components_old3`, `components_old3`, `Composers` e `composers`.
- 576 file .md nella radice di `docs/` (`find -maxdepth 1`, 2026-10-14); consolidamento DOC-004/006 ancora aperto.

## Test

151 file PHP in `tests/` (Unit: Actions, Datas, Filament, Http, Middleware, Models, Providers, Support, View; Feature: `HomepageConfigurationGovernanceTest`, `HomepageFilamentBlocksArchitectureTest`, `HeaderNavJsonTest`, `IndividualFolioRoutesTest`, ...). Non eseguiti in questa verifica. Il `Pest.php` di un modulo non viene caricato se si lancia Pest dalla root `laravel/` (Seo: 22 falliti su 46 per questo, vedi [Seo](../../Seo/docs/README.md)); Tenant e' stato lanciato con `bash bashscripts/tools/pest-scratch-db.sh Modules/Tenant/tests/Unit/Actions` (27 passati, 5 falliti per `expectMockery`).

## Mappa dei docs

Contratto corrente per le pagine pubbliche di primo livello: [container0 index
JSON-driven pages](./wiki/concepts/container0-index-json-driven-pages.md).

Il contratto comune per la documentazione è
[DOCUMENTATION_GOVERNANCE.md](../../../../docs/DOCUMENTATION_GOVERNANCE.md).
Questo `README.md` è l'ingresso canonico del modulo; gli indici esistenti sono
mappe di navigazione e non fonti concorrenti.

### Regola operativa per le pagine di primo livello

Prima di creare una Blade sotto `resources/views/pages/`, verificare se l'URL è
già coperto da `[container0]/index.blade.php` o da `[container0]/[slug0]`. Per
`domande-frequenti.index` la risposta è sì: la view speciale
`Themes/Sixteen/resources/views/pages/domande-frequenti/index.blade.php` è vietata
perché duplica il match Folio e bypassa il JSON tenant. Se il problema è nel
markup, correggere il blocco condiviso; se è nei dati, correggere JSON/Filament;
se è nel catalogo, correggere il modulo owner.

Indice operativo: [00-INDEX.md](./00-index.md). Wiki: [wiki/index.md](./wiki/index.md); middleware e JSON: [wiki/concepts/cms-page-middleware-json-ssot.md](./wiki/concepts/cms-page-middleware-json-ssot.md); guscio Folio: [wiki/concepts/folio-page-shell-pattern.md](./wiki/concepts/folio-page-shell-pattern.md); homepage: [architecture/homepage-structure.md](./architecture/homepage-structure.md); blocchi: [blocks/README.md](./blocks/README.md); front office: [frontoffice/architecture.md](./frontoffice/architecture.md). Story: [stories/](./stories/); PHPStan: [stories/phpstan-cms-zero.story.md](./stories/phpstan-cms-zero.story.md).

## Dipendenze / Moduli Correlati

- [Xot - Framework Base](../../Xot/docs/README.md) — Always dependency
- [UI - Components](../../UI/docs/README.md) — For UI components library
- [Lang - Translations](../../Lang/docs/README.md) — For i18n support
- [Media - File Management](../../Media/docs/README.md) — For image/file handling

## Documenti Correlati

- [PHPStan Configuration](../../../phpstan.neon)

## Regole Critiche

1. **Always extend Xot base classes** — Never extend Laravel/Filament directly
2. **Use namespace `Modules\Cms`** — Never `app\Cms`
3. **Strict typing** — `declare(strict_types=1);` in all files
4. **Relative links only** — All doc links must be relative paths
5. **No placeholder text** — Remove PROJECT_NAME, [CHANGE_ME], etc
6. **JSON validation** — Validate block data structure before storage
7. **No merge conflict markers** — Ensure clean commits

## Standard Rules & Workflow

- [[BMAD Method](../../../../docs/wiki/concepts/bmad-method.md)]
- [[Context Engineering](../../../../docs/wiki/concepts/context-engineering.md)]
- [[LLM Wiki Governance](../../../../docs/wiki/concepts/llm-wiki-governance.md)]

---

**Ultima verifica**: 2026-10-14 (Laravel 13.35.0, PHP 8.4.26). Livello PHPStan e copertura non rimisurati in questa verifica.

**Sostenibilità (discovery):** [project-sustainability-content.md](./project-sustainability-content.md) — outline `/sostieni` e footer partner. Il dossier locale del modulo è la fonte mantenuta; eventuali riferimenti a `bmad-output/` sono storici.

**Note**: Documentation previously had duplications and merge conflicts. This version consolidates to single source of truth.
