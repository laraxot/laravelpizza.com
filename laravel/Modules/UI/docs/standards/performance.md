# Standard di Performance

## 🚀 Metriche Core Web Vitals

### LCP (Largest Contentful Paint)
- Obiettivo: < 2.5s
- Ottimizzazioni:
  - Lazy loading immagini
  - Preload risorse critiche
  - Ottimizzazione server

### FID (First Input Delay)
- Obiettivo: < 100ms
- Ottimizzazioni:
  - Code splitting
  - Defer script non critici
  - Minimizzare task lunghi

### CLS (Cumulative Layout Shift)
- Obiettivo: < 0.1
- Ottimizzazioni:
  - Dimensioni esplicite immagini
  - Riservare spazio per contenuti dinamici
  - Font display swap

## 📊 Ottimizzazioni

### Asset
```html
<!-- Preload risorse critiche -->
<link rel="preload" href="font.woff2" as="font" type="font/woff2" crossorigin>

<!-- Lazy loading immagini -->
<img src="image.jpg" loading="lazy" alt="Descrizione">

<!-- Dimensioni esplicite -->
<img src="image.jpg" width="800" height="600" alt="Descrizione">
```

### JavaScript
```javascript
// Code splitting
import('./module.js').then(module => {
  // Usa il modulo
});

// Defer script non critici
<script src="non-critico.js" defer></script>

// Minimizzare task lunghi
setTimeout(() => {
  // Task pesante
}, 0);
```

### CSS
```css
/* Font display swap */
@font-face {
  font-family: 'Inter';
  src: url('inter.woff2') format('woff2');
  font-display: swap;
}

/* Contenitori con aspect ratio */
.aspect-container {
  position: relative;
  padding-top: 56.25%; /* 16:9 */
}

.aspect-container img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
```

## 🛠 Strumenti di Monitoraggio

### Lighthouse
- Audit completo
- Suggerimenti ottimizzazione
- Metriche Core Web Vitals

### WebPageTest
- Test da diverse location
- Filmstrip rendering
- Waterfall chart

### Chrome DevTools
- Performance panel
- Network panel
- Coverage tool

## 🔗 Collegamenti
- [Standard UI](../ui-standards.md)
- [Accessibilità](./accessibility.md)
- [Componenti Base](../base-components.md)
## Collegamenti tra versioni di performance.md
* [performance.md](laravel/vendor/spatie/laravel-data/docs/advanced-usage/performance.md)
* [performance.md](../../../Xot/docs/features/performance.md)
* [performance.md](../../../Xot/docs/packages/performance.md)
* [performance.md](../../../Xot/docs/roadmap/architecture/performance.md)
* [performance.md](../../../UI/docs/standards/performance.md)
* [performance.md](../../../Lang/docs/packages/performance.md)
* [performance.md](../../../Job/docs/packages/performance.md)
* [performance.md](../../../Cms/docs/frontoffice/performance.md)
