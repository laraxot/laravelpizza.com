---
title: "Allineamento visivo con laravelpizza.com"
type: guide
status: active
theme: Meetup
qmd: "visual parity pixel parity confronto laravelpizza.com homepage hero features screenshot playwright footer logo gap analysis dark mode tailwind v4 cache view:clear"
---

# Allineamento visivo con laravelpizza.com

Il tema Meetup nasce come conversione di laravelpizza.com e ne e' la versione migliorata. L'allineamento visivo e' il metodo per non perdere identita' e struttura dell'originale; **non e' un tetto**: dove la nostra pagina e' migliore (menu lingua con effetto vetro, tema chiaro/scuro, animazioni, componenti accessibili) si tiene la nostra, come da [project-purpose](project-purpose.md). Questa pagina raccoglie il metodo di confronto, le lezioni che hanno resistito e gli screenshot di riferimento.

## Come si confronta

1. Avviare il sito locale (`composer dev` da `laravel/`, oppure l'host del tenant) e usare la stessa risoluzione dell'originale.
2. Screenshot "above the fold" di locale e produzione: `npm run screenshots` (`scripts/capture-screenshots.mjs`, Playwright; la home locale usa `LOCAL_URL`, default `http://127.0.0.1:8002/it`) e `npm run screenshots:footer` (`scripts/capture-footer-screenshots.mjs`, solo footer). Alternativa interattiva: browser MCP (Playwright/Chrome DevTools) con `navigate` e `take_screenshot` a pagina intera o su un selettore.
3. Verificare gli asset realmente caricati (CSS/JS dal `manifest.json`, `/themes/Meetup/assets/app-*.css|js`, font) prima di toccare il codice: spesso la differenza e' una build vecchia ([assets-and-build](assets-and-build.md)).
4. Correggere nell'ordine: contenuto nel JSON della pagina (`config/local/laravelpizza/database/content/pages/*.json`), blocco Blade (`resources/views/components/blocks/*`), CSS/JS del tema solo se serve.
5. **Dopo ogni modifica a Blade/view**: `php artisan view:clear` e `php artisan optimize:clear`, poi hard refresh del browser, altrimenti si guarda la versione in cache.
6. Salvare gli screenshot in una cartella di `docs/` solo se servono davvero come riferimento; non accumulare frame datati.

Nota sul riferimento: l'HTML corrente di laravelpizza.com e' servito da un bundle esterno (`/assets/index-*.js|css`, tipo Hostinger Horizons), non da Laravel; il confronto e' quindi solo visivo e di contenuto, mai di pipeline o di dipendenze.

## Pipeline della homepage (stato attuale)

`pages/index.blade.php` (Folio, `name('home')`, `PageSlugMiddleware`) rende `<x-layouts.app>` con `<x-page side="content" slug="home" />` e `<x-page side="sidebar" slug="home" />`. Il contenuto e' `home.json`: blocchi `hero` (`blocks.hero.main`), `events` (`blocks.events.list`), `features` (`blocks.features.grid`), `cta` (`blocks.cta.banner`). Nessun HTML di pagina nella Blade ([cms-json-pages](cms-json-pages.md), [ADR](adr/public-pages-from-json-via-x-page.md)).

## Lezioni che hanno resistito

- **Layout giusto**: la home deve usare il layout pubblico del tema (navigazione in alto, tema scuro, nessuna sidebar da dashboard). Una volta `<x-layouts.app>` si risolveva in un layout con sidebar da pannello e tema chiaro: sintomo = homepage con menu laterale e colori bianchi/zinc. I layout del tema stanno in `resources/views/components/layouts/` ([layouts](layouts.md)).
- **Tailwind v4**: niente classi costruite per interpolazione (`hover:border-{{ $colore }}`): lo scanner non le vede e spariscono nella build. Usare classi complete o mappe di classi. Il colore di sfondo di sezioni "chiare" per errore (es. "Why Join Our Community?") va forzato su `bg-slate-900`/`text-white`/`text-slate-300` se la sezione deve essere scura; il tema supporta chiaro/scuro, quindi ogni sezione ha le varianti `dark:` ([design-system](design-system.md)).
- **Icona hero**: la pizza slice coerente con navbar e footer; il logo e' un file SVG richiamato con `<x-filament::icon icon="meetup-logo">` ([header-footer-logo](header-footer-logo.md), [svg-icons-no-hardcoded-blade](svg-icons-no-hardcoded-blade.md)).
- **Griglia delle feature**: 4 card (`lg:grid-cols-4`) su fondo scuro; i bottoni primari del sito sono `red-600/700` e le azioni Filament sono stilate in `resources/css/custom.css` (`.fi-btn-action`) per tenere il brand coerente fra sito pubblico e pannello.
- **Header/menu**: l'originale ha logo + "Laravel Pizza Meetups", Events, Community Chat, selettore lingua, Login e Sign up; il nostro menu e' un upgrade (vetro, toggle chiaro/scuro) ma i contenuti di navigazione restano allineati. Dettagli in [header-footer-logo](header-footer-logo.md) e [language-switcher](language-switcher.md).
- **Registrazione e dettaglio evento non sono copie 1:1**: hanno elementi in piu' voluti (consensi GDPR, conferma password, iscrizione Livewire, calendario `.ics`). Non allinearli all'originale togliendoli ([register-page](register-page.md), [events-pages](events-pages.md)).
- **Guardare davvero la pagina originale** prima di implementare (snapshot con browser MCP) e non aggiungere o togliere elementi a memoria.

## Screenshot di riferimento in questa cartella

- `visual-analysis/screenshots/prod-home.png` (produzione) e `visual-analysis/screenshots/local-it-home.png` (locale `/it`)
- `visual-analysis/screenshots/event-detail-page.png` (dettaglio evento)
- `visual-analysis/footer/footer-laravelpizza-com.png` e `visual-analysis/footer/footer-locale-it.png` (confronto footer)
- `images/target_state_mockup.png` (mockup dello stato obiettivo)
- altri frame in `visual-analysis/screenshots/` sono catture di sessioni di confronto, senza valore di specifica

![Home produzione](visual-analysis/screenshots/prod-home.png)
![Home locale](visual-analysis/screenshots/local-it-home.png)

## Da verificare

- Il livello di parita' dichiarato dai vecchi report ("95%") e' un'autovalutazione di una singola sessione: rifare il confronto prima di citarlo.
- Dark mode di default: l'originale e' solo scuro, il nostro tema e' commutabile; se si vuole parita' assoluta va forzata la classe `dark` sull'elemento `html` di default.

## Vedi anche

- [design-system](design-system.md), [layouts](layouts.md), [assets-and-build](assets-and-build.md)
- [testing](testing.md) — audit del front office e screenshot
- [roadmap](roadmap.md)
