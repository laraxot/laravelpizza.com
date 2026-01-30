# Area Personale Paziente - <nome progetto>

## Introduzione

L'Area Personale Paziente rappresenta il cuore dell'esperienza utente per i pazienti registrati, fornendo accesso a tutte le funzionalità principali del portale in modo organizzato e intuitivo.

## Stato Attuale

**Completamento**: 70%

### ✅ Completato
- Dashboard principale
- Gestione profilo
- Storico appuntamenti

### 🚧 In Corso  
- Documenti clinici (60% completato)

### 📋 Pianificato
- Impostazioni notifiche

## Dashboard Principale

### Layout e Struttura
La dashboard è organizzata in sezioni modulari per fornire una visione d'insieme delle informazioni più rilevanti:

1. **Widget di Benvenuto**
   - Nome paziente personalizzato
   - Stato della gravidanza (settimana corrente)
   - Prossimo appuntamento pianificato

2. **Quick Actions**
   - Prenota nuova visita
   - Visualizza documenti
   - Contatta il dottore
   - Richiedi rimborso

3. **Riepilogo Recente**
   - Ultimi appuntamenti
   - Documenti caricati di recente
   - Notifiche non lette

### Implementazione Tecnica
```php
class PatientDashboardWidget extends Widget
{
    protected static string $view = '<nome progetto>::filament.widgets.patient-dashboard';
    
    protected function getViewData(): array
    {
        $patient = auth()->user();
        
        return [
            'next_appointment' => $this->getNextAppointment($patient),
            'recent_documents' => $this->getRecentDocuments($patient),
            'pregnancy_week' => $this->calculatePregnancyWeek($patient),
            'notifications_count' => $this->getUnreadNotifications($patient),
        ];
    }
}
```

## Gestione Profilo

### Informazioni Personali
- **Dati anagrafici**: Nome, cognome, data di nascita, codice fiscale
- **Contatti**: Email, telefono, indirizzo di residenza
- **Dati sanitari**: Medico di base, tessera sanitaria, allergie note
- **Gravidanza**: Data presunta parto, settimana gestazionale, note

### Funzionalità di Modifica
```php
class ProfileManagementWidget extends Widget
{
    public $personalData;
    public $contactData;
    public $medicalData;
    public $pregnancyData;
    
    protected function getFormSchema(): array
    {
        return [
            Tabs::make('Profile')
                ->schema([
                    Tab::make('Dati Personali')
                        ->schema($this->getPersonalDataSchema()),
                    Tab::make('Contatti')
                        ->schema($this->getContactDataSchema()),
                    Tab::make('Dati Sanitari')
                        ->schema($this->getMedicalDataSchema()),
                    Tab::make('Gravidanza')
                        ->schema($this->getPregnancyDataSchema()),
                ]),
        ];
    }
}
```

### Validazione e Sicurezza
- Verifica OTP per modifiche sensibili
- Audit trail per tutte le modifiche
- Backup automatico dei dati precedenti
- Validazione formato documenti

## Storico Appuntamenti

### Visualizzazione Cronologica
Gli appuntamenti sono organizzati in ordine cronologico inverso con filtri avanzati:

1. **Filtri Disponibili**
   - Per data (periodo personalizzabile)
   - Per tipologia di visita
   - Per stato appuntamento
   - Per medico/studio

2. **Informazioni Visualizzate**
   - Data e ora appuntamento
   - Studio e medico
   - Tipologia visita
   - Stato (completato, cancellato, riprogrammato)
   - Referti associati
   - Note e promemoria

### Azioni Disponibili
```php
class AppointmentHistoryWidget extends Widget
{
    protected function getTableActions(): array
    {
        return [
            Action::make('view_details')
                ->label('Dettagli')
                ->icon('heroicon-o-eye')
                ->modalContent(fn ($record) => view('patient.appointment-details', ['appointment' => $record])),
            
            Action::make('download_documents')
                ->label('Scarica Documenti')
                ->icon('heroicon-o-document-download')
                ->action(fn ($record) => $this->downloadAppointmentDocuments($record)),
            
            Action::make('reschedule')
                ->label('Riprogramma')
                ->icon('heroicon-o-calendar')
                ->visible(fn ($record) => $record->canReschedule())
                ->action(fn ($record) => $this->redirectToBooking($record)),
        ];
    }
}
```

## Documenti Clinici (In Sviluppo)

### Tipologie di Documenti
1. **Documenti di Identità**
   - Carta d'identità
   - Codice fiscale
   - Tessera sanitaria

2. **Certificazioni Mediche**
   - Certificato di gravidanza
   - Documentazione ISEE
   - Referti precedenti
   - Prescrizioni mediche

3. **Referti e Esiti**
   - Referti visite odontoiatriche
   - Radiografie e imaging
   - Piani di trattamento
   - Fatture e ricevute

### Gestione Upload e Visualizzazione
```php
class DocumentManagementWidget extends Widget
{
    public function uploadDocument(array $data): void
    {
        $document = Document::create([
            'patient_id' => auth()->id(),
            'type' => $data['type'],
            'title' => $data['title'],
            'filename' => $data['file']->getClientOriginalName(),
            'path' => $data['file']->store('patient-documents'),
            'uploaded_at' => now(),
        ]);
        
        // OCR processing per documenti scansionati
        ProcessDocumentOCR::dispatch($document);
        
        // Notifica upload completato
        auth()->user()->notify(new DocumentUploadedNotification($document));
    }
}
```

### Sicurezza Documenti
- Encryption at-rest per tutti i documenti
- Access control granulare
- Audit trail per accessi e modifiche
- Retention policy automatica
- Backup incrementali

## Impostazioni Notifiche (Pianificato)

### Tipologie di Notifiche
1. **Appuntamenti**
   - Promemoria 24h prima
   - Promemoria 2h prima
   - Conferme e cancellazioni
   - Riprogrammazioni

2. **Documenti**
   - Upload completati
   - Scadenze documenti
   - Richieste integrazione
   - Approvazioni/rifiuti

3. **Sistema**
   - Manutenzione programmata
   - Aggiornamenti policy
   - Novità del servizio
   - Comunicazioni importanti

### Canali di Notifica
```php
class NotificationPreferencesWidget extends Widget
{
    protected function getFormSchema(): array
    {
        return [
            Section::make('Canali di Notifica')
                ->schema([
                    Toggle::make('email_notifications')
                        ->label('Email'),
                    Toggle::make('sms_notifications')
                        ->label('SMS'),
                    Toggle::make('push_notifications')
                        ->label('Notifiche Push'),
                    Toggle::make('in_app_notifications')
                        ->label('Notifiche In-App'),
                ]),
            
            Section::make('Preferenze per Tipologia')
                ->schema([
                    CheckboxList::make('appointment_notifications')
                        ->label('Notifiche Appuntamenti')
                        ->options([
                            'reminder_24h' => 'Promemoria 24h prima',
                            'reminder_2h' => 'Promemoria 2h prima',
                            'confirmations' => 'Conferme e cancellazioni',
                        ]),
                ]),
        ];
    }
}
```

## Mobile Experience

### Responsive Design
L'area personale è ottimizzata per dispositivi mobili considerando che il target principale accede tramite smartphone:

1. **Layout Adattivo**
   - Menu di navigazione collassabile
   - Card layout per sezioni principali
   - Touch-friendly interface
   - Swipe gestures per navigazione

2. **Performance Mobile**
   - Lazy loading per documenti pesanti
   - Compressione immagini dinamica
   - Cache locale per dati frequenti
   - Offline mode per visualizzazione base

### PWA Features
```javascript
// Service Worker per caching
self.addEventListener('fetch', event => {
  if (event.request.url.includes('/patient/dashboard')) {
    event.respondWith(
      caches.match(event.request)
        .then(response => response || fetch(event.request))
    );
  }
});
```

## Sicurezza e Privacy

### Controlli di Accesso
- Autenticazione multi-fattore opzionale
- Session timeout configurabile
- IP whitelisting per accessi sensibili
- Rate limiting per API calls

### Compliance GDPR
- Consent management granulare
- Right to access implementato
- Right to rectification attivo
- Data portability supportata
- Right to erasure conforme

### Audit e Monitoring
```php
class PatientActivityAudit
{
    public static function logAccess(string $section, User $patient): void
    {
        AuditLog::create([
            'user_id' => $patient->id,
            'action' => 'area_access',
            'section' => $section,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now(),
        ]);
    }
}
```

## Timeline Implementazione

### Fase 1: Completamento Documenti Clinici (Gennaio 2025)
- [ ] Sistema upload avanzato
- [ ] OCR integration
- [ ] Validation automatica
- [ ] Preview documenti

### Fase 2: Impostazioni Notifiche (Febbraio 2025)
- [ ] UI preferenze notifiche
- [ ] Backend gestione canali
- [ ] Testing multi-canale
- [ ] Documentazione utente

### Fase 3: Ottimizzazioni e Enhancement (Marzo 2025)
- [ ] Performance tuning
- [ ] Analytics integration
- [ ] A/B testing UX
- [ ] Mobile app preparation

## Testing Strategy

### Test Utente
- User journey testing completo
- Accessibility compliance testing
- Cross-browser compatibility
- Mobile device testing matrix

### Performance Testing
- Load testing per upload documenti
- Stress testing dashboard rendering
- Memory usage optimization
- Database query optimization

## Success Metrics

### KPI Principali
- **User Engagement**: > 80% utenti attivi settimanalmente
- **Document Upload Success**: > 95% upload completati
- **Mobile Usage**: > 70% accessi da mobile
- **User Satisfaction**: > 4.5/5 rating

### Monitoring Dashboard
```php
class PatientAreaMetrics
{
    public function getDashboardMetrics(): array
    {
        return [
            'daily_active_users' => $this->getDailyActiveUsers(),
            'document_upload_rate' => $this->getDocumentUploadRate(),
            'mobile_usage_percentage' => $this->getMobileUsagePercentage(),
            'avg_session_duration' => $this->getAverageSessionDuration(),
        ];
    }
}
```

## Collegamenti e Backlink

### Documentazione Correlata
- [Torna alla Roadmap Frontoffice](../roadmap_frontoffice.md)
- [Stato Dettagliato Lavori](../stato_aggiornamenti_lavori_dettagliato_gennaio_2025.md)
- [Stato Avanzamento 2025](../stato_avanzamento_lavori_2025_06_05.md)
- [Registrazione Paziente](./06-iscrizione-paziente.md)
- [Sistema Prenotazioni](./16-sistema-prenotazioni.md)
- [Sistema Notifiche](./28-sistema-notifiche.md)
- [Gestione Documenti](./20-gestione-documenti.md)

### Risorse Tecniche
- [Mobile Optimization](./31-mobile-optimization.md)
- [Security Audit](./32-security-audit.md)
- [UI/UX Base](./03-ui-ux-base.md)

---

*Documento creato: 2 Gennaio 2025*  
*Responsabile: Frontend Team*  
*Stato: 70% completato*  
*Prossimo aggiornamento: 15 Gennaio 2025* 
