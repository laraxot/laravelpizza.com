# Autenticazione in Predict

## Panoramica
Il sistema di autenticazione in Predict è basato su Laravel Volt e supporta sia l'autenticazione tradizionale che quella sociale.

## Configurazione

### Route
```php
// Route con prefisso lingua
Route::prefix('{lang}')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', 'Login')->name('login');
        Route::get('register', 'Register')->name('register');
    });
});

// Route di fallback
Route::middleware('guest')->group(function () {
    Route::get('login', 'Login')->name('login');
    Route::get('register', 'Register')->name('register');
});
```

### Socialite
```php
// Configurazione in config/services.php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

## Componenti

### LoginComponent
```php
class LoginComponent extends Component
{
    #[Validate('required|email')]
    public string $email = '';
    
    #[Validate('required')]
    public string $password = '';
    
    public bool $remember = false;

    public function authenticate(): RedirectResponse
    {
        $this->validate();
        
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));
            return back();
        }
        
        event(new Login('web', User::where('email', $this->email)->first(), $this->remember));
        
        return redirect()->intended('/');
    }
}
```

## Eventi e Listeners

### Login Event
- `LoginListener`: Gestisce la logica post-login
- `CheckLoginListener`: Verifica le condizioni di accesso

### Registered Event
- `ProfileRegisteredListener`: Inizializza il profilo utente

## Middleware

### Auth Middleware
Protegge le route che richiedono autenticazione:
```php
Route::middleware('auth')->group(function () {
    // Route protette
});
```

### Guest Middleware
Restringe l'accesso alle route pubbliche:
```php
Route::middleware('guest')->group(function () {
    // Route pubbliche
});
```

## Best Practices

1. **Sicurezza**
   - Utilizzare HTTPS per tutte le route di autenticazione
   - Implementare rate limiting per prevenire attacchi brute force
   - Validare tutti gli input utente

2. **UX**
   - Fornire feedback chiari per errori di login
   - Implementare remember me functionality
   - Supportare multiple opzioni di login

3. **Manutenzione**
   - Mantenere aggiornate le dipendenze di sicurezza
   - Monitorare i tentativi di login falliti
   - Implementare logging per debugging

## Troubleshooting

### Problemi Comuni

1. **Errori di Redirect**
   - Verificare la configurazione delle route
   - Controllare i middleware
   - Verificare la configurazione di Socialite

2. **Errori di Autenticazione**
   - Controllare le credenziali nel database
   - Verificare la configurazione del guard
   - Controllare i log per errori specifici

3. **Problemi di Sessione**
   - Verificare la configurazione della sessione
   - Controllare il middleware web
   - Verificare la configurazione del cookie 

## Implementazioni Specifiche

### Logout con Volt e Folio
Per dettagli sull'implementazione del logout utilizzando Volt e Folio, consultare la [documentazione del modulo User](../laravel/Modules/User/project_docs/VOLT_FOLIO_LOGOUT_ERROR.md). 
