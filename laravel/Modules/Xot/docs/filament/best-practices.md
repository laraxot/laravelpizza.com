# Best Practices Filament - Modulo Xot

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Classi Base Uniche:** Estendere sempre XotBaseResource e XotBaseRelationManager
- **Template Standardizzati:** Strutture uniformi per tutte le risorse
- **Componenti Riutilizzabili:** Evitare duplicazione di logica

### **KISS (Keep It Simple, Stupid)**
- **Struttura Semplice:** Organizzazione logica e prevedibile
- **Metodi Essenziali:** Solo i metodi necessari
- **Configurazione Minimal:** Impostazioni essenziali

## 🏗️ Struttura delle Classi Base

### **XotBaseResource**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources;

use Filament\Resources\Resource;

abstract class XotBaseResource extends Resource
{
    // Funzionalità comuni per tutte le risorse Filament
}
```

### **XotBaseRelationManager**
```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

abstract class XotBaseRelationManager extends RelationManager
{
    // Funzionalità comuni per tutti i relation manager
}
```

## 📋 Regole di Implementazione

### **1. Estensione Obbligatoria**
- **MAI** estendere direttamente `Filament\Resources\Resource`
- **MAI** estendere direttamente `Filament\Resources\RelationManagers\RelationManager`
- **SEMPRE** estendere le classi base appropriate del modulo

### **2. Metodi da Implementare**
```php
// ✅ CORRETTO - Implementare solo i metodi necessari
class UserResource extends XotBaseResource
{
    public static function getFormSchema(): array
    {
        return [
            // Schema del form
        ];
    }
    
    public static function getTableColumns(): array
    {
        return [
            // Colonne della tabella
        ];
    }
}
```

### **3. Metodi da NON Implementare**
```php
// ❌ MAI implementare questi metodi nelle classi derivate
public function form(\Filament\Schemas\Schema $form): \Filament\Schemas\Schema
{
    // Questo metodo è già implementato in XotBaseResource
}

public function table(Table $table): Table
{
    // Questo metodo è già implementato in XotBaseResource
}
```

## 🚫 Anti-pattern da Evitare

### **1. Estensione Diretta**
```php
// ❌ MAI fare questo
class UserResource extends \Filament\Resources\Resource
{
    // ...
}
```

### **2. Duplicazione Funzionalità**
```php
// ❌ MAI duplicare funzionalità già presenti nelle classi base
class CustomResource extends XotBaseResource
{
    public function getNavigationLabel() // Già presente in XotBaseResource
    {
        return 'Custom Label';
    }
}
```

### **3. Uso di ->label() Direttamente**
```php
// ❌ MAI usare ->label() direttamente
TextInput::make('name')->label('Nome')
TextColumn::make('email')->label('Email')
Action::make('save')->label('Salva')
```

## ✅ Best Practices

### **1. Utilizzo Classi Base**
```php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    // Implementazione specifica del modulo User
}
```

### **2. Schema Form Standardizzato**
```php
public static function getFormSchema(): array
{
    return [
        Forms\Components\TextInput::make('name')
            ->required()
            ->maxLength(255),
            
        Forms\Components\EmailInput::make('email')
            ->required()
            ->unique(ignoreRecord: true),
            
        Forms\Components\Select::make('role')
            ->options([
                'admin' => 'Amministratore',
                'user' => 'Utente',
            ])
            ->required(),
    ];
}
```

### **3. Colonne Tabella Standardizzate**
```php
public static function getTableColumns(): array
{
    return [
        Tables\Columns\TextColumn::make('name')
            ->searchable()
            ->sortable(),
            
        Tables\Columns\TextColumn::make('email')
            ->searchable()
            ->sortable(),
            
        Tables\Columns\TextColumn::make('role')
            ->badge()
            ->color('primary'),
            
        Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->sortable(),
    ];
}
```

### **4. Azioni Standardizzate**
```php
public static function getTableActions(): array
{
    return [
        Tables\Actions\EditAction::make(),
        Tables\Actions\DeleteAction::make(),
    ];
}

public static function getTableBulkActions(): array
{
    return [
        Tables\Actions\BulkActionGroup::make([
            Tables\Actions\DeleteBulkAction::make(),
        ]),
    ];
}
```

## 🔧 Configurazione e Setup

### **1. Service Provider Registration**
```php
// Modules/User/Providers/UserServiceProvider.php
public function boot(): void
{
    parent::boot();
    
    // Registrazione risorse Filament
    Filament::registerResources([
        UserResource::class,
        ProfileResource::class,
    ]);
}
```

### **2. Configurazione Modulo**
```php
// Modules/User/config/filament.php
return [
    'resources' => [
        'namespace' => 'Modules\User\Filament\Resources',
        'path' => app_path('Modules/User/Filament/Resources'),
    ],
];
```

### **3. Traduzioni Automatiche**
```php
// Modules/User/lang/it/filament.php
return [
    'resources' => [
        'user' => [
            'label' => 'Utente',
            'plural_label' => 'Utenti',
            'navigation_group' => 'Gestione Utenti',
        ],
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
- **Test Unitari:** 100% delle risorse
- **Test di Integrazione:** 100% delle funzionalità
- **Test di Regressione:** Dopo ogni modifica

## 🔗 Collegamenti

- [Architettura Modulo Xot](../core/architecture.md)
- [Convenzioni di Naming](../core/naming-conventions.md)
- [Best Practices Sistema](../../../docs/core/best-practices.md)
- [Template Filament](../templates/filament.md)

---

**Ultimo aggiornamento:** Gennaio 2025  
**Versione:** 2.0 - Consolidata DRY + KISS
