# Prevenzione ->label() Hardcoded - Modulo User

## 🚨 **REGOLA ASSOLUTA**

**MAI** usare `->label()` con stringhe hardcoded. **SEMPRE** usare le traduzioni.

## ❌ **VIETATO - MAI FARE**

```php
// ❌ ERRORE CRITICO - MAI FARE
TextInput::make('name')
    ->label('Nome'),

Select::make('status')
    ->label('Stato'),

Toggle::make('active')
    ->label('Attivo'),
```

## ✅ **CORRETTO - SEMPRE FARE**

```php
// ✅ CORRETTO - SEMPRE FARE
TextInput::make('name')
    ->label(__('user::fields.name.label')),

Select::make('status')
    ->label(__('user::fields.status.label')),

Toggle::make('active')
    ->label(__('user::fields.active.label')),
```

## 📋 **Checklist Prevenzione**

### 1. **Controllo Pre-commit**
```bash
# Cerca ->label() hardcoded
grep -r "->label('[^']*')" Modules/User/app/ --include="*.php"

# Cerca ->label() con stringhe
grep -r "->label(\"[^\"]*\")" Modules/User/app/ --include="*.php"
```

### 2. **Controllo CI/CD**
```yaml
# .github/workflows/user-checks.yml
name: User Module Checks

on: [push, pull_request]

jobs:
  label-check:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
    - name: Check for hardcoded labels
      run: |
        if grep -r "->label('[^']*')" Modules/User/app/ --include="*.php"; then
          echo "❌ Hardcoded labels found!"
          exit 1
        fi
```

### 3. **Template Corretto**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Resources\XotBaseResource;

class ExampleResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->label(__('user::fields.name.label'))
                ->placeholder(__('user::fields.name.placeholder'))
                ->helperText(__('user::fields.name.help')),
                
            'email' => TextInput::make('email')
                ->label(__('user::fields.email.label'))
                ->placeholder(__('user::fields.email.placeholder'))
                ->helperText(__('user::fields.email.help')),
        ];
    }
}
```

## 🔧 **File Traduzione Corretti**

### Struttura Espansa Obbligatoria
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome completo dell\'utente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'Indirizzo email valido',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Utente',
            'success' => 'Utente creato con successo',
            'error' => 'Errore nella creazione',
        ],
    ],
];
```

## 🚨 **Errori Comuni**

### 1. **Dimenticare le Traduzioni**
```php
// ❌ ERRORE - Manca il file di traduzione
TextInput::make('name')
    ->label(__('user::fields.name.label')); // Errore se il file non esiste
```

### 2. **Struttura Piatta**
```php
// ❌ ERRORE - Struttura piatta
return [
    'name_label' => 'Nome',
    'email_label' => 'Email',
];
```

### 3. **Helper Text Uguale a Placeholder**
```php
// ❌ ERRORE - Helper text uguale a placeholder
'name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Inserisci il nome', // Deve essere diverso!
],
```

## ✅ **Soluzioni Implementate**

### 1. **File Corretti**
- ✅ `ViewPermission.php` - Corretto con traduzioni
- ✅ `DeviceResource.php` - Corretto con traduzioni
- ✅ `S3Test.php` - Già corretto

### 2. **File Traduzione Creati**
- ✅ `Modules/User/lang/it/permission.php`
- ✅ `Modules/User/lang/en/permission.php`
- ✅ `Modules/User/lang/it/device.php`
- ✅ `Modules/User/lang/en/device.php`

### 3. **Controlli Automatici**
- ✅ Pre-commit hooks
- ✅ CI/CD pipeline
- ✅ Template standard

## 📊 **Metriche Prevenzione**

### 🎯 **Obiettivi**
- **0** `->label()` hardcoded nel modulo User
- **100%** traduzioni complete
- **100%** struttura espansa
- **100%** conformità standard

### 📈 **Monitoraggio**
- **Daily**: Controlli automatici
- **Weekly**: Revisioni manuali
- **Monthly**: Audit completo
- **Quarterly**: Aggiornamenti standard

## 🔗 **Collegamenti**

- [Translation Standards](../../docs/translation-standards.md)
- [PHPStan Fixes](../../docs/phpstan_level10_fixes.md)
- [Best Practices](../../docs/best-practices.md)

---

**🔄 Ultimo aggiornamento**: 27 Gennaio 2025  
**📦 Versione**: 3.1.0  
**🎯 Obiettivo**: Zero ->label() hardcoded  
**✅ Status**: Prevenzione attiva e monitorata
