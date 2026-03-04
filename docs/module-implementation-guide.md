# Guida Implementazione Modulo Meetup

## 📋 Panoramica

Questa guida descrive come implementare completamente il modulo Meetup per gestire il sistema di ordinazione pizze, integrandolo con l'architettura **Laraxot** (Folio + Volt + Filament).

## 🎯 Obiettivi Implementazione

1. **Implementare modelli Eloquent** seguendo pattern Laraxot
2. **Creare Filament Resources** per admin panel
3. **Implementare Frontend** usando **Folio** (Routing) e **Volt** (Logic)
4. **Gestire business logic** con Actions pattern
5. **NO Controllers, NO Routes files**

## 📁 Struttura Modulo Target

```
Modules/Meetup/
├── app/
│   ├── Actions/                    # Business logic
│   │   ├── CreateOrderAction.php
│   │   ├── AddToCartAction.php
│   │   └── ProcessPaymentAction.php
│   ├── Datas/                      # Data objects
│   │   ├── OrderData.php
│   │   └── PizzaData.php
│   ├── Events/                     # Domain events
│   │   ├── OrderCreated.php
│   │   └── OrderStatusChanged.php
│   ├── Filament/                   # Admin panel
│   │   ├── Resources/
│   │   │   ├── PizzaResource.php
│   │   │   ├── CategoryResource.php
│   │   │   └── OrderResource.php
│   │   └── Widgets/
│   │       ├── OrderStatsWidget.php
│   │       └── RevenueWidget.php
│   ├── Models/                     # Eloquent models
│   │   ├── Category.php
│   │   ├── Pizza.php
│   │   ├── Ingredient.php
│   │   ├── Order.php
│   │   └── OrderItem.php
│   ├── Providers/
│   │   ├── MeetupServiceProvider.php
│   │   └── FilamentServiceProvider.php
│   └── Services/
│       └── CartService.php
├── config/
│   └── meetup.php
├── database/
│   ├── migrations/
│   │   ├── create_meetup_tables.php
│   │   └── add_meetup_relationships.php
│   └── seeders/
│       └── MeetupSeeder.php
├── resources/
│   ├── views/
│   │   ├── pages/                  # Folio Pages (Routing)
│   │   │   ├── index.blade.php
│   │   │   ├── events/
│   │   │   │   ├── index.blade.php
│   │   │   │   └── [slug].blade.php
│   │   │   └── cart.blade.php
│   │   └── components/             # Volt Components
│   │       ├── header.blade.php
│   │       ├── footer.blade.php
│   │       └── pizza-card.blade.php
└── tests/
    ├── Unit/
    └── Feature/
```

## 🏗️ Implementazione Modelli

*(Vedi sezione Modelli originale - invariata)*

## 🎨 Filament Resources

*(Vedi sezione Filament Resources originale - invariata)*

## 🔧 Business Logic con Actions

*(Vedi sezione Actions originale - invariata)*

## ⚡ Frontend con Folio & Volt

### 1. **Page: Pizza Menu (`resources/views/pages/menu/index.blade.php`)**

```php
<?php

use function Laravel\Folio\{name};
use Modules\Meetup\Models\Pizza;
use Modules\Meetup\Models\Category;

name('menu.index');

$categories = Category::with(['pizzas' => fn($q) => $q->active()])->orderBy('order')->get();

?>

<x-layouts.app>
    <div class="container mx-auto py-12">
        @foreach($categories as $category)
            <section class="mb-12">
                <h2 class="text-3xl font-bold mb-6">{{ $category->name }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($category->pizzas as $pizza)
                        <livewire:pizza-card :pizza="$pizza" wire:key="{{ $pizza->id }}" />
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
</x-layouts.app>
```

### 2. **Volt Component: Pizza Card (`resources/views/livewire/pizza-card.blade.php`)**

```php
<?php

use Modules\Meetup\Models\Pizza;
use Modules\Meetup\Actions\AddToCartAction;
use Modules\Meetup\Datas\CartItemData;
use function Livewire\Volt\{state, action};

state(['pizza']);

$addToCart = function (AddToCartAction $action) {
    $action->execute(CartItemData::from($this->pizza));
    $this->dispatch('cart-updated');
    $this->dispatch('notify', 'Pizza aggiunta al carrello!');
};

?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <img src="{{ $pizza->image_url }}" alt="{{ $pizza->name }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="text-xl font-bold">{{ $pizza->name }}</h3>
        <p class="text-gray-600 mt-2">{{ $pizza->description }}</p>
        <div class="mt-4 flex justify-between items-center">
            <span class="text-lg font-bold">€ {{ $pizza->price }}</span>
            <button wire:click="addToCart" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                Aggiungi
            </button>
        </div>
    </div>
</div>
```

## 📋 Checklist Implementazione

- [ ] Creare modelli Eloquent
- [ ] Implementare migrations database
- [ ] Creare Filament resources
- [ ] Implementare business logic con Actions
- [ ] **Configurare Folio Pages** (NO Controllers)
- [ ] **Creare Volt Components** (NO Class Components)
- [ ] Creare Service Provider
- [ ] Implementare tests

## 🔗 Collegamenti

- [Laraxot Architecture Documentation](../Xot/docs/)
- [Filament Documentation](https://filamentphp.com/docs)
- [Laravel Folio](https://laravel.com/docs/folio)
- [Laravel Volt](https://livewire.laravel.com/docs/volt)

---
**
**Status**: 🟡 In Progress
**Priorità**: ALTA
