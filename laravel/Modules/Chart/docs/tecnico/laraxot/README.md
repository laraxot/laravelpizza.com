# Framework Laraxot

## Panoramica
Laraxot è un framework modulare basato su Laravel specificamente progettato per applicazioni multi-tenant con pannelli di amministrazione avanzati.

## Moduli Core

### Module XOT (module_xot_fila3)
Il modulo base di Laraxot che fornisce funzionalità core:
- Service Provider principale
- Helper e utility
- Traits comuni
- Middleware
- Commands di base
- Factory di base

### Module LANG (module_lang_fila3)
Gestisce il sistema multilingua:
- Traduzione automatica
- Localizzazione
- Switch lingua
- Traduzioni tenant-specific
- Export/import traduzioni

### Module TENANT (module_tenant_fila3)
Gestisce il multi-tenant:
- Identificazione tenant
- Isolamento dati
- Configurazione tenant
- Middleware tenant
- Database tenant

### Module USER (module_user_fila3)
Gestisce gli utenti:
- Autenticazione
- Autorizzazione
- Gestione profili
- Ruoli e permessi
- Preferenze utente

## Moduli Funzionali

### Module MEDIA (module_media_fila3)
Gestisce i file e i media:
- Upload file
- Image processing
- Storage configurabile
- Conversioni automatiche
- Associazione con modelli

### Module ACTIVITY (module_activity_fila3)
Gestisce il logging delle attività:
- Audit log
- Activity tracking
- Event logging
- Error tracking
- Statistiche

### Module GDPR (module_gdpr_fila3)
Gestisce la privacy:
- Cookie policy
- Privacy policy
- Consensi
- Data export
- Data deletion

### Module NOTIFY (module_notify_fila3)
Sistema di notifiche:
- Email
- In-app
- Push
- SMS
- Canali personalizzati

### Module CMS (module_cms_fila3)
Gestione contenuti:
- Pagine
- Blog
- Articoli
- Categorie
- Tag

### Module JOB (module_job_fila3)
Gestione job in background:
- Code
- Schedule
- Retry
- Monitoring
- Notifiche

## Struttura Moduli

```
ModuleName/
├── app/                     # Codice del modulo
│   ├── Console/             # Comandi Artisan
│   ├── Http/                # Controller, Middleware, Requests
│   ├── Models/              # Modelli Eloquent
│   ├── Providers/           # Service Provider
│   └── ...                  # Altri componenti
├── config/                  # Configurazioni
├── database/
│   ├── migrations/          # Migrazioni specifiche
│   └── seeders/             # Seeders specifici
├── resources/
│   ├── assets/              # Asset specifici
│   ├── lang/                # Traduzioni
│   └── views/               # Viste Blade
├── routes/                  # Route
├── composer.json            # Dipendenze
└── module.json              # Metadati
```

## Tema Filament (theme_one_fila3)
Theme One è il tema principale per Filament 4:
- Personalizzazione UI
- Componenti custom
- Layout admin
- Dark/light mode
- Responsive design

## Installazione

### Primo Utilizzo
```bash

# Clonare il progetto Laravel di base
git clone [url-progetto] my-project
cd my-project

# Installare le dipendenze
composer install

# Installare i moduli Laraxot con git subtree
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash
git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev --squash
git subtree add --prefix laravel/Themes/One git@github.com:laraxot/theme_one_fila3.git dev --squash
```

### Configurazione
```bash

# Setup ambiente
cp .env.example .env
php artisan key:generate

# Migrazioni
php artisan module:migrate

# Publishing assets
php artisan vendor:publish --tag=filament-config
php artisan vendor:publish --tag=xot-config
```

## Convenzioni

### Namespace
I moduli Laraxot utilizzano una struttura particolare per i namespace:
- **Struttura fisica**: `/Modules/Xot/app/Http/Controllers/`
- **Namespace logico**: `Modules\Xot\Http\Controllers\`

### Models
- Tutti i modelli devono usare il trait `BelongsToTenant` in ambiente multi-tenant
- Estendere `Modules\Xot\Models\BaseModel` per la massima compatibilità
- Usare i traits per funzionalità comuni

### Controllers
- Estendere `Modules\Xot\Http\Controllers\BaseController`
- Utilizzare form request per la validazione
- Seguire pattern resource controller

## Best Practices

### NON fare
- NON estendere direttamente classi Filament
- NON modificare i moduli core
- NON creare dipendenze circolari
- NON duplicare codice tra moduli

### FARE
- Creare wrapper personalizzati per Filament
- Utilizzare i traits per estendere funzionalità
- Seguire il pattern di composizione
- Mantenere back-compatibility
- Documentare le modifiche 

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

