# Implementazione di un Carrello della Spesa

## Introduzione

Questa guida fornisce i passaggi per implementare un carrello della spesa basato su Event Sourcing, ispirandosi ai progetti di Spatie. L'obiettivo è creare un sistema tracciabile e scalabile per gestire ordini nel modulo `Activity`.

## Passaggi per l'Implementazione

### 1. Configurazione dell'Ambiente

- Installa il pacchetto `spatie/laravel-event-sourcing` nel tuo progetto Laravel.
- Configura il database per salvare gli eventi.

```bash
composer require spatie/laravel-event-sourcing
php artisan vendor:publish --provider="Spatie\EventSourcing\EventSourcingServiceProvider" --tag="migrations"
php artisan migrate
```

### 2. Definizione degli Eventi

Crea classi per ogni evento rilevante, come `CartItemAdded`, `CartItemRemoved`, `CartCheckedOut`. Questi eventi devono implementare `ShouldBeStored`.

```php
namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartItemAdded extends ShouldBeStored
{
    public function __construct(public string $cartUuid, public string $itemId, public int $quantity, public float $price)
    {
    }
}
```

### 3. Creazione dell'Aggregate Root

Definisci un aggregate per il carrello che gestisca i comandi e generi eventi.

```php
namespace App\Domain\Cart;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use App\Domain\Cart\Events\CartItemAdded;

class CartAggregate extends AggregateRoot
{
    public function addItem(string $itemId, int $quantity, float $price): self
    {
        $this->recordThat(new CartItemAdded($this->uuid(), $itemId, $quantity, $price));
        return $this;
    }
}
```

### 4. Gestione dei Comandi

Crea azioni o controller per gestire i comandi degli utenti, come aggiungere articoli al carrello.

```php
namespace App\Http\Controllers;

use App\Domain\Cart\CartAggregate;

class CartController
{
    public function addItem(Request $request)
    {
        $cart = CartAggregate::retrieve($request->user()->activeCartUuid);
        $cart->addItem($request->itemId, $request->quantity, $request->price);
        $cart->persist();
        return redirect()->back();
    }
}
```

### 5. Proiettori per le Query

Implementa proiettori per creare viste ottimizzate per le query, come il contenuto corrente del carrello.

```php
namespace App\Domain\Cart\Projectors;

use Spatie\EventSourcing\Projectors\Projector;
use App\Domain\Cart\Events\CartItemAdded;

class CartProjector implements Projector
{
    public function onCartItemAdded(CartItemAdded $event, string $aggregateUuid)
    {
        // Aggiorna il database o una vista per mostrare il carrello corrente
    }
}
```

### 6. Integrazione nel Modulo Activity

Adatta il carrello per tracciare ordini o acquisti specifici nel contesto sanitario, come forniture mediche.
- Modifica gli eventi per includere metadati rilevanti (es. categoria di fornitura).
- Usa i proiettori per creare report su ordini frequenti o budget spesi.

## Considerazioni

- **Performance**: Rigiocare molti eventi può rallentare il sistema; considera snapshot per aggregate complessi.
- **Scalabilità**: Usa code per gestire eventi asincroni come notifiche o aggiornamenti di inventario.
- **Tracciabilità**: Assicurati che ogni evento sia significativo per mantenere un audit trail chiaro.
