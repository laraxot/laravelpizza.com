---
title: "Docs Cms: studio del codice e correzione degli ingressi (DOC-010, DOC-002)"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Cms
tags: [docs, cms, folio, json, blocchi, stale, docs-organizer, bmad]
qmd: "cms docs studio 2026-10-14 Page SushiToJsons pagine JSON tenant Folio ResolvePageAction PageSlugMiddleware blocchi type PageService inesistente"
related:
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ./dcp-41-url-to-json-resolver.story.md
---

# Docs Cms: studio del codice e correzione degli ingressi

## Richiesta
Fase BMAD documentazione/qualita' (DOC-010 + DOC-002): capire come il Cms serve le pagine JSON del sito (modelli Page, sezioni, blocchi) e confrontarlo con i docs; correggere `README.md`, `00-INDEX.md`, `index.md` senza toccare le righe dell'altra sessione che lavora sul Cms.

## Analisi
Verificato il 2026-10-14:
- `Models\Page` (`BaseModelLang` + `HasBlocks` + `SushiToJsons` del modulo Tenant) legge file `laravel/config/<tenant>/database/content/pages/<slug>.json`: 99 per `local/fixcity`, 8 in `sections/`. Campi: `title`, `description`, `blocks`, `content_blocks`, `sidebar_blocks`, `footer_blocks` per lingua, `middleware`, `layout`. `home.json`: 4 blocchi per lingua (`home.hero`, `ticket.map-preview`, `how-it-works`, `quick-actions`).
- Le rotte sono Folio: `FolioVoltServiceProvider` monta `pages/` del tema pubblico (Sixteen) e dei moduli sotto `/{locale}` per `de,en,es,it`, poi `Volt::mount`. `routes/web.php` del Cms ha solo `/` che reindirizza a `/{locale}`.
- `ResolvePageAction`: modello dinamico (`profile`, `events`, `xra.container0_model_map`, `Modules\<C>\Models\<Singolare>`), poi `<container0>.<slug0>`, poi `<container0>.view`. `PageSlugMiddleware` applica il `middleware` del JSON ed e' agganciato nelle pagine Sixteen `[container0]/[slug0]/index.blade.php` e `tests/[slug].blade.php`.
- Blocchi: `HasBlocks::getBlocks($side)` -> `BlockData`; `ResolveBlockQueryAction` (model, scope, orderBy, limit, wrap_in); resa in `Themes/Sixteen/resources/views/components/blocks/` (166 voci). Metatag: componente `Metatags` + `BuildPageSchemaAction` su `Xot\Datas\MetatagData` (il modulo Seo non c'entra).
- Il vecchio README descriveva `PageService`, `BlockService`, `ContentService`, modello `Block`, `PublishPageAction`, `CreatePageAction`, `config/local/cms/blocks.php`, `PageCreationTest.php`: nessuno esiste (`app/Services` assente). `wiki/content-architecture.md` descrive modelli `ContentPage`/`ContentBlock` inesistenti. `00-index.md` (variante minuscola, `active`) linka 9 file di `../Meetup/docs/` che non esistono (nemmeno in `Themes/Meetup/docs/`).
- Igiene: dentro `app/` ci sono `docs/`, `Config/` e `config/` (due `xra.php`), `bashscripts/`, `App/` vuota; in `resources/views` `Components_old3`/`components_old3` e `Composers`/`composers`.

## Modifiche
- `README.md`: blocco da "# Modulo Cms" a "Dipendenze" sostituito (come si servono le pagine, Filament, quick start provato, debito, test, mappa); footer "Production" sostituito dalla data di verifica; `status: active`.
- `00-INDEX.md` (riletto prima, mtime 07:36:52, nessuna scrittura nei 15 minuti precedenti): aggiunta in coda al paragrafo di governance la sezione "Stato verificato e mappa delle directory"; righe dell'altra sessione intatte (la nota "BMAD + second brain note (agent AI update 2026-10-14)" e le sezioni Design Comuni non sono state toccate), solo `updated` portato a 2026-10-14.
- `00-index.md`: nota di variante storica e 18 link a `../Meetup/docs/` annotati come mancanti.
- `index.md`: nota in testa e 24 link a file mancanti annotati.
- `wiki/log.md`: 2 link annotati e voce datata. `docs-organizer.py stale --fix` su `wiki/content-architecture.md`.

## Verifica
- `bash bashscripts/tools/cms/page-json-for-url.sh http://127.0.0.1:8081/it/tests` -> `slug: tests.index (letto dalla risposta)` e i due JSON; su `/it/` non trova `data-slug`.
- Link (eventi `unresolved` con `--busy-minutes 0`, solo i 6 file toccati): prima 47, dopo 44, tutti annotati (senza annotazione: 0). Intero modulo: 1878 prima, 1875 dopo. Con la metrica di `audit` (link rotti nei soli file indice) il brief indicava 468, ora 465. File del modulo con link irrisolti: 462.
- Frontmatter in dry-run: 61 eventi `frontmatter-dry` ancora in attesa (62 prima: `README.md` ora ha `status`).
- Test del Cms non eseguiti.

## Decisioni
- I 576 .md nella radice di `docs/` non si spostano (DOC-004/006). Nessun file cancellato o rinominato; nessuna modifica al codice.
- `00-INDEX.md` resta l'ingresso operativo; `index.md` e `00-index.md` restano varianti storiche annotate.

## Aperto
- Pulire `app/docs`, `app/Config`, `app/config`, `app/bashscripts`, `app/App` e le viste `*_old3`: richiede una story di codice.
- `bottlenecks.md` cita `Modules\Cms\Services\SearchService` e `roadmap-complete.md` `PageService`/`BlockService`: non marcati (sono piani).
- Quale tenant sia autorevole per le copie multiple dello stesso JSON (aperto da DCP-41).
