# Gestione degli Errori nelle Blade di Autenticazione

## Introduzione

La gestione degli errori nelle blade di autenticazione deve seguire un pattern coerente che garantisca:
- Feedback immediato all'utente
- Logging appropriato per il debugging
- Sicurezza nella gestione delle informazioni sensibili

## Pattern di Gestione Errori

### 1. Try-Catch nei Metodi Volt

```php
public function action()
{
    try {
        // Logica principale
        $this->validate([...]);
        $result = $this->performAction();
        
        // Evento di successo
        Event::dispatch('auth.action.successful', [$result]);
        
        return redirect()->route('dashboard');
    } catch (ValidationException $e) {
        // Gestione errori di validazione
        $this->addError('field', $e->getMessage());
        return null;
    } catch (\Exception $e) {
        // Log dell'errore
        Log::error('Errore durante l\'azione: ' . $e->getMessage(), [
            'user_id' => auth()->id(),
            'action' => 'action_name',
            'trace' => $e->getTraceAsString()
        ]);
        
        // Notifica all'utente
        session()->flash('error', __('Si è verificato un errore. Riprova più tardi.'));
        return null;
    }
}
```

### 2. Gestione Errori di Validazione

```php
protected function getErrorBag()
{
    return $this->errorBag;
}

protected function addError($field, $message)
{
    $this->addError($field, $message);
    $this->dispatch('validation-error', [
        'field' => $field,
        'message' => $message
    ]);
}
```

### 3. Feedback Utente

```blade
<div>
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
</div>
```

## Best Practices

### 1. Logging
- Registrare sempre gli errori con contesto appropriato
- Utilizzare livelli di log appropriati (error, warning, info)
- Includere informazioni utili per il debugging

### 2. Sicurezza
- Non esporre dettagli tecnici degli errori
- Sanitizzare i messaggi di errore
- Proteggere informazioni sensibili nei log

### 3. UX
- Fornire feedback immediato
- Mantenere lo stato del form in caso di errore
- Offrire suggerimenti per la risoluzione

### 4. Performance
- Evitare log eccessivi
- Ottimizzare la gestione degli errori
- Implementare rate limiting per le azioni

## Esempi Specifici

### Login
```php
public function login()
{
    try {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            Event::dispatch('auth.login.successful', [auth()->user()]);
            return redirect()->intended(route('dashboard'));
        }
        
        Log::warning('Tentativo di login fallito', [
            'email' => $this->email,
            'ip' => request()->ip()
        ]);
        
        $this->addError('email', __('Credenziali non valide'));
    } catch (\Exception $e) {
        Log::error('Errore durante il login: ' . $e->getMessage());
        session()->flash('error', __('Si è verificato un errore durante il login'));
    }
}
```

### Register
```php
public function register()
{
    try {
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
        
        Event::dispatch('auth.register.successful', [$user]);
        Auth::login($user);
        
        return redirect()->route('dashboard');
    } catch (ValidationException $e) {
        foreach ($e->errors() as $field => $messages) {
            $this->addError($field, $messages[0]);
        }
    } catch (\Exception $e) {
        Log::error('Errore durante la registrazione: ' . $e->getMessage());
        session()->flash('error', __('Si è verificato un errore durante la registrazione'));
    }
}
```

## Collegamenti

- [Documentazione Volt](./VOLT_LOGOUT.md)
- [Best Practices Routing](./ROUTING_BEST_PRACTICES.md)
- [Struttura Directory](./DIRECTORY_STRUCTURE_CHECKLIST.md) 
