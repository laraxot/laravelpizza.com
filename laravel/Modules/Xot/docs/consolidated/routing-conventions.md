# Convenzioni di Routing

## Struttura Base

```
Modules\[NomeModulo]\
    └── resources\
        └── views\
            ├── pages\        # Folio - routing automatico
            │   ├── auth\
            │   │   ├── login.blade.php
            │   │   └── register.blade.php
            │   └── dashboard.blade.php
            └── components\   # Volt - componenti riutilizzabili
                ├── forms\
                │   ├── login.blade.php
                │   └── register.blade.php
                └── cards\
                    └── user.blade.php
```

## Regole Principali

1. **Routing Folio**:
   - Tutte le pagine in `resources/views/pages/`
   - Nomi file e cartelle in lowercase
   - Routing automatico basato sulla struttura cartelle
   - No route manuali in `routes/web.php`

2. **Componenti Volt**:
   - Tutti i componenti in `resources/views/components/`
   - Nomi file e cartelle in lowercase
   - Namespace basato sulla struttura cartelle

3. **API Routes**:
   - Tutte le route API in `routes/api.php`
   - Prefisso automatico basato sul nome modulo
   - Versionamento API opzionale

## Best Practices

1. **Organizzazione**:
   ```php
   // Folio - routing automatico
   /pages/auth/login.blade.php -> /auth/login
   /pages/dashboard.blade.php -> /dashboard
   
   // Volt - componenti
   <x-user::forms.login />
   <x-user::cards.user :user="$user" />
   ```

2. **Middleware**:
   - Usare middleware a livello di modulo
   - Documentare middleware custom
   - Mantenere coerenza tra moduli

3. **Documentazione**:
   - Documentare route non standard
   - Aggiornare README.md con route principali
   - Mantenere coerenza tra moduli

## Esempi

### Corretto
```php
// Folio - routing automatico
/pages/auth/login.blade.php -> /auth/login

// Volt - componenti
<x-user::forms.login />
```

### Errato
```php
// ❌ Route manuale
Route::get('/auth/login', [AuthController::class, 'login']);

// ❌ Componente senza namespace
<x-login />
```

## Note Importanti
- Sfruttare il routing automatico di Folio
- Usare namespace per i componenti Volt
- Documentare eccezioni
- Aggiornare moduli esistenti 