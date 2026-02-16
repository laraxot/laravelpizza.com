# Regole per le Chiavi di Traduzione

## Principi Fondamentali

1. **Chiavi in Inglese**
   - Le chiavi di traduzione DEVONO essere sempre in inglese
   - Esempio corretto: `__('login')` invece di `__('Accedi')`
   - Le traduzioni effettive vengono gestite nei file di lingua

2. **Struttura delle Chiavi**
   - Utilizzare il formato `namespace.key` per chiavi complesse
   - Esempio: `auth.login` per la pagina di login
   - Mantenere una gerarchia logica e coerente

3. **File di Traduzione**
   - Posizione: `lang/{locale}/`
   - Struttura nidificata per organizzare le traduzioni
   - Esempio:
     ```php
     // lang/it/auth.php
     return [
         'login' => 'Accedi',
         'register' => 'Registrati'
     ];
     ```

4. **Convenzioni di Naming**
   - Utilizzare nomi descrittivi ma concisi
   - Evitare spazi e caratteri speciali
   - Mantenere la coerenza tra i file di traduzione

5. **Gestione dei Namespace**
   - Raggruppare le traduzioni per modulo/funzionalità
   - Esempio:
     ```php
     // lang/it/user.php
     return [
         'profile' => [
             'title' => 'Profilo',
             'edit' => 'Modifica Profilo'
         ]
     ];
     ```

## Implementazione

### 1. Definizione delle Chiavi

```php
// Corretto
__('auth.login')
__('auth.register')
__('user.profile.title')

// Non Corretto
__('Accedi')
__('Registrati')
__('Profilo')
```

### 2. File di Traduzione

```php
// lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci'
];

// lang/en/auth.php
return [
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout'
];
```

### 3. Utilizzo nei Componenti

```blade
{{-- Corretto --}}
<a href="{{ route('login') }}">{{ __('auth.login') }}</a>
<a href="{{ route('register') }}">{{ __('auth.register') }}</a>

{{-- Non Corretto --}}
<a href="{{ route('login') }}">{{ __('Accedi') }}</a>
<a href="{{ route('register') }}">{{ __('Registrati') }}</a>
```

## Best Practices Aggiuntive

1. **Validazione**
   - Verificare l'esistenza delle chiavi di traduzione
   - Utilizzare strumenti di validazione automatica
   - Mantenere una lista di tutte le chiavi utilizzate

2. **Manutenzione**
   - Aggiornare regolarmente i file di traduzione
   - Rimuovere le chiavi non utilizzate
   - Documentare le nuove chiavi aggiunte

3. **Performance**
   - Utilizzare il caching delle traduzioni
   - Minimizzare le chiamate di traduzione
   - Ottimizzare la struttura dei file

4. **Testing**
   - Verificare la presenza di tutte le traduzioni
   - Testare con diverse lingue
   - Validare la coerenza delle traduzioni

## Collegamenti Correlati

- [Best Practices per le Traduzioni](TRANSLATION_BEST_PRACTICES.md)
- [Struttura del Modulo](MODULE_STRUCTURE.md)
- [Convenzioni di Codice](CODE_CONVENTIONS.md)
