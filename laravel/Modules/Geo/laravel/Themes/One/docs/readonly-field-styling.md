# Readonly Field Styling - UI/UX Pattern

**Theme**: One  
**Date**: 2026-02-11  
**Status**: Standard attivo

---

## Panoramica

Pattern standard per lo stile visivo dei campi readonly (calcolati/computati) nei form Filament. Condiviso con il tema Zero per garantire coerenza cross-theme.

## Pattern Standard

### Classi Tailwind CSS

```php
->readOnly()
->extraInputAttributes([
    'class' => 'bg-blue-50 dark:bg-blue-950/30 border-l-4 border-l-blue-400 dark:border-l-blue-500 text-blue-900 dark:text-blue-100 cursor-not-allowed',
])
```

### Gerarchia visiva

| Tipo campo | Sfondo Light | Sfondo Dark | Bordo | Cursore |
|------------|-------------|-------------|-------|---------|
| Editabile | `#ffffff` (bianco) | Tema scuro standard | Nessuno extra | `text` |
| Readonly/Calcolato | `#eff6ff` (azzurro) | `rgba(23,37,84,0.3)` | `border-l-4 blue-400` | `not-allowed` |

## Principi di design

- **Blu = sistema/calcolato**: Colore universalmente associato a "informazione"
- **Bordo sinistro**: Indicatore visivo rapido e accessibile (non solo colore)
- **Dark mode completo**: Ogni classe ha il corrispettivo `dark:`
- **Cursor feedback**: `cursor-not-allowed` per comunicare non-interattività

## Quando usare

- ✅ Campi calcolati automaticamente (totali, importi derivati)
- ✅ Campi con valore di sistema non modificabile
- ❌ Campi disabilitati temporaneamente (usa `->disabled()`)
- ❌ Campi nascosti (usa `->hidden()`)

## Anti-pattern

```php
// ❌ Troppo sottile
->extraInputAttributes(['class' => 'bg-gray-100'])

// ❌ Nessuno stile
->readOnly()

// ❌ Impedisce invio form
->disabled()
```

## Accessibilità

- Contrasto `text-blue-900` su `bg-blue-50` > 7:1 (WCAG AAA)
- `border-l-4` come indicatore strutturale oltre al colore
- `aria-readonly="true"` aggiunto automaticamente da Filament

## Collegamenti

- [Theme Zero - Readonly Styling](../../../Themes/Zero/docs/readonly-field-styling.md) - Pattern condiviso
- [IndennitaResponsabilita - Readonly Styling](../../../Modules/IndennitaResponsabilita/docs/readonly-field-styling.md) - Implementazione nel modulo

---

*Ultimo aggiornamento: 2026-02-11*
