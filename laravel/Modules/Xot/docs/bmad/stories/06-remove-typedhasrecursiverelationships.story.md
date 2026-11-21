---
title: "Remove TypedHasRecursiveRelationships wrapper - use vendor HasRecursiveRelationships directly"
type: story
module: Xot
epic: quality
story_id: "2026-10-06-remove-typedhasrecursiverelationships"
status: done
track: quality/refactor
related:
  - 2026-10-06-phpstan-modules-level10.story.md
---

# Remove TypedHasRecursiveRelationships wrapper

## Obiettivo funzionale

Rimuovere il trait wrapper `TypedHasRecursiveRelationships` e usare direttamente il trait vendor `Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships` nei modelli. Aggiornare il contratto `HasRecursiveRelationshipsContract` per usare `static` come tipo di ritorno invece di `Model` per compatibilità con PHPStan Level 10.

## Stato iniziale

- `TypedHasRecursiveRelationships` esiste in `Modules/Xot/Models/Traits/TypedHasRecursiveRelationships.php`
- 4 classi lo usano: `XotBaseTreeModel`, `BaseTreeModel` (Xot), `Menu`, `BaseTreeModel` (Cms)
- Il contratto `HasRecursiveRelationshipsContract` richiede return types `Ancestors<Model, Model>` ecc.
- Il vendor trait `HasRecursiveRelationships` restituisce `Ancestors<static, static>` ecc.

## Criteri di accettazione

- [x] `TypedHasRecursiveRelationships` rimosso
- [x] `HasRecursiveRelationshipsContract` aggiornato con template covariante `TModel`
- [x] Tutti i 4 modelli usano `use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;`
- [x] PHPStan Level 10 passa su tutti i moduli
- [x] Test Pest: errori preesistenti su temi mancanti (non correlati)
- [x] Story aggiornata con esito

## Diario

- 2026-10-06: Story creata, analisi iniziata
- 2026-10-06: Capito il "perché": il wrapper aggiunge complessità; usando template covariante nel contratto + vendor trait diretto, PHPStan inferisce i tipi dal trait vendor (docblock `@return Ancestors<static, static>`) e il contratto è soddisfatto.
- 2026-10-06: Xot (`BaseTreeModel`, `XotBaseTreeModel`) e Cms `BaseTreeModel` usano il trait vendor; wrapper cancellato. Cms `Menu` aggiornato.
- 2026-10-06: Risolti tutti gli errori PHPStan Level 10 su tutti i moduli (31 errori iniziali → 0)
- 2026-10-06: Story completata

## Note tecniche

Il pattern chiave: in PHP 8.0+, template covariante `@template-covariant TModel of Model` nell'interfaccia permette di usare `TModel` nelle posizioni di ritorno. Il vendor trait ha docblock `@return Ancestors<static, static>` che PHPStan usa per inferire i tipi. Con il contratto covariante, `HasRecursiveRelationshipsContract<Menu>` è sottotipo di `HasRecursiveRelationshipsContract<Model>`.

Modelli aggiornati:
- `Modules\Xot\Models\XotBaseTreeModel`
- `Modules\Xot\Models\BaseTreeModel`
- `Modules\Cms\Models\BaseTreeModel`
- `Modules\Cms\Models\Menu`

File rimosso: `Modules/Xot/Models/Traits/TypedHasRecursiveRelationships.php`