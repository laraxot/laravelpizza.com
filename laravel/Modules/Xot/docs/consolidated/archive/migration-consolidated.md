# Migrazioni - Documentazione Consolidata DRY + KISS

> **🎯 Single Source of Truth**: Questo documento centralizza TUTTE le regole di migrazione del progetto
> 
> **🔗 Riferimenti**: [coding-standards.md](coding-standards.md) | [best-practices.md](best-practices.md)

## 🚨 STOP DUPLICAZIONE!

**Prima di creare nuovi file di migrazione, LEGGI QUESTO DOCUMENTO!**

Questo documento sostituisce e consolida **30+ file di migrazione duplicati** trovati in tutti i moduli.

### ❌ File da NON Creare Più
- `migration-rules.md` in qualsiasi modulo
- `migration-guide.md` duplicati
- `migration-checklist.md` sparsi
- Qualsiasi documentazione migrazione specifica di modulo

### ✅ Unica Fonte di Verità
- **Questo file**: `/laravel/Modules/Xot/project_docs/migration-consolidated.md`
- **Implementazione**: File di migrazione nei singoli moduli (solo migrazioni, non docs)

## Principi Fondamentali

### Classi Anonime Obbligatorie
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    public function up(): void
    {
        // Implementazione migrazione
    }
    // NIENTE metodo down()
};
```

### No Down() Method
- **MAI** implementare il metodo `down()` nelle migrazioni
- La gestione del rollback è centralizzata in XotBaseMigration
- Evitare duplicazione e conflitti

### Controlli di Esistenza
```php
public function up(): void
{
    // Controllo se la tabella esiste già
    if (Schema::hasTable($this->table_name)) {
        return;
    }

    // Creazione tabella
    Schema::create($this->table_name, function (Blueprint $table) {
        // Definizione colonne
    });
}
```

## Struttura Standard delle Migrazioni

### Creazione Tabella
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected string $table_name = 'nome_tabella';

    public function up(): void
    {
        // Verifica se la tabella esiste già
        if (Schema::hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] già esistente';
            return;
        }

        // Crea la tabella
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            // Campi specifici
            $table->string('nome');
            $table->string('descrizione')->nullable();
            $table->integer('quantita')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Timestamp standard
            $table->timestamps();
        });

        echo 'Tabella ['.$this->table_name.'] creata con successo!';
    }
};
```

### Aggiornamento Tabella
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected string $table_name = 'nome_tabella';

    public function up(): void
    {
        // Verifica se la tabella esiste
        if (!Schema::hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] non esistente';
            return;
        }

        // Aggiunge la colonna se non esiste
        if (!Schema::hasColumn($this->table_name, 'email')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string('email')->nullable()->after('nome');
            });

            echo 'Colonna [email] aggiunta alla tabella ['.$this->table_name.']';
        } else {
            echo 'Colonna [email] già esistente nella tabella ['.$this->table_name.']';
        }

        // Aggiunge un'altra colonna se non esiste
        if (!Schema::hasColumn($this->table_name, 'telefono')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string('telefono')->nullable()->after('email');
            });

            echo 'Colonna [telefono] aggiunta alla tabella ['.$this->table_name.']';
        } else {
            echo 'Colonna [telefono] già esistente nella tabella ['.$this->table_name.']';
        }
    }
};
```

### Relazioni e Indici
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected string $table_name = 'prodotti';

    public function up(): void
    {
        // Verifica se la tabella esiste già
        if (Schema::hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] già esistente';
            return;
        }

        // Crea la tabella con relazioni e indici
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            // Campi principali
            $table->string('nome');
            $table->text('descrizione')->nullable();
            $table->decimal('prezzo', 10, 2)->default(0);
            $table->integer('quantita_disponibile')->default(0);

            // Chiavi esterne e relazioni
            $table->foreignId('categoria_id')->constrained('categorie')->onDelete('cascade');
            $table->foreignId('fornitore_id')->nullable()->constrained('fornitori')->onDelete('set null');

            // Indici per migliorare le performance
            $table->index('nome');
            $table->index(['categoria_id', 'prezzo']);

            // Flag e stati
            $table->boolean('is_attivo')->default(true);
            $table->enum('stato', ['disponibile', 'esaurito', 'in_arrivo'])->default('disponibile');

            // Timestamp standard
            $table->timestamps();
        });

        echo 'Tabella ['.$this->table_name.'] creata con successo!';
    }
};
```

### Tabella Pivot
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected string $table_name = 'prodotto_tag';

    public function up(): void
    {
        // Verifica se la tabella esiste già
        if (Schema::hasTable($this->table_name)) {
            echo 'Tabella ['.$this->table_name.'] già esistente';
            return;
        }

        // Crea la tabella pivot
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            // Chiavi esterne
            $table->foreignId('prodotto_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');

            // Attributi aggiuntivi della relazione (se necessari)
            $table->integer('ordine')->default(0);

            // Indice composito per garantire unicità
            $table->unique(['prodotto_id', 'tag_id']);

            // Timestamp standard
            $table->timestamps();
        });

        echo 'Tabella ['.$this->table_name.'] creata con successo!';
    }
};
```

## Regole per Modifica di Tabelle Esistenti

### Regola 1: Copia la Migrazione Originale
Quando è necessario aggiungere colonne a una tabella esistente:
1. **NON** creare una nuova migrazione di creazione
2. **COPIARE** la migrazione originale
3. **AGGIORNARE** il timestamp nel nome del file
4. **AGGIUNGERE** le nuove colonne solo se non esistono

### Regola 2: Verifica Sempre l'Esistenza
Prima di aggiungere o modificare:
1. Verificare sempre se la tabella esiste con `Schema::hasTable($this->table_name)`
2. Verificare sempre se la colonna esiste con `Schema::hasColumn($this->table_name, 'nome_colonna')`

### Regola 3: Documentazione Adeguata
1. Documentare la modifica nella docs del modulo specifico (non root)
2. Creare collegamenti bidirezionali con la root docs
3. Spiegare la motivazione della modifica

## Tipi di Colonne Comuni

```php
$table->id(); // Chiave primaria autoincrement
$table->uuid('uuid')->unique(); // UUID
$table->string('nome', 100)->nullable(); // Stringa con lunghezza massima
$table->text('descrizione')->nullable(); // Testo lungo
$table->integer('quantita')->default(0); // Intero con default
$table->decimal('importo', 10, 2)->nullable(); // Decimale (10 cifre, 2 decimali)
$table->boolean('attivo')->default(true); // Booleano
$table->date('data')->nullable(); // Data
$table->dateTime('timestamp')->nullable(); // Data e ora
$table->timestamps(); // created_at e updated_at
$table->softDeletes(); // deleted_at per soft delete
```

## Gestione delle Foreign Key

```php
// Creazione foreign key
$table->unsignedBigInteger('user_id')->nullable();
$table->foreign('user_id')->references('id')->on('users');

// Oppure con metodo abbreviato
$table->foreignId('user_id')->nullable()->constrained();

// Con opzioni on delete/update
$table->foreignId('user_id')
    ->nullable()
    ->constrained()
    ->onDelete('cascade')
    ->onUpdate('cascade');
```

## Indici e Vincoli

```php
// Indici
$table->index('nome');
$table->index(['categoria_id', 'is_attivo']);
$table->unique('email');
$table->unique(['anno', 'mese', 'user_id']);
$table->fullText('descrizione'); // Per ricerche full-text

// Chiavi esterne
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->foreignId('categoria_id')->nullable()->constrained()->onDelete('set null');
```

## Procedura per Aggiornamento Tabelle Esistenti

### Fase 1: Documentazione Preliminare
1. Studiare la documentazione esistente del modulo
2. Verificare la struttura attuale della tabella
3. Documentare le modifiche necessarie e la motivazione

### Fase 2: Preparazione Migrazione
1. Copiare il file di migrazione originale
2. Rinominarlo con un nuovo timestamp
3. Aggiornare il contenuto mantenendo la compatibilità

### Fase 3: Implementazione
```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected string $table_name = 'prodotti';

    public function up(): void
    {
        // Verifica se la tabella esiste
        if (!Schema::hasTable($this->table_name)) {
            // Se non esiste, crea la tabella con tutte le colonne
            Schema::create($this->table_name, function (Blueprint $table) {
                $table->id();

                // Colonne originali
                $table->string('nome');
                $table->text('descrizione')->nullable();
                $table->decimal('prezzo', 10, 2)->default(0);

                // Nuove colonne
                $table->string('codice_sku')->nullable()->unique();
                $table->decimal('peso', 8, 2)->nullable();

                $table->timestamps();
            });

            echo 'Tabella ['.$this->table_name.'] creata con successo!';
            return;
        }

        // Se la tabella esiste, verifica e aggiungi solo le nuove colonne

        // Verifica e aggiungi codice_sku
        if (!Schema::hasColumn($this->table_name, 'codice_sku')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->string('codice_sku')->nullable()->unique()->after('prezzo');
            });

            echo 'Colonna [codice_sku] aggiunta alla tabella ['.$this->table_name.']';
        } else {
            echo 'Colonna [codice_sku] già esistente nella tabella ['.$this->table_name.']';
        }

        // Verifica e aggiungi peso
        if (!Schema::hasColumn($this->table_name, 'peso')) {
            Schema::table($this->table_name, function (Blueprint $table) {
                $table->decimal('peso', 8, 2)->nullable()->after('codice_sku');
            });

            echo 'Colonna [peso] aggiunta alla tabella ['.$this->table_name.']';
        } else {
            echo 'Colonna [peso] già esistente nella tabella ['.$this->table_name.']';
        }
    }
};
```

### Fase 4: Documentazione Post-Implementazione
1. Aggiornare la documentazione del modulo specifico
2. Creare/aggiornare collegamenti bidirezionali con la root docs
3. Aggiornare eventuali diagrammi ER o schemi di database

## Checklist per Migrazioni Corrette

Prima di considerare completa una migrazione, verificare:

- [ ] Estende `XotBaseMigration` anziché `Migration`
- [ ] NON implementa il metodo `down()`
- [ ] Verifica l'esistenza di tabelle/colonne prima di crearle/modificarle
- [ ] Utilizza i tipi di dati appropriati per ogni colonna
- [ ] Definisce indici e chiavi esterne quando necessario
- [ ] Include commenti e documentazione adeguata
- [ ] Segue le convenzioni di naming standard
- [ ] Documentazione nel modulo specifico aggiornata
- [ ] Collegamenti bidirezionali con la root docs creati/aggiornati

## Errori Comuni e Soluzioni

### Errore: ParseError - Metodi Fuori dalla Classe
**Sintomo**: `ParseError: syntax error, unexpected token "protected", expecting end of file`

**Causa**: Una funzione viene dichiarata **fuori dal blocco della classe** dopo la parentesi graffa di chiusura `}`.

**Soluzione**:
1. Spostare il metodo all'interno della classe corretta
2. Verificare che la parentesi graffa di chiusura sia l'ultima istruzione del file
3. Se il metodo non serve più, eliminarlo

### Errore: Namespace Senza Segmento 'App'
**Sintomo**: `Class not found: Modules\ModuleName\App\Models\Example`

**Causa**: Utilizzo di namespace con segmento `App` che non esiste nella struttura modulare.

**Soluzione**:
```php
// ❌ ERRATO
namespace Modules\ModuleName\App\Models;
namespace Modules\ModuleName\App\Actions;

// ✅ CORRETTO
namespace Modules\ModuleName\Models;
namespace Modules\ModuleName\Actions;
```

### Errore: Migrazioni con Metodo Down()
**Sintomo**: `Method down() not allowed in XotBaseMigration`

**Causa**: Implementazione del metodo `down()` in migrazioni che estendono `XotBaseMigration`.

**Soluzione**:
```php
// ❌ ERRATO
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    public function down(): void { /* ... */ } // ERRORE
};

// ✅ CORRETTO
return new class extends XotBaseMigration {
    public function up(): void { /* ... */ }
    // NIENTE metodo down()
};
```

## Comandi Utili

### Identificazione Conflitti
```bash
# Trova file con conflitti Git
git status --porcelain | grep "^UU\|^AA\|^DD"

# Lista file con conflitti per tipo
git diff --name-only --diff-filter=U
```

### Verifica PHPStan
```bash
# Verifica singolo file
./vendor/bin/phpstan analyse --level=10 path/to/file.php

# Verifica modulo completo
./vendor/bin/phpstan analyse --level=10 laravel/Modules/NomeModulo/
```

### Test Funzionali
```bash
# Test specifico per modulo
php artisan test --testsuite=NomeModulo

# Verifica autoload dopo modifiche
composer dump-autoload
```

## Best Practices Specifiche

### Moduli Laravel
- **Namespace**: Seguire il pattern `Modules\NomeModulo\...`
- **Service Provider**: Estendere sempre `XotBaseServiceProvider`
- **Models**: Estendere il BaseModel del modulo per centralizzare comportamenti
- **Resources Filament**: Estendere `XotBaseResource` invece di `Resource` direttamente

### Conflitti Tipici nei Moduli
1. **Service Provider**: Verificare registrazione route, view, traduzioni
2. **Composer.json**: Mantenere autoload PSR-4 corretto
3. **Models**: Controllare trait e relazioni
4. **Resources Filament**: Verificare estensione delle classi base corrette

## Collegamenti

- [Coding Standards](coding-standards.md)
- [Best Practices](best-practices.md)
- [PHPStan Guide](phpstan-consolidated.md)

---

*Ultimo aggiornamento: 2025-08-04*
*Modulo: Xot*
*Categoria: Migrazioni*
