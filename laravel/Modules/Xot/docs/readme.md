# Xot Module - Framework Base Laraxot
# Laraxot PTVX - Documentazione Consolidata
# Modulo Xot - Documentazione

## Panoramica
Il modulo Xot fornisce le classi base e i componenti fondamentali per l'architettura Laraxot, seguendo il principio di **mai estendere classi Filament direttamente**.

## Componenti Principali

### XotBasePage
Classe base per tutte le pagine personalizzate dell'applicazione.

**Caratteristiche:**
- Estende `Filament\Resources\Pages\Page` invece di classi Filament direttamente
- Fornisce funzionalità comuni per pagine personalizzate
- Gestione automatica delle traduzioni
- Schema form configurabile

## 🎯 **Funzionalità Principali**

**Data Creazione**: 27 Gennaio 2025
**Stato**: Consolidato da docs/ root
**Priorità**: CRITICA (Documentazione principale)
# 🏗️ **Xot Module** - Framework Base Laraxot

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN%20%7C%20DE-green.svg)](https://laravel.com/docs/localization)
[![Base Framework](https://img.shields.io/badge/Framework-Base%20Core-orange.svg)](https://laraxot.com/)
[![Modular Architecture](https://img.shields.io/badge/Architecture-Modular%20Monolith-yellow.svg)](https://martinfowler.com/articles/modular-monolith.html)
[![Quality Score](https://img.shields.io/badge/Quality%20Score-98%25-brightgreen.svg)](https://github.com/laraxot/xot-module)

> **🚀 Modulo Xot**: Framework base e cuore architetturale di Laraxot - fornisce classi base, traits, convenzioni e infrastruttura core per tutti i moduli dell'ecosistema.

## 📋 **Panoramica**

Il modulo **Xot** è il **framework base** di Laraxot, fornendo:

- 🏗️ **Classi Base Universali** - XotBaseResource, XotBaseWidget, XotBaseMigration
- 🔧 **Traits Fondamentali** - HasXotTable, HasXotFactory, HasUuid, HasMedia, HasStates
- 📦 **Service Providers Core** - XotBaseServiceProvider con auto-discovery
- 🎯 **Convenzioni Standard** - Naming, structure, best practices per tutti i moduli
- ⚡ **Infrastruttura Core** - Actions, Enums, Exceptions, Helpers comuni
- 🎨 **Componenti Filament** - Widget, Resources, Forms base per UI consistente

## ⚡ **Architettura Core**

### 🏗️ **Base Classes Pattern**
**Utilizzo:**
```php
class MiaPagina extends XotBasePage
{
    protected static ?string $model = MiaModel::class;

    protected function getFormSchema(): array
    {
        return [
            // Componenti del form
        ];
    }
}
```

## Fix e Correzioni

### getModel() Method Fix
- **Problema**: Errore di sovrascrittura static/non-static
- **Soluzione**: Correzione della dichiarazione del metodo per compatibilità con Filament
- **Documentazione**: [xotbasepage-getmodel-fix.md](./xotbasepage-getmodel-fix.md)

### Filament Resource Creation Fix
- **Problema**: Errori di compatibilità con comandi `make:filament-resource` e `filament:generate-resources`
- **Soluzione**: Corretti errori di compatibilità, registrato comando personalizzato, rimossi file di test problematici
- **Documentazione**: [filament-resource-creation-fix.md](./filament-resource-creation-fix.md)

## Principi Architetturali

### Regola Fondamentale
> **MAI estendere classi Filament direttamente - sempre estendere classi XotBase**

### Regole Critiche Laraxot - DA SEGUIRE SEMPRE

#### 🚫 **Estensioni Classi Filament Vietate**
**MAI estendere direttamente:**
- ❌ `Filament\Resources\Pages\CreateRecord`
- ❌ `Filament\Resources\Pages\EditRecord`
- ❌ `Filament\Resources\Pages\ListRecords`
- ❌ `Filament\Resources\Pages\Page`
- ❌ `Filament\Actions\Action`
- ❌ `Filament\Forms\Components\*`
- ❌ `Filament\Tables\Columns\*`

**✅ SEMPRE estendere le classi XotBase:**
- ✅ `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord`
- ✅ `Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord`
- ✅ `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`
- ✅ `Modules\Xot\Filament\Pages\XotBasePage`
- ✅ `Modules\Xot\Filament\Actions\XotBaseAction`
- ✅ `Modules\Xot\Filament\Components\XotBaseComponent`

#### 🚫 **Proprietà Vietate in XotBasePage**
**Chi estende `XotBasePage` NON DEVE avere:**
```php
// ❌ VIETATO
protected static ?string $navigationIcon = 'heroicon-o-home';
protected static ?string $title = 'Titolo';
protected static ?string $navigationLabel = 'Etichetta';
```

#### 🚫 **Label e Traduzioni Hardcoded**
**MAI usare metodi hardcoded:**
```php
use Modules\Xot\Actions\XotBaseAction;
// ❌ VIETATO
// ❌ VIETATO
TextInput::make('name')->label('Nome')
TextInput::make('name')->label('Nome')
TextColumn::make('status')->placeholder('Stato')
TextColumn::make('status')->placeholder('Stato')
Action::make('edit')->tooltip('Modifica')
Action::make('edit')->tooltip('Modifica')
```
```

**✅ Traduzioni gestite automaticamente via LangServiceProvider:**
```php
// ✅ CORRETTO
TextInput::make('name')
TextColumn::make('status')
Action::make('edit')
```

#### 🚫 **BadgeColumn Deprecato**
**NON usare più BadgeColumn:**
```php
// ❌ DEPRECATO
BadgeColumn::make('status')

// ✅ CORRETTO
TextColumn::make('status')->badge()
```

#### 🚫 **Servizi Tradizionali**
**NON usare Services, ma Spatie QueueableAction:**
```php
// ❌ VIETATO
class UserService
{
    public function process(array $data) { /* ... */ }
}

// ✅ CORRETTO
class ProcessUserAction
{
    use QueueableAction;

    public function execute(UserData $data): UserData
    {

        // Auto-logging con activity trail
        $this->logActivity('user.created', $user);

        // Auto-dispatching eventi
        event(new UserCreated($user));

        return $user;
        // Logica business
        // Logica business
    }
}
```

```php
// Enum base con traduzioni automatiche
use Modules\Xot\Enums\XotBaseEnum;

enum UserStatus: string implements XotBaseEnum
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case SUSPENDED = 'suspended';

    public function getLabel(): string
    {
        return match($this) {
            self::ACTIVE => __('xot::enums.user_status.active'),
            self::INACTIVE => __('xot::enums.user_status.inactive'),
            self::SUSPENDED => __('xot::enums.user_status.suspended'),
        };
    }
}
```

### 🔍 **Advanced Query Filters**
```php
// Sistema filtri per API e ricerche
use Modules\Xot\QueryFilters\XotBaseFilter;
#### 🚫 **getTableColumns() in XotBaseResource**
**Chi estende `XotBaseResource` NON DEVE implementare `getTableColumns()`:**
- ❌ `getTableColumns()` → VIETATO
- ✅ Usa `getTableColumns()` se necessario (ereditato da base)

### Vantaggi
1. **Controllo**: Override locale delle funzionalità
2. **Coerenza**: Comportamento uniforme tra moduli
3. **Manutenibilità**: Modifiche centralizzate
4. **Compatibilità**: Rispetto delle convenzioni PHP
5. **Traduzioni Automatiche**: Gestione centralizzata via LangServiceProvider
6. **Type Safety**: PHPDoc e tipizzazione rigorosa

## Sistema Service Provider

Il modulo Xot fornisce `XotBaseServiceProvider`, la classe base per tutti i ServiceProvider modulari.

**Caratteristiche**:
- Registrazione automatica di view, traduzioni, config, componenti
- Approccio DRY: configurazione minimale richiesta
- Sistema di view namespace resolution integrato
- Discovery automatico moduli

**Documentazione completa**: [Service Provider Architecture](./service-provider-architecture.md)

### Errori Comuni

**"No hint path defined for [namespace]"**
Quando un view namespace non è registrato correttamente. Vedere:
- [Activity Module - Errore No Hint Path](../activity/docs/errori/no-hint-path-defined.md)

## Collegamenti Interni

### Architettura Fondamentale
- [XotBase Architecture Complete](./xotbase-architecture-complete.md) ⭐ **MASTER DOC**
- [Service Provider Architecture](./service-provider-architecture.md)
- [Standalone vs Resource Pages](./filament/standalone-vs-resource-pages.md) ⚠️ **IMPORTANTE**

### Errori Critici
- [Mai Estendere Filament Direttamente](./errori-critici/mai-estendere-filament-direttamente.md) ⚠️ **CRITICO**
- [Differenza Due XotBasePage](./filament/standalone-vs-resource-pages.md) ⚠️ **CRITICO**

### Fix Specifici
- [XotBasePage getModel() Fix](./xotbasepage-getmodel-fix.md)
- [Filament Resource Creation Fix](./filament-resource-creation-fix.md)

## Collegamenti Moduli
- [Activity Module](../activity/docs/README.md)
- [IndennitaResponsabilita Module](../indennitaresponsabilita/docs/README.md)
- [UI Module](../ui/docs/README.md)

## Collegamenti Root
- [Laraxot Conventions](../../../README.md)

*Ultimo aggiornamento: Sistema di documentazione automatica*
*Ultimo aggiornamento: Sistema di documentazione automatica*
