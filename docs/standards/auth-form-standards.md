# Standard Form di Autenticazione

## Principi di Design

### Layout
- I form di autenticazione devono essere centrati sia orizzontalmente che verticalmente
- Utilizzare una larghezza massima appropriata per garantire leggibilità
- Mantenere una gerarchia visiva chiara con spaziatura consistente

### Container
```html
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <!-- Logo o intestazione -->
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <!-- Form -->
    </div>
  </div>
</div>
```

### Intestazione
```html
<div class="sm:mx-auto sm:w-full sm:max-w-md">
  <img class="mx-auto h-12 w-auto" src="logo.svg" alt="Logo">
  <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
    Titolo del Form
  </h2>
  <p class="mt-2 text-center text-sm text-gray-600">
    Sottotitolo o descrizione
  </p>
</div>
```

### Form
```html
<form class="space-y-6">
  <div>
    <label class="block text-sm font-medium text-gray-700">
      Email
    </label>
    <div class="mt-1">
      <input
        type="email"
        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
      >
    </div>
  </div>

  <!-- Altri campi -->

  <div>
    <button
      type="submit"
      class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
    >
      Invia
    </button>
  </div>
</form>
```

## Responsive Design

### Mobile
- Form a larghezza piena
- Padding ridotto
- Stack verticale per tutti gli elementi

```scss
// Mobile (default)
.auth-container {
  @apply px-4 py-8;
}

.auth-form {
  @apply w-full;
}
```

### Tablet e Desktop
- Form centrato con larghezza massima
- Padding aumentato
- Possibile layout a due colonne per alcuni elementi

```scss
// Tablet (sm)
@screen sm {
  .auth-container {
    @apply px-6 py-12;
  }

  .auth-form {
    @apply max-w-md mx-auto;
  }
}

// Desktop (lg)
@screen lg {
  .auth-container {
    @apply px-8;
  }
}
```

## Elementi Visivi

### Ombreggiature
```scss
.auth-card {
  @apply shadow-sm;

  @screen sm {
    @apply shadow-md;
  }
}
```

### Bordi e Arrotondamenti
```scss
.auth-card {
  @apply rounded-lg;
}

.auth-input {
  @apply rounded-md;
}

.auth-button {
  @apply rounded-md;
}
```

### Spaziatura
```scss
.auth-section {
  @apply space-y-6;
}

.auth-field {
  @apply space-y-1;
}

.auth-actions {
  @apply mt-6;
}
```

## Accessibilità

### Focus Management
```scss
.auth-input:focus {
  @apply outline-none ring-2 ring-primary-500 border-primary-500;
}

.auth-button:focus {
  @apply outline-none ring-2 ring-offset-2 ring-primary-500;
}
```

### ARIA Labels
```html
<div class="auth-field">
  <label id="email-label">Email</label>
  <input
    type="email"
    aria-labelledby="email-label"
    aria-required="true"
  >
</div>
```

## Best Practices

1. **Centratura e Allineamento**
   - Form sempre centrato nella viewport
   - Elementi interni allineati consistentemente
   - Larghezza massima appropriata per la leggibilità

2. **Gerarchia Visiva**
   - Logo/brand in alto
   - Titolo chiaro e descrittivo
   - Campi form ben spaziati
   - Call to action prominente

3. **Feedback Utente**
   - Validazione in tempo reale
   - Messaggi di errore chiari
   - Indicatori di stato (loading, success, error)
   - Focus states visibili

4. **Responsive Design**
   - Layout fluido su tutti i dispositivi
   - Spaziatura adattiva
   - Touch targets appropriati su mobile

5. **Performance**
   - Caricamento ottimizzato
   - Transizioni fluide
   - Gestione efficiente degli stati

6. **Sicurezza**
   - CSRF protection
   - Rate limiting
   - Validazione server-side
   - Sanitizzazione input

## Collegamenti
- [Form Standards](./form_standards.md)
- [UI Standards](./ui-standards.md)
- [Accessibility](./accessibility.md)
# Standard Form di Autenticazione

## Principi di Design

### Layout
- I form di autenticazione devono essere centrati sia orizzontalmente che verticalmente
- Utilizzare una larghezza massima appropriata per garantire leggibilità
- Mantenere una gerarchia visiva chiara con spaziatura consistente

### Container
```html
<div class="min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    <!-- Logo o intestazione -->
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
      <!-- Form -->
    </div>
  </div>
</div>
```

### Intestazione
```html
<div class="sm:mx-auto sm:w-full sm:max-w-md">
  <img class="mx-auto h-12 w-auto" src="logo.svg" alt="Logo">
  <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
    Titolo del Form
  </h2>
  <p class="mt-2 text-center text-sm text-gray-600">
    Sottotitolo o descrizione
  </p>
</div>
```

### Form
```html
<form class="space-y-6">
  <div>
    <label class="block text-sm font-medium text-gray-700">
      Email
    </label>
    <div class="mt-1">
      <input
        type="email"
        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
      >
    </div>
  </div>

  <!-- Altri campi -->

  <div>
    <button
      type="submit"
      class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
    >
      Invia
    </button>
  </div>
</form>
```

## Responsive Design

### Mobile
- Form a larghezza piena
- Padding ridotto
- Stack verticale per tutti gli elementi

```scss
// Mobile (default)
.auth-container {
  @apply px-4 py-8;
}

.auth-form {
  @apply w-full;
}
```

### Tablet e Desktop
- Form centrato con larghezza massima
- Padding aumentato
- Possibile layout a due colonne per alcuni elementi

```scss
// Tablet (sm)
@screen sm {
  .auth-container {
    @apply px-6 py-12;
  }

  .auth-form {
    @apply max-w-md mx-auto;
  }
}

// Desktop (lg)
@screen lg {
  .auth-container {
    @apply px-8;
  }
}
```

## Elementi Visivi

### Ombreggiature
```scss
.auth-card {
  @apply shadow-sm;

  @screen sm {
    @apply shadow-md;
  }
}
```

### Bordi e Arrotondamenti
```scss
.auth-card {
  @apply rounded-lg;
}

.auth-input {
  @apply rounded-md;
}

.auth-button {
  @apply rounded-md;
}
```

### Spaziatura
```scss
.auth-section {
  @apply space-y-6;
}

.auth-field {
  @apply space-y-1;
}

.auth-actions {
  @apply mt-6;
}
```

## Accessibilità

### Focus Management
```scss
.auth-input:focus {
  @apply outline-none ring-2 ring-primary-500 border-primary-500;
}

.auth-button:focus {
  @apply outline-none ring-2 ring-offset-2 ring-primary-500;
}
```

### ARIA Labels
```html
<div class="auth-field">
  <label id="email-label">Email</label>
  <input
    type="email"
    aria-labelledby="email-label"
    aria-required="true"
  >
</div>
```

## Best Practices

1. **Centratura e Allineamento**
   - Form sempre centrato nella viewport
   - Elementi interni allineati consistentemente
   - Larghezza massima appropriata per la leggibilità

2. **Gerarchia Visiva**
   - Logo/brand in alto
   - Titolo chiaro e descrittivo
   - Campi form ben spaziati
   - Call to action prominente

3. **Feedback Utente**
   - Validazione in tempo reale
   - Messaggi di errore chiari
   - Indicatori di stato (loading, success, error)
   - Focus states visibili

4. **Responsive Design**
   - Layout fluido su tutti i dispositivi
   - Spaziatura adattiva
   - Touch targets appropriati su mobile

5. **Performance**
   - Caricamento ottimizzato
   - Transizioni fluide
   - Gestione efficiente degli stati

6. **Sicurezza**
   - CSRF protection
   - Rate limiting
   - Validazione server-side
   - Sanitizzazione input

## Collegamenti
- [Form Standards](./form_standards.md)
- [UI Standards](./ui-standards.md)
- [Accessibility](./accessibility.md)
