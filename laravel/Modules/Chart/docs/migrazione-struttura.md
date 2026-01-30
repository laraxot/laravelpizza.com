# Migrazione della Struttura del Progetto il progetto

## Spostamento della Directory Laravel

Se l'installazione Laravel esiste già in una posizione errata, è possibile spostarla nella posizione corretta con un semplice comando:

```bash

# Spostare l'installazione Laravel dalla posizione errata a quella corretta
mv /var/www/html/<nome progetto>/public_html/laravel /var/www/html/<nome progetto>/laravel
```

Questo approccio è preferibile rispetto alla reinstallazione completa, in quanto:
- Preserva tutte le personalizzazioni già implementate
- Risparmia tempo e risorse
- Evita potenziali errori di configurazione
- Mantiene tutte le dipendenze già installate

## Struttura Corretta delle Directory

```
/var/www/html/<nome progetto>/
├── docs/                     # Documentazione del progetto
├── laravel/                  # Installazione Laravel (posizione corretta)
│   ├── app/                  # Core application code
│   ├── bootstrap/            # Framework bootstrap files
│   ├── config/               # Configuration files
│   ├── database/             # Database migrations and seeds
│   ├── Modules/              # Moduli Laravel installati
│   └── ...                   # Altri file e directory Laravel
└── .cursor/                  # Configurazioni IDE
    └── rules/                # Regole per l'ambiente di sviluppo
```

## Aggiornamento Configurazioni

Dopo lo spostamento, potrebbe essere necessario aggiornare alcuni percorsi di file nelle configurazioni Laravel:

1. Verificare il file `.env` per eventuali percorsi assoluti
2. Aggiornare eventuali riferimenti nei file di configurazione
3. Aggiornare eventuali script di deployment

## Verifica Funzionamento

Per verificare che tutto funzioni correttamente dopo lo spostamento:

```bash
cd /var/www/html/<nome progetto>/laravel
php artisan serve
```

Questo dovrebbe avviare il server di sviluppo Laravel senza errori se la migrazione ha avuto successo.

# Gestione Migrazioni nei Moduli

## Struttura delle Migrazioni

### 1. Organizzazione
- Tutte le migrazioni sono contenute all'interno dei rispettivi moduli
- La struttura standard è:
```
laravel/Modules/[NomeModulo]/
└── Database/
    └── Migrations/
        ├── 2024_03_28_000001_create_table_name.php
        └── 2024_03_28_000002_add_column_to_table.php
```

### 2. Convenzioni di Nomenclatura
- Nome file: `YYYY_MM_DD_HHMMSS_description.php`
- Nome classe: `CreateTableNameTable` o `AddColumnToTableNameTable`
- Nome tabella: `module_name_table_name`

### 3. Best Practices
- Ogni modifica al database deve avere una migrazione
- Le migrazioni devono essere atomiche e indipendenti
- Includere sempre il rollback delle modifiche
- Documentare le dipendenze tra migrazioni
- Utilizzare foreign keys per le relazioni

## Processo di Migrazione

### 1. Preparazione
```bash

# Rimuovere le migrazioni centrali per evitare conflitti
rm -rf database/migrations

# Verificare lo stato delle migrazioni
php artisan migrate:status
```

### 2. Esecuzione
```bash

# Eseguire tutte le migrazioni
php artisan migrate

# Se necessario, forzare la migrazione
php artisan migrate --force
```

### 3. Rollback
```bash

# Annullare l'ultima migrazione
php artisan migrate:rollback

# Annullare tutte le migrazioni
php artisan migrate:reset

# Annullare e rieseguire tutte le migrazioni
php artisan migrate:refresh
```

## Gestione Moduli

### 1. Installazione Nuovo Modulo
```bash

# 1. Aggiungere il modulo con git subtree
git subtree add --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev

# 2. Rimuovere migrazioni centrali
rm -rf database/migrations

# 3. Eseguire le migrazioni
php artisan migrate
```

### 2. Aggiornamento Modulo
```bash

# 1. Aggiornare il modulo
git subtree pull --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev

# 2. Rimuovere migrazioni centrali
rm -rf database/migrations

# 3. Eseguire le migrazioni
php artisan migrate
```

### 3. Rimozione Modulo
```bash

# 1. Rimuovere il modulo
git subtree remove --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev

# 2. Rimuovere migrazioni centrali
rm -rf database/migrations

# 3. Eseguire le migrazioni
php artisan migrate
```

## Risoluzione Problemi

### 1. Conflitti di Migrazione
```bash

# Se ci sono conflitti durante l'aggiornamento
git subtree pull --prefix laravel/Modules/[NomeModulo] git@github.com:laraxot/module_[nome]_fila3.git dev --squash

# Risolvere i conflitti manualmente

# Poi eseguire
rm -rf database/migrations
php artisan migrate
```

### 2. Migrazioni Mancanti
```bash

# Verificare lo stato
php artisan migrate:status

# Se necessario, forzare la migrazione
php artisan migrate --force
```

### 3. Rollback Parziale
```bash

# Annullare le migrazioni di un modulo specifico
php artisan migrate:rollback --path=laravel/Modules/[NomeModulo]/Database/Migrations
```

## Note Importanti

### 1. Perché Rimuovere database/migrations?
- Evita conflitti con le migrazioni dei moduli
- Mantiene una struttura pulita e organizzata
- Permette una gestione indipendente delle migrazioni per modulo
- Facilita il rollback e l'aggiornamento dei moduli

### 2. Ordine di Esecuzione
- Le migrazioni vengono eseguite in ordine alfabetico
- Usare prefissi numerici per controllare l'ordine
- Considerare le dipendenze tra moduli

### 3. Backup
- Eseguire backup prima di ogni operazione di migrazione
- Verificare l'integrità dei dati dopo la migrazione
- Mantenere un log delle migrazioni eseguite

### 4. Testing
- Testare le migrazioni in ambiente di sviluppo
- Verificare il rollback funziona correttamente
- Testare le dipendenze tra moduli

## Esempi Pratici

### 1. Creazione Nuova Tabella
```php
// laravel/Modules/Patient/Database/Migrations/2024_03_28_000001_create_patients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
```

### 2. Modifica Tabella Esistente
```php
// laravel/Modules/Patient/Database/Migrations/2024_03_28_000002_add_phone_to_patients_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
```

### 3. Relazioni tra Moduli
```php
// laravel/Modules/Dental/Database/Migrations/2024_03_28_000001_create_visits_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->dateTime('visit_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
```

## Collegamenti tra versioni di migrazione-struttura.md
* [migrazione-struttura.md](docs/migrazione-struttura.md)
* [migrazione-struttura.md](docs/tecnico/struttura/migrazione-struttura.md)

