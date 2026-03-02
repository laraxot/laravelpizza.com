# Struttura dei Moduli in <nome progetto>

Questo documento definisce le linee guida ufficiali per la struttura dei moduli all'interno del framework <nome progetto>.

---

## Gestione dati geografici statici: GeoJsonModel readonly (ispirato a Squire)

Per tutti i dati geografici statici (regioni, province, comuni, cap) di dimensioni gestibili, NON creare tabelle/migration dedicate. Utilizzare invece un modello base readonly (`GeoJsonModel`) che legge i dati direttamente da file JSON (es: `Modules/Geo/resources/json/comuni.json`).

- I model specialistici (Region, Province, City, Cap) devono estendere la base GeoJsonModel e fornire metodi di filtro.
- Versionare sempre il file json e documentare la struttura.
- Aggiornare la documentazione di Geo/docs, <nome progetto>/docs e questa stessa doc con collegamenti bidirezionali.

Per dettagli implementativi e best practice vedi:
- [Geo/project_docs/geo-json-model.md](../../geo/project_docs/geo-json-model.md)
- [<nome progetto>/project_docs/geo-integration.md](../../<nome progetto>/project_docs/geo-integration.md)
- [Questa stessa doc (Xot/module-structure.md)](module-structure.md)

---

## Service Provider

### Convenzioni Base

Ogni modulo deve avere un ServiceProvider che estende `XotBaseServiceProvider`. Questo provider è responsabile della registrazione delle risorse del modulo (routes, views, translations, etc.) nell'applicazione.

```php
<?php

declare(strict_types=1);

namespace Modules\NomeModulo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class NomeModuloServiceProvider extends XotBaseServiceProvider {
    // Implementazione
}
```

### Proprietà Obbligatorie

Il ServiceProvider deve definire le seguenti proprietà:

1. **public string $name**: Nome del modulo in formato PascalCase/CamelCase con prima lettera maiuscola (NON $module_name)
   ```php
   public string $name = 'NomeModulo';
   ```

   > **IMPORTANTE**: La stessa proprietà deve essere definita anche nel `RouteServiceProvider` del modulo

2. **protected string $module_dir**: Directory del modulo (default: `__DIR__`)
   ```php
   protected string $module_dir = __DIR__;
   ```

3. **protected string $module_ns**: Namespace del modulo (default: `__NAMESPACE__`)
   ```php
   protected string $module_ns = __NAMESPACE__;
   ```

### Proprietà Opzionali

1. **public string $nameLower**: Versione minuscola del nome del modulo (se non definita, viene generata automaticamente da $name)

### Metodi Personalizzabili

I seguenti metodi possono essere sovrascritti per personalizzare il comportamento del ServiceProvider:

- `register()`: Registra i servizi del modulo nel container
- `registerTranslations()`: Registra le traduzioni
- `registerConfig()`: Registra le configurazioni
- `registerViews()`: Registra le viste
- `registerFactories()`: Registra le factories per i modelli
- `registerCommands()`: Registra i comandi Artisan
- `registerLivewireComponents()`: Registra i componenti Livewire

## Errori Comuni

### Nome del Modulo Mancante o Errato

Se viene mostrato l'errore `name is empty on [Modules\NomeModulo\Providers\NomeModuloServiceProvider]`, significa che:

1. La proprietà `$name` non è stata definita nel ServiceProvider
2. È stata utilizzata `$module_name` invece di `$name`

**Correzione**:
```php
// ERRATO
public string $module_name = 'nomeModulo';
// ERRATO
public string $name = 'nomemodulo';

// CORRETTO
public string $name = 'NomeModulo';
```

## Esempio Completo

```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class BlogServiceProvider extends XotBaseServiceProvider {
    public string $name = 'Blog';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    // Metodi personalizzati se necessario
    public function registerConfig(): void
    {
        // Configurazione personalizzata
        parent::registerConfig();
    }
}
```
# Struttura dei Moduli in il progetto

## Panoramica
Questo documento descrive la struttura standard dei moduli nel progetto il progetto.

## Struttura Base
```
ModuleName/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── auth/
│   │   │   └── ...
│   │   └── components/ # Per Volt
│   ├── Http/
│   ├── Models/
│   └── ...
├── config/
├── database/
├── docs/
├── resources/
│   ├── views/
│   │   ├── pages/      # Per Folio
│   │   │   ├── auth/
│   │   │   └── ...
│   │   └── components/ # Per Volt
│   ├── lang/
│   └── ...
├── routes/
├── tests/
└── composer.json
```

## Collegamenti

### Documentazione Correlata
- [README](../readme.md) - Panoramica del modulo Xot
- [Convenzioni di Naming](./naming-conventions.md) - Regole di naming
- [Case Sensitivity](./directory-case-sensitivity.md) - Regole per la case sensitivity
- [Namespace Rules](./namespace-rules.md) - Regole per i namespace

### Moduli Collegati
- [UI](../ui/docs/readme.md) - Componenti di interfaccia
- [Cms](../cms/docs/readme.md) - Gestione contenuti
- [Lang](../lang/docs/readme.md) - Traduzioni
- [User](../user/docs/readme.md) - Gestione utenti

## Struttura Dettagliata

### Cartella app/
- **Filament/**: Componenti Filament
  - **Resources/**: Risorse Filament
  - **components/**: Componenti Volt
- **Http/**: Controller e middleware
- **Models/**: Modelli del modulo

### Cartella config/
- File di configurazione del modulo
- Override delle configurazioni globali

### Cartella database/
- Migrations
- Seeders
- Factories

### Cartella docs/
- Documentazione del modulo
- Guide di sviluppo
- Best practices

### Cartella resources/
- **views/**: Template Blade
  - **pages/**: Pagine Folio
  - **components/**: Componenti Volt
- **lang/**: File di traduzione
- **assets/**: Risorse statiche

### Cartella routes/
- Definizione delle rotte
- Gruppi di rotte
- Middleware

### Cartella tests/
- Test unitari
- Test di integrazione
- Test funzionali

## Best Practices

### Organizzazione
1. Seguire la struttura standard
2. Mantenere la coerenza tra moduli
3. Documentare le deviazioni
4. Aggiornare la documentazione

### Naming
1. Usare nomi descrittivi
2. Seguire le convenzioni
3. Evitare abbreviazioni
4. Mantenere la coerenza

### Documentazione
1. Mantenere aggiornata
2. Includere esempi
3. Documentare le dipendenze
4. Collegamenti bidirezionali

## Convenzioni di Naming dei Campi

### Regole Fondamentali

In il progetto, è fondamentale seguire queste convenzioni di naming per i campi del database e dei modelli:

#### Campi Utente e Persona

- SEMPRE usare `first_name` (mai `name`)
- SEMPRE usare `last_name` (mai `surname`)

Questa convenzione garantisce:
- Coerenza in tutto il database e il codice
- Compatibilità con API e servizi esterni
- Supporto per l'internazionalizzazione
- Allineamento con gli standard PSR

#### Esempi

```php
// CORRETTO
protected $fillable = [
    'first_name',
    'last_name',
    'email',
];

// ERRATO
protected $fillable = [
    'name',
    'surname',
    'email',
];
```

#### Altri Campi Standard

- Campi temporali: `created_at`, `updated_at`, `deleted_at`, `birth_date`
- Chiavi esterne: `user_id`, `patient_id` (mai `id_user`, `id_patient`)
- Campi booleani: `is_active`, `is_verified`

### Verifica e Correzione

Utilizzare il comando di analisi per verificare la conformità:

```bash
php artisan xot:analyze-naming
```

Per ulteriori dettagli, consultare la [documentazione completa sulle convenzioni di naming](/docs/convenzioni-naming-campi.md).

## Esempi

### Struttura Modulo User
```
User/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── UserResource.php
│   │   │   └── ProfileResource.php
│   │   └── components/
│   │       └── profile-form.php
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
│       ├── User.php
│       └── Profile.php
├── config/
│   └── user.php
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/
│   ├── README.md
│   └── api.md
├── resources/
│   ├── views/
│   │   ├── pages/
│   │   │   └── profile.blade.php
│   │   └── components/
│   │       └── profile-form.blade.php
│   └── lang/
│       └── it/
│           └── user.php
├── routes/
│   └── web.php
└── tests/
    ├── Unit/
    └── Feature/
```

## Collegamenti Moduli

### Modulo UI
- [Componenti Volt](../ui/docs/components/volt.md)
- [Layout](../ui/docs/layouts.md)
- [Temi](../ui/docs/themes.md)
- [Best Practices](../ui/docs/best-practices.md)

### Modulo Cms
- [Frontend](../cms/docs/frontend.md)
- [Temi](../cms/docs/themes.md)
- [Contenuti](../cms/docs/content.md)
- [Convenzioni Filament](../cms/docs/convenzioni-namespace-filament.md)

### Modulo Lang
- [Traduzioni](../lang/docs/translations.md)
- [Localizzazione](../lang/docs/localization.md)
- [API Traduzioni](../lang/docs/api.md)

### Modulo User
- [Autenticazione](../user/docs/auth.md)
- [Permessi](../user/docs/permissions.md)
- [Profilo](../user/docs/profile.md)

### Modulo Patient
- [Gestione Pazienti](../patient/docs/patients.md)
- [Cartelle Cliniche](../patient/docs/records.md)
- [Appuntamenti](../patient/docs/appointments.md)

### Modulo Dental
- [Trattamenti](../dental/docs/treatments.md)
- [Pianificazione](../dental/docs/planning.md)
- [Documenti](../dental/docs/documents.md)

### Modulo Tenant
- [Multi-tenant](../tenant/docs/multi-tenant.md)
- [Configurazione](../tenant/docs/configuration.md)
- [Migrazione](../tenant/docs/migration.md)

### Modulo Media
- [Gestione File](../media/docs/files.md)
- [Upload](../media/docs/upload.md)
- [Storage](../media/docs/storage.md)

### Modulo Notify
- [Notifiche](../notify/docs/notifications.md)
- [Email](../notify/docs/email.md)
- [SMS](../notify/docs/sms.md)

### Modulo Reporting
- [Report](../reporting/docs/reports.md)
- [Esportazione](../reporting/docs/export.md)
- [Analytics](../reporting/docs/analytics.md)

### Modulo Gdpr
- [Privacy](../gdpr/docs/privacy.md)
- [Consensi](../gdpr/docs/consents.md)
- [Sicurezza](../gdpr/docs/security.md)

### Modulo Job
- [Jobs](../job/docs/jobs.md)
- [Queue](../job/docs/queue.md)
- [Scheduling](../job/docs/scheduling.md)

### Modulo Chart
- [Grafici](../chart/docs/charts.md)
- [Dashboard](../chart/docs/dashboard.md)
- [Visualizzazione](../chart/docs/visualization.md)

# Struttura dei Moduli Laravel

## Case Sensitivity e Convenzioni di Naming

### Directory Principali (SEMPRE lowercase)
```
ModuleName/
├── config/
├── database/
├── resources/         ✓ CORRETTO
│   ├── views/
│   ├── lang/
│   └── assets/
├── Resources/         ✗ ERRATO
├── src/
└── tests/
```

### Perché è Importante
1. **Compatibilità con i Filesystem**
   - Linux è case-sensitive
   - Windows e macOS sono case-insensitive
   - Usare lowercase previene problemi di compatibilità

2. **Convenzioni Laravel**
   - Laravel usa `resources/` (lowercase) come standard
   - Tutti i framework moderni usano lowercase per le directory
   - Mantiene consistenza con l'ecosistema Laravel

3. **Problemi Comuni**
   - Git può non rilevare cambi di case
   - Deployment può fallire su sistemi case-sensitive
   - Problemi di autoloading

### Directory Structure Corretta
```
laravel/Modules/Patient/
├── app/
│   ├── Filament/
│   ├── Http/
│   ├── Models/
│   └── Providers/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/           ✓ CORRETTO
│   ├── views/
│   │   ├── components/
│   │   ├── layouts/
│   │   └── pages/
│   ├── lang/
│   └── assets/
├── routes/
├── src/
└── tests/
```

### Regole da Seguire

1. **Nomi Directory Standard**
   - `resources/` NON `Resources/`
   - `views/` NON `Views/`
   - `lang/` NON `Lang/`
   - `assets/` NON `Assets/`

2. **Struttura Views**
   ```
   resources/views/
   ├── components/
   ├── layouts/
   ├── pages/
   └── partials/
   ```

3. **Struttura Assets**
   ```
   resources/assets/
   ├── js/
   ├── css/
   └── images/
   ```

4. **Struttura Lang**
   ```
   resources/lang/
   ├── en/
   └── it/
   ```

### Checklist di Verifica
- [ ] Tutte le directory standard sono in lowercase
- [ ] Nessuna directory `Resources/` (uppercase)
- [ ] Views sono in `resources/views/`
- [ ] Assets sono in `resources/assets/`
- [ ] Traduzioni sono in `resources/lang/`

### Come Correggere Directory Errate

1. **In Locale**
   ```bash
   # Rinomina preservando il contenuto
   mv Resources resources_temp
   mv resources_temp resources
   ```

2. **Su Git**
   ```bash
   git mv Resources resources_temp
   git mv resources_temp resources
   git commit -m "fix: correct resources directory case sensitivity"
   ```

### Note Importanti

1. **Quando Crei Nuovi Moduli**
   - Usa sempre il template corretto
   - Verifica la struttura delle directory
   - Segui le convenzioni di naming

2. **Durante il Development**
   - Controlla regolarmente la struttura
   - Usa tool di linting per il filesystem
   - Mantieni consistenza tra moduli

3. **Prima del Deploy**
   - Verifica che tutte le directory siano lowercase
   - Testa su un sistema case-sensitive
   - Controlla i path nelle configurazioni

### Troubleshooting

Se trovi una directory con case errato:
1. Verifica se ci sono riferimenti nel codice
2. Pianifica la migrazione
3. Aggiorna tutti i riferimenti
4. Rinomina la directory
5. Testa approfonditamente
6. Committa le modifiche

## Collegamenti tra versioni di module_structure.md
* [module_structure.md](../../../../../../../docs/error_analysis/module_structure.md)
