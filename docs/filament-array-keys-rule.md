# Filament Array Keys Rule - Array con Chiavi String

**Regola Critica**: Tutti i metodi Filament che restituiscono array devono usare chiavi string
**Status**: Obbligatorio per PHPStan Level 10

---

## 🚨 Regola Assoluta

**Tutti i metodi Filament che restituiscono array DEVONO usare chiavi string quando possibile. Filament v4 accetta anche chiavi int, ma preferire sempre string.**

Metodi interessati:
- `getTableColumns()` → `array<string, Column>` (preferito) o `array<string|int, Column>`
- `getFormSchema()` → `array<string, Component>` (preferito) o `array<string|int, Component>`
- `getTableBulkActions()` → `array<string, BulkAction>` (preferito) o `array<string|int, BulkAction>`
- `getTableActions()` → `array<string, Action>` (preferito) o `array<string|int, Action>`
- `getTableFilters()` → `array<string, Filter>` (preferito) o `array<string|int, Filter>`
- `getHeaderActions()` → `array<string, Action>` (preferito) o `array<string|int, Action>`

**Nota**: `XotBaseResource::getFormSchema()` accetta `array<string|int, Component>` per compatibilità Filament v4, ma **preferire sempre chiavi string** per migliore type safety e leggibilità.

---

## ❌ Pattern SBAGLIATO

```php
// ❌ SBAGLIATO - Array numerico
public function getTableActions(): array
{
    return [
        ViewAction::make(),   // Chiave: 0
        EditAction::make(),   // Chiave: 1
        DeleteAction::make(), // Chiave: 2
    ];
}

// ❌ SBAGLIATO - Array numerico
public static function getFormSchema(): array
{
    return [
        TextInput::make('name'),  // Chiave: 0
        EmailInput::make('email'), // Chiave: 1
    ];
}
```

---

## ✅ Pattern CORRETTO

```php
// ✅ CORRETTO - Array associativo con chiavi string
/** @return array<string, Action> */
public function getTableActions(): array
{
    return [
        'view' => ViewAction::make(),
        'edit' => EditAction::make(),
        'delete' => DeleteAction::make(),
    ];
}

// ✅ CORRETTO - Array associativo con chiavi string
/** @return array<string, Component> */
public static function getFormSchema(): array
{
    return [
        'name_field' => TextInput::make('name'),
        'email_field' => EmailInput::make('email'),
    ];
}

// ✅ CORRETTO - getHeaderActions con chiavi string
/** @return array<string, Action> */
protected function getHeaderActions(): array
{
    return [
        'create' => CreateAction::make(),
        'delete' => DeleteAction::make(),
    ];
}

// ✅ CORRETTO - getTableColumns con chiavi string
/** @return array<string, Column> */
public function getTableColumns(): array
{
    return [
        'name' => TextColumn::make('name'),
        'email' => TextColumn::make('email'),
    ];
}
```

---

## 📋 Esempi Completi

### Resource con Tutti i Metodi

```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\EmailInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteBulkAction;

class UserResource extends XotBaseResource
{
    /**
     * @return array<string, \Filament\Forms\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            'name_field' => TextInput::make('name'),
            'email_field' => EmailInput::make('email'),
        ];
    }

    /**
     * @return array<string, \Filament\Tables\Columns\Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name'),
            'email' => TextColumn::make('email'),
        ];
    }

    /**
     * @return array<string, \Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Actions\Action>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, \Filament\Actions\BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
```

---

## 🔍 Verifica Violazioni

### Script di Verifica

```bash
# Trova metodi che potrebbero restituire array numerici
grep -r "getTableActions\|getTableBulkActions\|getHeaderActions\|getTableColumns\|getFormSchema\|getTableFilters" laravel/Modules --include="*.php" -A 5 | grep -E "return \[|::make\(\)" | grep -v "=>"
```

### Pattern da Cercare

Cerca pattern come:
```php
return [
    Action::make(),  // ❌ Manca chiave string
];
```

Dovrebbe essere:
```php
return [
    'key' => Action::make(),  // ✅ Chiave string presente
];
```

---

## 💡 Motivazione

1. **Type Safety**: PHPStan può verificare meglio i tipi con chiavi esplicite
2. **Filament Compatibility**: Filament si aspetta array associativi per identificare componenti
3. **Manutenibilità**: Chiavi esplicite rendono il codice più leggibile
4. **Debugging**: Più facile identificare componenti in errori

---

## ✅ Checklist

Prima di commit:

- [ ] Tutti i metodi `get*` restituiscono `array<string, T>`
- [ ] Nessun array numerico nei metodi Filament
- [ ] PHPDoc corretto con `@return array<string, T>`
- [ ] PHPStan Level 10 passa senza errori

---

## 🔗 Collegamenti

- [Filament Class Extension Rules](./filament-class-extension-rules.md)
- [PHPStan Code Quality Guide](./phpstan_code_quality_guide.md)

---

