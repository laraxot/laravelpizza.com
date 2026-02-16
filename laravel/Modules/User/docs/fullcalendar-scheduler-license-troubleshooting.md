# FullCalendar Scheduler License - Troubleshooting e Configurazione Avanzata

## Panoramica

Questa documentazione fornisce una guida completa per la risoluzione dei problemi relativi alle licenze FullCalendar Scheduler, basata sulla documentazione ufficiale e sui problemi comuni riscontrati nella community.

## Tipi di Licenza FullCalendar

### FullCalendar Standard (MIT License)
- **Gratuito** per uso commerciale e non commerciale
- Include i plugin base (dayGrid, timeGrid, list, interaction)
- **NON** include funzionalità premium come resource views e timeline

### FullCalendar Premium (Scheduler)
- **Richiede licenza commerciale** per uso in produzione
- Include resource views, timeline, e funzionalità avanzate
- Diversi tipi di licenza disponibili

## Tipi di Licenza Premium

### 1. Licenza Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX', // Formato tipico
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- Per aziende e uso commerciale
- Permette modifiche al codice sorgente
- NON permette redistribuzione delle modifiche
- Acquisto necessario da [FullCalendar Pricing](https://fullcalendar.io/pricing/)

### 2. Licenza Non-Commerciale
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per organizzazioni non-profit registrate
- NON copre enti governativi e università
- NON permette modifiche al codice sorgente

### 3. Licenza GPLv3 Open Source
```javascript
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
  plugins: [resourceTimelinePlugin],
  initialView: 'resourceTimelineWeek'
});
```

**Caratteristiche:**
- **Gratuita** per progetti completamente GPLv3-compliant
- Richiede che tutto il progetto sia open source sotto GPLv3

## Problemi Comuni e Soluzioni

### 1. "Unknown option 'schedulerLicenseKey'" Error

**Problema:** L'opzione `schedulerLicenseKey` non viene riconosciuta.

**Cause Possibili:**
- Plugin premium non importato correttamente
- Versione FullCalendar incompatibile
- Bug noto nelle versioni 5.x e 6.x

**Soluzioni:**

#### Soluzione A: Verificare Import Plugin Premium
```javascript
// Assicurarsi di importare almeno un plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
import resourceDayGridPlugin from '@fullcalendar/resource-daygrid';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin, resourceDayGridPlugin], // Plugin premium richiesto
  initialView: 'resourceTimelineWeek'
});
```

#### Soluzione B: Workaround per TypeScript/Angular (v5.x-6.x)
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';

// Workaround per bug noto
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;

// Poi configurare normalmente
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  // altre opzioni...
};
```

#### Soluzione C: Per React/TypeScript (v6.x)
```typescript
// Se BASE_OPTION_DEFAULTS non è disponibile, usare ignore
/* @ts-ignore */
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-LICENSE-KEY',
  plugins: [resourceTimelinePlugin],
  // altre opzioni...
};
```

### 2. "Invalid License String" Error

**Problema:** La chiave di licenza non viene riconosciuta come valida.

**Cause:**
- Chiave copiata incorrettamente
- Caratteri extra o mancanti
- Confusione con altri tipi di chiavi (customer key, support key)

**Soluzioni:**
1. **Verificare formato:** La chiave deve essere nel formato `XXXXXXXXXX-XXX-XXXXXXXXXX`
2. **Copiare esattamente:** Copiare la chiave esattamente come ricevuta via email
3. **Controllare spazi:** Rimuovere spazi iniziali/finali
4. **Verificare source:** Assicurarsi di usare la license key, non il customer number

### 3. "Evaluation Period Has Expired" Error

**Problema:** Il periodo di valutazione è scaduto.

**Soluzioni:**
1. **Acquistare licenza:** Visitare [FullCalendar Pricing](https://fullcalendar.io/pricing/)
2. **Contattare support:** Email a `sales@fullcalendar.io` per rinnovo
3. **Licenza offline:** Richiedere chiave offline se necessario

### 4. "Outdated License Key" Warning

**Problema:** Chiave valida ma obsoleta per la versione corrente.

**Cause:**
- Aggiornamento FullCalendar oltre il periodo di upgrade gratuito (1 anno)
- Licenza acquistata per versione precedente

**Soluzioni:**
1. **Downgrade:** Usare versione FullCalendar compatibile con la licenza
2. **Upgrade licenza:** Acquistare anno aggiuntivo di supporto
3. **Contattare sales:** Email a `sales@fullcalendar.io` per rinnovo

## Configurazione in Laravel/Filament

### 1. Variabili Ambiente (.env)
```env
# Licenza FullCalendar Scheduler
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX

# Configurazioni aggiuntive
FULLCALENDAR_CACHE_TTL=300
FULLCALENDAR_MAX_EVENTS=100
```

### 2. Configurazione (config/fullcalendar.php)
```php
<?php

return [
    // Licenza Scheduler
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    
    // Validazione licenza
    'validate_license' => env('APP_ENV') === 'production',
    
    // Fallback per sviluppo
    'development_mode' => env('APP_ENV') !== 'production',
    
    // Plugin premium abilitati
    'premium_plugins' => [
        'resource-timeline',
        'resource-daygrid',
        'resource-timegrid',
    ],
];
```

### 3. AdminPanelProvider (Filament)
```php
<?php

namespace Modules\SaluteOra\app\Providers\Filament;

use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->plugins([
                $this->getFullCalendarPlugin(),
                // altri plugin...
            ]);
    }

    private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');
        
        // Validazione licenza in produzione
        if (app()->environment('production') && empty($licenseKey)) {
            throw new \Exception('FullCalendar Scheduler license key required in production');
        }

        $plugin = FilamentFullCalendarPlugin::make()
            ->selectable()
            ->editable();

        // Applicare licenza solo se presente
        if (!empty($licenseKey)) {
            $plugin->schedulerLicenseKey($licenseKey);
        }

        return $plugin->config([
            'plugins' => [
                'dayGrid',
                'timeGrid',
                'list',
                'interaction',
                'multiMonth',
                'scrollGrid',
                // Plugin premium (richiedono licenza)
                'resourceTimeline',
                'resourceDayGrid',
                'resourceTimeGrid',
            ],
            
            // Configurazioni specifiche per SaluteOra
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1,
            
            // Business hours sanitarie
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            
            // Validazioni
            'selectConstraint' => 'businessHours',
            'eventConstraint' => 'businessHours',
            
            // Performance
            'lazyFetching' => true,
            'eventLimit' => config('fullcalendar.max_events', 100),
        ]);
    }
}
```

## Testing e Debug

### 1. Verifica Configurazione
```bash
# Verificare variabili ambiente
php artisan config:show fullcalendar

# Test configurazione FullCalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### 2. Debug JavaScript Console
```javascript
// Verificare se plugin premium sono caricati
console.log(FullCalendar.globalPlugins);

// Verificare configurazione calendario
console.log(calendar.getOption('schedulerLicenseKey'));
```

### 3. Comandi Artisan Personalizzati
```php
<?php
// app/Console/Commands/FullCalendarDebug.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FullCalendarDebug extends Command
{
    protected $signature = 'fullcalendar:debug';
    protected $description = 'Debug FullCalendar configuration';

    public function handle()
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');
        
        $this->info('FullCalendar Configuration Debug');
        $this->line('================================');
        
        if (empty($licenseKey)) {
            $this->error('❌ No license key configured');
            $this->warn('Set FULLCALENDAR_SCHEDULER_LICENSE_KEY in .env');
        } else {
            $this->info('✅ License key configured');
            $this->line('Key: ' . substr($licenseKey, 0, 10) . '...');
        }
        
        $this->line('Environment: ' . app()->environment());
        $this->line('Premium plugins: ' . json_encode(config('fullcalendar.premium_plugins', [])));
        
        return 0;
    }
}
```

## Best Practices per SaluteOra

### 1. Sicurezza Licenza
```php
// Non esporre mai la licenza nei log
Log::info('FullCalendar configured', [
    'has_license' => !empty(config('fullcalendar.scheduler_license_key')),
    'environment' => app()->environment(),
    // NON loggare la licenza effettiva
]);
```

### 2. Gestione Ambienti
```php
// Configurazione differenziata per ambiente
if (app()->environment('production')) {
    // Licenza obbligatoria in produzione
    $licenseKey = config('fullcalendar.scheduler_license_key');
    if (empty($licenseKey)) {
        throw new \Exception('Scheduler license required in production');
    }
} else {
    // Sviluppo: mostrare warning ma continuare
    if (empty(config('fullcalendar.scheduler_license_key'))) {
        logger()->warning('FullCalendar Scheduler running without license (development mode)');
    }
}
```

### 3. Monitoring Licenza
```php
// Monitoraggio scadenza licenza
class FullCalendarLicenseCheck
{
    public function checkLicenseValidity(): bool
    {
        $licenseKey = config('fullcalendar.scheduler_license_key');
        
        if (empty($licenseKey)) {
            return false;
        }
        
        // Implementare controllo validità se necessario
        // (FullCalendar non fornisce API per questo)
        
        return true;
    }
}
```

## Troubleshooting Avanzato

### 1. Problemi di Versioning
- **v5.x:** Bug noto con `schedulerLicenseKey`, usare workaround
- **v6.x:** Problemi con TypeScript exports, usare `@ts-ignore`
- **Aggiornamenti:** Verificare sempre compatibilità licenza

### 2. Problemi di Build
```javascript
// Webpack/Vite: assicurarsi che plugin premium siano inclusi
import '@fullcalendar/resource-timeline/index.css';
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
```

### 3. Problemi di Performance
```javascript
// Limitare eventi per evitare problemi di licenza
const calendarOptions = {
  schedulerLicenseKey: 'YOUR-KEY',
  eventSources: [{
    url: '/api/events',
    extraParams: {
      limit: 100 // Limitare numero eventi
    }
  }]
};
```

## Contatti e Supporto

### FullCalendar Support
- **Sales:** sales@fullcalendar.io
- **Support:** [FullCalendar Support](https://fullcalendar.io/support/)
- **Documentation:** [FullCalendar Docs](https://fullcalendar.io/docs/)

### Risorse Utili
- [Pricing](https://fullcalendar.io/pricing/)
- [License FAQ](https://fullcalendar.io/license/faq/)
- [GitHub Issues](https://github.com/fullcalendar/fullcalendar/issues)
- [Changelog](https://fullcalendar.io/changelog/)

## Conclusioni

La gestione delle licenze FullCalendar Scheduler richiede attenzione particolare, specialmente in ambienti di produzione sanitari come SaluteOra. Seguire questa guida garantisce una configurazione corretta e la risoluzione dei problemi più comuni.

**Punti Chiave:**
1. **Licenza obbligatoria** per uso commerciale in produzione
2. **Plugin premium richiesti** per `schedulerLicenseKey`
3. **Workaround disponibili** per bug noti nelle versioni 5.x-6.x
4. **Configurazione ambiente-specifica** per sviluppo vs produzione
5. **Monitoring e logging** per troubleshooting proattivo 
