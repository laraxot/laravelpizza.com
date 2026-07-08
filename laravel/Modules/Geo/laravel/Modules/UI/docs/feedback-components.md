# Componenti Feedback e Notifiche

## 🚨 Alert e Notifiche

### Alert Base
```html
<!-- Successo -->
<div class="alert alert-success" role="alert">
  <i class="fas fa-check-circle"></i>
  Operazione completata con successo
</div>

<!-- Errore -->
<div class="alert alert-danger" role="alert">
  <i class="fas fa-exclamation-circle"></i>
  Si è verificato un errore
</div>

<!-- Info -->
<div class="alert alert-info" role="alert">
  <i class="fas fa-info-circle"></i>
  Informazione importante
</div>

<!-- Warning -->
<div class="alert alert-warning" role="alert">
  <i class="fas fa-exclamation-triangle"></i>
  Attenzione: azione richiesta
</div>
```

### Alert Dismissible
```html
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Attenzione!</strong> Questa azione non può essere annullata.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
</div>
```

## 📢 Toast e Snackbar

### Toast
```html
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <strong class="me-auto">Notifica</strong>
    <small>Ora</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Chiudi"></button>
  </div>
  <div class="toast-body">
    Operazione completata con successo
  </div>
</div>
```

### Snackbar
```html
<div class="snackbar" role="alert" aria-live="polite">
  <div class="snackbar-content">
    <span class="snackbar-message">Modifiche salvate</span>
    <button class="snackbar-action">Annulla</button>
  </div>
</div>
```

## 🗨️ Modali e Dialoghi

### Modal Base
```html
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Titolo Modale</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body">
        <p>Contenuto del modale</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-primary">Conferma</button>
      </div>
    </div>
  </div>
</div>
```

### Dialogo di Conferma
```html
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-question-circle fa-3x mb-3"></i>
        <h5 class="modal-title">Sei sicuro?</h5>
        <p>Questa azione non può essere annullata</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-danger">Elimina</button>
      </div>
    </div>
  </div>
</div>
```

## 💡 Tooltip e Popover

### Tooltip
```html
<button
  type="button"
  class="btn btn-secondary"
  data-bs-toggle="tooltip"
  data-bs-placement="top"
  title="Tooltip in alto"
>
  Tooltip
</button>
```

### Popover
```html
<button
  type="button"
  class="btn btn-secondary"
  data-bs-toggle="popover"
  data-bs-placement="right"
  data-bs-content="Contenuto del popover"
  title="Titolo Popover"
>
  Popover
</button>
```

## ⏳ Progress e Loading States

### Progress Bar
```html
<div class="progress">
  <div
    class="progress-bar progress-bar-striped progress-bar-animated"
    role="progressbar"
    style="width: 75%"
    aria-valuenow="75"
    aria-valuemin="0"
    aria-valuemax="100"
  >
    75%
  </div>
</div>
```

### Skeleton Loading
```html
<div class="skeleton">
  <div class="skeleton-header"></div>
  <div class="skeleton-body">
    <div class="skeleton-line"></div>
    <div class="skeleton-line"></div>
    <div class="skeleton-line"></div>
  </div>
</div>
```

## 🎨 Stili e Comportamenti

### Animazioni
```scss
// Fade in/out
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}

// Slide in/out
@keyframes slideIn {
  from { transform: translateY(100%); }
  to { transform: translateY(0); }
}

@keyframes slideOut {
  from { transform: translateY(0); }
  to { transform: translateY(100%); }
}
```

### Z-index
```scss
$zindex-dropdown: 1000;
$zindex-sticky: 1020;
$zindex-fixed: 1030;
$zindex-modal-backdrop: 1040;
$zindex-modal: 1050;
$zindex-popover: 1060;
$zindex-tooltip: 1070;
```

## 🔗 Collegamenti
- [Componenti Base](./base-components.md)
- [Layout](./layout-components.md)
- [Accessibilità](./standards/accessibility.md)
- [Performance](./standards/performance.md)
# Componenti Feedback e Notifiche

## 🚨 Alert e Notifiche

### Alert Base
```html
<!-- Successo -->
<div class="alert alert-success" role="alert">
  <i class="fas fa-check-circle"></i>
  Operazione completata con successo
</div>

<!-- Errore -->
<div class="alert alert-danger" role="alert">
  <i class="fas fa-exclamation-circle"></i>
  Si è verificato un errore
</div>

<!-- Info -->
<div class="alert alert-info" role="alert">
  <i class="fas fa-info-circle"></i>
  Informazione importante
</div>

<!-- Warning -->
<div class="alert alert-warning" role="alert">
  <i class="fas fa-exclamation-triangle"></i>
  Attenzione: azione richiesta
</div>
```

### Alert Dismissible
```html
<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Attenzione!</strong> Questa azione non può essere annullata.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
</div>
```

## 📢 Toast e Snackbar

### Toast
```html
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
    <strong class="me-auto">Notifica</strong>
    <small>Ora</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Chiudi"></button>
  </div>
  <div class="toast-body">
    Operazione completata con successo
  </div>
</div>
```

### Snackbar
```html
<div class="snackbar" role="alert" aria-live="polite">
  <div class="snackbar-content">
    <span class="snackbar-message">Modifiche salvate</span>
    <button class="snackbar-action">Annulla</button>
  </div>
</div>
```

## 🗨️ Modali e Dialoghi

### Modal Base
```html
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Titolo Modale</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
      </div>
      <div class="modal-body">
        <p>Contenuto del modale</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-primary">Conferma</button>
      </div>
    </div>
  </div>
</div>
```

### Dialogo di Conferma
```html
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fas fa-question-circle fa-3x mb-3"></i>
        <h5 class="modal-title">Sei sicuro?</h5>
        <p>Questa azione non può essere annullata</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-danger">Elimina</button>
      </div>
    </div>
  </div>
</div>
```

## 💡 Tooltip e Popover

### Tooltip
```html
<button
  type="button"
  class="btn btn-secondary"
  data-bs-toggle="tooltip"
  data-bs-placement="top"
  title="Tooltip in alto"
>
  Tooltip
</button>
```

### Popover
```html
<button
  type="button"
  class="btn btn-secondary"
  data-bs-toggle="popover"
  data-bs-placement="right"
  data-bs-content="Contenuto del popover"
  title="Titolo Popover"
>
  Popover
</button>
```

## ⏳ Progress e Loading States

### Progress Bar
```html
<div class="progress">
  <div
    class="progress-bar progress-bar-striped progress-bar-animated"
    role="progressbar"
    style="width: 75%"
    aria-valuenow="75"
    aria-valuemin="0"
    aria-valuemax="100"
  >
    75%
  </div>
</div>
```

### Skeleton Loading
```html
<div class="skeleton">
  <div class="skeleton-header"></div>
  <div class="skeleton-body">
    <div class="skeleton-line"></div>
    <div class="skeleton-line"></div>
    <div class="skeleton-line"></div>
  </div>
</div>
```

## 🎨 Stili e Comportamenti

### Animazioni
```scss
// Fade in/out
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes fadeOut {
  from { opacity: 1; }
  to { opacity: 0; }
}

// Slide in/out
@keyframes slideIn {
  from { transform: translateY(100%); }
  to { transform: translateY(0); }
}

@keyframes slideOut {
  from { transform: translateY(0); }
  to { transform: translateY(100%); }
}
```

### Z-index
```scss
$zindex-dropdown: 1000;
$zindex-sticky: 1020;
$zindex-fixed: 1030;
$zindex-modal-backdrop: 1040;
$zindex-modal: 1050;
$zindex-popover: 1060;
$zindex-tooltip: 1070;
```

## 🔗 Collegamenti
- [Componenti Base](./base-components.md)
- [Layout](./layout-components.md)
- [Accessibilità](./standards/accessibility.md)
- [Performance](./standards/performance.md)
