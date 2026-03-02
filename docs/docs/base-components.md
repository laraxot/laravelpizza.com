# Componenti Base

## 🎨 Design System

### Colori
```scss
// Palette principale
$primary: #007bff;
$secondary: #6c757d;
$success: #28a745;
$danger: #dc3545;
$warning: #ffc107;
$info: #17a2b8;

// Gradienti
$gradient-primary: linear-gradient(135deg, $primary, darken($primary, 10%));
$gradient-success: linear-gradient(135deg, $success, darken($success, 10%));
```

### Tipografia
```scss
// Font stack
$font-family-base: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
$font-family-heading: 'Montserrat', $font-family-base;

// Scale
$font-size-base: 1rem;
$font-size-sm: 0.875rem;
$font-size-lg: 1.125rem;

// Pesanti
$font-weight-normal: 400;
$font-weight-medium: 500;
$font-weight-bold: 700;
```

### Spaziatura
```scss
// Scale
$spacer: 1rem;
$spacers: (
  0: 0,
  1: $spacer * 0.25,
  2: $spacer * 0.5,
  3: $spacer,
  4: $spacer * 1.5,
  5: $spacer * 3
);
```

## 📱 Componenti

### Bottoni
```html
<!-- Primario -->
<button class="btn btn-primary">
  <i class="fas fa-plus"></i>
  Aggiungi
</button>

<!-- Secondario -->
<button class="btn btn-secondary">
  <i class="fas fa-edit"></i>
  Modifica
</button>

<!-- Pericolo -->
<button class="btn btn-danger">
  <i class="fas fa-trash"></i>
  Elimina
</button>
```

### Form
```html
<!-- Input -->
<div class="form-group">
  <label for="email">Email</label>
  <input type="email" id="email" class="form-control" placeholder="Inserisci email">
  <small class="form-text text-muted">Non condivideremo mai la tua email</small>
</div>

<!-- Select -->
<div class="form-group">
  <label for="role">Ruolo</label>
  <select id="role" class="form-control">
    <option value="">Seleziona un ruolo</option>
    <option value="admin">Amministratore</option>
    <option value="user">Utente</option>
  </select>
</div>
```

### Card
```html
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Titolo Card</h5>
  </div>
  <div class="card-body">
    <p class="card-text">Contenuto della card</p>
  </div>
  <div class="card-footer">
    <button class="btn btn-primary">Azione</button>
  </div>
</div>
```

### Alert
```html
<!-- Successo -->
<div class="alert alert-success">
  <i class="fas fa-check-circle"></i>
  Operazione completata con successo
</div>

<!-- Errore -->
<div class="alert alert-danger">
  <i class="fas fa-exclamation-circle"></i>
  Si è verificato un errore
</div>

<!-- Info -->
<div class="alert alert-info">
  <i class="fas fa-info-circle"></i>
  Informazione importante
</div>
```

### Badge
```html
<!-- Primario -->
<span class="badge badge-primary">Nuovo</span>

<!-- Successo -->
<span class="badge badge-success">Completato</span>

<!-- Pericolo -->
<span class="badge badge-danger">Errore</span>
```

### Progress Bar
```html
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
    75%
  </div>
</div>
```

### Spinner
```html
<div class="spinner-border text-primary" role="status">
  <span class="sr-only">Caricamento...</span>
</div>
```

## 🔗 Collegamenti
- [Performance](./standards/performance.md)
- [Accessibilità](./standards/accessibility.md)
- [UI Standards](./standards/ui-standards.md)
# Componenti Base

## 🎨 Design System

### Colori
```scss
// Palette principale
$primary: #007bff;
$secondary: #6c757d;
$success: #28a745;
$danger: #dc3545;
$warning: #ffc107;
$info: #17a2b8;

// Gradienti
$gradient-primary: linear-gradient(135deg, $primary, darken($primary, 10%));
$gradient-success: linear-gradient(135deg, $success, darken($success, 10%));
```

### Tipografia
```scss
// Font stack
$font-family-base: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
$font-family-heading: 'Montserrat', $font-family-base;

// Scale
$font-size-base: 1rem;
$font-size-sm: 0.875rem;
$font-size-lg: 1.125rem;

// Pesanti
$font-weight-normal: 400;
$font-weight-medium: 500;
$font-weight-bold: 700;
```

### Spaziatura
```scss
// Scale
$spacer: 1rem;
$spacers: (
  0: 0,
  1: $spacer * 0.25,
  2: $spacer * 0.5,
  3: $spacer,
  4: $spacer * 1.5,
  5: $spacer * 3
);
```

## 📱 Componenti

### Bottoni
```html
<!-- Primario -->
<button class="btn btn-primary">
  <i class="fas fa-plus"></i>
  Aggiungi
</button>

<!-- Secondario -->
<button class="btn btn-secondary">
  <i class="fas fa-edit"></i>
  Modifica
</button>

<!-- Pericolo -->
<button class="btn btn-danger">
  <i class="fas fa-trash"></i>
  Elimina
</button>
```

### Form
```html
<!-- Input -->
<div class="form-group">
  <label for="email">Email</label>
  <input type="email" id="email" class="form-control" placeholder="Inserisci email">
  <small class="form-text text-muted">Non condivideremo mai la tua email</small>
</div>

<!-- Select -->
<div class="form-group">
  <label for="role">Ruolo</label>
  <select id="role" class="form-control">
    <option value="">Seleziona un ruolo</option>
    <option value="admin">Amministratore</option>
    <option value="user">Utente</option>
  </select>
</div>
```

### Card
```html
<div class="card">
  <div class="card-header">
    <h5 class="card-title">Titolo Card</h5>
  </div>
  <div class="card-body">
    <p class="card-text">Contenuto della card</p>
  </div>
  <div class="card-footer">
    <button class="btn btn-primary">Azione</button>
  </div>
</div>
```

### Alert
```html
<!-- Successo -->
<div class="alert alert-success">
  <i class="fas fa-check-circle"></i>
  Operazione completata con successo
</div>

<!-- Errore -->
<div class="alert alert-danger">
  <i class="fas fa-exclamation-circle"></i>
  Si è verificato un errore
</div>

<!-- Info -->
<div class="alert alert-info">
  <i class="fas fa-info-circle"></i>
  Informazione importante
</div>
```

### Badge
```html
<!-- Primario -->
<span class="badge badge-primary">Nuovo</span>

<!-- Successo -->
<span class="badge badge-success">Completato</span>

<!-- Pericolo -->
<span class="badge badge-danger">Errore</span>
```

### Progress Bar
```html
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
    75%
  </div>
</div>
```

### Spinner
```html
<div class="spinner-border text-primary" role="status">
  <span class="sr-only">Caricamento...</span>
</div>
```

## 🔗 Collegamenti
- [Performance](./standards/performance.md)
- [Accessibilità](./standards/accessibility.md)
- [UI Standards](./standards/ui-standards.md)
