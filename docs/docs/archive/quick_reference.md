# Guida Rapida alle Traduzioni

## Struttura Base

```
lang/
├── it/                 # Traduzioni in italiano
│   ├── auth.php        # Testi di autenticazione
│   ├── validation.php  # Messaggi di validazione
│   └── modules/        # Moduli personalizzati
│       ├── patient.php
│       └── doctor.php
└── en/                 # Traduzioni in inglese
    └── ...
```

## Utilizzo Base

### Nei File Blade
```blade
{{ __('Benvenuto, :name', ['name' => $user->name]) }}

{{ __('patient.profile.title') }}
```

### Nei Controller/Classi PHP
```php
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

// Impostare la lingua
App::setLocale('it');

// Ottenere una traduzione
$welcome = __('Benvenuto');
$welcome = Lang::get('messages.welcome');

// Con parametri
$message = __('Ciao :name', ['name' => 'Mario']);
```

## Formato delle Chiavi

### Struttura Consigliata
- Usare la notazione puntata per le gerarchie
- Prefissare con il nome del modulo
- Usare snake_case per le chiavi

Esempio:
```php
// patient.php
return [
    'profile' => [
        'title' => 'Profilo Paziente',
        'personal_data' => 'Dati Personali',
    ]
];

// Nel codice
__('patient.profile.title')
```

## Best Practice

1. **Non concatenare stringhe**
   ```php
   // Sbagliato
   echo __('Nome: ') . $user->name;
   
   // Corretto
   echo __('Nome: :name', ['name' => $user->name]);
   ```

2. **Usare le chiavi in inglese**
   ```php
   // Sconsigliato
   __('nome_campo_obbligatorio')
   
   // Consigliato
   __('validation.required')
   ```

3. **Validare le traduzioni**
   ```bash
   # Verifica traduzioni mancanti
   php artisan translation:check
   ```

## Comandi Utili

```bash
# Pubblicare file di lingua
php artisan lang:publish

# Cercare traduzioni mancanti
php artisan translation:show-missing

# Estrai stringhe traducibili
php artisan translation:extract

# Pulire la cache delle traduzioni
php artisan view:clear
php artisan config:clear
```

## Esempi Avanzati

### Pluralizzazione
```php
// resources/lang/en/messages.php
return [
    'apples' => '{0} Nessuna mela|{1} Una mela|[2,*] :count mele',
];

// Nel codice
echo trans_choice('messages.apples', 0); // Nessuna mela
echo trans_choice('messages.apples', 1); // Una mela
echo trans_choice('messages.apples', 5, ['count' => 5]); // 5 mele
```

### Override delle Traduzioni
Per sovrascrivere le traduzioni di un pacchetto, pubblicare le traduzioni:

```bash
php artisan vendor:publish --tag=laravel-translations
```

Poi modificare i file in `lang/vendor/{package}/{locale}/`.

## Console Commands
- **Console Commands**: Non registrarli mai manualmente, sono autoregistrati da XotBaseServiceProvider ([vedi](./lang-service-provider.md), [filosofia](./PHILOSOPHY.md))
