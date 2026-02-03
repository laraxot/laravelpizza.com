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
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> cc52d333 (.)
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome progetto>\App\Controllers;

// CORRETTO
namespace Modules\<nome progetto>\Controllers;
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> ce6fc085 (.)
=======
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 67be6ac0 (.)
=======
>>>>>>> 2bad128c (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88ee35c4e (.)
=======
>>>>>>> 358ba79a7 (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 92cca5ade (.)
=======
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome modulo>\App\Controllers;

// CORRETTO
namespace Modules\<nome modulo>\Controllers;
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
namespace Modules\SaluteOra\App\Controllers;

// CORRETTO
namespace Modules\SaluteOra\Controllers;
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> 472bd9dc (.)
=======
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 3bf39332 (.)
=======
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> cf971011 (.)
=======
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 7e4835b8e (.)
namespace Modules\<nome modulo>\App\Controllers;

// CORRETTO
namespace Modules\<nome modulo>\Controllers;
<<<<<<< HEAD
=======
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
```

## esempi corretti vs errati

### corretti ✓
```php
namespace Modules\Xot\Console\Commands;
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> cc52d333 (.)
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome progetto>\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\<nome progetto>\Filament\Resources;
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> ce6fc085 (.)
=======
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 67be6ac0 (.)
=======
>>>>>>> 2bad128c (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88ee35c4e (.)
=======
>>>>>>> 358ba79a7 (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 92cca5ade (.)
=======
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome modulo>\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\<nome modulo>\Filament\Resources;
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
namespace Modules\SaluteOra\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\SaluteOra\Filament\Resources;
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> 472bd9dc (.)
=======
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 3bf39332 (.)
=======
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> cf971011 (.)
=======
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 7e4835b8e (.)
namespace Modules\<nome modulo>\Models;
namespace Modules\User\Services;
namespace Modules\Tenant\Repositories;
namespace Modules\<nome modulo>\Filament\Resources;
<<<<<<< HEAD
=======
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
```

### errati ✗
```php
namespace Modules\Xot\app\Console\Commands;       // errato: 'app' nel namespace
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> cc52d333 (.)
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome progetto>\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\<nome progetto>\Controllers;      // errato: struttura completamente sbagliata
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> ce6fc085 (.)
=======
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 67be6ac0 (.)
=======
>>>>>>> 2bad128c (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88ee35c4e (.)
=======
>>>>>>> 358ba79a7 (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 92cca5ade (.)
=======
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome modulo>\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\<nome modulo>\Controllers;      // errato: struttura completamente sbagliata
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
namespace Modules\SaluteOra\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\SaluteOra\Controllers;      // errato: struttura completamente sbagliata
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> 472bd9dc (.)
=======
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 3bf39332 (.)
=======
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> cf971011 (.)
=======
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 7e4835b8e (.)
namespace Modules\<nome modulo>\App\Models;           // errato: 'App' nel namespace
namespace Modules\User\App\Services;              // errato: 'App' nel namespace
namespace Modules\Tenant\app\Repositories;        // errato: 'app' nel namespace
namespace App\Modules\<nome modulo>\Controllers;      // errato: struttura completamente sbagliata
<<<<<<< HEAD
=======
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
```

## struttura fisica vs namespace

### importante: separazione tra percorso fisico e namespace

Anche se i file sono fisicamente collocati in una directory `app/`, il namespace **non deve mai riflettere** questa struttura.

```
<<<<<<< HEAD
<<<<<<< HEAD
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome modulo>\Models;
=======
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 7e4835b8e (.)
<<<<<<< HEAD
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome modulo>\Models;
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 5a14301c (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 71f31700 (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> d86d643a (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 472bd9dc (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> d86d643a (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 472bd9dc (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 3bf39332 (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> cf971011 (.)
=======
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> e7da37af (.)
=======
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome modulo>\Models;
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
>>>>>>> 62cc8443 (.)
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
>>>>>>> ce6fc085 (.)
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
=======
>>>>>>> 6cba4fe (.)
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
<<<<<<< HEAD
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
=======
>>>>>>> 88e35986 (.)
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
=======
>>>>>>> 6cba4fe (.)
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
=======
>>>>>>> e0b8ebe3 (.)
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
=======
>>>>>>> 6cba4fe (.)
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
=======
>>>>>>> cc52d333 (.)
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
=======
>>>>>>> 6cba4fe (.)
Percorso fisico:    /Modules/SaluteOra/app/Models/Patient.php
Namespace corretto: namespace Modules\SaluteOra\Models;
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome progetto>\Models;
Percorso fisico:    /Modules/<nome progetto>/app/Models/Patient.php
Namespace corretto: namespace Modules\<nome modulo>\Models;
>>>>>>> 551c768c4 (.)
```

### mappatura corretta percorso-namespace

| percorso fisico | namespace corretto |
|-----------------|--------------------|
<<<<<<< HEAD
<<<<<<< HEAD
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome modulo>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome modulo>\Filament\Resources` |
=======
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 7e4835b8e (.)
<<<<<<< HEAD
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome modulo>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome modulo>\Filament\Resources` |
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 5a14301c (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 71f31700 (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> d86d643a (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 472bd9dc (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> d86d643a (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 472bd9dc (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 3bf39332 (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> cf971011 (.)
=======
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> e7da37af (.)
=======
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome modulo>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome modulo>\Filament\Resources` |
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
>>>>>>> 62cc8443 (.)
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
>>>>>>> ce6fc085 (.)
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
=======
>>>>>>> 6cba4fe (.)
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
<<<<<<< HEAD
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
=======
>>>>>>> 88e35986 (.)
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
=======
>>>>>>> 6cba4fe (.)
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
=======
>>>>>>> e0b8ebe3 (.)
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
=======
>>>>>>> 6cba4fe (.)
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
=======
>>>>>>> cc52d333 (.)
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
=======
>>>>>>> 6cba4fe (.)
| `/Modules/SaluteOra/app/Models/Patient.php` | `Modules\SaluteOra\Models` |
| `/Modules/SaluteOra/app/Filament/Resources/PatientResource.php` | `Modules\SaluteOra\Filament\Resources` |
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome modulo>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome modulo>\Filament\Resources` |
>>>>>>> 551c768c4 (.)
| `/Modules/Xot/app/Providers/XotServiceProvider.php` | `Modules\Xot\Providers` |

### struttura directory completa

```
Modules/
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> cc52d333 (.)
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 551c768c4 (.)
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
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> ce6fc085 (.)
=======
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 67be6ac0 (.)
=======
>>>>>>> 2bad128c (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88ee35c4e (.)
=======
>>>>>>> 358ba79a7 (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 92cca5ade (.)
=======
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
  <nome progetto>/
    app/                        // directory fisica
      Console/
        Commands/
          ImportPatient.php     // namespace Modules\<nome modulo>\Console\Commands;
      Models/
        Patient.php            // namespace Modules\<nome modulo>\Models;
      Filament/
        Resources/
          PatientResource.php  // namespace Modules\<nome modulo>\Filament\Resources;
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
  SaluteOra/
    app/                        // directory fisica
      Console/
        Commands/
          ImportPatient.php     // namespace Modules\SaluteOra\Console\Commands;
      Models/
        Patient.php            // namespace Modules\SaluteOra\Models;
      Filament/
        Resources/
          PatientResource.php  // namespace Modules\SaluteOra\Filament\Resources;
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> 472bd9dc (.)
=======
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 3bf39332 (.)
=======
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> cf971011 (.)
=======
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 7e4835b8e (.)
  <nome progetto>/
    app/                        // directory fisica
      Console/
        Commands/
          ImportPatient.php     // namespace Modules\<nome modulo>\Console\Commands;
      Models/
        Patient.php            // namespace Modules\<nome modulo>\Models;
      Filament/
        Resources/
          PatientResource.php  // namespace Modules\<nome modulo>\Filament\Resources;
<<<<<<< HEAD
=======
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 551c768c4 (.)
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
>>>>>>> 6ca989d8 (.)
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
<<<<<<< HEAD
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
php artisan phpstan:analyse --level=1 Modules/SaluteOra
=======
>>>>>>> a5dccfe (.)
>>>>>>> d86d643a (.)
=======
=======
>>>>>>> 17684f52 (.)
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
=======
>>>>>>> 6cba4fe (.)
php artisan phpstan:analyse --level=1 Modules/SaluteOra
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
php artisan phpstan:analyse --level=1 Modules/SaluteOra
=======
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
>>>>>>> a5dccfe (.)
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
<<<<<<< HEAD
=======
>>>>>>> a5dccfe (.)
>>>>>>> d86d643a (.)
=======
=======
>>>>>>> 17684f52 (.)
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
=======
>>>>>>> 6cba4fe (.)
php artisan phpstan:analyse --level=1 Modules/SaluteOra
>>>>>>> c35986f4 (.)
=======
php artisan phpstan:analyse --level=1 Modules/SaluteOra
=======
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
>>>>>>> a5dccfe (.)
>>>>>>> 472bd9dc (.)
=======
=======
>>>>>>> 88e35986 (.)
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 2bad128c (.)
php artisan phpstan:analyse --level=1 Modules/SaluteOra
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
php artisan phpstan:analyse --level=1 Modules/SaluteOra
=======
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
>>>>>>> a5dccfe (.)
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
=======
>>>>>>> e0b8ebe3 (.)
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
=======
>>>>>>> 6cba4fe (.)
php artisan phpstan:analyse --level=1 Modules/SaluteOra
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
php artisan phpstan:analyse --level=1 Modules/SaluteOra
=======
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
>>>>>>> a5dccfe (.)
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
=======
>>>>>>> cc52d333 (.)
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
=======
>>>>>>> 6cba4fe (.)
php artisan phpstan:analyse --level=1 Modules/SaluteOra
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
php artisan phpstan:analyse --level=1 Modules/SaluteOra
=======
php artisan phpstan:analyse --level=1 Modules/<nome progetto>
>>>>>>> a5dccfe (.)
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 17684f52 (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> cc52d333 (.)
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome progetto>\App\Console\Commands;

// CORRETTO ✓
namespace Modules\<nome progetto>\Console\Commands;
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> ce6fc085 (.)
=======
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 67be6ac0 (.)
=======
>>>>>>> 2bad128c (.)
=======
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> 88ee35c4e (.)
=======
>>>>>>> 358ba79a7 (.)
=======
>>>>>>> 88e745db5 (.)
=======
>>>>>>> 92cca5ade (.)
=======
>>>>>>> f8f76a284 (.)
=======
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
namespace Modules\<nome modulo>\App\Console\Commands;

// CORRETTO ✓
namespace Modules\<nome modulo>\Console\Commands;
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 399f46d3 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
=======
>>>>>>> 6cba4fe (.)
>>>>>>> cc52d333 (.)
<<<<<<< HEAD
>>>>>>> f8f76a284 (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
namespace Modules\SaluteOra\App\Console\Commands;

// CORRETTO ✓
namespace Modules\SaluteOra\Console\Commands;
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> d86d643a (.)
=======
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
>>>>>>> 472bd9dc (.)
=======
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
>>>>>>> 3bf39332 (.)
=======
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
>>>>>>> cf971011 (.)
=======
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
>>>>>>> e7da37af (.)
=======
>>>>>>> 7e4835b8e (.)
namespace Modules\<nome modulo>\App\Console\Commands;

// CORRETTO ✓
namespace Modules\<nome modulo>\Console\Commands;
<<<<<<< HEAD
=======
>>>>>>> a5dccfe (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> d86d643a (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
=======
>>>>>>> 472bd9dc (.)
=======
>>>>>>> 5a14301c (.)
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> d86d643a (.)
=======
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
>>>>>>> 472bd9dc (.)
<<<<<<< HEAD
>>>>>>> 62cc8443 (.)
=======
=======
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 3bf39332 (.)
<<<<<<< HEAD
>>>>>>> ab5b3a4f (.)
=======
=======
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
>>>>>>> cf971011 (.)
<<<<<<< HEAD
>>>>>>> 88e745db5 (.)
=======
=======
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
>>>>>>> e7da37af (.)
>>>>>>> 7e4835b8e (.)
=======
>>>>>>> 551c768c4 (.)
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 551c768c4 (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
=======
>>>>>>> 6ca989d8 (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> 71f31700 (.)
=======
=======
>>>>>>> 399f46d3 (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
>>>>>>> 6cba4fe (.)
<<<<<<< HEAD
>>>>>>> 399f46d3 (.)
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> c35986f4 (.)
=======
=======
>>>>>>> 88e35986 (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
>>>>>>> 6cba4fe (.)
<<<<<<< HEAD
>>>>>>> 17684f52 (.)
=======
>>>>>>> 2bad128c (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
<<<<<<< HEAD
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
>>>>>>> a5dccfe (.)
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
=======
>>>>>>> 71f31700 (.)
=======
>>>>>>> 399f46d3 (.)
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> c35986f4 (.)
<<<<<<< HEAD
>>>>>>> 6ca989d8 (.)
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
>>>>>>> 6cba4fe (.)
>>>>>>> 17684f52 (.)
<<<<<<< HEAD
>>>>>>> ce6fc085 (.)
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> 33af3e61 (.)
<<<<<<< HEAD
>>>>>>> 67be6ac0 (.)
=======
=======
>>>>>>> 88e35986 (.)
<<<<<<< HEAD
>>>>>>> 2bad128c (.)
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> 5bd842e3 (.)
<<<<<<< HEAD
>>>>>>> 88ee35c4e (.)
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
>>>>>>> 6cba4fe (.)
>>>>>>> e0b8ebe3 (.)
<<<<<<< HEAD
>>>>>>> 358ba79a7 (.)
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> 03ceeac3 (.)
<<<<<<< HEAD
>>>>>>> 92cca5ade (.)
=======
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_<nome progetto>/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_saluteora/laravel/Modules
>>>>>>> 6cba4fe (.)
>>>>>>> cc52d333 (.)
>>>>>>> f8f76a284 (.)
=======
grep -r "namespace Modules\\\\.*\\\\App\\\\" /var/www/html/base_techplanner_fila3_mono/laravel/Modules
>>>>>>> 551c768c4 (.)
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
