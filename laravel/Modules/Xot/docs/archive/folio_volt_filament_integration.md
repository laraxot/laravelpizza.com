# Integrazione Folio, Volt e Filament

> **NOTA**: Questo documento è stato unificato con la documentazione sull'architettura Folio + Volt + Filament. Consulta il documento aggiornato nel link sottostante.

## Collegamenti

- [Documentazione completa sull'architettura Folio + Volt + Filament](./FOLIO_VOLT_ARCHITECTURE.md)
- [README](../README.md) - Panoramica del modulo Xot
- [Struttura dei moduli](./MODULE_STRUCTURE.md) - Convenzioni di struttura dei moduli
- [Convenzioni di naming](../../../docs/convenzioni-naming-campi.md) - Convenzioni per i nomi dei campi

### Moduli Collegati
- [UI](../UI/docs/README.md) - Componenti di interfaccia
- [Cms](../Cms/docs/README.md) - Gestione contenuti
- [Lang](../Lang/docs/README.md) - Traduzioni

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
- [Componenti Volt](../UI/docs/components/volt.md)
- [Layout](../UI/docs/layouts.md)
- [Temi](../UI/docs/themes.md)
- [Best Practices](../UI/docs/best-practices.md)

### Modulo Cms
- [Frontend](../Cms/docs/frontend.md)
- [Temi](../Cms/docs/themes.md)
- [Contenuti](../Cms/docs/content.md)
- [Convenzioni Filament](../Cms/docs/convenzioni-namespace-filament.md)

### Modulo Lang
- [Traduzioni](../Lang/docs/translations.md)
- [Localizzazione](../Lang/docs/localization.md)
- [API Traduzioni](../Lang/docs/api.md)

### Modulo User
- [Autenticazione](../User/docs/auth.md)
- [Permessi](../User/docs/permissions.md)
- [Profilo](../User/docs/profile.md)

### Modulo Patient
- [Gestione Pazienti](../Patient/docs/patients.md)
- [Cartelle Cliniche](../Patient/docs/records.md)
- [Appuntamenti](../Patient/docs/appointments.md)

### Modulo Dental
- [Trattamenti](../Dental/docs/treatments.md)
- [Pianificazione](../Dental/docs/planning.md)
- [Documenti](../Dental/docs/documents.md)

### Modulo Tenant
- [Multi-tenant](../Tenant/docs/multi-tenant.md)
- [Configurazione](../Tenant/docs/configuration.md)
- [Migrazione](../Tenant/docs/migration.md)

### Modulo Media
- [Gestione File](../Media/docs/files.md)
- [Upload](../Media/docs/upload.md)
- [Storage](../Media/docs/storage.md)

### Modulo Notify
- [Notifiche](../Notify/docs/notifications.md)
- [Email](../Notify/docs/email.md)
- [SMS](../Notify/docs/sms.md)

### Modulo Reporting
- [Report](../Reporting/docs/reports.md)
- [Esportazione](../Reporting/docs/export.md)
- [Analytics](../Reporting/docs/analytics.md)

### Modulo Gdpr
- [Privacy](../Gdpr/docs/privacy.md)
- [Consensi](../Gdpr/docs/consents.md)
- [Sicurezza](../Gdpr/docs/security.md)

### Modulo Job
- [Jobs](../Job/docs/jobs.md)
- [Queue](../Job/docs/queue.md)
- [Scheduling](../Job/docs/scheduling.md)

### Modulo Chart
- [Grafici](../Chart/docs/charts.md)
- [Dashboard](../Chart/docs/dashboard.md)
- [Visualizzazione](../Chart/docs/visualization.md)
