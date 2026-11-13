---
title: "theme build"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "theme build"
issues: []
discussions: []
status: draft
---

# Theme Build & Publish Guide

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

## Installazione dipendenze

All'interno di `Themes/One`, installa i plugin necessari per Filament 3.x con:
```bash
npm install tailwindcss@3 @tailwindcss/forms @tailwindcss/typography postcss postcss-nesting autoprefixer --save-dev
```

Per aggiornare il tema **One**, eseguire i seguenti passi all'interno della cartella del tema:

```bash
cd Themes/One

# 1. Compilare asset (Tailwind, JavaScript, CSS):
npm run build

<<<<<<< .merge_file_R7YDz0
# 2. Pubblicare asset nella cartella pubblica:
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
# 2. Niente copia: public_html/themes/<Tema> e' un symlink a Themes/<Tema>/public
#    (php artisan xot:theme-link, una volta per installazione)
>>>>>>> .merge_file_xDq7Rb
```

> **Requisito:** Filament 3.x supporta solo **Tailwind CSS 3.x**. Verificare in `package.json` di avere `"tailwindcss": "^3.x"` come dipendenza.

Se è la prima volta, verificare di aver eseguito `npm install` per le dipendenze.
