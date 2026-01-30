# Moduli Laraxot per il progetto

## Moduli Core (Essenziali)
1. **module_xot_fila3** - Modulo base con utility e configurazioni core
2. **module_lang_fila3** - Gestione multilingua
3. **module_tenant_fila3** - Supporto multi-tenant
4. **module_user_fila3** - Gestione utenti e autenticazione

## Moduli Frontend
5. **module_ui_fila3** - Interfaccia utente base
6. **theme_one_fila3** - Tema per Filament 4 (da installare in `/laravel/Themes/One/`)

## Moduli Funzionali
7. **module_media_fila3** - Gestione media e file
8. **module_activity_fila3** - Logging e monitoraggio attività
9. **module_gdpr_fila3** - Gestione privacy e GDPR (cruciale!)
10. **module_notify_fila3** - Sistema di notifiche
11. **module_cms_fila3** - Gestione contenuti
12. **module_job_fila3** - Gestione job in background

## Struttura Corretta dei Moduli
```
laravel/Modules/
└── NomeModulo/
    ├── app/                     # Codice del modulo (namespace: Modules\NomeModulo\)
    │   ├── Console/             # Comandi Artisan
    │   ├── Http/                # Controller, Middleware, Requests
    │   ├── Models/              # Modelli Eloquent
    │   ├── Providers/           # Service Provider
    │   └── ...                  # Altri componenti
    ├── config/                  # Configurazioni del modulo
    ├── database/
    │   ├── migrations/          # Migrazioni specifiche del modulo
    │   └── seeders/             # Seeders specifici del modulo
    ├── resources/
    │   ├── assets/              # Asset specifici del modulo
    │   ├── lang/                # Traduzioni
    │   └── views/               # Viste Blade
    ├── routes/                  # Route del modulo
    ├── composer.json            # Dipendenze del modulo
    └── module.json              # Metadati del modulo
```

## Comandi di Installazione
```bash

# Installazione corretta dei moduli
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash

# ... e così via per gli altri moduli

# Installazione corretta del tema
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

## Ordine di Installazione (in base alle dipendenze)
1. module_xot_fila3 (base)
2. module_lang_fila3 (dipende da Xot)
3. module_tenant_fila3 (dipende da Xot)
4. module_ui_fila3 (dipende da Xot)
5. theme_one_fila3 (dipende da UI)
6. module_user_fila3 (dipende da Xot, Tenant)
7. module_media_fila3 (dipende da Xot)
8. module_activity_fila3 (dipende da Xot, User)
9. module_gdpr_fila3 (dipende da Xot, User)
10. module_notify_fila3 (dipende da Xot, User)
11. module_cms_fila3 (dipende da Xot, Media)
12. module_job_fila3 (dipende da Xot)

## Struttura dei Namespace
I moduli Laraxot utilizzano una struttura particolare per i namespace:

1. **Struttura fisica**: I file si trovano nella sottodirectory `app/` del modulo
   - Esempio: `Modules/Chart/app/Providers/ChartServiceProvider.php`

2. **Namespace logico**: Nonostante la posizione fisica, il namespace NON include "App"
   - Esempio: `Modules\Chart\Providers\ChartServiceProvider`

## Manutenzione
- Aggiornamento dipendenze: `composer update`
- Pulizia cache: `php artisan optimize:clear`
- Rimozione migrazioni centrali: `rm -rf database/migrations`
- Esecuzione migrazioni dai moduli: `php artisan module:migrate` 

## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

