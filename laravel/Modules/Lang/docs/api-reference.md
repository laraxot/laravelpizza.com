# 📚 **API Reference Modulo Lang - Laraxot**

## 🎯 **Panoramica**

Questo documento fornisce la documentazione completa delle API del modulo Lang, seguendo i principi **DRY**, **KISS**, **SOLID**, **Robust** e **Laraxot**. Include tutti i metodi, classi e interfacce disponibili.

---

## 🏗️ **Architettura API**

### **Struttura Generale**
```
Lang Module API
├── Services
│   ├── TranslationService
│   ├── ValidationService
│   └── CacheService
├── Commands
│   ├── ValidateCommand
│   ├── CacheCommand
│   └── ReportCommand
├── Facades
│   └── Lang
└── Helpers
    ├── TranslationHelper
    └── ValidationHelper
```

---

## 🔧 **Services**

### **TranslationService**

#### **Classe Base**
```php
namespace Modules\Lang\Services;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Translation\Translator;

class TranslationService
{
    public function __construct(
        private Translator $translator,
        private Repository $cache,
        private array $config
    ) {}
}
```

#### **Metodi Principali**

##### **get() - Recupera Traduzione**
```php
/**
 * Recupera una traduzione per la chiave specificata.
 *
 * @param string $key Chiave di traduzione
 * @param array<string, mixed> $replace Parametri di sostituzione
 * @param string|null $locale Locale specifico
 * @param bool $fallback Abilita fallback
 * 
 * @return string|array<string, mixed> Traduzione o array di traduzioni
 */
public function get(string $key, array $replace = [], ?string $locale = null, bool $fallback = true): string|array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(TranslationService::class);

// Traduzione semplice
$text = $service->get('fields.name.label');

// Con parametri
$text = $service->get('messages.welcome', ['name' => 'Mario']);

// Locale specifico
$text = $service->get('buttons.save', [], 'en');
```

##### **set() - Imposta Traduzione**
```php
/**
 * Imposta una traduzione per la chiave specificata.
 *
 * @param string $key Chiave di traduzione
 * @param string|array<string, mixed> $value Valore traduzione
 * @param string $locale Locale
 * @param bool $persist Persiste su file
 * 
 * @return bool Successo operazione
 */
public function set(string $key, string|array $value, string $locale, bool $persist = false): bool
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(TranslationService::class);

// Imposta traduzione
$service->set('fields.name.label', 'Nome', 'it');

// Imposta array traduzioni
$service->set('validation', [
    'required' => 'Campo obbligatorio',
    'email' => 'Email non valida'
], 'it');
```

##### **has() - Verifica Esistenza**
```php
/**
 * Verifica se esiste una traduzione per la chiave.
 *
 * @param string $key Chiave di traduzione
 * @param string|null $locale Locale specifico
 * 
 * @return bool Esistenza traduzione
 */
public function has(string $key, ?string $locale = null): bool
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(TranslationService::class);

if ($service->has('fields.name.label')) {
    $label = $service->get('fields.name.label');
}
```

##### **missing() - Chiavi Mancanti**
```php
/**
 * Recupera tutte le chiavi di traduzione mancanti.
 *
 * @param string $locale Locale specifico
 * @param array<string> $exclude Chiavi da escludere
 * 
 * @return array<string> Chiavi mancanti
 */
public function missing(string $locale, array $exclude = []): array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(TranslationService::class);

$missing = $service->missing('it', ['debug', 'test']);
// Restituisce: ['fields.name.label', 'buttons.save']
```

---

### **ValidationService**

#### **Classe Base**
```php
namespace Modules\Lang\Services;

use Illuminate\Support\Collection;

class ValidationService
{
    public function __construct(
        private array $config,
        private TranslationService $translationService
    ) {}
}
```

#### **Metodi Principali**

##### **validate() - Validazione Completa**
```php
/**
 * Valida tutti i file di traduzione per un modulo.
 *
 * @param string $module Nome modulo
 * @param string $locale Locale
 * @param array<string, mixed> $options Opzioni validazione
 * 
 * @return array<string, mixed> Risultato validazione
 */
public function validate(string $module, string $locale, array $options = []): array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(ValidationService::class);

$result = $service->validate('User', 'it', [
    'strict' => true,
    'auto_fix' => false
]);

// Output:
// [
//     'valid' => true,
//     'errors' => [],
//     'warnings' => ['fields.email.help' => 'Help text mancante'],
//     'score' => 95.2
// ]
```

##### **validateFile() - Validazione Singolo File**
```php
/**
 * Valida un singolo file di traduzione.
 *
 * @param string $filePath Percorso file
 * @param array<string, mixed> $options Opzioni validazione
 * 
 * @return array<string, mixed> Risultato validazione
 */
public function validateFile(string $filePath, array $options = []): array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(ValidationService::class);

$result = $service->validateFile(
    'Modules/User/lang/it/fields.php',
    ['syntax_check' => true, 'structure_check' => true]
);
```

##### **fix() - Correzione Automatica**
```php
/**
 * Corregge automaticamente errori comuni nei file di traduzione.
 *
 * @param string $filePath Percorso file
 * @param array<string, mixed> $options Opzioni correzione
 * 
 * @return array<string, mixed> Risultato correzione
 */
public function fix(string $filePath, array $options = []): array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(ValidationService::class);

$result = $service->fix('Modules/User/lang/it/fields.php', [
    'fix_syntax' => true,
    'fix_structure' => true,
    'backup' => true
]);
```

---

### **CacheService**

#### **Classe Base**
```php
namespace Modules\Lang\Services;

use Illuminate\Contracts\Cache\Repository;

class CacheService
{
    public function __construct(
        private Repository $cache,
        private array $config
    ) {}
}
```

#### **Metodi Principali**

##### **get() - Recupera da Cache**
```php
/**
 * Recupera traduzioni dalla cache.
 *
 * @param string $key Chiave cache
 * @param string $locale Locale
 * 
 * @return array<string, mixed>|null Traduzioni o null
 */
public function get(string $key, string $locale): ?array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(CacheService::class);

$translations = $service->get('user_fields', 'it');
if ($translations) {
    // Usa traduzioni dalla cache
}
```

##### **put() - Salva in Cache**
```php
/**
 * Salva traduzioni nella cache.
 *
 * @param string $key Chiave cache
 * @param string $locale Locale
 * @param array<string, mixed> $translations Traduzioni
 * @param int|null $ttl TTL specifico
 * 
 * @return bool Successo operazione
 */
public function put(string $key, string $locale, array $translations, ?int $ttl = null): bool
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(CacheService::class);

$service->put('user_fields', 'it', [
    'name' => ['label' => 'Nome'],
    'email' => ['label' => 'Email']
], 3600);
```

##### **clear() - Pulisce Cache**
```php
/**
 * Pulisce la cache per un modulo o locale specifico.
 *
 * @param string|null $module Nome modulo (opzionale)
 * @param string|null $locale Locale (opzionale)
 * 
 * @return bool Successo operazione
 */
public function clear(?string $module = null, ?string $locale = null): bool
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$service = app(CacheService::class);

// Pulisce tutta la cache
$service->clear();

// Pulisce cache modulo specifico
$service->clear('User');

// Pulisce cache locale specifico
$service->clear(null, 'it');
```

---

## 🎮 **Commands**

### **ValidateCommand**

#### **Comando Base**
```bash
php artisan lang:validate [options]
```

#### **Opzioni Disponibili**
```bash
--module=MODULE        # Valida solo modulo specifico
--locale=LOCALE        # Valida solo locale specifico
--detailed             # Output dettagliato
--format=FORMAT        # Formato output (json, table, csv)
--fix                  # Correzione automatica
--strict               # Modalità strict
--output=FILE          # Salva output su file
```

#### **Esempi d'uso**
```bash
# Validazione completa
php artisan lang:validate

# Validazione modulo specifico
php artisan lang:validate --module=User

# Validazione con correzione automatica
php artisan lang:validate --fix --detailed

# Output JSON su file
php artisan lang:validate --format=json --output=validation_report.json
```

### **CacheCommand**

#### **Comando Base**
```bash
php artisan lang:cache [options]
```

#### **Opzioni Disponibili**
```bash
--clear                # Pulisce cache
--status               # Mostra status cache
--warm                 # Precarica cache
--optimize             # Ottimizza cache
--stats                # Statistiche cache
```

#### **Esempi d'uso**
```bash
# Gestione cache
php artisan lang:cache

# Pulisce cache
php artisan lang:cache --clear

# Status cache
php artisan lang:cache --status

# Precarica cache
php artisan lang:cache --warm
```

### **ReportCommand**

#### **Comando Base**
```bash
php artisan lang:report [options]
```

#### **Opzioni Disponibili**
```bash
--module=MODULE        # Report modulo specifico
--locale=LOCALE        # Report locale specifico
--format=FORMAT        # Formato output
--output=FILE          # Salva su file
--detailed             # Report dettagliato
--quality              # Focus qualità
--performance          # Focus performance
```

#### **Esempi d'uso**
```bash
# Report completo
php artisan lang:report

# Report modulo specifico
php artisan lang:report --module=User --format=json

# Report qualità
php artisan lang:report --quality --detailed

# Salva su file
php artisan lang:report --format=csv --output=lang_report.csv
```

---

## 🌟 **Facades**

### **Lang Facade**

#### **Metodi Principali**

##### **get() - Recupera Traduzione**
```php
use Modules\Lang\Facades\Lang;

// Traduzione semplice
$text = Lang::get('fields.name.label');

// Con parametri
$text = Lang::get('messages.welcome', ['name' => 'Mario']);

// Locale specifico
$text = Lang::get('buttons.save', [], 'en');
```

##### **set() - Imposta Traduzione**
```php
// Imposta traduzione
Lang::set('fields.name.label', 'Nome', 'it');

// Imposta array
Lang::set('validation', [
    'required' => 'Campo obbligatorio'
], 'it');
```

##### **has() - Verifica Esistenza**
```php
if (Lang::has('fields.name.label')) {
    $label = Lang::get('fields.name.label');
}
```

##### **missing() - Chiavi Mancanti**
```php
$missing = Lang::missing('it', ['debug']);
```

##### **validate() - Validazione**
```php
$result = Lang::validate('User', 'it');
```

##### **cache() - Gestione Cache**
```php
// Pulisce cache
Lang::cache()->clear();

// Status cache
$status = Lang::cache()->status();
```

---

## 🛠️ **Helpers**

### **TranslationHelper**

#### **Funzioni Globali**

##### **__lang() - Helper Traduzione**
```php
/**
 * Helper per traduzioni con namespace automatico.
 *
 * @param string $key Chiave traduzione
 * @param array<string, mixed> $replace Parametri
 * @param string|null $locale Locale
 * 
 * @return string Traduzione
 */
function __lang(string $key, array $replace = [], ?string $locale = null): string
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
// Traduzione automatica con namespace modulo
$text = __lang('fields.name.label'); // Cerca in modulo corrente

// Con parametri
$text = __lang('messages.welcome', ['name' => 'Mario']);

// Locale specifico
$text = __lang('buttons.save', [], 'en');
```

##### **lang_has() - Verifica Esistenza**
```php
/**
 * Verifica esistenza traduzione con namespace automatico.
 *
 * @param string $key Chiave traduzione
 * @param string|null $locale Locale
 * 
 * @return bool Esistenza
 */
function lang_has(string $key, ?string $locale = null): bool
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
if (lang_has('fields.name.label')) {
    $label = __lang('fields.name.label');
}
```

### **ValidationHelper**

#### **Funzioni Globali**

##### **validate_lang_file() - Validazione File**
```php
/**
 * Valida un file di traduzione.
 *
 * @param string $filePath Percorso file
 * @param array<string, mixed> $options Opzioni
 * 
 * @return array<string, mixed> Risultato
 */
function validate_lang_file(string $filePath, array $options = []): array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$result = validate_lang_file('Modules/User/lang/it/fields.php', [
    'syntax_check' => true,
    'structure_check' => true
]);
```

##### **fix_lang_file() - Correzione File**
```php
/**
 * Corregge automaticamente un file di traduzione.
 *
 * @param string $filePath Percorso file
 * @param array<string, mixed> $options Opzioni
 * 
 * @return array<string, mixed> Risultato
 */
function fix_lang_file(string $filePath, array $options = []): array
{
    // Implementazione
}
```

**Esempio d'uso:**
```php
$result = fix_lang_file('Modules/User/lang/it/fields.php', [
    'fix_syntax' => true,
    'backup' => true
]);
```

---

## 📊 **Response Types**

### **ValidationResult**

#### **Struttura**
```php
class ValidationResult
{
    public function __construct(
        public bool $valid,
        public array $errors,
        public array $warnings,
        public float $score,
        public array $details,
        public string $filePath,
        public string $module,
        public string $locale
    ) {}
}
```

#### **Esempio Output**
```php
[
    'valid' => true,
    'errors' => [],
    'warnings' => [
        'fields.email.help' => 'Help text mancante per campo email'
    ],
    'score' => 95.2,
    'details' => [
        'total_keys' => 45,
        'valid_keys' => 43,
        'missing_keys' => 2,
        'syntax_errors' => 0,
        'structure_errors' => 0
    ],
    'filePath' => 'Modules/User/lang/it/fields.php',
    'module' => 'User',
    'locale' => 'it'
]
```

### **CacheStatus**

#### **Struttura**
```php
class CacheStatus
{
    public function __construct(
        public bool $enabled,
        public int $ttl,
        public int $totalKeys,
        public int $hitRate,
        public float $memoryUsage,
        public array $modules
    ) {}
}
```

#### **Esempio Output**
```php
[
    'enabled' => true,
    'ttl' => 3600,
    'totalKeys' => 1247,
    'hitRate' => 98.5,
    'memoryUsage' => 2.3,
    'modules' => [
        'User' => 245,
        'Performance' => 156,
        'Lang' => 89
    ]
]
```

---

## 🔗 **Integrazione Filament**

### **Componenti Automatici**

#### **TextInput**
```php
use Filament\Forms\Components\TextInput;

// ✅ CORRETTO - Label automatica
TextInput::make('name')
    ->required()
    ->maxLength(255);

// Il sistema carica automaticamente:
// - fields.name.label
// - fields.name.placeholder
// - fields.name.help
```

#### **Select**
```php
use Filament\Forms\Components\Select;

// ✅ CORRETTO - Opzioni da traduzioni
Select::make('role')
    ->options([
        'admin' => __('fields.role.options.admin'),
        'user' => __('fields.role.options.user')
    ]);
```

#### **Actions**
```php
use Filament\Actions\Action;

// ✅ CORRETTO - Traduzioni da file
Action::make('approve')
    ->requiresConfirmation()
    ->modalHeading(__('actions.approve.modal.heading'))
    ->modalDescription(__('actions.approve.modal.description'));
```

---

## 📋 **Best Practices API**

### **1. Gestione Errori**
```php
try {
    $result = $translationService->get('key');
} catch (TranslationNotFoundException $e) {
    Log::warning('Translation key not found', [
        'key' => 'key',
        'locale' => app()->getLocale()
    ]);
    
    // Fallback
    $result = 'Fallback text';
}
```

### **2. Performance**
```php
// ✅ CORRETTO - Cache abilitata
$translations = $cacheService->get('module_fields', $locale);
if (!$translations) {
    $translations = $translationService->loadModule('User');
    $cacheService->put('module_fields', $locale, $translations);
}

// ❌ ERRATO - Caricamento ogni volta
$translations = $translationService->loadModule('User');
```

### **3. Validazione Input**
```php
// ✅ CORRETTO - Validazione parametri
public function get(string $key, array $replace = [], ?string $locale = null): string
{
    if (empty($key)) {
        throw new InvalidArgumentException('Translation key cannot be empty');
    }
    
    if ($locale && !in_array($locale, $this->config['available_locales'])) {
        throw new InvalidArgumentException("Invalid locale: {$locale}");
    }
    
    // Implementazione...
}
```

---

## 🔗 **Riferimenti e Collegamenti**

### **1. Documentazione**
- [README.md](README.md) - Documentazione principale
- [BEST_PRACTICES.md](BEST_PRACTICES.md) - Best practices
- [TROUBLESHOOTING.md](TROUBLESHOOTING.md) - Troubleshooting
- [config/lang.php](../config/lang.php) - Configurazione

### **2. Esempi**
- [Examples/](../Examples/) - Esempi di utilizzo
- [Tests/](../Tests/) - Test unitari e di integrazione

### **3. Framework**
- [Laraxot Framework](https://github.com/laraxot/laraxot)
- [Laravel Localization](https://laravel.com/project_docs/localization)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Versione**: 2.0.0  
**Autore**: Team Laraxot  
**Mantenuto da**: Community Laraxot
