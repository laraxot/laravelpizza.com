# Struttura delle Blade di Autenticazione con Volt

## Introduzione

Le blade di autenticazione nel tema One devono seguire un pattern specifico che combina Volt, Folio e Livewire per garantire una gestione efficiente e sicura dell'autenticazione.

## Struttura Directory

```
laravel/Themes/One/resources/views/pages/auth/
├── login.blade.php
├── register.blade.php
├── logout.blade.php
├── verify.blade.php
├── password/
│   ├── reset.blade.php
│   ├── confirm.blade.php
│   └── email.blade.php
└── [type]/
    └── index.blade.php
```

## Pattern Comune

Ogni blade di autenticazione deve seguire questo pattern:

```blade
@volt
class [NomePagina]Page
{
    // Proprietà pubbliche per il binding
    public $property = '';
    
    // Metodi pubblici per le azioni
    public function action()
    {
        // Logica dell'azione
    }
    
    // Hook del ciclo di vita
    public function mount()
    {
        // Inizializzazione
    }
}
@endvolt

<x-layout>
    <x-slot:title>
        {{ __('Titolo Pagina') }}
    </x-slot>
    
    <!-- Contenuto -->
</x-layout>
```

## Best Practices

### 1. Gestione dello Stato
- Utilizzare proprietà pubbliche per il binding bidirezionale
- Implementare validazione lato client e server
- Gestire correttamente il ciclo di vita del componente

### 2. Sicurezza
- Implementare CSRF protection
- Validare tutti gli input
- Gestire correttamente le sessioni
- Utilizzare middleware di autenticazione

### 3. UX/UI
- Fornire feedback immediato
- Implementare gestione errori
- Mantenere coerenza visiva
- Supportare responsive design

### 4. Performance
- Minimizzare le chiamate al server
- Ottimizzare il rendering
- Implementare caching quando appropriato

## Esempi Specifici

### Login
```blade
@volt
class LoginPage
{
    public $email = '';
    public $password = '';
    public $remember = false;
    
    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect()->intended(route('dashboard'));
        }
        
        $this->addError('email', __('Credenziali non valide'));
    }
}
@endvolt
```

### Register
```blade
@volt
class RegisterPage
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    
    public function register()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);
        
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);
        
        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
@endvolt
```

### Logout
```blade
@volt
class LogoutPage
{
    public function mount()
    {
        try {
            Event::dispatch('auth.logout.attempting', [auth()->user()]);
            
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();
            
            Event::dispatch('auth.logout.successful');
            
            Log::info('Utente disconnesso', [
                'user_id' => auth()->id(),
                'timestamp' => now()
            ]);
            
            return redirect()->route('home');
        } catch (\Exception $e) {
            Log::error('Errore durante il logout: ' . $e->getMessage());
            session()->flash('error', __('Si è verificato un errore durante il logout'));
            return redirect()->back();
        }
    }
}
@endvolt
```

## Eventi e Logging

Ogni azione di autenticazione deve:
1. Emettere eventi appropriati
2. Registrare log per audit
3. Gestire errori in modo appropriato

## Collegamenti

- [Documentazione Volt](./VOLT_LOGOUT.md)
- [Best Practices Routing](./ROUTING_BEST_PRACTICES.md)
- [Struttura Directory](./DIRECTORY_STRUCTURE_CHECKLIST.md)
- [Gestione Errori](./ERROR_HANDLING.md) 
