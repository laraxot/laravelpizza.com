---
title: Gerarchia widget Filament — solo XotBase*
type: concept
tags: [filament, widget, xotbase, architecture]
qmd:
  index: true
created_at: 2026-06-10
updated_at: 2026-06-10
---

# Gerarchia widget Filament — solo XotBase*

## Perché (religione Laraxot)

Filament è **vendor**. `Modules\Xot\Filament\*` è il **ponte**: traduzioni, view auto (`GetViewByClassAction`), policy UX, upgrade Filament v5 centralizzato. I moduli **non** estendono mai `Filament\Widgets\*` direttamente.

Pattern: namespace `Modules\Xot\…` + prefisso classe `XotBase` = contratto minimo del dominio.

## Albero scelta (KISS)

| Esigenza | Estendere |
|----------|-----------|
| Vista custom, azioni, listener Livewire | `XotBaseWidget` |
| Form/schema (campi da `*Form` o `getFormSchema`) | `XotBaseSchemaWidget` |
| Wizard multi-step | `XotBaseWizardWidget` |
| Infolist read-only FO | `XotBaseInfolistWidget` |
| Grafico | `XotBaseChartWidget` |
| Tabella in widget | `XotBaseTableWidget` |
| Stats overview | `XotBaseStatsOverviewWidget` |

**Vietato nei moduli:** `extends Filament\Widgets\Widget` (e analoghi Chart/Table/Stats).

Eccezione: solo codice **dentro** `Modules\Xot` che definisce le basi.

## Esempio Comment FO

`CommentsWidget` → `XotBaseSchemaWidget` (view custom + `getFormSchema(): []`).

## Collegamenti

- [filament-widgets-domain-folder-naming](./filament-widgets-domain-folder-naming.md)
- [Comment FO widgets](../../../Comment/docs/wiki/concepts/fo-filament-widgets-no-livewire.md)

## View auto (no render pigro)

- `GetViewByClassAction` nel costruttore `XotBaseWidget` → `module::filament.widgets.{domain}.{kebab-class}`.
- `$view` nel widget figlio: **solo commentato** come promemoria.
- Condizioni UI (record null) → **Blade**, non `render()`.
