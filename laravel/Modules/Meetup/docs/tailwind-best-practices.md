# Best Practices Tailwind CSS - Modulo Meetup

## 📋 Panoramica

Questo documento descrive le best practices per l'utilizzo di Tailwind CSS nel tema Meetup e nel modulo.

## 🎯 Principi Fondamentali

### 1. Utility-First
Usa sempre le utility class di Tailwind invece di CSS custom quando possibile.

```blade
{{-- ✅ Buono --}}
<div class="flex items-center justify-between p-6 bg-white rounded-lg shadow-md">

{{-- ❌ Evitare --}}
<div class="custom-card">
```

### 2. Responsive Design
Sempre mobile-first, poi estendi per schermi più grandi.

```blade
{{-- Mobile: 1 colonna, Desktop: 3 colonne --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
```

### 3. Consistenza
Usa sempre le stesse classi per gli stessi scopi.

```blade
{{-- Tutti i button primary usano le stesse classi --}}
<button class="btn-primary">Aggiungi</button>
<button class="btn-primary">Ordina</button>
```

## 🎨 Pattern Comuni

### Layout Container

```blade
{{-- Container principale --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Contenuto -->
</div>
```

### Card Component

```blade
{{-- Card base --}}
<div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="p-6">
        <!-- Contenuto card -->
    </div>
</div>
```

### Button Variants

```blade
{{-- Primary --}}
<button class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
    Aggiungi
</button>

{{-- Secondary --}}
<button class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
    Annulla
</button>

{{-- Outline --}}
<button class="border-2 border-primary-600 text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
    Dettagli
</button>
```

### Form Inputs

```blade
{{-- Text Input --}}
<input
    type="text"
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
    placeholder="Nome pizza"
>

{{-- Select --}}
<select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors">
    <option>Seleziona categoria</option>
</select>

{{-- Textarea --}}
<textarea
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors resize-none"
    rows="4"
></textarea>
```

### Grid Layouts

```blade
{{-- Grid responsive --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @foreach($pizzas as $pizza)
        <!-- Item -->
    @endforeach
</div>

{{-- Flex layout --}}
<div class="flex flex-col md:flex-row items-center justify-between gap-4">
    <!-- Items -->
</div>
```

### Typography

```blade
{{-- Heading 1 --}}
<h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Menu Pizze</h1>

{{-- Heading 2 --}}
<h2 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-3">Categorie</h2>

{{-- Heading 3 --}}
<h3 class="text-xl font-semibold text-gray-800 mb-2">Pizza Margherita</h3>

{{-- Body text --}}
<p class="text-gray-600 leading-relaxed">Descrizione della pizza...</p>

{{-- Small text --}}
<p class="text-sm text-gray-500">Prezzo: €8.50</p>
```

## 🎨 Componenti Personalizzati

### Custom Classes in app.css

```css
@layer components {
    /* Button Primary */
    .btn-primary {
        @apply bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold;
        @apply hover:bg-primary-700 focus:outline-none;
        @apply focus:ring-2 focus:ring-primary-500 focus:ring-offset-2;
        @apply transition-colors duration-200;
    }

    /* Card Pizza */
    .pizza-card {
        @apply bg-white rounded-lg shadow-md overflow-hidden;
        @apply hover:shadow-lg transition-all duration-300;
    }

    /* Input Form */
    .form-input {
        @apply w-full px-4 py-2 border border-gray-300 rounded-lg;
        @apply focus:ring-2 focus:ring-primary-500 focus:border-transparent;
        @apply transition-colors;
    }

    /* Badge */
    .badge {
        @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
    }

    .badge-primary {
        @apply bg-primary-100 text-primary-800;
    }

    .badge-success {
        @apply bg-green-100 text-green-800;
    }
}
```

### Utilizzo Componenti Custom

```blade
{{-- Button con classe custom --}}
<button class="btn-primary">Aggiungi</button>

{{-- Card con classe custom --}}
<div class="pizza-card">
    <!-- Contenuto -->
</div>

{{-- Input con classe custom --}}
<input type="text" class="form-input" placeholder="Nome">
```

## 📱 Responsive Patterns

### Mobile-First Approach

```blade
{{-- Padding: mobile 4, tablet 6, desktop 8 --}}
<div class="p-4 md:p-6 lg:p-8">

{{-- Font size: mobile base, tablet lg, desktop xl --}}
<h1 class="text-2xl md:text-3xl lg:text-4xl">

{{-- Grid: mobile 1 col, tablet 2 cols, desktop 3 cols --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
```

### Hide/Show Responsive

```blade
{{-- Visibile solo su mobile --}}
<div class="block md:hidden">Mobile only</div>

{{-- Visibile solo su desktop --}}
<div class="hidden md:block">Desktop only</div>
```

## 🎭 Stati e Interazioni

### Hover States

```blade
<div class="hover:bg-gray-50 hover:shadow-md transition-all duration-200">
```

### Focus States

```blade
<input class="focus:ring-2 focus:ring-primary-500 focus:border-transparent">
```

### Active States

```blade
<button class="active:scale-95 transition-transform">
```

### Disabled States

```blade
<button class="disabled:opacity-50 disabled:cursor-not-allowed">
```

## 🌈 Colori e Temi

### Uso Colori Primary

```blade
{{-- Background --}}
<div class="bg-primary-600">

{{-- Text --}}
<p class="text-primary-600">

{{-- Border --}}
<div class="border-primary-600">

{{-- Ring (focus) --}}
<input class="focus:ring-primary-500">
```

### Dark Mode (se implementato)

```blade
<div class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
```

## ⚡ Performance

### Purge Content

Assicurati che `tailwind.config.js` includa tutti i path corretti:

```javascript
content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "../../Modules/Meetup/**/*.blade.php",
    "../../Themes/Meetup/**/*.blade.php",
]
```

### Evitare Classi Dinamiche

```blade
{{-- ❌ Evitare --}}
<div class="text-{{ $size }}">

{{-- ✅ Usare condizioni --}}
<div class="{{ $size === 'lg' ? 'text-lg' : 'text-base' }}">
```

## 🔗 Collegamenti

- [Configurazione UI/UX MCP](./ui-ux-mcp-configuration.md)
- [Documentazione Tailwind CSS](https://tailwindcss.com/docs)
- [Tailwind UI Components](https://tailwindui.com/components)

## 📝 Checklist

- [ ] Tutti i componenti usano utility-first
- [ ] Design responsive mobile-first
- [ ] Colori consistenti con palette
- [ ] Focus states visibili
- [ ] Transizioni smooth
- [ ] Classi custom documentate
- [ ] Purge configurato correttamente
