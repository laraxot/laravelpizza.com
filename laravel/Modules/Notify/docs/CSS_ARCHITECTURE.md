# 📚 Documentazione Finale - Sixteen Theme CSS Architecture

## Panoramica

Il tema Sixteen utilizza un'architettura CSS ibrida:
- **Bootstrap Italia** per i componenti PA (Pubblica Amministrazione)
- **Tailwind CSS** per utility e customizzazioni
- **Filament CSS** per i componenti admin

## Architettura File

```
Themes/Sixteen/resources/css/
├── app.css                    ← File principale
├── bootstrap-italia.css       ← Definizioni componenti Bootstrap Italia
├── agid-colors.css            ← Variabili colori AGID
├── agid-override.css          ← Override specifici
└── filament/
    └── theme.css              ← Customizzazioni Filament
```

## Import Chain

```css
/* app.css */
@import "./bootstrap-italia.css";     /* Componenti PA */
@import "./agid-colors.css";          /* Colori */
@import "./agid-override.css";        /* Override */
@import "tailwindcss";                /* Utility */
@import '../../../../vendor/filament/...'; /* Filament */
```

## Classi Bootstrap Italia

### Standard (da CDN)
```css
@import url('https://cdn.jsdelivr.net/npm/bootstrap-italia@2.8.8/dist/css/bootstrap-italia.min.css');
```

### Custom (da bootstrap-italia.css)
```css
.card-teaser { }
.section-title { }
.calendar-list { }
.calendar-event { }
.card-category { }
.card-date { }
.card-list { }
```

## Tailwind @apply

Usato SOLO per:

### 1. Bottoni Custom
```css
.btn-agid {
  @apply inline-flex items-center justify-center gap-1.5 px-4 py-2 text-sm font-semibold rounded-md;
}
```

### 2. Form Elements
```css
.input-agid {
  @apply w-full px-3 py-2 text-sm border border-gray-300 rounded-md;
}
```

### 3. Cards Custom
```css
.card-agid {
  @apply bg-white rounded-lg shadow-agid border border-gray-200;
}
```

## Componenti Blade

### Hero Homepage
```blade
{{-- File: components/blocks/hero/homepage.blade.php --}}
<article class="card card-teaser shadow-sm">
  <div class="card-body">
    <div class="row">
      <div class="col-md-5">
        <img src="{{ $image }}" class="img-fluid rounded" />
```

### Governance Cards
```blade
{{-- File: components/blocks/governance/cards.blade.php --}}
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-title text-center mb-5">Organi di governo</h2>
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="card card-teaser shadow-sm h-100">
```

### Events Calendar
```blade
{{-- File: components/blocks/events/calendar.blade.php --}}
<section class="py-5">
  <div class="container">
    <h2 class="section-title mb-2">Eventi</h2>
    <div class="calendar-list">
      <div class="calendar-event mb-3 pb-3 border-bottom">
```

### Topics Grid
```blade
{{-- File: components/blocks/topics/highlight.blade.php --}}
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-title mb-5">Argomenti in evidenza</h2>
    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="card card-teaser shadow-sm h-100">
```

## Testing

### Verifica Classi
```bash
curl http://fixcity.local/it/tests/homepage | grep -o 'class="[^"]*"' | sort | uniq
```

### Output Atteso
```
class="card card-teaser"
class="section-title"
class="calendar-list"
class="calendar-event"
class="row g-4"
class="col-lg-4 col-md-6"
class="img-fluid rounded"
class="btn btn-outline-primary btn-sm"
```

## Best Practices

### ✅ CORRETTO
```blade
<!-- Usa classi Bootstrap Italia -->
<div class="card card-teaser">
<h2 class="section-title">
<div class="calendar-list">
```

### ❌ SBAGLIATO
```blade
<!-- Non usare Tailwind per componenti PA -->
<div class="bg-white rounded shadow-lg">
<h2 class="text-3xl font-bold">
<div class="flex flex-col">
```

### ✅ CORRETTO (Customizzazioni)
```blade
<!-- Tailwind solo per layout/utility -->
<div class="card card-teaser mb-4">  <!-- mb-4 OK -->
<section class="py-5 bg-light">     <!-- py-5 OK -->
```

## Risorse

- [Bootstrap Italia Docs](https://italia.github.io/design-web-toolkit/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [Filament Docs](https://filamentphp.com/docs)
- [AGID Design System](https://www.agid.gov.it/it/design-sviluppo/design-system)

---

**Ultimo Aggiornamento**: 2026-03-31  
**Tema**: Sixteen v1.0  
**Framework**: Bootstrap Italia 2.8.8 + Tailwind CSS 4.x + Filament 5.x
