---
title: "theme vite manifest workflow"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "theme vite manifest workflow"
issues: []
discussions: []
status: draft
---

# Theme Vite Manifest Workflow

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

Quando una Blade usa:

```blade
@vite(['resources/css/app.css', 'resources/js/app.js'], 'themes/<ThemeName>')
```

Laravel non usa `public/build/manifest.json`, ma:

```text
public_html/themes/<ThemeName>/manifest.json
```

Per i temi con build separata il contratto operativo e':

```bash
npm install
npm run build
<<<<<<< .merge_file_LR7UYK
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_A0LhRE
```

`build` genera il manifest del tema.
`copy` lo pubblica nella directory realmente letta dal renderer.
