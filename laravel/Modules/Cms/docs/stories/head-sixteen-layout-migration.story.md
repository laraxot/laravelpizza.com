---
title: "[STORY] Head SEO del tema Sixteen sul componente Cms"
type: story
module: Cms
status: in-progress
priority: high
created: 2026-11-11
updated: 2026-11-11
tags: [bmad, ecc, seo, head, laravel-head, theme-sixteen, migration, parity]
related:
  - "head-sixteen-parity-closeout.story.md"
  - "../seo-head-architecture.md"
  - "seo-head-component.story.md"
  - "../../../../Themes/Sixteen/docs/stories/auth-components-regression-restore.story.md"
issues: []
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/93", "https://github.com/laraxot/theme_sixteen_fila5/discussions/95"]
---

# [STORY] Head SEO del tema Sixteen sul componente Cms

**Discussioni:** [#93](https://github.com/laraxot/theme_sixteen_fila5/discussions/93) (decisioni D-1..D-7 della migrazione) · [#95](https://github.com/laraxot/theme_sixteen_fila5/discussions/95) (diff di parità misurato su 128 URL e decisioni dell'audit anonimo; la D-7 resta aperta lì e qui).

## Scopo

Sostituire l'`<head>` HTML scritto a mano nel layout principale del tema Sixteen
con il componente `<x-cms::head>` (modulo Cms, già basato su `laravel/head`),
mantenendo **la stessa visualizzazione** e senza perdere nessuna funzionalità SEO
o di boot già presente. Il layout resta responsabile solo del body e degli stack;
tutto il markup `<head>` diventa responsabilità del modulo Cms, come già avviene
per il tema Two (`Themes/Two/resources/views/layouts/base.blade.php`).

Richiesta utente: «al posto di [head inline] dobbiamo utilizzare il componente
Head del modulo Cms, e dentro il componente Head del modulo Cms dobbiamo
utilizzare al meglio laravel/head, mantenere la stessa visualizzazione».

## Perché (il senso)

Oggi il FO ha **quattro teste diverse** e la SEO è duplicata:

| File | Stato | Note |
|---|---|---|
| `Themes/Sixteen/resources/views/components/layouts/main.blade.php` | da migrare | head completo: meta, OG, Twitter, JSON-LD home, canonical/hreflang via `x-layouts.seo-links`, FOUC guard, bootstrap Alpine `mobileMenu`, dark-mode, Vite, Livewire/Filament styles |
| `components/layouts/auth.blade.php` | da valutare | head AGID diverso (theme-color `#0066CC`, `noindex,nofollow`, CSS custom) — prop `themeColor` esiste, robots noindex coperto dalla policy Cms per path `auth/*` |
| `mobile/layout.blade.php` | da valutare | head minimale PWA (theme-color, apple-mobile-web-app) — shell mobile, probabilmente fuori scope |
| `offline.blade.php` | da escludere | deve funzionare offline: usa `asset()` e non può dipendere dal rendering Vite/Cms |

Tutti i layout pubblici convergono su `layouts.main` (`components/layouts/app`,
`app01`, `test`, `design-comuni-bare`, `layouts/app` lo wrappano), quindi
**un solo punto di cambiamento** copre home, pagine CMS, listing, area
personale e test.

Il tema ha anche una action SEO propria, `ResolvePageHeadAction`
(DCP-288: titolo con brand, `noindex` su path privati, `og:locale` regionale)
usata solo da `main.blade.php`. Il modulo Cms ha già i resolver equivalenti e
più ricchi (`ComposeDocumentTitleAction`, `ResolveRobotsPolicyAction`,
`ResolveHreflangAlternatesAction`, `ResolvePageDescriptionAction`,
`BuildHeadSchemaAction`). La migrazione elimina una seconda verità SEO.

### Decisione superata da rivedere

`Themes/Sixteen/docs/wiki/concepts/document-shell.md` (decision, 2026-11-09)
recita: «Sixteen **non usa** `<x-cms::head />` / `<x-cms::foot />`: è un tema
autonomo con document shell proprio». La richiesta utente ribalta questa
decisione: Sixteen converge su `cms::head` come TwentyOne, mantenendo body e
stack propri. In fase 4 il doc va riscritto come decisione revisionata
(motivazione: SSoT SEO in Cms, `laravel/head`, parità già garantita dai
resolver del modulo) — non cancellato: la storia delle decisioni resta.

## Cosa fa il componente Cms oggi (verificato nel codice)

`Modules/Cms/app/View/Components/Head.php` + `resources/views/components/head.blade.php`:

- titolo con brand (`ComposeDocumentTitleAction`), description (prop → pagina CMS → sito → meta), robots policy, OG/Twitter (`summary_large_image` se immagine social), canonical, hreflang alternates, JSON-LD (`Organization`+`WebSite` home, entità pagina+`BreadcrumbList` interne), favicon/apple-touch/manifest, theme-color (prop `themeColor`, default `#0f2b46`), `@head` di laravel/head, csrf-token, `[x-cloak]`, dark-mode boot, `@livewireStyles`/`@filamentStyles`, `@vite` theme-aware (`themes/{pubTheme}`), `@stack('head')`/`@stack('styles')`.
- Registrato come `<x-cms::head>` (`CmsServiceProvider`).

## Gap di parità da chiudere prima/durante l'implementazione

1. **`?page=N` nel canonical/hreflang** — REGRESSIONE reale: `x-layouts.seo-links`
   preserva `?page=2` nel canonical e nelle alternate (FO-6-25, DCP-288: ogni
   pagina di elenco è una pagina a sé). `Head::canonicalUrl()` usa solo
   `request()->path()` e perde la query. → Estendere il resolver Cms
   (`canonicalUrl`/`ResolveHreflangAlternatesAction`) per conservare il solo
   parametro `page` (intero ≥2), oppure verificare che `ResolveCmsPageAction`
   copra già il caso. Cambia codice del modulo Cms: serve story/test nel modulo.
2. **theme-color** — Sixteen usa `#007a52` (main/mobile) vs default Cms
   `#0f2b46`. → passare `theme-color="#007a52"` (prop esistente).
3. **FOUC guard `#sixteen-critical-fouc`** — CSS critico anti-trasparenza
   hero, specifico del tema. → spostare in `@push('head')` (lo stack esiste
   nella view `cms::components.head`, dopo Vite: le regole `!important`
   restano efficaci).
4. **Bootstrap Alpine `mobileMenu`** — listener `alpine:init` inline nel
   `<head>`; deve restare dentro `<head>` prima del body. → `@push('head')`.
5. **Dark-mode script e `[x-cloak]`** — già duplicati nella view Cms: rimuovere
   le copie dal layout Sixteen (DRY).
6. **Title/description/robots** — verificare parità output tra
   `ResolvePageHeadAction` e i resolver Cms su: home, pagina CMS, `auth/*`,
   `area-personale/*`, `tests/*`, `tickets/*`, `?page=2`. Se il Cms produce
   titoli/robots diversi ma corretti, la SSoT diventa il Cms (documentare la
   divergenza nel report). `ResolvePageHeadAction` + `PageHeadData` +
   `ResolvePageHeadActionTest` diventano dead code → rimozione in fase 2
   (forward-only, con test aggiornati).
7. **`auth.blade.php`** — head AGID distinto; valutare se `<x-cms::head>` con
   prop appropriate basta o se il layout resta custom (è `noindex` comunque).
   Decisione registrata nella story, non bloccante per la fase 1.
8. **`mobile/layout` / `offline`** — fuori scope fase 1 (documentare perché).

## Piano di implementazione (fasi)

- **Fase 0 — docs (questa story)**: inventario, gap, criteri di parità.
- **Fase 1 — Cms**: estendere canonical/hreflang con `?page` (se serve) + test
  Pest nel modulo; nessuna breaking change per Two.
- **Fase 2 — Sixteen**: `layouts/main.blade.php` emette
  `<x-layouts.main>` → dentro, `<x-cms::head :title="$title" :description="$description" :homepage="$bodyPage === 'homepage'" theme-color="#007a52" />`
  + `@push('head')` per FOUC guard e bootstrap Alpine; rimozione del markup SEO
  duplicato e di `ResolvePageHeadAction` se dead.
- **Fase 3 — verifica parità**: screenshot/DOM diff di `<head>` prima/dopo su
  pagine rappresentative via Playwright/Puppeteer; curl sweep status code;
  Pest mirati; `view:cache` exit 0; PHPStan zero.
- **Fase 4 — docs**: aggiornare `seo-head-architecture.md` (sezione adozione
  Sixteen), docs del tema (`document-shell.md`, wiki concepts), README modulare
  se richiesto; registrare nel report le divergenze volute.

## Verifica (acceptance)

- [ ] `php artisan view:cache` exit 0
- [ ] `curl` 200 su: `/it`, `/it/accessibilita`, una pagina CMS interna,
      una listing `?page=2`, `/it/auth/login`, `/it/tests`, una pagina
      `area-personale` (login)
- [ ] `<head>` renderizzato contiene: un solo title, description, robots
      corretti per path privato, canonical + hreflang (con `?page` preservato),
      OG/Twitter, theme-color `#007a52`, JSON-LD homepage, favicon/manifest se presenti
- [ ] Nessun tag SEO duplicato (`canonical`, `og:*`, `twitter:*`, `title`)
- [ ] Dark mode, FOUC guard, menu mobile Alpine funzionanti (Playwright)
- [ ] Pest: test Cms per `?page` canonical; test Sixteen aggiornati;
      PHPStan zero errori
- [ ] Parità visiva: nessuna differenza di rendering body (solo `<head>` cambia)
- [ ] `Themes/Sixteen/docs/wiki/concepts/document-shell.md` aggiornato come
      decisione revisionata; `seo-head-architecture.md` con sezione adozione
      Sixteen

## Non-obiettivi

- Non si toccano `offline.blade.php` e `mobile/layout.blade.php` in fase 1.
- Non si installano pacchetti nuovi (`laravel/head` è già nel composer.lock).
- Non si cambia il design/visualizzazione: solo la provenienza del markup head.
- Non si migra il backoffice Filament (ha il suo head).

## Contesto agenti

- BMAD: questa story in `Modules/Cms/docs/stories/` (owner del componente).
- ECC: gate PTVX — Pest mirati + PHPStan zero + `view:cache` exit 0; lock sulle
  cartelle `Modules/Cms` e `Themes/Sixteen` durante l'implementazione.
- Second brain: initiative Hindsight `kp-8acd5914cdc14a178e18f52d8f8540d8`
  (audit FO produzione) — questo lavoro è un item dell'audit.

---

## Verifica indipendente e misure (seconda sessione, 2026-11-11)

> Sezione aggiunta da una seconda sessione che ha lavorato in parallelo sullo stesso repo. La parte sopra è dell'altra
> sessione e non è stata riscritta: qui si **verifica sul codice e si misura**. Nessun file del repo è stato modificato
> per ottenere queste misure.

**Metodo.** Baseline live (`curl` su `:8000`, 8 URL: `/it`, `/en`, `/it/tickets`, `/it/tickets?page=2`, `/it/auth/login`,
`/it/domande-frequenti`, `/it/tests`, `/it/tickets/track`) → `<head>` estratto e ridotto a una riga per tag. Stesso URL reso
**in-process** con `<x-cms::head>` (titolo e descrizione presi dalla pagina live, `theme-color="#007a52"`, `homepage` su `/it` e
`/en`) e confronto tag per tag. Le regole pure (robots) sono confrontate sugli stessi percorsi, senza HTTP. Script e output grezzi
stanno nello scratchpad della sessione, non versionati.

**Limiti dichiarati.** Il render in-process non ha sessione né route: `request()->route()` è nullo, quindi le regole che
scattano per *nome di rotta* o per slug non si vedono (`HIDDEN_SLUGS`); `csrf-token` esce vuoto; l'host è `fixcity.local` invece
di `:8000` (differenza solo di harness, ignorata nei confronti).

### Cosa la story dice e il codice conferma

- `?page=N` perso dal canonical: **misurato**, `/it/tickets?page=2` → canonical `/it/tickets` (alternate comprese). Regressione reale.
- `theme-color`: con la prop `#007a52` nessuna differenza.
- FOUC guard e `mobileMenu` assenti nel Cms (attesi): lo `<style>` del Cms è di 39 caratteri, solo `[x-cloak]`.
- `og:locale`, `viewport`, `twitter:card`, `og:type`, `og:url`, Vite/Livewire/Filament styles: **identici** sui 4 URL confrontati
  tag per tag (`/it`, `/it/tickets?page=2`, `/it/auth/login`, `/it/tests`). Gli altri 4 baseline (`/en`, `/it/tickets`,
  `/it/domande-frequenti`, `/it/tickets/track`) sono stati resi e usati solo per robots e titolo: il diff completo per tag va
  ripetuto in Fase 3 su tutto il set e sulle 4 lingue.

### Divergenze misurate che la story non elenca

| # | Cosa | Oggi (Sixteen) | Con `cms::head` | Si vede? | Gravità |
|---|------|----------------|-----------------|----------|---------|
| 1 | **Brand «Test»** | `FixCity` | `… — Test` in `<title>`, `og:site_name`, `application-name`, JSON-LD `Organization` | sì, nella scheda del browser | **bloccante** |
| 2 | Separatore del titolo | `Elenco segnalazioni \| FixCity` | `Elenco segnalazioni — FixCity` | sì, nella scheda | alta |
| 3 | Pagine private | `tickets/create`, `tickets/confirmation`, `tickets/track` → `noindex` | indicizzabili a livello di percorso; `tickets/track` confermato `index, follow, max-image-preview:large` nel render completo | no | **alta (privacy/SEO)** |
| 4 | Stringa robots | `noindex,follow`; nessun meta sulle pagine pubbliche | `noindex, follow`; `index, follow, max-image-preview:large` sulle pubbliche | no | media |
| 5 | hreflang | sempre 4 lingue + `x-default` | solo le lingue «scritte» (`/it/tickets`: solo it/en) | no | media |
| 6 | Tag nuovi | — | `link rel=icon`, `application-name`, `csrf-token`, JSON-LD `Organization` (home), `BreadcrumbList` + `WebPage` (interne) | no | bassa |
| 7 | Fallback description | `$description ?: nome app` (`FixCity` su 404 e `/it/tests`) | omessa o descrizione del sito | no | bassa |

**Non è una divergenza ma un buco comune (sweep anonimo, 2026-11-11).** I dettagli di blog ed eventi in `en/de/es`
(12 pagine misurate) hanno il corpo in italiano, `<html lang>` della lingua dell'URL, nessun `robots` e canonical su sé stessi:
sono indicizzabili come duplicati dell'italiano. Con `cms::head` **resterebbe uguale**: `Head.php:67-68` calcola `translated`
solo se la pagina è un `Page` del CMS (`ResolveWrittenLocalesAction`); un dettaglio da modello ha `writtenLocales = null` e quindi
`translated = true`. Non rientra nel criterio «stessa visualizzazione», quindi non si corregge in questa migrazione; va deciso a
parte (tradurre i contenuti, oppure far valutare «tradotto» anche ai dettagli da modello). Nel frattempo il corpo italiano dentro
una pagina `lang="en"` non è marcato `lang="it"` (WCAG 3.1.2, livello AA).

Cause verificate nel codice:

1. `Head::resolveBrand()` prova `pub_theme::header.brand.name` (chiave **assente** in `Themes/Sixteen/lang`), poi
   `MetatagData::getBrandName()` che legge `config/local/fixcity/metatag.php:33` → `'title' => 'Test'` (segnaposto lasciato nel
   tenant). `config('app.name')` è solo il terzo ripiego e non viene raggiunto, perché «Test» non è una stringa vuota. Il layout
   attuale ignora `metatag.php` e usa `config('app.name')` con ripiego `FixCity`. Verificato in CLI (`getBrandName=[Test]`,
   `Lang::has('pub_theme::header.brand.name')=false`); il tenant letto in una richiesta servita è lo stesso `local/fixcity`, ma la
   conferma sotto HTTP resta da fare in Fase 3.
2. `ComposeDocumentTitleAction::SEPARATOR = ' — '`: toglie il brand con qualunque separatore e lo ricompone con `—`.
3. `ResolveRobotsPolicyAction::HIDDEN_SEGMENTS` = `area-personale, auth, coming-soon, dashboard, notifications, preview-content, profile`;
   `HIDDEN_SLUGS` = `tickets.confirmation, segnalazione-dettaglio, segnalazioni.index`. Non ci sono `tickets/create|track`. Matrice
   (percorso → decisione, Sixteen | Cms): `tickets/create` NOINDEX | index; `tickets/confirmation` NOINDEX | index (a livello di
   percorso; il nome rotta potrebbe coprirlo in HTTP, **da verificare**); `tickets/track` NOINDEX | index (**confermato**);
   inverso: `profile/edit` e `dashboard` index | NOINDEX (Cms più prudente, accettabile). Nota: nel Cms sono codificati nomi di un
   dominio specifico (tickets) dentro un modulo generico: l'elenco va reso configurabile, non esteso a mano.

### Rischi tecnici (misurati)

- **R-1 — `@push` dopo `@stack` si perde.** Prova: `@stack('h')` seguito da `@push('h')…` → output vuoto; `@push` prima di
  `@stack` → presente. Nel layout i `@push('head')` per FOUC guard e `mobileMenu` vanno scritti **prima** del tag `<x-cms::head>`.
  I `@push('styles')` fatti dalle pagine nello slot non sono toccati (lo slot si rende prima del layout).
- **R-2 — Più teste, non una.** `layouts/base`, `layouts/guest`, `layouts/test` e `components/layouts/auth` hanno un `<head>` proprio e
  **non** passano da `layouts.main` (grep: 0 occorrenze di `layouts.main`). Resta da misurare quali pagine servite le usano
  (`design-comuni/pages/homepage` estende `layouts.base`, `pages/[container0]/[slug0]` usa `layouts.test` in un ramo). «Tutti i
  layout pubblici convergono su `layouts.main`» è quindi **non provato**; il perimetro va deciso (D-6).
- **R-3 — Riferimento a un tema che non c'è.** Qui i temi sono `Barthelemy`, `Meetup`, `Sixteen`, `TwentyOne`: `Themes/Two` non
  esiste. Il precedente di adozione di `cms::head` è **TwentyOne** (`layouts/base.blade.php:3`, `components/layouts/app.blade.php:5`).
  Lo stesso errore è in `seo-head-architecture.md` e nella story `seo-head-component` (copiate da un altro repo).
- **R-4 — Stesso titolo in tre posti.** `og:title` e `twitter:title` ereditano il separatore: D-2 li cambia tutti insieme.

### Cancelli di verifica: stato misurato (prima di qualunque modifica)

- `ResolvePageHeadActionTest` (unit): **25 verdi**.
- `Feature/Pages/SeoHeadTest` (HTTP, DCP-288, già esistente e **non citato sopra**): **21 rossi / 3 verdi** in baseline. 20 sono
  `404 invece di 200`: le pagine non si risolvono nel kernel di test (ipotesi non verificata: tenant `localhost` di Pest diverso da
  `local/fixcity`); 1 è un'asserzione di stringa. Quindi **non è oggi un cancello di parità utilizzabile**, e non va «aggiustato»
  per far passare il piano. Fissa comunque il contratto da rispettare: titolo con `|`, `noindex,follow` esatto, nessun meta robots
  e nessun `link rel~=icon` sulle pagine pubbliche, `?page` nel canonical.
- Cancello scelto: confronto HTTP reale su `:8000` (diff per tag, più `view:cache` e `curl` 200 sul set sotto) + Pest nel modulo Cms
  con `Blade::render('<x-cms::head …>')` per le regole pure (robots, titolo, canonical con `?page`). I test del tema che pinnano
  la forma vecchia si aggiornano **solo dopo** la decisione corrispondente, mai per convenienza.

### Decisioni aperte (proposta in grassetto; decide il PO/utente)

| ID | Decisione | Proposta |
|----|-----------|----------|
| D-1 | Origine del brand | **Chiave `header.brand.name` = `FixCity` in `Themes/Sixteen/lang/{it,en,de,es}/header.php` + correggere `'Test'` in `config/local/fixcity/metatag.php`** (prerequisito di ogni altra fase) |
| D-2 | Separatore titolo | **Tenere `\|` (richiesta: «stessa visualizzazione»; pinnato dai test)**, reso configurabile nel Cms; `—` solo se il PO lo vuole |
| D-3 | Percorsi `noindex` del progetto | **Elenco configurabile** (config del tenant o prop del componente), default invariato; niente nomi di dominio nel codice generico del Cms |
| D-4 | Robots sulle pagine pubbliche | **Accettare `index, follow, max-image-preview:large`** (più informativo) e aggiornare `SeoHeadTest` solo dopo il sì; alternativa: prop per ometterlo |
| D-5 | hreflang | **«Solo lingue scritte»** (Cms): corretto per la SEO, ma cambia l'output e il test |
| D-6 | Perimetro layout | **Fase 1 solo `layouts.main`**; `base`/`guest`/`test`/`auth` dopo averne misurato l'uso reale |

### Piano rivisto

- **Fase 0 — docs e misure:** fatta (questa sezione, più documenti collegati sotto).
- **Fase 1 — prerequisiti** (nel modulo Cms e nei dati del tema, con test Pest nel modulo): D-1, canonical/hreflang con `?page`, D-2, D-3.
  Nessuna modifica ai layout finché i test Cms non sono verdi.
- **Fase 2 — `layouts/main.blade.php`:** `@push('head')` **prima** di `<x-cms::head>` (R-1); props `title`, `description`,
  `homepage`, `theme-color`; rimozione dei duplicati; `ResolvePageHeadAction`, `PageHeadData` e il suo test si ritirano solo quando
  esiste l'equivalente nel Cms.
- **Fase 3 — parità:** diff dei `<head>` su 8+ URL × 4 lingue + 404; screenshot prima/dopo con Puppeteer (desktop e mobile, tema
  chiaro e scuro) e confronto; console senza errori; Livewire e `mobileMenu` funzionanti; `view:cache` exit 0; PHPStan zero.
- **Fase 4 — docs:** `document-shell.md` (decisione rivista, non cancellata), `seo-head-architecture.md` (adozione per tema,
  «Two» → TwentyOne), indice docs del tema e del modulo.

**Criterio di accettazione aggiuntivo:** l'unica differenza ammessa nel diff dei `<head>` è l'insieme delle decisioni D-1…D-6
approvate; qualunque altra differenza è un difetto.

---

## Decisioni del PO (2026-11-11, seconda sessione)

| ID | Decisione | Esito |
|----|-----------|-------|
| D-1 | Origine del brand | **Approvata**: `header.brand.name` = `FixCity` in `Themes/Sixteen/lang/{it,en,de,es}/header.php` **e** fix `'Test'` → `FixCity` in `config/local/fixcity/metatag.php` |
| D-2 | Separatore titolo | **Approvato `|`**: reso configurabile nel Cms (config/prop), Sixteen lo imposta a `|`; i test pinnati restano validi |
| D-3 | Percorsi `noindex` | **Approvato elenco configurabile**: niente nomi di dominio nel codice generico; gli slug `tickets.*` del progetto vanno in config del tenant/prop |
| D-4 | Robots pubbliche | **Approvato output Cms** (`index, follow, max-image-preview:large`); `SeoHeadTest` si aggiorna dopo, documentando la divergenza |
| D-5 | hreflang | **Approvato «solo lingue scritte»**; aggiornamento test dopo |
| D-6 | Perimetro | **Esteso: TUTTI i layout con `<head>` proprio** (`layouts.main`, `layouts.base`, `layouts/guest`, `layouts/test`, `components/layouts/auth` e valutazione `mobile/layout`); `offline.blade.php` resta escluso per definizione (funziona offline) |

---

## Studio di `laravel/head` v0.2.2 e piano a story (terza sessione, 2026-11-11)

> Sezione aggiunta in coda, senza riscrivere le due sopra. Fonte: lettura di `vendor/laravel/head/src` (il README rimanda alla
> documentazione online, non c'è altro in locale). Nessun file di codice è stato modificato. Dove il comportamento dipende da come
> la libreria fonde i valori, la voce dice «da provare»: si prova con un test prima di adottarla.

### Cosa offre `laravel/head` e il componente Cms non sfrutta (ancora)

| API `Head::` | Che cosa fa (dal sorgente) | Uso proposto |
|---|---|---|
| `title($t, prefix:, suffix:, exact:)` | non `exact`: rende `prefix . $t . suffix`; `exact: true` rende il valore tal quale. `asDefaults()` rende esatto il titolo di default e lascia a prefix/suffix il compito di decorare i soli titoli di pagina | **D-2 senza codice nostro:** suffisso `' \| FixCity'` nativo. Oggi il Cms usa `exact: true` e ricompone il titolo con `ComposeDocumentTitleAction` (separatore fisso `—`). Da provare: `Head::defaults()` con suffisso del tema + titolo di pagina non esatto; se regge, l'Action si riduce a decidere il suffisso |
| `paginate(Paginator)` | `rel=prev` / `rel=next` in una chiave separata (`links.pagination`) | Chiamata di **pagina** sulle liste con paginator Laravel: non confligge col componente. **Non** sostituisce il canonical con `?page` (gap 1): `canonical()` prende la stringa che gli si dà |
| `canonical($url, forceHttps:, trailingSlash:)` | emette l'URL ricevuto | Il fix della `?page` è in `Head::canonicalUrl()` del Cms, non nella libreria |
| `hiddenFromRobots()` / `searchableByRobots()` | direttive robots semantiche | Candidate al posto di `ResolveRobotsPolicyAction::directive()` quando D-3 rende configurabile l'elenco `noindex` |
| `preload` / `preconnect` / `dnsPrefetch` / `prefetch` | hint di rete | `preload` dei woff2 critici (font self-hosted, DCP-183) può migliorare LCP: **da misurare** (Lighthouse prima/dopo), non adottare a priori |
| `themeColor`, `manifest`, `pwa()` | PWA | `themeColor` già in uso (`#007a52`); `pwa()` solo per il tema mobile, fuori fase 1 |
| `defaults()`, attributi di rotta (`fromRouteAttribute`) | valori per gruppo di rotte | Non usati: il Cms scrive a runtime sullo strato più alto. Opzione per D-3 (noindex per gruppo di rotte invece di costanti nel codice): **non verificato** il funzionamento con Folio, valutare in H-3 |

### Cosa la libreria non offre (e perché la Fase 2 resta come scritta)

Nessun tag `<script>` / `<style>` generico: `src/Tags` contiene solo AlternateLinks, Canonical, Description, FeedLinks, GenericLinks,
GroupedTagBuilder, MetaTags, OpenGraph, PaginationLinks, PerformanceLinks, Robots, Schemas, StringTagBuilder, TagBuilder, Title,
Twitter. Quindi FOUC guard `#sixteen-critical-fouc`, bootstrap Alpine `mobileMenu` e boot del dark mode restano `@push('head')`
del layout (prima di `<x-cms::head>`, R-1): non è un limite del componente ma la divisione corretta fra «dati SEO» (libreria) e
«comportamento del tema» (layout). Requisiti della libreria: PHP ^8.3, `illuminate/*` ^13.17 (installata v0.2.2, nessun pacchetto nuovo).

### Piano di esecuzione: story figlie con perimetri di file disgiunti

Si materializzano come file in `Modules/Cms/docs/stories/` o `Themes/Sixteen/docs/stories/` solo quando partono (claim nella story, poi
lock su cartella): nessuna scaffolding anticipata.

| ID | Cosa | Owner | Perimetro di file | Dipende da | Cancello di uscita |
|---|---|---|---|---|---|
| H-1 | Brand: `header.brand.name` = `FixCity` in 4 lingue e `'Test'` fuori da `config/local/fixcity/metatag.php` (D-1) | Sixteen (lang) + dati del tenant | `Themes/Sixteen/lang/{it,en,de,es}/header.php`, `config/local/fixcity/metatag.php` | — | test lang a 4 lingue; `Lang::has` vero; nessun «Test» in `<title>` |
| H-2 | Canonical e hreflang conservano `?page=N` (N ≥ 2) | Cms | `Head::canonicalUrl()`, `ResolveHreflangAlternatesAction`, test Pest nel modulo | — | Pest Cms mirato verde; TwentyOne invariato |
| H-3 | Titolo con `\|` (D-2) e percorsi `noindex` configurabili (D-3), senza nomi di dominio nel codice del Cms | Cms | `ComposeDocumentTitleAction`, `ResolveRobotsPolicyAction`, config | H-1 | Pest Cms; matrice robots della story invariata o approvata |
| H-4 | `layouts/main` adotta `<x-cms::head>`; ritiro di `ResolvePageHeadAction`, `PageHeadData` e del suo test | Sixteen | `components/layouts/main.blade.php`, `app/Actions/Seo/ResolvePageHeadAction.php`, `tests/Unit/ResolvePageHeadActionTest.php` | H-1…H-3 | `view:cache` exit 0; parità (H-5) |
| H-5 | Verifica di parità: diff del `<head>` per tag e screenshot prima/dopo | Sixteen `tests/` | strumento di sweep, fuori da `app/` | H-4 | vedi sotto |
| H-6 | Docs: `document-shell.md` (decisione rivista), `seo-head-architecture.md`, indici | Cms + Sixteen | `docs/` dei due | H-4 | link rotti = 0 sui file toccati |

H-1 e H-2 sono indipendenti e possono andare in parallelo (file diversi). Ordine di rischio: H-1 è un dato, H-2 è codice nel Cms
con test, H-4 è l'unico che cambia il rendering di ogni pagina.

### Piano di verifica della parità (H-5)

1. **Prima** di H-4: catturare la baseline sull'albero attuale e conservarla fuori dal repo (testo del solo `<head>` per tag, più
   screenshot a 1440 px e 375 px, tema chiaro e scuro) su: `/it`, `/en`, `/de`, `/es`, `/it/tickets`, `/it/tickets?page=2`,
   un dettaglio ticket, `/it/blog`, un articolo, `/it/auth/login`, `/it/tests`, `/it/area-personale/pratiche` (anonimo = redirect),
   una 404. Le misure della seconda sessione sono un punto di partenza, non la baseline: erano su 4 URL con diff completo.
2. **Dopo** H-4: stesso insieme, diff per tag. Ammesse solo le differenze D-1…D-6 approvate.
3. **Strumenti:** Playwright (script di sweep con Chrome di sistema `--no-sandbox`), Puppeteer come secondo parere per lo schermo,
   Pest nel modulo Cms con `Blade::render('<x-cms::head …>')` per le regole pure, `view:cache` e `curl` 200. Il browser Playwright
   MCP è unico e condiviso fra le sessioni: se risponde «Browser is already in use» non si forza, si usa uno script con il
   pacchetto `playwright` del repo.
4. **Cosa non si può dedurre dal render in-process:** rotte per nome, sessione, `csrf-token`. Servono richieste HTTP reali sul
   server di sviluppo (`:8081`) e, da loggato, la fixture isolata `bashscripts/tools/visual/scratch-auth-fixture.sh`.

### Confidenza e limiti di questa sezione

Alta: API elencate (lette nel sorgente), assenza di tag script/style, requisiti di versione. Media: il comportamento di fusione di
`Head::defaults()` col titolo non esatto, e gli attributi di rotta con Folio (voci «da provare»). Non misurato in questa sessione:
nessun render del componente; la baseline di H-5 va presa a macchina libera (load average > 30 durante questa sessione, misure
di tempo e timeout non affidabili).

---

## Dev Agent Record — implementazione Fasi 1-2 (sessione corrente)

**Fatto:**

- **H-1/D-1:** `header.brand.name` = `FixCity` in `Themes/Sixteen/lang/{it,en}/header.php` (de/es ereditano da en); `metatag.php`:
  `title` e `sitename` → `FixCity` in `config/local/fixcity/` e `config/localhost/` (prima `Test`/`foodfriendfinder`).
- **H-2:** `Head::canonicalUrl()` e `ResolveHreflangAlternatesAction` conservano `?page=N` (N ≥ 2, intero); `build()` accetta `$query` opzionale (BC).
- **H-3/D-2/D-3:** separatore titolo e liste `noindex` leggibili da `config/{tenant}/fixcity/head.php` via
  `GetTenantConfigArrayAction('head')` in `ComposeDocumentTitleAction` e `ResolveRobotsPolicyAction`
  (`title_separator`, `noindex_paths`, `noindex_slugs`; file assente o container non bootstrappato → default del modulo).
  Creati `config/local/fixcity/head.php` e `config/localhost/head.php` con `title_separator = ' | '`,
  `noindex_paths = ['tests','tickets/create','tickets/confirmation','tickets/track']` (parita' con `ResolvePageHeadAction::NOINDEX_PATHS`).
- **H-4 parziale:** migrati a `<x-cms::head>`: `components/layouts/main` (props title/description/homepage, `theme-color="#007a52"`,
  Alpine `mobileMenu` e FOUC guard in `@push('head')`/`@push('styles')`), `components/layouts/auth` (AGID styles in `@push('styles')`,
  `theme-color="#0066CC"`, js tema a fine body), `components/layouts/guest`, `layouts/base`, `layouts/guest`, `mobile/layout`.
  Rimosso `<x-layouts.seo-links />` da main (canonical/hreflang ora del Cms).

**Esclusi di proposito (da registrare):** `offline.blade.php` (funziona offline, niente CMS/Vite),
`livewire/auth/logout.blade.php` (documento HTML standalone del logout), `layouts/test.blade.php` (carica `app-test.css`,
solo test interni frontend). `ResolvePageHeadAction`/`PageHeadData` NON ancora ritirati: verificare che nessun caller resti
prima del ritiro (H-4 completo).

**Verificato live (server :8092):** `/it` → `<title>Segnala un problema, segui la soluzione | FixCity</title>`,
robots `index, follow, max-image-preview:large`, un solo canonical, hreflang de/en/es/it/x-default, 2 JSON-LD;
`/it/auth/login` → `noindex, follow`, titolo `Accedi a FixCity`; `/it/blog?page=2` → canonical e hreflang con `?page=2`.
`view:cache` exit 0; Pest `Modules/Cms/tests/Unit/Actions/Head` 79/80 (1 fallimento preesistente:
`MetatagData::make()` in test puro, non toccato); PHPStan zero sui file toccati; Pint eseguito.

**Da fare:** H-5 parita' completa (diff `<head>` su URL×lingue, screenshot), ritiro `ResolvePageHeadAction` se orfano,
H-6 docs (`document-shell.md`, `seo-head-architecture.md`, indici), audit FO guest+autenticato.

### Diff di parità misurato (sessione 85, 2026-11-11 ~21:25 UTC, sola lettura, 128 URL anonimi)

Prima = sweep browser di questa sessione **con l'`<head>` inline** (eseguito prima delle 21:13, quando `main.blade.php` è passato a `<x-cms::head>`);
ora = HTML grezzo servito da `:8081`. Strumento: `head-parity-diff.py` nello scratchpad della sessione 85 (non versionato). Nessun cambio a `status`,
`<meta name="description">`, `og:title`, `<html lang>` e `<title>` delle pagine interne: **0 differenze** su questi campi.

| # | Campo | Prima → ora | Pagine | Giudizio |
|---|-------|-------------|--------|----------|
| 1 | `robots` pubbliche | nessun meta → `index, follow, max-image-preview:large` | 84 | previsto da **D-4** (approvato) |
| 2 | `<title>` della home | `FixCity — Segnala un problema…` → `Segnala un problema… \| FixCity` | 4 (it/en/de/es) | coerente col separatore `\|` di **D-2**, ma **cambia l'ordine** marchio/titolo solo sulla home: da confermare |
| 3 | `canonical` e `hreflang` sulle pagine `noindex` | presenti (1 canonical, hreflang) → **assenti** | 36 URL = 16 pagine distinte (`auth/login`, `auth/register`, `tickets/confirmation`, `tickets/track` × 4 lingue) + 20 che per l'anonimo reindirizzano al login (`area-personale/*`, `tickets/create`) | **non coperto da nessuna decisione**: regressione di parità e fa fallire il cancello `LG-03`/`LG-04` (DCP-166, «canonical e hreflang su ogni pagina», 4.3.9) |

Il cancello completo (`go-live-gate.py --base http://127.0.0.1:8081 --skip-pest`, 2026-11-11 ~21:20) lo conferma: `LG-03` e `LG-04` **FAIL, 12 su 48**
(le tre pagine che il suo elenco misura — `auth/login`, `auth/register`, `tickets/track` — × 4 lingue). Il mio sweep precedente riportava «0 canonical
mancanti»: era vero con l'`<head>` di prima, non lo è più dopo la migrazione.

**D-7 (nuova, decide il PO).** Cause: `ResolveRobotsPolicyAction` dà `noindex` e il componente `Head` non emette canonical/hreflang per le pagine `noindex`.
Proposta (parità, nessun cambio di comportamento rispetto a prima): **canonical autoreferenziale e hreflang anche sulle pagine `noindex`** (il vecchio head
li emetteva, il cancello DCP-166 li pretende, per Google `noindex` + canonical su sé stessi è coerente). Alternativa: restare con l'output attuale e
**ridurre** il cancello `LG-03`/`LG-04` alle pagine indicizzabili (decisione di prodotto da scrivere in DCP-166). Va deciso prima di H-5 e di chiudere H-4:
finché non lo è, il cancello resta rosso per questa ragione e l'esito «NON pubblicabile» non dipende solo dal dev.
Corollario per **H-5**: il diff va rifatto in browser (DOM) oltre che sull'HTML grezzo, e sulle pagine da utente loggato.
