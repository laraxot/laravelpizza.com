# Architettura Modulo UI

## 🏗️ Panoramica Architetturale

Il modulo UI è il **modulo base** per tutti i componenti UI, interfacce e design system del sistema Laraxot.

## 🎯 Principi Fondamentali

### **DRY (Don't Repeat Yourself)**
- **Componenti Riutilizzabili:** Evitare duplicazione di componenti UI
- **Design System Centralizzato:** Stili e componenti uniformi
- **Template Standardizzati:** Strutture uniformi per tutti i componenti

### **KISS (Keep It Simple, Stupid)**
- **Interfacce Semplici:** Componenti facili da usare e capire
- **API Minimali:** Solo i metodi e proprietà essenziali
- **Struttura Lineare:** Organizzazione logica e prevedibile

## 🏛️ Struttura delle Classi Base

### **BaseComponent**
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Components;

use Illuminate\View\Component;

abstract class BaseComponent extends Component
{
    // Funzionalità comuni per tutti i componenti UI
}
```

### **BaseWidget**
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Widgets\Widget;

abstract class BaseWidget extends Widget
{
    // Funzionalità comuni per tutti i widget
}
```

## 🔄 Flusso di Ereditarietà

```
BaseComponent → Component (UI) → Componente concreto
BaseWidget → Widget (UI) → Widget concreto
```

## 📋 Regole di Implementazione

### **1. Estensione Obbligatoria**
- **MAI** estendere direttamente `Illuminate\View\Component`
- **MAI** estendere direttamente `Filament\Widgets\Widget`
- **SEMPRE** estendere le classi base appropriate del modulo

### **2. Naming Conventions**
- **File:** lowercase con hyphens (`ui-component.md`)
- **Cartelle:** lowercase con hyphens (`filament-widgets/`)
- **Classi:** PascalCase (`UIComponent`)
- **Metodi:** camelCase (`getComponentData`)

### **3. Struttura Standard**
```
app/
├── components/       # Componenti UI
├── widgets/          # Widget Filament
├── views/            # Template Blade
├── assets/           # CSS, JS, immagini
├── lang/             # Traduzioni
└── providers/        # Service provider
```

## 🚫 Anti-pattern da Evitare

### **1. Estensione Diretta**
```php
// MAI fare questo
class Button extends \Illuminate\View\Component
{
    // ...
}
```

### **2. Duplicazione Componenti**
```php
// MAI duplicare componenti già esistenti
class CustomButton extends BaseComponent
{
    // Duplicazione di Button esistente
}
```

### **3. Convenzioni Inconsistenti**
```php
// MAI usare convenzioni diverse
class UIButton extends BaseComponent // ✅ Corretto
class uibutton extends BaseComponent // ❌ Sbagliato
```

## ✅ Best Practices

### **1. Utilizzo Classi Base**
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Components;

use Modules\UI\Components\BaseComponent;

class Button extends BaseComponent
{
    // Implementazione specifica del modulo UI
}
```

### **2. Componenti Riutilizzabili**
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Components;

use Modules\UI\Components\BaseComponent;

class Card extends BaseComponent
{
    public function render()
    {
        return view('ui::components.card');
    }
}
```

### **3. Widget Standardizzati**
```php
<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\UI\Filament\Widgets\BaseWidget;

class StatsOverview extends BaseWidget
{
    // Implementazione specifica del modulo UI
}
```

## 🔧 Configurazione e Setup

### **1. Service Provider Registration**
```php
// Modules/UI/Providers/UIServiceProvider.php
public function boot(): void
{
    parent::boot();
    
    // Registrazione componenti UI
    Blade::componentNamespace('Modules\\UI\\Components', 'ui');
}
```

### **2. Configurazione Modulo**
```php
// Modules/UI/config/config.php
return [
    'name' => 'UI Module',
    'version' => '1.0.0',
    // ...
];
```

### **3. Asset Registration**
```php
// Modules/UI/Providers/UIServiceProvider.php
public function boot(): void
{
    parent::boot();
    
    // Registrazione asset
    $this->publishes([
        __DIR__.'/../resources/assets' => public_path('modules/ui'),
    ], 'ui-assets');
}
```

## 📊 Metriche di Qualità

### **PHPStan Compliance**
- **Livello Minimo:** 9
- **Livello Target:** 10
- **Tipizzazione:** 100% esplicita
- **PHPDoc:** Completo per tutte le classi

### **Code Coverage**
- **Test Unitari:** 100% dei componenti
- **Test di Integrazione:** 100% delle funzionalità
- **Test di Regressione:** Dopo ogni modifica

## 🔗 Collegamenti

- [Best Practices Sistema](../../../docs/core/best-practices.md)
- [Convenzioni Sistema](../../../docs/core/conventions.md)
- [Template Modulo](../../../docs/templates/module-template.md)
- [PHPStan Guide](../development/phpstan-guide.md)

---

**Ultimo aggiornamento:** Gennaio 2025  
**Versione:** 2.0 - Consolidata DRY + KISS
