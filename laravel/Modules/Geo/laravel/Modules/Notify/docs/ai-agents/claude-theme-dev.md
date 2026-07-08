# CLAUDE Theme Development

Guida allo sviluppo del tema Meetup.

## Theme Development (Meetup Theme)

Il Meetup theme è una **VERSIONE MIGLIORATA** di laravelpizza.com usando Tailwind CSS + Alpine.js.

### Obiettivi di Miglioramento

- ✨ Design moderno e accattivante
- 🚀 Migliori animazioni e interazioni
- 🎯 Clickbait-worthy headlines e CTAs
- 💥 Viral-ready social sharing
- 🔥 Conversion-optimized user flows

Il tema deve far dire "WOW!" ai visitatori.

---

## Setup & Build

```bash
cd laravel/Theme/Meetup

# Development
npm run dev

# Production build
npm run build
npm run copy    # MUST run after build to copy to public_html
```

---

## Key Files

- `resources/css/app.css` - Tailwind styles
- `resources/js/app.js` - Alpine.js components
- `resources/views/pages/` - Folio routes
- `resources/views/components/blocks/` - Reusable block components
- `resources/views/layouts/` - Page layouts

---

## Layout Hierarchy

- `x-layouts.main` - Base HTML shell (no header/footer)
- `x-layouts.app` - Full layout with nav + footer (public pages)
- `x-layouts.guest` - Auth pages (login/register)

---

## Front Office Architecture

### ✅ CORRETTO

```
Folio (routing)
├── Theme Fallback: [container0]/[slug0]/index.blade.php
├── Volt (anonymous Livewire - OK for Folio)
└── Blade Components (modular)
```

### ❌ SBAGLIATO

```
Themes/*/Http/Livewire/  ← FORBIDDEN!
PredictController@index   ← FORBIDDEN!
```

---

## 🔗 Link

- [Indice CLAUDE](./claude-split-index.md)
- [CLAUDE.md originale](../../CLAUDE.md)
- [Index principale](./index.md)
