# Filament 5.x Requirements & Configuration

**Data Analisi**: [DATE]
**Versione Filament**: 5.1.1
**Documentazione Upstream**: https://filamentphp.com/docs/5.x/introduction/installation

## Requisiti Critici Filament 5.x

### Requisiti di Sistema

- **PHP**: 8.2+
- **Laravel**: v11.28+
- **Tailwind CSS**: v4.1+ (⚠️ **CRITICO** - Filament 5.x richiede v4.1+, NON compatibile con v3.x)
- **Filament**: v5.0+

## Tailwind CSS v4.1+ Configuration

### Installazione

```bash
npm install tailwindcss@^4.1.0 @tailwindcss/vite@^4.1.0 --save-dev
```

### Vite Configuration

```javascript
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({...}),
        tailwindcss(),  // ✅ Plugin Vite (NON PostCSS)
    ],
});
```

### CSS Configuration

```css
@import 'tailwindcss';  /* ✅ Tailwind v4 */
/* NON @tailwind base/components/utilities */
```

### File da Rimuovere

Durante l'upgrade a Tailwind v4, rimuovere:
- `tailwind.config.js` (non più necessario)
- `postcss.config.js` (non più necessario, usa Vite plugin)

## Chart.js Plugins (Filament 5.x)

### Pattern Corretto

```javascript
window.filamentChartJsPlugins ??= [];
window.filamentChartJsPlugins.push(ChartDataLabels);
```

### Pattern Errato

```javascript
Chart.register(ChartDataLabels);  // ❌ NON funziona
```

## Collegamenti

- [Filament 5.x Installation](https://filamentphp.com/docs/5.x/introduction/installation)
- [Chart Installation Guide](../../Chart/docs/filament-5-installation-guide.md)

---

