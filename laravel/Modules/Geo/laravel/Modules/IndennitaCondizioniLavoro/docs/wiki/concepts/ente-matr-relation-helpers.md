# HasEnteMatrRelationHelpers su schede modulo

## Scopo

`CondizioniLavoro` e `ServizioEsterno` usano `RelationshipTrait`, che compone i trait Sigma `EnteMatrRelationship` / `EnteMatrDateRangeRelationship`. Questi chiamano `hasManyByEnteMatr()` e `hasOneByEnteMatr()`.

Il `BaseModel` di **IndennitaCondizioniLavoro** non estende `Sigma\Models\BaseModel` (dove il helper è già incluso). Senza `HasEnteMatrRelationHelpers` si ottiene `BadMethodCallException` su relazioni come `asz00k1()` (es. pagina `CompilaCondizioniLavoro`, accessor `hh_assenza_anno`).

## Regola

| Layer | Cosa fare |
| :--- | :--- |
| `RelationshipTrait` | `use HasEnteMatrRelationHelpers` prima dei trait `EnteMatr*` |
| Modello | Implementare `EnteMatrFieldsContract` (`matrField()`, `enteField()`) |

Stesso pattern di `Ptv\Models\BaseScheda` — vedi [Sigma — has-ente-matr-relation-helpers](../../../Sigma/docs/wiki/concepts/has-ente-matr-relation-helpers.md).

## Collegamenti

- [Sigma — ente-matr-field-ownership](../../../Sigma/docs/wiki/concepts/ente-matr-field-ownership.md)
- [IndennitaResponsabilita — Ptv vs Sigma](../../../IndennitaResponsabilita/docs/wiki/concepts/ente-matr-relazioni-ptv-scheda.md)
