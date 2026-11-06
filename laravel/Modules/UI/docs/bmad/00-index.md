---
title: "UI: indice della documentazione"
description: "Documentazione del modulo UI: componenti di interfaccia condivisi."
module: UI
tags: [ui, documentazione, modulo, laraxot]
status: active
repository: https://github.com/laraxot/module_ui_fila5
related:
  - ./00-index.md
  - ./index.md
  - ../../../../../docs/wiki/audits/docs-redundancy-audit.md
issues: https://github.com/laraxot/module_ui_fila5/issues
discussions: https://github.com/laraxot/module_ui_fila5/discussions
type: index
updated: 2026-10-15
qmd: "**indice documentazione modulo ui** ui"
---

# 📚 **Indice Documentazione Modulo UI**

**Last Update**: 31 Gennaio 2026
**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Design System e overview componenti.
2. [roadmap.md](../_archive/roadmap.md) - Evoluzione 2026: Tailwind v4 e Flux UI integration.
3. [philosophy.md](./philosophy.md) - "La Bellezza è Funzionale": filosofia del design in Laraxot.

## 🏗️ **Core Design System**
- 🎨 **[Layouts & Themes](./layouts-and-themes.md)** - Gestione dei temi per tenant e dark mode.
- 📐 **[Architecture Rules](./architecture.md)** - Regole per la creazione di nuovi componenti UI.
- 🖋️ **[Icon System](./icon-system.md)** - Integrazione di Blade Icons e set personalizzati.

## 🧱 **Componenti & Widget**
- 🧩 **[Blade Components](./blade-components.md)** - Libreria di componenti atomici riutilizzabili.
- ⚡ **[Filament Components](../legacy/filament-components-usage.md)** - Custom columns, fields e widgets per l'Admin Panel.
- 📍 **[Location Selector](./filament-components-location-studio.md)** - Componente avanzato per la selezione geografica.

## 🛠️ **Integrazioni Tecniche**
- 🏗️ **[Tailwind v4 Upgrade](./filament-v4-theme-upgrade.md)** - Guida alla migrazione verso l'ultima versione di Tailwind.
- 🛣️ **[Folio & Volt Themes](./struttura-themes-folio.md)** - Gestione dei temi nelle pagine Folio.
- 🧪 **[Table Layout Enum](./table-layout-enum-complete-guide.md)** - Standardizzazione dei layout tabelle.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-level-10-cleanup.md)** - Report di conformità Level 10.
- 🔬 **[Testing UI](./testing.md)** - Test di regressione visuale e componenti.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./consolidation-plan.md)** - Strategia per ridurre i 280+ file di documentazione.

## 📦 **Pacchetti Composer**
- [Riferimento composer packages](../../../../../bashscripts/ai/wiki/memories/composer-packages-reference.md)
- `owenvoke/blade-fontawesome` - Icone FontAwesome

## 🔗 **Moduli Correlati**
- [Xot](../../../Xot/docs/README.md) - Base framework per i widget.
- [Cms](../../../Cms/docs/README.md) - Layout dei contenuti e blocchi.

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

---

<!-- Merged from 00-INDEX.md, which collided with this file on case-insensitive filesystems. -->

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
| Testimonials Component | [Predict Homepage](../../Modules/<nome modulo>/docs/02-frontend/00-index.md) | Consumer |
| Testimonials Component | [forecast Homepage](../../Modules/Domain/docs/02-frontend/00-index.md) | Consumer |

### Verso Questo Indice

| Da | A | Tipo |
|----|---|------|
| [Theme Index](../../../../Themes/TwentyOne/docs/00-INDEX.md) | UI Components | Dependency |
| [Predict Module Index](../../Modules/<nome modulo>/docs/00-index.md) | UI Components | Reference |
| [forecast Module Index](../../Modules/Domain/docs/00-index.md) | UI Components | Reference |

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
---
## Contenuto assorbito da `00-INDEX.md`
# 🧩 UI Components - Documentation Index
**Path**: `Modules/UI/docs/`  
**Modulo**: @Modules/UI  
**Last Updated**: 2026-03-26  
**Status**: ✅ IN PROGRESS
## 🎯 Scopo
Componenti UI riutilizzabili per tutti i temi e moduli.
**Principi**:
- **Reusable**: Scrivi una volta, usa ovunque
- **Composable**: Componenti piccoli → componibili → potenti
- **Accessible**: WCAG 2.2 AA compliant
- **Themeable**: Personalizzabile dal tema
## 📦 Componenti
### Blade Components
| Componente | File | Descrizione | Status |
|------------|------|-------------|--------|
| Testimonials | `testimonials.blade.php` | Componente testimonials riutilizzabile | ✅ TODO |
| Stats Card | `stats-card.blade.php` | Card per statistiche | ⏳ TODO |
| Feature Card | `feature-card.blade.php` | Card per features | ⏳ TODO |
| Pricing Card | `pricing-card.blade.php` | Card per pricing | ⏳ TODO |
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
    'name' => 'Mario Rossi',           // Nome utente
    'role' => 'Trader',                // Ruolo (opzionale)
    'avatar' => 'url...',              // URL avatar (opzionale)
    'content' => 'Testimonial...',     // Contenuto
    'rating' => 5,                     // Rating 1-5 (opzionale)
]
## 🔗 Link Bidirezionali
### Da Questo Indice
| Da | A | Tipo |
|----|---|------|
| Testimonials Component | [Theme Customization](../../Themes/TwentyOne/docs/components/testimonials.md) | Integration |
| Testimonials Component | [Predict Homepage](../../Modules/Predict/docs/02-frontend/00-INDEX.md) | Consumer |
### Verso Questo Indice
| [Theme Index](../../Themes/TwentyOne/docs/00-INDEX.md) | UI Components | Dependency |
| [Predict Module Index](../../Modules/Predict/docs/00-INDEX.md) | UI Components | Reference |
## 📚 Riferimenti
### Interni
- [Maintainable CSS - Semantics](https://maintainablecss.com/chapters/semantics/)
- [WCAG 2.2 Guidelines](https://www.w3.org/WAI/WCAG22/quickref/)
### Esterni
- [Laravel Blade Components](https://laravel.com/docs/blade#components)
- [Alpine.js](https://alpinejs.dev/start-here)
**Maintained By**: AI Agents Team  
**Review Cycle**: Every sprint  
**Next Review**: 2026-04-02
