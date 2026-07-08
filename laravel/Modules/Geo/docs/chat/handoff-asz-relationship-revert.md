---
title: handoff revert asz relationship bypass
type: chat
tags: [handoff, eloquent, asz, ptv, architecture]
updated: 2026-06-15
related:
  - ../wiki/rules/eloquent-relationship-encapsulation.md
  - ../wiki/patterns/scheda-asz-relationship-query.md
  - handoff-phpstan-modules-zero.md
---

# Handoff — revert bypass `asz()` in ListaAszTipCodEsclusoSubito

## Fatto

Ripristinata catena canonica:

```php
$scheda->asz()->ofRangeDate($asz_dal, $asz_al)->select(...)->distinct()->get()->toArray();
```

Rimosso anti-pattern `Asz00k1::query()->where(matr, ente, aszann)`.

## Wiki creata/aggiornata

- [eloquent-relationship-encapsulation.md](../wiki/rules/eloquent-relationship-encapsulation.md) — regola cardinale
- [eloquent-relationships-dry-kiss.md](../wiki/memories/eloquent-relationships-dry-kiss.md)
- [scheda-asz-relationship-query.md](../wiki/patterns/scheda-asz-relationship-query.md)

## Gate

`phpstan analyse Modules` → OK (701 file)

**Agente:** Auto (Cursor) · 2026-06-15
