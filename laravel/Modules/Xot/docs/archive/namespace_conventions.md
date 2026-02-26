# Convenzioni per i Namespace nei Moduli

## Struttura Base
I namespace nei moduli di OrisBroker Framework devono seguire una struttura precisa per mantenere la coerenza del codebase.

### Regola Fondamentale
Il namespace base di ogni modulo è `Modules\{ModuleName}`. È importante notare che **NON** si deve includere `app` nel namespace.

### Esempi Corretti
```php
namespace Modules\Xot\Console\Commands;
namespace Modules\Broker\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
```

### Esempi Errati
```php
namespace Modules\Xot\app\Console\Commands;

### Versione HEAD


### Versione Incoming

namespace Modules\Xot\Console\Commands;

---

namespace Modules\Broker\app\Models;
namespace Modules\User\app\Services;
namespace Modules\Tenant\app\Repositories;
```

## Struttura delle Directory
Anche se i file possono essere fisicamente collocati in una directory `app/`, il namespace non deve riflettere questa struttura.

### Esempio di Struttura Directory
```
Modules/
  Xot/
    app/
      Console/
        Commands/
          ImportMdbToMySQL.php  // namespace Modules\Xot\Console\Commands;
    Models/
    Services/
    Repositories/
```

## Motivazione
Questa convenzione:

# convenzioni per i namespace nei moduli

## regola assoluta e inviolabile

il namespace base di ogni modulo è **sempre e solo** `Modules\{ModuleName}` (dove ModuleName è il nome del modulo con la prima lettera maiuscola).

### errore comune da evitare assolutamente

**MAI** includere `App` o `app` nel namespace, anche se i file sono fisicamente nella cartella `app/`.

Questo è l'errore più comune e grave nelle convenzioni di namespace:

```php
// GRAVEMENTE ERRATO
<<<<<<< HEAD
namespace Modules\ModuloEsempio\App\Controllers;

// CORRETTO
namespace Modules\ModuloEsempio\Controllers;
=======
namespace Modules\healthcare_app\App\Controllers;

// CORRETTO
namespace Modules\healthcare_app\Controllers;
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

## esempi corretti vs errati

### corretti ✓
```php
namespace Modules\Xot\Console\Commands;
<<<<<<< HEAD
namespace Modules\ModuloEsempio\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\ModuloEsempio\Filament\Resources;
=======
namespace Modules\healthcare_app\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\healthcare_app\Filament\Resources;
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

### errati ✗
```php
namespace Modules\Xot\app\Console\Commands;       // errato: 'app' nel namespace
<<<<<<< HEAD
namespace Modules\ModuloEsempio\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\ModuloEsempio\Controllers;      // errato: struttura completamente sbagliata
=======
namespace Modules\healthcare_app\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\healthcare_app\Controllers;      // errato: struttura completamente sbagliata
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

## struttura fisica vs namespace

### importante: separazione tra percorso fisico e namespace

Anche se i file sono fisicamente collocati in una directory `app/`, il namespace **non deve mai riflettere** questa struttura.

```
<<<<<<< HEAD
Percorso fisico:    /Modules/ModuloEsempio/app/Models/Patient.php
Namespace corretto: namespace Modules\ModuloEsempio\Models;
=======
Percorso fisico:    /Modules/healthcare_app/app/Models/Patient.php
Namespace corretto: namespace Modules\healthcare_app\Models;
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

### mappatura corretta percorso-namespace

| percorso fisico | namespace corretto |
|-----------------|--------------------|
<<<<<<< HEAD
| `/Modules/ModuloEsempio/app/Models/Patient.php` | `Modules\ModuloEsempio\Models` |
| `/Modules/ModuloEsempio/app/Filament/Resources/PatientResource.php` | `Modules\ModuloEsempio\Filament\Resources` |
=======
| `/Modules/healthcare_app/app/Models/Patient.php` | `Modules\healthcare_app\Models` |
| `/Modules/healthcare_app/app/Filament/Resources/PatientResource.php` | `Modules\healthcare_app\Filament\Resources` |
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
| `/Modules/Xot/app/Providers/XotServiceProvider.php` | `Modules\Xot\Providers` |

### struttura directory completa

```
Modules/
<<<<<<< HEAD
  ModuloEsempio/
    app/                        // directory fisica
      Console/
        Commands/
          ImportPatient.php     // namespace Modules\ModuloEsempio\Console\Commands;
      Models/
        Patient.php            // namespace Modules\ModuloEsempio\Models;
      Filament/
        Resources/
          PatientResource.php  // namespace Modules\ModuloEsempio\Filament\Resources;
=======
  healthcare_app/
    app/                        // directory fisica
      Console/
        Commands/
          ImportPatient.php     // namespace Modules\healthcare_app\Console\Commands;
      Models/
        Patient.php            // namespace Modules\healthcare_app\Models;
      Filament/
        Resources/
          PatientResource.php  // namespace Modules\healthcare_app\Filament\Resources;
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

## come verificare i namespace

### verifica manuale

Prima di committare un file, verifica sempre che:

1. Il namespace **non** contenga `app` o `App`
2. Il namespace inizi sempre con `Modules\NomeModulo\`
3. Il resto del namespace rifletta la struttura logica delle classi

### uso di phpstan

Utilizza phpstan per verificare automaticamente i namespace:

```bash
<<<<<<< HEAD
php artisan phpstan:analyse --level=1 Modules/ModuloEsempio
=======
php artisan phpstan:analyse --level=1 Modules/healthcare_app
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

## motivazione di questa convenzione
- Mantiene i namespace puliti e coerenti
- Evita confusione con la struttura delle directory
- Facilita l'autoloading e la navigazione del codice
- Segue le best practice di Laravel per i moduli

## Note Importanti
- Questa convenzione si applica a TUTTI i moduli del framework
- Non ci sono eccezioni a questa regola
- I file possono essere fisicamente in `app/` ma il namespace non deve rifletterlo
- Questa convenzione è obbligatoria per mantenere la compatibilità con il framework

## Errori Comuni

### Pattern di Errore: Inclusione di `App` nel Namespace

Un errore comune è includere `App` nel namespace:

```php
// ERRATO ❌
<<<<<<< HEAD
namespace Modules\ModuloEsempio\App\Console\Commands;

// CORRETTO ✓
namespace Modules\ModuloEsempio\Console\Commands;
=======
namespace Modules\healthcare_app\App\Console\Commands;

// CORRETTO ✓
namespace Modules\healthcare_app\Console\Commands;
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

### Conseguenze dell'Errore
- Class not found exceptions
- Problemi con l'autoloading
- Errori di binding resolution nel container Laravel
- Failure nei comandi artisan
- Errori di tipo "Target class does not exist"

## Strumenti di Verifica e Prevenzione

### Verifica Manuale
Utilizzare grep per trovare tutti i file con namespace errato:

```bash
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_ptvx/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_healthcare_app/laravel/Modules
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

### PHP Stan
Configurare PHP Stan per verificare i namespace corretti:

```yaml

# phpstan.neon
parameters:
  checkMissingIterableValueType: false
  checkGenericClassInNonGenericObjectType: false
  checkAlwaysTrueInstanceof: false
  rules:
    - Modules\Xot\Rules\CorrectNamespaceRule
```

### IDE Configuration
Configurare il tuo IDE (PhpStorm, VSCode) per applicare automaticamente le convenzioni di namespace quando si creano nuovi file.

## Come Correggere

1. Individuare tutti i file con namespace errato
2. Correggere il namespace rimuovendo `App\` dal percorso
3. Aggiornare eventuali riferimenti a queste classi in altri file
4. Pulire la cache dell'applicazione dopo le modifiche

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```
