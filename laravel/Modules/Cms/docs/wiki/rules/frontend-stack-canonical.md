---
tags: [documentation]
created: 2026-09-26
qmd: "frontend stack canonical"
issues: []
discussions: []
title: frontend stack canonico — cms module stub
type: rule
module: Cms
updated: 2026-06-03
---

# Stack frontend — modulo Cms

## Mantra progetto

```
Tailwind CSS v4 + Alpine.js v3 + Lit v3 + DaisyUI v5 + Flowbite + Filament v5 + Vite
```

Blocchi CMS e pagine Folio: classi Tailwind/DaisyUI nel tema; naming blocchi da Tailwind/Flowbite blocks. **NO** Bootstrap.

## Filament layout (obbligatorio)

Harness: agent FO/Cms che tocca `head.blade.php` / `foot.blade.php` o layout tema.
Comportamento: non rimuovere `@filamentStyles` (head) né `@filamentScripts` (foot); ordine Filament 5.x.
Copertura dedicata: [filament-layout-styles-scripts.md](../../bmad/filament-layout-styles-scripts.md) (questo file resta lo stack UI; quello è il contratto asset Filament).

## SSoT

- [Themes/Sixteen/docs/wiki/rules/frontend-stack-canonical.md](../../../../../Themes/Sixteen/docs/wiki/rules/frontend-stack-canonical.md)
- [cms-block-naming-tailwind-flowbite.md](../../../../../Themes/Sixteen/docs/wiki/rules/cms-block-naming-tailwind-flowbite.md)

## Story

[STORY-133](../../../../../../docs/stories/STORY-133-frontend-stack-religion-tailwind-alpine-lit.md)
