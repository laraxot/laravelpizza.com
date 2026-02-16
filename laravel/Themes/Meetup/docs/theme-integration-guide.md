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

## 🔄 Conversione HTML → Blade

### 1. **Layout Base (app.blade.php)**

```php
<!DOCTYPE html>
<html lang="it" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel Pizza - Pizzeria Artigianale')</title>
    <meta name="description" content="@yield('description', 'Laravel Pizza - Le migliori pizze artigianali consegnate a casa tua')">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Head Content -->
    @yield('head')
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    @include('pub_theme::components.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('pub_theme::components.footer')

    <!-- Additional Scripts -->
    @yield('scripts')
</body>
</html>
```

### 2. **Homepage Blade Template (home.blade.php)**

```php
@extends('pub_theme::layouts.app')

@section('title', 'Laravel Pizza - Pizzeria Artigianale | Ordina Online')
@section('description', 'Laravel Pizza - Le migliori pizze artigianali consegnate a casa tua. Ingredienti freschi, ricette tradizionali e consegna veloce.')

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative bg-gradient-to-br from-primary-600 to-primary-700 text-white section overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="container-custom relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold mb-6 text-balance">
                        La Pizza Artigianale che ami, a casa tua
                    </h1>
                    <p class="text-xl md:text-2xl text-primary-50 mb-8 text-balance">
                        Ingredienti freschi, ricette tradizionali e consegna veloce. Ordina ora e goditi la migliore pizza della città!
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('meetup.menu') }}" class="btn-secondary inline-block text-center">Vedi il Menu</a>
                        <a href="#ordina" class="bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block text-center">
                            Ordina Subito
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative">
                    <div class="aspect-square bg-white/10 backdrop-blur-sm rounded-full p-8">
                        <img src="{{ asset('images/pizza-hero.png') }}" alt="Pizza artigianale Laravel Pizza" class="w-full h-full object-cover rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section bg-white">
        <div class="container-custom">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature Cards -->
                @foreach($features as $feature)
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 {{ $feature['bgColor'] }} {{ $feature['textColor'] }} rounded-full mb-4">
                            {!! $feature['icon'] !!}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Menu Highlights -->
    <section id="menu" class="section bg-gray-50">
        <div class="container-custom">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-display font-bold text-gray-900 mb-4">Le Nostre Pizze</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Scopri le nostre specialità, preparate con passione e ingredienti di altissima qualità
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($featuredPizzas as $pizza)
                    @include('pub_theme::components.pizza-card', ['pizza' => $pizza])
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('meetup.menu') }}" class="btn-secondary inline-block">Vedi Menu Completo</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="ordina" class="section bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="container-custom">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl font-display font-bold mb-6">Pronto a ordinare?</h2>
                <p class="text-xl text-primary-50 mb-8">
                    Ricevi la tua pizza in 30 minuti! Ordina online e goditi la migliore pizza della città.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('meetup.menu') }}" class="btn-secondary inline-block">Inizia l'Ordine</a>
                    <a href="tel:+390123456789" class="bg-white text-primary-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                        Chiama: 012 345 6789
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Homepage specific JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scroll for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
@endsection
```

### 3. **Componenti Blade Riutilizzabili**

#### Pizza Card Component (`components/pizza-card.blade.php`)
```php
@props(['pizza'])

<div class="pizza-card">
    <div class="aspect-pizza bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
        @if($pizza['image'])
            <img src="{{ asset($pizza['image']) }}" alt="{{ $pizza['name'] }}" class="w-full h-full object-cover">
        @else
            <svg class="w-32 h-32 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" opacity="0.3"/>
                <circle cx="8" cy="8" r="1"/>
                <circle cx="16" cy="8" r="1"/>
                <circle cx="12" cy="12" r="1"/>
                <circle cx="8" cy="16" r="1"/>
                <circle cx="16" cy="16" r="1"/>
            </svg>
        @endif
    </div>
    <div class="p-6">
        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $pizza['name'] }}</h3>
        <p class="text-gray-600 mb-4">{{ $pizza['description'] }}</p>
        <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-primary-600">€{{ number_format($pizza['price'], 2) }}</span>
            <button
                class="add-to-cart btn-primary"
                data-pizza-id="{{ $pizza['id'] }}"
                data-pizza-name="{{ $pizza['name'] }}"
                data-pizza-price="{{ $pizza['price'] }}"
            >
                Aggiungi
            </button>
        </div>
    </div>
</div>
```

## 🔧 Configurazione Laravel

### 1. **Service Provider per Tema Meetup**

```php
<?php

namespace Themes\Meetup\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MeetupThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registra le views del tema
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'meetup');
    }

    public function boot()
    {
        // Condivide dati globali con le views
        View::composer('pub_theme::*', function ($view) {
            $view->with([
                'features' => [
                    [
                        'icon' => '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                        'title' => 'Consegna Veloce',
                        'description' => 'Pizza calda e fragrante in 30 minuti o è gratis!',
                        'bgColor' => 'bg-primary-100',
                        'textColor' => 'text-primary-600'
                    ],
                    // ... altre features
                ]
            ]);
        });
    }
}
```

### 2. **Routes per Tema Meetup**

```php
<?php

use Illuminate\Support\Facades\Route;
use Themes\Meetup\Http\Controllers\HomeController;
use Themes\Meetup\Http\Controllers\MenuController;
use Themes\Meetup\Http\Controllers\EventsController;

Route::name('meetup.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::get('/events', [EventsController::class, 'index'])->name('events');
    Route::get('/contact', [ContactController::class, 'index'])->name('contact');
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});
```

### 3. **Controller di Esempio**

```php
<?php

namespace Themes\Meetup\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPizzas = [
            [
                'id' => 1,
                'name' => 'Margherita',
                'description' => 'Pomodoro, mozzarella, basilico fresco e olio d\'oliva',
                'price' => 8.00,
                'image' => 'images/pizzas/margherita.jpg'
            ],
            // ... altre pizze
        ];

        return view('pub_theme::pages.home', compact('featuredPizzas'));
    }
}
```

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
