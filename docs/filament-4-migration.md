# Guida alla Migrazione Filament 4

## Cambiamenti Principali da Filament 3 a Filament 4

### 1. Schema → Form

**PRIMA (Filament 3):**
```php
use Filament\Schemas\Schema;

public function form(Schema $schema): Schema
{
    return $schema
        ->components([
            // componenti
        ]);
}
```

**DOPO (Filament 4):**
```php
use Filament\Forms\Form;

public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form
        ->schema([
            // componenti
        ]);
}
```

### 2. Metodi di Schema

**PRIMA (Filament 3):**
```php
$schema->components([...])
$schema->statePath('data')
$schema->model($model)
```

**DOPO (Filament 4):**
```php
$form->schema([...])
$form->statePath('data')
$form->model($model)
```

### 3. Widget e Form

**PRIMA (Filament 3):**
```php
use Filament\Schemas\Schema;

class MyWidget extends Widget
{
    public function getFormSchema(): array
    {
        return [
            // componenti
        ];
    }
}
```

**DOPO (Filament 4):**
```php
use Filament\Forms\Form;

class MyWidget extends Widget
{
    public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
    {
        return $form->schema([
            // componenti
        ]);
    }
}
```

### 4. Resource Forms

**PRIMA (Filament 3):**
```php
public static function form(Schema $schema): Schema
{
    return $schema
        ->schema([
            // componenti
        ]);
}
```

**DOPO (Filament 4):**
```php
public static function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form
        ->schema([
            // componenti
        ]);
}
```

## Pattern di Risoluzione Conflitti

### Conflitto Import
```php
// PRIMA (Filament 3)
use Filament\Schemas\Schema;

// DOPO (Filament 4)
use Filament\Forms\Form;
```

**Risoluzione:**
```php
use Filament\Forms\Form;
```

### Conflitto Metodo
```php
// PRIMA (Filament 3)
public function form(Schema $schema): Schema
{
    return $schema->components([...]);
}

// DOPO (Filament 4)
public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form->schema([...]);
}
```

**Risoluzione:**
```php
public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    return $form->schema([...]);
}
```

## Checklist Migrazione

- [ ] Sostituire `Filament\Schemas\Schema` con `Filament\Forms\Form`
- [ ] Cambiare `->components([...])` in `->schema([...])`
- [ ] Aggiornare type hints nei metodi
- [ ] Verificare che tutti i form funzionino correttamente
- [ ] Eseguire test per verificare la compatibilità

## Collegamenti

- [Documentazione Filament 4 Forms](https://filamentphp.com/docs/4.x/components/form)
- [Guida Migrazione Filament](https://filamentphp.com/docs/4.x/upgrade-guide)
- [XotBaseWidget](../filament/widgets/xotbasewidget.md)
