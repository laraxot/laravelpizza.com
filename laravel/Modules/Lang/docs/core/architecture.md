# Architettura Modulo Lang

## 🏗️ Panoramica Architetturale

Il modulo Lang è il **modulo specializzato** per la gestione delle lingue, traduzioni e internazionalizzazione del sistema Laraxot.

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Traduzioni Centralizzate:** Evitare duplicazione di testi
- **Sistema Lingue Unificato:** Gestione uniforme delle traduzioni
- **Template Standardizzati:** Strutture uniformi per tutte le lingue

### **KISS (Keep It Simple, Stupid)**
- **API Semplici:** Metodi facili da usare per le traduzioni
- **Struttura Chiara:** Organizzazione logica dei file di lingua
- **Gestione Lineare:** Processo semplice per aggiungere nuove lingue

## 🏛️ Struttura delle Classi Base

### **BaseModel (Modulo Lang)**
```php
<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Modules\Xot\Models\XotBaseModel;

abstract class BaseModel extends XotBaseModel
{
    // Funzionalità specifiche per tutti i modelli del modulo Lang
}
```

### **Language Model**
```php
<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Language model.
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $native_name
 * @property bool $is_active
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Translation> $translations
 */
class Language extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'code',
        'name',
        'native_name',
        'is_active',
        'is_default',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get language translations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Translation>
     */
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    /**
     * Check if language is active.
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Check if language is default.
     */
    public function isDefault(): bool
    {
        return $this->is_default;
    }
}
```

## 🔄 Flusso di Ereditarietà

```
XotBaseModel → BaseModel (Lang) → Modello concreto
XotBaseResource → Resource (Lang) → Resource concreta
XotBaseRelationManager → RelationManager (Lang) → RelationManager concreto
```

## 📋 Regole di Implementazione

### **1. Estensione Obbligatoria**
- **MAI** estendere direttamente `Illuminate\Database\Eloquent\Model`
- **MAI** estendere direttamente `Filament\Resources\Resource`
- **SEMPRE** estendere le classi base appropriate del modulo

### **2. Naming Conventions**
- **File:** lowercase con hyphens (`language-management.md`)
- **Cartelle:** lowercase con hyphens (`filament-resources/`)
- **Classi:** PascalCase (`LanguageManager`)
- **Metodi:** camelCase (`getActiveLanguages`)

### **3. Struttura Standard**
```
app/
├── models/          # Modelli dati
├── services/        # Servizi business
├── actions/         # Azioni specifiche
├── traits/          # Trait e comportamenti
├── notifications/   # Notifiche
├── mail/            # Mail e comunicazioni
├── datas/           # DTO e oggetti dati
├── enums/           # Enum e costanti
├── view/            # View e componenti
├── http/            # Controller e middleware
├── console/         # Comandi console
└── providers/       # Service provider
```

## 🚫 Anti-pattern da Evitare

### **1. Estensione Diretta**
```php
// MAI fare questo
class Language extends \Illuminate\Database\Eloquent\Model
{
    // ...
}
```

### **2. Duplicazione Traduzioni**
```php
// MAI duplicare traduzioni tra moduli
// Modulo A
'welcome' => 'Benvenuto'

// Modulo B - MAI fare questo
'welcome' => 'Benvenuto' // Duplicazione
```

### **3. Convenzioni Inconsistenti**
```php
// MAI usare convenzioni diverse
class LanguageManager extends BaseModel // ✅ Corretto
class language_manager extends BaseModel // ❌ Sbagliato
```

## ✅ Best Practices

### **1. Utilizzo Classi Base**
```php
<?php

declare(strict_types=1);

namespace Modules\Lang\Models;

use Modules\Lang\Models\BaseModel;

class Translation extends BaseModel
{
    // Implementazione specifica del modulo Lang
}
```

### **2. Gestione Traduzioni Centralizzata**
```php
<?php

declare(strict_types=1);

namespace Modules\Lang\Services;

class TranslationService
{
    /**
     * Get translation for key and language.
     */
    public function getTranslation(string $key, string $languageCode): ?string
    {
        // Logica centralizzata per recuperare traduzioni
    }

    /**
     * Set translation for key and language.
     */
    public function setTranslation(string $key, string $languageCode, string $value): bool
    {
        // Logica centralizzata per impostare traduzioni
    }
}
```

### **3. Sistema Lingue Standardizzato**
```php
<?php

declare(strict_types=1);

namespace Modules\Lang\Services;

class LanguageService
{
    /**
     * Get active languages.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \Modules\Lang\Models\Language>
     */
    public function getActiveLanguages(): Collection
    {
        return Language::where('is_active', true)->get();
    }

    /**
     * Get default language.
     */
    public function getDefaultLanguage(): ?Language
    {
        return Language::where('is_default', true)->first();
    }
}
```

## 🔧 Configurazione e Setup

### **1. Service Provider Registration**
```php
// Modules/Lang/Providers/LangServiceProvider.php
public function boot(): void
{
    parent::boot();

    // Configurazioni specifiche del modulo Lang
}
```

### **2. Configurazione Modulo**
```php
// Modules/Lang/config/config.php
return [
    'name' => 'Lang Module',
    'version' => '1.0.0',
    'languages' => [
        'default' => 'it',
        'fallback' => 'en',
        'available' => ['it', 'en', 'de', 'fr'],
    ],
];
```

### **3. Traduzioni**
```php
// Modules/Lang/lang/it/lang.php
return [
    'languages' => [
        'it' => 'Italiano',
        'en' => 'Inglese',
        'de' => 'Tedesco',
        'fr' => 'Francese',
    ],
    'status' => [
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'default' => 'Predefinito',
    ],
];
```

## 📊 Metriche di Qualità

### **PHPStan Compliance**
- **Livello Minimo:** 9
- **Livello Target:** 10
- **Tipizzazione:** 100% esplicita
- **PHPDoc:** Completo per tutte le classi

### **Code Coverage**
- **Test Unitari:** 100% dei modelli
- **Test di Integrazione:** 100% delle funzionalità
- **Test di Regressione:** Dopo ogni modifica

## 🔗 Collegamenti

- [Best Practices Sistema](../../../docs/core/best-practices.md)
- [Convenzioni Sistema](../../../docs/core/conventions.md)
- [Template Modulo](../../../docs/templates/module-template.md)
- [PHPStan Guide](../development/phpstan-guide.md)

---

**Versione:** 2.0 - Consolidata DRY + KISS
