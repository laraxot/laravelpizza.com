# Standard Form nei Temi

## Principi Generali

### Layout e Allineamento
- I form devono essere centrati nella pagina con margini appropriati
- Utilizzare una larghezza massima per garantire leggibilità
- Mantenere una spaziatura consistente tra gli elementi

```html
<div class="container mx-auto max-w-4xl px-4 py-8">
  <form class="w-full space-y-6">
    <!-- Contenuto del form -->
  </form>
</div>
```

### Grid System
- Utilizzare il grid system di Tailwind per layout responsivi
- Su mobile: colonna singola
- Su tablet e desktop: layout a due colonne dove appropriato

```html
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div class="col-span-1">
    <!-- Campo 1 -->
  </div>
  <div class="col-span-1">
    <!-- Campo 2 -->
  </div>
</div>
```

### Spaziatura
```scss
// Margini e padding consistenti
.form-container {
  @apply p-6 md:p-8;
}

.form-group {
  @apply mb-4 md:mb-6;
}

.form-section {
  @apply mb-8 md:mb-12;
}
```

## Componenti Form

### Input Text
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Nome
  </label>
  <input
    type="text"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500"
  >
</div>
```

### Select
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Ruolo
  </label>
  <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500">
    <option>Seleziona...</option>
  </select>
</div>
```

### Checkbox e Radio
```html
<div class="form-group">
  <div class="flex items-center">
    <input
      type="checkbox"
      class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
    >
    <label class="ml-2 text-sm text-gray-700">
      Accetto i termini
    </label>
  </div>
</div>
```

## Responsive Design

### Mobile First
```scss
// Base styles (mobile)
.form-container {
  width: 100%;
  padding: 1rem;
}

// Tablet (md)
@screen md {
  .form-container {
    padding: 2rem;
    max-width: 768px;
    margin: 0 auto;
  }
}

// Desktop (lg)
@screen lg {
  .form-container {
    max-width: 1024px;
  }
}
```

### Breakpoints
```scss
// Tailwind breakpoints
screens: {
  'sm': '640px',
  'md': '768px',
  'lg': '1024px',
  'xl': '1280px',
  '2xl': '1536px',
}
```

## Validazione e Feedback

### Errori
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Email
  </label>
  <input
    type="email"
    class="w-full px-4 py-2 border border-red-300 rounded-md focus:ring-2 focus:ring-red-500"
    aria-invalid="true"
    aria-describedby="email-error"
  >
  <p id="email-error" class="mt-2 text-sm text-red-600">
    Inserisci un indirizzo email valido
  </p>
</div>
```

### Successo
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Username
  </label>
  <input
    type="text"
    class="w-full px-4 py-2 border border-green-300 rounded-md focus:ring-2 focus:ring-green-500"
    aria-invalid="false"
  >
  <p class="mt-2 text-sm text-green-600">
    Username disponibile
  </p>
</div>
```

## Accessibilità

### ARIA Labels
```html
<div class="form-group">
  <label id="email-label" class="block text-sm font-medium text-gray-700 mb-2">
    Email
  </label>
  <input
    type="email"
    aria-labelledby="email-label"
    aria-required="true"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500"
  >
</div>
```

### Focus States
```scss
// Focus visibile e consistente
.form-input:focus {
  @apply outline-none ring-2 ring-primary-500 border-transparent;
}

// Focus visibile per keyboard navigation
.form-input:focus-visible {
  @apply ring-2 ring-primary-500 ring-offset-2;
}
```

## Performance

### Loading States
```html
<button
  type="submit"
  class="btn btn-primary"
  disabled
>
  <span class="spinner" aria-hidden="true"></span>
  <span>Caricamento...</span>
</button>
```

### Lazy Loading
```javascript
// Lazy load form validation library
const loadValidator = () => import('./validator.js');

form.addEventListener('submit', async (e) => {
  const validator = await loadValidator();
  // Validate form
});
```

## Best Practices

1. **Centratura e Allineamento**
   - Tutti i form devono essere centrati nella pagina
   - Utilizzare container con larghezza massima
   - Mantenere margini consistenti

2. **Responsive Design**
   - Layout a colonna singola su mobile
   - Grid system per schermi più grandi
   - Breakpoint standard di Tailwind

3. **Spaziatura**
   - Margini verticali consistenti tra gruppi di campi
   - Padding interno consistente per i container
   - Gap appropriato nel grid system

4. **Validazione**
   - Feedback visivo immediato
   - Messaggi di errore chiari
   - Stati di successo appropriati

5. **Accessibilità**
   - ARIA labels per tutti i campi
   - Focus states visibili
   - Messaggi di errore associati ai campi

6. **Performance**
   - Lazy loading di script pesanti
   - Stati di loading appropriati
   - Ottimizzazione delle risorse

## Collegamenti
- [UI Standards](./ui-standards.md)
- [Accessibility](./accessibility.md)
- [Performance](./performance.md)
# Standard Form nei Temi

## Principi Generali

### Layout e Allineamento
- I form devono essere centrati nella pagina con margini appropriati
- Utilizzare una larghezza massima per garantire leggibilità
- Mantenere una spaziatura consistente tra gli elementi

```html
<div class="container mx-auto max-w-4xl px-4 py-8">
  <form class="w-full space-y-6">
    <!-- Contenuto del form -->
  </form>
</div>
```

### Grid System
- Utilizzare il grid system di Tailwind per layout responsivi
- Su mobile: colonna singola
- Su tablet e desktop: layout a due colonne dove appropriato

```html
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div class="col-span-1">
    <!-- Campo 1 -->
  </div>
  <div class="col-span-1">
    <!-- Campo 2 -->
  </div>
</div>
```

### Spaziatura
```scss
// Margini e padding consistenti
.form-container {
  @apply p-6 md:p-8;
}

.form-group {
  @apply mb-4 md:mb-6;
}

.form-section {
  @apply mb-8 md:mb-12;
}
```

## Componenti Form

### Input Text
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Nome
  </label>
  <input
    type="text"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500"
  >
</div>
```

### Select
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Ruolo
  </label>
  <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500">
    <option>Seleziona...</option>
  </select>
</div>
```

### Checkbox e Radio
```html
<div class="form-group">
  <div class="flex items-center">
    <input
      type="checkbox"
      class="h-4 w-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
    >
    <label class="ml-2 text-sm text-gray-700">
      Accetto i termini
    </label>
  </div>
</div>
```

## Responsive Design

### Mobile First
```scss
// Base styles (mobile)
.form-container {
  width: 100%;
  padding: 1rem;
}

// Tablet (md)
@screen md {
  .form-container {
    padding: 2rem;
    max-width: 768px;
    margin: 0 auto;
  }
}

// Desktop (lg)
@screen lg {
  .form-container {
    max-width: 1024px;
  }
}
```

### Breakpoints
```scss
// Tailwind breakpoints
screens: {
  'sm': '640px',
  'md': '768px',
  'lg': '1024px',
  'xl': '1280px',
  '2xl': '1536px',
}
```

## Validazione e Feedback

### Errori
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Email
  </label>
  <input
    type="email"
    class="w-full px-4 py-2 border border-red-300 rounded-md focus:ring-2 focus:ring-red-500"
    aria-invalid="true"
    aria-describedby="email-error"
  >
  <p id="email-error" class="mt-2 text-sm text-red-600">
    Inserisci un indirizzo email valido
  </p>
</div>
```

### Successo
```html
<div class="form-group">
  <label class="block text-sm font-medium text-gray-700 mb-2">
    Username
  </label>
  <input
    type="text"
    class="w-full px-4 py-2 border border-green-300 rounded-md focus:ring-2 focus:ring-green-500"
    aria-invalid="false"
  >
  <p class="mt-2 text-sm text-green-600">
    Username disponibile
  </p>
</div>
```

## Accessibilità

### ARIA Labels
```html
<div class="form-group">
  <label id="email-label" class="block text-sm font-medium text-gray-700 mb-2">
    Email
  </label>
  <input
    type="email"
    aria-labelledby="email-label"
    aria-required="true"
    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary-500"
  >
</div>
```

### Focus States
```scss
// Focus visibile e consistente
.form-input:focus {
  @apply outline-none ring-2 ring-primary-500 border-transparent;
}

// Focus visibile per keyboard navigation
.form-input:focus-visible {
  @apply ring-2 ring-primary-500 ring-offset-2;
}
```

## Performance

### Loading States
```html
<button
  type="submit"
  class="btn btn-primary"
  disabled
>
  <span class="spinner" aria-hidden="true"></span>
  <span>Caricamento...</span>
</button>
```

### Lazy Loading
```javascript
// Lazy load form validation library
const loadValidator = () => import('./validator.js');

form.addEventListener('submit', async (e) => {
  const validator = await loadValidator();
  // Validate form
});
```

## Best Practices

1. **Centratura e Allineamento**
   - Tutti i form devono essere centrati nella pagina
   - Utilizzare container con larghezza massima
   - Mantenere margini consistenti

2. **Responsive Design**
   - Layout a colonna singola su mobile
   - Grid system per schermi più grandi
   - Breakpoint standard di Tailwind

3. **Spaziatura**
   - Margini verticali consistenti tra gruppi di campi
   - Padding interno consistente per i container
   - Gap appropriato nel grid system

4. **Validazione**
   - Feedback visivo immediato
   - Messaggi di errore chiari
   - Stati di successo appropriati

5. **Accessibilità**
   - ARIA labels per tutti i campi
   - Focus states visibili
   - Messaggi di errore associati ai campi

6. **Performance**
   - Lazy loading di script pesanti
   - Stati di loading appropriati
   - Ottimizzazione delle risorse

## Collegamenti
- [UI Standards](./ui-standards.md)
- [Accessibility](./accessibility.md)
- [Performance](./performance.md)
