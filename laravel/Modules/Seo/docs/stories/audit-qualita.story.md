---
title: "[STORY] Audit qualita' del modulo Seo"
type: story
status: review
priority: high
created: 2026-11-19
updated: 2026-11-19
module: Seo
issues: [64]
tags: [bmad, audit, quality, phpstan, pest, docs, dead-code]
---

# Story: audit qualita' del modulo Seo

Issue di riferimento: laraxot/base_techplanner_fila5#64.

## Obiettivo

Portare a zero i test rossi, togliere codice morto e doppioni, rendere la documentazione navigabile da un solo indice,
senza cambiare il comportamento pubblico (`/sitemap.xml`, `/robots.txt`, `seo:robots`, redirect canonici, facade `Metatag`).

## Esito

### Test (7 fallimenti iniziali, nessuno era un bug del codice di produzione)

| Test | Causa | Correzione |
|------|-------|------------|
| `CanonicalPathRedirectTest` (serve le pagine canoniche) | Usava `/it/tickets`, pagina che esiste solo nei progetti con il modulo dei ticket | Pagine presenti ovunque: `/it`, `/en`, `/it/auth/login`, `/up` |
| `RedirectToCanonicalPathTest`, `RedirectToPageAliasTest` | Casi `de`/`es`, lingue non attive in questo progetto (`en`, `it`) | Il test fissa le sue lingue in `beforeEach` |
| `SitemapDetailTemplatesTest` (articoli in sitemap) | Nessun modulo registra percorsi sotto `SitemapPathsContract::TAG` in questo progetto | Skip esplicito se nessuna sorgente e' registrata |
| `ReplaceMetatagDataActionTest` (2) | Mancava `uses(TestCase::class)`: senza provider `MetatagState` non era singleton | Aggiunto il TestCase |
| `MetatagServiceExtendedTest` | Senza TestCase (`config` non risolto) e su una classe morta | Rimosso con la classe (copertura gia' in `MetatagFacadeAdapterExtendedTest`) |

### Codice morto rimosso (nessun riferimento in `laravel/`, verificato con grep)

- `app/Services/MetatagService.php`, `app/Adapters/MetatagManager.php`: la facade usa `MetatagFacadeAdapter`.
- `app/Data/MetatagData.php`, `app/Data/SocialShareData.php`: doppioni di `app/Datas/*`; `tests/Unit/Data/*` erano copie dei test in `tests/Unit/Datas/*`.
- `app/Actions/Url/ResolvePageAliasAction.php` (+ test): sostituita da `ResolvePathAliasAction` + `SeoConfigData::pathAliases()`.
- `app/Interfaces/MetatagDataInterface.php`: sostituita da `Contracts/MetatagDataContract`.
- 5 file `*.php.lock` di un vecchio lock di sessione (2026-11-01) finiti nel repository.

`mixed` in `app/`: 28 -> 23 (rimossi con il codice morto; i restanti sono confini legittimi: dati arbitrari dei metatag, regole di validazione Filament).

### Documentazione

- Indice unico: [index.md](../index.md). Rimossi `00-INDEX.md`, `00-index.md`, `INDEX.md` (gia' `superseded`).
- `README.md` (concatenazione `stale` di due README) riscritto come presentazione breve e corretta del modulo.
- 12 file con data nel nome: rinominati (data in `created:`) o uniti/rimossi se doppioni; 15 file vuoti (solo frontmatter o segnaposto) rimossi; 2 duplicati esatti rimossi; link aggiornati.
- `services-to-adapters-conversion.md` e `philosophy-3.md` allineati allo stato reale (facade -> `MetatagFacadeAdapter`).

## Verifica

- PHPStan livello max su `Modules/Seo`: 0 errori (prima e dopo).
- Pest `Modules/Seo/tests`: prima 7 falliti / 91 passati; dopo vedi report della issue #64.

## Fuori scope / da fare

- `Modules/Xot/routes/web_seo.php` e `routes/seo.php` dichiarano anch'esse `/sitemap.xml`: verificare quale rotta vince e togliere il doppione (modulo Xot).
- `docs/docs_master_index.md` e `Modules/Notify/docs/ai-agents/project-docs-index.md` puntano ancora agli indici rimossi.
- Le voci di `index-2.md` che puntavano a file vuoti rimossi sono rimaste come testo semplice: da potare alla prossima revisione.
