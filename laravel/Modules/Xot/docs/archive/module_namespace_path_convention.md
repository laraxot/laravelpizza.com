# convenzioni per namespace e percorsi dei moduli

## struttura corretta del percorso

uno degli errori più comuni è la confusione tra il namespace nel codice php e il percorso fisico dei file nel filesystem.

### percorso fisico corretto

i file dei moduli devono sempre seguire questa struttura:

```
<<<<<<< HEAD
/var/www/html/base_ptvx/laravel/Modules/{NomeModulo}/app/{Tipo}/...
```

per esempio:
- `/var/www/html/base_ptvx/laravel/Modules/ModuloEsempio/app/Filament/Resources/...`
- `/var/www/html/base_ptvx/laravel/Modules/ModuloEsempio/app/Models/...`
- `/var/www/html/base_ptvx/laravel/Modules/ModuloEsempio/app/Http/Controllers/...`
=======
/var/www/html/base_healthcare_app/laravel/Modules/{NomeModulo}/app/{Tipo}/...
```

per esempio:
- `/var/www/html/base_healthcare_app/laravel/Modules/healthcare_app/app/Filament/Resources/...`
- `/var/www/html/base_healthcare_app/laravel/Modules/healthcare_app/app/Models/...`
- `/var/www/html/base_healthcare_app/laravel/Modules/healthcare_app/app/Http/Controllers/...`
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)

### namespace corretto

i namespace nei file php devono seguire questa struttura:

```php
namespace Modules\{NomeModulo}\{Tipo}\...;
```

per esempio:
<<<<<<< HEAD
- `namespace Modules\ModuloEsempio\Filament\Resources;`
- `namespace Modules\ModuloEsempio\Models;`
- `namespace Modules\ModuloEsempio\Http\Controllers;`
=======
- `namespace Modules\healthcare_app\Filament\Resources;`
- `namespace Modules\healthcare_app\Models;`
- `namespace Modules\healthcare_app\Http\Controllers;`
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)

## errore comune

spesso si confonde il percorso fisico con il namespace, cercando file in:

```
<<<<<<< HEAD
/var/www/html/base_ptvx/laravel/Modules/{NomeModulo}/{Tipo}/...
=======
/var/www/html/base_healthcare_app/laravel/Modules/{NomeModulo}/{Tipo}/...
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
```

questo è **errato** perché omette la directory `app/` nel percorso fisico.

## verifiche rapide

1. percorso fisico: deve contenere `/app/` dopo il nome del modulo
2. namespace: non deve contenere `app` nel namespace

## esempi corretti

| namespace | percorso fisico |
|-----------|----------------|
<<<<<<< HEAD
| `Modules\ModuloEsempio\Filament\Resources\DoctorResource` | `/var/www/html/base_ptvx/laravel/Modules/ModuloEsempio/app/Filament/Resources/DoctorResource.php` |
| `Modules\User\Models\User` | `/var/www/html/base_ptvx/laravel/Modules/User/app/Models/User.php` |
=======
| `Modules\healthcare_app\Filament\Resources\DoctorResource` | `/var/www/html/base_healthcare_app/laravel/Modules/healthcare_app/app/Filament/Resources/DoctorResource.php` |
| `Modules\User\Models\User` | `/var/www/html/base_healthcare_app/laravel/Modules/User/app/Models/User.php` |
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)

## come evitare l'errore

1. usa sempre strumenti come `find_by_name` per verificare il percorso effettivo
2. controlla sempre la corrispondenza tra il namespace e il percorso fisico
3. considera sempre che il percorso fisico contiene `/app/` mentre il namespace no

## linkback

<<<<<<< HEAD
- [convenzioni di codice](/var/www/html/base_ptvx/laravel/docs/conventions.md)
- [struttura progetto](/var/www/html/base_ptvx/laravel/docs/project-structure.md)
=======
- [convenzioni di codice](/var/www/html/base_healthcare_app/laravel/docs/conventions.md)
- [struttura progetto](/var/www/html/base_healthcare_app/laravel/docs/project-structure.md)
>>>>>>> 8116fe6a (docs: replace project-specific references with generic placeholders across documentation)
