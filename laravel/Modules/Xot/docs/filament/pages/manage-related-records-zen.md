# ManageRelatedRecords Zen

## Philosophy
`XotBaseManageRelatedRecords` is designed to provide a high-level, standardized interface for managing relationships in Filament. It follows the "Super Mucca" methodology of deep abstraction and explicit translation.

### Core Tenets
- **Zero-Config Localization**: Labels, placeholders, and helper texts must NEVER be set via `->label()`, `->placeholder()`, or `->helperText()`. The system handles them automatically if the key exists in the `lang` files.
- **Iconic Consistency**: Every action and column should have a visual marker. Users process icons faster than text.
- **Relative Time Context**: Dates are data, but "time ago" is information. Use relative formatting for timestamps.
- **Agnostic Structure**: The base class must remain pure of domain logic, providing only the structural "skeletal" support for relations.

## Religion
- **The Hash follows the ID**: All ID columns must be prefixed/accompanied by `heroicon-o-hashtag`.
- **The Plus signifies Creation**: `CreateAction` must use `heroicon-o-plus` and primary color.
- **Naming is Destiny**: The relationship name determines the automatic labels. Respect the naming conventions of the models.

## Politics
- **Header Actions**: Must always prioritize `CreateAction`. By default, `disableCreateAnother()` should be set to simplify the flow.
- **Table Striping**: Tables must be `striped()` to improve readability of dense relational data.
- **Ordering**: The default sort should be `id` desc to show the most recent relations first.

## Zen
- "A relation is a bridge between two worlds; the bridge must be clean."
- "Translate the intent, not just the word."
- "Visual hierarchy is the silent architecture of clarity."
- "A sexy UI is a predictable UI."
