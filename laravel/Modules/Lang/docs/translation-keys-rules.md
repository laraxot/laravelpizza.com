# Regole per le Chiavi di Traduzione 

## Collegamenti correlati
- [Documentazione centrale](./README.md)
- [Collegamenti documentazione](./collegamenti-documentazione.md)
- [Implementazione Auth Pages](../../User/docs/AUTH_PAGES_IMPLEMENTATION.md)
- [Regole Traduzioni User](../../User/docs/TRANSLATION_KEYS_RULES.md)
- [Documentazione Lang](./README.md)

## Regole Fondamentali per le Traduzioni

### 1. Struttura delle Chiavi di Traduzione

Le chiavi di traduzione  devono seguire una struttura gerarchica espansa:

```php
// Corretto
'auth' => [
    'login' => [
        'button' => [
            'label' => 'Login',
        ],
    ],
],

// Errato
'auth.login.button.label' => 'Login',
```

### 2. Convenzioni di Naming

Le chiavi di traduzione devono seguire il formato:
```
modulo::risorsa.fields.campo.label
```

Esempi:
- `user::auth.login.button.label`
- `dental::appointment.fields.date.label`
- `cms::page.fields.title.label`

### 3. Divieto di Chiavi in Italiano

**MAI utilizzare chiavi di traduzione in italiano**:

```php
// Errato
__('Accedi')
__('Registrati')
__('Esci')

// Corretto
__('auth.login.button.label')
__('auth.register.button.label')
__('auth.logout.button.label')
```

### 4. Divieto di Utilizzo del Metodo `->label()`

**MAI utilizzare il metodo `->label()` nei componenti Filament**:

```php
// Errato
TextInput::make('name')
    ->label('Nome')

// Corretto
TextInput::make('name')
// Il label viene gestito automaticamente dal LangServiceProvider
```

### 5. Gestione Automatica delle Etichette

Le etichette sono gestite automaticamente dal `LangServiceProvider` utilizzando la convenzione:

```
modulo::risorsa.fields.campo.label
```

### 6. Organizzazione dei File di Traduzione

I file di traduzione devono essere organizzati per modulo e risorsa:

```
/Modules/Lang/resources/lang/
├── it/
│   ├── auth.php
│   ├── user.php
│   ├── dental.php
│   └── ...
└── en/
    ├── auth.php
    ├── user.php
    ├── dental.php
    └── ...
```

### 7. Struttura dei File di Traduzione

Ogni file di traduzione deve seguire una struttura gerarchica coerente:

```php
// auth.php
return [
    'login' => [
        'title' => [
            'label' => 'Accedi',
        ],
        'button' => [
            'label' => 'Accedi',
        ],
        'fields' => [
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Inserisci la tua email',
            ],
            'password' => [
                'label' => 'Password',
                'placeholder' => 'Inserisci la tua password',
            ],
        ],
    ],
    // ...
];
```

## Esempi di Implementazione Corretta

### 1. Nei Template Blade

```blade
<h1>{{ __('auth.login.title.label') }}</h1>

<form>
    <label>{{ __('auth.login.fields.email.label') }}</label>
    <input type="email" placeholder="{{ __('auth.login.fields.email.placeholder') }}">
    
    <label>{{ __('auth.login.fields.password.label') }}</label>
    <input type="password" placeholder="{{ __('auth.login.fields.password.placeholder') }}">
    
    <button type="submit">{{ __('auth.login.button.label') }}</button>
</form>
```

### 2. Nei Componenti Filament

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Actions\Action;

// Definizione dei campi
public function getFormSchema(): array
{
    return [
        'email' => TextInput::make('email')
            ->email()
            ->required(),
        'password' => TextInput::make('password')
            ->password()
            ->required(),
    ];
}

// Definizione delle azioni
protected function getFormActions(): array
{
    return [
        Action::make('login')
            ->label(__('auth.login.button.label'))
            ->submit('login'),
    ];
}
```

## Vantaggi dell'Approccio Corretto

1. **Coerenza**: Garantisce una terminologia coerente in tutta l'applicazione
2. **Manutenibilità**: Facilita l'aggiornamento e la gestione delle traduzioni
3. **Internazionalizzazione**: Semplifica l'aggiunta di nuove lingue
4. **Automazione**: Consente l'estrazione automatica delle chiavi di traduzione
5. **Riutilizzabilità**: Le traduzioni possono essere riutilizzate in diversi contesti

## Strumenti di Supporto

### 1. Estrazione Automatica delle Chiavi

 include strumenti per l'estrazione automatica delle chiavi di traduzione:

```bash
php artisan lang:extract
```

### 2. Verifica delle Traduzioni Mancanti

Strumento per verificare le traduzioni mancanti:

```bash
php artisan lang:missing
```

### 3. Sincronizzazione delle Traduzioni

Strumento per sincronizzare le traduzioni tra le diverse lingue:

```bash
php artisan lang:sync
```

## Conclusione

Seguire queste regole per le chiavi di traduzione è fondamentale per garantire la coerenza, la manutenibilità e l'internazionalizzazione dell'applicazione . L'utilizzo di chiavi standardizzate e strutturate gerarchicamente facilita la gestione delle traduzioni e migliora la qualità complessiva del codice.

## [2024-07-07] Nota storica: correzione massiva Notify

- Sono state applicate correzioni strutturali alle traduzioni del modulo Notify per allineamento a queste regole.
- Vedi anche: [TRANSLATION_KEYS_RULES.md](../../../Notify/docs/TRANSLATION_KEYS_RULES.md) per dettagli, esempi e best practice specifiche.
- Ogni nuova regola o convenzione va riportata sia qui che nella documentazione del modulo coinvolto.
