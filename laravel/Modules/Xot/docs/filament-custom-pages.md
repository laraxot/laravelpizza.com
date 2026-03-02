# Filament Custom Pages - Documentazione Modulo Xot

## Overview

Il modulo **Xot** fornisce le classi base astratte per tutte le pagine Filament custom nel progetto **PTVX (Fila5 Mono)**.

## Classi Base

### 1. XotBasePage (Standalone Pages)

**Posizione**: `Modules/Xot/app/Filament/Pages/XotBasePage.php`

Classe base per tutte le pagine Filament *standalone* (non legate a risorse specifiche).

```php
abstract class XotBasePage extends Page implements HasForms
{
    use InteractsWithForms;
    use TransTrait;
    
    public static ?string $model = null;
    public array $data = [];
    protected string $view = '';
}
```

**Features**:
- Gestione automatica traduzioni (`TransTrait`)
- Rilevamento modello da namespace
- Helper per moduli
- Cache timeout configurabile

**Metodi Key**:
- `getModuleName()`: Estrae nome modulo dal namespace
- `getView()`: Auto-genera path view
- `getModel()`: Ritorna modello associato
- `getFormModel()`: Per compatibilità Filament Forms
- `getFormStatePath()`: Default 'data'

### 2. XotBaseEditRecord (Resource Pages)

**Posizione**: `Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php`

Classe base per pagine di editing risorse.

```php
abstract class XotBaseEditRecord extends FilamentEditRecord
{
    use TransTrait;
    
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->model($this->getRecord());
    }
}
```

**Features**:
- Form schema auto-configurato
- Model binding automatico
- Metodi canDelete/canForceDelete

### 3. XotBasePage (Resources)

**Posizione**: `Modules/Xot/app/Filament/Resources/Pages/XotBasePage.php`

Versione per pagine risorsa con `$resource` property.

```php
abstract class XotBasePage extends FilamentResourcePage
{
    public ?array $data = [];
    
    public function getFormStatePath(): string
    {
        return 'data';
    }
    
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema())
            ->model($this->getFormModel())
            ->statePath($this->getFormStatePath())
            ->operation($this->getFormContext())
            ->columns(2);
    }
}
```

## Pattern Filament 5

### Schema-Based Forms

Filament 5 usa `Schema` invece di `Form`:

```php
use Filament\Schemas\Schema;

public function nomeForm(Schema $schema): Schema
{
    return $schema
        ->components([
            TextInput::make('field')->required(),
        ])
        ->statePath('data');
}
```

### State Path

Isola i dati del form in una property specifica:

```php
public ?array $emailData = [];

public function emailForm(Schema $schema): Schema
{
    return $schema
        ->components([...])
        ->statePath('emailData');  // Isola i dati
}
```

## Best Practices

### 1. Sempre Short Array Syntax

```php
// ✅ CORRETTO
return [
    'key' => 'value',
];

// ❌ ERRATO
return array(
    'key' => 'value',
);
```

### 2. View Naming Convention

```
module-name::filament.pages.page-name
```

### 3. Type Declarations

```php
protected static string $resource = ResourceClass::class;
protected string $view = 'module::filament.pages.name';
public array $data = [];
```

### 4. Namespace Structure

```
Modules/
├── Xot/app/Filament/Pages/XotBasePage.php           (Standalone)
├── Xot/app/Filament/Resources/Pages/XotBasePage.php (Resource)
└── Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php
```

## Confronto: Standalone vs Resource Pages

| Feature | Standalone | Resource |
|---------|-----------|----------|
| Estende | `Filament\Pages\Page` | `Filament\Resources\Pages\Page` |
| Property | `$model` | `$resource` |
| Uso | Form custom, utility | Edit, Create, View record |
| View | Personalizzata | Standard o personalizzata |

## Collegamenti

- [Filament 5 Upgrade Guide](../../../../../../../../../docs/filament-5-upgrade.md)
- [Short Array Syntax Rule](../../../../../../../../../docs/coding-standards.md#array-syntax)
- [Custom Pages - Pdnd Module](../../pdnd/docs/filament-custom-pages.md)
- [Custom Pages - Notify Module](../../notify/docs/filament-custom-pages.md)
