# Architettura Folio + Volt + Filament in il progetto

## Panoramica
Questo documento descrive l'architettura frontend basata su Folio, Volt e Filament nel progetto il progetto, con particolare attenzione alle convenzioni di naming, all'integrazione tra componenti e alle best practice.

## Collegamenti

### Documentazione Correlata
- [README](../README.md) - Panoramica del modulo Xot
- [Struttura dei Moduli](./MODULE_STRUCTURE.md) - Convenzioni di struttura dei moduli
- [Convenzioni di Naming](../../../project_docs/convenzioni-naming-campi.md) - Convenzioni per i nomi dei campi
- [Flusso di Registrazione](../../../project_docs/flusso-registrazione.md) - Implementazione del wizard multi-step

### Moduli Collegati
- [UI](../../UI/project_docs/README.md) - Componenti di interfaccia
- [Cms](../../Cms/project_docs/README.md) - Gestione contenuti
- [Lang](../../Lang/project_docs/README.md) - Traduzioni
- [Patient](../../Patient/project_docs/README.md) - Gestione pazienti

## Regole Fondamentali

### Case Sensitivity e Struttura delle Directory

In il progetto, è fondamentale rispettare le seguenti regole:

1. **Case Sensitivity**: Rispettare rigorosamente la case sensitivity nelle directory
   - `resources/` è CORRETTO, `Resources/` è ERRATO
   - `config/` è CORRETTO, `Config/` è ERRATO
   - `views/` è CORRETTO, `Views/` è ERRATO

2. **Codice PHP**: Tutto il codice PHP deve essere nella sottodirectory `app` del modulo
   - `/Modules/User/app/Filament/Widgets/` è CORRETTO
   - `/Modules/User/Filament/Widgets/` è ERRATO

3. **Namespace**: Il namespace non deve includere il segmento `app` anche se i file sono fisicamente in quella directory
   - ✅ CORRETTO: `namespace Modules\User\Filament\Widgets;`
   - ❌ ERRATO: `namespace Modules\User\App\Filament\Widgets;`

Questa convenzione è particolarmente importante per garantire la compatibilità tra diversi sistemi operativi (Linux è case-sensitive, Windows e macOS generalmente no).

### Cartelle con Nomi Sensibili al Case

| Nome Corretto (✅) | Nome Errato (❌) | Note |
|-------------------|-----------------|------|
| `resources/`      | `Resources/`    | Le risorse del modulo devono sempre usare il nome minuscolo |
| `config/`         | `Config/`       | Le configurazioni devono sempre usare il nome minuscolo |
| `views/`          | `Views/`        | Le viste devono sempre usare il nome minuscolo |
| `images/`         | `Images/`       | Le immagini devono sempre usare il nome minuscolo |
| `lang/`           | `Lang/`         | I file di traduzione devono sempre usare il nome minuscolo |

## Struttura

### Pagine Folio
```
Themes/{ThemeName}/resources/views/pages/
├── auth/
│   ├── login.blade.php
│   └── register.blade.php
├── dashboard/
│   └── index.blade.php
└── profile/
    └── edit.blade.php
```

### Componenti Volt
```
resources/views/components/
├── auth/
│   ├── login-form.php
│   └── register-form.php
├── dashboard/
│   └── stats-card.php
└── profile/
    └── edit-form.php
```

## Esempi

### Pagina Folio
```php
<?php

use function Livewire\Volt\{state, mount};

state([
    'user' => null,
]);

mount(function() {
    $this->user = auth()->user();
});

?>

<div>
    <x-profile.edit-form :user="$user" />
</div>
```

### Componente Volt
```php
<?php

use function Livewire\Volt\{state, mount};

state([
    'name' => '',
    'email' => '',
]);

mount(function($user) {
    $this->name = $user->name;
    $this->email = $user->email;
});

$update = function() {
    $this->validate([
        'name' => 'required|min:3',
        'email' => 'required|email',
    ]);
    
    auth()->user()->update([
        'name' => $this->name,
        'email' => $this->email,
    ]);
    
    $this->dispatch('profile-updated');
};

?>

<form wire:submit="update">
    <input type="text" wire:model="name">
    <input type="email" wire:model="email">
    <button type="submit">Aggiorna</button>
</form>
```

## Integrazione con Filament

### Pattern per Form Complessi

Per i form complessi in il progetto (come registrazione, wizard multi-step, ecc.), utilizzare **sempre** i widget Filament tramite Livewire, invece di implementare la logica direttamente nelle viste Blade con Volt.

```php
// In una vista Blade (es. register.blade.php)
@livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class, ['type' => 'patient'])
```

#### Vantaggi dell'approccio Livewire + Widget Filament
- **Separazione delle responsabilità**: logica del form nei widget, presentazione nelle viste
- **Riutilizzo del codice**: widget utilizzabili in più punti dell'applicazione
- **Manutenibilità superiore**: modifiche alla logica in un unico punto
- **Funzionalità avanzate**: validazione, gestione errori, componenti interattivi
- **Coerenza architettonica**: segue il pattern utilizzato in tutta l'applicazione

#### Quando usare Volt vs Widget Filament
- **Widget Filament**: per form complessi, wizard multi-step, validazione avanzata
- **Volt**: per componenti più semplici, logica specifica della pagina, interazioni UI

#### Errori da evitare
- ❌ NON reimplementare form complessi direttamente nelle viste con Volt
- ❌ NON duplicare la logica di validazione già presente nei widget Filament
- ❌ NON mischiare approcci diversi per lo stesso tipo di funzionalità

### Routing con Folio

⚠️ **IMPORTANTE**: Non creare mai rotte in `routes/web.php` per il frontoffice. Utilizzare sempre il routing basato su file di Laravel Folio.

Le pagine sono definite come file Blade nella directory `Themes/{ThemeName}/resources/views/pages/` e diventano automaticamente rotte accessibili basate sul loro percorso.

#### Esempio di pagina Folio con Livewire

```php
<?php
use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

name('register');
middleware(['guest']);

new class extends Component {
    // Logica minima del componente
};
?>

<x-layouts.app>
    <div class="container mx-auto">
        <!-- Integrazione del widget Filament -->
        @livewire(\Modules\User\Filament\Widgets\RegistrationWidget::class, ['type' => 'patient'])
    </div>
</x-layouts.app>
```

## Best Practices

### Organizzazione
1. Separare logica e presentazione
2. Utilizzare componenti riutilizzabili
3. Mantenere la coerenza
4. Documentare le dipendenze
5. Seguire le convenzioni di naming (`first_name`/`last_name` invece di `name`/`surname`)

### Performance
1. Minimizzare gli stati
2. Utilizzare lazy loading
3. Ottimizzare re-render
4. Caching quando appropriato
5. Utilizzare i widget Filament per form complessi

### Sicurezza
1. Validare input
2. Sanitizzare output
3. Proteggere dati sensibili
4. Gestire errori
5. Utilizzare middleware appropriati

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
