---
title: "Modelli Eloquent: XotBaseModel e regole"
type: rule
status: active
module: Xot
qmd: "XotBaseModel XotBaseUuidModel getClassName casts schemaless attributes HasExtraTrait Updater connessione modulo trait shadow"
updated: 2026-11-25
---

# Modelli Eloquent: XotBaseModel e regole

Ogni modello dei moduli estende una base di Xot, mai `Illuminate\Database\Eloquent\Model` (regola generale in [xotbase-extension-rules.md](xotbase-extension-rules.md)).

## Le basi (`Modules\Xot\Models`)

| Classe | Quando |
|---|---|
| `XotBaseModel` | modello standard; compone `HasCustomRelations`, `HasXotFactory`, `RelationX`, `Updater`; `$perPage = 30`, `$snakeAttributes = true`, connessione di default `xot` |
| `XotBaseUuidModel` | chiave stringa non incrementale (`$incrementing = false`, `$keyType = 'string'`) |
| `XotBaseTreeModel` | alberi / liste di adiacenza (`Staudenmeir\LaravelAdjacencyList\...\HasRecursiveRelationships`: `parent()`, `children()`, `ancestors()`, `descendants()`, `toTree()` arrivano dal trait e non si ridichiarano) |
| `XotBasePivot`, `XotBaseMorphPivot` | pivot delle many-to-many (vedi [traits/relation-x.md](traits/relation-x.md)) |

`HasCommonScopes` (scope `published` su `published_at`) **non** sta su `XotBaseModel`: rompe i modelli con un proprio `scopePublished` (es. su `status`); si
aggiunge solo ai modelli di dominio che lo vogliono.

## Regole

1. **`casts()` e non `$casts`**: `protected function casts(): array`. La base dichiara i cast comuni (`id`/`uuid` string, `created_at`/`updated_at`/`deleted_at`/
   `published_at`/`verified_at` datetime, `created_by`/`updated_by`/`deleted_by` string); una sottoclasse unisce i propri cast a quelli del parent.
2. **Connessione**: ogni modulo ha la sua connessione, aggiunta dinamicamente da `TenantServiceProvider::registerDB()` come copia della default; i modelli non
   nominano mai un database hardcoded. Due moduli possono avere lo **stesso nome di tabella su connessioni diverse**: per questo la classe giusta si risolve per
   modulo (punto 3), mai con un ripiego su un altro modulo (restituirebbe righe di un altro ente senza errori).
3. **`getClassName()`**: `Modello::getClassName()` (senza argomenti, senza `static::`) risolve il concreto del **modulo chiamante** mantenendo il basename
   (`Modules\<ModuloChiamante>\Models\<Modello>`), dall'oggetto chiamante nel backtrace; fa `Assert::classExists` e lancia se al modulo manca il modello.
   Guardia: `tests/Unit/Models/ClassResolutionUsesGetClassNameTest.php` (tetto zero, legge il sorgente).
4. **Creatore/aggiornatore**: il trait `Updater` valorizza `created_by`/`updated_by`/`deleted_by` e fornisce `creator()`/`updater()`/`deleter()` verso la classe profilo
   configurata in `XotData` (`getProfileClass()`, chiave `user_id`).
5. **Attributi JSON liberi** (`spatie/laravel-schemaless-attributes`): colonna creata con la macro `$table->schemalessAttributes('extra')` nella migrazione
   (vedi [laraxot-migration-philosophy-summary.md](laraxot-migration-philosophy-summary.md)); nel modello il cast va importato da
   `Spatie\SchemalessAttributes\Casts\SchemalessAttributes` (non dalla classe-valore `Spatie\SchemalessAttributes\SchemalessAttributes`) oppure si usa
   `SchemalessAttributesTrait` (es. `BaseProfile`, `StoredEvent`). Adatti a metadati e preferenze, non ai dati di business centrali.
6. **Extra polimorfico**: `HasExtraTrait::extra()` e' una `MorphOne` verso `Modules\<ModuloDelModello>\Models\Extra` (classe obbligatoria nel modulo).
7. **Un trait non si ridichiara**: se la classe compone un trait, non riscrive a mano un suo metodo (vince in silenzio quello della classe e si perde il
   comportamento del trait, per esempio `ancestors()`/`descendants()`). Guardie: `tests/Unit/Models/NoMethodShadowsComposedTraitTest.php`,
   `AdjacencyListRelationsNotRedeclaredTest.php`.
8. **Many-to-many**: sempre `belongsToManyX`; per le tabelle condivise riconosciute da nome tabella `tableMorphMany`.
9. Modelli di pacchetti terzi: si estende nel modulo che li usa, mantenendo la base Xot nella catena (es. profilo su `BaseModel`), senza modificare il vendor.

## Guardie

`tests/Unit/Models/` (`XotBaseModelTest`, `BaseModelTest`, `XotBaseModelBusinessLogicTest`, i test sopra) e la regola `xotbase` di `tests/Arch/ArchitectureTest.php`.

## Vedi anche

- [adr/0004-one-model-one-migration.md](adr/0004-one-model-one-migration.md): un modello, una migrazione owner.
