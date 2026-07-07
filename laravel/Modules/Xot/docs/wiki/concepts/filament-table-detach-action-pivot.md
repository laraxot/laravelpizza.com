---
title: "Filament table detach action pivot"
type: concept
status: approved
tags: [filament, tables, phpstan, pivot, xot]
created: 2026-07-07
updated: 2026-07-07
qmd: "filament table detach action pivot belongstomany phpstan xot"
issues:
  - "https://github.com/provtv/base_ptv_fila5/issues/177"
related:
  - "./xotbase-table-columns-enforcement.md"
---

# Filament table detach action pivot

> Le azioni detach vanno abilitate solo su relazioni `BelongsToMany`.

## Regola

In `HasXotTable`, prima di leggere il pivot class usare:

```php
if ($relationship instanceof BelongsToMany) {
    $pivotClass = $relationship->getPivotClass();
}
```

## Perche'

`getPivotClass()` e' contratto di `BelongsToMany`. Usare `method_exists()` su relazioni generiche lascia PHPStan con tipi deboli e introduce chiamate su valori non garantiti.
