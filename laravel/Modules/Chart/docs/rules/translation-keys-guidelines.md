# Linee Guida per le Chiavi di Traduzione in <nome progetto>

## Collegamenti correlati
- [Documentazione centrale](/docs/README.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)
- [Regole Traduzioni User](/laravel/Modules/User/docs/TRANSLATION_KEYS_RULES.md)
- [Regole Traduzioni Lang](/laravel/Modules/Lang/docs/TRANSLATION_KEYS_RULES.md)
- [Implementazione Auth Pages](/laravel/Modules/User/docs/AUTH_PAGES_IMPLEMENTATION.md)

## Errore Comune da Evitare

Un errore comune nell'implementazione delle traduzioni in <nome progetto> è l'utilizzo di chiavi di traduzione in italiano direttamente nel codice:

```php
// ERRATO
__('Accedi')
__('Registrati')
__('Esci')
```

Questo approccio è problematico per diversi motivi:
1. Rende difficile la manutenzione e l'aggiornamento delle traduzioni
2. Complica l'internazionalizzazione dell'applicazione
3. Non segue le convenzioni di <nome progetto> per le traduzioni
4. Rende impossibile l'estrazione automatica delle chiavi di traduzione

## Regole Fondamentali

### 1. Utilizzare Chiavi di Traduzione Standardizzate

```php
// CORRETTO
__('auth.login.button.label')
__('auth.register.button.label')
__('auth.logout.button.label')
```

### 2. Struttura Gerarchica delle Chiavi

Le chiavi di traduzione devono seguire una struttura gerarchica che riflette la struttura dell'applicazione:

```
modulo::risorsa.fields.campo.label
```

### 3. Definizione nei File di Traduzione

I file di traduzione devono essere organizzati per modulo e risorsa, con una struttura gerarchica:

```php
// auth.php
return [
    'login' => [
        'button' => [
            'label' => 'Accedi',
        ],
        'fields' => [
            'email' => [
                'label' => 'Email',
                'placeholder' => 'Inserisci la tua email',
            ],
        ],
    ],
    'register' => [
        'button' => [
            'label' => 'Registrati',
        ],
    ],
    'logout' => [
        'button' => [
            'label' => 'Esci',
        ],
        'confirm' => [
            'label' => 'Conferma Logout',
            'title' => 'Sei sicuro di voler uscire?',
            'description' => 'Conferma per effettuare il logout dal sistema.',
        ],
        'cancel' => [
            'label' => 'Annulla',
        ],
        'success' => [
            'message' => 'Logout effettuato con successo',
        ],
    ],
];
```

### 4. Componenti Filament

Nei componenti Filament, non utilizzare mai il metodo `->label()` con stringhe dirette:

```php
// ERRATO
TextInput::make('name')
    ->label('Nome')

// CORRETTO
TextInput::make('name')
// Il label viene gestito automaticamente dal LangServiceProvider
```

### 5. JSON di Configurazione

Nei file JSON di configurazione (come per le sezioni dell'header), utilizzare chiavi di traduzione standardizzate:

```json
// ERRATO
{
    "label": "Profilo",
    "url": "/profilo",
    "icon": "heroicon-o-user"
}

// CORRETTO
{
    "label": "auth.profile.link.label",
    "url": "/profilo",
    "icon": "heroicon-o-user"
}
```

## Implementazione nelle Viste Blade

### Componenti UI

Utilizzare sempre i componenti Blade nativi di Filament con chiavi di traduzione standardizzate:

```blade
<!-- ERRATO -->
<a href="{{ route('login') }}" class="text-sm font-medium">
    {{ __('Accedi') }}
</a>

<!-- CORRETTO -->
<x-filament::button
    tag="a"
    href="{{ route('login') }}"
    color="primary"
    size="sm"
>
    {{ __('auth.login.button.label') }}
</x-filament::button>
```

### Menu e Dropdown

Per i menu e i dropdown, utilizzare chiavi di traduzione standardizzate:

```blade
@foreach($menu_items as $item)
    <a href="{{ $item['url'] }}">
        <!-- ERRATO -->
        {{ $item['label'] }}
        
        <!-- CORRETTO -->
        {{ __($item['label']) }}
    </a>
@endforeach
```

## Vantaggi dell'Approccio Corretto

1. **Manutenibilità**: Le chiavi di traduzione sono organizzate in modo gerarchico e coerente
2. **Internazionalizzazione**: Facilita l'aggiunta di nuove lingue
3. **Coerenza**: Garantisce una terminologia coerente in tutta l'applicazione
4. **Automazione**: Consente l'estrazione automatica delle chiavi di traduzione
5. **Riutilizzabilità**: Le traduzioni possono essere riutilizzate in diversi contesti

## Strumenti di Supporto

<nome progetto> include strumenti per l'estrazione automatica delle chiavi di traduzione e la verifica delle traduzioni mancanti:

```bash
php artisan lang:extract
php artisan lang:missing
php artisan lang:sync
```

## Conclusione

Seguire queste linee guida per le chiavi di traduzione è fondamentale per garantire la coerenza, la manutenibilità e l'internazionalizzazione dell'applicazione <nome progetto>. L'utilizzo di chiavi standardizzate e strutturate gerarchicamente facilita la gestione delle traduzioni e migliora la qualità complessiva del codice.
