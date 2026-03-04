# Struttura dei Namespace nei Moduli Laravel

Questo documento definisce le linee guida ufficiali per l'utilizzo corretto dei namespace nei moduli Laravel all'interno del framework del progetto.

## Regole Fondamentali

1. **Namespace Base**: Il namespace base per tutti i moduli è `Modules\NomeModulo\` (senza `App\`)
2. **Case Sensitivity**: Rispettare rigorosamente la case sensitivity nei namespace e nei percorsi
3. **Struttura Coerente**: Seguire la struttura standard definita in questo documento per tutti i moduli

## Struttura Corretta dei Namespace

| Tipo di Componente | Namespace Corretto | Namespace Errato |
|-------------------|-------------------|------------------|
| Controllers | `Modules\NomeModulo\Http\Controllers` | ~~`Modules\NomeModulo\App\Http\Controllers`~~ |
| Models | `Modules\NomeModulo\Models` | ~~`Modules\NomeModulo\App\Models`~~ |
| Providers | `Modules\NomeModulo\Providers` | ~~`Modules\NomeModulo\App\Providers`~~ |
| Livewire | `Modules\NomeModulo\Livewire` | ~~`Modules\NomeModulo\App\Livewire`~~ |
| Filament Resources | `Modules\NomeModulo\Filament\Resources` | ~~`Modules\NomeModulo\App\Filament\Resources`~~ |
| Filament Widgets | `Modules\NomeModulo\Filament\Widgets` | ~~`Modules\NomeModulo\App\Filament\Widgets`~~ |

## Struttura delle Directory

La struttura delle directory deve rispecchiare i namespace, con attenzione alla case sensitivity:

```
/Modules/NomeModulo/
  ├── Filament/              # PascalCase
  │   ├── Resources/         # PascalCase
  │   └── Widgets/           # PascalCase
  ├── Http/                  # PascalCase
  │   └── Controllers/       # PascalCase
  ├── Livewire/              # PascalCase
  ├── Models/                # PascalCase
  ├── Providers/             # PascalCase
  ├── config/                # lowercase
  ├── database/              # lowercase
  ├── resources/             # lowercase
  │   ├── assets/            # lowercase
  │   ├── lang/              # lowercase
  │   └── views/             # lowercase
  │       ├── filament/      # lowercase
  │       │   ├── resources/ # lowercase
  │       │   └── widgets/   # lowercase
  │       └── livewire/      # lowercase
  └── routes/                # lowercase
```

## Esempi di Implementazione Corretta

### Controller

```php
// Corretto
namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    // ...
}
```

### Model

```php
// Corretto
namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // ...
}
```

### Service Provider

```php
// Corretto
namespace Modules\Blog\Providers;

use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    // ...
}
```

## Errori Comuni e Soluzioni

### 1. Namespace Errato

```php
// Errato
namespace Modules\Blog\App\Http\Controllers;  // Troppi livelli di annidamento

// Corretto
namespace Modules\Blog\Http\Controllers;
```

### 2. Case Sensitivity

```php
// Errato
namespace Modules\blog\http\controllers;  // Tutto minuscolo

// Corretto
namespace Modules\Blog\Http\Controllers;  // PascalCase per i namespace
```

### 3. Percorsi Errati

```
// Errato
/Modules/Blog/App/Http/Controllers/PostController.php

// Corretto
/Modules/Blog/Http/Controllers/PostController.php
```

## Migrazione da Struttura Errata a Corretta

Se hai già una struttura con i namespace errati, segui questi passaggi per correggerla:

1. Sposta i file nella posizione corretta
2. Aggiorna i namespace nei file
3. Aggiorna tutti i riferimenti ai namespace nei file che li importano
4. Esegui `composer dump-autoload`
5. Verifica che tutto funzioni correttamente

## Strumenti Utili

- `composer dump-autoload` - Rigenera l'autoloader di Composer
- `php artisan make:module:component` - Crea componenti con la struttura corretta (se disponibile nel modulo)
- `php artisan ide-helper:models` - Genera file di aiuto per l'IDE (se si usa Laravel IDE Helper)

## Conclusione

Seguire queste linee guida garantirà una struttura del codice coerente e manutenibile in tutti i moduli del progetto, facilitando la collaborazione tra sviluppatori e riducendo gli errori legati ai namespace.
