---
title: "theme vite manifest workflow"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "theme vite manifest workflow"
issues: []
discussions: []
<<<<<<< HEAD
=======
status: draft
>>>>>>> laraxot/dev
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
<<<<<<< .merge_file_3ejOIJ
<<<<<<< .merge_file_ZmQgzB
<<<<<<< .merge_file_RRqiVP
# public_html/themes/<Tema> è un symlink a laravel/Themes/<Tema>/public: niente copia (Modules/Xot/docs/wiki/concepts/public-html-symlink-assets.md)
=======
=======
>>>>>>> .merge_file_xf0Nd0
=======
>>>>>>> .merge_file_yTIRBb
<<<<<<< HEAD
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
<<<<<<< HEAD
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
# public_html/themes/<Tema> è un symlink a laravel/Themes/<Tema>/public: niente copia (Modules/Xot/docs/wiki/concepts/public-html-symlink-assets.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_3ejOIJ
<<<<<<< .merge_file_ZmQgzB
>>>>>>> .merge_file_XVsOBI
=======
>>>>>>> .merge_file_xf0Nd0
=======
>>>>>>> .merge_file_yTIRBb
```

`build` genera il manifest del tema.
`copy` lo pubblica nella directory realmente letta dal renderer.
