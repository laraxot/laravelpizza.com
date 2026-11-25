---
title: "Seo: architettura"
type: architecture
status: active
module: Seo
tags: [seo, architettura, actions, adapters, contratti]
qmd: "seo architettura actions adapters datas contracts facade metatag sitemap robots indexnow middleware canonical filament dipendenze"
related:
  - ./metatag.md
  - ./configuration.md
  - ./adr/search-engine-presence.md
  - ./adr/sitemap-built-in-seo-fed-by-tagged-sources.md
  - ./adr/robots-disallow-subset-of-head-noindex.md
---

# Seo: architettura

Seo rende trovabile il sito: sitemap e `robots.txt` dinamici, redirect canonici, metatag della pagina, link di
condivisione social, notifica IndexNow. Non ha modelli Eloquent e non ha migrazioni: lo stato che serve vive per
richiesta (metatag) oppure nel file di configurazione del tenant (`SeoConfigData`).

## Confini

- `module.json` dichiara `requires: Xot, Cms`. Il codice di `app/` importa solo `Modules\Seo`, `Modules\Xot` e
  `Modules\Cms`: lo impone `tests/Unit/Architecture/SitemapOwnershipTest.php`. Allungare la lista e' una decisione di
  architettura, non una comodita'.
- Seo non conosce i modelli dei moduli che lo usano. Un modulo con pagine di dettaglio da indicizzare implementa
  `SitemapPathsContract` e si registra col tag `SitemapPathsContract::TAG` (`seo.sitemap.paths`) nel proprio service
  provider: vedi [ADR sitemap](./adr/sitemap-built-in-seo-fed-by-tagged-sources.md).
- L'esclusione dall'indice e' del `<head>` (`noindex`, deciso da Cms `ResolveRobotsPolicyAction`); `robots.txt` chiude
  solo un sottoinsieme di quelle aree: vedi [ADR robots](./adr/robots-disallow-subset-of-head-noindex.md).

## Livelli del codice (`app/`)

| Cartella | Contenuto | Regola |
|----------|-----------|--------|
| `Actions/Metatag/` | `GetMetatagDataAction`, `MergeMetatagDataAction`, `ReplaceMetatagDataAction` | operazioni sullo stato dei metatag, vedi [metatag.md](./metatag.md) |
| `Actions/Sitemap/` | `BuildSitemapAction` (rotta `seo.sitemap`) | XML costruito dall'Action, `<lastmod>` solo se la sorgente ha una data vera |
| `Actions/Robots/` | `BuildRobotsTxtAction` (rotta `seo.robots`) | `Disallow` per `PRIVATE_SEGMENTS` in ogni lingua + `/admin`, `Sitemap:` assoluta |
| `Actions/IndexNow/` | `SubmitIndexNowAction`, `ServeIndexNowKeyAction` (rotta `seo.indexnow.key`) | contratti in [contracts/](./contracts/README.md) |
| `Actions/Url/` | `NormalizeLocalizedPathAction`, `ResolvePathAliasAction` | forma canonica dell'URL, usate dal middleware |
| `Actions/GenerateSocialShareLinksAction.php` | URL di condivisione | vedi [social-share.md](./social-share.md) |
| `Adapters/` | `MetatagFacadeAdapter`, `MetatagState` | coordinatore con stato per richiesta (singleton) |
| `Datas/` | `MetatagData`, `SeoConfigData`, `SocialShareData` | Spatie Laravel Data, cartella `Datas/` (non `Data/`) |
| `Contracts/` | `MetatagDataContract`, `SitemapPathsContract`, `SitemapLastModifiedContract` | suffisso `Contract`, mai `Interfaces/` |
| `Facades/Metatag.php` | API dei setter | punta a `MetatagFacadeAdapter` |
| `Http/Middleware/RedirectToCanonicalPath.php` | 301 alla forma canonica | middleware globale, vedi sotto |
| `Console/Commands/` | `seo:robots`, `seo:indexnow` | vedi [configuration.md](./configuration.md) |
| `Filament/` | `Dashboard`, `SettingPage`, widget `GenerateSitemapWidget` e `SocialShareWidget` | tutte le classi estendono `XotBase*`, mai `Filament\*` direttamente |
| `Providers/` | `SeoServiceProvider`, `RouteServiceProvider`, `EventServiceProvider`, `Filament/AdminPanelProvider` | provider minimale su `XotBaseServiceProvider` |

Residui storici nel codice: `app/Services/MetatagService.php.bak` e `app/Interfaces/MetatagDataInterface.php.bak`
(file rinominati, mai cancellati con `git rm`; nessun codice attivo li usa).

## Regole di costruzione

- **Niente `app/Services/` ne' `app/Support/`.** Logica senza stato = Action (`QueueableAction`, un solo `execute()`).
  Un coordinatore di facade con stato per richiesta non e' una Action: sta in `Adapters/`. E' la ragione per cui
  `MetatagService` e' diventato `MetatagFacadeAdapter` + `MetatagState` + tre Action.
- **Contratti** in `app/Contracts/` con suffisso `Contract`. Un'interfaccia "capacita'" (verbo/predicato) non porta il
  suffisso ma vive comunque in `Contracts/`. Solo le capacita' puramente Eloquent stanno in `Models/Contracts/`
  (raro in Seo). Quando il contratto appartiene a un altro modulo si usa quello, non se ne duplica uno.
- **Mai estendere `Filament\*`**: si estende lo specchio `Modules\Xot\Filament\...\XotBase*` allo stesso percorso
  relativo; se manca, si crea in Xot prima, mai come scorciatoia nel modulo.
- Alias e chiave IndexNow sono impostazioni del tenant (`SeoConfigData`), non costanti del codice.

## Redirect canonico

`SeoServiceProvider::boot()` antepone `RedirectToCanonicalPath` al kernel HTTP (non al router: il kernel risincronizza
il router a ogni richiesta, e il middleware deve agire prima della ricerca della rotta). Solo GET e HEAD. Una sola
risposta 301 anche quando le regole si sommano (`/IT/faqs/` -> `/it/faq`): prima `NormalizeLocalizedPathAction`
(lingua minuscola, niente doppio slash ne' slash finale), poi `ResolvePathAliasAction` (alias di pagina nella stessa
lingua). La query string resta com'era. Le lingue sono quelle di `config('laravellocalization.supportedLocales')`.

## Dipendenze e composer

- `Modules/Seo/composer.json` richiede `spatie/laravel-sitemap ^8.2`; `BuildSitemapAction` pero' costruisce l'XML da se' e
  non importa `Spatie\Sitemap`. Le dipendenze del dominio si dichiarano nel `composer.json` del modulo, mai in quello
  della radice: il plugin merge di nwidart unisce solo `Modules/*/composer.json` (mai `Themes/*/composer.json`).
- La sitemap si basa sulle pagine CMS (`Modules\Cms\Models\Page`) e sulle lingue di mcamara/laravel-localization.

## Principi

- *I metadati sono SEO gratis: si automatizzano.* Ogni pagina dichiara titolo, descrizione e tipo; l'autore non deve
  conoscere SEO.
- *Una URL per concetto.* La canonicalizzazione (redirect 301 + alias) evita la diluizione: la dichiarazione e'
  vincolante, non un suggerimento.
- *Lo stato dei metatag e' per richiesta, non persistente*: per questo non ci sono modelli. Un DTO tipizzato
  (`MetatagData`, Wireable per Livewire) basta, senza tabella ne' query.
