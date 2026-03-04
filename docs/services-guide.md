# Guida Servizi - Modulo Meetup

## 📋 Panoramica

Questo documento descrive i servizi del modulo Meetup, responsabili della logica di business complessa e delle operazioni che coinvolgono più modelli.

## 🎯 Principi di Design

### 1. Single Responsibility
Ogni servizio ha una responsabilità ben definita.

### 2. Dependency Injection
I servizi ricevono le dipendenze tramite constructor injection.

### 3. Type Safety
Tutti i metodi hanno type hints espliciti e return types.

### 4. Error Handling
Gestione errori consistente con eccezioni specifiche.

## 📦 Servizi Principali

### PizzaService

Gestisce la logica di business per le pizze.

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\Meetup\Models\Category;
use Modules\Meetup\Models\Pizza;

class PizzaService
{
    /**
     * Ottiene tutte le pizze attive.
     *
     * @return Collection<int, Pizza>
     */
    public function getActivePizzas(): Collection
    {
        return Pizza::active()
            ->with(['category', 'ingredients'])
            ->ordered()
            ->get();
    }

    /**
     * Ottiene pizze per categoria.
     *
     * @return Collection<int, Pizza>
     */
    public function getPizzasByCategory(string $categoryId): Collection
    {
        return Pizza::active()
            ->byCategory($categoryId)
            ->with(['category', 'ingredients'])
            ->ordered()
            ->get();
    }

    /**
     * Ottiene pizze in evidenza.
     *
     * @return Collection<int, Pizza>
     */
    public function getFeaturedPizzas(int $limit = 6): Collection
    {
        return Pizza::active()
            ->featured()
            ->with(['category', 'ingredients'])
            ->limit($limit)
            ->get();
    }

    /**
     * Cerca pizze per termine.
     *
     * @return Collection<int, Pizza>
     */
    public function searchPizzas(string $term): Collection
    {
        return Pizza::active()
            ->where('name', 'LIKE', "%{$term}%")
            ->orWhere('description', 'LIKE', "%{$term}%")
            ->with(['category', 'ingredients'])
            ->get();
    }

    /**
     * Ottiene pizza per slug.
     */
    public function getPizzaBySlug(string $slug): ?Pizza
    {
        return Pizza::active()
            ->where('slug', $slug)
            ->with(['category', 'ingredients'])
            ->first();
    }

    /**
     * Verifica disponibilità pizza.
     */
    public function checkAvailability(string $pizzaId, int $quantity = 1): bool
    {
        $pizza = Pizza::find($pizzaId);

        if (!$pizza) {
            return false;
        }

        return $pizza->isAvailable($quantity);
    }
}
```

### OrderService

Gestisce la logica di business per gli ordini.

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Illuminate\Support\Facades\DB;
use Modules\Meetup\Models\Order;
use Modules\Meetup\Models\OrderItem;
use Modules\Meetup\Models\Pizza;
use Modules\User\Models\User;

class OrderService
{
    public function __construct(
        private readonly PizzaService $pizzaService
    ) {}

    /**
     * Crea un nuovo ordine.
     *
     * @param array<int, array{id: string, quantity: int, customizations?: array}> $items
     */
    public function createOrder(
        ?User $user,
        array $items,
        array $deliveryData,
        string $paymentMethod = 'cash'
    ): Order {
        return DB::transaction(function () use ($user, $items, $deliveryData, $paymentMethod) {
            // Calcola totali
            $subtotal = $this->calculateSubtotal($items);
            $tax = $this->calculateTax($subtotal);
            $deliveryFee = $this->calculateDeliveryFee($deliveryData);
            $total = $subtotal + $tax + $deliveryFee;

            // Crea ordine
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user?->id,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'delivery_address' => $deliveryData['address'] ?? null,
                'delivery_phone' => $deliveryData['phone'] ?? null,
                'delivery_notes' => $deliveryData['notes'] ?? null,
                'payment_method' => $paymentMethod,
                'payment_status' => 'pending',
            ]);

            // Crea order items
            foreach ($items as $item) {
                $pizza = Pizza::findOrFail($item['id']);

                // Verifica disponibilità
                if (!$pizza->isAvailable($item['quantity'])) {
                    throw new \Exception("Pizza {$pizza->name} non disponibile");
                }

                // Calcola prezzo
                $unitPrice = $pizza->calculatePrice(
                    $item['customizations']['added'] ?? [],
                    $item['customizations']['removed'] ?? []
                );
                $totalPrice = $unitPrice * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'pizza_id' => $pizza->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'customizations' => $item['customizations'] ?? null,
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            return $order->load('items.pizza');
        });
    }

    /**
     * Aggiorna stato ordine.
     */
    public function updateOrderStatus(string $orderId, string $status, ?string $reason = null): Order
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'status' => $status,
            'cancelled_at' => $status === 'cancelled' ? now() : null,
            'cancellation_reason' => $status === 'cancelled' ? $reason : null,
            'delivered_at' => $status === 'delivered' ? now() : null,
        ]);

        return $order->fresh();
    }

    /**
     * Ottiene ordini utente.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getUserOrders(User $user, int $perPage = 15)
    {
        return Order::forUser($user->id)
            ->with('items.pizza')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Calcola subtotale ordine.
     */
    private function calculateSubtotal(array $items): float
    {
        $subtotal = 0;

        foreach ($items as $item) {
            $pizza = Pizza::findOrFail($item['id']);
            $unitPrice = $pizza->calculatePrice(
                $item['customizations']['added'] ?? [],
                $item['customizations']['removed'] ?? []
            );
            $subtotal += $unitPrice * $item['quantity'];
        }

        return $subtotal;
    }

    /**
     * Calcola tasse.
     */
    private function calculateTax(float $subtotal): float
    {
        $taxRate = config('meetup.tax_rate', 0.10); // 10% default

        return $subtotal * $taxRate;
    }

    /**
     * Calcola costo consegna.
     */
    private function calculateDeliveryFee(array $deliveryData): float
    {
        // Logica per calcolo costo consegna
        // Può dipendere da distanza, zona, etc.
        return config('meetup.delivery_fee', 3.00);
    }
}
```

### CartService

Gestisce il carrello acquisti (session-based).

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Illuminate\Support\Facades\Session;
use Modules\Meetup\Models\Pizza;

class CartService
{
    private const CART_KEY = 'meetup_cart';

    /**
     * Aggiunge item al carrello.
     */
    public function addItem(string $pizzaId, int $quantity = 1, array $customizations = []): void
    {
        $cart = $this->getCart();
        $key = $this->generateItemKey($pizzaId, $customizations);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'pizza_id' => $pizzaId,
                'quantity' => $quantity,
                'customizations' => $customizations,
            ];
        }

        $this->saveCart($cart);
    }

    /**
     * Rimuove item dal carrello.
     */
    public function removeItem(string $key): void
    {
        $cart = $this->getCart();
        unset($cart[$key]);
        $this->saveCart($cart);
    }

    /**
     * Aggiorna quantità item.
     */
    public function updateQuantity(string $key, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeItem($key);
            return;
        }

        $cart = $this->getCart();
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            $this->saveCart($cart);
        }
    }

    /**
     * Svuota carrello.
     */
    public function clear(): void
    {
        Session::forget(self::CART_KEY);
    }

    /**
     * Ottiene contenuto carrello con dettagli pizze.
     *
     * @return array<int, array{key: string, pizza: Pizza, quantity: int, customizations: array, total: float}>
     */
    public function getCartWithDetails(): array
    {
        $cart = $this->getCart();
        $items = [];

        foreach ($cart as $key => $item) {
            $pizza = Pizza::find($item['pizza_id']);
            if (!$pizza) {
                continue;
            }

            $unitPrice = $pizza->calculatePrice(
                $item['customizations']['added'] ?? [],
                $item['customizations']['removed'] ?? []
            );
            $total = $unitPrice * $item['quantity'];

            $items[] = [
                'key' => $key,
                'pizza' => $pizza,
                'quantity' => $item['quantity'],
                'customizations' => $item['customizations'],
                'unit_price' => $unitPrice,
                'total' => $total,
            ];
        }

        return $items;
    }

    /**
     * Calcola totale carrello.
     */
    public function getTotal(): float
    {
        $items = $this->getCartWithDetails();
        $total = 0;

        foreach ($items as $item) {
            $total += $item['total'];
        }

        return $total;
    }

    /**
     * Ottiene carrello dalla sessione.
     *
     * @return array<string, array{pizza_id: string, quantity: int, customizations: array}>
     */
    private function getCart(): array
    {
        return Session::get(self::CART_KEY, []);
    }

    /**
     * Salva carrello in sessione.
     */
    private function saveCart(array $cart): void
    {
        Session::put(self::CART_KEY, $cart);
    }

    /**
     * Genera chiave univoca per item.
     */
    private function generateItemKey(string $pizzaId, array $customizations): string
    {
        $customizationsHash = md5(json_encode($customizations));

        return "{$pizzaId}_{$customizationsHash}";
    }
}
```

## 🔧 Utilizzo nei Controller

```php
use Modules\Meetup\Services\PizzaService;
use Modules\Meetup\Services\OrderService;
use Modules\Meetup\Services\CartService;

class MenuController extends Controller
{
    public function __construct(
        private readonly PizzaService $pizzaService,
        private readonly CartService $cartService
    ) {}

    public function index()
    {
        $pizzas = $this->pizzaService->getActivePizzas();
        $cartTotal = $this->cartService->getTotal();

        return view('meetup::menu', compact('pizzas', 'cartTotal'));
    }
}
```

## 🔗 Collegamenti

- [Business Logic](./business-logic.md)
- [API Endpoints](./api_endpoints.md)
- [Architettura Modelli](./models-architecture.md)
