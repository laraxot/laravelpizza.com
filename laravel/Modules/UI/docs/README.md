# 🎨 UI Module - Componenti e Interfaccia Utente

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)

> **Status**: ✅ UI Components Module

## 📋 Panoramica

Il modulo **UI** fornisce componenti, widget e funzionalità di interfaccia utente condivise per l'ecosistema Laraxot.

## ⚡ Funzionalità Core

### 🧩 Blade Components
```php
// Componente riutilizzabile
<x-ui.card>
    <x-slot:header>
        <h2>Dashboard</h2>
    </x-slot:header>
    <x-ui.button variant="primary">Crea Nuovo</x-ui.button>
</x-ui.card>
```

### 🎨 Filament Widgets
```php
class UserCalendarWidget extends XotBaseWidget
{
    protected static string $view = 'ui::filament.widgets.user-calendar';

    public function getViewData(): array
    {
        return [
            'events' => $this->getUserEvents(),
            'layout' => TableLayoutEnum::GRID,
        ];
    }
}
```

### 📱 TableLayoutEnum System
Sistema di layout per tabelle Filament (lista/griglia) con traduzioni automatiche.

## 📦 Installazione

```bash
php artisan module:enable UI
php artisan vendor:publish --tag=ui-config
npm run build
```

## 🎯 Regole Critiche

### ❌ MAI usare ->label()
```php
// ERRORE
TextColumn::make('name')->label('Nome')

// ✅ CORRETTO
TextColumn::make('name')
```

### ✅ SEMPRE usa transClass() negli Enum
```php
enum TableLayoutEnum: string implements HasColor, HasIcon, HasLabel
{
    use TransTrait;

    case LIST = 'list';
    case GRID = 'grid';

    public function getLabel(): string
    {
        return $this->transClass(self::class, $this->value . '.label');
    }
}
```

## ✅ Stato Qualità

- **PHPStan Level 10**: ✅ Compliant
- **Translation Standards**: ✅ 100%
- **Componenti**: 50+ Blade components
- **Widget**: 20+ Filament widgets

## 📚 Documentazione

- [Components Guide](components.md)
- [TableLayoutEnum Guide](table-layout-enum-complete-guide.md)
- [Filament Components](filament-components.md)

## 🔗 Moduli Collegati

- [Xot Module](../xot/docs/readme.md) - Framework core
- [User Module](../user/docs/readme.md) - Gestione utenti
- [Lang Module](../lang/docs/readme.md) - Traduzioni

---

**🔄 Ultimo aggiornamento**: 27 Gennaio 2025
**📦 Versione**: 4.1.0

## 🔁 CI & Semantic Versioning
Workflow: `.github/workflows/semantic-versioning.yml`

## 📄 License
MIT
