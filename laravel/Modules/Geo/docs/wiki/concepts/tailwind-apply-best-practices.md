---
name: Tailwind @apply Best Practices for Geo Module
description: Guida all'uso di @apply per mantenere compatibilità Bootstrap Italia nel modulo Geo
metadata:
  type: decision
---

# Tailwind @apply Best Practices - Geo Module

## Perché @apply è la Soluzione Migliore

**Concordiamo pienamente con l'approccio @apply:**
- **Stile coerente**: Mantiene `btn`, `card`, `form-control` come nell'interfaccia esistente
- **Performance**: Tailwind ottimizza le classi compilate
- **Manutenibilità**: Un solo punto di modifica per tutti gli stili
- **Sviluppo rapido**: Gli sviluppatori usano classi già conosciute

## Alias per il Modulo Geo

### Struttura File CSS per Componenti Mappe
```css
/* Modules/Geo/resources/css/tailwind-apply.css */
@layer components {
  /* Componenti Mappe - Manteniamo le classi semantiche */
  .btn-map-control {
    @apply rounded-full px-3 py-2 font-medium text-white bg-gray-800 hover:bg-gray-900 transition-all duration-200 shadow-lg;
  }
  
  .btn-map-control-primary {
    @apply btn-map-control bg-blue-600 hover:bg-blue-700;
  }
  
  .btn-map-control-secondary {
    @apply btn-map-control bg-gray-600 hover:bg-gray-700;
  }
  
  /* Componenti Geolocalizzazione */
  .geo-picker-container {
    @apply relative w-full h-96 border-2 border-gray-300 rounded-lg overflow-hidden bg-gray-50;
  }
  
  .geo-result-card {
    @apply bg-white rounded-lg shadow-md border border-gray-200 p-4 hover:shadow-lg transition-shadow duration-200;
  }
  
  /* Overlay Search */
  .map-search-overlay {
    @apply absolute top-4 left-4 z-10 w-80 bg-white rounded-lg shadow-xl border border-gray-200 p-4;
  }
  
  .map-search-input {
    @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200;
  }
  
  /* Coordinate Input */
  .coordinate-input-group {
    @apply grid grid-cols-2 gap-2;
  }
  
  .coordinate-input {
    @apply form-control text-center;
  }
}
```

### Configurazione Tailwind
```javascript
// Modules/Geo/resources/tailwind-apply.config.js
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    function({ addComponents }) {
      addComponents({
        'btn-map-control': {
          '@apply': ['rounded-full', 'px-3', 'py-2', 'font-medium', 'text-white', 'bg-gray-800', 'hover:bg-gray-900', 'transition-all', 'duration-200', 'shadow-lg']
        },
        'geo-picker-container': {
          '@apply': ['relative', 'w-full', 'h-96', 'border-2', 'border-gray-300', 'rounded-lg', 'overflow-hidden', 'bg-gray-50']
        }
      })
    }
  ]
}
```

### Utilizzo nei Componenti Lit
```javascript
// coordinate-picker-lit.js
render() {
  return html`
    <div class="geo-picker-container">
      ${this._searchOpen ? renderSearch(this, searchUiHandlers) : ''}
      <button class="btn-map-control-primary" @click="${this.toggleSearch}">
        <span class="icon icon-primary">search</span>
      </button>
    </div>
  `;
}
```

## Vantaggi Specifici per Geo Module

1. **Stile Consistente**: Tutti i componenti mappe usano le stesse classi semantiche
2. **Performance Ottimizzata**: Tailwind compila solo le classi utilizzate
3. **Facile Personalizzazione**: Modificare `btn-map-control` cambia tutti i pulsanti
4. **Supporto Dark Mode**: Le classi ereditano automaticamente le varianti dark di Tailwind

## Migrazione Progressiva

1. **Passo 1**: Identificare tutte le classi CSS custom nel modulo Geo
2. **Passo 2**: Creare alias @apply per ogni componente riutilizzabile
3. **Passo 3**: Sostituire le classi inline con gli alias
4. **Passo 4**: Rimuovere il CSS custom duplicato