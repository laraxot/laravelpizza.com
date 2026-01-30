# 🚨 STRUTTURA MODULI E NAMESPACE - REGOLE CRITICHE

## ⚠️ ATTENZIONE: Questa è la regola più importante del progetto

### 🔴 REGOLA FONDAMENTALE DEI NAMESPACE

**I namespace NON includono MAI il segmento `app` anche se i file sono fisicamente nella directory `app`**

## 📁 Struttura File System vs 📦 Namespace

### File System (percorso fisico)
```
/laravel/Modules/NomeModulo/
├── app/
│   ├── Actions/
│   ├── Console/
│   ├── Datas/
│   ├── Enums/
│   ├── Events/
│   ├── Filament/
│   │   ├── Forms/
│   │   ├── Resources/
│   │   └── Widgets/
│   ├── Http/
│   │   └── Controllers/
│   ├── Models/
│   ├── Providers/
│   └── Services/
├── config/
├── database/
├── docs/
├── lang/
├── resources/
├── routes/
└── tests/
```

### Namespace (struttura logica)
```php
Modules\NomeModulo\Actions
Modules\NomeModulo\Console
Modules\NomeModulo\Datas
Modules\NomeModulo\Enums
Modules\NomeModulo\Events
Modules\NomeModulo\Filament\Forms
Modules\NomeModulo\Filament\Resources
Modules\NomeModulo\Filament\Widgets
Modules\NomeModulo\Http\Controllers
Modules\NomeModulo\Models
Modules\NomeModulo\Providers
Modules\NomeModulo\Services
```

## ✅ ESEMPI CORRETTI

### Enum
```php
// File: /laravel/Modules/<nome progetto>/app/Enums/AppointmentType.php
namespace Modules\<nome progetto>\Enums;
```

### Filament Form
```php
// File: /laravel/Modules/Geo/app/Filament/Forms/LocationForm.php
namespace Modules\Geo\Filament\Forms;
```

### Model
```php
// File: /laravel/Modules/User/app/Models/User.php
namespace Modules\User\Models;
```

### Action
```php
// File: /laravel/Modules/Patient/app/Actions/CreatePatientAction.php
namespace Modules\Patient\Actions;
```

### Provider
```php
// File: /laravel/Modules/Tenant/app/Providers/TenantServiceProvider.php
namespace Modules\Tenant\Providers;
```

## ❌ ESEMPI ERRATI

```php
// ❌ ERRATO - Non includere "App" nel namespace
namespace Modules\Geo\App\Filament\Forms\LocationForm;

// ❌ ERRATO - Non includere "app" nel namespace
namespace Modules\<nome progetto>\app\Enums\AppointmentType;

// ❌ ERRATO - Path fisico errato (manca cartella app)
// File: /laravel/Modules/<nome progetto>/Enums/AppointmentType.php
// Dovrebbe essere: /laravel/Modules/<nome progetto>/app/Enums/AppointmentType.php
```

## 🔧 AUTOLOADING IN COMPOSER.JSON

Ogni modulo ha questa configurazione nel suo `composer.json`:

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\NomeModulo\\": "app/",
            "Modules\\NomeModulo\\Database\\": "database/"
        }
    }
}
```

Questo dice a Composer che:
- `Modules\NomeModulo\*` → cerca in `app/`
- `Modules\NomeModulo\Database\*` → cerca in `database/`

## 📝 CHECKLIST PER NUOVI FILE

Quando crei un nuovo file:

1. ✅ Il file è nella cartella `app/` del modulo?
2. ✅ Il namespace NON contiene `App` o `app`?
3. ✅ Il namespace segue il pattern `Modules\NomeModulo\Sottocartella`?
4. ✅ Hai eseguito `composer dumpautoload` dopo aver creato il file?

## 🛠️ COMANDO DI VERIFICA

Dopo aver creato/modificato file, esegui sempre:

```bash
cd /var/www/html/_bases/base_<nome progetto>/laravel
composer dumpautoload
```

Se ci sono errori di namespace, Composer li segnalerà.

## 🎯 PATTERN DA MEMORIZZARE

```
PERCORSO FISICO:    /Modules/[Modulo]/app/[Cartella]/[File].php
NAMESPACE:          Modules\[Modulo]\[Cartella]
```

## ⚡ COMANDI UTILI

### Verificare un namespace
```bash

# Trova tutti i file con namespace errati
grep -r "namespace Modules.*App\\\\" /var/www/html/_bases/base_<nome progetto>/laravel/Modules/
```

### Correggere un namespace
```bash

# Esempio: correggere namespace nel modulo Geo
find /var/www/html/_bases/base_<nome progetto>/laravel/Modules/Geo -name "*.php" -exec sed -i 's/namespace Modules\\Geo\\App\\/namespace Modules\\Geo\\/g' {} \;
```

## 🚨 ERRORI COMUNI E SOLUZIONI

### Errore: Class not found
**Causa**: Namespace errato o file nel percorso sbagliato
**Soluzione**: 
1. Verifica che il file sia in `app/`
2. Verifica che il namespace non contenga `App`
3. Esegui `composer dumpautoload`

### Errore: Cannot redeclare class
**Causa**: Due file con lo stesso namespace/classe
**Soluzione**: Cerca duplicati con `grep -r "class NomeClasse" Modules/`

## 📋 ESEMPI PER OGNI TIPO DI FILE

### Actions
```php
// File: /Modules/NomeModulo/app/Actions/NomeAction.php
namespace Modules\NomeModulo\Actions;
```

### Datas (DTO)
```php
// File: /Modules/NomeModulo/app/Datas/NomeData.php
namespace Modules\NomeModulo\Datas;
```

### Enums
```php
// File: /Modules/NomeModulo/app/Enums/NomeEnum.php
namespace Modules\NomeModulo\Enums;
```

### Filament Resources
```php
// File: /Modules/NomeModulo/app/Filament/Resources/NomeResource.php
namespace Modules\NomeModulo\Filament\Resources;
```

### Controllers
```php
// File: /Modules/NomeModulo/app/Http/Controllers/NomeController.php
namespace Modules\NomeModulo\Http\Controllers;
```

---

**IMPORTANTE**: Questa è la regola più violata e che causa più errori. Memorizzala e applicala sempre!
