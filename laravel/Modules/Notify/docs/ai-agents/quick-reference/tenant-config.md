---
title: "tenant config"
type: note
tags: [documentation]
created: 2026-09-26
<<<<<<< .merge_file_x8khiL
<<<<<<< .merge_file_8oRmEA
updated: 2026-11-23
=======
=======
>>>>>>> .merge_file_bP1CTq
<<<<<<< HEAD
updated: 2026-09-26
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_x8khiL
>>>>>>> .merge_file_VKL7nA
=======
>>>>>>> .merge_file_bP1CTq
qmd: "tenant config"
issues: []
discussions: []
status: draft
---

# Quick Reference - Tenant Config

## Verifiche base

```php
config('app.url');
app(\Modules\Tenant\Actions\GetTenantNameAction::class)->execute();
config('it.<nome progetto>.manager.morph_map');
\Illuminate\Database\Eloquent\Relations\Relation::morphMap();
```

## Problema tipico

- Il worker usa config vecchia/cached o tenant path inatteso.

## Azioni

1. verificare tenant risolto
2. verificare chiavi config effettivamente caricate
3. riallineare provider/morph map
4. restart queue worker
