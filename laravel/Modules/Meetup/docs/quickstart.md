# 🚀 QuickStart Guide - LaravelPizza

## 5 Minuti per il Primo Ordine

Questa guida ti permetterà di avere LaravelPizza funzionante in 5 minuti e creare il tuo primo ordine pizza!

---

## ⚡ Setup Ultra-Rapido

### Prerequisiti Veloci
```bash
# Verifica versioni
php -v          # >= 8.2
composer -V     # >= 2.5
node -v         # >= 18
npm -v          # >= 9
```

### 3 Step Setup

#### 1️⃣ Clone & Install (2 min)
```bash
# Clone repository
cd /var/www/_bases
git clone [URL_REPO] base_laravelpizza
cd base_laravelpizza/laravel

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
```

#### 2️⃣ Database & Seed (2 min)
```bash
# Create SQLite database
touch database/database.sqlite

# Run migrations
php artisan migrate

# Seed with demo data (50 pizze, 20 categorie, dati esempio)
php artisan db:seed

# Create admin user
php artisan make:filament-user
# Email: admin@laravelpizza.test
# Password: password
```

#### 3️⃣ Build & Serve (1 min)
```bash
# Build assets
npm run build

# Start server
php artisan serve

# In another terminal - queue worker per ordini
php artisan queue:work
```

**Done! 🎉**
- Frontend: http://localhost:8000
- Admin Panel: http://localhost:8000/admin

---

## 🍕 Il Tuo Primo Ordine (2 minuti)

### Frontend Flow

1. **Vai al Menu**
   ```
   http://localhost:8000/menu.html
   ```

2. **Scegli una Pizza**
   - Filtra per "Classiche"
   - Click su "Margherita"
   - Click "Aggiungi al Carrello"

3. **Vai al Carrello**
   - Click sull'icona carrello (header)
   - Verifica items
   - Click "Procedi al Checkout"

4. **Completa Ordine**
   - Compila form (Nome, Email, Telefono)
   - Scegli "Delivery"
   - Inserisci indirizzo
   - Scegli "Contanti alla consegna"
   - Click "Conferma Ordine"

5. **Tracking**
   - Riceverai email conferma (check Mailpit: http://localhost:8025)
   - Tracking page per seguire lo stato

### Admin Panel Flow

1. **Login Admin**
   ```
   http://localhost:8000/admin
   Email: admin@laravelpizza.test
   Password: password
   ```

2. **Dashboard Overview**
   - Vedi widgets statistiche
   - Ordini oggi, fatturato, pizza più venduta

3. **Gestisci Ordine**
   - Sidebar → "Orders"
   - Click sull'ordine appena creato
   - Cambia status: "In attesa" → "In preparazione"
   - Salva

4. **Crea Nuova Pizza**
   - Sidebar → "Pizzas" → "Create"
   - Titolo: "La Mia Pizza Speciale"
   - Categoria: "Speciali"
   - Prezzo: 12.00
   - Ingredienti: Seleziona da lista
   - Upload immagine (opzionale)
   - Salva

---

## 📁 File e Cartelle Chiave

### Dove Trovare Cosa (Top 10)

```
laravel/
├── app/
│   └── Application.php          # Custom app class (public_html redirect)
│
├── bootstrap/
│   └── providers.php             # Service providers registered
│
├── Modules/
│   ├── Meetup/                   # 🍕 MODULO PRINCIPALE
│   │   ├── app/
│   │   │   ├── Models/           # Pizza, Order, Category, etc.
│   │   │   ├── Actions/          # CreateOrder, AddToCart actions
│   │   │   ├── Filament/         # Admin resources
│   │   │   └── Services/         # Business logic services
│   │   ├── database/
│   │   │   ├── migrations/       # Database tables
│   │   │   └── seeders/          # Demo data
│   │   ├── docs/                 # 📚 DOCUMENTAZIONE
│   │   └── routes/
│   │       └── web.php           # Frontend routes
│   │
│   ├── Xot/                      # Core framework module
│   ├── User/                     # Authentication & users
│   ├── Cms/                      # Folio + Livewire Volt
│   └── UI/                       # UI components
│
├── Themes/
│   └── Meetup/                   # 🎨 TEMA FRONTEND
│       ├── resources/
│       │   ├── html/             # HTML statico con Tailwind
│       │   │   ├── index.html
│       │   │   ├── menu.html
│       │   │   ├── events.html
│       │   │   ├── dist/         # Assets compilati
│       │   │   └── README.md
│       │   └── views/            # Blade templates
│       ├── vite.config.js        # Vite build config
│       └── docs/                 # Theme docs
│
├── config/
│   ├── modules.php               # Modules configuration
│   └── xot.php                   # XotData config (theme, etc.)
│
├── database/
│   └── database.sqlite           # SQLite DB (default)
│
└── routes/
    └── web.php                   # Main routes
```

---

## 🔑 Comandi Essenziali

### Development Daily

```bash
# Start everything (run each in separate terminal)
php artisan serve                 # Web server :8000
php artisan queue:work            # Process jobs (orders, emails)
npm run dev                       # Hot reload assets (optional)

# View logs in real-time
tail -f storage/logs/laravel.log

# Clear caches when things act weird
php artisan optimize:clear
```

### Database

```bash
# Fresh start (WARNING: deletes all data!)
php artisan migrate:fresh --seed

# Rollback last migration
php artisan migrate:rollback

# Check migration status
php artisan migrate:status

# Seed specific seeder
php artisan db:seed --class=Modules\\Meetup\\Database\\Seeders\\PizzaSeeder
```

### Modules

```bash
# List all modules
php artisan module:list

# Enable/Disable module
php artisan module:enable Meetup
php artisan module:disable Meetup

# Module commands
php artisan module:make-model Pizza Meetup
php artisan module:make-migration create_pizzas_table Meetup
```

### Code Quality (CRITICAL!)

```bash
# ALWAYS run before committing!
vendor/bin/phpstan analyse Modules/Meetup --level=10
vendor/bin/pint Modules/Meetup
vendor/bin/pest Modules/Meetup
```

### Assets

```bash
# Build for production
npm run build

# Build for dev (with source maps)
npm run dev

# Watch and rebuild
npm run watch
```

---

## 🎯 Quick Tasks (Copy-Paste Ready)

### Creare una Nuova Pizza via Tinker

```bash
php artisan tinker
```

```php
use Modules\Meetup\Models\Pizza;
use Modules\Meetup\Models\Category;

$category = Category::where('slug', 'classiche')->first();

Pizza::create([
    'title' => 'Pizza Napoletana DOC',
    'slug' => 'pizza-napoletana-doc',
    'description' => 'La vera pizza napoletana con mozzarella di bufala',
    'price' => 11.50,
    'category_id' => $category->id,
    'is_active' => true,
    'is_featured' => false,
]);
```

### Creare un Ordine Programmaticamente

```php
use Modules\Meetup\Models\Order;
use Modules\Meetup\Models\Pizza;
use Modules\User\Models\User;

$user = User::first();
$pizza = Pizza::where('slug', 'margherita')->first();

$order = Order::create([
    'user_id' => $user->id,
    'total_amount' => 8.50,
    'status' => 'pending',
    'delivery_type' => 'delivery',
    'delivery_address' => 'Via Roma 123, Milano',
]);

$order->items()->create([
    'pizza_id' => $pizza->id,
    'quantity' => 1,
    'price' => $pizza->price,
    'total' => $pizza->price,
]);
```

### Testare Email Notifications

```bash
# Start Mailpit (if using Docker)
# Or use Laravel Log driver in .env:
# MAIL_MAILER=log

php artisan tinker
```

```php
use Modules\Meetup\Models\Order;
use Modules\Meetup\Notifications\OrderConfirmation;

$order = Order::first();
$order->user->notify(new OrderConfirmation($order));

// Check: storage/logs/laravel.log or http://localhost:8025
```

---

## 🐛 Problemi Comuni & Fix Rapidi

### "Class not found" / Autoload Issues

```bash
composer dump-autoload
php artisan optimize:clear
```

### "No application encryption key"

```bash
php artisan key:generate
```

### "SQLSTATE[HY000]: General error: 1 no such table"

```bash
php artisan migrate:fresh --seed
```

### Tema non viene caricato

```bash
# Verifica config
php artisan tinker
>>> XotData::make()->theme  # Should be "Meetup"

# Clear view cache
php artisan view:clear
```

### Assets non si compilano

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Permessi File (Linux/Mac)

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

### "419 Page Expired" su Form Submit

```bash
# Assicurati che i form abbiano CSRF token
@csrf  # In Blade
<meta name="csrf-token" content="{{ csrf_token() }}">  # In head
```

---

## 📚 Prossimi Passi

### Dopo il QuickStart

1. **Leggi la Documentation** 📖
   - `INSTALLATION.md` - Setup dettagliato
   - `FEATURES.md` - Tutte le features disponibili
   - `DEVELOPMENT.md` - Workflow completo
   - `MODELS_REFERENCE.md` - Models e relationships
   - `DOCUMENTATION_INDEX.md` - Indice completo docs

2. **Esplora il Codice** 🔍
   - `/Modules/Meetup/app/Models/` - I modelli principali
   - `/Modules/Meetup/app/Filament/` - Admin panel resources
   - `/Themes/Meetup/resources/html/` - Frontend statico
   - `/Modules/Meetup/database/seeders/` - Dati demo

3. **Prova le Features** 🎮
   - Sistema ordini completo
   - Gestione menu pizze
   - Eventi (corsi, serate tema)
   - Admin dashboard Filament
   - Static HTML + Vite build

4. **Contribuisci** 🤝
   - Leggi `CONTRIBUTING.md`
   - Crea un branch
   - Fai una PR
   - Segui code style (PHPStan level 10!)

---

## 💡 Pro Tips

### Speed Up Development

```bash
# Usa alias utili
alias pa='php artisan'
alias pam='php artisan migrate'
alias pas='php artisan serve'
alias paqw='php artisan queue:work'
alias pat='php artisan tinker'

# Mettili in ~/.bashrc o ~/.zshrc
```

### IDE Helper per Autocomplete

```bash
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
php artisan ide-helper:models
php artisan ide-helper:meta
```

### Debug con Ray (opzionale)

```bash
composer require spatie/laravel-ray
```

```php
use function Spatie\LaravelRay\ray;

ray($order)->green();  // Beautiful debug output!
```

### Quick DB Inspect

```bash
# SQLite DB browser
php artisan db:show
php artisan db:table pizzas

# Or use CLI
sqlite3 database/database.sqlite
sqlite> .tables
sqlite> SELECT * FROM meetup_pizzas LIMIT 5;
```

---

## 🎓 Learn by Example

### User Journey: Ordine Pizza

```
1. Cliente visita /menu.html
2. Filtra pizze (categoria, prezzo, proprietà)
3. Click "Margherita" → Vede dettagli
4. Click "Aggiungi al Carrello"
   → JavaScript add to cart (localStorage)
5. Click carrello icon → /cart.html
6. Click "Procedi al Checkout" → /checkout.html
7. Compila form → POST /orders
   → OrderController@store
   → CreateOrderAction::execute()
   → Crea Order + OrderItems
   → SendOrderConfirmationEmail (queued)
8. Redirect → /orders/{id}/tracking
9. Cliente riceve email (Mailpit)
10. Admin vede ordine in dashboard Filament
11. Admin cambia status → Notifica cliente
```

### Admin Workflow: Gestione Pizza

```
1. Login /admin
2. Sidebar → Pizzas
3. Click "Create"
   → PizzaResource::form()
4. Compila dati:
   - Title, Description, Price
   - Category (select)
   - Ingredients (multiselect)
   - Image (upload via Spatie Media Library)
5. Click "Create"
   → PizzaResource::create()
   → Pizza::create()
   → Cache::forget('pizzas.featured')
6. Pizza visible in frontend
```

---

## ✅ Checklist Primo Giorno

- [ ] Repository clonato
- [ ] Dipendenze installate (composer + npm)
- [ ] Database creato e migrato
- [ ] Seeder eseguito con dati demo
- [ ] Admin user creato
- [ ] Server avviato (localhost:8000)
- [ ] Queue worker running
- [ ] Homepage caricata correttamente
- [ ] Admin panel accessibile
- [ ] Primo ordine creato dal frontend
- [ ] Ordine visibile in admin panel
- [ ] Assets compilati con Vite
- [ ] Documentazione letta (almeno README + QUICKSTART)
- [ ] IDE configurato con helper

---

## 🆘 Bisogno di Aiuto?

- **Documentazione:** `/Modules/Meetup/docs/`
- **Issues GitHub:** [URL_REPO]/issues
- **Logs:** `storage/logs/laravel.log`
- **Debug:** `php artisan telescope` (if installed)

---

**Benvenuto nel team LaravelPizza! 🍕**

Tempo stimato per completare questo quickstart: **5-10 minuti**

*Ultima revisione: 2025-11-27*
