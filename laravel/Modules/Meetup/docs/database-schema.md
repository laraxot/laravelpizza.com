# 🗄️ Database Schema - Modulo Meetup

## Panoramica

Il database del modulo Meetup è progettato per gestire un sistema completo di ordinazione pizze online, con supporto per menu dinamico, personalizzazioni, ordini e tracking.

## 📊 Tabelle Principali

### 1. meetup_pizzas

Tabella principale per le pizze del menu.

```sql
CREATE TABLE meetup_pizzas (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    short_description VARCHAR(500),
    category_id BIGINT UNSIGNED,
    base_price DECIMAL(8,2) NOT NULL,
    image_path VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    is_featured BOOLEAN DEFAULT 0,
    is_vegetarian BOOLEAN DEFAULT 0,
    is_vegan BOOLEAN DEFAULT 0,
    is_spicy BOOLEAN DEFAULT 0,
    calories INT UNSIGNED,
    preparation_time INT UNSIGNED COMMENT 'minuti',
    popularity_score INT DEFAULT 0,
    meta_data JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_category_id (category_id),
    INDEX idx_slug (slug),
    INDEX idx_is_active (is_active),
    INDEX idx_is_featured (is_featured),
    INDEX idx_popularity_score (popularity_score),

    FOREIGN KEY (category_id) REFERENCES meetup_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Campi Speciali:**
- `slug` - URL-friendly identifier per SEO
- `meta_data` - JSON per dati aggiuntivi flessibili
- `popularity_score` - Calcolato in base al numero di ordini
- `calories` - Informazioni nutrizionali
- `preparation_time` - Tempo preparazione in minuti

### 2. meetup_categories

Categorie per organizzare le pizze.

```sql
CREATE TABLE meetup_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    icon VARCHAR(255),
    color VARCHAR(7) COMMENT 'HEX color',
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    parent_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_slug (slug),
    INDEX idx_display_order (display_order),
    INDEX idx_parent_id (parent_id),

    FOREIGN KEY (parent_id) REFERENCES meetup_categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Esempi Categorie:**
- Classiche (Margherita, Marinara, etc.)
- Speciali (Pizze gourmet)
- Vegetariane
- Vegane
- Del giorno (offerte speciali)

### 3. meetup_ingredients

Ingredienti disponibili per personalizzazioni.

```sql
CREATE TABLE meetup_ingredients (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price_modifier DECIMAL(6,2) DEFAULT 0.00 COMMENT 'Costo aggiuntivo',
    is_available BOOLEAN DEFAULT 1,
    is_allergen BOOLEAN DEFAULT 0,
    allergen_type VARCHAR(100),
    image_path VARCHAR(255),
    stock_quantity INT UNSIGNED,
    min_stock_alert INT UNSIGNED DEFAULT 10,
    category ENUM('base', 'cheese', 'meat', 'vegetable', 'sauce', 'extra') DEFAULT 'extra',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_is_available (is_available),
    INDEX idx_category (category),
    INDEX idx_is_allergen (is_allergen)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4. meetup_pizza_ingredient (Pivot)

Relazione molti-a-molti tra pizze e ingredienti.

```sql
CREATE TABLE meetup_pizza_ingredient (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    pizza_id BIGINT UNSIGNED NOT NULL,
    ingredient_id BIGINT UNSIGNED NOT NULL,
    quantity DECIMAL(5,2) DEFAULT 1.00,
    is_default BOOLEAN DEFAULT 1 COMMENT 'Ingrediente standard della pizza',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    UNIQUE KEY unique_pizza_ingredient (pizza_id, ingredient_id),
    INDEX idx_pizza_id (pizza_id),
    INDEX idx_ingredient_id (ingredient_id),

    FOREIGN KEY (pizza_id) REFERENCES meetup_pizzas(id) ON DELETE CASCADE,
    FOREIGN KEY (ingredient_id) REFERENCES meetup_ingredients(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 5. meetup_sizes

Dimensioni disponibili per le pizze.

```sql
CREATE TABLE meetup_sizes (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    diameter_cm INT UNSIGNED,
    price_multiplier DECIMAL(4,2) DEFAULT 1.00,
    slices INT UNSIGNED,
    display_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_display_order (display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Esempi:**
- Baby (20cm) - multiplier: 0.7
- Normale (30cm) - multiplier: 1.0
- Maxi (40cm) - multiplier: 1.5
- Party (60cm) - multiplier: 2.5

### 6. meetup_orders

Ordini effettuati dai clienti.

```sql
CREATE TABLE meetup_orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id BIGINT UNSIGNED,
    guest_email VARCHAR(255),
    guest_phone VARCHAR(20),
    status ENUM('pending', 'confirmed', 'preparing', 'ready', 'delivering', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    payment_method ENUM('cash', 'card', 'paypal', 'stripe', 'bank_transfer') DEFAULT 'cash',
    subtotal DECIMAL(10,2) NOT NULL,
    delivery_fee DECIMAL(6,2) DEFAULT 0.00,
    discount_amount DECIMAL(8,2) DEFAULT 0.00,
    tax_amount DECIMAL(8,2) DEFAULT 0.00,
    total DECIMAL(10,2) NOT NULL,
    delivery_type ENUM('delivery', 'pickup', 'dine_in') DEFAULT 'delivery',
    delivery_address TEXT,
    delivery_city VARCHAR(100),
    delivery_postal_code VARCHAR(20),
    delivery_latitude DECIMAL(10,8),
    delivery_longitude DECIMAL(11,8),
    delivery_notes TEXT,
    customer_notes TEXT,
    estimated_delivery_time TIMESTAMP,
    actual_delivery_time TIMESTAMP,
    assigned_driver_id BIGINT UNSIGNED,
    coupon_code VARCHAR(50),
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_order_number (order_number),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_created_at (created_at),

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 7. meetup_order_items

Singoli item di un ordine.

```sql
CREATE TABLE meetup_order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    pizza_id BIGINT UNSIGNED,
    size_id BIGINT UNSIGNED,
    quantity INT UNSIGNED NOT NULL DEFAULT 1,
    unit_price DECIMAL(8,2) NOT NULL,
    total_price DECIMAL(8,2) NOT NULL,
    customizations JSON COMMENT 'Ingredienti aggiunti/rimossi',
    special_instructions TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_order_id (order_id),
    INDEX idx_pizza_id (pizza_id),

    FOREIGN KEY (order_id) REFERENCES meetup_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (pizza_id) REFERENCES meetup_pizzas(id) ON DELETE SET NULL,
    FOREIGN KEY (size_id) REFERENCES meetup_sizes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

**Esempio customizations JSON:**
```json
{
    "added": [
        {"ingredient_id": 12, "name": "Olive", "price": 1.50},
        {"ingredient_id": 8, "name": "Funghi", "price": 1.00}
    ],
    "removed": [
        {"ingredient_id": 3, "name": "Cipolla"}
    ],
    "extra": [
        {"ingredient_id": 5, "name": "Mozzarella Extra", "price": 2.00}
    ]
}
```

### 8. meetup_reviews

Recensioni e valutazioni pizze.

```sql
CREATE TABLE meetup_reviews (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    pizza_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED,
    order_id BIGINT UNSIGNED,
    rating TINYINT UNSIGNED NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(255),
    comment TEXT,
    pros TEXT,
    cons TEXT,
    is_verified_purchase BOOLEAN DEFAULT 0,
    is_approved BOOLEAN DEFAULT 0,
    helpful_count INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_pizza_id (pizza_id),
    INDEX idx_user_id (user_id),
    INDEX idx_rating (rating),
    INDEX idx_is_approved (is_approved),
    INDEX idx_created_at (created_at),

    FOREIGN KEY (pizza_id) REFERENCES meetup_pizzas(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (order_id) REFERENCES meetup_orders(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 9. meetup_coupons

Codici sconto e promozioni.

```sql
CREATE TABLE meetup_coupons (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    type ENUM('percentage', 'fixed_amount', 'free_delivery') DEFAULT 'percentage',
    value DECIMAL(8,2) NOT NULL,
    min_order_amount DECIMAL(8,2),
    max_discount_amount DECIMAL(8,2),
    usage_limit INT UNSIGNED,
    usage_count INT DEFAULT 0,
    user_usage_limit INT UNSIGNED DEFAULT 1,
    valid_from TIMESTAMP,
    valid_until TIMESTAMP,
    is_active BOOLEAN DEFAULT 1,
    applicable_categories JSON COMMENT 'IDs categorie applicabili',
    applicable_pizzas JSON COMMENT 'IDs pizze applicabili',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_code (code),
    INDEX idx_is_active (is_active),
    INDEX idx_valid_from (valid_from),
    INDEX idx_valid_until (valid_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 10. meetup_delivery_zones

Zone di consegna con tariffe.

```sql
CREATE TABLE meetup_delivery_zones (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    city VARCHAR(100),
    postal_codes JSON COMMENT 'Array di CAP coperti',
    delivery_fee DECIMAL(6,2) NOT NULL,
    min_order_amount DECIMAL(8,2),
    max_delivery_time INT UNSIGNED COMMENT 'minuti',
    is_active BOOLEAN DEFAULT 1,
    polygon_coordinates JSON COMMENT 'Coordinate poligono area',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,

    INDEX idx_city (city),
    INDEX idx_is_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## 🔗 Relazioni tra Tabelle

### Diagramma ER

```
meetup_categories
    ↓ 1:N
meetup_pizzas ←──┬──→ meetup_pizza_ingredient ←── meetup_ingredients
    ↓ 1:N        │
meetup_reviews   │
                 ↓ N:1
            meetup_order_items ──→ meetup_sizes
                 ↓ N:1
            meetup_orders
                 ↓ 1:N
            users (dal modulo User)
```

### Cardinalità

- **Category → Pizzas**: 1:N (una categoria ha molte pizze)
- **Pizza → Ingredients**: N:N (tramite pivot pizza_ingredient)
- **Pizza → Reviews**: 1:N (una pizza ha molte recensioni)
- **Order → OrderItems**: 1:N (un ordine ha molti item)
- **User → Orders**: 1:N (un utente può fare molti ordini)
- **Pizza → OrderItems**: 1:N (una pizza può essere in molti ordini)
- **Size → OrderItems**: 1:N (una dimensione può essere in molti item)

## 📝 Note Implementazione

### Indici

Tutti gli indici sono stati progettati per:
- Query frequenti (ricerca pizze, ordini per utente)
- Ordinamenti (popularity_score, display_order)
- Filtri (is_active, status, category_id)

### JSON Fields

I campi JSON sono usati per:
- `meta_data` - Dati flessibili senza alterare schema
- `customizations` - Personalizzazioni ordine dinamiche
- `applicable_categories/pizzas` - Liste dinamiche per coupon
- `polygon_coordinates` - Coordinate geografiche zone

### Soft Deletes

La tabella `meetup_pizzas` usa soft delete (`deleted_at`) per:
- Mantenere storico ordini
- Possibilità di ripristino
- Analytics storici

### Timestamp Tracking

Tutte le tabelle hanno:
- `created_at` - Data creazione
- `updated_at` - Data ultimo aggiornamento
- Alcuni hanno `deleted_at` per soft delete

### Decimal Precision

Prezzi usano `DECIMAL(8,2)` per:
- Precisione monetaria
- Evitare errori di arrotondamento
- Supporto fino a 999,999.99€

## 🔐 Sicurezza

### Constraints

- Foreign keys con `ON DELETE CASCADE` per order_items
- Foreign keys con `ON DELETE SET NULL` per referenze opzionali
- CHECK constraints per rating (1-5)
- UNIQUE constraints per slug, order_number, coupon code

### Validazione

Campi che richiedono validazione application-level:
- Email format per `guest_email`
- Phone format per `guest_phone`
- Postal code format per `delivery_postal_code`
- Latitude/Longitude range per coordinate
- JSON schema validation per campi JSON

## 🚀 Migrazioni Laravel

Le migrazioni saranno create in ordine:

1. `create_meetup_categories_table.php`
2. `create_meetup_sizes_table.php`
3. `create_meetup_pizzas_table.php`
4. `create_meetup_ingredients_table.php`
5. `create_meetup_pizza_ingredient_table.php`
6. `create_meetup_delivery_zones_table.php`
7. `create_meetup_coupons_table.php`
8. `create_meetup_orders_table.php`
9. `create_meetup_order_items_table.php`
10. `create_meetup_reviews_table.php`

### Esempio Migration

```php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetup_pizzas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('short_description', 500)->nullable();
            $table->foreignId('category_id')->nullable()->constrained('meetup_categories')->nullOnDelete();
            $table->decimal('base_price', 8, 2);
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_vegetarian')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->boolean('is_spicy')->default(false);
            $table->unsignedInteger('calories')->nullable();
            $table->unsignedInteger('preparation_time')->nullable()->comment('minuti');
            $table->integer('popularity_score')->default(0);
            $table->json('meta_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'is_active']);
            $table->index('slug');
            $table->index('popularity_score');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetup_pizzas');
    }
};
```

## 📊 Seeding Dati

### Dati Essenziali (Seeder)

1. **Categorie Default**:
   - Classiche
   - Speciali
   - Vegetariane
   - Vegane
   - Bianche

2. **Dimensioni Standard**:
   - Baby (20cm)
   - Normale (30cm)
   - Maxi (40cm)
   - Party (60cm)

3. **Ingredienti Base**:
   - Pomodoro
   - Mozzarella
   - Olio EVO
   - Basilico
   - (+ 50+ ingredienti vari)

4. **Pizze Classiche**:
   - Margherita
   - Marinara
   - Diavola
   - Quattro Stagioni
   - Capricciosa
   - (+ altre pizze classiche)

5. **Zone Consegna**:
   - Centro città (€2.50)
   - Periferia (€4.00)
   - Fuori città (€6.00)

### Factory per Testing

Ogni model avrà una factory per generare dati fake nei test.
