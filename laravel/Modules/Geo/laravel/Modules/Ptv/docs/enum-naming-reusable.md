# Naming enum — concetto riutilizzabile, non consumer

## Scopo

Il nome di un enum descrive **cosa rappresenta** (concetto di dominio condiviso), non **dove** è usato per la prima volta (risorsa Filament, form, modulo figlio).

**Perché:** un operatore `=` o un tipo `string` vale per criteri esclusione, criteri valutazione, filtri dinamici, regole campo+valore. Nome legato a una sola risorsa impedisce il riuso e moltiplica enum quasi identici.

## Regola

| ❌ Nome legato al consumer | ✅ Nome sul concetto |
| :--- | :--- |
| `CriteriEsclusioneOpEnum` | `ComparisonOperatorEnum` |
| `CriteriEsclusioneValueTypeEnum` | `RuleValueTypeEnum` |
| `ListSchedaStatusEnum` (se lo stato è generico) | `WorkflowStatusEnum` |

### Quando il prefisso risorsa è corretto

Usare il nome della risorsa/entità **solo** se i casi sono **specifici** di quell’aggregato e non si riusano altrove:

- `CriteriEsclusioneEnum` — catalogo **nomi** criterio (`min_gg_propro`, `lista_posiz`, …): dominio proprio dell’esclusione.

### Checklist prima di creare l’enum

1. I valori si ripetono in più form/modelli? → nome **generico**.
2. Il backed `value` è già un vocabolario condiviso (SQL, tipo scalare)? → enum sul vocabolario.
3. Lang file: `comparison_operator_enum.php`, non `criteri_esclusione_op_enum.php`.
4. `EnumTrait` + `values.{value}.label` — vedi [enum-trait-pattern](../../Xot/docs/enum-trait-pattern.md).

## Esempi Ptv

| Concetto | Enum | Consumer (esempio) |
| :--- | :--- | :--- |
| Operatore confronto | `ComparisonOperatorEnum` | `CriteriEsclusioneResource` campo `op` |
| Tipo valore in regola | `RuleValueTypeEnum` | `CriteriEsclusioneResource` campo `type` |
| Nome criterio esclusione | `CriteriEsclusioneEnum` | solo criteri esclusione |

## Collegamenti

- [filament-select-options-enum](./filament-select-options-enum.md)
- [enum-trait-pattern](../../Xot/docs/enum-trait-pattern.md)
- [Progressioni — schemas/tables](../../Progressioni/docs/filament-resource-schemas-tables.md)
