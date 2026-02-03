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
namespace Modules\<nome progetto>\App\Controllers;

// CORRETTO
namespace Modules\<nome progetto>\Controllers;
```

## esempi corretti vs errati

### corretti ✓
```php
namespace Modules\Xot\Console\Commands;
namespace Modules\<nome progetto>\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\<nome progetto>\Filament\Resources;
```

### errati ✗
```php
namespace Modules\Xot\app\Console\Commands;       // errato: 'app' nel namespace
namespace Modules\<nome progetto>\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\<nome progetto>\Controllers;      // errato: struttura completamente sbagliata
```

## struttura fisica vs namespace

### importante: separazione tra percorso fisico e namespace

Anche se i file sono fisicamente collocati in una directory `app/`, il namespace **non deve mai riflettere** questa struttura.

```
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
```

### mappatura corretta percorso-namespace

| percorso fisico | namespace corretto |
|-----------------|--------------------|
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/Xot/app/Providers/XotServiceProvider.php` | `Modules\Xot\Providers` |

### struttura directory completa

```
Modules/
  <nome progetto>/
    app/                        // directory fisica
      Console/
        Commands/
          ImportPatient.php     // namespace Modules\<nome progetto>\Console\Commands;
      Models/
        Patient.php            // namespace Modules\<nome progetto>\Models;
      Filament/
        Resources/
          PatientResource.php  // namespace Modules\<nome progetto>\Filament\Resources;
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
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
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
namespace Modules\<nome progetto>\App\Console\Commands;

// CORRETTO ✓
namespace Modules\<nome progetto>\Console\Commands;
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
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
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
