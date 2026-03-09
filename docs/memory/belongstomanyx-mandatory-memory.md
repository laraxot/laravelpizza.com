# Memory: belongsToManyX Mandatory

**Date**: 2026-03-09

## Regola

Nel progetto LaravelPizza le relazioni many-to-many devono usare `belongsToManyX(...)`.

## Impatto operativo

- evitare introduzione di `belongsToMany(...)` nei modelli applicativi
- uniformare le relazioni esistenti quando si interviene sui file
- aggiornare test Pest e documentazione quando viene fatta conversione

## Verifica rapida

```bash
rg -n "belongsToMany\\(" laravel/Modules
```
