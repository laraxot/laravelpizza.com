# Migrazioni

## Configurazione Base

### Database
```php
// config/database.php
'mysql' => [
    'driver' => 'mysql',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => null,
    'options' => extension_loaded('pdo_mysql') ? array_filter([
        PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
    ]) : [],
],
```

## Migrazioni Base

### Creazione Tabella
```php
// database/migrations/2024_01_01_000000_create_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
```

### Modifica Tabella
```php
// database/migrations/2024_01_01_000001_add_role_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
```

## Best Practices

### 1. Struttura
- Organizzare per dominio
- Utilizzare i nomi descrittivi
- Documentare le migrazioni
- Gestire le dipendenze

### 2. Performance
- Ottimizzare le query
- Utilizzare gli indici
- Implementare il caching
- Monitorare le migrazioni

### 3. Sicurezza
- Validare i dati
- Proteggere le migrazioni
- Implementare il logging
- Gestire i fallimenti

### 4. Manutenzione
- Monitorare le migrazioni
- Gestire le versioni
- Implementare alerting
- Documentare le migrazioni

## Esempi di Utilizzo

### Migrazione con Relazioni
```php
// database/migrations/2024_01_01_000002_create_posts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
```

### Migrazione con Indici
```php
// database/migrations/2024_01_01_000003_create_comments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->timestamps();

            $table->index(['user_id', 'post_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
```

## Strumenti Utili

### Comandi Artisan
```bash
# Creare una migrazione
php artisan make:migration create_users_table

# Eseguire le migrazioni
php artisan migrate

# Rollback dell'ultima migrazione
php artisan migrate:rollback

# Rollback di tutte le migrazioni
php artisan migrate:reset

# Refresh di tutte le migrazioni
php artisan migrate:refresh
```

### Schema Builder
```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::table('users', function (Blueprint $table) {
    // Aggiungere una colonna
    $table->string('phone')->nullable();

    // Modificare una colonna
    $table->string('name', 100)->change();

    // Rinominare una colonna
    $table->renameColumn('name', 'first_name');

    // Eliminare una colonna
    $table->dropColumn('phone');
});
```

## Gestione degli Errori

### Errori di Migrazione
```php
try {
    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
    });
} catch (\Exception $e) {
    Log::error('Errore nella migrazione', [
        'migration' => 'create_users_table',
        'error' => $e->getMessage(),
    ]);
    
    throw $e;
}
```

### Logging
```php
use Illuminate\Support\Facades\Log;

public function up()
{
    Log::info('Inizio migrazione', [
        'migration' => 'create_users_table',
    ]);

    Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
    });

    Log::info('Migrazione completata', [
        'migration' => 'create_users_table',
    ]);
}
```

## Migrazioni Avanzate

### Migrazione con Soft Delete
```php
// database/migrations/2024_01_01_000004_add_soft_deletes_to_posts_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
```

### Migrazione con Polimorfismo
```php
// database/migrations/2024_01_01_000005_create_comments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('commentable');
            $table->text('content');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
``` 