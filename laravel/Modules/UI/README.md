# UI Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Components 222+](https://img.shields.io/badge/Components-222+-purple.svg)](#componenti-blade)
[![SVG Icons 365+](https://img.shields.io/badge/SVG%20Icons-365+-orange.svg)](#sistema-icone)
[![Widgets 11](https://img.shields.io/badge/Widgets-11-blue.svg)](#widget-filament)

> **Design system condiviso per tutti i moduli Laraxot**: 222 componenti Blade, 365+ icone SVG, 11 widget Filament, page builder a blocchi, dark mode, layout responsive. La base visiva dell'intero ecosistema.

---

## Cosa fa

Il modulo UI e il **design system centralizzato** di Laraxot. Ogni modulo (Quaeris, Limesurvey, Cms, etc.) usa i suoi componenti Blade, icone SVG e widget Filament per garantire coerenza visiva e ridurre la duplicazione.

```blade
{{-- Icone con prefisso ui- --}}
@svg('ui-login')
@svg('ui-user')
@svg('ui-settings')

{{-- Componenti layout --}}
<x-ui::navbar />
<x-ui::sidebar />
<x-ui::dark-mode-switcher />

{{-- Blocchi pre-costruiti per pagine --}}
<x-ui::blocks.hero.centered />
<x-ui::blocks.cta.stacked />
<x-ui::blocks.features.grid />
```

---

## Architettura

```
UI Module (design system centralizzato)
    |
    +-- 222 Componenti Blade
    |     +-- 11 Component class PHP (Svg, Logo, Navbar, Sidebar...)
    |     +-- 211 Block templates (hero, CTA, features, blog, newsletter...)
    |
    +-- 365+ Icone SVG
    |     +-- 100+ icone azione/UI
    |     +-- 240+ bandiere paesi
    |     +-- 20+ brand social media
    |     +-- 4 avatar default
    |
    +-- 11 Widget Filament
    |     +-- StatsOverview, Calendar, DarkMode, Chart...
    |
    +-- TableLayoutEnum (toggle lista/griglia)
    +-- InlineDatePicker (date selettive)
    +-- Theme system (dark/light, multi-tenant)
    |
    v
Tutti i moduli Laraxot
```

---

## Componenti Blade

### Component Class (11 PHP)

| Componente | Funzione |
|------------|----------|
| **Svg** | Rendering icone SVG con attributi dinamici |
| **Logo** | Logo applicazione con varianti |
| **Navbar** | Barra navigazione responsive |
| **Sidebar** | Sidebar collassabile |
| **Block** | Container blocco contenuto |
| **DarkModeSwitcher** | Toggle tema chiaro/scuro |
| **BreadLink** | Link breadcrumb |
| **WithSidebar** | Layout con sidebar |
| **Simple / Std** | Layout standard |

### Blocchi Pre-costruiti (211 template)

Libreria completa di blocchi riutilizzabili per costruire pagine:

| Categoria | Varianti | Esempi |
|-----------|----------|--------|
| **Hero** | 13 | Centered, split, con immagine, dark, phone mockup, code example |
| **Features** | 30+ | Grid, testimonials, screenshots, product showcase |
| **CTA** | 15+ | Centered, stacked, justified, dark, branded |
| **Blog** | 15+ | Single/multi colonna, con immagini, featured, archivio |
| **Header** | 15+ | Centered, con stats, background image, dark |
| **Newsletter** | 10+ | Side-by-side, stacked, su card, dark background |
| **Altro** | 20+ | Appointment, documents, eligibility, gallery, paragraph |

```blade
{{-- Costruisci una pagina combinando blocchi --}}
<x-ui::blocks.hero.centered
    title="Dashboard Survey"
    subtitle="Gestisci i tuoi questionari"
/>

<x-ui::blocks.features.grid :features="$features" />

<x-ui::blocks.cta.branded
    action-url="/surveys/create"
    action-text="Crea Survey"
/>
```

---

## Sistema Icone

365+ icone SVG registrate automaticamente con Blade Icons, prefisso `ui-`:

### Icone Azione/UI (100+)

```blade
@svg('ui-edit')       {{-- Modifica --}}
@svg('ui-delete')     {{-- Elimina --}}
@svg('ui-create')     {{-- Crea --}}
@svg('ui-export')     {{-- Esporta --}}
@svg('ui-login')      {{-- Login --}}
@svg('ui-user')       {{-- Utente --}}
@svg('ui-settings')   {{-- Impostazioni --}}
@svg('ui-archive')    {{-- Archivio --}}
@svg('ui-ai')         {{-- Intelligenza artificiale --}}
@svg('ui-brain')      {{-- Cervello/AI --}}
```

### In Filament

```php
// Form
TextInput::make('email')->prefixIcon('ui-login');

// Table
TextColumn::make('name')->icon('ui-user');

// Action
Action::make('delete')->icon('ui-trash');

// Navigation
protected static ?string $navigationIcon = 'ui-settings';
```

### Bandiere Paesi (240+)

```blade
@svg('ui-flag-it')  {{-- Italia --}}
@svg('ui-flag-de')  {{-- Germania --}}
@svg('ui-flag-us')  {{-- USA --}}
{{-- Tutte le bandiere ISO 3166-1 --}}
```

### Brand Social Media (20+)

```blade
@svg('ui-brand-twitter')
@svg('ui-brand-linkedin')
@svg('ui-brand-github')
@svg('ui-brand-facebook')
@svg('ui-brand-instagram')
@svg('ui-brand-youtube')
@svg('ui-brand-discord')
@svg('ui-brand-slack')
@svg('ui-brand-spotify')
```

---

## Widget Filament

11 widget che estendono XotBaseWidget:

| Widget | Funzione |
|--------|----------|
| **StatsOverviewWidget** | Dashboard con metriche aggregate |
| **StatWithIconWidget** | Statistica singola con icona |
| **RowWidget** | Layout a riga per widget multipli |
| **HeroWidget** | Sezione hero nel pannello admin |
| **DarkModeSwitcherWidget** | Toggle tema nel pannello |
| **UserCalendarWidget** | Calendario eventi con date picker |
| **GroupWidget** | Container per raggruppare widget |
| **OverlookWidget** | Overview/sommario rapido |
| **RedirectWidget** | Redirect programmabile |
| **TestChartWidget** | Chart di test/demo |
| **TestWidget** | Widget di test/sviluppo |

---

## TableLayoutEnum

Sistema toggle per passare da vista lista a vista griglia nelle tabelle Filament:

```php
use Modules\UI\Enums\TableLayoutEnum;

// Nella resource Filament
public function getTableLayout(): TableLayoutEnum
{
    return TableLayoutEnum::fromSession('posts', TableLayoutEnum::List);
}

// L'utente puo switchare tra List e Grid
// La preferenza viene salvata in sessione
```

---

## InlineDatePicker

Date picker custom con selezione di date specifiche:

```php
use Modules\UI\Filament\Forms\Components\InlineDatePicker;

InlineDatePicker::make('selected_dates')
    ->selectableDates($availableDates)
    ->multiple()
    ->label('Seleziona le date');
```

---

## Dark Mode e Theming

```blade
{{-- Toggle automatico --}}
<x-ui::dark-mode-switcher />

{{-- Il sistema supporta: --}}
{{-- 1. Dark/Light mode con classe Tailwind dark: --}}
{{-- 2. Theme per tenant (colori personalizzati) --}}
{{-- 3. Persistenza preferenza utente --}}
```

---

## Modelli

| Modello | Funzione |
|---------|----------|
| **Category** | Categorie per organizzazione contenuti |
| **Collection** | Collezioni/raggruppamenti |
| **FieldOption** | Opzioni per campi form dinamici |

---

## Integrazione con altri moduli

```
UI ──> Xot        (XotBaseWidget, XotBaseResource)
UI ──> Quaeris    (componenti dashboard, icone survey)
UI ──> Cms        (blocchi pagina, layout)
UI ──> Chart      (widget chart base)
UI ──> User       (avatar, icone profilo)
UI ──> Limesurvey (icone tipi domanda)
UI ──> Notify     (template email, icone notifica)
UI ──> Lang       (traduzioni IT/EN/DE)
```

Tutti i moduli importano componenti e icone dal modulo UI per coerenza visiva.

---

## Quick Start

```bash
# Il modulo e gia incluso nel monorepo
php artisan module:enable UI

# Le icone sono disponibili immediatamente
# Usa il prefisso ui- in Blade o Filament

# Verifica le icone disponibili
ls laravel/Modules/UI/resources/svg/
```

### Usare un blocco in una pagina

```blade
{{-- resources/views/pages/landing.blade.php --}}
@extends('ui::layouts.master')

@section('content')
    <x-ui::blocks.hero.split
        title="Quaeris Survey Platform"
        subtitle="Gestione survey professionale"
        image="/images/dashboard-preview.png"
    />

    <x-ui::blocks.features.grid :features="[
        ['title' => 'Survey', 'icon' => 'ui-survey'],
        ['title' => 'Dashboard', 'icon' => 'ui-chart'],
        ['title' => 'Report PDF', 'icon' => 'ui-export'],
    ]" />
@endsection
```

---

## Metriche del modulo

| Metrica | Valore |
|---------|--------|
| **Componenti Blade** | 222 (11 class + 211 block template) |
| **Icone SVG** | 365+ (azioni, bandiere, brand) |
| **Widget Filament** | 11 |
| **Modelli** | 3 |
| **Bandiere paesi** | 240+ (ISO 3166-1 completo) |
| **Brand social** | 20+ |
| **Categorie blocchi** | 7 (hero, CTA, features, blog, header, newsletter, misc) |
| **Lingue** | 3 (IT/EN/DE) |
| **Documentazione** | 498 file |
| **PHPStan Level** | 10 |

---

## Documentazione

| Guida | Link |
|-------|------|
| **Indice** | [docs/README.md](docs/readme.md) |
| **Filosofia design** | [docs/philosophy.md](docs/philosophy.md) |
| **Sistema icone** | [docs/icon-system.md](docs/icon-system.md) |
| **Componenti Blade** | [docs/blade-components.md](docs/blade-components.md) |
| **TableLayoutEnum** | [docs/table-layout-enum-complete-guide.md](docs/table-layout-enum-complete-guide.md) |
| **Componenti Filament** | [docs/filament-components-usage.md](docs/filament-components-usage.md) |
| **Architettura** | [docs/architecture.md](docs/architecture.md) |

---

**Module Type**: Design System & UI Components
**Critical Level**: Alto (usato da tutti i moduli per interfaccia)
**Architecture**: Component-based, Blade + Filament, Tailwind CSS v4
**Quality**: PHPStan Level 10, 365+ icone, 222 componenti testati

*Il design system che unifica l'intero ecosistema Laraxot: componenti, icone e layout condivisi.*
