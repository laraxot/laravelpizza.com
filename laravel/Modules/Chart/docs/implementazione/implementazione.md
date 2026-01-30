# Guida all'Implementazione di il progetto

## Panoramica del Progetto

il progetto è un sistema di gestione per il progetto "Promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica". Il sistema è costruito utilizzando:

- **Laravel** come framework PHP di base
- **Laravel Modules** per una struttura modulare
- **Filament** come pannello di amministrazione
- **Laraxot** come suite di moduli core estensibili

## Architettura del Sistema

### Struttura Modulare

Il sistema è organizzato in moduli indipendenti ma interdipendenti:

1. **Moduli Core** (forniti da Laraxot):
   - **Xot**: Modulo base che fornisce funzionalità essenziali
   - **User**: Gestione utenti e autenticazione
   - **Media**: Gestione file e immagini
   - **Activity**: Logging delle attività
   - **Lang**: Gestione multilingua
   - **Tenant**: Supporto multi-tenant
   - **GDPR**: Gestione privacy e conformità GDPR

2. **Moduli Frontend**:
   - **UI**: Componenti UI riutilizzabili
   - **Theme One**: Theme predefinito

3. **Moduli Funzionali**:
   - **Notify**: Sistema di notifiche
   - **CMS**: Gestione contenuti

4. **Moduli Custom** (da implementare):
   - **Patient**: Gestione pazienti e documenti ISEE
   - **Dental**: Gestione visite e trattamenti

5. **Moduli di Utilità**:
   - **Job**: Gestione code e lavori asincroni
   - **Chart**: Generazione grafici e reportistica

## Installazione e Setup

### 1. Requisiti di Sistema

- PHP 8.2+
- Composer 2.5+
- Node.js 18+ e npm
- MySQL 8.0+
- Git 2.3+

### 2. Creazione del Progetto

```bash

# Installare Laravel Installer
composer global require laravel/installer

# Creare un nuovo progetto Laravel
laravel new laravel
cd laravel

# Installare Laravel Modules
composer require nwidart/laravel-modules

# Pubblicare i file di configurazione
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

### 3. Configurazione composer.json

È necessario configurare correttamente il file `composer.json` per l'autoloading dei moduli:

```json
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The skeleton application for the Laravel framework.",
    "keywords": ["laravel", "framework"],
    "license": "MIT",
    "require": {
        "php": "^8.2",
        "laravel/framework": "^11.0",
        "nwidart/laravel-modules": "^10.0"
    },
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/",
            "Modules\\": "Modules/"
        }
    },
    "extra": {
        "laravel": {
            "dont-discover": []
        },
        "merge-plugin": {
            "include": [
                "Modules/*/composer.json"
            ],
            "recurse": true,
            "replace": false,
            "ignore-duplicates": false,
            "merge-dev": true,
            "merge-extra": false,
            "merge-extra-deep": false,
            "merge-scripts": false
        }
    }
}
```

Dopo aver modificato il file, eseguire:

```bash
composer dump-autoload
```

### 4. Importazione dei Moduli Laraxot

Utilizzare git subtree per importare i moduli Laraxot mantenendo la possibilità di aggiornamenti futuri:

```bash

# Creare la directory Modules se non esiste
mkdir -p Modules

# Moduli Core
git subtree add --prefix Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev
git subtree add --prefix Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev
git subtree add --prefix Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev
git subtree add --prefix Modules/User git@github.com:laraxot/module_user_fila3.git dev
git subtree add --prefix Modules/Media git@github.com:laraxot/module_media_fila3.git dev
git subtree add --prefix Modules/Activity git@github.com:laraxot/module_activity_fila3.git dev
git subtree add --prefix Modules/Gdpr git@github.com:laraxot/module_gdpr_fila3.git dev

# Moduli Frontend
git subtree add --prefix Modules/UI git@github.com:laraxot/module_ui_fila3.git dev
git subtree add --prefix Themes/One git@github.com:laraxot/theme_one_fila3.git dev

# Moduli Funzionali
git subtree add --prefix Modules/Notify git@github.com:laraxot/module_notify_fila3.git dev
git subtree add --prefix Modules/Cms git@github.com:laraxot/module_cms_fila3.git dev

# Moduli Utilità
git subtree add --prefix Modules/Job git@github.com:laraxot/module_job_fila3.git dev
git subtree add --prefix Modules/Chart git@github.com:laraxot/module_chart_fila3.git dev
```

### 5. Creazione dei Moduli Custom

```bash

# Creare il modulo Patient
php artisan module:make Patient

# Creare il modulo Dental
php artisan module:make Dental
```

### 6. Installazione di Filament

```bash
composer require filament/filament:"^3.2"
php artisan filament:install --panels
```

### 7. Installazione Spatie Permission

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### 8. Gestione delle Migrazioni

**IMPORTANTE**: In il progetto, tutte le migrazioni sono gestite all'interno dei moduli Laraxot. Prima di eseguire le migrazioni, è necessario rimuovere le migrazioni locali:

```bash

# Rimuovere le migrazioni locali
rm -rf database/migrations

# Eseguire le migrazioni dei moduli
php artisan migrate
```

Questo approccio è fondamentale perché:
- Ogni modulo contiene le proprie migrazioni
- Evita conflitti tra migrazioni locali e dei moduli
- Garantisce l'esecuzione corretta delle migrazioni nell'ordine delle dipendenze
- Mantiene la modularità del sistema

Per maggiori dettagli sulla gestione delle migrazioni, consultare la documentazione tecnica in `/docs/tecnico/10-gestione-migrazioni-moduli.md`.

## Configurazione dei Moduli

### 1. Service Provider

Per i moduli custom, è necessario creare un Service Provider che estende `XotBaseServiceProvider`:

```php
// Modules/Patient/Providers/PatientServiceProvider.php
<?php

namespace Modules\Patient\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class PatientServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Patient';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

### 2. Configurazione module.json

Ogni modulo deve avere un file `module.json` correttamente configurato:

```json
// Modules/Patient/module.json
{
    "name": "Patient",
    "alias": "patient",
    "description": "Gestione pazienti e ISEE",
    "keywords": [],
    "priority": 10,
    "active": 1,
    "order": 10,
    "providers": [
        "Modules\\Patient\\Providers\\PatientServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": [
        "Xot",
        "User",
        "Media",
        "Gdpr"
    ]
}
```

```json
// Modules/Dental/module.json
{
    "name": "Dental",
    "alias": "dental",
    "description": "Gestione visite e trattamenti dentali",
    "keywords": [],
    "priority": 11,
    "active": 1,
    "order": 11,
    "providers": [
        "Modules\\Dental\\Providers\\DentalServiceProvider"
    ],
    "aliases": {},
    "files": [],
    "requires": [
        "Xot",
        "Patient",
        "User",
        "Media"
    ]
}
```

## Struttura dei Moduli Custom

### Modulo Patient

```
Modules/Patient/
├── app/
│   ├── Models/
│   │   ├── Patient.php
│   │   └── IseeDocument.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── PatientResource.php
│   │   │   ├── PatientResource/
│   │   │   │   ├── Pages/
│   │   │   │   └── Widgets/
│   │   │   └── IseeDocumentResource.php
│   │   └── Widgets/
│   ├── Providers/
│   │   └── PatientServiceProvider.php
│   ├── Repositories/
│   │   └── PatientRepository.php
│   └── Services/
│       └── PatientService.php
├── config/
│   └── config.php
├── database/
│   ├── migrations/
│   │   ├── 2024_03_01_000001_create_patients_table.php
│   │   └── 2024_03_01_000002_create_isee_documents_table.php
│   ├── seeders/
│   │   └── PatientSeeder.php
│   └── factories/
│       ├── PatientFactory.php
│       └── IseeDocumentFactory.php
├── resources/
│   ├── assets/
│   ├── lang/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
├── tests/
└── module.json
```

### Modulo Dental

```
Modules/Dental/
├── app/
│   ├── Models/
│   │   ├── Visit.php
│   │   └── Treatment.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── VisitResource.php
│   │   │   └── TreatmentResource.php
│   │   └── Widgets/
│   ├── Providers/
│   │   └── DentalServiceProvider.php
│   ├── Repositories/
│   │   └── VisitRepository.php
│   └── Services/
│       └── DentalService.php
├── config/
│   └── config.php
├── database/
│   ├── migrations/
│   │   ├── 2024_03_01_000003_create_visits_table.php
│   │   └── 2024_03_01_000004_create_treatments_table.php
│   ├── seeders/
│   │   └── DentalSeeder.php
│   └── factories/
│       ├── VisitFactory.php
│       └── TreatmentFactory.php
├── resources/
│   ├── assets/
│   ├── lang/
│   └── views/
├── routes/
│   ├── web.php
│   └── api.php
├── tests/
└── module.json
```

## Filament Panel

Configurare il pannello Filament in `app/Providers/Filament/AdminPanelProvider.php`:

```php
<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Modules\Tenant\Http\Middleware\TenantMiddleware;
use Modules\Gdpr\Http\Middleware\GdprComplianceMiddleware;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                TenantMiddleware::class,
                GdprComplianceMiddleware::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

## Filament Resources

Creare risorse Filament per ogni modello:

### PatientResource.php

```php
<?php

namespace Modules\Patient\app\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Modules\Patient\app\Models\Patient;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class PatientResource extends Resource
{
    protected static ?string $model = Patient::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Gestione Pazienti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('code')
                    ->label('Codice')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('first_name')
                    ->label('Nome')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Cognome')
                    ->required(),
                DatePicker::make('birth_date')
                    ->label('Data di Nascita')
                    ->required(),
                Select::make('gender')
                    ->label('Genere')
                    ->options([
                        'F' => 'Femminile',
                        'M' => 'Maschile',
                        'O' => 'Altro',
                    ])
                    ->required(),
                TextInput::make('tax_code')
                    ->label('Codice Fiscale')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('address')
                    ->label('Indirizzo'),
                TextInput::make('city')
                    ->label('Città'),
                TextInput::make('province')
                    ->label('Provincia'),
                TextInput::make('postal_code')
                    ->label('CAP'),
                TextInput::make('phone')
                    ->label('Telefono'),
                TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Select::make('status')
                    ->label('Stato')
                    ->options([
                        'active' => 'Attivo',
                        'inactive' => 'Inattivo',
                        'suspended' => 'Sospeso',
                    ])
                    ->default('active')
                    ->required(),
                TextInput::make('pregnancy_week')
                    ->label('Settimana di Gravidanza')
                    ->numeric(),
                DatePicker::make('estimated_delivery_date')
                    ->label('Data Presunta Parto'),
                Textarea::make('notes')
                    ->label('Note'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Codice')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Cognome')
                    ->searchable(),
                TextColumn::make('birth_date')
                    ->label('Data di Nascita')
                    ->date('d/m/Y'),
                TextColumn::make('gender')
                    ->label('Genere'),
                TextColumn::make('pregnancy_week')
                    ->label('Settimana di Gravidanza'),
                TextColumn::make('status')
                    ->label('Stato'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'active' => 'Attivo',
                        'inactive' => 'Inattivo',
                        'suspended' => 'Sospeso',
                    ]),
                SelectFilter::make('gender')
                    ->label('Genere')
                    ->options([
                        'F' => 'Femminile',
                        'M' => 'Maschile',
                        'O' => 'Altro',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Relazioni con altri modelli
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPatients::route('/'),
            'create' => Pages\CreatePatient::route('/create'),
            'edit' => Pages\EditPatient::route('/{record}/edit'),
        ];
    }
}
```

## Testing

### PHPUnit Configuration

Configurare PHPUnit in `phpunit.xml`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
>
    <testsuites>
        <testsuite name="Unit">
            <directory>tests/Unit</directory>
        </testsuite>
        <testsuite name="Feature">
            <directory>tests/Feature</directory>
        </testsuite>
        <testsuite name="Modules">
            <directory>Modules/*/Tests</directory>
        </testsuite>
    </testsuites>
    <source>
        <include>
            <directory>app</directory>
            <directory>Modules</directory>
        </include>
    </source>
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="BCRYPT_ROUNDS" value="4"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="DB_CONNECTION" value="sqlite"/>
        <env name="DB_DATABASE" value=":memory:"/>
        <env name="MAIL_MAILER" value="array"/>
        <env name="PULSE_ENABLED" value="false"/>
        <env name="QUEUE_CONNECTION" value="sync"/>
        <env name="SESSION_DRIVER" value="array"/>
        <env name="TELESCOPE_ENABLED" value="false"/>
    </php>
</phpunit>
```

### Test Base per Moduli

```php
// tests/Feature/ModuleTest.php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ModuleTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Verifica che i moduli siano caricati correttamente.
     */
    public function test_modules_are_loaded()
    {
        $modules = app('modules')->all();
        $this->assertNotEmpty($modules);
        
        // Verifica moduli core
        $this->assertArrayHasKey('Xot', $modules);
        $this->assertArrayHasKey('User', $modules);
        $this->assertArrayHasKey('Media', $modules);
        $this->assertArrayHasKey('Gdpr', $modules);
        
        // Verifica moduli custom
        $this->assertArrayHasKey('Patient', $modules);
        $this->assertArrayHasKey('Dental', $modules);
    }
    
    /**
     * Verifica che i service provider dei moduli siano registrati.
     */
    public function test_module_providers_are_registered()
    {
        $this->assertTrue(app()->providerIsLoaded('Modules\Xot\Providers\XotServiceProvider'));
        $this->assertTrue(app()->providerIsLoaded('Modules\Patient\Providers\PatientServiceProvider'));
        $this->assertTrue(app()->providerIsLoaded('Modules\Dental\Providers\DentalServiceProvider'));
    }
}
```

## GDPR e Privacy

### Configurazione GDPR

Il modulo GDPR implementa:

1. **Consenso**: Gestione dei consensi dei pazienti
2. **Esportazione Dati**: Funzionalità per esportare i dati personali
3. **Cancellazione Dati**: Meccanismi per la cancellazione sicura dei dati
4. **Registro Trattamenti**: Tracciamento dei trattamenti dei dati

### Middleware GDPR

Il middleware `GdprComplianceMiddleware` assicura che l'applicazione rispetti le normative GDPR:

```php
// Modules/Gdpr/Http/Middleware/GdprComplianceMiddleware.php
<?php

namespace Modules\Gdpr\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GdprComplianceMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Verifica consenso per l'utente corrente
        if (auth()->check() && !$this->hasValidConsent(auth()->user())) {
            // Reindirizza alla pagina di consenso se necessario
            if (!$request->routeIs('gdpr.consent.*')) {
                return redirect()->route('gdpr.consent.show');
            }
        }

        return $next($request);
    }

    private function hasValidConsent($user)
    {
        // Logica per verificare il consenso
        return true; // Implementare la logica effettiva
    }
}
```

## Deployment

### Script di Deployment

```bash
#!/bin/bash

# File: deploy.sh

echo "Deploying il progetto..."

# Entra nella directory del progetto
cd /path/to/project

# Pull delle ultime modifiche
git pull origin main

# Installa le dipendenze
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Cancella le cache
php artisan optimize:clear

# Esegui le migrazioni
php artisan migrate --force

# Compila gli asset
npm ci
npm run build

# Riavvia i worker delle code
php artisan queue:restart

echo "Deployment completato con successo!"
```

## Best Practices

### Sicurezza

1. **Protezione dati sensibili**: Utilizzare crittografia per i dati sensibili
2. **Validazione input**: Validare rigorosamente tutti gli input utente
3. **Prevenzione CSRF**: Utilizzare i token CSRF per tutte le richieste
4. **Rate Limiting**: Implementare limitazioni di frequenza per le API
5. **Logging**: Mantenere log dettagliati delle attività di sicurezza

### Performance

1. **Cache**: Utilizzare cache per dati frequentemente acceduti
2. **Ottimizzazione Query**: Ottimizzare le query database
3. **Eager Loading**: Utilizzare eager loading per le relazioni
4. **Lazy Loading**: Implementare lazy loading per contenuti pesanti
5. **Asset Management**: Ottimizzare e minimizzare asset JS/CSS

### Manutenibilità

1. **Convenzioni**: Seguire le convenzioni di codice PSR-12
2. **Documentazione**: Documentare ogni componente
3. **Testing**: Implementare test unitari e di integrazione
4. **Versionamento**: Utilizzare semantic versioning per le release
5. **CI/CD**: Implementare pipeline CI/CD per automazione

## Troubleshooting

### Problemi Comuni e Soluzioni

1. **Moduli non caricati**
   - Verificare `composer.json` per il corretto autoloading
   - Verificare che i moduli siano abilitati in `config/modules.php`
   - Controllare eventuali errori nei ServiceProvider

2. **Errori di Database**
   - Verificare la corretta configurazione nel file `.env`
   - Eseguire `php artisan migrate:status` per verificare le migrazioni
   - Controllare i log per errori specifici

3. **Problemi con Filament**
   - Verificare l'installazione di Filament
   - Controllare i permessi degli utenti
   - Verificare che i resources siano correttamente registrati

4. **Problemi di Dipendenze**
   - Verificare i conflitti nel file `composer.json`
   - Eseguire `composer update --with-dependencies`
   - Controllare la compatibilità delle versioni dei pacchetti

## Contatti e Supporto

Per supporto tecnico sul progetto il progetto, contattare:

- **Supporto Tecnico**: support@<nome progetto>.it
- **Documentazione**: https://<nome progetto>.it/docs
