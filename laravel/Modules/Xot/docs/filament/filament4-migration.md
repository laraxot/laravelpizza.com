# Filament 5.x Migration Guide

**Data**: 2026-01-30
**Versione Attuale**: Filament 5.1.1

> [!NOTE]
> Il progetto è già stato migrato a Filament 5.x. Questa documentazione è per riferimento.

## Status Migrazione

✅ **COMPLETATA** - Progetto aggiornato a Filament 5.1.1

## Requisiti Sistema

| Requisito | Versione Richiesta | Versione Attuale |
|-----------|-------------------|------------------|
| PHP | 8.2+ | 8.3.6 ✅ |
| Laravel | v11.28+ | 12.48.1 ✅ |
| Tailwind CSS | v4.0+ | v4.1.0 ✅ |
| Livewire | v4.0+ | v4.x ✅ |

## Differenze Principali da v4

### Tailwind CSS v4

Filament 5.x usa Tailwind CSS v4 con plugin Vite:

```javascript
// vite.config.js
import tailwindcss from '@tailwindcss/vite';
tailwindcss(),
```

```css
/* app.css */
@import 'tailwindcss';
```

### Chart.js Plugins

```javascript
// ✅ Pattern Corretto (Filament 5.x)
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);

// ❌ Pattern Obsoleto
Chart.register(ChartDataLabels);
```

## 🔗 Risorse

- [Filament 5.x Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [Livewire 4.x Upgrade Guide](https://livewire.laravel.com/docs/4.x/upgrading)


**Versione Attuale**: Filament 5.1.1

> [!NOTE]
> Il progetto è già stato migrato a Filament 5.x. Questa documentazione è per riferimento.

## Status Migrazione

✅ **COMPLETATA** - Progetto aggiornato a Filament 5.1.1

## Requisiti Sistema

| Requisito | Versione Richiesta | Versione Attuale |
|-----------|-------------------|------------------|
| PHP | 8.2+ | 8.3.6 ✅ |
| Laravel | v11.28+ | 12.48.1 ✅ |
| Tailwind CSS | v4.0+ | v4.1.0 ✅ |
| Livewire | v4.0+ | v4.x ✅ |

## Differenze Principali da v4

### Tailwind CSS v4

Filament 5.x usa Tailwind CSS v4 con plugin Vite:

```javascript
// vite.config.js
import tailwindcss from '@tailwindcss/vite';
tailwindcss(),
```

```css
/* app.css */
@import 'tailwindcss';
```

### Chart.js Plugins

```javascript
// ✅ Pattern Corretto (Filament 5.x)
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);

// ❌ Pattern Obsoleto
Chart.register(ChartDataLabels);
```

## 🔗 Risorse

- [Filament 5.x Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [Livewire 4.x Upgrade Guide](https://livewire.laravel.com/docs/4.x/upgrading)


**Versione Attuale**: Filament 5.1.1

> [!NOTE]
> Il progetto è già stato migrato a Filament 5.x. Questa documentazione è per riferimento.

## Status Migrazione

✅ **COMPLETATA** - Progetto aggiornato a Filament 5.1.1

## Requisiti Sistema

| Requisito | Versione Richiesta | Versione Attuale |
|-----------|-------------------|------------------|
| PHP | 8.2+ | 8.3.6 ✅ |
| Laravel | v11.28+ | 12.48.1 ✅ |
| Tailwind CSS | v4.0+ | v4.1.0 ✅ |
| Livewire | v4.0+ | v4.x ✅ |

## Differenze Principali da v4

### Tailwind CSS v4

Filament 5.x usa Tailwind CSS v4 con plugin Vite:

```javascript
// vite.config.js
import tailwindcss from '@tailwindcss/vite';
tailwindcss(),
```

```css
/* app.css */
@import 'tailwindcss';
```

### Chart.js Plugins

```javascript
// ✅ Pattern Corretto (Filament 5.x)
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);

// ❌ Pattern Obsoleto
Chart.register(ChartDataLabels);
```

## 🔗 Risorse

- [Filament 5.x Upgrade Guide](https://filamentphp.com/docs/5.x/upgrade-guide)
- [Livewire 4.x Upgrade Guide](https://livewire.laravel.com/docs/4.x/upgrading)

