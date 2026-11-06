---
title: "BuildSitemapAction dominio Seo — proprietà del modulo"
type: decision
tags: [seo, sitemap, architectural-decision]
status: active
related:
  - sitemap-report-management.md
  - ../../Fixcity/docs/wiki/concepts/sitemap-design-dcp-166.md
confidence: high
created: 2026-10-26
updated: 2026-10-26
qmd: "proprieta modulo BuildSitemapAction sitemap semantica SEO CMS"
sources:
  - "../../Fixcity/docs/wiki/concepts/sitemap-design-dcp-166.md"
  - ../sitemap.md
discussions: []
issues: []
---

# Proprietà del modulo

**Decisione.** `BuildSitemapAction` appartiene a `Modules/Seo`, non a `Modules/Fixcity`.

## Perché

1. **Dominio.** Genera il sitemap di pagine pubbliche; è una questione SEO, non Fixcity.
2. **Dipendenze.** Usa `Cms\Models\Page` (CMS) e `LaravelLocalization` (internazionalizzazione) — anche queste cross-module, ma la funzione è SEO.
3. **Entry point.** La rotta a livello radice è in `laravel/routes/web.php:25` con `BuildSitemapAction::class` diretto — non è un'azione Fixcity.

## Decisione

- Spostare `Modules/Fixcity/app/Actions/BuildSitemapAction.php` → `Modules/Seo/app/Actions/Sitemap/BuildSitemapAction.php`.
- Namespace: `Modules\Fixcity\Actions` → `Modules\Seo\Actions\Sitemap`.
- Riferimenti nella doc Fixcity (commento, DCP-166) si correggeranno qui.
- La rotta radice rimane invariata.

## Variabile chiave per evitare errori ricorrenti

Quando un'azione legge un modello cross-modulo (`Page`, `XotBase*`...) è sempre necessario capire, con `rg -n "use .*"`, chi importa e da dove. Se la classe dipende solo per un `use` meccanico ma il dominio è chiaramente SEO, si sposta nel modulo delle azioni associate al dominio.

## Stato (2026-10-26)

Lo spostamento e' fatto: la classe e' `Modules\Seo\Actions\Sitemap\BuildSitemapAction` (la sottocartella `Sitemap` e' il contesto, come da
`docs/wiki/rules/actions-domain-subfolders.md`) e la rotta `/sitemap.xml` in `laravel/routes/web.php` la richiama.

## Fonti degli URL di dettaglio: contratto e tag (DCP-273)

La sitemap non conosce i modelli degli altri moduli. Le pagine del CMS le legge da `Cms\Models\Page`; gli URL di dettaglio (articoli, eventi,
segnalazioni) li dichiara chi li possiede:

```php
// Modules/<Proprietario>/app/Actions/<Dominio>/Elenca...PathsAction.php
final class ListPublicTicketPathsAction implements SitemapPathsContract
{
    use QueueableAction;

    /** @return list<string> percorsi senza lingua ne' barra iniziale, gia' codificati: 'tickets/35' */
    public function execute(): array { /* stessa query della pagina di dettaglio */ }
}

// Modules/<Proprietario>/app/Providers/<Proprietario>ServiceProvider.php, register()
$this->app->tag([ListPublicTicketPathsAction::class], SitemapPathsContract::TAG);
```

`BuildSitemapAction` legge `app()->tagged(SitemapPathsContract::TAG)`, aggiunge ogni lingua, ordina e toglie i doppioni. La dipendenza va
dal proprietario verso Seo (`Blog -> Seo`, `Fixcity -> Seo`), mai il contrario: il grafo dei moduli resta senza cicli.

**Perche' non la config.** La config di modulo si carica come `Config::set('seo.config', ...)` senza override per tenant: una lista di classi
sarebbe un secondo posto da tenere allineato con il modulo che possiede la fonte.

**Lista di controllo per una nuova fonte** (cosa mi sarebbe servito in DCP-273):

1. Chi serve l'URL? Risolvere la rotta reale (`route:list`, o una richiesta HTTP). Il dettaglio di blog, eventi e segnalazioni lo serve la
   sola pagina Folio del tema `[container0]/[slug0]/index.blade.php`, non le pagine dei moduli (oscurate).
2. La fonte usa la **stessa query** della pagina di dettaglio (non una copia): un URL e' in sitemap se e solo se la sua pagina risponde con
   quel contenuto. Per gli articoli la query e' condivisa in `Blog\View\Composers\Queries\ThemeArticleQueries`.
3. L'insieme e' quello visibile a un **anonimo**, anche se la sitemap la genera un utente loggato (`includeOwnTickets: false`).
4. Prima di escludere una famiglia di URL come «dati personali» si legge la story che l'ha resa pubblica (per `/tickets/{id}` e' DCP-148).
5. Un test parte dalle **liste** del sito, raccoglie i link di dettaglio e controlla che stiano in sitemap (copertura), oltre al test che ogni
   URL in sitemap risponde 200 con il contenuto (precisione). Sta in `Modules/Fixcity/tests/Feature/Pages/SeoLinksTest.php`.

Vedi la story [DCP-273](../stories/dcp-273-sitemap-con-le-pagine-di-dettaglio-di-blog-ed-eventi.story.md).
