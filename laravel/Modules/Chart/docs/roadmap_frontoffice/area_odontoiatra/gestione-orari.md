# Gestione Orari - Area Odontoiatra

## Introduzione

Il sistema di gestione orari permette agli odontoiatri di configurare la propria disponibilità settimanale, gestire eccezioni, ferie e pause, garantendo una sincronizzazione perfetta con il sistema di prenotazioni pazienti.

## Stato Implementazione

**Completamento**: ✅ 100% (Implementato e Attivo)

### ✅ Funzionalità Implementate
- Configurazione orari settimanali standard
- Gestione eccezioni giornaliere
- Pianificazione ferie e chiusure
- Pausa pranzo e break configurabili
- Sincronizzazione automatica con calendario prenotazioni
- Notifiche automatiche modifiche orari

## Configurazione Orari Standard

### Schema Settimanale
```
┌─────────────────────────────────────────────────────────────┐
│ ⚙️ Configurazione Orari Studio                            │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ 📅 Lunedì     🟢 Attivo                                   │
│     Mattina:  08:00 - 12:00  [Modifica]                   │
│     Pausa:    12:00 - 14:00                               │
│     Pomeriggio: 14:00 - 18:00  [Modifica]                 │
│                                                             │
│ 📅 Martedì    🟢 Attivo                                   │
│     Mattina:  08:00 - 12:00  [Modifica]                   │
│     Pausa:    12:00 - 14:00                               │
│     Pomeriggio: 14:00 - 18:00  [Modifica]                 │
│                                                             │
│ 📅 Mercoledì  🟢 Attivo                                   │
│     Mattina:  08:00 - 12:00  [Modifica]                   │
│     Pausa:    12:00 - 14:00                               │
│     Pomeriggio: 14:00 - 18:00  [Modifica]                 │
│                                                             │
│ 📅 Giovedì    🟢 Attivo                                   │
│     Mattina:  08:00 - 12:00  [Modifica]                   │
│     Pausa:    12:00 - 14:00                               │
│     Pomeriggio: 14:00 - 18:00  [Modifica]                 │
│                                                             │
│ 📅 Venerdì    🟢 Attivo                                   │
│     Mattina:  08:00 - 12:00  [Modifica]                   │
│     Pausa:    12:00 - 14:00                               │
│     Pomeriggio: 14:00 - 18:00  [Modifica]                 │
│                                                             │
│ 📅 Sabato     🟡 Solo Mattina                             │
│     Mattina:  09:00 - 13:00  [Modifica]                   │
│     Pomeriggio: ❌ Chiuso                                  │
│                                                             │
│ 📅 Domenica   ❌ Chiuso                                   │
│                                                             │
│ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐           │
│ │ 💾 Salva    │ │ 🔄 Reset    │ │ 📋 Template │           │
│ │ Modifiche   │ │ Default     │ │ Predefiniti │           │
│ └─────────────┘ └─────────────┘ └─────────────┘           │
└─────────────────────────────────────────────────────────────┘
```

### Struttura Dati
```php
// Configurazione orari settimanale
[
    'studio_id' => $studioId,
    'dentist_id' => $dentistId,
    'weekly_schedule' => [
        'monday' => [
            'enabled' => true,
            'morning' => [
                'start' => '08:00',
                'end' => '12:00',
                'slot_duration' => 30 // minuti
            ],
            'afternoon' => [
                'start' => '14:00',
                'end' => '18:00',
                'slot_duration' => 30
            ],
            'break_time' => [
                'start' => '12:00',
                'end' => '14:00'
            ]
        ],
        // ... altri giorni
        'sunday' => [
            'enabled' => false
        ]
    ],
    'timezone' => 'Europe/Rome',
    'advance_booking_days' => 60, // giorni in anticipo per prenotazioni
    'last_minute_hours' => 2 // ore minime anticipo
]
```

## Gestione Eccezioni e Chiusure

### Eccezioni Giornaliere
```
┌─────────────────────────────────────────────────────────────┐
│ 📅 Eccezioni Orari                                         │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ ➕ Aggiungi Eccezione                                      │
│                                                             │
│ 📆 15 Gennaio 2025 (Martedì)                              │
│     Tipo: 🩺 Visita Specialistica Esterna                 │
│     Orario: 15:00 - 17:00 NON DISPONIBILE                 │
│     Motivo: Visita presso Ospedale San Giovanni            │
│     [Modifica] [Elimina]                                   │
│                                                             │
│ 📆 22 Gennaio 2025 (Martedì)                              │
│     Tipo: 🎯 Orario Prolungato                            │
│     Orario: 08:00 - 20:00 (esteso fino alle 20:00)       │
│     Motivo: Recupero appuntamenti                          │
│     [Modifica] [Elimina]                                   │
│                                                             │
│ 📆 28 Gennaio 2025 (Lunedì)                               │
│     Tipo: ❌ Chiusura Giornata                            │
│     Orario: TUTTO IL GIORNO                               │
│     Motivo: Corso di formazione                           │
│     [Modifica] [Elimina]                                   │
└─────────────────────────────────────────────────────────────┘
```

### Pianificazione Ferie
```php
// Gestione periodi ferie
[
    'vacation_periods' => [
        [
            'start_date' => '2025-08-10',
            'end_date' => '2025-08-25',
            'type' => 'vacation',
            'status' => 'approved',
            'notes' => 'Ferie estive',
            'auto_reschedule' => false, // non riprogrammare automaticamente
            'notification_sent' => true
        ],
        [
            'start_date' => '2025-12-24',
            'end_date' => '2025-01-06',
            'type' => 'holiday',
            'status' => 'planned',
            'notes' => 'Chiusura natalizia',
            'auto_reschedule' => true,
            'advance_notice_days' => 30
        ]
    ]
]
```

## Slot e Configurazioni Avanzate

### Durata Slot Personalizzata
```php
// Configurazione slot per tipo visita
[
    'slot_configurations' => [
        'prima_visita' => [
            'duration' => 45, // minuti
            'buffer_before' => 5, // minuti preparazione
            'buffer_after' => 10, // minuti pulizia/disinfettamento
            'max_per_day' => 6
        ],
        'controllo_periodico' => [
            'duration' => 30,
            'buffer_before' => 5,
            'buffer_after' => 5,
            'max_per_day' => 8
        ],
        'pulizia_dentale' => [
            'duration' => 30,
            'buffer_before' => 5,
            'buffer_after' => 5,
            'max_per_day' => 10
        ],
        'urgenza' => [
            'duration' => 60,
            'buffer_before' => 0,
            'buffer_after' => 15,
            'max_per_day' => 2, // slot riservati
            'priority' => 'high'
        ]
    ]
]
```

### Template Orari Predefiniti
```php
// Template comuni per setup rapido
$templates = [
    'standard_full_time' => [
        'description' => 'Orario completo Lun-Ven + Sab mattina',
        'weekly_hours' => 42,
        'schedule' => [
            'monday_friday' => ['08:00-12:00', '14:00-18:00'],
            'saturday' => ['09:00-13:00'],
            'sunday' => 'closed'
        ]
    ],
    'part_time_morning' => [
        'description' => 'Solo mattina Lun-Sab',
        'weekly_hours' => 30,
        'schedule' => [
            'monday_saturday' => ['08:00-13:00'],
            'sunday' => 'closed'
        ]
    ],
    'evening_clinic' => [
        'description' => 'Studio serale Lun-Ven',
        'weekly_hours' => 25,
        'schedule' => [
            'monday_friday' => ['15:00-20:00'],
            'weekend' => 'closed'
        ]
    ]
];
```

## Integrazione Sistema

### Sincronizzazione Automatica
```php
// Event listeners per sincronizzazione
Event::listen('schedule.updated', function ($schedule) {
    // Aggiorna disponibilità calendario
    CalendarAvailability::sync($schedule);
    
    // Notifica pazienti con appuntamenti impattati
    if ($schedule->hasConflicts()) {
        NotifyPatientsOfScheduleChange::dispatch($schedule);
    }
    
    // Cache refresh
    Cache::forget("availability_{$schedule->dentist_id}");
});
```

### API Disponibilità
```php
// Endpoint per controllo disponibilità real-time
Route::get('/api/availability/{dentistId}', function($dentistId, Request $request) {
    $date = $request->input('date', today());
    
    $availability = Cache::remember(
        "availability_{$dentistId}_{$date}",
        300, // 5 minuti cache
        function () use ($dentistId, $date) {
            return AvailabilityService::getAvailableSlots($dentistId, $date);
        }
    );
    
    return response()->json([
        'date' => $date,
        'available_slots' => $availability['slots'],
        'working_hours' => $availability['hours'],
        'exceptions' => $availability['exceptions']
    ]);
});
```

## Notifiche e Comunicazioni

### Notifiche Automatiche
1. **Modifica Orari**: Notifica pazienti con appuntamenti impattati
2. **Chiusura Imprevista**: Alert immediato a pazienti interessati
3. **Riapertura**: Notifica disponibilità slot liberati
4. **Promemoria Configurazione**: Alert per aggiornare orari stagionali

### Template Notifiche
```php
// Template email modifica orari
$emailTemplate = [
    'subject' => 'Modifica Orari Studio - Dr. {{dentist_name}}',
    'body' => '
        Gentile {{patient_name}},
        
        La informiamo che gli orari dello studio del Dr. {{dentist_name}} 
        sono stati modificati per il giorno {{date}}.
        
        Il suo appuntamento del {{appointment_date}} alle {{appointment_time}}
        {{#if_rescheduled}}
        è stato riprogrammato per {{new_appointment_date}} alle {{new_appointment_time}}.
        {{else}}
        rimane confermato e non subisce modifiche.
        {{/if_rescheduled}}
        
        Per eventuali chiarimenti può contattare lo studio al {{studio_phone}}.
        
        Cordiali saluti,
        Staff <nome progetto>
    '
];
```

## Analisi e Reportistica

### Metriche Utilizzo
```php
// Analytics orari studio
[
    'schedule_metrics' => [
        'weekly_working_hours' => 40,
        'average_daily_patients' => 12,
        'peak_hours' => ['10:00-11:00', '15:00-16:00'],
        'least_busy_hours' => ['08:00-09:00', '17:00-18:00'],
        'slot_utilization' => 87.3, // %
        'no_show_rate_by_hour' => [
            '08:00' => 8.2,
            '10:00' => 3.1,
            '15:00' => 2.8,
            '17:00' => 6.5
        ]
    ],
    'efficiency_indicators' => [
        'average_time_between_appointments' => 5, // minuti
        'overtime_frequency' => 12, // % giorni con ritardi
        'break_time_adherence' => 94, // % rispetto orari programmati
        'schedule_change_frequency' => 2.3 // modifiche/mese
    ]
]
```

### Report Personalizzati
- **Report Settimanale**: Utilizzo slot e performance
- **Analisi Mensile**: Trend produttività e ottimizzazioni
- **Benchmark Comparativo**: Confronto con altri studi simili
- **Forecast Planning**: Previsioni carico lavoro futuro

## Mobile e Accessibility

### App Mobile per Gestione
- **Quick Schedule Edit**: Modifica rapida orari da mobile
- **Emergency Closure**: Chiusura imprevista con un tap
- **Push Notifications**: Alert per conflitti o richieste urgenti
- **Voice Commands**: Comandi vocali per aggiornamenti rapidi

### Accessibility Features
- **High Contrast Mode**: Modalità alto contrasto
- **Font Size Scaling**: Ridimensionamento testo
- **Keyboard Navigation**: Navigazione completa da tastiera
- **Screen Reader Support**: Compatibilità lettori schermo

## Collegamenti Bidirezionali

← **Ritorna a**: [Area Odontoiatra](../../stato_avanzamento_lavori_2025_06_05.md#4-area-odontoiatra-55) | [Dashboard Principale](./dashboard_principale.md)

### File Correlati
- [Calendario Appuntamenti](./calendario_appuntamenti.md)
- [Sistema Notifiche](../notifiche/README.md)
- [Prenotazione Visite](../prenotazione_visite/disponibilita_orari.md)
- [Dashboard Odontoiatra](./dashboard_principale.md)

## Sicurezza e Compliance

### Controllo Accessi
- **Role-based Configuration**: Solo odontoiatra può modificare propri orari
- **Admin Override**: Amministratori possono gestire in emergenza
- **Audit Trail**: Log completo modifiche orari
- **Change Approval**: Workflow approvazione per modifiche significative

### Business Continuity
- **Backup Scheduling**: Copia di sicurezza configurazioni
- **Disaster Recovery**: Procedure ripristino configurazioni
- **Sync Verification**: Controllo sincronizzazione tra sistemi
- **Rollback Capability**: Possibilità annullare modifiche

---
*Ultimo aggiornamento: 2 Gennaio 2025* 
