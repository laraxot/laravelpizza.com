# Regole per le Chiavi di Traduzione

## Principi Fondamentali

1. **MAI utilizzare chiavi di traduzione in italiano** come `__('Accedi')` o `__('Registrati')`
2. **Utilizzare la struttura espansa per i campi** nei file di traduzione
3. **Seguire la convenzione di naming**: `modulo::risorsa.fields.campo.label`
4. **MAI utilizzare il metodo `->label()`** nei componenti Filament
5. **Le etichette sono gestite automaticamente** dal LangServiceProvider

## Esempi Corretti e Incorretti

### ❌ ERRATO:
```php
__('Accedi')
__('Registrati')
__('Esci')
```

### ✅ CORRETTO:
```php
__('auth.login.button.label')
__('auth.register.button.label')
__('auth.logout.button.label')
```

## Struttura dei File di Traduzione

```php
// auth.php
return [
    'login' => [
        'button' => [
            'label' => 'Login',
        ],
        'form' => [
            'email' => [
                'label' => 'Email Address',
                'placeholder' => 'Enter your email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Enter your password',
            ],
        ],
    ],
    'register' => [
        'button' => [
            'label' => 'Register',
        ],
        // altri campi...
    ],
];
```

## Vantaggi della Struttura Gerarchica

1. **Organizzazione**: Raggruppa logicamente le traduzioni per contesto
2. **Manutenibilità**: Facilita l'aggiunta di nuove traduzioni
3. **Coerenza**: Garantisce uno standard uniforme in tutto il progetto
4. **Riutilizzo**: Consente di riutilizzare componenti tra diverse parti dell'applicazione

## Implementazione in Filament

In Filament, NON utilizzare mai il metodo `->label()` nei componenti:

### ❌ ERRATO:
```php
Forms\Components\TextInput::make('email')
    ->label('Indirizzo Email')
```

### ✅ CORRETTO:
```php
Forms\Components\TextInput::make('email')
// Il label viene gestito automaticamente dal LangServiceProvider
```

## Documentazione Correlata

- [Traduzioni in Filament](../translations/filament.md)
- [Gestione delle Traduzioni](./translations.md)
- [LangServiceProvider](../../laravel/Modules/Lang/docs/LANG_SERVICE_PROVIDER.md)
