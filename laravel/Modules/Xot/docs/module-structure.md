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
# Struttura dei Moduli in <nome progetto>

Questo documento definisce le linee guida ufficiali per la struttura dei moduli all'interno del framework <nome progetto>.

---

## Gestione dati geografici statici: GeoJsonModel readonly (ispirato a Squire)

Per tutti i dati geografici statici (regioni, province, comuni, cap) di dimensioni gestibili, NON creare tabelle/migration dedicate. Utilizzare invece un modello base readonly (`GeoJsonModel`) che legge i dati direttamente da file JSON (es: `Modules/Geo/resources/json/comuni.json`).

- I model specialistici (Region, Province, City, Cap) devono estendere la base GeoJsonModel e fornire metodi di filtro.
- Versionare sempre il file json e documentare la struttura.
- Aggiornare la documentazione di Geo/docs, <nome progetto>/docs e questa stessa doc con collegamenti bidirezionali.

Per dettagli implementativi e best practice vedi:
- [Geo/docs/geo-json-model.md](../../Geo/docs/geo-json-model.md)
- [Geo/docs/geo-json-model.md](../../geo/docs/geo-json-model.md)
- [<nome progetto>/docs/geo-integration.md](../../<nome progetto>/docs/geo-integration.md)
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

## Collegamenti

### Documentazione Correlata
- [README](../readme.md) - Panoramica del modulo Xot
- [Convenzioni di Naming](./naming-conventions.md) - Regole di naming
- [Case Sensitivity](./directory-case-sensitivity.md) - Regole per la case sensitivity
- [Namespace Rules](./namespace-rules.md) - Regole per i namespace

### Moduli Collegati
- [UI](../ui/project_docs/readme.md) - Componenti di interfaccia
- [Cms](../cms/project_docs/readme.md) - Gestione contenuti
- [Lang](../lang/project_docs/readme.md) - Traduzioni
- [User](../user/project_docs/readme.md) - Gestione utenti
- [README](../README.md) - Panoramica del modulo Xot
- [Convenzioni di Naming](./naming-conventions.md) - Regole di naming
- [Case Sensitivity](./DIRECTORY-CASE-SENSITIVITY.md) - Regole per la case sensitivity
- [Namespace Rules](./NAMESPACE-RULES.md) - Regole per i namespace

### Moduli Collegati
- [UI](../UI/project_docs/README.md) - Componenti di interfaccia
- [Cms](../Cms/project_docs/README.md) - Gestione contenuti
- [Lang](../Lang/project_docs/README.md) - Traduzioni
- [User](../User/project_docs/README.md) - Gestione utenti

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

Per ulteriori dettagli, consultare la [documentazione completa sulle convenzioni di naming](/project_docs/convenzioni-naming-campi.md).

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
- [Componenti Volt](../ui/project_docs/components/volt.md)
- [Layout](../ui/project_docs/layouts.md)
- [Temi](../ui/project_docs/themes.md)
- [Best Practices](../ui/project_docs/best-practices.md)

### Modulo Cms
- [Frontend](../cms/project_docs/frontend.md)
- [Temi](../cms/project_docs/themes.md)
- [Contenuti](../cms/project_docs/content.md)
- [Convenzioni Filament](../cms/project_docs/convenzioni-namespace-filament.md)

### Modulo Lang
- [Traduzioni](../lang/project_docs/translations.md)
- [Localizzazione](../lang/project_docs/localization.md)
- [API Traduzioni](../lang/project_docs/api.md)

### Modulo User
- [Autenticazione](../user/project_docs/auth.md)
- [Permessi](../user/project_docs/permissions.md)
- [Profilo](../user/project_docs/profile.md)

### Modulo Patient
- [Gestione Pazienti](../patient/project_docs/patients.md)
- [Cartelle Cliniche](../patient/project_docs/records.md)
- [Appuntamenti](../patient/project_docs/appointments.md)

### Modulo Dental
- [Trattamenti](../dental/project_docs/treatments.md)
- [Pianificazione](../dental/project_docs/planning.md)
- [Documenti](../dental/project_docs/documents.md)

### Modulo Tenant
- [Multi-tenant](../tenant/project_docs/multi-tenant.md)
- [Configurazione](../tenant/project_docs/configuration.md)
- [Migrazione](../tenant/project_docs/migration.md)

### Modulo Media
- [Gestione File](../media/project_docs/files.md)
- [Upload](../media/project_docs/upload.md)
- [Storage](../media/project_docs/storage.md)

### Modulo Notify
- [Notifiche](../notify/project_docs/notifications.md)
- [Email](../notify/project_docs/email.md)
- [SMS](../notify/project_docs/sms.md)

### Modulo Reporting
- [Report](../reporting/project_docs/reports.md)
- [Esportazione](../reporting/project_docs/export.md)
- [Analytics](../reporting/project_docs/analytics.md)

### Modulo Gdpr
- [Privacy](../gdpr/project_docs/privacy.md)
- [Consensi](../gdpr/project_docs/consents.md)
- [Sicurezza](../gdpr/project_docs/security.md)

### Modulo Job
- [Jobs](../job/project_docs/jobs.md)
- [Queue](../job/project_docs/queue.md)
- [Scheduling](../job/project_docs/scheduling.md)

### Modulo Chart
- [Grafici](../chart/project_docs/charts.md)
- [Dashboard](../chart/project_docs/dashboard.md)
- [Visualizzazione](../chart/project_docs/visualization.md)
- [Componenti Volt](../UI/project_docs/components/volt.md)
- [Layout](../UI/project_docs/layouts.md)
- [Temi](../UI/project_docs/themes.md)
- [Best Practices](../UI/project_docs/best-practices.md)

### Modulo Cms
- [Frontend](../Cms/project_docs/frontend.md)
- [Temi](../Cms/project_docs/themes.md)
- [Contenuti](../Cms/project_docs/content.md)
- [Convenzioni Filament](../Cms/project_docs/convenzioni-namespace-filament.md)

### Modulo Lang
- [Traduzioni](../Lang/project_docs/translations.md)
- [Localizzazione](../Lang/project_docs/localization.md)
- [API Traduzioni](../Lang/project_docs/api.md)

### Modulo User
- [Autenticazione](../User/project_docs/auth.md)
- [Permessi](../User/project_docs/permissions.md)
- [Profilo](../User/project_docs/profile.md)

### Modulo Patient
- [Gestione Pazienti](../Patient/project_docs/patients.md)
- [Cartelle Cliniche](../Patient/project_docs/records.md)
- [Appuntamenti](../Patient/project_docs/appointments.md)

### Modulo Dental
- [Trattamenti](../Dental/project_docs/treatments.md)
- [Pianificazione](../Dental/project_docs/planning.md)
- [Documenti](../Dental/project_docs/documents.md)

### Modulo Tenant
- [Multi-tenant](../Tenant/project_docs/multi-tenant.md)
- [Configurazione](../Tenant/project_docs/configuration.md)
- [Migrazione](../Tenant/project_docs/migration.md)

### Modulo Media
- [Gestione File](../Media/project_docs/files.md)
- [Upload](../Media/project_docs/upload.md)
- [Storage](../Media/project_docs/storage.md)

### Modulo Notify
- [Notifiche](../Notify/project_docs/notifications.md)
- [Email](../Notify/project_docs/email.md)
- [SMS](../Notify/project_docs/sms.md)

### Modulo Reporting
- [Report](../Reporting/project_docs/reports.md)
- [Esportazione](../Reporting/project_docs/export.md)
- [Analytics](../Reporting/project_docs/analytics.md)

### Modulo Gdpr
- [Privacy](../Gdpr/project_docs/privacy.md)
- [Consensi](../Gdpr/project_docs/consents.md)
- [Sicurezza](../Gdpr/project_docs/security.md)

### Modulo Job
- [Jobs](../Job/project_docs/jobs.md)
- [Queue](../Job/project_docs/queue.md)
- [Scheduling](../Job/project_docs/scheduling.md)

### Modulo Chart
- [Grafici](../Chart/project_docs/charts.md)
- [Dashboard](../Chart/project_docs/dashboard.md)
- [Visualizzazione](../Chart/project_docs/visualization.md)

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
* [module_structure.md](../../../../../docs/project/error_analysis/module_structure.md)