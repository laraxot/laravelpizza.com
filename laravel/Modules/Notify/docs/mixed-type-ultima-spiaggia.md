---
title: "mixed type ultima spiaggia"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "mixed type ultima spiaggia"
issues: []
discussions: []
---

# Mixed (tipo di dato) - Solo come Ultima Spiaggia

**Regola**: `mixed` solo quando non esiste un tipo più stretto. Non è un shortcut per PHPStan.

## Perché

PHPStan a livello max non ragiona su `mixed`: ogni `(int)` / `->email` a valle è errore o bug silenzioso. In questo host i numeri (job, voti, importi) sono il Job dell'operatore. Dichiarare `mixed` sposta l'incertezza sull'utente.

## Preferenze (in ordine)

1. **Proprietà già tipizzate** — `$this->total_jobs`, non `$this->attributes['total_jobs']`
2. **Union types** - `string|int|null`
3. **Generics** - `Collection<int, User>`, `array<string, Component>`
4. **Interfacce / classi** - `ArrayAccess`, `Model`
5. **Bordo opaco** - `SafeStringCastAction` / `SafeIntCastAction` (modulo Xot)
6. **`mixed`** - solo API/JSON senza contratto, e documentato

`@var mixed` inline è sempre rumore: se serve narrowing, `is_*` o la firma a monte.
`TransCollectionAction` stringhifica la collection *prima* di tradurre, così `trans()` è `string`.
Helper che nel corpo fanno solo `is_string` (es. `isMasked`) vanno firmati `string`; proprietà DTO già tipizzate non servono `toString(mixed)` né `toBoolean(mixed)` (`ResolveFilamentUserConfigurationAction`, come il gemello SuperAdmin). Identificatore rate-limit notifiche è `int|string`.
`selectOne()` resta `mixed` alla fonte: si restringe **al call site** (`is_object || is_array`) e l'helper prende `object|array`. `@var int` su `$record->anno` è rumore: `is_int || is_string`, come `pluck('id')`.

`TValue` di `LazyCollection` / `Collection` è **invariante**: `mixed` lì non è il
caso generale, è un tipo diverso da `Model`. Allineare proprietà, costruttore e
`@return`. Una promoted property perde il generic del `@param`.
`pluck('id')` resta `mixed` sul valore: `is_int || is_string`, non `(string) $id`.
`Collection::map()` si aspetta `callable(mixed)`: una `Closure(array)` è troppo stretta.
Si itera il modello, non `collect($models->toArray())->map(array $item)`.
`Collection::toArray()` è di nuovo `mixed`: non si allarga la proprietà di destinazione
(`CedDiffImport::$columns` resta scalare|null, si filtra la cella).
Dettaglio export: [Xot export lazy](../../Xot/docs/export-xls-by-lazy-collection.md).

## Collegamenti

- [Xot PHPStan rules](../../Xot/docs/quality/phpstan-rules.md)
- [Xot Safe*CastAction](../../Xot/docs/safe-casting-actions.md)
- [Job: proprietà tipizzate](../../Job/docs/typed-model-properties-over-raw-attributes.md)
- [Campagna 5.10](../../Xot/docs/stories/5.10.mixed-narrowing-campaign.story.md)
- [Export XLS lazy / generic invarianti](../../Xot/docs/export-xls-by-lazy-collection.md)
