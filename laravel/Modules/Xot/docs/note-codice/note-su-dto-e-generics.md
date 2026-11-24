---
title: "Note su DTO, action e generics in PHP"
type: archive
tags: [archivio, dto, spatie-data, generics, phpstan]
created: 2026-11-20
updated: 2026-11-20
qmd: "note DTO data transfer object action generics PHP collezioni tipizzate"
issues: [247]
discussions: []
---

# Note su DTO, action e generics in PHP

Stava in `Modules/Xot/app/DTOs/links.md`, in una cartella di codice, ed era il
solo motivo per cui `app/DTOs/` esisteva — una cartella che la regola vuole
chiamata `Datas/` (base_quaeris_fila5#247).

Link e frammenti sul tema delle collezioni tipizzate a mano e dei generics, da
prima che il progetto adottasse `spatie/laravel-data`. Materiale di studio, non
documentazione di come funzionano le cose qui.

---

https://martinjoo.dev/how-to-use-data-transfer-objects-and-actions-in-laravel




//---- collezioni a mano 
https://blog.programster.org/php-creating-strict-type-arrays      !!!!!!!!!!!!!


https://phpstan.org/r/813cc9a7-19d7-4127-ac1e-8275d38647d2



https://stitcher.io/blog/generics-in-php-1   !!

class Collection<Type> extends ArrayObject
{
    public function offsetGet(mixed $key): Type 
    { /* … */ }
    
    // …
}

