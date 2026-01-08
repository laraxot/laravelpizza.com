# UI Framework

## Introduzione

Il modulo CMS supporta l'integrazione con i principali framework UI moderni. Questa sezione descrive come configurare e utilizzare Tailwind CSS, Flowbite e shadcn/ui nel contesto del CMS.

## Tailwind CSS

### Installazione
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```

### Configurazione
```javascript
// tailwind.config.js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
```

### Integrazione con Vite
```javascript
// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
```

## Flowbite

### Installazione
```bash
npm install flowbite
```

### Configurazione
```javascript
// tailwind.config.js
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('flowbite/plugin')
    ],
}
```

### Esempio di Utilizzo
```html
<button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
    Default
</button>
```

## shadcn/ui

### Installazione
```bash
npm install @shadcn/ui
```

### Configurazione
```javascript
// tailwind.config.js
const { fontFamily } = require("tailwindcss/defaultTheme")

module.exports = {
    darkMode: ["class"],
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        container: {
            center: true,
            padding: "2rem",
            screens: {
                "2xl": "1400px",
            },
        },
        extend: {
            colors: {
                border: "hsl(var(--border))",
                input: "hsl(var(--input))",
                ring: "hsl(var(--ring))",
                background: "hsl(var(--background))",
                foreground: "hsl(var(--foreground))",
                primary: {
                    DEFAULT: "hsl(var(--primary))",
                    foreground: "hsl(var(--primary-foreground))",
                },
                // ... altri colori
            },
            fontFamily: {
                sans: ["var(--font-sans)", ...fontFamily.sans],
            },
        },
    },
    plugins: [require("tailwindcss-animate")],
}
```

### Esempio di Componente
```vue
<template>
    <button
        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
    >
        <slot />
    </button>
</template>
```

## Best Practices

1. **Performance**
   - Utilizzare PurgeCSS per rimuovere CSS non utilizzato
   - Implementare il code splitting
   - Ottimizzare le immagini

2. **Accessibilità**
   - Utilizzare colori con contrasto sufficiente
   - Implementare focus states
   - Aggiungere ARIA labels

3. **Responsive Design**
   - Utilizzare breakpoint appropriati
   - Testare su diversi dispositivi
   - Implementare mobile-first design

## Risorse Utili

- [Documentazione Tailwind](https://tailwindcss.com/docs)
- [Documentazione Flowbite](https://flowbite.com/docs)
- [Documentazione shadcn/ui](https://ui.shadcn.com/docs)

## Troubleshooting

### Errori Comuni

1. **Problemi di Stile**
   - Verificare la configurazione di Tailwind
   - Controllare l'ordine dei plugin
   - Aggiornare le dipendenze

2. **Problemi di Build**
   - Verificare la configurazione di Vite
   - Controllare i file di configurazione
   - Riavviare il server di sviluppo

3. **Problemi di Performance**
   - Ottimizzare le classi Tailwind
   - Implementare il purging
   - Utilizzare CDN per gli asset 
