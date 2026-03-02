# Integrazione Folio, Volt e Filament

> **NOTA**: Questo documento è stato unificato con la documentazione sull'architettura Folio + Volt + Filament. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sull'architettura Folio + Volt + Filament](./folio_volt_architecture.md)
- [README](../readme.md) - Panoramica del modulo Xot
- [Struttura dei moduli](./module_structure.md) - Convenzioni di struttura dei moduli
- [Convenzioni di naming](../../../project_docs/convenzioni-naming-campi.md) - Convenzioni per i nomi dei campi

### Moduli Collegati
- [UI](../ui/project_docs/readme.md) - Componenti di interfaccia
- [Cms](../cms/project_docs/readme.md) - Gestione contenuti
- [Lang](../lang/project_docs/readme.md) - Traduzioni

## Struttura

### Pagine Folio con Filament
```
resources/views/pages/
├── admin/
│   ├── dashboard.blade.php
│   └── settings.blade.php
└── filament/
    ├── resources/
    │   └── index.blade.php
    └── widgets/
        └── stats.blade.php
```

### Componenti Volt con Filament
```
resources/views/components/
├── filament/
│   ├── resources/
│   │   └── form.php
│   └── widgets/
│       └── stats-card.php
└── admin/
    └── settings-form.php
```

## Esempi

### Pagina Folio con Filament
```php
<?php

use function Livewire\Volt\{state, mount};
use Filament\Resources\Resource;

state([
    'resource' => null,
]);

mount(function() {
    $this->resource = Resource::make('users');
});

?>

<div>
    <x-filament::resources.index :resource="$resource" />
</div>
```

### Componente Volt con Filament
```php
<?php

use function Livewire\Volt\{state, mount};
use Filament\Forms\Form;

state([
    'form' => null,
]);

mount(function() {
    $this->form = Form::make()
        ->schema([
            // Schema del form
        ]);
});

$submit = function() {
    $this->form->validate();
    // Logica di submit
};

?>

<form wire:submit="submit">
    {{ $this->form }}
    <button type="submit">Salva</button>
</form>
```

## Best Practices

### Organizzazione
1. Separare logica e presentazione
2. Utilizzare componenti riutilizzabili
3. Mantenere la coerenza
4. Documentare le dipendenze

### Performance
1. Minimizzare gli stati
2. Utilizzare lazy loading
3. Ottimizzare re-render
4. Caching quando appropriato

### Sicurezza
1. Validare input
2. Sanitizzare output
3. Proteggere dati sensibili
4. Gestire errori

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
# Integrazione Folio, Volt e Filament

> **NOTA**: Questo documento è stato unificato con la documentazione sull'architettura Folio + Volt + Filament. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sull'architettura Folio + Volt + Filament](./folio_volt_architecture.md)
- [README](../readme.md) - Panoramica del modulo Xot
- [Struttura dei moduli](./module_structure.md) - Convenzioni di struttura dei moduli
- [Convenzioni di naming](../../../docs/convenzioni-naming-campi.md) - Convenzioni per i nomi dei campi

### Moduli Collegati
- [UI](../ui/docs/readme.md) - Componenti di interfaccia
- [Cms](../cms/docs/readme.md) - Gestione contenuti
- [Lang](../lang/docs/readme.md) - Traduzioni

## Struttura

### Pagine Folio con Filament
```
resources/views/pages/
├── admin/
│   ├── dashboard.blade.php
│   └── settings.blade.php
└── filament/
    ├── resources/
    │   └── index.blade.php
    └── widgets/
        └── stats.blade.php
```

### Componenti Volt con Filament
```
resources/views/components/
├── filament/
│   ├── resources/
│   │   └── form.php
│   └── widgets/
│       └── stats-card.php
└── admin/
    └── settings-form.php
```

## Esempi

### Pagina Folio con Filament
```php
<?php

use function Livewire\Volt\{state, mount};
use Filament\Resources\Resource;

state([
    'resource' => null,
]);

mount(function() {
    $this->resource = Resource::make('users');
});

?>

<div>
    <x-filament::resources.index :resource="$resource" />
</div>
```

### Componente Volt con Filament
```php
<?php

use function Livewire\Volt\{state, mount};
use Filament\Forms\Form;

state([
    'form' => null,
]);

mount(function() {
    $this->form = Form::make()
        ->schema([
            // Schema del form
        ]);
});

$submit = function() {
    $this->form->validate();
    // Logica di submit
};

?>

<form wire:submit="submit">
    {{ $this->form }}
    <button type="submit">Salva</button>
</form>
```

## Best Practices

### Organizzazione
1. Separare logica e presentazione
2. Utilizzare componenti riutilizzabili
3. Mantenere la coerenza
4. Documentare le dipendenze

### Performance
1. Minimizzare gli stati
2. Utilizzare lazy loading
3. Ottimizzare re-render
4. Caching quando appropriato

### Sicurezza
1. Validare input
2. Sanitizzare output
3. Proteggere dati sensibili
4. Gestire errori

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
