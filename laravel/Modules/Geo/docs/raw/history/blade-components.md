# Blade Components

## GroupColumn – Gestione automagica delle label (18 Nov 2025)

- **Problema**: la view `ui::filament.tables.columns.group` mostrava le chiavi (`ui::table.columns.*`) invece delle traduzioni reali.
- **Soluzione**: il componente ora usa `getLabel()` (already translated da LangServiceProvider) con fallback progressivi:
  1. `getLabel()` (incluse Closure / Htmlable)
  2. `__('ui::table.columns.{name}.label')`
  3. `Str::headline($name)`
- **Benefici**: traduzioni corrette senza hardcode di namespace, compatibilità con l'automazione LangServiceProvider, zero regressioni sui record.

Per tutti i dettagli tecnici vedere [`Modules/UI/docs/bugfix/groupcolumn-architectural-violations.md`](../laravel/Modules/UI/docs/bugfix/groupcolumn-architectural-violations.md).

