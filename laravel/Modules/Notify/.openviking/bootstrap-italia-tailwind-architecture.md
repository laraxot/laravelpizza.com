# OpenViking: BOOTSTRAP ITALIA + TAILWIND @apply

**URI**: `viking://css/bootstrap-italia-tailwind`  
**Timestamp**: 2026-03-31  
**Status**: ✅ **ARCHITETTURA CHIARA**

---

## 🎯 ARCHITETTURA

```
HTML: Classi Bootstrap Italia
      ↓
CSS:  style-apply.css (Tailwind @apply)
      ↓
Output: Tailwind compila
```

---

## 📋 FILE CHIAVE

### style-apply.css

**Location**: `Themes/Sixteen/Main_files/five/src/`

**Righe**: 1740

**Contenuto**: Classi Bootstrap Italia con @apply

### Esempio

```css
.it-header-wrapper {
  background-color: var(--bs-primary);
  @apply text-white relative;
}
```

---

## 🔧 USO

### HTML (Blade)

```blade
<div class="it-header-wrapper">
  <div class="container">
  <div class="row">
  <div class="col-12">
```

### CSS

**Già gestito** da style-apply.css!

**NON ridefinire!**

---

## 🧘 MANTRAS

> *"Bootstrap Italia nel HTML."*

> *"Tailwind @apply nel CSS."*

> *"style-apply.css gestisce tutto."*

---

**Status**: ✅ **CHIARO**  
**Next**: Usare classi Bootstrap Italia ovunque!
