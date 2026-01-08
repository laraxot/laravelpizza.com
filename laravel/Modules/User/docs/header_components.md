# Componenti Header

## Struttura e Convenzioni

### 1. Posizione dei Componenti
```laravel/Themes/One/resources/views/components/blocks/
├── navigation/
│   ├── language-switcher.blade.php    # Selettore lingua
│   ├── user-dropdown.blade.php        # Dropdown utente
│   └── avatar.blade.php              # Componente avatar
```

### 2. Convenzioni di Naming
- I componenti devono seguire il pattern `kebab-case`
- I nomi dei file devono essere descrittivi e in inglese
- I componenti devono essere autocontenuti e riutilizzabili

### 3. Struttura Componenti

#### Language Switcher
```blade
<x-navigation.language-switcher>
    <!-- Contenuto del selettore lingua -->
</x-navigation.language-switcher>
```

#### User Dropdown
```blade
<x-navigation.user-dropdown>
    <!-- Contenuto del dropdown utente -->
</x-navigation.user-dropdown>
```

#### Avatar
```blade
<x-navigation.avatar>
    <!-- Contenuto dell'avatar -->
</x-navigation.avatar>
```

### 4. Integrazione con Filament
- Utilizzare i componenti Filament quando appropriato
- Mantenere la coerenza con il design system di Filament
- Utilizzare le classi di stile di Filament

### 5. Gestione Stati
- Gestire gli stati di autenticazione
- Gestire la lingua corrente
- Gestire il tema (chiaro/scuro)

### 6. Best Practices
- Mantenere i componenti leggeri e performanti
- Utilizzare lazy loading per le immagini
- Implementare caching appropriato
- Gestire correttamente le traduzioni

### 7. Eventi e Logging
- Loggare i cambi di lingua
- Loggare le azioni dell'utente
- Implementare analytics appropriati

### 8. Sicurezza
- Validare i dati in input
- Proteggere le rotte di autenticazione
- Gestire correttamente i token CSRF

## Implementazione

### 1. Language Switcher
- Mostrare le lingue disponibili
- Mantenere la lingua corrente
- Gestire il cambio di lingua
- Persistenza della scelta

### 2. User Dropdown
- Mostrare informazioni utente
- Link al profilo
- Opzioni di amministrazione
- Logout

### 3. Avatar
- Mostrare l'immagine profilo
- Fallback per utenti senza avatar
- Gestione upload avatar
- Cache delle immagini

## Collegamenti Correlati
- [Documentazione Filament](https://filamentphp.com/docs)
- [Best Practices di Sicurezza](./SECURITY_BEST_PRACTICES.md)
- [Gestione Sessione](./SESSION_MANAGEMENT.md) 
