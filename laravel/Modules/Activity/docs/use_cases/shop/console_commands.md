# Guida Completa ai Console Commands per il Modulo Shop

## Indice
1. [Introduzione](#1-introduzione)
2. [Best Practice](#2-best-practice)
3. [Comandi di Base](#3-comandi-di-base)
4. [Gestione Carrelli](#4-gestione-carrelli)
5. [Gestione Ordini](#5-gestione-ordini)
6. [Report e Manutenzione](#6-report-e-manutenzione)
7. [Suggerimenti Avanzati](#7-suggerimenti-avanzati)

## 1. Introduzione

I console commands nel modulo Shop forniscono un'interfaccia a riga di comando completa per gestire tutte le operazioni di e-commerce. Sono essenziali per:

- Automazione dei processi di acquisto
- Gestione degli ordini in batch
- Manutenzione del catalogo prodotti
- Generazione di report
- Operazioni di debug e risoluzione problemi

## 2. Best Practice

### 2.1 Convenzioni di Naming

```markdown

# Buono
shop:cart:create
shop:order:process
shop:product:import
shop:report:daily-sales

# Da evitare
createCart
processOrder
importProducts
```

### 2.2 Struttura dei Comandi

Ogni comando dovrebbe seguire questa struttura base:

```php
namespace Modules\Activity\App\Console\Commands\Shop;

use Illuminate\Console\Command;
use Modules\Activity\Domain\Shop\Cart\CartAggregate;

class CreateCartCommand extends Command
{
    protected $signature = 'shop:cart:create
                            {user_id : ID dell\'utente}
                            {--products=* : Lista prodotti ID:QUANTITÀ}
                            {--coupon= : Codice coupon da applicare}';

    protected $description = 'Crea un nuovo carrello per un utente';

    public function handle()
    {
        // Implementazione
    }
}
```

### 2.3 Gestione degli Errori

```php
try {
    // Operazione sul carrello
} catch (ProductNotFoundException $e) {
    $this->error("Prodotto non trovato: " . $e->getProductId());
    return Command::FAILURE;
} catch (InsufficientStockException $e) {
    $this->warn("Scorte insufficienti per il prodotto: " . $e->getProductId());
    return Command::FAILURE;
}
```

## 3. Comandi di Base

### 3.1 Creazione Carrello

**Sintassi:**
```bash
php artisan shop:cart:create {user_id} {--products=*}
```

**Esempio:**
```bash
php artisan shop:cart:create 123 --products=ABC123:2 --products=XYZ789:1
```

**Implementazione:**
```php
public function handle(CartService $cartService)
{
    $userId = $this->argument('user_id');
    $products = $this->parseProducts($this->option('products'));
    
    $cart = $cartService->createCart($userId);
    
    foreach ($products as $productId => $quantity) {
        $cart->addItem($productId, $quantity);
    }
    
    $this->info("Carrello creato con ID: " . $cart->getId());
    $this->table(
        ['Prodotto', 'Quantità', 'Prezzo'],
        $cart->getItems()->map(fn($item) => [
            $item->getProductName(),
            $item->getQuantity(),
            $item->getPrice()->format()
        ])
    );
}
```

## 4. Gestione Carrelli

### 4.1 Aggiunta Prodotto

```bash
php artisan shop:cart:add-item {cart_id} {product_id} {quantity=1}
```

### 4.2 Rimozione Prodotto

```bash
php artisan shop:cart:remove-item {cart_id} {product_id} {quantity=1}
```

### 4.3 Svuotamento Carrello

```bash
php artisan shop:cart:clear {cart_id}
```

## 5. Gestione Ordini

### 5.1 Checkout

```bash
php artisan shop:order:checkout {cart_id} {--payment-method=credit_card}
```

### 5.2 Aggiornamento Stato Ordine

```bash
php artisan shop:order:update-status {order_id} {status}
```

## 6. Report e Manutenzione

### 6.1 Report Vendite Giornaliere

```bash
php artisan shop:report:daily-sales {date=today}
```

### 6.2 Pulizia Carrelli Abbandonati

```bash
php artisan shop:maintenance:cleanup-abandoned-carts {--days=30}
```

## 7. Suggerimenti Avanzati

### 7.1 Output Tabellare

```php
$this->table(
    ['ID', 'Cliente', 'Totale', 'Stato'],
    $orders->map(fn($order) => [
        $order->id,
        $order->customer->name,
        $order->total->format(),
        $order->status
    ])
);
```

### 7.2 Barra di Avanzamento

```php
$bar = $this->output->createProgressBar(count($products));

foreach ($products as $product) {
    // Elabora prodotto
    $bar->advance();
}

$bar->finish();
```

### 7.3 Input Interattivo

```php
$productId = $this->choice(
    'Seleziona un prodotto:',
    $availableProducts->pluck('name', 'id')->toArray()
);

$quantity = $this->ask('Quantità:', 1);
```

**Dettagli**:
- **Namespace**: Usiamo `Modules\Activity\App\Console\Commands` per mantenere l'organizzazione modulare.
- **Signature**: Definisce il comando come `activity:shop:create-cart` con un parametro obbligatorio: `userId`.
- **Description**: Una breve descrizione del comando, visibile con `php artisan list`.
- **Handle**: Contiene la logica per creare un carrello della spesa utilizzando un aggregate root `CartAggregate` (ipotetico, basato su Event Sourcing).

### 3. Registrazione del Comando

I comandi da console in Laravel vengono automaticamente registrati se si trovano nella directory `app/Console/Commands`. Tuttavia, poiché abbiamo spostato il comando nel modulo `Activity`, dobbiamo registrarlo manualmente nel `Kernel.php` o nel service provider del modulo.

Aggiungiamo il comando in `Modules/Activity/app/Providers/ActivityServiceProvider.php`:

```php
namespace Modules\Activity\App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Activity\App\Console\Commands\CartCreateCommand;

class ActivityServiceProvider extends ServiceProvider
{
    protected $commands = [
        CartCreateCommand::class,
    ];

    public function boot()
    {
        $this->commands($this->commands);
    }
}
```

**Motivazione**: Questo approccio mantiene i comandi specifici del modulo isolati e gestiti dal modulo stesso.

### 4. Utilizzo del Comando

Ora possiamo eseguire il comando da console:

```bash
php artisan activity:shop:create-cart 12345
```

**Output Atteso**:
```
Carrello della spesa creato con UUID: cart_12345_xxxxxxxxxx per l'utente 12345
```

## Altri Comandi Utili per il Caso d'Uso Shop

### Comando per Aggiungere un Articolo al Carrello

Creiamo un comando per aggiungere articoli a un carrello esistente:

```bash
php artisan make:command CartAddItemCommand
```

Modifichiamo il file `CartAddItemCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\Shop\CartAggregate;

class CartAddItemCommand extends Command
{
    protected $signature = 'activity:shop:add-item {cartUuid} {itemId} {quantity=1} {price}';
    
    protected $description = 'Aggiunge un articolo al carrello della spesa nel modulo Activity';

    public function handle()
    {
        $cartUuid = $this->argument('cartUuid');
        $itemId = $this->argument('itemId');
        $quantity = (int) $this->argument('quantity');
        $price = (float) $this->argument('price');

        $cart = CartAggregate::retrieve($cartUuid);
        
        $cart->addItem($itemId, $quantity, $price);
        $cart->persist();

        $this->info("Articolo {$itemId} aggiunto al carrello {$cartUuid}: Quantità {$quantity}, Prezzo {$price}");
    }
}
```

**Utilizzo**:

```bash
php artisan activity:shop:add-item cart_12345_xxxxxxxxxx item_001 2 19.99
```

**Motivazione**: Questo comando permette di aggiungere articoli al carrello in modo controllato, utile per test o correzioni manuali.

### Comando per Completare un Ordine

Creiamo un comando per completare un ordine dal carrello:

```bash
php artisan make:command CartCheckoutCommand
```

Modifichiamo il file `CartCheckoutCommand.php`:

```php
namespace Modules\Activity\App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Activity\App\Domain\Shop\CartAggregate;

class CartCheckoutCommand extends Command
{
    protected $signature = 'activity:shop:checkout {cartUuid}';
    
    protected $description = 'Completa un ordine dal carrello della spesa nel modulo Activity';

    public function handle()
    {
        $cartUuid = $this->argument('cartUuid');

        $cart = CartAggregate::retrieve($cartUuid);
        
        $orderUuid = uniqid('order_');
        $cart->checkout($orderUuid);
        $cart->persist();

        $this->info("Ordine completato con UUID: {$orderUuid} dal carrello {$cartUuid}");
    }
}
```

**Utilizzo**:

```bash
php artisan activity:shop:checkout cart_12345_xxxxxxxxxx
```

**Motivazione**: Questo comando è utile per finalizzare un ordine, simulando il processo di checkout per test o gestione manuale.

## Best Practices per i Comandi da Console

- **Namespace Coerente**: Usa un namespace che rifletta la posizione del modulo (`Modules\Activity\App\Console\Commands`) per mantenere l'organizzazione.
- **Nomi Descrittivi**: Usa nomi di comandi chiari e specifici (es. `activity:shop:create-cart`) per evitare ambiguità.
- **Parametri e Opzioni**: Definisci parametri obbligatori e opzioni facoltative per rendere i comandi flessibili (es. `quantity=1` come default).
- **Feedback Utente**: Usa `$this->info()`, `$this->error()`, ecc., per fornire feedback chiaro durante l'esecuzione.
- **Gestione Errori**: Implementa controlli per prevenire errori e fornire messaggi utili.
- **Registrazione**: Registra i comandi nel service provider del modulo per mantenere l'isolamento.

## Conclusione

I comandi da console sono strumenti essenziali per gestire operazioni nel caso d'uso `Shop` del modulo `Activity`. Seguendo i passaggi descritti, puoi creare comandi personalizzati per creare carrelli, aggiungere articoli e completare ordini, migliorando la gestione e il debug del sistema. Questi comandi possono essere ulteriormente estesi per coprire altre funzionalità specifiche come gestione degli sconti, report di vendita o simulazioni di acquisti.
