---
title: "DCP-273 - La sitemap include le pagine di dettaglio di blog, eventi e segnalazioni"
type: story
status: done
updated: 2026-10-26
tags: [docs, seo, sitemap, blog, events, tickets, folio, search-console, bmad, ponytail]
qmd: "dcp 273 sitemap.xml articoli blog eventi segnalazioni tickets dettaglio Article content_type SitemapPathsContract tag folio container0 slug0 soft-404 view template"
related:
  - ../../../Fixcity/docs/stories/dcp-272-sitemap-coerente-con-robots-e-senza-redirect.story.md
  - ../bmad/architecture-sitemap-ownership.md
---

# DCP-273 - La sitemap include le pagine di dettaglio di blog, eventi e segnalazioni

**Stato:** done per il perimetro sotto; restano i punti elencati in «Non verificato» e «Segnalazioni fuori perimetro».

Richieste dell'utente (2026-10-26):

1. «nella sitemap.xml manca http://192.168.1.40:8001/it/blog/una-segnalazione-utile-inizia-da-tre-informazioni, percio' devi migliorare,
   capire la fonte del tuo errore, correggerla, capire come non fare mai piu' errori simili».
2. «il percorso folio per il post del blog e' e deve essere `laravel/Themes/Sixteen/resources/views/pages/[container0]/[slug0]/index.blade.php`,
   cerca di capire il perche', il senso».
3. «nel sitemap.xml mancano anche i ticket come per esempio manca http://192.168.1.40:8000/it/tickets/35 e la sua blade per folio e', e deve essere
   `[container0]/[slug0]/index.blade.php`».

## Fatti misurati prima di toccare il codice

- L'URL esiste: risponde 200 in it, en, de, es (stesso slug, lo slug di `Article` non e' traducibile).
- La sitemap viva (porta 8001) aveva 72 URL; del blog c'erano `/it/blog` e `/it/blog/view`, nessun articolo.
- Nel DB di sviluppo: 10 post e 5 eventi tutti pubblicati (15 x 4 lingue = 60 URL mancanti); 11 segnalazioni pubbliche su 18.
- **Le pagine di dettaglio le serve una sola pagina Folio**, `Themes/Sixteen/resources/views/pages/[container0]/[slug0]/index.blade.php`
  (route name `container0.view`). Per `blog` ed `events` chiama `Cms\ResolvePageAction`, che chiede al `Blog\ThemeComposer`
  `findPublishedPostBySlug` / `findPublishedEventBySlug`. Per `tickets` con slug numerico usa `$specialPage = 'ticket-detail'` e
  `Fixcity\BuildPublicTicketDetailAction` (404 se non visibile).
- Le pagine `Modules/Blog/resources/views/pages/blog/[slug].blade.php` e `events/[slug].blade.php` (route name `blog.show`, `events.show`)
  sono **oscurate** dal tema e non vanno cancellate: `route('events.show', ...)` e' usata da due template del tema
  (`pages/comune/homepage.blade.php:111`, `templates/home.blade.php:158`).
- `services` non ha modello ne' record (solo il template `services/view`); `profile` e' una pagina personale e resta fuori.

## Causa

1. **La sola fonte della sitemap era la tabella `pages` del CMS.** I contenuti con URL proprio (articoli, eventi, segnalazioni) stanno in altre
   tabelle e non venivano mai letti.
2. **Ho misurato la precisione e mai la copertura.** In DCP-272 ho verificato che ogni URL in sitemap fosse buono (non bloccato da robots, non
   reindirizzato), non che ogni URL indicizzabile del sito fosse in sitemap. La verifica mancante: partire dalle liste del sito (`/it/blog`,
   `/it/events`), raccogliere i link di dettaglio e controllare che stiano tutti nella sitemap. Ora e' un test permanente.
3. **Le pagine `*.view` sono template, non contenuti.** `blog.view`, `events.view`, `services.view` stavano in sitemap come `/it/blog/view`.
4. **Ho escluso `/tickets/{id}` come «dati personali» senza leggere `BuildPublicTicketDetailAction` ne' DCP-148.** La pagina e' pubblica per
   scelta (come l'elenco, DCP-104). Un'ipotesi non verificata e' diventata una decisione: e' lo stesso difetto del punto 2 (assunzione al posto
   di una misura), ripetuto sulla fonte successiva.
5. **Avevo letto il percorso Folio dei contenuti dal posto sbagliato.** Il rendering di dettaglio non sta nei moduli: sta in un'unica pagina del
   tema. Prima di dire «questa pagina non esiste / non e' servita» si risolve l'URL con la rotta reale (`php artisan route:list`, o una richiesta
   HTTP), non leggendo le cartelle `pages` dei moduli.

## Decisioni

- **Seo non importa Blog ne' Fixcity.** Il proprietario di un codice lo decide il dominio e chi dichiara la dipendenza, non la posizione del file.
  Seo definisce `Modules\Seo\Contracts\SitemapPathsContract` (`TAG = 'seo.sitemap.paths'`, `execute(): list<string>` con percorsi senza lingua).
  Il modulo proprietario registra la sua fonte nel `register()` del proprio provider con
  `$this->app->tag([Fonte::class], SitemapPathsContract::TAG)`; `BuildSitemapAction` legge `app()->tagged(...)`. La dipendenza va
  proprietario -> Seo e il grafo resta senza cicli.
- **Perche' i tag e non la config.** La config di modulo si carica come `Config::set('seo.config', ...)` senza override per tenant: una lista di
  classi li' sarebbe un secondo posto da tenere allineato. Il tag e' dichiarato dove sta la fonte.
- `Blog\Actions\Article\ListPublishedArticlePathsAction` usa le stesse query di `findPublished*BySlug` (ora condivise in
  `ThemeArticleQueries::publishedPostsQuery()` / `publishedEventsQuery()`), cosi' un URL e' in sitemap se e solo se la sua pagina risponde con
  quel contenuto. SQL invariato.
- `Fixcity\Actions\Ticket\ListPublicTicketPathsAction` parte da `BuildPublicTicketsQueryAction::execute(includeOwnTickets: false)`:
  l'insieme e' quello visibile a un anonimo anche quando la sitemap la genera un utente loggato (il futuro pulsante del back office).
- Le pagine CMS il cui slug finisce in `.view` non vanno in sitemap.
- Niente `lastmod` (come in DCP-272).
- Il test Fixcity ora transa anche la connessione `blog` (prima gli articoli di prova restavano nel DB: `articles.title` e' unico).

## Verifica

Output reali del 2026-10-26, DB di prova (`bashscripts/tools/pest-scratch-db.sh`), mai il DB di sviluppo:

- `SeoLinksTest` + `TicketPublicDetailPageTest`: **33 passed (419 assertions)**, wrapper con exit 0.
- Test nuovi in `SeoLinksTest` (7): elenca post, eventi e segnalazioni in 4 lingue; ogni link di dettaglio mostrato da `/it/blog` e
  `/it/events` e' in sitemap (guardia di copertura); mai post programmati, bozze, template, segnalazioni non pubbliche (nemmeno se la
  sitemap la genera il proprietario); ogni URL di dettaglio in sitemap risponde 200 e mostra il titolo.
- **Sito vivo, 2026-10-26** (`curl http://192.168.1.40:8000|8001/sitemap.xml`, entrambe 200, 102433 byte): **164 URL** (41 percorsi x 4 lingue; erano 72).
  Contiene `/it/tickets/35` (nel DB di sviluppo e' `resolved`, con posizione: uno degli 11 pubblici, id 29..39) e
  `/it/blog/una-segnalazione-utile-inizia-da-tre-informazioni`; non contiene piu' `/blog/view`. Sono i due esempi dell'utente.
- Guardia di proprieta' `Modules/Seo/tests/Unit/Architecture/SitemapOwnershipTest.php` (2 test): `Spatie\Sitemap` e `BuildSitemapAction` esistono solo in
  `Modules/Seo`; Seo importa solo i moduli Seo, Xot e Cms (misurato). **Prova inversa:** con un file `class BuildSitemapAction` messo per pochi
  secondi in `Modules/Blog/app` il test e' diventato rosso (`1 failed, 1 passed`) nominando quel file; tolto il file, `2 passed`.
- Lo strumento di prova aveva un difetto che la prova inversa ha mostrato: `bashscripts/tools/pest-scratch-db.sh` con `PEST_OUT=` usciva con 0
  anche con un test rosso (l'ultimo comando era il `grep`). Corretto: ora restituisce l'exit di Pest, misurato rosso = 1 e verde = 0.
- PHPStan (config unica `laravel/phpstan.neon`) sui 6 file di produzione e sui test: **0 errori**, exit 0. Nessun `@phpstan-ignore`, nessun
  cast per silenziare: `sitemapPathOf()` restringe il tipo con `is_string`.

## Non verificato

- Produzione gira sullo stato committato: gli effetti arrivano solo dopo commit, push e deploy. Non misurata.
- Search Console: il server MCP `gsc` non e' connesso, quindi nulla e' stato inviato a Google.
- La scrittura di `public_html/sitemap.xml` e il pulsante del back office sono del lavoro in corso della sessione parallela (widget Seo).

## Segnalazioni fuori perimetro (non corrette qui, da decidere)

1. **Soft-404 sui contenuti inesistenti.** `/it/blog/slug-che-non-esiste` risponde 200 con il titolo «Novita'» perche' la pagina Folio del tema
   ripiega sul template CMS `blog.view`. Vale anche per `/events/...`. Per un motore di ricerca e' una pagina vuota con codice 200. La correzione
   tocca `Cms\ResolvePageAction` e la pagina Folio del tema (file condivisi): proposta come story a parte.
2. **10 test Blog gia' rossi.** `Tests\Feature\Modules\Blog\BlogFrontOfficeNovitaTest` e `BlogFrontOfficeEventsTest` falliscono con
   `Duplicate entry '' for key 'PRIMARY'` in `DemoContentSeeder.php:28` (`Category::firstOrCreate`): la tabella `categories` ha `id`
   `varchar(191)` senza default e il modello inserisce senza `id`, quindi la seconda categoria collide. Lo stack non passa da nessun file toccato
   da questa story (git status del repo Blog: solo i miei 3 file). Causa probabile: il modulo Blog e il modulo Fixcity definiscono due forme
   diverse di `categories` (Blog: `id()` + `title`; reale: chiave stringa + `name`). Da risolvere con una decisione sul proprietario della tabella.
3. `BuildSitemapAction` ha ancora `NOT_INDEXABLE` con slug di Fixcity nel codice di Seo e costruisce gli URL dall'host della richiesta invece
   che da `config('app.url')`: entrambi sono prerequisiti del file statico, sul lavoro della sessione parallela.
