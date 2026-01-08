# Assets in il progetto

Gli assets sono le risorse statiche (CSS, JavaScript, immagini, font) utilizzate dal tema. Ogni tema può definire i propri assets.

## Struttura degli Assets

Gli assets sono organizzati in:

```
laravel/
├── Modules/
│   └── [Module]/
│       └── resources/
│           ├── images/
│           ├── css/
│           └── js/
└── Themes/
    └── [Theme]/
        └── resources/
            ├── images/
            ├── css/
            └── js/
```

## CSS

### app.css
```css
@tailwind base;
@tailwind components;
@tailwind utilities;

/* Custom styles */
@layer components {
    /* Button variants */
    .btn-primary {
        @apply inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
    }

    .btn-secondary {
        @apply inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
    }

    /* Card styles */
    .card {
        @apply bg-white overflow-hidden shadow-sm sm:rounded-lg;
    }

    .card-header {
        @apply p-6 border-b border-gray-200;
    }

    .card-body {
        @apply p-6;
    }

    /* Form styles */
    .form-input {
        @apply border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm;
    }

    .form-label {
        @apply block font-medium text-sm text-gray-700;
    }

    .form-error {
        @apply text-sm text-red-600;
    }
}
```

### blocks.css
```css
/* Hero block */
.hero {
    @apply relative bg-white overflow-hidden;
}

.hero-content {
    @apply max-w-7xl mx-auto;
}

.hero-title {
    @apply text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl;
}

.hero-subtitle {
    @apply mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl;
}

/* Feature sections block */
.feature-sections {
    @apply py-12 bg-white;
}

.feature-section {
    @apply relative;
}

.feature-icon {
    @apply absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white;
}

/* Stats block */
.stats {
    @apply bg-gray-50 pt-12 sm:pt-16;
}

.stat-item {
    @apply relative px-4 pt-5 pb-12 text-center overflow-hidden sm:pt-6 sm:px-6;
}

.stat-value {
    @apply text-3xl font-extrabold text-gray-900 sm:text-4xl;
}

.stat-label {
    @apply mt-3 text-base font-medium text-gray-500;
}

/* CTA block */
.cta {
    @apply bg-indigo-700;
}

.cta-content {
    @apply max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8;
}

.cta-title {
    @apply text-3xl font-extrabold text-white sm:text-4xl;
}

.cta-description {
    @apply mt-6 text-lg leading-6 text-indigo-200;
}
```

## JavaScript

### app.js
```javascript
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Custom components
import './components/blocks';
import './components/forms';
import './components/ui';
```

### blocks.js
```javascript
// Hero block
document.addEventListener('alpine:init', () => {
    Alpine.data('hero', () => ({
        init() {
            // Initialize hero block
        }
    }));
});

// Feature sections block
document.addEventListener('alpine:init', () => {
    Alpine.data('featureSections', () => ({
        init() {
            // Initialize feature sections block
        }
    }));
});

// Stats block
document.addEventListener('alpine:init', () => {
    Alpine.data('stats', () => ({
        init() {
            // Initialize stats block
        }
    }));
});

// CTA block
document.addEventListener('alpine:init', () => {
    Alpine.data('cta', () => ({
        init() {
            // Initialize CTA block
        }
    }));
});
```

## Best Practices

1. **Organizzazione**: Mantieni una struttura pulita e organizzata
2. **Modularità**: Separa gli assets per componente
3. **Performance**: Ottimizza il caricamento delle risorse
4. **Manutenibilità**: Mantieni il codice pulito e documentato
5. **Consistenza**: Mantieni uno stile coerente
6. **Accessibilità**: Assicurati che gli assets siano accessibili
7. **Responsive**: Rendi gli assets responsive
8. **Versioning**: Gestisci correttamente le versioni degli assets

## Gestione degli Asset

1. **Percorsi**:
   - Gli asset possono essere in `resources` dei moduli o dei temi
   - I percorsi sono relativi alla root del modulo/tema
   - Esempio: `/Modules/Patient/resources/images/logo.svg`

2. **Helper Asset**:
   - Usare `$_theme->asset()` per gli asset
   - Converte automaticamente i percorsi in URL pubblici
   - Esempio: `<img src="{{ $_theme->asset($src) }}">`

3. **Best Practices**:
   - Organizzare gli asset per modulo/tema
   - Usare percorsi relativi alla root del modulo/tema
   - Verificare sempre che gli asset esistano
   - Usare dimensioni appropriate per le immagini
   - Ottimizzare le immagini per il web

4. **Sicurezza**:
   - Non permettere upload di file eseguibili
   - Validare i tipi di file
   - Usare nomi di file unici
   - Sanitizzare i nomi dei file

5. **Performance**:
   - Implementare lazy loading
   - Ottimizzare le dimensioni dei file
   - Usare formati moderni (WebP, AVIF)

## Esempi

```json
{
    "logo": {
        "src": "/Modules/Patient/resources/images/logo.svg",
        "alt": "Logo del sito"
    }
}
```

```blade
<img src="{{ $_theme->asset($src) }}" 
     alt="{{ $alt }}"
     class="h-8 w-auto">
``` 
## Collegamenti tra versioni di assets.md
* [assets.md](../../../Xot/docs/assets.md)
* [assets.md](../../../Cms/docs/themes/assets.md)
* [assets.md](../../../../Themes/One/docs/assets.md)

