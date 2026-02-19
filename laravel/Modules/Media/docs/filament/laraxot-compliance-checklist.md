# Checklist Conformità Laraxot - Modulo Media

## 🎯 **CHECKLIST PRE-COMMIT OBBLIGATORIA**

### 📁 **Struttura e Namespace**
- [ ] Namespace corretto: `Modules\{ModuleName}\{Directory}` (senza segmento 'app')
- [ ] File posizionato in `Modules/{ModuleName}/app/` per classi applicative
- [ ] Estensione da classi XotBase* appropriate (XotBasePage, XotBaseResource, etc.)
- [ ] `declare(strict_types=1);` presente all'inizio di ogni file PHP

### 🔤 **Traduzioni**
- [ ] Nessuna stringa hardcoded nelle interfacce utente
- [ ] Traduzioni sempre del modulo corrente: `{module}::*` (mai cross-modulo)
- [ ] Struttura espansa per campi: `label`, `placeholder`, `helper_text`
- [ ] File traduzione in `Modules/{ModuleName}/lang/{locale}/`

### 🏗️ **Filament Components**
- [ ] `getFormSchema()` restituisce array associativo con chiavi string
- [ ] `getTableColumns()` restituisce array associativo con chiavi string
- [ ] `getTableActions()` restituisce array associativo con chiavi string
- [ ] Mai usare `->label()` nei componenti (gestito da LangServiceProvider)
- [ ] Nome view allineato al nome classe (kebab-case)

### 🔍 **Tipizzazione e PHPDoc**
- [ ] Tutti i metodi hanno tipi di ritorno espliciti
- [ ] Tutti i parametri hanno tipi dichiarati
- [ ] PHPDoc completi per proprietà e metodi pubblici
- [ ] Proprietà array tipizzate: `@var array<string, mixed>`
- [ ] Evitare `mixed` quando possibile

### ✅ **Validazione Automatica**
- [ ] PHPStan livello 9+ superato senza errori
- [ ] PSR-12 coding standards rispettati
- [ ] Nessun warning IDE per tipizzazione
- [ ] Test unitari passano (se presenti)

## 🚨 **ANTI-PATTERN DA EVITARE**

### ❌ **Traduzioni Errate**
```php
// MAI fare questo
__('ui::s3test.actions.test.label')           // Cross-modulo
->label('Test Connection')                     // Hardcoded
->placeholder('Enter value')                   // Hardcoded
```

### ❌ **Array Non Associativi**
```php
// MAI fare questo
protected function getFormSchema(): array
{
    return [
        TextInput::make('name'),    // Array numerico
        Select::make('type'),       // Array numerico
    ];
}
```

### ❌ **Metodi Non Tipizzati**
```php
// MAI fare questo
private function processData($data)           // Senza tipi
{
    return $data;                            // Senza tipo ritorno
}
```

### ❌ **Namespace Errati**
```php
// MAI fare questo
namespace Modules\Media\App\Filament\Pages;   // Con 'App'
namespace App\Filament\Resources;             // Fuori da Modules
```

## ✅ **PATTERN CORRETTI**

### ✅ **Traduzioni Corrette**
```php
// Sempre fare così
__('media::s3test.actions.test.label')        // Modulo-specifico
// Nessun ->label() sui componenti
// Struttura espansa nei file lang
```

### ✅ **Array Associativi**
```php
// Sempre fare così
protected function getFormSchema(): array
{
    return [
        'name_field' => TextInput::make('name'),
        'type_field' => Select::make('type'),
    ];
}
```

### ✅ **Metodi Tipizzati**
```php
// Sempre fare così
/**
 * Process configuration data.
 *
 * @param array<string, mixed> $data
 * @return array<string, mixed>
 */
private function processData(array $data): array
{
    return $data;
}
```

### ✅ **Namespace Corretti**
```php
// Sempre fare così
namespace Modules\Media\Filament\Pages;       // Senza 'App'
namespace Modules\Media\Models;               // Corretto
```

## 🔧 **COMANDI VALIDAZIONE**

### PHPStan Check
```bash
cd laravel
./vendor/bin/phpstan analyze Modules/Media --level=9
```

### Traduzioni Check
```bash
# Cerca stringhe hardcoded
grep -r "->label(" Modules/Media/app/Filament/
grep -r "__('ui::" Modules/Media/app/
```

### Namespace Check
```bash
# Verifica namespace corretti
grep -r "namespace.*\\App\\" Modules/Media/app/
```

## 📋 **TEMPLATE CLASSE FILAMENT**

```php
<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Modules\Xot\Filament\Pages\XotBasePage;

/**
 * Description of the page purpose.
 *
 * @property ComponentContainer $form
 */
class ExamplePage extends XotBasePage
{
    /**
     * Debug results storage.
     *
     * @var array<string, mixed>
     */
    public array $debugResults = [];

    /**
     * Get the form schema.
     *
     * @return array<string, \Filament\Forms\Components\Component>
     */
    protected function getFormSchema(): array
    {
        return [
            'main_grid' => Grid::make(2)
                ->schema([
                    TextInput::make('name'),
                    TextInput::make('email'),
                ]),
        ];
    }

    /**
     * Process form data.
     *
     * @param array<string, mixed> $data
     * @return void
     */
    private function processData(array $data): void
    {
        // Implementation
    }
}
```

## 🔗 **Collegamenti Documentazione**

- [S3Test Refactoring Analysis](s3test-refactoring-analysis.md)
- [Media Module README](../readme.md)
- [Laraxot Best Practices](../../../../docs/laraxot-best-practices.md)
- [PHPStan Guidelines](../../../../docs/phpstan-guidelines.md)

---

**Versione**: 1.0
**Applicabilità**: Tutti i file Filament del modulo Media
