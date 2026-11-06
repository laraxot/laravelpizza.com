---
id: dcp-274
title: "DCP-274: verifica copertura completa sitemap.xml (ticket + blog + eventi)"
type: story
epic: dc-parity-v2
status: ready
priority: P1
owner: module:Seo
module: Seo
created: 2026-10-26
updated: 2026-11-01
qmd: "verifica sitemap copertura completa ticket blog eventi folio generico dcp-166 dcp-273"
related: [dcp-166, dcp-273, dcp-272]
---

# DCP-274: Verifica copertura completa sitemap.xml

## Contesto
`dcp-166` ha implementato `sitemap.xml`, `canonical`, `hreflang`. `dcp-273` ha definito il contratto `SitemapPathsContract` per i dettagli (blog, eventi, ticket). Questo task verifica che **tutto** sia incluso nella pratica.

## Storia utente
Come motore di ricerca, voglio trovare in `sitemap.xml` **tutte** le pagine pubbliche (CMS, blog, eventi, ticket) così da indicizzarle correttamente.

## Criteri di accettazione
- [ ] `curl /sitemap.xml` → 200, XML valido
- [ ] Contiene almeno una URL `tickets/{id}` (es. `/it/tickets/35` se pubblico)
- [ ] Contiene almeno una URL `blog/{slug}` e `events/{slug}` (se articoli/eventi pubblicati)
- [ ] `robots.txt` cita `Sitemap: https://.../sitemap.xml` (DCP-155)
- [ ] `lg-design-scan.py` → 0 errori per sitemap, canonical, hreflang

## Verifica data-level (se fallisce AC sopra)
1. `php artisan tinker`:
   ```php
   $t = Ticket::find(35); echo $t->location ? 'ok' : 'NULL'; echo $t->status->value;
   ```
   Se `location` NULL o `status` non in `canViewByAll()` → ticket non pubblico, corretto che non sia in sitemap.
2. `ThemeArticleQueries::publishedPostSlugs()` → vuoto? Allora nessun post pubblicato, corretto.
3. `app()->tagged('seo.sitemap.paths')` include `ListPublicTicketPathsAction` e `ListPublishedArticlePathsAction`?

## Test esistenti
`Modules/Fixcity/tests/Feature/Pages/SeoLinksTest.php`:
- `test_sitemap_contains_public_ticket_details` (line 177)
- `test_sitemap_contains_blog_and_event_details` (line 260)
- `test_sitemap_urls_respond_200_with_content` (line 290)

## Note implementazione
Nessun nuovo codice. Solo verifica dati e conferma test verdi. Se dati non pubblici, creare contenuto di test o accettare che sitemap sia corretta per il dataset corrente.

## Cause e correzioni nel modulo (indipendenti dal sito)

Verificate su un'installazione dove `/sitemap.xml` rispondeva 404. Le misure del singolo sito (numero di URL, alias, pagine del tema) stanno nei docs del progetto che lo ospita, non qui: questo modulo e' condiviso.

- `SeoServiceProvider` e `Seo\Providers\RouteServiceProvider` devono definire `$module_dir` e `$module_ns`: senza, `XotBaseServiceProvider` registra il `RouteServiceProvider` di Xot e le `routes/web.php` di Seo non si caricano mai.
- `routes/web.php` registra `GET /sitemap.xml` (`seo.sitemap`) e `GET /robots.txt` (`seo.robots`) con la sintassi `[Classe::class, '__invoke']`: la sola classe, dentro il gruppo con `namespace()` del provider, viene prefissata e lancia «Invalid route action».
- `Actions/Robots/BuildRobotsTxtAction` chiude in ogni lingua i segmenti riservati e `/admin`, e scrive la riga `Sitemap:`. `PRIVATE_SEGMENTS` deve restare un sottoinsieme di `Cms\Actions\Head\ResolveRobotsPolicyAction::HIDDEN_SEGMENTS` (lo verifica `RobotsSegmentsMatchHeadPolicyTest`). `BuildRobotsTxtActionTest` e' scritto ma non eseguito: usa il TestCase di Seo, che richiede un database.
- `BuildSitemapAction` elenca per ogni pagina solo le lingue con titolo scritto (stessa regola di `Cms\View\Components\Head`) e scarta le URL che `ResolveRobotsPolicyAction::isIndexable()` considera non indicizzabili; gli hreflang collegano solo le lingue elencate e `x-default` compare solo se la lingua predefinita e' fra quelle. Le URL di dettaglio dei moduli (`SitemapPathsContract`) restano senza restrizione di lingua. Dipendenza da sapere: se `ResolveRobotsPolicyAction` viene rinominata o spostata, `/sitemap.xml` risponde 500. `Cms` e' nell'elenco ammesso da `SitemapOwnershipTest`.
- Non verificato qui: le AC sui ticket (richiedono un modulo di dominio che registri una fonte `SitemapPathsContract`) e il contenuto delle URL di dettaglio oltre lo stato 200.
