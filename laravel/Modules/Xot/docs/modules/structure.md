---
title: "Struttura dei Moduli Laravel (nwidart/laravel-modules)"
type: note
status: unverified
created: 2026-09-24
updated: 2026-10-20
module: Xot
tags: [xot, modules]
qmd: "Struttura dei Moduli Laravel (nwidart/laravel-modules)"
---
# Struttura dei Moduli Laravel (nwidart/laravel-modules)

## Struttura dei percorsi e namespace

Quando si lavora con il pacchetto nwidart/laravel-modules, è essenziale comprendere la differenza tra la struttura fisica dei file e la struttura dei namespace.

### 🔹 Struttura fisica dei file

```
Modules/
  ├── NomeModulo/
  │   ├── app/                      <- Directory che contiene le classi PHP 
  │   │   ├── Models/               <- Modelli
  │   │   ├── Http/                 <- Controller, Middleware, Requests
  │   │   │   ├── Controllers/
  │   │   │   ├── Middleware/
  │   │   │   └── Requests/
  │   │   ├── Providers/            <- Service Provider
  │   │   ├── Services/             <- Servizi
  │   │   └── ...
  │   ├── resources/                <- Risorse (views, assets, traduzioni)
  │   │   ├── views/
  │   │   ├── lang/
  │   │   └── assets/
  │   ├── routes/                   <- File delle rotte 
  │   ├── config/                   <- Configurazioni
  │   ├── database/                 <- Migrazioni e seeders
  │   │   ├── migrations/
  │   │   └── seeders/
  │   ├── Tests/                    <- Test unitari
  │   └── module.json               <- Definizione del modulo
```

### 🔹 Struttura dei namespace

Importante: il namespace **non** include il segmento "app" anche se i file si trovano fisicamente nella directory "app":

```php
namespace Modules\NomeModulo\Models;            // Corretto
namespace Modules\NomeModulo\Http\Controllers;  // Corretto
namespace Modules\NomeModulo\Providers;         // Corretto
```

❌ **NON** utilizzare:
```php
namespace Modules\NomeModulo\app\Models;          // ERRATO
```

### 🔹 Percorsi vs. Namespace

| Percorso Fisico | Namespace Corretto |
|-----------------|-------------------|
| `Modules/Blog/app/Models/Post.php` | `Modules\Blog\Models\Post` |
| `Modules/Blog/app/Http/Controllers/PostController.php` | `Modules\Blog\Http\Controllers\PostController` |
| `Modules/Blog/app/Providers/BlogServiceProvider.php` | `Modules\Blog\Providers\BlogServiceProvider` |

### 🔹 Helpers per i percorsi

Per ottenere il percorso fisico di un modulo, utilizzare:

```php
// Percorso radice del modulo
$modulePath = module_path('NomeModulo');

// Percorso specifico all'interno del modulo
$modelsPath = module_path('NomeModulo', 'app/Models');
```

## Risoluzione dei problemi comuni

### 🔸 Errore di classe non trovata

Se si riceve un errore "Class not found" è possibile che:

1. Il namespace non sia corretto (assicurarsi che **non** includa "app")
2. Il file non si trovi nella directory corretta (dovrebbe essere sotto "app/")
3. Il compositore di Laravel non ha aggiornato l'autoload (eseguire `composer dump-autoload`)

### 🔸 Errore di file non trovato

Se si riceve un errore "File not found" quando si tenta di accedere a un file:

1. Verificare che il percorso fisico sia corretto (dovrebbe includere "app/")
2. Utilizzare helper come `module_path()` per costruire percorsi invece di concatenarli manualmente
