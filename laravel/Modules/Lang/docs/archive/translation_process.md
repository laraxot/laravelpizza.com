# Processo di Traduzione: Da Sviluppatore a Traduttore

## Indice
1. [Introduzione](#introduzione)
2. [Struttura dei File di Traduzione](#struttura-dei-file-di-traduzione)
3. [Preparazione per i Traduttori](#preparazione-per-i-traduttori)
4. [Strumenti Consigliati](#strumenti-consigliati)
5. [Integrazione con il Flusso di Lavoro](#integrazione-con-il-flusso-di-lavoro)
6. [Best Practice](#best-practice)
7. [Automazione](#automazione)

## Introduzione

Questo documento descrive il processo di gestione delle traduzioni nel progetto <nome progetto>, con particolare attenzione alla collaborazione tra sviluppatori e traduttori.

## Struttura dei File di Traduzione

### File JSON (Traduzioni Globali)

`lang/it.json`
```json
{
    "Dashboard": "Pannello di Controllo",
    "Log in": "Accedi",
    "Register": "Registrati",
    "You're logged in!": "Sei connesso!"
}
```

### File PHP (Traduzioni Categorizzate)

`lang/it/auth.php`
```php
return [
    'failed' => 'Credenziali non valide.',
    'password' => 'La password non è corretta.',
    'throttle' => 'Troppi tentativi di accesso. Riprova tra :seconds secondi.',
    'register' => 'Registrazione',
];
```

## Preparazione per i Traduttori

### Istruzioni per i Traduttori

1. **File JSON**
   - Tradurre SOLO il testo a destra dei due punti `:`
   - NON modificare le chiavi a sinistra
   - Mantenere la struttura del file
   - Usare `\'` per gli apici singoli nel testo

2. **File PHP**
   - Tradurre SOLO il testo a destra di `=>`
   - NON modificare le chiavi a sinistra
   - Mantenere la struttura e la formattazione
   - Usare `\'` per gli apici singoli nel testo
   - I segnaposto come `:attribute` o `:count` DEVONO essere mantenuti

### Struttura Consigliata

```
lang/
├── it/
│   ├── auth.php
│   ├── validation.php
│   └── modules/
│       └── patient.php
└── en/
    └── ...
```

## Strumenti Consigliati

### 1. Laravel Lang

Per le traduzioni di base di Laravel:

```bash

# Installazione
composer require laravel-lang/common --dev

# Aggiungere una lingua
php artisan lang:add it
```

### 2. Traduzione Automatica con AI

Esempio di utilizzo di ChatGPT per la traduzione:

```
Traduci in italiano mantenendo la struttura JSON:

{
  "Dashboard": "Dashboard",
  "Log in": "Log in",
  "Register": "Register"
}
```

### 3. Editor Online

- [Lokalize](https://lokalise.com/)
- [POEditor](https://poeditor.com/)
- [Transifex](https://www.transifex.com/)

## Integrazione con il Flusso di Lavoro

### 1. Branch di Traduzione

```bash

# Creare un branch dedicato
git checkout -b feature/italian-translations

# Aggiungere i file tradotti
git add lang/it/
git commit -m "Aggiunte traduzioni in italiano"
```

### 2. Verifica delle Traduzioni

```bash
# Verificare le traduzioni mancanti
php artisan translations:missing it

# Verificare la sintassi PHP
php -l lang/it/auth.php
```

## Best Practice

### 1. Convenzioni per le Chiavi

- Usare `snake_case` per le chiavi
- Usare la notazione puntata per le gerarchie
- Mantenere le chiavi in inglese
- Essere descrittivi ma concisi

### 2. Gestione dei Parametri

```php
// Buono
'welcome' => 'Benvenuto, :name!',

// Utilizzo
__('messages.welcome', ['name' => 'Mario']);
```

### 3. Plurale/Singolare

```php
'apples' => '{0} Nessuna mela|{1} Una mela|[2,*] :count mele',
```

## Automazione

### 1. Comandi Personalizzati

`app/Console/Commands/ExtractTranslations.php`
```php
class ExtractTranslations extends Command
{
    protected $signature = 'translations:extract {locale} {--output=} {--source=resources/views}';
    
    public function handle()
    {
        // Estrai le stringhe dai file di vista
        // e genera i file di traduzione
    }
}
```

### 2. GitHub Actions

`.github/workflows/translations.yml`
```yaml
name: Check Translations

on: [push, pull_request]

jobs:
  check-translations:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v2
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          
      - name: Install Dependencies
        run: |
          composer install -n --prefer-dist
          
      - name: Check Missing Translations
        run: php artisan translations:missing it --json > missing.json
        
      - name: Fail if Missing Translations
        if: ${{ !contains('0', '0') }}
        run: |
          if [ -s missing.json ]; then
            echo "Missing translations found!"
            cat missing.json
            exit 1
          fi
```

## Risoluzione dei Problemi

### 1. Traduzioni Mancanti

```bash
# Verificare le chiavi mancanti
php artisan translations:missing it

# Verificare la cache delle viste
php artisan view:clear
php artisan config:clear
```

### 2. Problemi di Codifica

Assicurarsi che i file siano salvati in UTF-8 senza BOM:

```bash
# Convertire in UTF-8 senza BOM
find lang -type f -name "*.php" -o -name "*.json" | xargs dos2unix
```

## Conclusione

Questo documento fornisce una guida completa per la gestione delle traduzioni nel progetto <nome progetto>. Seguendo queste linee guida, è possibile garantire un processo di traduzione fluido e coerente in tutto il team di sviluppo.
