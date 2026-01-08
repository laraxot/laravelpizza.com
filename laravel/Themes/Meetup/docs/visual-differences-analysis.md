# Visual Differences Analysis - Homepage Issue

## Evidence (screenshots)

Gli screenshot di confronto devono essere salvati nel tema in:

`Themes/Meetup/docs/screenshots/`

File attesi:

- `local-it-home.png` (http://127.0.0.1:8002/it)
- `prod-home.png` (https://laravelpizza.com/)

File raw (generati da Chromium headless, tenuti per tracciabilità):

- `screenshot_127_0_0_1_2026-01-08T21-06-05-138Z_frame1.png`
- `screenshot_laravelpizza_com_2026-01-08T21-06-05-094Z_frame1.png`

## Current State (WRONG - Image 01c.png)

### Theme & Design
- ❌ **Light theme** with white background
- ❌ **Blue accent colors** instead of red
- ❌ Light color scheme throughout

### Content
- ❌ **Wrong content**: "Funzionalità Principali" (Business features)
- ❌ Italian business text: "Tutto quello che ti serve per gestire la tua azienda"
- ❌ **Employee Management** ("Gestione Dipendenti") instead of community features
- ❌ Generic business functionality instead of meetup community

### Navigation
- ❌ **Missing navigation bar** entirely
- ❌ No Laravel Pizza Meetups branding
- ❌ No menu items (Events, Community Chat, etc.)
- ❌ No login/signup buttons

### Hero Section
- ❌ **Missing hero section** with main headline
- ❌ No pizza icon
- ❌ No "Laravel Developers. Pizza. Community." heading
- ❌ No CTA buttons

### Features Section
- ❌ Shows business icons (blue people icons)
- ❌ Wrong feature cards (employee management vs meetup features)
- ❌ Light card styling instead of dark glass morphism

---

## Target State (CORRECT - Image 01b.png)

### Theme & Design
✅ **Dark theme** with slate-900 background (#0f172a)
✅ **Red accent colors** (#dc2626, #ef4444) - Laravel Pizza brand
✅ Dark navy/slate color scheme throughout

### Navigation Bar
✅ **Full navigation** at top with:
- Laravel Pizza Meetups logo (red pizza slice icon + text)
- Menu items: Events, Community Chat
- Language selector (English)
- Login button (outlined)
- Sign Up button (red solid)
✅ Dark background with subtle backdrop blur
✅ Sticky positioning

### Hero Section
✅ **Large hero** with:
- Centered red pizza slice icon (large)
- "Laravel Developers." in white (5xl-7xl font)
- "Pizza. Community." in red (5xl-7xl font)
- Subtitle: "Join fellow Laravel, Filament, and Livewire enthusiasts for pizza meetups..."
- Two prominent CTA buttons:
  - "Join the Community" (red solid background)
  - "View Events" (red outlined)

### Features Section - "Why Join Our Community?"
✅ Section heading in large white text
✅ Subtitle: "More than just pizza - it's about building lasting connections..."
✅ **Four feature cards** in a grid:
1. **Regular Meetups** (red calendar icon)
   - "Join weekly pizza meetups with Laravel developers in your area"
2. **Growing Community** (red people icon)
   - "Connect with passionate developers who love Laravel and pizza"
3. **Multiple Locations** (red location pin icon)
   - "Find meetups in cities around the world"
4. **Real-time Chat** (red chat bubble icon)
   - "Stay connected with the community between meetups"

✅ **Card styling**: Dark glass morphism effect
- Background: slate-800/50 with backdrop blur
- Border: slate-700
- Hover: red border glow
- Icons in red circles with semi-transparent background

---

## Root Cause Analysis

### Why is it showing wrong content?

Possible causes:
1. **Content blocks not rendering** - The JSON-based blocks from `home.json` are not being rendered
2. **Wrong page being loaded** - Different page content is being shown
3. **Cache issue** - Old content is cached
4. **View resolution issue** - The Folio page is not using the correct layout or blocks
5. **Database seeding issue** - The pages table may have old content

### Root cause confermata: Features Grid non allineata al tema dark

Il blocco `pub_theme::components.blocks.features.grid` deve seguire la palette dark del tema Meetup.

- Il template aveva `bg-white` e testi `text-gray-*`, quindi “staccava” visivamente su layout dark.
- Inoltre usava classi Tailwind dinamiche (es. `hover:border-{{ $feature['color'] }}-200`). Con Tailwind v4 queste classi spesso non vengono generate se non safelistate, causando hover/border incoerenti.

Regola pratica:

- Usare classi Tailwind statiche (es. `hover:border-red-500`) per i blocchi public.
- Se serve colorizzazione dinamica, va introdotta una safelist (decisione da documentare) invece di interpolare classi.

### What should be happening:

1. Route `/it` should load the Folio page
2. Folio page should read from `home.json`
3. Content blocks should render using views like `pub_theme::components.blocks.hero.main`
4. Layout should be `pub_theme::components.layouts.main`
5. Navigation should be included in layout or as first block

---

## Investigation Needed

### Check #1: What page is actually rendering?
- Is `/it` route loading the correct Folio page?
- What view is being used?

### Check #2: Is home.json being read?
- Are content blocks being loaded from database?
- Is the seeder running correctly?

### Check #3: Navigation component
- Where should the navigation come from?
- Is it in the layout or a separate block?

### Check #4: Content block rendering
- Are the block components being found and rendered?
- Is `pub_theme::` resolving correctly?

---

## Expected File Structure

### Navigation
Should be in: `Themes/Meetup/resources/views/components/navigation.blade.php`
Or included in: `Themes/Meetup/resources/views/components/layouts/main.blade.php`

### Hero Block
File: `Themes/Meetup/resources/views/components/blocks/hero/main.blade.php`
Should contain: Pizza icon, "Laravel Developers. Pizza. Community.", CTAs

### Features Block
File: `Themes/Meetup/resources/views/components/blocks/features/grid.blade.php`
Should contain: 4 cards with red icons and dark styling

---

## Next Steps

1. ✅ Document differences (this file)
2. ⏳ Check Folio page structure
3. ⏳ Verify navigation component exists and is included
4. ⏳ Check content block rendering logic
5. ⏳ Verify home.json is being used
6. ⏳ Implement missing components
7. ⏳ Test and verify
