---
title: "claude pitfalls"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "claude pitfalls"
issues: []
discussions: []
status: draft
---

# CLAUDE Common Pitfalls

> **Obsoleto: `npm run copy` non esiste piu' (2026-11-11).** Gli asset dei temi
> arrivano nella document root con un symlink, non con una copia. Per il
> procedimento valido vedi
> [Xot/docs/theme-assets-workflow.md](/laravel/Modules/Xot/docs/theme-assets-workflow.md).
> Le istruzioni di copia qui sotto sono lasciate come documentazione storica.

Errori comuni da evitare.

## Errori Architetturali

### 1. ❌ Controller per Front Office
**✅ CORRETTO**: Usare Folio + Volt + JSON pages

---
### 2. ❌ Connessioni Per-Modulo in Config
**✅ CORRETTO**: Seguire Laravel 12 standard - solo driver connections

---

### 3. ❌ SVG Inline in Blade
**✅ CORRETTO**: Creare .svg in `Modules/Meetup/resources/svg/` e usare `<x-filament::icon>`

---

### 4. ❌ URL Localizzati Manuali
**✅ CORRETTO**: Usare `LaravelLocalization::localizeUrl('/path')`

---

### 5. ❌ Estendere Filament Diretto
**✅ CORRETTO**: Sempre estendere XotBase abstracts

---

### 6. ❌ Duplicate Migration Files
**✅ CORRETTO**: One table, one create migration

---

### 7. ❌ ServiceProvider Complessi
**✅ CORRETTO**: Usare struttura minimale - lasciare che XotBase faccia il lavoro

---

### 8. ❌ Proprietà Richieste Mancanti nei Provider
**✅ CORRETTO**: Includere SEMPRE `$module_dir`, `$module_ns`

---

### 9. ❌ Non Chiamare parent::boot()
**✅ CORRETTO**: Chiamare SEMPRE parent prima

---

### 10. ❌ Hardcoding Stringhe in UI
**✅ CORRETTO**: Usare translation files

---

### 11. ❌ Business Logic in Blade/Livewire
**✅ CORRETTO**: Usare Actions pattern

---

### 12. ❌ Missing declare(strict_types=1)
**✅ CORRETTO**: Aggiungere a ogni file PHP

---

### 13. ❌ UPPERCASE o CamelCase .md Filenames
**✅ CORRETTO**: Usare lowercase-with-hyphens.md

---

<<<<<<< .merge_file_tC3XR9
niente `npm run copy`: `public_html/themes/<Tema>` è un symlink a `../../laravel/Themes/<Tema>/public`
**✅ CORRETTO**: Sempre eseguire copy per deploy assets
=======
### 14. ❌ Dimenticare il symlink `public_html/themes/<Tema>` dopo theme build (`npm run copy` dismesso)
**✅ CORRETTO**: Verificare che `public_html/themes/<Tema>` sia symlink a `laravel/Themes/<Tema>/public` (`php artisan xot:theme-link`, una volta per installazione); `npm run copy` non serve più.
>>>>>>> .merge_file_szNhtH

---

## 🔗 Link

- [Indice CLAUDE](./claude-split-index.md)
- [critical-rules.md](./critical-rules.md)
- [CLAUDE.md originale](../../CLAUDE.md)
- [CLAUDE.md originale](../CLAUDE.md)
- [Index principale](./index.md)
