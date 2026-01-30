# Calendario Appuntamenti - Area Odontoiatra

## Introduzione

Il calendario appuntamenti rappresenta lo strumento centrale per la gestione temporale dello studio odontoiatrico, permettendo la visualizzazione, modifica e organizzazione di tutti gli appuntamenti in un'interfaccia intuitiva e funzionale.

## Stato Implementazione

**Completamento**: ✅ 100% (Implementato e Attivo)

### ✅ Funzionalità Implementate
- Visualizzazione calendario multi-view (giorno/settimana/mese)
- Gestione appuntamenti drag & drop
- Slot temporali personalizzabili
- Ricorrenze e serie appuntamenti
- Integrazione con sistema prenotazioni pazienti
- Export calendario (iCal/Google Calendar)

## Viste del Calendario

### Vista Giornaliera
```
┌─────────────────────────────────────────────────────────────┐
│ 📅 Martedì 15 Gennaio 2025                    [<] [OGGI] [>]│
├─────────────────────────────────────────────────────────────┤
│ 08:00 ┌─────────────────────────────────────────────────┐   │
│       │ 🦷 Maria Rossi - Prima Visita                  │   │
│ 08:30 │ 📞 345-1234567 | 📄 Documenti: ✅            │   │
│       └─────────────────────────────────────────────────┘   │
│ 09:00 ┌─────────────────────────────────────────────────┐   │
│       │ 🦷 Giuseppe Bianchi - Controllo                │   │
│ 09:30 │ 📞 335-9876543 | 📄 Documenti: ⚠️            │   │
│       └─────────────────────────────────────────────────┘   │
│ 10:00 ░░░░░░░░░░░░░░░ SLOT LIBERO ░░░░░░░░░░░░░░░         │
│ 10:30 ░░░░░░░░░░░░░░░ SLOT LIBERO ░░░░░░░░░░░░░░░         │
│ 11:00 ┌─────────────────────────────────────────────────┐   │
│       │ 🦷 Anna Verdi - Pulizia                        │   │
│ 11:30 │ 📞 349-1112233 | 📄 Documenti: ✅            │   │
│       └─────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────┘
```

### Vista Settimanale
- **Layout 7 giorni**: Colonne per ogni giorno della settimana
- **Drag & Drop**: Spostamento appuntamenti tra giorni
- **Slot Highlighting**: Evidenziazione fasce orarie libere/occupate
- **Zoom Temporale**: Ingrandimento/riduzione scala oraria

### Vista Mensile
- **Overview Completo**: Tutti gli appuntamenti del mese
- **Density Indicators**: Indicatori carico di lavoro giornaliero
- **Quick Preview**: Anteprima appuntamenti al hover
- **Navigation Shortcuts**: Navigazione rapida tra mesi

## Gestione Appuntamenti

### Creazione Nuovo Appuntamento
```php
// Dati appuntamento
[
    'patient_id' => $patientId,
    'date' => '2025-01-15',
    'start_time' => '09:00',
    'end_time' => '09:30',
    'visit_type' => 'prima_visita',
    'status' => 'confirmed',
    'notes' => 'Paziente gestante - 32 settimane',
    'room' => 'Sala 1',
    'assistant_required' => true,
    'special_equipment' => null
]
```

### Modal Dettagli Appuntamento
```
┌─────────────────────────────────────────────────────────────┐
│ 📋 Dettagli Appuntamento                               [X] │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ 👤 Paziente: Maria Rossi                                   │
│ 📅 Data: Martedì 15 Gennaio 2025                          │
│ ⏰ Orario: 09:00 - 09:30                                   │
│ 🦷 Tipo Visita: Prima Visita                              │
│ 📍 Sala: Studio 1                                          │
│                                                             │
│ 📝 Note:                                                   │
│ ┌─────────────────────────────────────────────────────┐   │
│ │ Paziente gestante - 32 settimane                   │   │
│ │ Allergia: Penicillina                              │   │
│ │ Richiesta anestesia locale                         │   │
│ └─────────────────────────────────────────────────────┘   │
│                                                             │
│ 📄 Documenti: ✅ ISEE ✅ Tessera ⚠️ Gravidanza         │
│                                                             │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐          │
│ │  📝     │ │  📞     │ │  📧     │ │  🗑️     │          │
│ │ Modifica│ │Contatta │ │ Email   │ │Cancella │          │
│ └─────────┘ └─────────┘ └─────────┘ └─────────┘          │
└─────────────────────────────────────────────────────────────┘
```

### Azioni Appuntamento
1. **Modifica**: Cambio orario, sala, note
2. **Conferma**: Conferma appuntamento richiesto
3. **Rinvia**: Spostamento a data futura
4. **Cancella**: Cancellazione con motivo
5. **Duplica**: Creazione appuntamento simile
6. **Check-in**: Segna arrivo paziente

## Configurazione Orari e Slot

### Impostazione Orari Lavoro
```php
// Configurazione settimanale
[
    'monday' => [
        'enabled' => true,
        'morning' => ['start' => '08:00', 'end' => '12:00'],
        'afternoon' => ['start' => '14:00', 'end' => '18:00'],
        'slot_duration' => 30, // minuti
        'break_time' => ['start' => '12:00', 'end' => '14:00']
    ],
    'tuesday' => [
        'enabled' => true,
        'morning' => ['start' => '08:00', 'end' => '12:00'],
        'afternoon' => ['start' => '14:00', 'end' => '18:00'],
        'slot_duration' => 30,
        'break_time' => ['start' => '12:00', 'end' => '14:00']
    ],
    // ... altri giorni
    'saturday' => [
        'enabled' => true,
        'morning' => ['start' => '08:00', 'end' => '12:00'],
        'afternoon' => ['enabled' => false],
        'slot_duration' => 30
    ],
    'sunday' => ['enabled' => false]
]
```

### Slot Speciali
- **Appuntamenti Lunghi**: Slot multipli per interventi complessi
- **Emergency Slots**: Slot riservati per urgenze
- **Preparation Time**: Tempo preparazione tra pazienti
- **Cleanup Time**: Tempo sanificazione post-paziente

## Integrazione Sistema

### Sincronizzazione Real-time
```javascript
// WebSocket updates per calendario
socket.on('appointment_updated', function(data) {
    updateCalendarEvent(data.appointment_id, data.changes);
    showNotification(`Appuntamento ${data.action}: ${data.patient_name}`);
});

socket.on('new_booking_request', function(data) {
    highlightAvailableSlots(data.preferred_dates);
    showBookingRequestModal(data.request);
});
```

### Export e Integrazione Calendari
```php
// iCal export
Route::get('/calendar/export/ical', function(Request $request) {
    $calendar = new \Eluceo\iCal\Domain\Entity\Calendar();
    
    foreach ($appointments as $appointment) {
        $event = new \Eluceo\iCal\Domain\Entity\Event();
        $event->setSummary("Paziente: {$appointment->patient->name}")
              ->setStart(new \DateTime($appointment->start_datetime))
              ->setEnd(new \DateTime($appointment->end_datetime))
              ->setDescription("Tipo: {$appointment->visit_type}");
              
        $calendar->addEvent($event);
    }
    
    return response((string) $calendar)
        ->header('Content-Type', 'text/calendar; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="studio_calendar.ics"');
});
```

## Funzionalità Avanzate

### Template Appuntamenti
```php
// Template per tipologie frequenti
$templates = [
    'prima_visita' => [
        'duration' => 45, // minuti
        'preparation_time' => 5,
        'default_notes' => 'Prima visita - controllo generale',
        'required_documents' => ['ISEE', 'tessera_sanitaria', 'attestazione_gravidanza'],
        'estimated_cost' => 0 // gratuito
    ],
    'pulizia_dentale' => [
        'duration' => 30,
        'preparation_time' => 5,
        'default_notes' => 'Pulizia e controllo',
        'required_documents' => ['tessera_sanitaria'],
        'estimated_cost' => 0
    ],
    'urgenza' => [
        'duration' => 60,
        'preparation_time' => 0,
        'priority' => 'high',
        'default_notes' => 'Appuntamento urgente',
        'required_documents' => ['tessera_sanitaria']
    ]
];
```

### Gestione Conflitti
- **Double Booking Detection**: Rilevamento sovrapposizioni
- **Auto-resolution**: Suggerimenti automatici risoluzione
- **Conflict Alerts**: Notifiche conflitti in tempo reale
- **Buffer Time**: Tempo cuscinetto tra appuntamenti

### Analytics Calendario
```php
// Metriche utilizzo calendario
[
    'slot_utilization' => 85.3, // % slot occupati
    'peak_hours' => ['10:00-11:00', '15:00-16:00'],
    'average_appointment_duration' => 35, // minuti
    'no_show_rate' => 4.8, // %
    'most_requested_slots' => ['martedì 10:00', 'giovedì 15:00'],
    'cancellation_rate' => 2.1, // %
    'recurring_patients' => 68.2 // %
]
```

## Mobile Responsiveness

### Calendario Mobile
- **Touch Navigation**: Swipe tra giorni/settimane
- **Pinch to Zoom**: Zoom su fasce orarie
- **Quick Actions**: Tap per azioni rapide
- **Offline Sync**: Cache appuntamenti per consultazione offline

### Tablet Optimization
- **Split View**: Calendario + dettagli appuntamento
- **Drag & Drop**: Riorganizzazione touch-based
- **Popup Keyboard**: Input ottimizzato per touch

## Collegamenti Bidirezionali

← **Ritorna a**: [Area Odontoiatra](../../stato_avanzamento_lavori_2025_06_05.md#4-area-odontoiatra-55) | [Dashboard Principale](./dashboard_principale.md)

### File Correlati
- [Gestione Orari](./gestione_orari.md)
- [Sistema Notifiche](../notifiche/README.md)
- [Prenotazione Visite](../prenotazione_visite/calendario_disponibilita.md)
- [Conferma Appuntamento](../notifiche/conferma_appuntamento.md)

## Performance e Ottimizzazioni

### Caching Strategy
```php
// Cache calendario per performance
Cache::remember("calendar_data_{$dentistId}_{$date}", 3600, function () {
    return $this->getCalendarData($dentistId, $date);
});

// Preload dati adiacenti
Cache::put("calendar_data_{$dentistId}_{$nextWeek}", $this->getCalendarData($dentistId, $nextWeek), 3600);
```

### Database Optimization
- **Indexing**: Indici ottimizzati per query temporali
- **Partitioning**: Partizionamento tabelle per anno
- **Archiving**: Archiviazione appuntamenti vecchi
- **Query Optimization**: Query ottimizzate per range temporali

## Sicurezza e Compliance

### Access Control
- **Role-based Permissions**: Accesso basato su ruolo utente
- **Time-based Access**: Controllo accesso per orari
- **Audit Trail**: Log completo modifiche calendario
- **Data Encryption**: Cifratura dati sensibili

### GDPR Compliance
- **Data Minimization**: Solo dati necessari per funzionalità
- **Right to Erasure**: Cancellazione completa dati paziente
- **Data Portability**: Export dati in formato standard
- **Consent Management**: Gestione consensi trattamento dati

---
*Ultimo aggiornamento: 2 Gennaio 2025* 
