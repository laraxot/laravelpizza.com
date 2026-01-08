# Registrazione Componenti Blade

## Regola Fondamentale

❌ **NON registrare manualmente i componenti Blade nei ServiceProvider dei moduli o dell'applicazione principale**. La registrazione è gestita automaticamente da `XotBaseServiceProvider`.

## Come Funziona la Registrazione Automatica

1. **Per Moduli**
   - Directory: `Modules/{ModuleName}/View/Components/`
   - Namespace: `Modules\{ModuleName}\View\Components`
   - Prefix: `{module-name}`

2. **Per Temi**
   - Directory: `Themes/{ThemeName}/View/Components/`
   - Namespace: `Themes\{ThemeName}\View\Components`
   - Prefix: `{theme-name}`

3. **Per Applicazione Principale**
   - Directory: `app/View/Components/`
   - Namespace: `App\View\Components`
   - Prefix: `app`

## Struttura Directory Richiesta

```
Module/
├── View/
│   └── Components/
│       ├── Component1.php
│       └── Component2.php
└── resources/
    └── views/
        └── components/
            ├── component1.blade.php
            └── component2.blade.php
```

## Convenzioni di Denominazione

1. **Classi Componenti**
   - Nome file: PascalCase (es. `MyComponent.php`)
   - Nome classe: PascalCase (es. `MyComponent`)
   - Namespace: `{Namespace}\View\Components`

2. **Template Blade**
   - Nome file: kebab-case (es. `my-component.blade.php`)
   - Directory: `resources/views/components/`

## Esempi

### ❌ Cosa NON Fare

```php
// NO: Non registrare manualmente nei ServiceProvider
public function boot(): void
{
    Blade::componentNamespace('Modules\MyModule\View\Components', 'my-module');
    Blade::component('my-component', MyComponent::class);
}
```

### ✅ Cosa Fare

1. **Creare il Componente**
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\View\Components;

use Illuminate\View\Component;

class MyComponent extends Component
{
    public function render()
    {
        return view('my-module::components.my-component');
    }
}
```

2. **Creare il Template**
```blade
{{-- resources/views/components/my-component.blade.php --}}
<div>
    {{ $slot }}
</div>
```

3. **Utilizzare il Componente**
```blade
<x-my-module::my-component>
    Contenuto
</x-my-module::my-component>
```

## Troubleshooting

### Componente Non Trovato
- Verificare che il componente sia nella directory corretta
- Verificare che il namespace sia corretto
- Verificare che il nome del file e della classe seguano le convenzioni

### Template Non Trovato
- Verificare che il template sia nella directory corretta
- Verificare che il nome del file segua le convenzioni
- Verificare che il percorso nel metodo `render()` sia corretto

### Errore di Registrazione
- Verificare che il modulo/tema sia registrato correttamente
- Verificare che il ServiceProvider estenda la classe base corretta
- Verificare che le proprietà `$name` e `$nameLower` siano definite correttamente

## Link Utili
- [XotBaseServiceProvider](XotBaseServiceProvider.md)
- [service-provider-best-practices.md](service-provider-best-practices.md)
- [filament-best-practices.md](filament-best-practices.md) 