---
title: "MAI passare ciò che il modello sa già"
module: Sigma
type: rule
tags: [architecture, dry, contracts, anti-pattern]
updated: "2026-06-15"
---

# Regola: MAI passare come parametro ciò che il modello espone via contratto

## Enunciato

Se un modello implementa un contratto che espone un metodo (es. `annFieldName()`), il metodo helper che opera sul modello **interroga il contratto** — non riceve la stessa informazione come parametro stringa.

## Esempio

```php
// ❌ SBAGLIATO — 'quaann' è ridondante, Qua00f::annFieldName() lo restituisce già
$this->relatedByAnno(Qua00f::class, 'quaann');
$this->hasManyByEnteMatr(Qua00f::class)->where('quaann', '');

// ✅ CORRETTO — il helper legge annFieldName() dal modello via contratto
$this->hasManyByEnteMatr(Qua00f::class);
```

## Meccanismo

`hasManyByEnteMatr()` chiama `applyRelatedActiveAnnFilter()` che:
1. Verifica `is_a($related, DateRangeFieldsContract::class, true)`
2. Istanzia il modello: `$instance = new $related`
3. Chiama `$instance->annFieldName()` → `'quaann'`
4. Applica `->where('quaann', '')`

## Perché

- **DRY**: Se il campo cambia, basta aggiornare il modello — non N caller
- **Fonte di verità unica**: Il modello descrive sé stesso via contratto
- **Zero rischio disallineamento**: Non servono stringhe sparse nel codice
- **PHPStan-friendly**: Il contratto garantisce type safety

## Violazioni residue note

17 occorrenze `whereRaw('...ann=""')` residue — da eliminare progressivamente migrando i modelli a `BaseDateRangeModel`.
