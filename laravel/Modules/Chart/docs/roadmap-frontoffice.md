# 📅 Roadmap Frontoffice <nome progetto>

> **⚠️ AVVISO IMPORTANTE**
>
> Questa è la roadmap di riferimento UNICA per il frontoffice. Tutte le attività, priorità e avanzamenti devono essere tracciati qui e nei file collegati. Aggiorna SEMPRE questa roadmap PRIMA di ogni sviluppo o modifica.

## Introduzione

Questo documento descrive la roadmap di sviluppo dettagliata per il frontoffice di <nome progetto>, il portale dedicato alla promozione della salute orale per le gestanti in condizioni di vulnerabilità socio-economica, basato sulla [Presentazione del portale Salute Orale](./12.10,%20Presentazione%20del%20portale%20Salute%20Orale.md).

La roadmap è organizzata in aree funzionali, ognuna contenente task specifici con relative sotto-attività e percentuali di completamento. Per ogni task complesso sono disponibili documenti dettagliati nella directory `roadmap_frontoffice/` con spiegazioni passo-passo per l'implementazione.

## 📊 Stato Avanzamento Gennaio 2025 (Aggiornato)

**Avanzamento Complessivo: 82%** | **Completamento Previsto: 30 Aprile 2025** | **Budget Utilizzato: 78%**

| Macro-area | Stato (%) | Responsabile | File Dettaglio | Priorità | Timeline |
|------------|-----------|--------------|----------------|----------|----------|
| Homepage e Landing | 95% | Frontend Team | [01-homepage-layout.md](./roadmap_frontoffice/01-homepage-layout.md) | ✅ Completata | 15 Gen 2025 |
| Autenticazione Base | 90% | Backend Team | [04-registrazione-autenticazione.md](./roadmap_frontoffice/04-registrazione-autenticazione.md) | 🟡 Alta | 30 Gen 2025 |
| Registrazione Paziente | 85% | Frontend Team | [06-iscrizione-paziente.md](./roadmap_frontoffice/06-iscrizione-paziente.md) | 🟡 Alta | 15 Feb 2025 |
| Registrazione Dentista | 80% | Fullstack Team | [08-registrazione-odontoiatra.md](./roadmap_frontoffice/08-registrazione-odontoiatra.md) | 🔴 Critica | 28 Feb 2025 |
| Ricerca e Filtri | 75% | Frontend Team | [07-prenotazione-visite.md](./roadmap_frontoffice/07-prenotazione-visite.md) | 🟡 Alta | 15 Mar 2025 |
| Sistema Prenotazioni | 70% | Fullstack Team | [16-sistema-prenotazioni.md](./roadmap_frontoffice/16-sistema-prenotazioni.md) | 🔴 Critica | 31 Mar 2025 |
| Mobile Optimization | 70% | Frontend Team | [03-ui-ux-base.md](./roadmap_frontoffice/03-ui-ux-base.md) | 🟡 Alta | 31 Mar 2025 |
| Sistema Notifiche | 70% | Backend Team | [28-sistema-notifiche.md](./roadmap_frontoffice/28-sistema-notifiche.md) | 🟠 Media | 15 Apr 2025 |
| Sistema Rimborsi | 65% | Backend Team | [26-sistema-rimborsi.md](./roadmap_frontoffice/26-sistema-rimborsi.md) | 🟠 Media | 15 Apr 2025 |
| Back Office | 85% | Backend Team | [09-backoffice.md](./roadmap_frontoffice/09-backoffice.md) | 🟡 Alta | 28 Feb 2025 |
| **Prenotazione Diretta (/patient/book)** | **0%** | **Fullstack Team** | [30-patient-book.md](./roadmap_frontoffice/30-patient-book.md) | 🔴 **Critica** | **15 Mar 2025** |
| **Area Personale Paziente** | **70%** | **Frontend Team** | [33-area-personale-paziente.md](./roadmap_frontoffice/33-area-personale-paziente.md) | 🟡 **Alta** | **15 Feb 2025** |
| **Autenticazione a Due Fattori** | **85%** | **Security Team** | [34-autenticazione-due-fattori.md](./roadmap_frontoffice/34-autenticazione-due-fattori.md) | 🟡 **Alta** | **30 Gen 2025** |
| **Integrazione SPID/CIE** | **0%** | **Security Team** | [35-integrazione-spid-cie.md](./roadmap_frontoffice/35-integrazione-spid-cie.md) | 🟠 **Media** | **15 Apr 2025** |
| **Integrazione Pagamenti** | **70%** | **Backend Team** | [36-integrazione-pagamenti.md](./roadmap_frontoffice/36-integrazione-pagamenti.md) | 🔴 **Critica** | **31 Mar 2025** |

### 📝 **Stato Aggiornamenti**: 
Ogni punto del [stato avanzamento lavori](./stato_avanzamento_lavori_2025_06_05.md) ha il proprio file di approfondimento nella cartella [roadmap_frontoffice](./roadmap_frontoffice/) con collegamenti bidirezionali. Ultimo aggiornamento: 2 Gennaio 2025. 
## 🚀 Features Critiche in Sviluppo

### 1. Prenotazione Diretta (/it/patient/book) - PRIORITÀ MASSIMA

**File di riferimento**: [30-patient-book.md](./roadmap_frontoffice/30-patient-book.md)

- **Stato**: 0% (Analisi completata)
- **Priorità**: 🔴 **Critica**
- **Timeline**: 15 Feb - 15 Mar 2025
- **Complessità**: Alta
- **Team**: Fullstack Team (4 developer)

**Componenti Chiave**:

1. Widget unificato prenotazione
2. Validazione documenti real-time
3. Selezione slot intelligente
4. Notifiche immediate

### 2. Integrazione SPID - IN CORSO

- **Stato**: 60% completato
- **Timeline**: 25 Gen 2025
- **Responsabile**: Backend Team

### 3. Sistema FullCalendar Multi-Tenant

- **Stato**: 60% completato
- Configurazione base: ✅
- Multi-tenancy: 🚧 In corso
- Eventi real-time: ❌ Da iniziare

## 📈 Analisi Performance e Obiettivi

### Metriche Performance Attuali vs Obiettivi

| Metrica | Attuale | Obiettivo | Status |
|---------|---------|-----------|--------|
| Homepage load | 1.8s | < 2s | ✅ |
| Search results | 2.3s | < 2s | ⚠️ |
| Booking flow | 3.1s | < 2s | ❌ |
| Mobile Usability | 85% | 100% | 🚧 |
| Lighthouse Score | 78 | > 90 | 🚧 |

## 🎯 Piano Operativo Gennaio-Aprile 2025

### 📅 Gennaio 2025 (In Corso)

- [x] **Completato**: Homepage ottimizzazioni
- [x] **Completato**: Integrazione SPID base
- [ ] **In Corso**: Inizio sviluppo prenotazione diretta
- [ ] **Pianificato**: Mobile optimization sprint

### 📅 Febbraio 2025

- [ ] Completamento registrazione dentista (workflow approvazione)
- [ ] Mappa interattiva con geolocalizzazione
- [ ] Sistema tracking rimborsi
- [ ] Prenotazione diretta MVP

### 📅 Marzo 2025

- [ ] Sistema prenotazioni avanzato (slot dinamici, overbooking)
- [ ] Prenotazione diretta completamento
- [ ] Performance optimization generale
- [ ] Mobile app PWA setup

### 📅 Aprile 2025

- [ ] Sistema rimborsi completo
- [ ] Analytics avanzate e KPI automatici
- [ ] Testing completo e security audit
- [ ] Go-live preparazione

## 🔍 Rischi Identificati e Mitigazioni

### 🚨 Rischi Critici

1. **Volume Prenotazioni Simultanee**
   - *Probabilità*: Media | *Impatto*: Critico
   - *Mitigazione*: Load balancing, sistema code, Redis caching

2. **Performance Mobile su Dispositivi Datati**
   - *Probabilità*: Alta | *Impatto*: Alto
   - *Mitigazione*: Lazy loading, CDN, compressione asset

3. **Integrazione SPID Complessità**
   - *Probabilità*: Media | *Impatto*: Alto
   - *Mitigazione*: Team dedicato, supporto AgID

### ⚠️ Rischi Operativi

1. **Adozione Lenta Dentisti**
   - *Mitigazione*: Programma incentivi, onboarding semplificato

2. **Supporto Utenti Volume Alto**
   - *Mitigazione*: Documentazione self-service, chatbot

## 💰 Budget e Risorse

### Utilizzo Budget (78% utilizzato)

- **Sviluppo**: 65% utilizzato (€195K/€300K)
- **Infrastruttura**: 45% utilizzato (€45K/€100K)
- **Marketing**: 20% utilizzato (€20K/€100K)

### Team Allocation

- **Backend**: 4 developer (100% allocated)
- **Frontend**: 3 developer (100% allocated)
- **DevOps**: 1 engineer (75% allocated)
- **Testing**: 2 QA (100% allocated)
- **PM**: 1 manager (100% allocated)

## 📋 Checklist Pre-Go-Live (30 Aprile 2025)

### Sicurezza e Compliance

- [ ] Security audit completato
- [ ] GDPR compliance verificata
- [ ] Penetration test superato
- [ ] Backup e disaster recovery testati

### Performance e Stabilità
- [ ] Test di carico superati (1000+ utenti simultanei)
- [ ] Monitoring produzione configurato
- [ ] CDN e caching ottimizzati
- [ ] Mobile performance > 90

### Documentazione e Training
- [ ] Documentazione utente finale
- [ ] Training team supporto completato
- [ ] Runbook operativo
- [ ] Piano rollback definito

## 🔗 Collegamenti Documentazione Dettagliata

### 📁 Documentazione Tecnica Centrale
- **[Stato Dettagliato Lavori](./stato_aggiornamenti_lavori_dettagliato_gennaio_2025.md)** - Analisi completa e tempistiche
- [Architettura Sistema](./architettura_sistema.md)
- [Guida Sviluppatore](./guida_sviluppatore.md)
- [Standards e Best Practice](./standards/)

### 📁 File Implementazione Specifici (roadmap_frontoffice/)
- [Setup Ambiente](./roadmap_frontoffice/01-setup-ambiente.md)
- [Architettura Base](./roadmap_frontoffice/02-architettura-base.md)
- [UI/UX Base](./roadmap_frontoffice/03-ui-ux-base.md)
- [Registrazione Autenticazione](./roadmap_frontoffice/04-registrazione-autenticazione.md)
- [Homepage Landing](./roadmap_frontoffice/05-homepage-landing.md)
- [Iscrizione Paziente](./roadmap_frontoffice/06-iscrizione-paziente.md)
- [Prenotazione Visite](./roadmap_frontoffice/07-prenotazione-visite.md)
- [Registrazione Odontoiatra](./roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Backoffice](./roadmap_frontoffice/09-backoffice.md)
- [Modelli Ereditarietà](./roadmap_frontoffice/10-modelli-ereditarieta.md)
- [Sistema Prenotazioni](./roadmap_frontoffice/16-sistema-prenotazioni.md)
- [Sistema Rimborsi](./roadmap_frontoffice/26-sistema-rimborsi.md)
- [Sistema Notifiche](./roadmap_frontoffice/28-sistema-notifiche.md)
- [Patient Book Diretta](./roadmap_frontoffice/30-patient-book.md)

### 📁 Analisi Immagini e Mockup
- [Analisi Immagini Progetto](./images/) - 31 mockup analizzati
- [Descrizioni UI/UX](./images/2.md) - Homepage e landing
- [Caricamento Documenti](./images/5.md) - Upload workflow
- [Flussi Prenotazione](./images/7.md) - User journey

## Best Practice e Regole (Aggiornate Gennaio 2025)

### Neutralità documentazione
- Tutta la documentazione nelle cartelle docs dei moduli deve essere **neutra** e **riutilizzabile**: mai inserire riferimenti a progetti, brand o contesti specifici.
- Se serve un riferimento specifico, va messo solo nella documentazione root del progetto.

### Ereditarietà dei trait
- **Mai duplicare trait già presenti nei modelli base**. Esempio: se `HasFactory` è già in `BaseUser`, non aggiungerlo in `User` o `Doctor`.
- Motivazione: evitare ridondanza, warning, confusione e problemi di override.

### Gestione ValidationException custom
- Usare sempre `ValidationException::withMessages()` per errori custom.
- Anti-pattern: non usare mai `validator([], [])->errors()->add(...)`.

### Architettura Widget Filament
- Tutte le pagine di form devono includere direttamente solo widget Filament modulari, mai form custom
- Ogni widget incluso DEVE restituire un solo root element HTML
- File legacy come `app/Livewire/Patient/Book.php` NON devono esistere in architettura modulare

### Checklist Sviluppo
- [ ] Aggiornamento documentazione neutra e bidirezionale
- [ ] Nessun riferimento a brand/progetto nei moduli
- [ ] Nessuna duplicazione trait nei modelli
- [ ] Error handling solo con ValidationException::withMessages
- [ ] STI e trait secondo best practice
- [ ] Test e validazione su tutte le nuove feature
- [ ] Collegamenti bidirezionali aggiornati

---

*Ultimo aggiornamento: 2 Gennaio 2025*  
*Prossimo aggiornamento: 16 Gennaio 2025*  
*Responsabile: Project Manager & Tech Lead*

## 🎯 Prossimi Step Operativi Immediati

1. **Priorità Critica**: Iniziare sviluppo prenotazione diretta `/it/patient/book`
2. **Priorità Alta**: Completare integrazione SPID
3. **Priorità Alta**: Ottimizzare performance mobile
4. **Priorità Media**: Implementare mappa interattiva ricerca dentisti

> Questa roadmap e il [documento di stato dettagliato](./stato_aggiornamenti_lavori_dettagliato_gennaio_2025.md) sono la fonte di verità per il frontoffice. Ogni modifica deve essere documentata qui PRIMA di essere implementata.
