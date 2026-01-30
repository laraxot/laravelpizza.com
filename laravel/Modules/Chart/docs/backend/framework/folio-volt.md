# Folio e Volt

## Prerequisiti
- Laravel 12.x
- PHP 8.2+
- Livewire 3.x

## Folio - Routing Automatico

### Struttura
```
resources/views/pages/
├── auth/
│   ├── login.blade.php     -> /auth/login
│   └── register.blade.php  -> /auth/register
└── dashboard.blade.php     -> /dashboard
```

### Convenzioni
1. **File e Cartelle**:
   - Tutto in lowercase
   - Usare `-` per separare parole
   - Estensione `.blade.php`

2. **URL Generation**:
   - `/pages/auth/login.blade.php` → `/auth/login`
   - `/pages/dashboard.blade.php` → `/dashboard`
   - `/pages/users/[id].blade.php` → `/users/{id}`

3. **Parametri Dinamici**:
   ```php
   // pages/users/[id].blade.php
   <?php
   use function Livewire\Volt\{state, mount};
   
   state(['user' => null]);
   
   mount(function ($id) {
       $this->user = User::findOrFail($id);
   });
   ?>
   ```

## Volt - Componenti

### Struttura
```
resources/views/components/
├── forms/
│   ├── login.blade.php
│   └── register.blade.php
└── ui/
    ├── button.blade.php
    └── card.blade.php
```

### Convenzioni
1. **Naming**:
   ```php
   // Componente
   <x-module::forms.login />
   
   // Con Props
   <x-module::forms.login 
       :email="$email"
       :remember="true" 
   />
   ```

2. **State Management**:
   ```php
   <?php
   use function Livewire\Volt\{state, computed, mount};
   
   // State
   state([
       'email' => '',
       'password' => '',
       'remember' => false
   ]);
   
   // Computed
   computed(function () {
       return !empty($this->email) && !empty($this->password);
   })->isValid;
   
   // Methods
   $login = function () {
       $this->validate([
           'email' => 'required|email',
           'password' => 'required'
       ]);
       
       // Login logic
   };
   ?>
   ```

3. **Lifecycle Hooks**:
   ```php
   mount(function ($user = null) {
       if ($user) {
           $this->email = $user->email;
       }
   });
   
   updating('email', function ($value) {
       $this->validateOnly('email');
   });
   ```

## Best Practices

### 1. Folio
- Organizzare le pagine in modo logico
- Usare parametri dinamici con cautela
- Documentare le route complesse
- Mantenere la struttura piatta quando possibile

### 2. Volt
- Componenti piccoli e riutilizzabili
- Stato minimo necessario
- Validazione lato client e server
- Documentare props e eventi

### 3. Performance
- Lazy Loading quando necessario
- Caching appropriato
- Ottimizzazione delle query
- Minimizzare le richieste AJAX

## Esempi Completi

### Folio Page
```php
// pages/auth/login.blade.php
<?php
use function Livewire\Volt\{state, computed};

state([
    'email' => '',
    'password' => '',
    'remember' => false,
    'error' => null
]);

computed(function () {
    return !empty($this->email) && !empty($this->password);
})->isValid;

$login = function () {
    $this->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    try {
        Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember);
        
        return redirect()->intended('/dashboard');
    } catch (\Exception $e) {
        $this->error = 'Invalid credentials';
    }
};
?>

<x-layouts.auth>
    <x-forms.login 
        :email="$email"
        :password="$password"
        :remember="$remember"
        :error="$error"
        wire:submit="login"
    />
</x-layouts.auth>
```

### Volt Component
```php
// components/forms/login.blade.php
<?php
use function Livewire\Volt\{state, computed, mount};

state([
    'email' => '',
    'password' => '',
    'remember' => false
]);

computed(function () {
    return !empty($this->email) && !empty($this->password);
})->isValid;

$submit = function () {
    $this->dispatch('login', [
        'email' => $this->email,
        'password' => $this->password,
        'remember' => $this->remember
    ]);
};
?>

<form wire:submit="submit">
    <x-input 
        wire:model="email"
        type="email"
        label="Email"
    />
    
    <x-input 
        wire:model="password"
        type="password"
        label="Password"
    />
    
    <x-checkbox
        wire:model="remember"
        label="Remember me"
    />
    
    <x-button
        type="submit"
        :disabled="!$this->isValid"
    >
        Login
    </x-button>
</form>
```

## Troubleshooting

### Common Issues
1. **Route Not Found**
   - Verificare la struttura delle cartelle
   - Controllare il nome del file
   - Verificare i parametri dinamici

2. **Component Not Found**
   - Verificare il namespace
   - Controllare l'autoloading
   - Verificare la struttura delle cartelle

3. **State Not Updating**
   - Verificare il wire:model
   - Controllare la definizione dello state
   - Verificare gli eventi Livewire

## Collegamenti
- [Struttura Base](../laravel/Modules/Xot/docs/STRUCTURE.md)
- [Convenzioni di Routing](../laravel/Modules/Xot/docs/routing-conventions.md)
- [Convenzioni di Namespace](../laravel/Modules/Xot/docs/namespace-conventions.md)
- [Documentazione Livewire](LIVEWIRE.md) 