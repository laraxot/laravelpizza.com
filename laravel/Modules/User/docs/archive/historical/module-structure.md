# Struttura del Modulo User

## Panoramica

Il modulo User gestisce tutte le funzionalità relative agli utenti, inclusa l'autenticazione, la registrazione, la gestione del profilo e le autorizzazioni.

## Struttura delle Directory

```
User/
├── Config/
│   └── config.php
├── Console/
│   └── Commands/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
│   └── BaseUser.php
├── Resources/
│   ├── assets/
│   ├── lang/
│   │   ├── en/
│   │   └── it/
│   └── views/
├── Routes/
│   ├── api.php
│   └── web.php
├── Services/
├── Tests/
└── composer.json
```

## Componenti Principali

### 1. Models

- `BaseUser.php`: Il modello principale per la gestione degli utenti
  - Implementa l'autenticazione
  - Gestisce le relazioni
  - Definisce le autorizzazioni

### 2. Controllers

- `AuthController`: Gestisce l'autenticazione
- `ProfileController`: Gestisce il profilo utente
- `UserController`: Gestisce gli utenti (CRUD)

### 3. Middleware

- `Authenticate`: Verifica l'autenticazione
- `Authorize`: Gestisce le autorizzazioni
- `CheckRole`: Verifica i ruoli utente

### 4. Routes

```php
// web.php
Route::group(['middleware' => ['web']], function () {
    // Auth Routes
    Route::get('login', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->name('logout');

    // Profile Routes
    Route::get('profile', 'ProfileController@show')->name('profile');
    Route::put('profile', 'ProfileController@update')->name('profile.update');
});

// api.php
Route::group(['middleware' => ['api']], function () {
    Route::apiResource('users', 'UserController');
});
```

### 5. Views

- `auth/`: Viste per l'autenticazione
- `profile/`: Viste per il profilo
- `users/`: Viste per la gestione utenti

### 6. Language Files

- `auth.php`: Traduzioni per l'autenticazione
- `profile.php`: Traduzioni per il profilo
- `user.php`: Traduzioni per la gestione utenti

## Configurazione

```php
// config.php
return [
    'name' => 'User',
    'middleware' => ['web', 'api'],
    'prefix' => 'user',
    'namespace' => 'Modules\User\Http\Controllers',
];

# Struttura Standard dei Moduli Laravel

## Struttura Base Corretta
```
laravel/Modules/ModuleName/
├── app/                        # Codice principale dell'applicazione
│   ├── Actions/               # Action classes
│   ├── Http/                  # Controllers, Middleware, Requests
│   ├── Models/                # Model classes
│   ├── Providers/            # Service providers
│   └── Services/             # Service classes
├── config/                    # Configurazioni del modulo
├── database/                  # Migrations, seeds, factories
├── docs/                      # Documentazione del modulo
├── lang/                      # File di traduzione (non Lang!)
├── resources/                # Asset e viste (non Resources!)
│   ├── css/
│   ├── js/
│   └── views/
├── routes/                    # File di routing
└── tests/                     # Test del modulo
```

## ❌ Pattern Errati da Evitare
```
laravel/Modules/ModuleName/
├── Resources/                # ERRATO: R maiuscola
├── Lang/                     # ERRATO: L maiuscola
├── Actions/                  # ERRATO: dovrebbe essere in app/Actions
└── Http/                     # ERRATO: dovrebbe essere in app/Http
```

## ✅ Pattern Corretti
```
laravel/Modules/ModuleName/
├── resources/               # CORRETTO: r minuscola
├── lang/                    # CORRETTO: l minuscola
├── app/Actions/            # CORRETTO: sotto app/
└── app/Http/               # CORRETTO: sotto app/
```

## Regole Fondamentali

1. **Namespace PSR-4**
   ```php
   namespace Modules\ModuleName\App\Actions;  // CORRETTO
   namespace Modules\ModuleName\Actions;      // ERRATO
   ```

2. **Case Sensitivity**
   - Usare lowercase per cartelle standard Laravel
   - Mantenere PascalCase per classi e namespace

3. **Struttura app/**
   - Tutto il codice PHP va sotto `app/`
   - Eccezioni: routes/, config/, lang/, resources/

4. **Resources vs resources**
   - `resources/`: assets, views, lang (lowercase)
   - `Resources/`: MAI usare questa versione

5. **Lang vs lang**
   - `lang/`: file di traduzione (lowercase)
   - `Lang/`: MAI usare questa versione

## Esempi di Path Corretti

### Controllers
```php
// CORRETTO
Modules/User/app/Http/Controllers/

// ERRATO
Modules/User/Http/Controllers/
```

### Actions
```php
// CORRETTO
Modules/User/app/Actions/

// ERRATO
Modules/User/Actions/
```

### Views
```php
// CORRETTO
Modules/User/resources/views/

// ERRATO
Modules/User/Resources/views/
```

### Translations
```php
// CORRETTO
Modules/User/lang/it/

// ERRATO
Modules/User/Lang/it/
```

## Best Practices

1. **Autenticazione**
   - Utilizzare il middleware `auth` per le rotte protette
   - Implementare il logout in modo sicuro
   - Gestire correttamente le sessioni

2. **Autorizzazioni**
   - Utilizzare le policies per le autorizzazioni
   - Implementare i ruoli e i permessi
   - Verificare le autorizzazioni nei controller

3. **Validazione**
   - Utilizzare le form requests per la validazione
   - Implementare regole di validazione personalizzate
   - Gestire i messaggi di errore

4. **Testing**
   - Scrivere test per l'autenticazione
   - Testare le autorizzazioni
   - Verificare il funzionamento delle rotte

## Collegamenti Correlati

- [Best Practices per le Traduzioni](TRANSLATION_BEST_PRACTICES.md)
- [Regole per le Chiavi di Traduzione](TRANSLATION_KEYS_RULES.md)
- [Convenzioni di Codice](CODE_CONVENTIONS.md)
1. **Verifica Path**
   ```bash
   # Prima di creare un file/cartella, verifica sempre il path
   pwd
   tree -L 3 laravel/Modules/User/
   ```

2. **Namespace Check**
   ```php
   // Verifica sempre il namespace corrisponda al path
   namespace Modules\User\Http\Controllers;      // CORRETTO
   namespace Modules\User\App\Http\Controllers;  // ERRATO
   ```

3. **Case Sensitivity**
   ```bash
   # Usa sempre lowercase per le cartelle standard Laravel
   mkdir -p resources/views
   mkdir -p lang/it

   # NON usare mai
   mkdir -p Resources/views  # ERRATO
   mkdir -p Lang/it         # ERRATO
   ```

4. **Struttura Moduli**
   ```bash
   # Crea sempre la struttura base completa
   mkdir -p app/{Actions,Http,Models,Providers,Services}
   mkdir -p {config,database,docs,lang,resources,routes,tests}
   ```

## Checklist di Validazione

- [ ] Tutti i path usano lowercase per cartelle standard Laravel
- [ ] Tutto il codice PHP è sotto la cartella `app/`
- [ ] I namespace corrispondono alla struttura delle cartelle
- [ ] Non ci sono cartelle con iniziali maiuscole (Resources, Lang, etc.)
- [ ] Le traduzioni sono in `lang/` (lowercase)
- [ ] Le viste sono in `resources/views/` (lowercase)

## Note Importanti

1. La struttura dei moduli segue le convenzioni Laravel
2. Case sensitivity è fondamentale in Linux/Unix
3. Mantenere consistenza tra namespace e struttura cartelle
4. Evitare duplicazione di codice tra moduli
5. Seguire PSR-4 per l'autoloading

## Comandi Utili

```bash

# Verifica struttura cartelle
tree -L 3 laravel/Modules/User/

# Trova cartelle con nomi errati
find . -type d -name "Resources" -o -name "Lang"

# Correggi permessi
chmod -R 755 laravel/Modules/*/app/
chmod -R 644 laravel/Modules/*/resources/
```
# Struttura del Modulo User

## Panoramica

Il modulo User gestisce tutte le funzionalità relative agli utenti, inclusa l'autenticazione, la registrazione, la gestione del profilo e le autorizzazioni.

## Struttura delle Directory

```
User/
├── Config/
│   └── config.php
├── Console/
│   └── Commands/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   └── Requests/
├── Models/
│   └── BaseUser.php
├── Resources/
│   ├── assets/
│   ├── lang/
│   │   ├── en/
│   │   └── it/
│   └── views/
├── Routes/
│   ├── api.php
│   └── web.php
├── Services/
├── Tests/
└── composer.json
```

## Componenti Principali

### 1. Models

- `BaseUser.php`: Il modello principale per la gestione degli utenti
  - Implementa l'autenticazione
  - Gestisce le relazioni
  - Definisce le autorizzazioni

### 2. Controllers

- `AuthController`: Gestisce l'autenticazione
- `ProfileController`: Gestisce il profilo utente
- `UserController`: Gestisce gli utenti (CRUD)

### 3. Middleware

- `Authenticate`: Verifica l'autenticazione
- `Authorize`: Gestisce le autorizzazioni
- `CheckRole`: Verifica i ruoli utente

### 4. Routes

```php
// web.php
Route::group(['middleware' => ['web']], function () {
    // Auth Routes
    Route::get('login', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout')->name('logout');

    // Profile Routes
    Route::get('profile', 'ProfileController@show')->name('profile');
    Route::put('profile', 'ProfileController@update')->name('profile.update');
});

// api.php
Route::group(['middleware' => ['api']], function () {
    Route::apiResource('users', 'UserController');
});
```

### 5. Views

- `auth/`: Viste per l'autenticazione
- `profile/`: Viste per il profilo
- `users/`: Viste per la gestione utenti

### 6. Language Files

- `auth.php`: Traduzioni per l'autenticazione
- `profile.php`: Traduzioni per il profilo
- `user.php`: Traduzioni per la gestione utenti

## Configurazione

```php
// config.php
return [
    'name' => 'User',
    'middleware' => ['web', 'api'],
    'prefix' => 'user',
    'namespace' => 'Modules\User\Http\Controllers',
];

# Struttura Standard dei Moduli Laravel

## Struttura Base Corretta
```
laravel/Modules/ModuleName/
├── app/                        # Codice principale dell'applicazione
│   ├── Actions/               # Action classes
│   ├── Http/                  # Controllers, Middleware, Requests
│   ├── Models/                # Model classes
│   ├── Providers/            # Service providers
│   └── Services/             # Service classes
├── config/                    # Configurazioni del modulo
├── database/                  # Migrations, seeds, factories
├── docs/                      # Documentazione del modulo
├── lang/                      # File di traduzione (non Lang!)
├── resources/                # Asset e viste (non Resources!)
│   ├── css/
│   ├── js/
│   └── views/
├── routes/                    # File di routing
└── tests/                     # Test del modulo
```

## ❌ Pattern Errati da Evitare
```
laravel/Modules/ModuleName/
├── Resources/                # ERRATO: R maiuscola
├── Lang/                     # ERRATO: L maiuscola
├── Actions/                  # ERRATO: dovrebbe essere in app/Actions
└── Http/                     # ERRATO: dovrebbe essere in app/Http
```

## ✅ Pattern Corretti
```
laravel/Modules/ModuleName/
├── resources/               # CORRETTO: r minuscola
├── lang/                    # CORRETTO: l minuscola
├── app/Actions/            # CORRETTO: sotto app/
└── app/Http/               # CORRETTO: sotto app/
```

## Regole Fondamentali

1. **Namespace PSR-4**
   ```php
   namespace Modules\ModuleName\App\Actions;  // CORRETTO
   namespace Modules\ModuleName\Actions;      // ERRATO
   ```

2. **Case Sensitivity**
   - Usare lowercase per cartelle standard Laravel
   - Mantenere PascalCase per classi e namespace

3. **Struttura app/**
   - Tutto il codice PHP va sotto `app/`
   - Eccezioni: routes/, config/, lang/, resources/

4. **Resources vs resources**
   - `resources/`: assets, views, lang (lowercase)
   - `Resources/`: MAI usare questa versione

5. **Lang vs lang**
   - `lang/`: file di traduzione (lowercase)
   - `Lang/`: MAI usare questa versione

## Esempi di Path Corretti

### Controllers
```php
// CORRETTO
Modules/User/app/Http/Controllers/

// ERRATO
Modules/User/Http/Controllers/
```

### Actions
```php
// CORRETTO
Modules/User/app/Actions/

// ERRATO
Modules/User/Actions/
```

### Views
```php
// CORRETTO
Modules/User/resources/views/

// ERRATO
Modules/User/Resources/views/
```

### Translations
```php
// CORRETTO
Modules/User/lang/it/

// ERRATO
Modules/User/Lang/it/
```

## Best Practices

1. **Autenticazione**
   - Utilizzare il middleware `auth` per le rotte protette
   - Implementare il logout in modo sicuro
   - Gestire correttamente le sessioni

2. **Autorizzazioni**
   - Utilizzare le policies per le autorizzazioni
   - Implementare i ruoli e i permessi
   - Verificare le autorizzazioni nei controller

3. **Validazione**
   - Utilizzare le form requests per la validazione
   - Implementare regole di validazione personalizzate
   - Gestire i messaggi di errore

4. **Testing**
   - Scrivere test per l'autenticazione
   - Testare le autorizzazioni
   - Verificare il funzionamento delle rotte

## Collegamenti Correlati

- [Best Practices per le Traduzioni](TRANSLATION_BEST_PRACTICES.md)
- [Regole per le Chiavi di Traduzione](TRANSLATION_KEYS_RULES.md)
- [Convenzioni di Codice](CODE_CONVENTIONS.md)
1. **Verifica Path**
   ```bash
   # Prima di creare un file/cartella, verifica sempre il path
   pwd
   tree -L 3 laravel/Modules/User/
   ```

2. **Namespace Check**
   ```php
   // Verifica sempre il namespace corrisponda al path
   namespace Modules\User\App\Http\Controllers;  // CORRETTO
   namespace Modules\User\Http\Controllers;      // ERRATO
   ```

3. **Case Sensitivity**
   ```bash
   # Usa sempre lowercase per le cartelle standard Laravel
   mkdir -p resources/views
   mkdir -p lang/it

   # NON usare mai
   mkdir -p Resources/views  # ERRATO
   mkdir -p Lang/it         # ERRATO
   ```

4. **Struttura Moduli**
   ```bash
   # Crea sempre la struttura base completa
   mkdir -p app/{Actions,Http,Models,Providers,Services}
   mkdir -p {config,database,docs,lang,resources,routes,tests}
   ```

## Checklist di Validazione

- [ ] Tutti i path usano lowercase per cartelle standard Laravel
- [ ] Tutto il codice PHP è sotto la cartella `app/`
- [ ] I namespace corrispondono alla struttura delle cartelle
- [ ] Non ci sono cartelle con iniziali maiuscole (Resources, Lang, etc.)
- [ ] Le traduzioni sono in `lang/` (lowercase)
- [ ] Le viste sono in `resources/views/` (lowercase)

## Note Importanti

1. La struttura dei moduli segue le convenzioni Laravel
2. Case sensitivity è fondamentale in Linux/Unix
3. Mantenere consistenza tra namespace e struttura cartelle
4. Evitare duplicazione di codice tra moduli
5. Seguire PSR-4 per l'autoloading

## Comandi Utili

```bash

# Verifica struttura cartelle
tree -L 3 laravel/Modules/User/

# Trova cartelle con nomi errati
find . -type d -name "Resources" -o -name "Lang"

# Correggi permessi
chmod -R 755 laravel/Modules/*/app/
chmod -R 644 laravel/Modules/*/resources/
```
