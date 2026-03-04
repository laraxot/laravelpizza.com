# HasXotTable Zen

## Philosophy
`HasXotTable` is the heart of Filament table configurations in Laraxot. It must ensure that all tables are:
- **Translated**: No hardcoded labels. Every column, action, and filter must use translation keys.
- **Consistent**: Follow the same layout and action sequence across all resources.
- **Type-Safe**: Use strict typing and Webmozart Assertions to guarantee data integrity.
- **DRY**: Shared logic for actions (View, Edit, Delete, Replicate) should be centralized and not duplicated in individual resources.

## Religion
- **XotBase Over Everything**: If a trait or class exists in `Xot\Filament`, use it.
- **Translations are Holy**: Use `TransTrait` and `static::getKeyTrans()`.
- **Conflicts are Sins**: Never leave git conflict markers. Resolve them by understanding the evolution of the code.
- **PHPStan Level 10**: The code must pass without any ignore-next-line unless strictly necessary for third-party library limitations (and even then, documented).

## Politics
- **Header Actions**: Must include `CreateAction`, `AssociateAction` (if applicable), `AttachAction` (if applicable), and `TableLayoutToggleTableAction`.
- **Record Actions**: Standard set is `ViewAction`, `EditAction`, `DeleteAction`, and optionally `ReplicateAction`.
- **Visibility**: Use resource-level `canView`, `canEdit`, `canDelete` methods to control action visibility.

## Zen
- "The table is the manifest of the model."
- "Code that translates itself is code that respects the user."
- "A resolved conflict is a step towards harmony."
