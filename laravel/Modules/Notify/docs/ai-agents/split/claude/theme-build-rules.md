---
title: "theme build rules"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "theme build rules"
issues: []
discussions: []
status: draft
---


> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

=== theme build rules ===

## CRITICAL: Theme Build Process

**NEVER FORGET THIS RULE**: After ANY modification to CSS, JavaScript, or Tailwind configuration files in a theme, you MUST run the build commands from the theme directory:

### Required Commands (ALWAYS):
```bash
cd /var/www/html/_bases/base_fixcity_fila5_mono/laravel/Themes/Sixteen
cd /var/www/html/_bases/base_ptvx_fila5_mono/laravel/Themes/Sixteen
npm run build
<<<<<<< .merge_file_5t3E61
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_rEuTe3
```

### When to Run:
- After modifying `tailwind.config.js`
- After modifying `resources/css/app.css` 
- After modifying any JavaScript files
- After adding new Tailwind classes to Blade files
- After ANY frontend changes

### Why This Is Critical:
- The Laravel application reads compiled assets from the theme's `resources/dist/` directory
- Without `npm run build`, Tailwind won't compile new classes or changes
<<<<<<< .merge_file_5t3E61
- niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`
=======
- Without `public_html/themes/<Tema>` symlinked to `laravel/Themes/<Tema>/public` (`npm run copy` dismesso), the changes won't be available to the main Laravel application
>>>>>>> .merge_file_rEuTe3
- Users will NOT see any frontend changes without these steps

### Remember:
- Changes to CSS/JS are INVISIBLE until built (`npm run build`)
- Always build from the specific theme directory (`Themes/Sixteen/`)
- Asset pubblicati via symlink `public_html/themes/<Tema>` → `Themes/<Tema>/public` (`php artisan xot:theme-link`); `npm run copy` e' dismesso

This is a fundamental rule that must NEVER be forgotten when working with themes.


---
## Cross-References

- ← [CLAUDE Index](INDEX.md): All Laravel Boost guidelines
- ← [Main AI Docs Index](../INDEX.md): Master index
- ← [CLAUDE Index](index.md): All Laravel Boost guidelines
- ← [Main AI Docs Index](../index.md): Master index
- ← [../../../../docs/CLAUDE.md](../../../../docs/../../../../docs/CLAUDE.md): Original source

