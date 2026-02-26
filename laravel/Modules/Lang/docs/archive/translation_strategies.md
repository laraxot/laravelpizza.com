# Strategie di Gestione delle Traduzioni in Laravel

## Indice
1. [Panoramica](#panoramica)
2. [File PHP vs JSON](#file-php-vs-json)
3. [Struttura delle Cartelle](#struttura-delle-cartelle)
4. [Helper di Traduzione](#helper-di-traduzione)
5. [Best Practice](#best-practice)
6. [Implementazione nel Progetto](#implementazione-nel-progetto)
7. [Migrazione tra Formati](#migrazione-tra-formati)
8. [Processo Dev → Traduttore: Strategia Operativa](#processo-dev-→-traduttore-strategia-operativa)
9. [Gestione Plurale/Singolare nelle Traduzioni](#gestione-plurale-singolare-nelle-traduzioni)

## Panoramica

In Laravel, esistono due approcci principali per gestire le traduzioni:
- **File PHP**: tradizionale, con struttura ad array
- **File JSON**: più moderno, con chiavi testuali

## File PHP vs JSON

### Vantaggi File PHP
- Struttura ad albero con chiavi annidate
- Organizzazione modulare (es: `auth.php`, `validation.php`)
- Possibilità di aggiungere commenti
- Supporto per chiavi duplicate in file diversi

### Vantaggi File JSON
- Chiavi leggibili direttamente nel codice
- Più facili da gestire per traduttori non tecnici
- Meno propensi a errori di percorso
- Più facili da gestire con strumenti di localizzazione

## Struttura delle Cartelle

### Struttura Consigliata

```
lang/
├── it/
│   ├── auth.php
│   ├── validation.php
│   └── modules/
│       ├── patient.php
│       └── doctor.php
└── en/
    ├── auth.php
    ├── validation.php
    └── modules/
        ├── patient.php
        └── doctor.php
```

### File di Configurazione

`config/app.php`:
```php
'locale' => 'it',
'fallback_locale' => 'en',
'faker_locale' => 'it_IT',
```

## Helper di Traduzione

### `__()` vs `trans()`
- `__()`: Helper per stringhe di traduzione
  - Restituisce `null` se chiamato senza parametri
  - Sintassi: `__('chiave.traduzione')`
  
- `trans()`: Versione più flessibile
  - Restituisce l'istanza del Translator se chiamato senza parametri
  - Utile per metodi concatenati: `trans()->getLocale()`

### Esempi di Utilizzo

```php
// Base
__('Benvenuto, :name', ['name' => $user->name]);

trans('messages.welcome', ['name' => $user->name]);

// Con namespace
__('auth::validation.required')


// Nei file blade
{{ __('Benvenuto') }}
{!! __('<strong>Importante</strong>') !!}
```

## Best Practice

1. **Consistenza**
   - Scegliere un formato (PHP o JSON) e mantenerlo
   - Usare lo stesso stile di chiavi in tutto il progetto

2. **Organizzazione**
   - Raggruppare le traduzioni per funzionalità
   - Usare prefissi per i moduli (es: `patient.profile.title`)

3. **Sicurezza**
   - Usare `{{ }}` per evitare XSS
   - Validare i parametri dinamici

4. **Performance**
   - Usare la cache delle traduzioni in produzione
   ```bash
   php artisan config:cache
   php artisan view:cache
   ```

## Implementazione nel Progetto

### 1. Creazione Struttura Base

```bash
# Pubblicare i file di lingua Laravel
php artisan lang:publish

# Creare la struttura per i moduli
mkdir -p lang/{it,en}/modules
```

### 2. File di Traduzione PHP

`lang/it/modules/patient.php`:
```php
return [
    'profile' => [
        'title' => 'Profilo Paziente',
        'name' => 'Nome',
        'surname' => 'Cognome',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
    ]
];
```

### 3. File di Traduzione JSON

`lang/it.json`:
```json
{
    "Welcome to our application!": "Benvenuto nella nostra applicazione!",
    "Name": "Nome",
    "E-Mail Address": "Indirizzo Email"
}
```

### 4. Middleware per la Lingua

`app/Http/Middleware/SetLocale.php`:
```php
public function handle($request, Closure $next)
{
    if (session()->has('locale')) {
        app()->setLocale(session('locale'));
    }
    
    return $next($request);
}
```

## Migrazione tra Formati

### Da JSON a PHP

1. Creare i file PHP necessari
2. Convertire le chiavi piatte in struttura ad albero
3. Aggiornare i riferimenti nel codice

### Da PHP a JSON

1. Estrarre tutte le chiavi di traduzione
2. Appiattire la struttura
3. Creare i file JSON
4. Aggiornare i riferimenti nel codice

## Strumenti Utili

### Comandi Artisan
```bash
# Pubblicare file di lingua
php artisan lang:publish

# Cercare traduzioni mancanti
php artisan translation:show-missing

# Estrai stringhe traducibili
php artisan translation:extract
```

### Pacchetti Consigliati
- `laravel-lang/common`: Traduzioni ufficiali Laravel
- `mcamara/laravel-localization`: Gestione avanzata delle lingue
- `spatie/laravel-translation-loader`: Caricamento traduzioni da DB

## Processo Dev → Traduttore: Strategia Operativa

1. **Preparazione**: Prepara i file PHP/JSON di riferimento in `/lang/en/` e `/lang/en.json`.
2. **Esportazione**: Invia solo i file di riferimento ai traduttori, con istruzioni chiare (tradurre solo i valori, non le chiavi).
3. **Istruzioni**: Fornisci una guida scritta su come tradurre (vedi esempio in README.md).
4. **Reintegrazione**: Sostituisci i file tradotti nella lingua target, verifica la sintassi e testa l'app.
5. **Modifiche Proposte**:
   - Nei Blade, sostituire tutte le stringhe hardcoded con chiavi strutturate.
   - Nei file PHP, uniformare la struttura e aggiungere commenti per i traduttori.
   - Versionare i file di traduzione separatamente.

## Gestione Plurale/Singolare nelle Traduzioni

### Uso di `trans_choice()` e `@choice`
- Per messaggi che variano in base al conteggio, usa `trans_choice()` o la direttiva Blade `@choice()`.
- Sintassi tipica in PHP:
  ```php
  // lang/en/messages.php
  return [
      'newMessageIndicator' => '{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages',
  ];
  ```
- In Blade:
  ```blade
  @choice('messages.newMessageIndicator', $messagesCount)
  ```

### Sintassi delle Regole Plurali
- `{0}`: caso zero
- `{1}`: caso singolare
- `[2,*]`: da 2 in poi
- Usa `:count` per il numero

### Plurale in JSON
- Supportato ma meno leggibile:
  ```json
  {
    "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages": "{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages"
  }
  ```
- In Blade:
  ```blade
  {{ trans_choice('{0} You have no new messages|{1} You have 1 new message|[2,*] You have :count new messages', $messagesCount) }}
  ```
- **Raccomandazione**: Preferire i file PHP per le stringhe plurali.

### Modifiche Proposte
- Inserire tutte le stringhe plurali in `/lang/{locale}/messages.php`.
- Nei Blade, sostituire blocchi condizionali con `trans_choice()` o `@choice()`.
- Evitare l'uso del JSON per le stringhe plurali.

## Conclusione

La scelta tra file PHP e JSON dipende dalle esigenze del progetto:
- **PHP**: migliore per progetti grandi con molte traduzioni
- **JSON**: ideale per progetti più piccoli o con contenuti più fluidi

Per questo progetto, si consiglia di utilizzare i file PHP per le traduzioni di sistema e i moduli, mantenendo una struttura organizzata e scalabile.
