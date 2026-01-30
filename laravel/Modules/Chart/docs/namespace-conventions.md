# convenzioni per i namespace nei moduli

questo documento è un collegamento alla documentazione completa disponibile nel modulo xot:

[vai alla documentazione completa](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/namespace_conventions.md)

## regola critica

**MAI** includere `App` o `app` nel namespace, anche se i file sono fisicamente nella cartella `app/`:

```php
// GRAVEMENTE ERRATO
namespace Modules\<nome progetto>\App\Controllers;

// CORRETTO
namespace Modules\<nome progetto>\Controllers;
```

## differenza tra percorso fisico e namespace

| percorso fisico | namespace corretto |
|-----------------|--------------------|
| `/Modules/<nome progetto>/app/Models/Patient.php` | `Modules\<nome progetto>\Models` |
| `/Modules/<nome progetto>/app/Filament/Resources/PatientResource.php` | `Modules\<nome progetto>\Filament\Resources` |

per dettagli completi, consultare la [documentazione nel modulo xot](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/namespace_conventions.md).
