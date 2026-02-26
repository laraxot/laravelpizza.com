# Convenzioni dei Namespace

## Struttura Base dei Namespace

La struttura corretta dei namespace nel framework segue questo pattern:

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

### Struttura Standard
```
Modules/{ModuleName}/
├── Components/
├── ViewModels/
├── Services/
├── Providers/
└── Resources/
    └── views/
        └── components/
```

## Regole Fondamentali

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

## Testing

```php
it('uses correct namespace for components', function () {
    expect(Footer::class)->toBe('Modules\UI\Components\Layout\Footer');
});

it('uses correct namespace for view models', function () {
    expect(FooterViewModel::class)->toBe('Modules\UI\ViewModels\Layout\FooterViewModel');
});
```

## Riferimenti

- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
- [Laravel Module Development](https://laravel.com/project_docs/10.x/packages)
- [Best Practices](../best-practices/README.md)
- [Architettura Modulare](../architecture.md) 

## Collegamenti tra versioni di namespaces.md
* [namespaces.md](docs/conventions/namespaces.md)
* [namespaces.md](../../../Xot/project_docs/conventions/namespaces.md)
* [namespaces.md](../../../Cms/project_docs/conventions/namespaces.md)

