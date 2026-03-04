# Struttura dei Namespace nei Moduli Laravel in il progetto

Questo documento definisce le linee guida ufficiali per l'utilizzo corretto dei namespace nei moduli Laravel all'interno del framework il progetto.

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
<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    // Implementazione...
}
```

### Model

```php
<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    // Implementazione...
}
```

### Livewire Component

```php
<?php

namespace Modules\User\Livewire;

use Livewire\Component;

class RegistrationForm extends Component
{
    // Implementazione...
}
```

### Filament Widget

```php
<?php

namespace Modules\User\Filament\Widgets;

use Filament\Widgets\Widget;

class RegistrationWidget extends Widget
{
    // Implementazione...
}
```

### Service Provider

```php
<?php

namespace Modules\User\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    // Implementazione...
}
```

## Regole per l'Autoloading

La configurazione di autoloading in `composer.json` deve riflettere questa struttura:

```json
"autoload": {
    "psr-4": {
        "Modules\\": "Modules/"
    }
}
```

## Errori Comuni e Come Evitarli

### 1. Confusione tra Struttura Laravel Standard e Struttura Moduli

**Problema**: Confondere la struttura standard di Laravel (`App\Http\Controllers`) con quella dei moduli.

**Soluzione**: Nei moduli, non utilizzare mai il namespace `App\` e non includere `App\` nel namespace del modulo.

### 2. Case Sensitivity nei Percorsi

**Problema**: Utilizzare la case sensitivity errata nei percorsi delle cartelle.

**Soluzione**:
- Cartelle standard di Laravel: sempre minuscole (`config`, `resources`, `routes`)
- Cartelle specifiche dei namespace: PascalCase (`Models`, `Providers`, `Filament`)

### 3. Riferimenti Errati nei Service Provider

**Problema**: Registrare componenti con namespace errati nei service provider.

**Soluzione**: Verificare sempre che i namespace nei service provider corrispondano alla struttura corretta.

## Strumenti di Verifica

Per verificare la correttezza dei namespace, utilizzare:

1. **PHPStan**: Configurato per rilevare errori di namespace
2. **Composer Dump-Autoload**: Per verificare che l'autoloading funzioni correttamente
3. **Test Unitari**: Per verificare che i componenti siano caricati correttamente

## Migrazione da Struttura Errata

Se hai componenti che utilizzano la struttura errata (`Modules\NomeModulo\App\...`), segui questi passaggi per migrare:

1. Sposta i file nella posizione corretta
2. Aggiorna i namespace nei file
3. Aggiorna tutti i riferimenti ai namespace nei file che li importano
4. Esegui `composer dump-autoload`
5. Verifica che tutto funzioni correttamente

## Conclusione

Seguire queste linee guida garantisce la coerenza in tutto il progetto il progetto e previene errori difficili da diagnosticare. La struttura corretta dei namespace è fondamentale per il corretto funzionamento dei moduli Laravel e per la manutenibilità del codice nel lungo termine.
