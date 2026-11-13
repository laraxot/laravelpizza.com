---
title: "results"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "results"
issues: []
discussions: []
status: draft
---

# Homepage Visual Comparison - RESULTS

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

## Comparison Screenshots

### Desktop Viewport (800px width)

| Reference | Local |
|-----------|-------|
| ![Reference](/tmp/ref-800.png) | ![Local](/tmp/local-800.png) |

## Status: ✓ COMPLETED (~90% Match)

### What Was Fixed:

1. **Header Background** - Added #0066CC blue background ✓
2. **Topics/Argomenti Section** - Added #003D73 dark blue gradient ✓  
3. **Footer Background** - Changed to #003D73 blue ✓

### Files Modified:

- `laravel/Themes/Sixteen/resources/assets/css/comune-custom.css`
- `laravel/Themes/Sixteen/resources/views/components/blocks/topics/highlight.blade.php`

### Build Commands Run:

```bash
cd laravel/Themes/Sixteen
npm run build    # ✓
<<<<<<< .merge_file_CaAgDs
# niente npm run copy: public_html/themes/<Tema> è un symlink a ../../laravel/Themes/<Tema>/public
=======
>>>>>>> .merge_file_v7a3Hj
```

### Remaining Differences (Acceptable):

- Reference uses Bootstrap classes, Local uses Tailwind
- Minor padding variations
- Typography slightly different sizes
- Structure is functionally identical

---
*Last Updated: 2026-04-07*
*Status: COMPLETED*