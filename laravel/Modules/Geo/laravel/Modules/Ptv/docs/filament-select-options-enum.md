# Select Filament — options da enum, non array hardcoded

## Scopo

Le `Select` Filament con opzioni fisse di dominio **non** usano array inline `->options([...])`. Usano enum backed PHP con `EnumTrait` e traduzioni in `lang/`.

**Perché:** type safety, DRY, label/color/icon centralizzati, Filament risolve `HasLabel` automaticamente, niente stringhe duplicate tra form/resource/test.

## Regola

| Anti-pattern | Pattern corretto |
| :--- | :--- |
| `->options(['=' => 'Uguale a', ...])` | `->options(ComparisonOperatorEnum::class)` |
| `match ($this) { ... }` in enum per label | `use EnumTrait` + `lang/{locale}/{enum_snake}.php` |
| `->label()` su Select | LangServiceProvider / traduzioni enum |
| Enum chiamato come la risorsa consumer | Nome sul **concetto** — vedi [enum-naming-reusable](./enum-naming-reusable.md) |

### Workflow

1. Identificare insieme chiuso di valori (operatori, tipi, stati).
2. Scegliere nome enum sul **concetto riutilizzabile** (non sul form che lo usa per primo).
3. Creare `Modules\{Modulo}\Enums\{Nome}Enum` backed `string` (o `int`).
4. `implements HasLabel` (+ `HasColor`, `HasIcon` se serve UI).
5. `use Modules\Xot\Traits\EnumTrait`.
6. File traduzione `lang/it/{snake_case_enum}.php` con chiave `values.{value}.label`.
7. Form: `Select::make('campo')->options(NomeEnum::class)`.

Contratto completo: [Xot — EnumTrait pattern](../../Xot/docs/enum-trait-pattern.md).

## Esempio CriteriEsclusione

| Campo form | Enum (concetto) |
| :--- | :--- |
| `op` | `ComparisonOperatorEnum` |
| `type` | `RuleValueTypeEnum` |
| `name` | `CriteriEsclusioneEnum` (catalogo specifico — ok prefisso entità) |

Form: `BaseCriteriEsclusioneForm`; Resource delega al form (no schema duplicato).

## Benefici

- **Business logic:** un solo elenco valori ammessi, riusabile tra risorse.
- **i18n:** etichette in `lang/`, non nel PHP del form.
- **Filament:** enum `HasLabel` → select native senza callback.
- **PHPStan:** backed enum invece di `string` magico.
- **Test:** Pest verifica casi, trait e traduzioni.

## Collegamenti

- [enum-naming-reusable](./enum-naming-reusable.md)
- [enum-trait-pattern](../../Xot/docs/enum-trait-pattern.md)
- [filament-resource-base-inheritance](./filament-resource-base-inheritance.md)
- [translations-status](./translations-status.md)
