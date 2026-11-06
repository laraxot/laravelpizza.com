# 🧩 UI Components - Documentation Index

**Path**: `Modules/UI/docs/`  
**Modulo**: @Modules/UI  
**Last Updated**: 2026-03-26  
**Status**: ✅ IN PROGRESS

---

## 🎯 Scopo

Componenti UI riutilizzabili per tutti i temi e moduli.

**Principi**:
- **Reusable**: Scrivi una volta, usa ovunque
- **Composable**: Componenti piccoli → componibili → potenti
- **Accessible**: WCAG 2.2 AA compliant
- **Themeable**: Personalizzabile dal tema

---

## 📦 Componenti

### Blade Components

| Componente | File | Descrizione | Status |
|------------|------|-------------|--------|
| Testimonials | `testimonials.blade.php` | Componente testimonials riutilizzabile | ✅ TODO |
| Stats Card | `stats-card.blade.php` | Card per statistiche | ⏳ TODO |
| Feature Card | `feature-card.blade.php` | Card per features | ⏳ TODO |
| Pricing Card | `pricing-card.blade.php` | Card per pricing | ⏳ TODO |

---

## 🧩 Testimonials Component

### Usage

```blade
{{-- Basic Usage --}}
<x-ui::testimonials 
    :items="$testimonials"
    title="Cosa dicono i nostri utenti"
    subtitle="Migliaia di utenti soddisfatti"
/>

{{-- Advanced Usage --}}
<x-ui::testimonials 
    :items="[
        [
            'name' => 'Mario Rossi',
            'role' => 'Trader Professionista',
            'avatar' => 'https://example.com/avatar.jpg',
            'content' => 'Questa piattaforma ha cambiato il mio modo di fare trading.',
            'rating' => 5,
        ],
        // ...
    ]"
    title="Dicono di noi"
    subtitle="Le recensioni dei nostri utenti"
    columns="3"
    autoplay="true"
    autoplay-speed="5000"
/>
```

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `items` | array | `[]` | Array di testimonials |
| `title` | string | `''` | Titolo sezione |
| `subtitle` | string | `''` | Sottotitolo sezione |
| `columns` | string | `'3'` | Colonne (1, 2, 3, 4) |
| `autoplay` | bool | `false` | Autoplay carousel |
| `autoplay-speed` | int | `5000` | Velocità autoplay (ms) |
| `showRating` | bool | `true` | Mostra rating stelle |
| `rounded` | string | `'full'` | Avatar rounded (none, sm, md, lg, full) |

### Item Structure

```php
[
    'name' => 'Mario Rossi',           // Nome utente
    'role' => 'Trader',                // Ruolo (opzionale)
    'avatar' => 'url...',              // URL avatar (opzionale)
    'content' => 'Testimonial...',     // Contenuto
    'rating' => 5,                     // Rating 1-5 (opzionale)
]
```

---

## 🔗 Link Bidirezionali

### Da Questo Indice

| Da | A | Tipo |
|----|---|------|
| Testimonials Component | [Theme Customization](../../Themes/TwentyOne/docs/components/testimonials.md) | Integration |
| Testimonials Component | [Predict Homepage](../../Modules/Predict/docs/02-frontend/00-INDEX.md) | Consumer |

### Verso Questo Indice

| Da | A | Tipo |
|----|---|------|
| [Theme Index](../../Themes/TwentyOne/docs/00-INDEX.md) | UI Components | Dependency |
| [Predict Module Index](../../Modules/Predict/docs/00-INDEX.md) | UI Components | Reference |

---

## 📚 Riferimenti

### Interni
- [Maintainable CSS - Semantics](https://maintainablecss.com/chapters/semantics/)
- [WCAG 2.2 Guidelines](https://www.w3.org/WAI/WCAG22/quickref/)

### Esterni
- [Laravel Blade Components](https://laravel.com/docs/blade#components)
- [Alpine.js](https://alpinejs.dev/start-here)

---

**Maintained By**: AI Agents Team  
**Review Cycle**: Every sprint  
**Next Review**: 2026-04-02
