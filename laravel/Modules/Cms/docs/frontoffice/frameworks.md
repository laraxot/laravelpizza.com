# Framework Frontend

## Introduzione

Il modulo CMS supporta l'integrazione con i principali framework frontend moderni. Questa sezione descrive come configurare e utilizzare Vue.js, React, Inertia.js e Livewire nel contesto del CMS.

## Vue.js

### Installazione
```bash
npm install vue@next @vitejs/plugin-vue
```

### Configurazione Vite
```javascript
// vite.config.js
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
```

### Esempio di Componente
```vue
<template>
    <div class="cms-content">
        <h1>{{ title }}</h1>
        <div v-html="content"></div>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        content: String
    }
}
</script>
```

## React

### Installazione
```bash
npm install react react-dom @vitejs/plugin-react
```

### Configurazione Vite
```javascript
// vite.config.js
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
});
```

### Esempio di Componente
```jsx
import React from 'react';

export default function CmsContent({ title, content }) {
    return (
        <div className="cms-content">
            <h1>{title}</h1>
            <div dangerouslySetInnerHTML={{ __html: content }} />
        </div>
    );
}
```

## Inertia.js

### Installazione
```bash
npm install @inertiajs/vue3 @inertiajs/progress
```

### Configurazione
```javascript
// resources/js/app.js
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el)
    },
})
```

### Esempio di Pagina
```vue
<template>
    <Layout>
        <div class="cms-content">
            <h1>{{ page.title }}</h1>
            <div v-html="page.content"></div>
        </div>
    </Layout>
</template>

<script>
import Layout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        Layout,
    },
    props: {
        page: Object,
    },
}
</script>
```

## Livewire

### Installazione
```bash
composer require livewire/livewire
```

### Configurazione
```php
// config/livewire.php
return [
    'asset_url' => env('APP_URL'),
    'view_path' => resource_path('views'),
    'class_namespace' => 'App\\Livewire',
];
```

### Esempio di Componente
```php
<?php

namespace App\Livewire;

use Livewire\Component;

class CmsContent extends Component
{
    public $title;
    public $content;

    public function mount($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.cms-content');
    }
}
```

## Risorse Utili

- [Documentazione Vue](https://vuejs.org/)
- [Documentazione React](https://reactjs.org/)
- [Documentazione Inertia](https://inertiajs.com/)
- [Documentazione Livewire](https://livewire.laravel.com/)

## Best Practices

1. **Performance**
   - Utilizzare il code splitting
   - Implementare il lazy loading
   - Ottimizzare i bundle

2. **Sicurezza**
   - Sanitizzare l'input
   - Implementare CSRF protection
   - Validare i dati

3. **SEO**
   - Utilizzare meta tags dinamici
   - Implementare SSR dove necessario
   - Ottimizzare per i motori di ricerca

## Troubleshooting

### Errori Comuni

1. **Problemi di Routing**
   - Verificare le configurazioni di Laravel
   - Controllare i middleware
   - Aggiornare le dipendenze

2. **Problemi di Hot Reload**
   - Verificare la configurazione Vite
   - Controllare i file di configurazione
   - Riavviare il server di sviluppo

3. **Problemi di Build**
   - Aggiornare le dipendenze
   - Verificare la compatibilità
   - Controllare i log di errore 
