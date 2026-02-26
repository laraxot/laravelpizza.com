# convenzioni per namespace e percorsi dei moduli

## struttura corretta del percorso

uno degli errori più comuni è la confusione tra il namespace nel codice php e il percorso fisico dei file nel filesystem.

### percorso fisico corretto

i file dei moduli devono sempre seguire questa struttura:

```
/var/www/html/base_<nome progetto>/laravel/Modules/{NomeModulo}/app/{Tipo}/...
```

per esempio:
- `/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/app/Filament/Resources/...`
- `/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/app/Models/...`
- `/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/app/Http/Controllers/...`

### namespace corretto

i namespace nei file php devono seguire questa struttura:

```php
namespace Modules\{NomeModulo}\{Tipo}\...;
```

per esempio:
- `namespace Modules\<nome progetto>\Filament\Resources;`
- `namespace Modules\<nome progetto>\Models;`
- `namespace Modules\<nome progetto>\Http\Controllers;`

## errore comune

spesso si confonde il percorso fisico con il namespace, cercando file in:

```
/var/www/html/base_<nome progetto>/laravel/Modules/{NomeModulo}/{Tipo}/...
```

questo è **errato** perché omette la directory `app/` nel percorso fisico.

## verifiche rapide

1. percorso fisico: deve contenere `/app/` dopo il nome del modulo
2. namespace: non deve contenere `app` nel namespace

## esempi corretti

| namespace | percorso fisico |
|-----------|----------------|
| `Modules\<nome progetto>\Filament\Resources\DoctorResource` | `/var/www/html/base_<nome progetto>/laravel/Modules/<nome progetto>/app/Filament/Resources/DoctorResource.php` |
| `Modules\User\Models\User` | `/var/www/html/base_<nome progetto>/laravel/Modules/User/app/Models/User.php` |

## come evitare l'errore

1. usa sempre strumenti come `find_by_name` per verificare il percorso effettivo
2. controlla sempre la corrispondenza tra il namespace e il percorso fisico
3. considera sempre che il percorso fisico contiene `/app/` mentre il namespace no

## linkback

- [convenzioni di codice](/var/www/html/base_<nome progetto>/laravel/project_docs/conventions.md)
- [struttura progetto](/var/www/html/base_<nome progetto>/laravel/project_docs/project-structure.md)
