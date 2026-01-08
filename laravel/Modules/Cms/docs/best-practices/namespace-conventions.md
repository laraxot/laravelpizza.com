# Convenzioni dei Namespace

## Struttura Base dei Namespace

La struttura corretta dei namespace nel progetto segue questo pattern:

```php
Modules\{ModuleName}\{Tipo}
```

### Esempi Corretti

✅ **CORRETTO**:
```php
namespace Modules\UI\Components\Layout;
namespace Modules\UI\ViewModels;
namespace Modules\UI\Services;
```

❌ **ERRATO**:
```php
namespace Modules\UI\app\Components\Layout;  // Non usare 'app'
namespace App\Modules\UI\Components;         // Non usare 'App'
namespace UI\Components;                     // Non omettere 'Modules'
```

## Struttura dei Moduli

### UI Module
```
Modules/UI/
├── Components/
│   └── Layout/
│       └── Footer.php
├── ViewModels/
│   └── Layout/
│       └── FooterViewModel.php
├── Services/
├── Providers/
└── Resources/
    └── views/
        └── components/
            └── layout/
                └── footer.blade.php
```

### CMS Module
```
Modules/Cms/
├── Components/
├── ViewModels/
├── Services/
└── Resources/
```

## Esempi di Implementazione

### 1. Component Class
```php
namespace Modules\UI\Components\Layout;

class Footer extends Component
{
    // Implementation
}
```

### 2. ViewModel Class
```php
namespace Modules\UI\ViewModels\Layout;

class FooterViewModel
{
    // Implementation
}
```

### 3. Service Class
```php
namespace Modules\UI\Services;

class ThemeService
{
    // Implementation
}
```

## Importazione nei File

### ✅ CORRETTO:
```php
use Modules\UI\Components\Layout\Footer;
use Modules\UI\ViewModels\Layout\FooterViewModel;
use Modules\UI\Services\ThemeService;
```

### ❌ ERRATO:
```php
use Modules\UI\app\Components\Layout\Footer;           // Non usare 'app'
use App\Modules\UI\ViewModels\Layout\FooterViewModel;  // Non usare 'App'
use UI\Services\ThemeService;                         // Non omettere 'Modules'
```

## Configurazione Composer

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\": "Modules/"
        }
    }
}
```

## Note Importanti

1. **Mai includere 'app' nel namespace**
   - Il namespace inizia direttamente con `Modules`
   - Segue le convenzioni PSR-4

2. **Mantenere la Coerenza**
   - Usare PascalCase per i nomi delle classi
   - Usare PascalCase per i nomi delle directory che fanno parte del namespace
   - Mantenere la struttura delle directory allineata con i namespace

3. **Organizzazione dei File**
   - Raggruppare i file correlati in sottodirectory appropriate
   - Mantenere una struttura pulita e logica
   - Seguire il principio di responsabilità singola

## Testing

```php
it('uses correct namespace for components', function () {
    expect(Footer::class)->toBe('Modules\UI\Components\Layout\Footer');
});

it('uses correct namespace for view models', function () {
    expect(FooterViewModel::class)->toBe('Modules\UI\ViewModels\Layout\FooterViewModel');
});
```

## Collegamenti

- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel Module Development](https://laravel.com/docs/10.x/packages)
- [Best Practices](/laravel/Modules/Cms/docs/best-practices/README.md)
- [Architettura Modulare](/laravel/Modules/Cms/docs/architecture.md) 

## Collegamenti tra versioni di namespace-conventions.md
* [namespace-conventions.md](laravel/Modules/Xot/docs/namespace-conventions.md)
* [namespace-conventions.md](laravel/Modules/User/docs/namespace-conventions.md)
* [namespace-conventions.md](laravel/Modules/Cms/docs/best-practices/namespace-conventions.md)

