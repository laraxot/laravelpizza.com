# LaravelPizza.com Homepage Replication & Enhancement Plan

## Target: https://laravelpizza.com/
## Our Site: http://127.0.0.1:8000/it

---
## STRUTTURA E GESTIONE CONTENUTI (Strict Rules)

1. **Filosofia Componenti**: Utilizziamo **Filament PHP** per il builder e **Laravel Folio + Volt** per il frontend.
   - Docs Builder: https://filamentphp.com/docs/5.x/forms/builder

2. **Sorgenti Dati (JSON)**:
   - I contenuti della homepage si trovano in:
     laravel/config/local/laravelpizza/database/content/pages/home.json
   - I contenuti delle sezioni (es. header, footer) sono in:
     laravel/config/local/laravelpizza/database/content/sections/{slug}.json
   - **REGOLA**: Se devi aggiungere nuovi blocchi di contenuto, modifica SEMPRE i file JSON, non hard-codare testo nelle view.

3. **Componenti Blade (Blocks)**:
   - I blocchi visuali si trovano in:
     laravel/Themes/Meetup/resources/views/components/blocks/
   - Se crei un nuovo blocco, assicurati che sia compatibile con la struttura dati definiti nel JSON e che erediti correttamente layout e stili.

---

## Target Site Analysis (Screenshots taken Feb 2026)

### Mission: CONVERSION & ELEVATION
Non stiamo solo replicando - stiamo **ELEVANDO** il sito originale per renderlo:
- ✨ **PIÙ COOL** - Design premium e moderno che cattura l'attenzione
- 🚀 **PIÙ CLICKBAIT** - Headlines e CTA irresistibili che convertono
- 💥 **PIÙ ENGAGING** - Animazioni fluide e interazioni wow-factor
- 🔥 **PIÙ VIRALE** - Progettato per essere condiviso e diventare virale

### Section Structure (top to bottom)

1. **Sticky Navigation Bar**
   - Left: Brand "LaravelPizza" con logo pizza SVG
   - Center: Home | Chi Siamo | Eventi | Blog | FAQ | Contatti
   - Right: CTA button "Partecipa agli Eventi" (arancione/red accent)
   - Background: blu scuro (#0f2b46) con backdrop blur, sticky on scroll
   - Hover effects su link con transizioni fluide

2. **Hero Section**
   - Full-width background: immagine pizza/meetup comunitaria
   - Dark overlay (~70% opacity) per leggibilità
   - Large bold title (white, 56-72px, font-bold)
   - Subtitle engaging (white/90%, 18-20px)
   - Two CTAs: Primary (arancione/red gradient) + Secondary (outline white)
   - **Social proof**: Stats bar con "1000+ Developers", "50+ Eventi", "10+ Città"

3. **Features/Benefits** (3 columns)
   - Cards con glassmorphism effect
   - Icona pizza/codecircolare colorata
   - Title engaging, description benefit-driven
   - "Scopri di più →" con hover animation
   - Shadow soft, rounded corners xl

4. **Why Join Section**
   - Pre-title in arancione uppercase ("PERCHÉ PARTECIPARE")
   - Bold centered title con gradiente text
   - 4 cards in grid: icona animata, title, benefit list
   - Microinteractions su hover (lift, glow)

5. **Events Showcase** (carousel/grid)
   - Featured events con date cards
   - Gradient badges per tipologie (Tech, Social, Workshop)
   - "Iscriviti" CTA prominenti
   - Lazy loading per performance

6. **Community/Speakers** (split layout)
   - Left: Testimonials con avatar, role, company
   - Right: Speaker cards con photo, bio, social links
   - Star rating system
   - Quote icon decorativo

7. **Latest Blog Posts**
   - Cards con featured image
   - Category tags color-coded
   - Reading time indicator
   - "Leggi tutto" CTA

8. **Newsletter CTA**
   - Gradient background (blu → arancione → rosso)
   - Pizza icon animato
   - "Rimani aggiornato" title
   - Email input + "Iscriviti" button con hover effect
   - GDPR compliant disclaimer

9. **Footer**
   - Background: gradient blu scuro (#0f2b46 → #1e3a5f)
   - 4 columns: Brand + Social, Quick Links, Resources, Contact
   - Social icons con hover effects
   - Bottom bar: Copyright + Privacy/Terms links

---

## Current Site Issues

1. **Layout**: Uses sidebar layout (2-column) - deve essere full-width
2. **Navigation**: Shows generic "Laravel" text, nav incompleta
3. **Hero**: Has glass panel overlay, needs professional redesign con pizza imagery
4. **Content**: Generic placeholder content, non LaravelPizza-specific
5. **Block rendering**: Uses `ui::components.blocks.{type}` - blocks devono matchare type names
6. **Missing blocks**: No events showcase, community testimonials, blog grid
7. **Styling**: Mix di DaisyUI e Tailwind - needs consistent Tailwind approach
8. **Animations**: No scroll animations, no microinteractions
9. **SEO**: Missing Schema.org, Open Graph, structured data

---

## Implementation Plan

### Phase 1: Layout & Navigation
- [ ] Remove sidebar da home.blade.php → full-width
- [ ] Update navigation con sticky header professional
- [ ] Implement smooth scroll behavior

### Phase 2: Block Components (in Themes/Meetup/resources/views/components/blocks/)
- [ ] hero/pizza.blade.php → Full-width hero con stats bar
- [ ] features/cards.blade.php → 3 cards con glassmorphism
- [ ] why-join/grid.blade.php → Pre-title + 4 icon cards
- [ ] events/showcase.blade.php → NEW: Events carousel/grid
- [ ] community/split.blade.php → NEW: Testimonials + speakers
- [ ] blog/grid.blade.php → NEW: Blog posts cards
- [ ] newsletter/signup.blade.php → Gradient + email form
- [ ] cta/banner.blade.php → Gradient CTA section

### Phase 3: Content (home.json in config/local/laravelpizza/database/content/pages/)
- [ ] Update tutti content_blocks con LaravelPizza-specific content
- [ ] Aggiungere dati events mock
- [ ] Aggiungere testimonials community
- [ ] Blog posts placeholder

### Phase 4: SEO & Marketing Improvements
- [ ] Meta tags dinamici per multilingua
- [ ] Schema.org JSON-LD per Organization, Event, BlogPosting
- [ ] Open Graph tags per social sharing
- [ ] Newsletter integration
- [ ] Analytics tracking ready

---

## Color Palette (LaravelPizza Brand)
- **Primary Dark**: #0f2b46 (navy scuro - navigation, footer, hero overlay)
- **Primary**: #ef4444 (red arancione - CTAs, accents, pizza color)
- **Secondary**: #f97316 (arancione - secondary CTAs, highlights)
- **Accent**: #06b6d4 (cyan - tech elements, links)
- **Background**: #f8fafc (light gray sections)
- **Card Background**: rgba(255,255,255,0.9) con backdrop blur
- **Text Primary**: #1e293b (slate-900)
- **Text Secondary**: #64748b (slate-500)

## Typography
- Font: Inter (Google Fonts) o system-ui
- Headings: font-bold/extrabold, tighter tracking
- Hero title: 56-72px (mobile: 36-48px)
- Section titles: 32-40px (mobile: 24-32px)
- Body: 16-18px, leading-relaxed
- Button text: font-semibold

---

## Improvements Over Target (our site deve essere MIGLIORE)

1. **Performance**: Lazy loading images, optimized SVGs, code splitting
2. **Animations**: Smooth scroll animations con Intersection Observer, parallax effects
3. **Accessibility**: WCAG 2.1 AA compliance, proper ARIA labels, keyboard navigation
4. **SEO**: Schema.org JSON-LD completo, proper heading hierarchy, meta descriptions
5. **Multilingual**: All content translatable via JSON, hreflang tags, language switcher
6. **AdSense Ready**: Strategic ad placement areas (non-intrusive)
7. **Inbound Marketing**: Lead magnets, newsletter, resource downloads, event registration
8. **Mobile First**: Superior mobile experience con touch-friendly interactions
9. **Dark Mode**: Optional dark mode support con system preference detection
10. **Microinteractions**: Hover effects, smooth transitions, loading states, feedback

---

## URL Mapping Rule
Target site usa schema flat (/{slug}) mentre local site usa multilingual ({lang}/pages/{slug}):
- / → /it
- /chi-siamo → /it/pages/chi-siamo
- /eventi → /it/pages/eventi
- /blog → /it/pages/blog
- /faq → /it/pages/faq
- /contatti → /it/pages/contatti

---

## Critical Workflow Rules
1. **DOPO ogni modifica CSS/JS**: `cd laravel/Themes/Meetup && npm run build && npm run copy`
2. **DOPO ogni modifica PHP**: Verifica con PHPStan Level 10
3. **SEMPRE**: Usa Folio + Volt, NO controllers per pagine pubbliche
4. **SEMPRE**: Contenuti in config/local/laravelpizza/database/content/pages/{slug}.json
5. **SEMPRE**: Componenti blocks in Themes/Meetup/resources/views/components/blocks/
6. **SEMPRE**: Localizza URL con LaravelLocalization::localizeUrl()

---

*Last updated: February 2026*