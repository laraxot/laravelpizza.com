---
title: "claude theme dev"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "claude theme dev"
issues: []
discussions: []
status: draft
---

# CLAUDE Theme Development

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

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
<<<<<<< .merge_file_20p8Vb
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_RJQYYB
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
ForecastController@index   ← FORBIDDEN!
```

---

## 🔗 Link

- [Indice CLAUDE](./claude-split-index.md)
- [CLAUDE.md originale](../../CLAUDE.md)
- [CLAUDE.md originale](../CLAUDE.md)
- [Index principale](./index.md)
