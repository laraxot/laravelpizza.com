# Bugfix: IconColumn View Path Mismatch

**Data Fix**: 11 Novembre 2025
**Status**: ✅ RISOLTO

## Problema

**View Path Non Corrispondente**:

Il file `IconColumn.php` referenziava una view che non esisteva:

```php
protected string $view = 'ui::filament.tables.columns.icon-column';
// Cercava: icon-column.blade.php
// Esisteva: icon.blade.php
```

**Impatto**: Errore 404 quando la colonna veniva renderizzata.

## Causa Radice

**Inconsistenza Naming Convention**:

Analizzando tutte le colonne custom del modulo UI:

| File PHP | View Path (nel codice) | File View (reale) | Status |
|----------|------------------------|-------------------|--------|
| `IconColumn.php` | `icon-column` | `icon.blade.php` | ❌ MISMATCH |
| `TreeColumn.php` | `tree-column` | `tree.blade.php` | ❌ MISMATCH |
| `DummyActionsColumn.php` | `dummy-actions-column` | `dummy-actions.blade.php` | ❌ MISMATCH |
| `IconStateSplitColumn.php` | `icon-state-split-column` | `icon-state-split.blade.php` | ❌ MISMATCH |
| `GroupColumn.php` | `group` | `group.blade.php` | ✅ OK |

**Pattern Identificato**: I file view **NON** usano il suffisso `-column`.

## Soluzione Applicata

### 1. Correzione Path View (IconColumn.php)

```php
// ❌ PRIMA
protected string $view = 'ui::filament.tables.columns.icon-column';

// ✅ DOPO
protected string $view = 'ui::filament.tables.columns.icon';
```

### 2. Miglioramento Blade View (icon.blade.php)

**Problema Secondario**: Assignment in conditional + spacing issues

```php
// ❌ PRIMA
@if($icon = $getState())
    <x-icon class="h-6" name="{{$icon}}" />
@endif

// ✅ DOPO
@php
    $icon = $getState();
@endphp

@if($icon)
    <x-icon class="h-6" name="{{ $icon }}" />
@endif
```

**Miglioramenti**:
- ✅ Separata assegnazione da condizione (PSR-12 compliant)
- ✅ Spacing corretto in Blade (`{{ $icon }}` non `{{$icon}}`)
- ✅ Migliore leggibilità

## Gerarchia Classi

```
FilamentIconColumn (Filament)
└── XotBaseIconColumn (Xot - abstract)
    └── IconColumn (UI - non final, estendibile)
        └── IconStateColumn (UI - final)
```

**Nota**: `IconColumn` NON è `final` perché estesa da `IconStateColumn`.

## Verifica

- ✅ View path corretto
- ✅ File view esiste
- ✅ Assignment in conditional eliminato
- ✅ Blade syntax PSR-12 compliant
- ✅ Gerarchia classi rispettata

## File da Correggere (Same Issue)

Altri file con lo stesso problema:

- [ ] `TreeColumn.php` → cambiare view da `tree-column` a `tree`
- [ ] `DummyActionsColumn.php` → cambiare view da `dummy-actions-column` a `dummy-actions`
- [ ] `IconStateSplitColumn.php` → cambiare view da `icon-state-split-column` a `icon-state-split`

## Best Practice

**Convenzione Naming View**:
- File classe: `{Name}Column.php` (con suffisso `-column`)
- File view: `{name}.blade.php` (senza suffisso `-column`)

**Esempio**:
```php
// File: IconColumn.php
protected string $view = 'ui::filament.tables.columns.icon';
// View: icon.blade.php
```

## Riferimenti

- [Laraxot Architectural Rules](../../architecture_rules.md)
- [XotBaseIconColumn](../../../../Xot/app/Filament/Tables/Columns/XotBaseIconColumn.php)
- [Blade Best Practices](https://laravel.com/docs/blade)
