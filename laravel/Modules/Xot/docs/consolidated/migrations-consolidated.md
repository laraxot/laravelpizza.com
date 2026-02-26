# Migrations - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTA la documentazione migrazioni del progetto
> 
> **🔗 Riferimenti**: [database-guidelines.md](database-guidelines.md) | [best-practices.md](best-practices.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file migrazioni, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **26+ file migrazioni duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `migrations.md` in qualsiasi modulo
- `migration-guide.md` duplicati
- `migration_best_practices.md` sparsi
- `migration_rules.md` in ogni modulo
- Qualsiasi documentazione migrazioni specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/migrations-consolidated.md`
- **File migrazione**: Solo nei singoli moduli (codice, non docs)

## Principi Fondamentali Universali

### Estensione Obbligatoria (Tutti i Moduli)
- **SEMPRE** estendere `XotBaseMigration`
- **MAI** estendere `Migration` di Laravel direttamente
- **MAI** implementare il metodo `down()`

### Classi Anonime Obbligatorie (Tutti i Moduli)
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    protected string $table_name = 'table_name';
    
    public function up(): void
    {
        // Implementazione...
    }
};
```

## ❌ Anti-Pattern Universali da Evitare

### 1. Estensione Diretta Migration (Tutti i Moduli)
```php
// ❌ MAI fare questo in nessun modulo
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    // ERRORE: Non estendere Migration direttamente
}
```

### 2. Implementazione Metodo down() (Tutti i Moduli)
```php
// ❌ MAI implementare down() in nessun modulo
public function down(): void
{
    Schema::dropIfExists($this->table_name); // ERRORE!
}
```

### 3. Nuove Migrazioni per Aggiungere Colonne (Tutti i Moduli)
```php
// ❌ MAI creare nuove migrazioni separate per colonne
// File: 2023_05_15_112233_add_email_to_users_table.php
// ERRORE: Dovrebbe essere aggiornamento della migrazione originale
```

## ✅ Pattern Corretti Universali

### 1. Creazione Tabella Standard (Tutti i Moduli)
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    protected string $table_name = 'users';

    public function up(): void
    {
        if ($this->hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] già esistente';
            return;
        }

        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        $this->tableComment($this->table_name, 'Tabella utenti del sistema');
    }
};
```

### 2. Aggiornamento Tabella Esistente (Tutti i Moduli)
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    protected string $table_name = 'users';

    public function up(): void
    {
        // 1. Prima crea la tabella se non esiste (codice originale)
        if (!$this->hasTable($this->table_name)) {
            $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                // Nuova colonna aggiunta qui nella creazione
                $table->string('phone')->nullable();
                $table->timestamps();
            });
            
            $this->tableComment($this->table_name, 'Tabella utenti del sistema');
            return;
        }
        
        // 2. Se la tabella esiste, aggiungi solo la nuova colonna
        if (!$this->hasColumn($this->table_name, 'phone')) {
            $this->tableUpdate(function (Blueprint $table): void {
                $table->string('phone')->nullable()->after('email');
            });
            
            $this->columnComment($this->table_name, 'phone', 'Numero di telefono utente');
        }
    }
};
```

### 3. Tabella Pivot con Relazioni (Tutti i Moduli)
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    protected string $table_name = 'model_pivot';

    public function up(): void
    {
        if ($this->hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] già esistente';
            return;
        }

        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            
            // Chiavi esterne con foreignIdFor
            $table->foreignIdFor(\Modules\ModuleName\Models\ModelA::class)
                ->comment('ID del primo modello');
            $table->foreignIdFor(\Modules\ModuleName\Models\ModelB::class)
                ->comment('ID del secondo modello');
            
            // Attributi aggiuntivi della relazione
            $table->json('metadata')->nullable()
                ->comment('Metadati aggiuntivi della relazione');
            $table->boolean('is_primary')->default(false)
                ->comment('Relazione principale');
            
            // Indice composito per unicità
            $table->unique(['model_a_id', 'model_b_id']);
            
            $table->timestamps();
        });

        $this->tableComment($this->table_name, 'Relazione molti-a-molti tra ModelA e ModelB');
    }
};
```

## Regole per Aggiornamento Tabelle Universali

### Procedura Obbligatoria per Aggiungere Colonne (Tutti i Moduli)

#### Passo 1: Copiare Migrazione Originale
```bash
# Copiare il file di migrazione originale
cp 2021_01_01_000000_create_users_table.php 2023_05_15_000000_create_users_table.php
```

#### Passo 2: Aggiornare Timestamp
- Aggiornare il timestamp nel nome del file
- Mantenere lo stesso nome della classe (anonima)

#### Passo 3: Aggiungere Logica Condizionale
```php
public function up(): void
{
    // 1. Creazione tabella con nuove colonne
    if (!$this->hasTable($this->table_name)) {
        $this->tableCreate(function (Blueprint $table): void {
            // Struttura originale + nuove colonne
        });
        return;
    }
    
    // 2. Aggiunta colonne se tabella esiste
    if (!$this->hasColumn($this->table_name, 'new_column')) {
        $this->tableUpdate(function (Blueprint $table): void {
            $table->string('new_column')->nullable();
        });
    }
}
```

## Metodi Helper XotBaseMigration Universali

### Controlli Esistenza (Tutti i Moduli)
```php
// Controllo tabella
if ($this->hasTable('table_name')) {
    // Tabella esiste
}

// Controllo colonna
if ($this->hasColumn('table_name', 'column_name')) {
    // Colonna esiste
}

// Controllo indice
if ($this->hasIndex('table_name', 'index_name')) {
    // Indice esiste
}
```

### Operazioni Tabella (Tutti i Moduli)
```php
// Creazione tabella
$this->tableCreate(function (Blueprint $table): void {
    // Definizione colonne
});

// Aggiornamento tabella
$this->tableUpdate(function (Blueprint $table): void {
    // Modifiche colonne
});

// Commento tabella
$this->tableComment('table_name', 'Descrizione tabella');

// Commento colonna
$this->columnComment('table_name', 'column_name', 'Descrizione colonna');
```

### Gestione Foreign Key (Tutti i Moduli)
```php
// Con foreignIdFor (RACCOMANDATO)
$table->foreignIdFor(\Modules\ModuleName\Models\User::class)
    ->comment('Riferimento utente');

// Manuale (solo se necessario)
$table->unsignedBigInteger('user_id')->nullable();
$table->foreign('user_id')->references('id')->on('users')
    ->onDelete('cascade')->onUpdate('cascade');
```

## Tipi di Colonne Standard Universali

### Tipi Base (Tutti i Moduli)
```php
$table->id();                           // Chiave primaria autoincrement
$table->uuid('uuid')->unique();         // UUID
$table->string('name', 100)->nullable(); // Stringa con lunghezza
$table->text('description')->nullable(); // Testo lungo
$table->integer('count')->default(0);   // Intero con default
$table->decimal('price', 10, 2)->nullable(); // Decimale (10 cifre, 2 decimali)
$table->boolean('is_active')->default(true); // Booleano
$table->date('birth_date')->nullable(); // Data
$table->dateTime('created_at')->nullable(); // Data e ora
$table->timestamps();                   // created_at e updated_at
$table->softDeletes();                 // deleted_at per soft delete
```

### Tipi Avanzati (Tutti i Moduli)
```php
$table->json('metadata')->nullable();   // Dati JSON
$table->enum('status', ['active', 'inactive']); // Enum
$table->point('location')->nullable();  // Punto geografico
$table->polygon('area')->nullable();    // Poligono geografico
```

## Indici e Vincoli Universali

### Indici Standard (Tutti i Moduli)
```php
$table->index('name');                  // Indice singolo
$table->index(['category_id', 'status']); // Indice composito
$table->unique('email');                // Vincolo unicità
$table->unique(['year', 'month', 'user_id']); // Unicità composita
$table->fullText('description');       // Indice full-text
```

### Vincoli Referenziali (Tutti i Moduli)
```php
$table->foreign('user_id')->references('id')->on('users')
    ->onDelete('cascade')
    ->onUpdate('cascade');
```

## Pattern Specifici per Modulo

### Activity Module
- **Tabelle**: `activities`, `activity_logs`
- **Relazioni**: User, Model polymorphic
- **Campi specifici**: `action`, `description`, `properties`

### Chart Module
- **Tabelle**: `charts`, `chart_data`
- **Relazioni**: User, Dashboard
- **Campi specifici**: `type`, `config`, `data`

### Cms Module
- **Tabelle**: `pages`, `posts`, `menus`
- **Relazioni**: User, Category, Media
- **Campi specifici**: `slug`, `content`, `status`

### FormBuilder Module
- **Tabelle**: `forms`, `form_fields`, `form_submissions`
- **Relazioni**: User, Form
- **Campi specifici**: `type`, `options`, `validation`

### Gdpr Module
- **Tabelle**: `consents`, `data_requests`
- **Relazioni**: User, ConsentType
- **Campi specifici**: `given_at`, `withdrawn_at`, `type`

### Geo Module
- **Tabelle**: `locations`, `countries`, `regions`
- **Relazioni**: User, Address
- **Campi specifici**: `latitude`, `longitude`, `polygon`

### Job Module
- **Tabelle**: `jobs`, `failed_jobs`, `job_batches`
- **Relazioni**: User, Batch
- **Campi specifici**: `queue`, `payload`, `attempts`

### Lang Module
- **Tabelle**: `translations`, `languages`
- **Relazioni**: User, Group
- **Campi specifici**: `locale`, `key`, `value`

### Media Module
- **Tabelle**: `media`, `media_collections`
- **Relazioni**: User, Model polymorphic
- **Campi specifici**: `filename`, `mime_type`, `size`

### Notify Module
- **Tabelle**: `notifications`, `notification_templates`
- **Relazioni**: User, Notifiable polymorphic
- **Campi specifici**: `type`, `data`, `read_at`

### <nome modulo> Module
- **Tabelle**: `appointments`, `patients`, `doctors`
- **Relazioni**: User, Studio, Treatment
- **Campi specifici**: `appointment_date`, `status`, `notes`

### <nome progetto> Module (CRITICO)
- **Tabelle**: `appointments`, `patients`, `doctors`, `studios`
- **Relazioni**: User, Studio, Doctor, Patient
- **Campi specifici**: `appointment_id`, `patient_id`, `doctor_id`

### Tenant Module
- **Tabelle**: `tenants`, `tenant_users`
- **Relazioni**: User, Domain
- **Campi specifici**: `domain`, `settings`, `active`

### UI Module
- **Tabelle**: `themes`, `components`, `widgets`
- **Relazioni**: User, Theme
- **Campi specifici**: `name`, `config`, `active`

### User Module (CRITICO)
- **Tabelle**: `users`, `roles`, `permissions`
- **Relazioni**: Role, Permission, Profile
- **Campi specifici**: `email`, `password`, `verified_at`

### Xot Module (CRITICO)
- **Tabelle**: `modules`, `settings`, `logs`
- **Relazioni**: User, Module
- **Campi specifici**: `name`, `active`, `config`

## 🔥 ELIMINAZIONE DUPLICAZIONI

### File da Eliminare IMMEDIATAMENTE
Tutti questi file sono DUPLICATI e vanno eliminati:

```bash
# Activity
rm Modules/Activity/project_docs/database/migrations.md

# Cms
rm Modules/Cms/project_docs/migration.md

# Gdpr
rm Modules/Gdpr/project_docs/migrations.md

# Geo
rm Modules/Geo/project_docs/migration-guide.md
rm Modules/Geo/project_docs/migration-naming-pattern.md
rm Modules/Geo/project_docs/migration_guide.md
rm Modules/Geo/project_docs/migration_naming_pattern.md

# Lang
rm Modules/Lang/project_docs/migration_best_practices.md
rm Modules/Lang/project_docs/migration_corrections_summary.md
rm Modules/Lang/project_docs/migration_patterns.md

# Notify
rm Modules/Notify/project_docs/migration_changes.md
rm Modules/Notify/project_docs/migration_rules.md
rm Modules/Notify/project_docs/migrations.md
rm Modules/Notify/project_docs/migrations_changelog.md

# <nome modulo>
rm Modules/<nome modulo>/project_docs/database/migrations.md

# E tutti gli altri file duplicati...
```

### Mantenere Solo
- **Questo file**: `/laravel/Modules/Xot/project_docs/migrations-consolidated.md`
- **File migrazione**: Solo codice nei singoli moduli

## Troubleshooting Universale

### Errori di Migrazione (Tutti i Moduli)
1. Verificare estensione XotBaseMigration
2. Controllare namespace corretto
3. Validare sintassi Blueprint
4. Verificare foreign key esistenti

### Performance (Tutti i Moduli)
1. Aggiungere indici appropriati
2. Utilizzare batch per grandi dataset
3. Ottimizzare foreign key
4. Monitorare query lente

---

**🎯 Obiettivo**: Da 26+ file duplicati a 1 file centralizzato  
**📈 Beneficio**: 96% riduzione duplicazioni, manutenzione semplificata  
**🔗 Vedi anche**: [database-guidelines.md](database-guidelines.md) | [best-practices.md](best-practices.md)

**Aggiornato**: 2025-08-07  
**Categoria**: database  
**Priorità**: CRITICA
