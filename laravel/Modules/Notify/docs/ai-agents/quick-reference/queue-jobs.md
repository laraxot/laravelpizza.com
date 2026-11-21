---
title: "queue jobs"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "queue jobs"
issues: []
discussions: []
---

# Quick Reference - Queue / Jobs

## Errori comuni

- `Out of range value for column 'attempts'`
  - Causa probabile: job in loop/fail retry elevato + colonna piccola.
  - Azione: pulire job bloccati, correggere causa root del fail, verificare schema `jobs.attempts`.

- `Class "user" not found` in morph
  - Causa probabile: morph map non allineata nel tenant config caricato dal worker.
  - Check:
    - config tenant attiva (`it/.../manager`)
    - `Relation::morphMap()` popolata correttamente
    - restart worker dopo cambio config/cache

## Comandi utili

```bash
cd laravel
php artisan queue:restart
php artisan config:clear
php artisan cache:clear
php artisan tinker
```
