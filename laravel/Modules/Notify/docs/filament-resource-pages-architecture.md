# Architettura delle Pagine di Risorse Filament

## Regola Fondamentale

, **MAI** estendere direttamente le classi di Filament per le pagine di risorse. Utilizzare **SEMPRE** le classi wrapper corrispondenti con prefisso `XotBase` fornite dal modulo `Xot`.

## Struttura Architetturale

Il pattern XotBase si applica a tutte le classi di Filament, incluse le pagine di risorse:

```
Filament\Resources\Pages\CreateRecord
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
        ↑
        └── Modules\Notify\Filament\Resources\YourResource\Pages\CreateYourModel

Filament\Resources\Pages\EditRecord
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
        ↑
        └── Modules\Notify\Filament\Resources\YourResource\Pages\EditYourModel

Filament\Resources\Pages\ListRecords
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
        ↑
        └── Modules\Notify\Filament\Resources\YourResource\Pages\ListYourModels
```

## Mappatura Completa delle Classi

| ❌ Classe Filament (NON USARE) | ✅ Classe XotBase (DA USARE) |
|-------------------------------|----------------------------|
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage` |

## Implementazione Corretta

### ✅ Esempio di `CreateNotifyTheme.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateNotifyTheme extends XotBaseCreateRecord
{
    protected static string $resource = NotifyThemeResource::class;
}
```

### ✅ Esempio di `EditNotifyTheme.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

use Filament\Pages\Actions\DeleteAction;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditNotifyTheme extends XotBaseEditRecord
{
    protected static string $resource = NotifyThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
```

## Vantaggi Architetturali

1. **Traduzione Automatica**: Le classi XotBase forniscono traduzione automatica per etichette, messaggi e testi UI
2. **Logica di Persistenza**: Gestione standardizzata di salvataggio, validazione e notifiche
3. **Multi-tenant**: Supporto integrato per isolamento dei dati per tenant
4. **Audit Trail**: Logging automatico delle modifiche ai record
5. **Autorizzazioni Unificate**: Gestione centralizzata dei permessi
6. **Convenzioni di Naming**: Supporto per strutture di naming coerenti

## Estendere le Funzionalità

Le classi base XotBase già implementano la maggior parte delle funzionalità necessarie. Quando si estendono, limitarsi a definire:

1. La risorsa associata via `protected static string $resource`
2. Azioni aggiuntive specifiche (header actions, etc.)
3. Override di comportamenti specifici solo quando necessario

## Verifica del Codice

Per verificare che tutte le pagine di risorse seguano questo pattern:

```bash
find Modules -type f -name "*.php" -path "*/Filament/Resources/*/Pages/*" -exec grep -l "extends.*\\\\Filament\\\\Resources\\\\Pages" {} \;
find Modules -type f -name "*.php" -path "*/Filament/Resources/*/Pages/*" -exec grep -l "extends.*\\\\Filament\\\\Resources\\\\Pages" {} \;
find Modules -type f -name "*.php" -path "*/Filament/Resources/*/Pages/*" -exec grep -l "extends.*\\\\Filament\\\\Resources\\\\Pages" {} \;
```

## Riferimenti

- [Filament Resources Documentation](https://filamentphp.com/docs/3.x/panels/resources/getting-started)
- [ XotBase Architecture](./FILAMENT_XOT_ARCHITECTURE.md)
- [<nome progetto> XotBase Architecture](./FILAMENT_XOT_ARCHITECTURE.md)
- [Pattern Architetturali in Laravel](https://laravel.com/docs/architecture)
# Architettura delle Pagine di Risorse Filament

## Regola Fondamentale

, **MAI** estendere direttamente le classi di Filament per le pagine di risorse. Utilizzare **SEMPRE** le classi wrapper corrispondenti con prefisso `XotBase` fornite dal modulo `Xot`.

## Struttura Architetturale

Il pattern XotBase si applica a tutte le classi di Filament, incluse le pagine di risorse:

```
Filament\Resources\Pages\CreateRecord
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord
        ↑
        └── Modules\Notify\Filament\Resources\YourResource\Pages\CreateYourModel

Filament\Resources\Pages\EditRecord
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord
        ↑
        └── Modules\Notify\Filament\Resources\YourResource\Pages\EditYourModel

Filament\Resources\Pages\ListRecords
    ↑
    └── Modules\Xot\Filament\Resources\Pages\XotBaseListRecords
        ↑
        └── Modules\Notify\Filament\Resources\YourResource\Pages\ListYourModels
```

## Mappatura Completa delle Classi

| ❌ Classe Filament (NON USARE) | ✅ Classe XotBase (DA USARE) |
|-------------------------------|----------------------------|
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |
| `Filament\Resources\Pages\EditRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |
| `Filament\Resources\Pages\ViewRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord` |
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Resources\Pages\Page` | `Modules\Xot\Filament\Resources\Pages\XotBaseResourcePage` |

## Implementazione Corretta

### ✅ Esempio di `CreateNotifyTheme.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateNotifyTheme extends XotBaseCreateRecord
{
    protected static string $resource = NotifyThemeResource::class;
}
```

### ✅ Esempio di `EditNotifyTheme.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\Pages;

use Filament\Pages\Actions\DeleteAction;
use Modules\Notify\Filament\Resources\NotifyThemeResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditNotifyTheme extends XotBaseEditRecord
{
    protected static string $resource = NotifyThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
```

## Vantaggi Architetturali

1. **Traduzione Automatica**: Le classi XotBase forniscono traduzione automatica per etichette, messaggi e testi UI
2. **Logica di Persistenza**: Gestione standardizzata di salvataggio, validazione e notifiche
3. **Multi-tenant**: Supporto integrato per isolamento dei dati per tenant
4. **Audit Trail**: Logging automatico delle modifiche ai record
5. **Autorizzazioni Unificate**: Gestione centralizzata dei permessi
6. **Convenzioni di Naming**: Supporto per strutture di naming coerenti

## Estendere le Funzionalità

Le classi base XotBase già implementano la maggior parte delle funzionalità necessarie. Quando si estendono, limitarsi a definire:

1. La risorsa associata via `protected static string $resource`
2. Azioni aggiuntive specifiche (header actions, etc.)
3. Override di comportamenti specifici solo quando necessario

## Verifica del Codice

Per verificare che tutte le pagine di risorse seguano questo pattern:

```bash
find Modules -type f -name "*.php" -path "*/Filament/Resources/*/Pages/*" -exec grep -l "extends.*\\\\Filament\\\\Resources\\\\Pages" {} \;
```

## Riferimenti

- [Filament Resources Documentation](https://filamentphp.com/docs/3.x/panels/resources/getting-started)
- [<main module> XotBase Architecture](./FILAMENT_XOT_ARCHITECTURE.md)
- [Pattern Architetturali in Laravel](https://laravel.com/docs/architecture)
