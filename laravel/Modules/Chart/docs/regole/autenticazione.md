# Regole per l'Autenticazione

## Configurazione Base
- L'URL dell'applicazione deve essere corretto nel file .env
- Il driver di autenticazione deve essere configurato correttamente
- Le tabelle necessarie devono essere create

## Configurazione .env
```env
APP_URL=http://<nome progetto>.local
AUTH_GUARD=web
AUTH_MODEL=Modules\User\Models\User
AUTH_PASSWORD_BROKER=users
AUTH_PASSWORD_RESET_TOKEN_TABLE=password_reset_tokens
```

## Tabelle Necessarie
1. users
2. password_reset_tokens
3. sessions (se si usa il driver database)

## Migrazioni
```php
// users table
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

// password_reset_tokens table
Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});

// sessions table (se necessario)
Schema::create('sessions', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->foreignId('user_id')->nullable()->index();
    $table->string('ip_address', 45)->nullable();
    $table->text('user_agent')->nullable();
    $table->text('payload');
    $table->integer('last_activity')->index();
});
```

## Validazione
- Verificare che tutte le tabelle necessarie esistano
- Controllare che il modello User sia configurato correttamente
- Assicurarsi che le route di autenticazione siano registrate
- Verificare che i middleware di autenticazione siano configurati 
## Collegamenti tra versioni di autenticazione.md
* [autenticazione.md](docs/regole/autenticazione.md)
* [autenticazione.md](docs/roadmap/core/autenticazione.md)
* [autenticazione.md](laravel/Modules/User/docs/roadmap/features/autenticazione.md)

