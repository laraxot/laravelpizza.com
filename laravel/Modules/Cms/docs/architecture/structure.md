# Struttura del Modulo CMS

## Directory Principali

```
Modules/Cms/
├── app/                    # Codice principale del modulo
│   ├── Http/              # Controllers, Middleware, Requests
│   ├── Models/            # Modelli del modulo
│   ├── Filament/          # Resources e Pages di Filament
│   ├── Providers/         # Service Providers
│   └── Console/           # Comandi Artisan
├── config/                # File di configurazione
├── database/              # Migrations e Seeders
│   ├── migrations/        # Migrations
│   └── seeders/          # Seeders
├── resources/             # Assets e Views
│   ├── views/            # Blade views
│   ├── lang/             # File di traduzione
│   └── assets/           # JS, CSS, immagini
├── routes/                # File delle routes
├── tests/                 # Test del modulo
└── docs/                  # Documentazione del modulo
```

## Convenzioni

1. **Namespace**
   - Tutte le classi devono usare il namespace `Modules\Cms`
   - I namespace devono riflettere la struttura delle directory

2. **Controllers**
   - Devono essere in `app/Http/Controllers`
   - Devono estendere `App\Http\Controllers\Controller`
   - Devono seguire la convenzione di naming `*Controller`

3. **Models**
   - Devono essere in `app/Models`
   - Devono estendere `Illuminate\Database\Eloquent\Model`
   - Devono avere il trait `HasFactory`

4. **Filament Resources**
   - Devono essere in `app/Filament/Resources`
   - Devono estendere `XotBaseResource`
   - Devono seguire le convenzioni di XotBaseResource

5. **Views**
   - Devono essere in `resources/views`
   - Devono usare il prefisso `cms::`
   - Devono seguire le convenzioni Blade

6. **Routes**
   - Devono essere in `routes`
   - Devono usare il prefisso `cms`
   - Devono essere raggruppate per funzionalità

7. **Config**
   - Devono essere in `config`
   - Devono usare il prefisso `cms`
   - Devono essere accessibili via `config('cms.*')`

8. **Translations**
   - Devono essere in `resources/lang`
   - Devono usare il prefisso `cms::`
   - Devono supportare italiano e inglese

## Spostamenti Necessari

1. Spostare i contenuti da:
   - `View/` → `resources/views/`
   - `Models/` → `app/Models/`
   - `Config/` → `config/`
   - `Routes/` → `routes/`
   - `Resources/` → `resources/`
   - `Database/` → `database/`
   - `lang/` → `resources/lang/`
   - `tests/` → `tests/`

2. Rimuovere directory non necessarie:
   - `Datas/`
   - `Presenters/`
   - `Actions/`
   - `bashscripts/`

3. Aggiornare i namespace in tutti i file
4. Aggiornare i riferimenti nei file di configurazione
5. Aggiornare i riferimenti nelle views
6. Aggiornare i riferimenti nelle routes 

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Architettura](architecture.md) - Architettura del sistema CMS
- [Struttura Moduli Laravel](struttura-moduli-laravel.md) - Struttura standard dei moduli Laravel
- [Namespace Moduli](namespace-moduli-laravel-<nome progetto>.md) - Convenzioni di namespace
- [Struttura Route e Viste](struttura-route-e-viste.md) - Organizzazione di route e viste

## Vedi Anche
- [Modulo Xot](../Xot/docs/README.md) - Struttura base dei moduli
- [Documentazione Laravel](https://laravel.com/docs/structure.html) - Struttura standard Laravel 
## Collegamenti tra versioni di structure.md
* [structure.md](bashscripts/docs/structure.md)
* [structure.md](laravel/Modules/Gdpr/docs/structure.md)
* [structure.md](laravel/Modules/Notify/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/structure.md)
* [structure.md](laravel/Modules/Xot/docs/base/structure.md)
* [structure.md](laravel/Modules/Xot/docs/config/structure.md)
* [structure.md](laravel/Modules/User/docs/structure.md)
* [structure.md](laravel/Modules/UI/docs/structure.md)
* [structure.md](laravel/Modules/Lang/docs/structure.md)
* [structure.md](laravel/Modules/Job/docs/structure.md)
* [structure.md](laravel/Modules/Media/docs/structure.md)
* [structure.md](laravel/Modules/Tenant/docs/structure.md)
* [structure.md](laravel/Modules/Activity/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/structure.md)
* [structure.md](laravel/Modules/Cms/docs/themes/structure.md)
* [structure.md](laravel/Modules/Cms/docs/components/structure.md)

