---
title: "Theme build e publish"
type: note
status: active
created: 2026-09-26
updated: 2026-11-16
tags: [documentation, themes, public_html]
qmd: "theme build publish public_html symlink xot theme-link npm build no copy"
---

# Theme Build & Publish Guide

> Gli asset dei temi arrivano in document root con un **symlink**, non con una copia.
> Canonico: [Xot theme-assets-workflow](../../../Xot/docs/theme-assets-workflow.md).
> `public_path()` = `public_html/` (mai `laravel/public`).

## Installazione dipendenze

Nella cartella del tema (es. `Themes/One`):

```bash
npm install
```

## Build e link

```bash
cd laravel/Themes/<Tema>
npm run build
# una volta per installazione:
php artisan xot:theme-link
# public_html/themes/<Tema> → symlink a ../../laravel/Themes/<Tema>/public
```

Niente `npm run copy`.
