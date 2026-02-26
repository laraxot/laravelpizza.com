# Integrazione Folio, Volt e Filament

> **NOTA**: Questo documento è stato unificato con la documentazione sull'architettura Folio + Volt + Filament. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sull'architettura Folio + Volt + Filament](./FOLIO_VOLT_ARCHITECTURE.md)
- [README](../README.md) - Panoramica del modulo Xot
- [Struttura dei moduli](./MODULE_STRUCTURE.md) - Convenzioni di struttura dei moduli
- [Convenzioni di naming](../../../project_docs/convenzioni-naming-campi.md) - Convenzioni per i nomi dei campi

### Moduli Collegati
- [UI](../UI/project_docs/README.md) - Componenti di interfaccia
- [Cms](../Cms/project_docs/README.md) - Gestione contenuti
- [Lang](../Lang/project_docs/README.md) - Traduzioni

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
