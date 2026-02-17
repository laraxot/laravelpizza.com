# FullCalendar Scheduler - Riferimento Rapido

## 🚨 Problemi Comuni e Soluzioni Immediate
### ❌ "Unknown option 'schedulerLicenseKey'"
**Causa:** Plugin premium non importato
```javascript
// ✅ SOLUZIONE: Importare plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';
var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-KEY',
  plugins: [resourceTimelinePlugin], // ← NECESSARIO
  initialView: 'resourceTimelineWeek'
});
```
**Workaround TypeScript/Angular:**
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;
### ❌ "Invalid License String"
**Causa:** Formato chiave errato
// ❌ SBAGLIATO
schedulerLicenseKey: 'customer-12345'
// ✅ CORRETTO
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX'
### ❌ "Evaluation Period Has Expired"
**Soluzioni:**
1. Acquistare licenza: https://fullcalendar.io/pricing/
2. Email support: sales@fullcalendar.io
3. Downgrade versione FullCalendar
### ❌ Banner Rosso "LICENSE NEEDED"
**Causa:** Nessuna licenza configurata
```php
// ✅ SOLUZIONE Laravel
// .env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=YOUR-KEY-HERE
// AdminPanelProvider.php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
## 🔑 Tipi di Licenza
### Commerciale
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX' // Acquistata
### Non-Profit (Gratuita)
schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
### Open Source GPLv3 (Gratuita)
schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source'
## ⚙️ Configurazione Laravel/Filament
### .env
```env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX
### config/fullcalendar.php
return [
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    'validate_license' => env('APP_ENV') === 'production',
];
### AdminPanelProvider.php
private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
{
    $licenseKey = config('fullcalendar.scheduler_license_key');

    $plugin = FilamentFullCalendarPlugin::make()
        ->selectable()
        ->editable();
    if (!empty($licenseKey)) {
        $plugin->schedulerLicenseKey($licenseKey);
    }
    return $plugin->config([
        'plugins' => [
            'dayGrid', 'timeGrid', 'list', 'interaction',
            'resourceTimeline', 'resourceDayGrid', // Premium
        ],
    ]);
}
## 🧪 Testing e Debug
### Verifica Configurazione
```bash
php artisan config:show fullcalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
### Debug JavaScript
console.log(FullCalendar.globalPlugins);
console.log(calendar.getOption('schedulerLicenseKey'));
### Comando Debug Personalizzato
// app/Console/Commands/FullCalendarDebug.php
php artisan make:command FullCalendarDebug
php artisan fullcalendar:debug
## 🔒 Sicurezza
### ❌ NON FARE
// Non loggare mai la licenza
Log::info('License: ' . $licenseKey); // ❌ PERICOLOSO
### ✅ FARE
// Loggare solo presenza licenza
Log::info('FullCalendar configured', [
    'has_license' => !empty($licenseKey),
    'environment' => app()->environment(),
]);
## 🌍 Gestione Ambienti
### Produzione (Licenza Obbligatoria)
if (app()->environment('production') && empty($licenseKey)) {
    throw new \Exception('Scheduler license required in production');
### Sviluppo (Warning)
if (app()->environment('local') && empty($licenseKey)) {
    logger()->warning('FullCalendar running without license (dev mode)');
## 📞 Supporto
- **Sales:** sales@fullcalendar.io
- **Pricing:** https://fullcalendar.io/pricing/
- **Docs:** https://fullcalendar.io/project_docs/schedulerLicenseKey
- **Docs:** https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub:** https://github.com/fullcalendar/fullcalendar/issues
## 🎯 Checklist Rapida
- [ ] Plugin premium importato (`@fullcalendar/resource-timeline`)
- [ ] Licenza configurata in `.env`
- [ ] Formato licenza corretto (`XXXXXXXXXX-XXX-XXXXXXXXXX`)
- [ ] Plugin applicato in AdminPanelProvider
- [ ] Test in console JavaScript
- [ ] Verifica ambiente produzione vs sviluppo
- [ ] Banner rosso rimosso
- [ ] Funzionalità premium attive
## 🚀  Specifico
## 🚀 <nome progetto> Specifico
### Business Hours Sanitarie
businessHours: {
  daysOfWeek: [1, 2, 3, 4, 5, 6], // Lun-Sab
  startTime: '08:00',
  endTime: '19:00',
### Configurazione Multi-Tenant
// Isolamento per studio
$plugin->config([
    'eventSources' => [{
        'url' => '/api/appointments',
        'extraParams' => [
            'studio_id' => Filament::getTenant()->id,
        ]
    }]
### Validazioni Sanitarie
selectConstraint: 'businessHours',
eventConstraint: 'businessHours',
slotDuration: '00:30:00', // 30 min slots
```
# FullCalendar Scheduler - Riferimento Rapido

## 🚨 Problemi Comuni e Soluzioni Immediate

### ❌ "Unknown option 'schedulerLicenseKey'"

**Causa:** Plugin premium non importato
```javascript
// ✅ SOLUZIONE: Importare plugin premium
import resourceTimelinePlugin from '@fullcalendar/resource-timeline';

var calendar = new Calendar(calendarEl, {
  schedulerLicenseKey: 'YOUR-KEY',
  plugins: [resourceTimelinePlugin], // ← NECESSARIO
  initialView: 'resourceTimelineWeek'
});
```

**Workaround TypeScript/Angular:**
```typescript
import { BASE_OPTION_REFINERS } from '@fullcalendar/core';
(BASE_OPTION_REFINERS as any).schedulerLicenseKey = String;
```

### ❌ "Invalid License String"

**Causa:** Formato chiave errato
```javascript
// ❌ SBAGLIATO
schedulerLicenseKey: 'customer-12345'

// ✅ CORRETTO
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX'
```

### ❌ "Evaluation Period Has Expired"

**Soluzioni:**
1. Acquistare licenza: https://fullcalendar.io/pricing/
2. Email support: sales@fullcalendar.io
3. Downgrade versione FullCalendar

### ❌ Banner Rosso "LICENSE NEEDED"

**Causa:** Nessuna licenza configurata
```php
// ✅ SOLUZIONE Laravel
// .env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=YOUR-KEY-HERE

// AdminPanelProvider.php
FilamentFullCalendarPlugin::make()
    ->schedulerLicenseKey(config('fullcalendar.scheduler_license_key'))
```

## 🔑 Tipi di Licenza

### Commerciale
```javascript
schedulerLicenseKey: 'XXXXXXXXXX-XXX-XXXXXXXXXX' // Acquistata
```

### Non-Profit (Gratuita)
```javascript
schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives'
```

### Open Source GPLv3 (Gratuita)
```javascript
schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source'
```

## ⚙️ Configurazione Laravel/Filament

### .env
```env
FULLCALENDAR_SCHEDULER_LICENSE_KEY=XXXXXXXXXX-XXX-XXXXXXXXXX
```

### config/fullcalendar.php
```php
return [
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),
    'validate_license' => env('APP_ENV') === 'production',
];
```

### AdminPanelProvider.php
```php
private function getFullCalendarPlugin(): FilamentFullCalendarPlugin
{
    $licenseKey = config('fullcalendar.scheduler_license_key');

    $plugin = FilamentFullCalendarPlugin::make()
        ->selectable()
        ->editable();

    if (!empty($licenseKey)) {
        $plugin->schedulerLicenseKey($licenseKey);
    }

    return $plugin->config([
        'plugins' => [
            'dayGrid', 'timeGrid', 'list', 'interaction',
            'resourceTimeline', 'resourceDayGrid', // Premium
        ],
    ]);
}
```

## 🧪 Testing e Debug

### Verifica Configurazione
```bash
php artisan config:show fullcalendar
php artisan tinker
>>> config('fullcalendar.scheduler_license_key')
```

### Debug JavaScript
```javascript
console.log(FullCalendar.globalPlugins);
console.log(calendar.getOption('schedulerLicenseKey'));
```

### Comando Debug Personalizzato
```php
// app/Console/Commands/FullCalendarDebug.php
php artisan make:command FullCalendarDebug
php artisan fullcalendar:debug
```

## 🔒 Sicurezza

### ❌ NON FARE
```php
// Non loggare mai la licenza
Log::info('License: ' . $licenseKey); // ❌ PERICOLOSO
```

### ✅ FARE
```php
// Loggare solo presenza licenza
Log::info('FullCalendar configured', [
    'has_license' => !empty($licenseKey),
    'environment' => app()->environment(),
]);
```

## 🌍 Gestione Ambienti

### Produzione (Licenza Obbligatoria)
```php
if (app()->environment('production') && empty($licenseKey)) {
    throw new \Exception('Scheduler license required in production');
}
```

### Sviluppo (Warning)
```php
if (app()->environment('local') && empty($licenseKey)) {
    logger()->warning('FullCalendar running without license (dev mode)');
}
```

## 📞 Supporto

- **Sales:** sales@fullcalendar.io
- **Pricing:** https://fullcalendar.io/pricing/
- **Docs:** https://fullcalendar.io/docs/schedulerLicenseKey
- **GitHub:** https://github.com/fullcalendar/fullcalendar/issues

## 🎯 Checklist Rapida

- [ ] Plugin premium importato (`@fullcalendar/resource-timeline`)
- [ ] Licenza configurata in `.env`
- [ ] Formato licenza corretto (`XXXXXXXXXX-XXX-XXXXXXXXXX`)
- [ ] Plugin applicato in AdminPanelProvider
- [ ] Test in console JavaScript
- [ ] Verifica ambiente produzione vs sviluppo
- [ ] Banner rosso rimosso
- [ ] Funzionalità premium attive

## 🚀 <nome progetto> Specifico

### Business Hours Sanitarie
```javascript
businessHours: {
  daysOfWeek: [1, 2, 3, 4, 5, 6], // Lun-Sab
  startTime: '08:00',
  endTime: '19:00',
}
```

### Configurazione Multi-Tenant
```php
// Isolamento per studio
$plugin->config([
    'eventSources' => [{
        'url' => '/api/appointments',
        'extraParams' => [
            'studio_id' => Filament::getTenant()->id,
        ]
    }]
]);
```

### Validazioni Sanitarie
```javascript
selectConstraint: 'businessHours',
eventConstraint: 'businessHours',
slotDuration: '00:30:00', // 30 min slots
```
