---
title: "Docs Seo: studio del codice e correzione degli ingressi (DOC-010, DOC-002)"
type: story
status: done
created: 2026-10-14
updated: 2026-10-14
module: Seo
tags: [docs, seo, metatag, social-share, stale, docs-organizer, bmad]
qmd: "seo docs studio 2026-10-14 metatag facade sitemap inesistente jigsaw stale blocco spurio index.md 00-INDEX.md contratto"
related:
  - ../../../../../bmad-output/docs-architecture/module-theme-docs-contract.md
  - ../../../Fixcity/docs/stories/dcp-56-organizzazione-docs-moduli-e-temi.story.md
  - ./docs-organization-pilot.story.md
---

# Docs Seo: studio del codice e correzione degli ingressi

## Richiesta
Fase BMAD documentazione/qualita' (DOC-010 + DOC-002): studiare il codice vero del modulo Seo, correggere `README.md`, `00-INDEX.md`, `index.md` solo con fatti verificati, sistemare a mano i 5 file con blocco frontmatter spurio, annotare i link ancora rotti, senza spostare, rinominare o cancellare file.

## Analisi
Il modulo e' molto piu' piccolo di quanto i docs dicano. Verificato il 2026-10-14:
- Codice: facade `Metatag` (accessor `MetatagFacadeAdapter`), 3 Actions in `app/Actions/Metatag/`, `MetatagState` (singleton per richiesta), DTO `Datas\MetatagData`, `GenerateSocialShareLinksAction`, `SocialShareWidget`, componente Blade `social-share`. Circa 2400 righe PHP, test compresi.
- Assenze: nessun Model, nessuna migration, nessuna rotta (`routes/*.php` vuoti), nessun comando (`php artisan list` filtrato su `seo|sitemap`: nessuna riga), nessuna Resource Filament. `spatie/laravel-sitemap` e' in `composer.json` ma nessun file di `app/` lo usa; le rotte `/sitemap.xml` stanno in Xot e sono commentate (`// @require 'web_seo.php';`); `public_html/robots.txt` dichiara che la sitemap non esiste.
- Nessun altro modulo o tema importa `Modules\Seo` (grep: solo `laravel/config/app.php`). I metatag renderizzati vengono da `Modules\Xot\Datas\MetatagData`, letti da `Cms\View\Components\Metatags` e stampati da `$_theme->metatags()` in Sixteen. La facade Seo e' un'API parallela non collegata al rendering.
- Debito di codice: `app/Data/` e `app/Datas/` duplicati, `app/Interfaces/MetatagDataInterface.php` (+ `.bak`) accanto a `Contracts/`, `MetatagManager` usato solo da un test.
- Docs falsi: `README.md` era la concatenazione di due README (badge Laravel 13 e 12.x) con `SEO::setTitle`, `seo:sitemap:generate`, `seo:validate-schema`, `SeoResource`; 5 file erano template Jigsaw copiati per errore; `configuration.md` e `testing.md` citano Models e `SeoMetadata` inesistenti.

## Modifiche
- 5 file con blocco spurio (`manual-stray-block`): `PROJECT-STRUCTURE.md` e `project-structure.md` avevano i fence scritti come `\`\`\``, quindi l'esempio YAML veniva letto come frontmatter: ripristinati 8 fence per file. `wiki/_templates/{concept,entity,source}.md` avevano uno stub generico (`status: stub`, rinvio a un canonico in `Themes/docs/shared-components/` che non esiste) davanti al frontmatter vero: stub rimosso con una sostituzione mirata per file.
- `README.md`: intestazione riscritta con identita', cosa fa, quick start provato, cosa non c'e', chi lo usa, debito, test; il testo storico resta sotto un'etichetta "non verificato". `status` da `stale` a `draft`.
- `index.md` (canonico dal pilota 2026-10-08): aggiunta la sezione "Stato verificato e mappa delle directory" (canoniche, evidence, legacy) e l'avviso sotto "SEO features".
- `00-INDEX.md` e `00-index.md` (superseded): nota datata che l'elenco funzioni descrive piani e che "Test suite da implementare" e' falso; 6 link morti per file annotati.
- `docs-organizer.py stale --fix` su 9 file: `getting-started.md`, `navigation.md`, `custom-404-page.md`, `customizing-your-site.md`, `algolia-docsearch.md` (Jigsaw), `configuration.md`, `testing.md`, `docs-health.md`, `project-structure.md`.

## Verifica
- `frontmatter` in dry-run con `--busy-minutes 0`: prima 5 eventi `manual-stray-block`; dopo 0 manuali (restano 3 eventi `frontmatter-dry` sui template: mancano `status` e `qmd`).
- Link (eventi `unresolved` di `links --by-name --busy-minutes 0`, solo i 18 file toccati): prima 28, dopo 25, tutti con annotazione "target mancante" (senza annotazione: 0). Intero modulo: 168 prima, 165 dopo. Con la metrica di `audit` (link rotti nei soli file indice) il brief indicava 27, ora 27 (i link morti dei file superseded sono annotati, ma `audit` non legge le annotazioni).
- Quick start con tinker: `Titolo di prova | Descrizione di prova | Modules\Seo\Datas\MetatagData`; chiavi dei link social `facebook,twitter,linkedin,whatsapp,telegram,copy`.
- Pest dalla root `laravel/` con `bashscripts/tools/pest-scratch-db.sh Modules/Seo/tests`: 24 passati, 22 falliti (`BindingResolutionException`, `Container::register()` non definito): il `Pest.php` del modulo non viene caricato da quella radice. Non e' una prova di regressione del codice; il comando corretto resta non verificato.

## Decisioni
- Il canone dell'indice in Seo resta `index.md` (scelta del pilota). Nessun nuovo indice creato.
- Nessun file spostato, rinominato o cancellato; nessuna modifica al codice.

## Aperto
- Il contratto dei docs indica `00-INDEX.md` come indice operativo, ma in Seo e' `superseded` da `index.md`: serve una decisione (non presa qui) tra mantenere `index.md` o invertire il canone.
- Unificare `Data`/`Datas`, togliere `Interfaces/` e il `.bak`, decidere se la facade Seo debba collegarsi al rendering o essere ritirata.
- Documenti di prodotto (PRD, roadmap, strategy, sprint, `task-*`) descrivono funzioni inesistenti: non marcati uno per uno.
