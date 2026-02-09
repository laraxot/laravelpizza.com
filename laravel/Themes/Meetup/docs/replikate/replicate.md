# Homepage Replication & Improvement Plan

## Target: https://laravelpizza.com/
## Our Site: Meetup theme at `/{locale}` (resolved via APP_URL + Tenant config + `xra.php` → `pub_theme`)

---

## Target Site Analysis (Screenshots taken Feb 2026)

### Site Identity
**Laravel Pizza Meetups** - A community platform for Laravel, Filament, and Livewire developers. "Pizza" is a metaphor for meetups and community gathering. This is NOT a food/e-commerce site.

### Section Structure (top to bottom)

1. **Sticky Navigation Bar**
   - Left: Pizza slice logo (SVG, red/dark red) + "Laravel Pizza Meetups" brand text (white, bold)
   - Center: Events (with calendar icon) | Community Chat (with chat icon) | Language selector (globe icon + "English")
   - Right: "Login" (text link) + "Sign Up" (red bg CTA button, rounded)
   - Very dark background (#0f172a slate-900 approx), sticky on scroll

2. **Hero Section**
   - Full-width, dark background matching nav (#0f172a)
   - Centered pizza slice icon/illustration (SVG, red outline, ~100px)
   - Large bold title: "Laravel Developers." (white) + "Pizza. Community." (red accent, #dc2626)
   - Subtitle paragraph (gray-400, ~18px): "Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups. Share knowledge, build connections, and enjoy great food together."
   - Two CTAs side by side:
     - Primary: "Join the Community →" (red bg #dc2626, white text, rounded-lg, arrow icon)
     - Secondary: "View Events" (outline, red border, red text, rounded-lg)
   - Generous vertical padding (~py-24 or more)

3. **Features / "Why Join Our Community?"**
   - Section title: "Why Join Our Community?" (white, bold, ~36px, centered)
   - Section subtitle: "More than just pizza - it's about building lasting connections with developers who share your passion" (gray-400, centered)
   - Grid of feature cards (3-4 columns on desktop, 1 col on mobile):
     - Each card: dark card bg (~slate-800), rounded, padding
     - Icon at top (Heroicon outline, red/red-accent color): calendar, users, map-pin, chat-bubble
     - Card title (white, bold): "Regular Meetups", "Growing Community", "Multiple Locations", "Realtime Chat"
     - Card description (gray-400): short paragraph
   - Cards have subtle border or shadow on dark bg

4. **CTA Banner Section**
   - Full-width red background (#dc2626) with rounded corners
   - Bold centered title: "Ready to Join?" (white, ~36px)
   - Subtitle: "Sign up today and start connecting with Laravel developers in your area. The next pizza meetup is just around the corner!" (white/90%)
   - Single CTA: "Create Your Account →" (white bg, red text, rounded-lg, with arrow icon)

5. **Footer**
   - Dark background (even darker than hero, ~#0b1120 or slate-950)
   - 3-column layout on desktop:
     - **Column 1 (Brand)**: Pizza slice logo + "Laravel Pizza Meetups" + description "Bringing together Laravel, Filament, and Livewire enthusiasts over delicious pizza. Join our community and connect with fellow developers." + Social icons (GitHub, Twitter/X)
     - **Column 2 (Quick Links)**: Title "Quick Links" + Events, Community Chat, Dashboard
     - **Column 3 (Community)**: Title "Community" + About Us, Code of Conduct, Contact
   - Bottom bar (border-t, very subtle): "Made with ♥ for the Laravel community" (gray-500, centered)

---

## Current Site Issues (to fix)

1. **Content alignment**: Verify `home.json` content_blocks match the target structure (hero → features → CTA)
2. **Color scheme**: Ensure dark theme uses correct slate-900/950 tones with red (#dc2626) accents
3. **Typography**: Hero title needs two-tone treatment (white + red)
4. **Feature cards**: Must use dark card style on dark bg, not white cards
5. **CTA section**: Red banner with rounded corners, white CTA button
6. **Footer**: 3 columns (not 4), correct content matching community theme
7. **Navigation**: Sticky dark nav with red "Sign Up" CTA
8. **SVG icons**: Must follow project rule - no inline SVG, use `<x-filament::icon icon="meetup-{name}" />`

---

## Implementation Plan

### Phase 1: Layout & Navigation
- [ ] Verify header section JSON (`sections/header.json`) matches target nav structure
- [ ] Sticky dark nav with logo + brand, menu items, language selector, Login + Sign Up CTA
- [ ] All nav links must use `LaravelLocalization::localizeUrl()` for proper locale prefix
- [ ] Language selector must use `LaravelLocalization::getLocalizedURL($code, null, [], true)`

### Phase 2: Block Components (in `Themes/Meetup/resources/views/components/blocks/`)
- [ ] `hero/main.blade.php` → Dark bg hero with pizza icon, two-tone title, dual CTAs
- [ ] `features/grid.blade.php` → "Why Join" section with dark icon cards
- [ ] `cta/banner.blade.php` → Red banner CTA with rounded corners
- [ ] Existing blocks to verify: check if all views referenced in `home.json` exist and render correctly

### Phase 3: Content (`home.json`)
- [ ] Verify `config/local/laravelpizza/database/content/pages/home.json` content_blocks:
  - `hero` → `pub_theme::components.blocks.hero.main`
  - `features` → `pub_theme::components.blocks.features.grid`
  - `cta` → `pub_theme::components.blocks.cta.banner`
- [ ] Verify translation keys exist in `Modules/Meetup/resources/lang/`
- [ ] All CTA URLs must NOT be hardcoded — use `LaravelLocalization::localizeUrl()`

### Phase 4: Footer
- [ ] Verify `sections/footer.json` matches target (3 columns: Brand, Quick Links, Community)
- [ ] Footer view `components/blocks/navigation/footer-institutional.blade.php` renders correctly
- [ ] All footer links must use `LaravelLocalization::localizeUrl()`
- [ ] Social icons must use SVG files + `<x-filament::icon>` pattern

### Phase 5: SEO & Marketing Improvements (beyond target)
- [ ] Proper meta tags via metatags component
- [ ] Schema.org JSON-LD for Organization and Event
- [ ] Open Graph + Twitter Card tags
- [ ] Multilingual hreflang tags
- [ ] AdSense-ready placeholder areas
- [ ] Newsletter integration ready

---

## Color Palette

- **Background Primary**: #0f172a (Tailwind slate-900) — nav, hero, page bg
- **Background Darker**: #0b1120 (slate-950 approx) — footer
- **Card Background**: #1e293b (slate-800) — feature cards
- **Accent/CTA**: #dc2626 (Tailwind red-600) — buttons, highlights, "Pizza. Community." text
- **Text Primary**: #ffffff (white) — headings
- **Text Secondary**: #9ca3af (gray-400) — body text, descriptions
- **Text Muted**: #6b7280 (gray-500) — footer copyright, subtle text
- **Border/Divider**: #334155 (slate-700) — subtle borders on dark bg

## Typography
- Headings: System font stack / Inter, bold/extrabold
- Body: System font stack / Inter, regular
- Hero title: 48-60px, two-tone (white + red)
- Section titles: 32-40px, white
- Body: 16-18px, gray-400

---

## Critical Architecture Rules (always follow)

1. **NO controllers, NO web.php routes** — Folio + Volt + JSON CMS-driven pages only
2. **Content in JSON** — `config/local/laravelpizza/database/content/pages/{slug}.json`
3. **Sections in JSON** — `config/local/laravelpizza/database/content/sections/{slug}.json`
4. **Block components** — `Themes/Meetup/resources/views/components/blocks/`
5. **SVG icons** — files in `Modules/Meetup/resources/svg/`, use `<x-filament::icon icon="meetup-{name}" />`
6. **Localized URLs** — always `LaravelLocalization::localizeUrl($path)`, never manual prefix
7. **Theme build** — after CSS/JS changes: `npm run build && npm run copy` (from `Themes/Meetup/`)
8. **XotBase extension** — Filament classes always extend XotBase* abstracts

---

## Improvements Over Target (our site should be BETTER)

1. **Performance**: Lazy loading images, optimized SVGs, minimal JS
2. **Animations**: Subtle scroll-in animations with Intersection Observer / Alpine.js
3. **Accessibility**: WCAG 2.1 AA compliance, proper ARIA labels, keyboard nav
4. **SEO**: Schema.org JSON-LD, proper heading hierarchy (single H1), meta descriptions
5. **Multilingual**: All content translatable via JSON + lang files, hreflang tags
6. **AdSense Ready**: Strategic ad placement areas that don't hurt UX
7. **Inbound Marketing**: Lead magnets, newsletter, resource downloads
8. **Mobile First**: Superior mobile experience, touch-friendly CTAs
9. **Dark Mode**: Native dark theme (the site IS dark-themed)
10. **Microinteractions**: Hover effects, smooth transitions, button feedback

---

*Last updated: February 2026*
