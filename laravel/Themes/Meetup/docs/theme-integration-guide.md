# Guida Integrazione Tema Meetup con Laravel

## 📋 Panoramica

Questa guida spiega come integrare il tema HTML statico Meetup con l'applicazione Laravel, convertendo i file HTML in Blade templates e integrando con il sistema di moduli Laraxot.

## 🎯 Obiettivi Integrazione

1. **Convertire HTML statico in Blade templates**
2. **Integrare con sistema di moduli Laraxot**
3. **Configurare asset building con Vite**
4. **Implementare backend functionality**
5. **Mantenere design system esistente**

## 📁 Struttura Target

```
Themes/Meetup/
├── resources/
│   ├── html/                      # Versione HTML statica (esistente)
│   │   ├── index.html
│   │   ├── menu.html
│   │   ├── events.html
│   │   ├── contact.html
│   │   ├── cart.html
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── views/                     # Blade templates (da creare)
│       ├── layouts/
│       │   ├── app.blade.php
│       │   └── components/
│       ├── pages/
│       │   ├── home.blade.php
│       │   ├── menu.blade.php
│       │   ├── events.blade.php
│       │   ├── contact.blade.php
│       │   └── cart.blade.php
│       └── components/
│           ├── header.blade.php
│           ├── footer.blade.php
│           ├── pizza-card.blade.php
│           └── event-card.blade.php
├── vite.config.js                 # Configurazione Vite
├── tailwind.config.js            # Configurazione Tailwind
└── package.json                  # Dipendenze npm
```


## 🔄 Conversione HTML → Blade (Folio & Volt)

In Laraxot, non usiamo controller tradizionali per il frontend. Usiamo **Laravel Folio** per il routing basato su file e **Livewire Volt** per i componenti interattivi.

### 1. **Routing con Folio**

Le pagine vengono create come file Blade in `Themes/Meetup/resources/views/pages/`.
Esempio per la home (`index.blade.php`):

```php
<?php

use function Laravel\Folio\name;
use function Livewire\Volt\layout;

name('home');
layout('pub_theme::layouts.app');

?>

<div>
    <x-pub_theme::blocks.hero />
    <x-pub_theme::blocks.features />
    <x-pub_theme::blocks.menu-highlights />
</div>
```

### 2. **Componenti Interattivi con Volt**

Per componenti che richiedono logica (es. aggiunta al carrello, form di contatto), usiamo Volt (Anonymous o Class API).

```php
<?php

use function Livewire\Volt\{state};

state(['count' => 0]);

$increment = fn () => $this->count++;

?>

<div class="p-4 border rounded">
    <h3 class="text-xl">Contatore: {{ $count }}</h3>
    <button wire:click="increment" class="btn-primary">Incrementa</button>
</div>
```

### 3. **Gestione Dati con x-page**

Per pagine di contenuto dinamico (About, Contact, Privacy), definiamo la struttura in JSON (`config/local/laravelpizza/database/content/pages/*.json`) e usiamo il componente `<x-page />`.

```php
@section('content')
    <x-page :slug="$slug" />
@endsection
```

### 4. **Layout System**

- `x-layouts.main`: Struttura HTML base.
- `x-layouts.app`: Layout completo con Header e Footer (estende `main`).
- `x-layouts.guest`: Layout per auth (estende `main`).

---

## 🔧 Configurazione Laraxot

### 1. **Metodologia "Super Mucca"**
Segui sempre i principi DRY, KISS, SOLID e Robust. Studia i `docs` prima di agire e aggiornali dopo.

### 2. **XotBase Alignment**
Se crei componenti Filament per il pannello admin, estendi sempre le classi `XotBase*`.

## 🎨 Configurazione Vite

### 1. **Vite Configuration Aggiornata**

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    tailwindcss(),
  ],
  build: {
    rollupOptions: {
      output: {
        manualChunks: {
          'cart': ['./resources/js/cart.js'],
          'menu': ['./resources/js/menu.js'],
        }
      }
    }
  },
});
```

### 2. **Asset Structure**

```
Themes/Meetup/resources/
├── css/
│   └── app.css          # Tailwind CSS + custom styles
├── js/
│   ├── app.js           # Main JavaScript file
│   ├── cart.js          # Cart functionality
│   └── menu.js          # Menu interactions
└── images/              # Theme images
```

## 🔄 Migrazione Dati

### 1. **Database Schema per Meetup Module**

```php
<?php

// Modules/Meetup/database/migrations/create_meetup_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meetup_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('meetup_pizzas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->foreignUuid('category_id')->constrained('meetup_categories');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        // ... altre tabelle
    }
};
```

## 📋 Checklist Implementazione

- [ ] Creare struttura Blade templates
- [ ] Convertire HTML statico in Blade
- [ ] Creare Service Provider per tema
- [ ] Configurare routes
- [ ] Implementare controllers
- [ ] Configurare Vite per assets
- [ ] Migrare dati da HTML a database
- [ ] Testare integrazione completa
- [ ] Ottimizzare performance
- [ ] Implementare caching

## 🔗 Collegamenti

- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Laravel Vite Integration](https://laravel.com/docs/vite)
- [Tailwind CSS with Laravel](https://tailwindcss.com/docs/guides/laravel)
- [Laraxot Architecture Documentation](../Modules/Xot/docs/)

---
**Ultimo aggiornamento**: [DATE]
**Status**: 🟡 In Progress
**Priorità**: ALTA
