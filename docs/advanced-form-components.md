# Componenti Form Avanzati

## 📝 Input Avanzati

### Input con Icona
```html
<div class="input-group">
  <span class="input-group-text">
    <i class="fas fa-user"></i>
  </span>
  <input type="text" class="form-control" placeholder="Username">
</div>
```

### Input con Validazione
```html
<div class="form-group">
  <label for="email">Email</label>
  <input
    type="email"
    id="email"
    class="form-control is-invalid"
    aria-describedby="email-error"
  >
  <div id="email-error" class="invalid-feedback">
    Inserisci un indirizzo email valido
  </div>
</div>
```

### Input con Autocompletamento
```html
<div class="form-group">
  <label for="search">Cerca</label>
  <input
    type="text"
    id="search"
    class="form-control"
    list="suggestions"
    autocomplete="off"
  >
  <datalist id="suggestions">
    <option value="Suggerimento 1">
    <option value="Suggerimento 2">
  </datalist>
</div>
```

## 📅 Selezione Data e Ora

### DatePicker
```html
<div class="form-group">
  <label for="date">Data</label>
  <div class="input-group datepicker">
    <input
      type="text"
      id="date"
      class="form-control"
      data-date-format="dd/mm/yyyy"
    >
    <span class="input-group-text">
      <i class="fas fa-calendar"></i>
    </span>
  </div>
</div>
```

### TimePicker
```html
<div class="form-group">
  <label for="time">Ora</label>
  <div class="input-group timepicker">
    <input
      type="text"
      id="time"
      class="form-control"
      data-time-format="HH:mm"
    >
    <span class="input-group-text">
      <i class="fas fa-clock"></i>
    </span>
  </div>
</div>
```

## 📊 Input Numerici

### Range Slider
```html
<div class="form-group">
  <label for="range">Range</label>
  <input
    type="range"
    id="range"
    class="form-range"
    min="0"
    max="100"
    step="1"
  >
  <div class="range-value">50</div>
</div>
```

### Input con Step
```html
<div class="form-group">
  <label for="quantity">Quantità</label>
  <div class="input-group">
    <button class="btn btn-outline-secondary" type="button">-</button>
    <input
      type="number"
      id="quantity"
      class="form-control text-center"
      min="0"
      max="100"
      step="1"
      value="1"
    >
    <button class="btn btn-outline-secondary" type="button">+</button>
  </div>
</div>
```

## 📎 Upload File

### Drag & Drop
```html
<div class="upload-area">
  <input type="file" id="file" class="d-none">
  <label for="file" class="upload-label">
    <i class="fas fa-cloud-upload-alt"></i>
    <span>Trascina i file qui o clicca per selezionare</span>
  </label>
  <div class="upload-preview"></div>
</div>
```

### Preview Immagini
```html
<div class="image-upload">
  <input type="file" id="image" accept="image/*" class="d-none">
  <label for="image" class="image-preview">
    <img src="placeholder.jpg" alt="Preview">
    <div class="image-overlay">
      <i class="fas fa-camera"></i>
      <span>Cambia immagine</span>
    </div>
  </label>
</div>
```

## 🎨 Stili e Comportamenti

### Focus States
```scss
.form-control {
  &:focus {
    border-color: $primary;
    box-shadow: 0 0 0 0.2rem rgba($primary, 0.25);
  }

  &.is-invalid {
    border-color: $danger;

    &:focus {
      box-shadow: 0 0 0 0.2rem rgba($danger, 0.25);
    }
  }
}
```

### Animazioni
```scss
.input-group {
  transition: all 0.3s ease;

  &:focus-within {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
}
```

## 🔗 Collegamenti
- [Componenti Base](./base-components.md)
- [Feedback](./feedback-components.md)
- [Accessibilità](./standards/accessibility.md)
- [Performance](./standards/performance.md)
# Componenti Form Avanzati

## 📝 Input Avanzati

### Input con Icona
```html
<div class="input-group">
  <span class="input-group-text">
    <i class="fas fa-user"></i>
  </span>
  <input type="text" class="form-control" placeholder="Username">
</div>
```

### Input con Validazione
```html
<div class="form-group">
  <label for="email">Email</label>
  <input
    type="email"
    id="email"
    class="form-control is-invalid"
    aria-describedby="email-error"
  >
  <div id="email-error" class="invalid-feedback">
    Inserisci un indirizzo email valido
  </div>
</div>
```

### Input con Autocompletamento
```html
<div class="form-group">
  <label for="search">Cerca</label>
  <input
    type="text"
    id="search"
    class="form-control"
    list="suggestions"
    autocomplete="off"
  >
  <datalist id="suggestions">
    <option value="Suggerimento 1">
    <option value="Suggerimento 2">
  </datalist>
</div>
```

## 📅 Selezione Data e Ora

### DatePicker
```html
<div class="form-group">
  <label for="date">Data</label>
  <div class="input-group datepicker">
    <input
      type="text"
      id="date"
      class="form-control"
      data-date-format="dd/mm/yyyy"
    >
    <span class="input-group-text">
      <i class="fas fa-calendar"></i>
    </span>
  </div>
</div>
```

### TimePicker
```html
<div class="form-group">
  <label for="time">Ora</label>
  <div class="input-group timepicker">
    <input
      type="text"
      id="time"
      class="form-control"
      data-time-format="HH:mm"
    >
    <span class="input-group-text">
      <i class="fas fa-clock"></i>
    </span>
  </div>
</div>
```

## 📊 Input Numerici

### Range Slider
```html
<div class="form-group">
  <label for="range">Range</label>
  <input
    type="range"
    id="range"
    class="form-range"
    min="0"
    max="100"
    step="1"
  >
  <div class="range-value">50</div>
</div>
```

### Input con Step
```html
<div class="form-group">
  <label for="quantity">Quantità</label>
  <div class="input-group">
    <button class="btn btn-outline-secondary" type="button">-</button>
    <input
      type="number"
      id="quantity"
      class="form-control text-center"
      min="0"
      max="100"
      step="1"
      value="1"
    >
    <button class="btn btn-outline-secondary" type="button">+</button>
  </div>
</div>
```

## 📎 Upload File

### Drag & Drop
```html
<div class="upload-area">
  <input type="file" id="file" class="d-none">
  <label for="file" class="upload-label">
    <i class="fas fa-cloud-upload-alt"></i>
    <span>Trascina i file qui o clicca per selezionare</span>
  </label>
  <div class="upload-preview"></div>
</div>
```

### Preview Immagini
```html
<div class="image-upload">
  <input type="file" id="image" accept="image/*" class="d-none">
  <label for="image" class="image-preview">
    <img src="placeholder.jpg" alt="Preview">
    <div class="image-overlay">
      <i class="fas fa-camera"></i>
      <span>Cambia immagine</span>
    </div>
  </label>
</div>
```

## 🎨 Stili e Comportamenti

### Focus States
```scss
.form-control {
  &:focus {
    border-color: $primary;
    box-shadow: 0 0 0 0.2rem rgba($primary, 0.25);
  }

  &.is-invalid {
    border-color: $danger;

    &:focus {
      box-shadow: 0 0 0 0.2rem rgba($danger, 0.25);
    }
  }
}
```

### Animazioni
```scss
.input-group {
  transition: all 0.3s ease;

  &:focus-within {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
}
```

## 🔗 Collegamenti
- [Componenti Base](./base-components.md)
- [Feedback](./feedback-components.md)
- [Accessibilità](./standards/accessibility.md)
- [Performance](./standards/performance.md)
