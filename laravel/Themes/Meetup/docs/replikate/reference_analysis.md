# LaravelPizza.com Homepage Replication & Enhancement Plan

## Target: https://laravelpizza.com/
## Our Site: `/{locale}` (resolved via APP_URL + Tenant + `xra.php` → `pub_theme` → `laravel/Themes/Meetup/`)

---

## STRUTTURA E GESTIONE CONTENUTI (Strict Rules)

1. **Filosofia Componenti**: Utilizziamo **Filament PHP** per il builder e **Laravel Folio + Volt** per il frontend.
   - Docs Builder: https://filamentphp.com/docs/5.x/forms/builder

2. **Sorgenti Dati (JSON)**:
   - Homepage: `laravel/config/local/laravelpizza/database/content/pages/home.json`
   - Sezioni (header, footer): `laravel/config/local/laravelpizza/database/content/sections/{slug}.json`
   - **REGOLA**: Nuovi blocchi di contenuto → modifica JSON, mai hardcodare testo nelle view.

3. **Componenti Blade (Blocks)**:
   - Blocchi in: `laravel/Themes/Meetup/resources/views/components/blocks/`
   - Nuovi blocchi devono essere compatibili con la struttura dati JSON.

---

## Target Site Analysis (from actual screenshots Feb 2026)

### Mission: CONVERSION & ELEVATION
Non stiamo solo replicando - stiamo **ELEVANDO** il sito originale.

### Actual Section Structure (verified from screenshots)

The real laravelpizza.com has a **dark-themed** design with **exactly these sections**:

1. **Sticky Navigation Bar**
   - Left: Pizza slice logo (red SVG) + "Laravel Pizza Meetups" (white, bold)
   - Center: Events (calendar icon) | Community Chat (chat icon) | Language selector (globe + "English")
   - Right: "Login" text + "Sign Up" red CTA button
   - Background: Very dark (#0f172a slate-900), sticky on scroll

2. **Hero Section**
   - Full-width, dark background matching nav
   - Centered pizza slice icon (large, red outline SVG)
   - Two-tone title: "Laravel Developers." (white) + "Pizza. Community." (red #dc2626)
   - Subtitle: "Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups..."
   - Two CTAs: "Join the Community →" (red bg) + "View Events" (outline red)
   - Generous vertical padding

3. **Features: "Why Join Our Community?"**
   - Section title (white, bold, centered)
   - Subtitle: "More than just pizza - it's about building lasting connections..."
   - 4 cards on dark bg (slate-800):
     - Regular Meetups (calendar icon)
     - Growing Community (users icon)
     - Multiple Locations (map-pin icon)
     - Realtime Chat (chat-bubble icon)

4. **CTA Banner**
   - Red background (#dc2626), rounded corners
   - "Ready to Join?" (white, bold)
   - Description + "Create Your Account →" (white bg, red text)

5. **Footer**
   - Very dark bg (~slate-950)
   - 3 columns: Brand (logo + description + social) | Quick Links | Community
   - Bottom bar: "Made with ♥ for the Laravel community"

**IMPORTANT**: The target does NOT have these sections (previously incorrectly listed):
- ~~Events Showcase/carousel~~
- ~~Community/Speakers split layout~~
- ~~Latest Blog Posts~~
- ~~Newsletter CTA section~~
- ~~Testimonials~~
- ~~Resources/Downloads~~

These may be added as improvements, but they are NOT on the current target site.

---

## WORKFLOW DI REPLICAZIONE

1. **Analisi e Documentazione (MCP)**:
   - Screenshot di https://laravelpizza.com/ in `laravel/Themes/Meetup/docs/screenshots/`
   - Analizza UI/UX e documenta in `laravel/Themes/Meetup/docs/`
   - Obiettivo: PIU BELLO dell'originale

2. **Funzionalita Richieste**:
   - **Multilingua**: Tutto traducibile via JSON + lang files. URL via `LaravelLocalization::localizeUrl()`
   - **SEO Ready**: HTML semantico, H1/H2/H3, meta tags, Schema.org
   - **Inbound Marketing**: CTA, form, download
   - **AdSense Ready**: Spazi per banner

3. **Apprendimento Continuo**:
   - Memoria = cartelle docs nei moduli e nel tema
   - AGGIORNA COSTANTEMENTE con scoperte, errori corretti, best practices

---

## Implementation Plan

### Phase 1: Layout & Navigation
- [ ] Sticky dark nav matching target
- [ ] Logo + brand, menu items, language selector, Login + Sign Up CTA
- [ ] All links via `LaravelLocalization::localizeUrl()`

### Phase 2: Block Components (`Themes/Meetup/resources/views/components/blocks/`)
- [ ] `hero/main.blade.php` → Dark bg hero with pizza icon, two-tone title, dual CTAs
- [ ] `features/grid.blade.php` → "Why Join" section with dark icon cards
- [ ] `cta/banner.blade.php` → Red CTA banner "Ready to Join?"

### Phase 3: Content (`home.json`)
- [ ] Verify `config/local/laravelpizza/database/content/pages/home.json`
- [ ] content_blocks: hero, features, cta — all with correct views
- [ ] Translation keys in `Modules/Meetup/resources/lang/`

### Phase 4: SEO & Marketing (improvements beyond target)
- [ ] Meta tags dinamici
- [ ] Schema.org JSON-LD per Organization, Event
- [ ] Open Graph + Twitter Card tags
- [ ] hreflang tags

---

## TASK SPECIFICI

### 1. Header & Navigation
- File Blade: via `<x-section slug="header"/>` → CMS Section resolution
- Dati: `laravel/config/local/laravelpizza/database/content/sections/header.json`
- Funzionalita: dropdown utente, cambio lingua, menu responsivo

### 2. Footer
- Vedi: `footer_improvement_prompt.md` (NOT `replikate_footer.txt` which is deprecated)
- Dati: `laravel/config/local/laravelpizza/database/content/sections/footer.json`
- Via `<x-section slug="footer"/>` → CMS Section resolution

---

## Color Palette (verified from actual screenshots)

- **Background Primary**: #0f172a (Tailwind slate-900) — nav, hero, page bg
- **Background Darker**: #0b1120 (~slate-950) — footer
- **Card Background**: #1e293b (slate-800) — feature cards
- **Accent/CTA**: #dc2626 (Tailwind red-600) — buttons, highlights, accent text
- **Text Primary**: #ffffff (white) — headings, brand
- **Text Secondary**: #9ca3af (gray-400) — body text, descriptions
- **Text Muted**: #6b7280 (gray-500) — copyright, subtle text
- **Border**: #334155 (slate-700) — dividers

**WRONG colors (from previous incorrect versions — DO NOT USE)**:
- #0f2b46, #1e3a5f (wrong navy), #ef4444 (wrong red), #f97316 (wrong orange), #06b6d4 (wrong cyan), #f8fafc (wrong light bg), #2563eb (wrong blue), #059669 (wrong emerald)

## Typography
- Font: Inter / system-ui
- Hero title: 48-60px, two-tone (white + red)
- Section titles: 32-40px, white, bold
- Body: 16-18px, gray-400

---

## REGOLE TECNICHE CRITICHE

1. **NO Controller**: Folio + Volt + JSON CMS only
2. **No property_exists()**: Usa `isset()` o `hasAttribute()`
3. **SVG Icons**: File in `Modules/Meetup/resources/svg/` + `<x-filament::icon icon="meetup-{name}" />`. NO inline SVG.
4. **URL Localization**: `LaravelLocalization::localizeUrl('/path')` sempre. Mai hardcodare `/it/...`
5. **belongsToManyX**: Mai `belongsToMany()` per M2M
6. **XotBase**: Filament classes SEMPRE extend XotBase*
7. **Theme build**: `npm run build && npm run copy` dopo ogni modifica CSS/JS
8. **Routine**: Studio Docs → Implementazione → Verifica → Aggiornamento Docs


