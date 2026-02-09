# Task: Full Site Replication and Alignment

## Objective
Bring the local `Meetup` theme frontend as close as possible to the target site (`https://laravelpizza.com/`), achieving pixel-parity in design and matching content. This task must strictly adhere to the project's Laraxot architecture.

**Local site URL**: Resolved via APP_URL + Tenant config. Typically `http://127.0.0.1:8000/{locale}`.
**Theme path**: `laravel/Themes/Meetup/` (resolved via `.env` → Tenant → `xra.php` → `pub_theme`).

## Core Architectural Principles
- **DO NOT** use traditional controllers or custom routes in `web.php` for public-facing pages
- **ALL** content pages are driven by Folio and defined by `.json` files in `laravel/config/local/laravelpizza/database/content/pages/{slug}.json`
- **ALL** section data (header, footer) lives in `laravel/config/local/laravelpizza/database/content/sections/{slug}.json`
- **ALL** page structure is built from `content_blocks` which map to Blade components in `laravel/Themes/Meetup/resources/views/components/blocks/`
- **SVG icons**: Files in `Modules/Meetup/resources/svg/`, invoked via `<x-filament::icon icon="meetup-{name}" />`. NO inline SVG in Blade.
- **URLs**: Always use `LaravelLocalization::localizeUrl('/path')`. Never hardcode locale prefix.
- **Many-to-many relations**: Always `$this->belongsToManyX()`, never `belongsToMany()`.

## Mission: ELEVATION, NOT JUST REPLICATION
We're not just copying - we're **ELEVATING** the original site to be MORE COOL, MORE ENGAGING, MORE VIRALE.

## Pre-Task Study (Mandatory)
Before making any changes, study the existing documentation:

1. **Theme Documentation**: `laravel/Themes/Meetup/docs/`
2. **CMS Module Documentation**: `laravel/Modules/Cms/docs/` (Section.php, content blocks)
3. **Other Modules**: `Modules/Lang/docs/`, `Modules/UI/docs/`, `Modules/Xot/docs/`
4. **Reference Plan**: `laravel/Themes/Meetup/docs/replikate/reference_analysis.md` (for detailed design, content, and architectural specifications)

## Step-by-Step Implementation Plan

### Phase 1: Analisi, Setup Iniziale e Layout di Base

1.  **Analisi Approfondita (MCP)**:
    *   Utilizza gli MCP per creare screenshot dettagliati di `https://laravelpizza.com/`. Salva le immagini in `laravel/Themes/Meetup/docs/screenshots`.
    *   Analizza l'UI/UX del sito target. Documenta in `laravel/Themes/Meetup/docs/` esattamente cosa deve essere replicato, con un focus sull'obiettivo di rendere il nostro sito *migliore* dell'originale in termini di UI/UX.
2.  **Preparazione del Layout**:
    *   Rimuovi la sidebar da `home.blade.php` per ottenere un layout full-width.

### Phase 2: Implementazione Header & Navigation

1.  **Obiettivo**: Replicare l'header di `https://laravelpizza.com/` (Sticky, Logo a sinistra, Menu centrale, CTA a destra).
2.  **File coinvolti**:
    *   Blade: `laravel/Themes/Meetup/resources/views/components/sections/header.blade.php` (richiamato come `<x-section slug="header"/>`).
    *   Dati: `laravel/config/local/laravelpizza/database/content/sections/header.json`.
3.  **Funzionalità**: Implementare supporto per dropdown utente (se loggato), cambio lingua (vedi Modulo Lang), e menu responsivo.
4.  **Verifica**: Assicurati che l'header sia sticky e che tutti i link funzionino correttamente, specialmente il cambio lingua.

### Phase 3: Implementazione Pagine Interne (con Folio e JSON)

1.  **Mappatura URL**: Implementa la mappatura delle URL del target alle nostre rotte Folio:
    *   `/` → `/it`
    *   `/chi-siamo` → `/it/pages/chi-siamo`
    *   `/eventi` → `/it/pages/eventi`
    *   `/blog` → `/it/pages/blog`
    *   `/faq` → `/it/pages/faq`
    *   `/contatti` → `/it/pages/contatti`
2.  **Contenuti JSON**: Crea o modifica i file JSON corrispondenti in `laravel/config/local/laravelpizza/database/content/pages/{slug}.json` per ciascuna pagina.
3.  **Componenti Blade (Blocks)**: Assicurati che i blocchi visuali necessari siano definiti in `laravel/Themes/Meetup/resources/views/components/blocks/` e che la loro struttura dati sia compatibile con i JSON.

### Phase 4: Implementazione Footer

1.  **Obiettivo**: Replicare il footer di `https://laravelpizza.com/`.
2.  **Riferimento**: Vedi istruzioni dettagliate in `laravel/Themes/Meetup/docs/replikate/footer_improvement_prompt.md`.
3.  **File coinvolti**:
    *   Dati: `laravel/config/local/laravelpizza/database/content/sections/footer.json`.
    *   Implementazione: `laravel/Themes/Meetup/resources/views/components/sections/footer/v1.blade.php` (o il Blade corretto risolto da `<x-section slug="footer"/>`).

### Phase 5: Funzionalità Avanzate e Miglioramenti

1.  **Multilingua**: Assicurati che ogni elemento del sito sia predisposto per la traduzione (via JSON o file lang).
2.  **SEO Ready**: Verifica la struttura HTML semantica, l'uso corretto di H1/H2/H3 e la predisposizione per meta tags dinamici.
3.  **Inbound Marketing**: Prepara il sito per l'integrazione di CTA, form e sezioni di download.
4.  **AdSense Ready**: Identifica e predisponi spazi per l'integrazione di banner pubblicitari non invasivi.

### Phase 6: Apprendimento Continuo e Reportistica

1.  **Aggiornamento Docs**: Documenta costantemente le scoperte, gli errori corretti e le best practices nelle cartelle `docs` (`Modules/Meetup/docs` e `Themes/Meetup/docs`).
2.  **Verifica Finale**: Effettua un controllo incrociato su desktop e mobile per assicurare che header, footer e pagine chiave siano leggibili, accessibili e coerenti.

## Critical Architecture Rules

1.  **NO Controller Tradizionali**: Usiamo Folio + Volt. Se vedi codice che suggerisce App\Http\Controllers, è SBAGLIATO.
2.  **Niente property_exists()**: Vietato sui Model Eloquent. Usa `isset()` o `hasAttribute()`.
3.  **Risorse in Themes/Main_files**: Se scarichi HTML/CSS statici per analisi, salvali in `laravel/Themes/Meetup/Main_files`.
4.  **Errori Comuni**:
    *   Se manca una view component (es. `ui::components.blocks.hero`), verifica se deve stare nel modulo UI o nel Tema (`Themes/Meetup/resources/views/components/`). Spesso, se specifico del tema, va nel tema.
    *   Componenti icone: Usa `x-filament::icon` o SVG in `Modules/Meetup/resources/svg`.
5.  **Routine di Controllo**:
    *   Esegui `php artisan optimize` dalla cartella laravel se cambi config o route.
    *   Prima di committare: **Studio Docs -> Implementazione -> Verifica -> Aggiornamento Docs**.
6.  **Content in JSON** — pages in `pages/{slug}.json`, sections in `sections/{slug}.json`
7.  **SVG icons** — `Modules/Meetup/resources/svg/` + `<x-filament::icon icon="meetup-{name}" />`
8.  **Localized URLs** — `LaravelLocalization::localizeUrl()` always
9.  **XotBase extension** — Filament classes extend XotBase* abstracts
10. **Theme build** — `npm run build && npm run copy` from `Themes/Meetup/` after CSS/JS changes
11. **belongsToManyX** — never use plain `belongsToMany()` for M2M relations
12. **No inline SVG** — never paste SVG markup in Blade

## Common Errors to Avoid

- Wrong content domain (medical/safety content instead of Laravel meetups)
- Wrong colors (#1e3a5f navy instead of correct #0f172a slate-900 + #dc2626 red)
- Hardcoding URLs without `LaravelLocalization::localizeUrl()`
- Creating controllers for public pages
- Inline SVG in Blade (must use file + icon component)
- Extending Filament classes directly (must use XotBase*)
- Forgetting `npm run build && npm run copy` after theme changes
- Not updating documentation after changes

## Improvements Over Target

1. **Performance**: Lazy loading, optimized SVGs, minimal JS
2. **Animations**: Scroll animations via Alpine.js + Intersection Observer
3. **Accessibility**: WCAG 2.1 AA, ARIA labels, keyboard navigation
4. **SEO**: Schema.org JSON-LD, heading hierarchy, meta tags, hreflang
5. **Multilingual**: Content in JSON + lang files, language switcher
6. **AdSense Ready**: Non-intrusive ad placement areas
7. **Inbound Marketing**: Newsletter, event registration CTAs
8. **Mobile First**: Touch-friendly, responsive design
9. **Microinteractions**: Hover effects, smooth transitions

---

*For specific design details, refer to `replicate.md` in this directory.*
