# Componenti UI - Modulo UI

## Panoramica

I componenti UI forniscono elementi riutilizzabili e standardizzati per l'interfaccia utente dell'ecosistema PTVX Fila3 Mono.

## 🎯 Principi di Design

### DRY (Don't Repeat Yourself)
- **Centralizzazione**: Componenti condivisi tra moduli
- **Riusabilità**: Pattern di design standardizzati
- **Manutenibilità**: Aggiornamenti centralizzati

### KISS (Keep It Simple, Stupid)
- **Semplicità**: Componenti facili da usare
- **Chiarezza**: API intuitive e prevedibili
- **Consistenza**: Comportamento uniforme

### SOLID
- **Single Responsibility**: Ogni componente ha uno scopo specifico
- **Open/Closed**: Estendibile senza modifiche
- **Liskov Substitution**: Varianti sostituibili
- **Interface Segregation**: Props specifiche e coese
- **Dependency Inversion**: Dipendenze da astrazioni

## 🏗️ Componenti Disponibili

### 1. Button Component
```blade
<x-ui::ui.button type="primary" size="lg" disabled="{{ false }}">
    Salva Modifiche
</x-ui::ui.button>
```

**Props disponibili:**
- `type`: primary, secondary, success, danger, warning, info
- `size`: sm, md, lg, xl
- `disabled`: true/false
- `loading`: true/false

### 2. Card Component
```blade
<x-ui::ui.card variant="elevated" padding="lg">
    <x-slot name="header">
        <h3 class="text-lg font-semibold">Titolo Card</h3>
    </x-slot>

    <p>Contenuto della card</p>

    <x-slot name="footer">
        <x-ui::ui.button type="primary">Azione</x-ui::ui.button>
    </x-slot>
</x-ui::ui.card>
```

**Props disponibili:**
- `variant`: default, elevated, outlined
- `padding`: sm, md, lg, xl
- `rounded`: sm, md, lg, xl

### 3. Input Component
```blade
<x-ui::ui.input
    name="email"
    type="email"
    placeholder="Inserisci email"
    :required="true"
    error="{{ $errors->first('email') }}"
/>
```

**Props disponibili:**
- `name`: Nome del campo
- `type`: text, email, password, number, tel
- `placeholder`: Testo placeholder
- `required`: true/false
- `error`: Messaggio di errore
- `disabled`: true/false

### 4. Modal Component
```blade
<x-ui::ui.modal
    id="confirm-modal"
    title="Conferma Azione"
    size="md"
>
    <p>Sei sicuro di voler procedere?</p>

    <x-slot name="footer">
        <x-ui::ui.button type="secondary" x-on:click="close">Annulla</x-ui::ui.button>
        <x-ui::ui.button type="danger">Conferma</x-ui::ui.button>
    </x-slot>
</x-ui::ui.modal>
```

**Props disponibili:**
- `id`: ID univoco del modal
- `title`: Titolo del modal
- `size`: sm, md, lg, xl, full

## 🎨 Personalizzazione

### Varianti CSS
```css
/* Varianti button */
.btn-primary { @apply bg-blue-600 text-white hover:bg-blue-700; }
.btn-secondary { @apply bg-gray-600 text-white hover:bg-gray-700; }
.btn-success { @apply bg-green-600 text-white hover:bg-green-700; }
.btn-danger { @apply bg-red-600 text-white hover:bg-red-700; }
```

### Temi Dinamici
```php
// config/ui.php
return [
    'components' => [
        'button' => [
            'variants' => [
                'primary' => 'bg-blue-600 hover:bg-blue-700',
                'secondary' => 'bg-gray-600 hover:bg-gray-700',
            ],
        ],
    ],
];
```

## 🚀 Utilizzo Avanzato

### Composizione Componenti
```blade
<x-ui::ui.card>
    <x-ui::ui.input name="search" placeholder="Cerca..." />

    <div class="mt-4">
        <x-ui::ui.button type="primary" size="sm">
            <x-ui::ui.icon name="search" class="w-4 h-4 mr-2" />
            Cerca
        </x-ui::ui.button>
    </div>
</x-ui::ui.card>
```

### Eventi e Interazioni
```blade
<x-ui::ui.button
    type="primary"
    x-data="{ loading: false }"
    x-on:click="loading = true; $wire.save().then(() => loading = false)"
    :disabled="$data.loading"
>
    <span x-show="!loading">Salva</span>
    <span x-show="loading">Salvando...</span>
</x-ui::ui.button>
```

## 📱 Responsività

### Breakpoints
```css
/* Mobile first approach */
.component { @apply p-2; }
@screen sm { .component { @apply p-4; } }
@screen md { .component { @apply p-6; } }
@screen lg { .component { @apply p-8; } }
```

### Varianti Responsive
```blade
<x-ui::ui.button
    size="sm md:md lg:lg"
    class="w-full md:w-auto"
>
    Responsive Button
</x-ui::ui.button>
```

## 🔗 Collegamenti

- [**README Modulo UI**](../README.md)
- [**Sistema Layout**](../layout/layout-system.md)
- [**Gestione Asset**](../assets/asset-management.md)
- [**Personalizzazioni Filament**](../filament/filament-customizations.md)

---

*Ultimo aggiornamento: giugno 2025*
