# Creazione di un Carrello della Spesa da Zero con Event Sourcing

## Introduzione

Questo documento fornisce una guida dettagliata per creare da zero un carrello della spesa basato su Event Sourcing in Laravel, ispirandosi ai principi e alle scelte dei progetti di Spatie `laravel-shop-main` e `laravel-shop-command-bus`. Spiegheremo ogni scelta tecnologica, filosofica e architetturale, con esempi pratici, come se questi progetti non esistessero. L'obiettivo è costruire un sistema tracciabile, scalabile e adatto al modulo `Activity`.

## Filosofia e Motivazioni

### Perché Event Sourcing?

L'Event Sourcing è una filosofia di design che considera gli eventi come la fonte primaria di verità, piuttosto che lo stato corrente. Le motivazioni per adottarlo sono:
- **Tracciabilità**: Ogni modifica (aggiunta di un articolo, checkout) è un evento salvato, permettendo un audit trail completo. Questo è cruciale per applicazioni finanziarie o sanitarie dove la storia è importante.
- **Flessibilità**: Gli eventi consentono di ricostruire lo stato in modi diversi per diverse viste o report.
- **Immutabilità**: Gli eventi non possono essere modificati, garantendo integrità dei dati.

Questa scelta riflette uno 'zen' del software: accettare il flusso di cambiamenti come la realtà ultima, piuttosto che uno stato statico. È una 'religione' di trasparenza e responsabilità.

### Separazione delle Responsabilità (CQRS)

Adottiamo il pattern Command Query Responsibility Segregation (CQRS) per separare la logica di scrittura (comandi che generano eventi) dalla logica di lettura (query che leggono lo stato). Questo migliora scalabilità e manutenzione, incarnando una politica di chiarezza architetturale.

## Scelte Tecnologiche

### Laravel come Framework

Scelgo Laravel per la sua semplicità, la vasta comunità e l'ecosistema di pacchetti. Useremo Laravel 8.x o superiore per sfruttare funzionalità moderne come il routing API e le migrazioni migliorate.
- **Motivazione**: Familiarità per molti sviluppatori, supporto per autenticazione e database out-of-the-box.
- **Alternativa**: Symfony potrebbe essere un'opzione, ma Laravel offre una curva di apprendimento più dolce.

### PHP 8.0+

Utilizziamo PHP 8.0 o superiore per sfruttare constructor property promotion, union types e performance migliorate.
- **Motivazione**: Modernità e type safety per ridurre errori.

### Pacchetti di Supporto

- **Spatie Laravel Event Sourcing**: Anche se stiamo creando da zero, useremo questo pacchetto per gestire eventi e aggregate, poiché reinventare questa logica sarebbe inefficiente.
- **Spatie Laravel Model States**: Per gestire stati in modo tipizzato (es. carrello 'attivo' o 'completato').

Questa scelta riflette una politica di riutilizzo di strumenti collaudati, evitando di 'reinventare la ruota'.

## Architettura del Sistema

### Struttura del Progetto

Creeremo due varianti ispirate ai progetti di Spatie:
1. **Shop Example App**: Un'applicazione completa per apprendimento e prototipazione.
2. **Shop Package**: Un pacchetto modulare installabile tramite Composer per integrazione in progetti esistenti.

### Struttura delle Directory (Shop Example App)

- `app/Domain/Cart`: Contiene aggregate, eventi e azioni per il carrello.
- `app/Domain/Order`: Gestisce gli ordini derivati dal carrello.
- `app/Domain/Payment`: Traccia i pagamenti.
- `app/Http/Controllers`: Punti di ingresso per comandi utente.
- `database/migrations`: Tabelle per salvare eventi e viste.

### Struttura delle Directory (Shop Package)

- `src/Cart`: Modulo per il carrello con eventi, aggregate e proiettori.
- `src/Order`, `src/Payment`, ecc.: Moduli separati per entità correlate.
- `src/ShopServiceProvider.php`: Configura il pacchetto per Laravel.
- `config/shop.php`: File di configurazione pubblicabile.

Questa struttura riflette una filosofia di modularità e una politica di separazione delle responsabilità.

## Passaggi per Creare Shop Example App da Zero

### 1. Configurazione Iniziale

Creiamo un nuovo progetto Laravel:

```bash
composer create-project laravel/laravel shop-example-app
cd shop-example-app
```

Aggiungiamo il pacchetto Event Sourcing:

```bash
composer require spatie/laravel-event-sourcing
php artisan vendor:publish --provider="Spatie\EventSourcing\EventSourcingServiceProvider" --tag="migrations"
php artisan migrate
```

**Scelta**: Usiamo Laravel per la semplicità e il pacchetto Spatie per accelerare lo sviluppo. Senza il pacchetto, dovremmo scrivere un sistema di gestione eventi manuale, che richiederebbe settimane.

### 2. Definizione degli Eventi per il Carrello

Creiamo eventi per tracciare modifiche al carrello in `app/Domain/Cart/Events`:

```php
// app/Domain/Cart/Events/CartItemAdded.php
namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartItemAdded extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
        public string $itemId,
        public int $quantity,
        public float $price
    ) {}
}
```

Creiamo altri eventi come `CartItemRemoved` e `CartCheckedOut`.

**Scelta**: Ogni evento è specifico e immutabile, riflettendo una filosofia di granularità. Usiamo proprietà pubbliche per semplicità (feature di PHP 8.0), una scelta di modernità.

### 3. Creazione dell'Aggregate Root per il Carrello

Definiamo un aggregate in `app/Domain/Cart/CartAggregate.php`:

```php
namespace App\Domain\Cart;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;
use App\Domain\Cart\Events\CartItemAdded;

class CartAggregate extends AggregateRoot
{
    protected array $items = [];

    public function addItem(string $itemId, int $quantity, float $price): self
    {
        $this->recordThat(new CartItemAdded(
            cartUuid: $this->uuid(),
            itemId: $itemId,
            quantity: $quantity,
            price: $price
        ));
        return $this;
    }

    protected function applyCartItemAdded(CartItemAdded $event): void
    {
        $this->items[$event->itemId] = [
            'quantity' => $event->quantity,
            'price' => $event->price,
        ];
    }
}
```

**Scelta**: L'aggregate incapsula la logica di business, decidendo quali eventi generare. Questo riflette una 'religione' di centralizzazione della logica. Usiamo `apply` per ricostruire lo stato dagli eventi, una politica di coerenza.

### 4. Controller per i Comandi

Creiamo un controller per gestire i comandi in `app/Http/Controllers/CartController.php`:

```php
namespace App\Http\Controllers;

use App\Domain\Cart\CartAggregate;
use Illuminate\Http\Request;

class CartController
{
    public function addItem(Request $request)
    {
        $user = $request->user();
        $cartUuid = $user->activeCartUuid ?? $this->generateCartUuid($user);
        $cart = CartAggregate::retrieve($cartUuid);
        $cart->addItem(
            $request->input('item_id'),
            $request->input('quantity', 1),
            $request->input('price')
        );
        $cart->persist();
        return redirect()->back()->with('message', 'Item added to cart');
    }

    protected function generateCartUuid($user): string
    {
        $uuid = uniqid('cart_' . $user->id . '_');
        $user->activeCartUuid = $uuid;
        $user->save();
        return $uuid;
    }
}
```

**Scelta**: Usiamo controller come punto di ingresso per i comandi, una politica di semplicità. Generiamo un UUID per il carrello per ogni utente, riflettendo una filosofia di personalizzazione.

### 5. Proiettori per le Query

Creiamo un proiettore per aggiornare una vista del carrello in `app/Domain/Cart/Projectors/CartItemProjector.php`:

```php
namespace App\Domain\Cart\Projectors;

use Spatie\EventSourcing\Projectionist\Projector;
use App\Domain\Cart\Events\CartItemAdded;
use App\Models\CartItem;

class CartItemProjector implements Projector
{
    public function onCartItemAdded(CartItemAdded $event, string $aggregateUuid)
    {
        CartItem::updateOrCreate(
            ['cart_uuid' => $event->cartUuid, 'item_id' => $event->itemId],
            ['quantity' => $event->quantity, 'price' => $event->price]
        );
    }
}
```

**Scelta**: I proiettori aggiornano tabelle ottimizzate per le query, una politica di performance. Usiamo `updateOrCreate` per idempotenza, riflettendo uno 'zen' di resilienza agli errori.

### 6. Configurazione del Projectionist

Configuriamo i proiettori in `app/Providers/EventSourcingServiceProvider.php`:

```php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Projectionist;
use App\Domain\Cart\Projectors\CartItemProjector;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $projectionist = app(Projectionist::class);
        $projectionist->addProjectors([
            CartItemProjector::class,
            // Altri proiettori
        ]);
    }
}
```

**Scelta**: Centralizziamo la configurazione dei proiettori, una politica di ordine.

## Passaggi per Creare Shop Package da Zero

### 1. Inizializzazione del Pacchetto

Creiamo un pacchetto Composer:

```bash
mkdir laravel-shop-package
cd laravel-shop-package
composer init --name="myvendor/laravel-shop" --type="library" --autoload="psr-4:MyVendor\\Shop\\:src/"
```

**Scelta**: Un pacchetto consente riutilizzabilità, riflettendo una filosofia di modularità.

### 2. Struttura del Pacchetto

Creiamo una struttura simile a `laravel-shop-command-bus`:

```bash
mkdir -p src/Cart/Events src/Cart/Projectors src/Order config
```

Trasferiamo la logica degli eventi, aggregate e proiettori da `Shop Example App` a `src/Cart`, ecc.

### 3. Service Provider

Creiamo `src/ShopServiceProvider.php`:

```php
namespace MyVendor\Shop;

use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Projectionist;
use MyVendor\Shop\Cart\Projectors\CartItemProjector;

class ShopServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/shop.php' => config_path('shop.php')], 'config');
        $projectionist = app(Projectionist::class);
        $projectionist->addProjectors([CartItemProjector::class]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/shop.php', 'shop');
    }
}
```

**Scelta**: Il provider configura il pacchetto per Laravel, una politica di integrazione.

### 4. Pubblicazione su Composer

Aggiungiamo il pacchetto a un repository e lo pubblichiamo:

```json
// composer.json
"repositories": [{"type": "path", "url": "path/to/laravel-shop-package"}]
```

**Scelta**: Pubblicare il pacchetto consente riutilizzo, una filosofia di condivisione.

## Considerazioni Finali per il Modulo Activity

- **Filosofia**: Adottare Event Sourcing per tracciabilità e trasparenza, una 'religione' di responsabilità.
- **Tecnologia**: Usare Laravel e pacchetti Spatie per velocità di sviluppo.
- **Politica**: Creare prima un'applicazione esempio per apprendimento, poi un pacchetto per integrazione.
- **Zen**: Accettare la complessità dell'Event Sourcing come un percorso verso un sistema più robusto.

Questa guida passo-passo ti permette di costruire un carrello della spesa da zero, con scelte motivate e esempi pratici, pronto per essere adattato al modulo `Activity` per gestire ordini o acquisti.
