# 🧠 Comprensione Business Logic dei Moduli TechPlanner

## Panoramica

Questo documento riassume la logica di business, la filosofia, le regole critiche e lo scopo di ogni modulo nel sistema TechPlanner Fila4 Mono.

## 🔧 Modulo Xot - Il Fondamento (Base Framework)

### Scopo
- Fornire il framework base per tutti gli altri moduli
- Implementare i pattern architetturali fondamentali
- Fornire le classi base per modelli, risorse, e componenti

### Logica & Filosofia
- **DRY**: Eliminare duplicazioni con classi base riutilizzabili
- **KISS**: Mantenere le cose semplici e intuitive
- **SOLID**: Seguire principi di progettazione software
- **Trasparenza**: Essere invisibile agli sviluppatori che usano altri moduli

### Business Logic Critica
- Tutte le classi Filament devono estendere XotBase* (mai Filament direttamente)
- Implementazione di base per autenticazione, autorizzazione, e sicurezza
- Gestione delle relazioni polimorfe e delle funzionalità comuni

### Politica
- Centralizzare la logica comune per mantenere coerenza tra moduli
- Fornire astrazioni per semplificare lo sviluppo nei moduli superiori

## 👥 Modulo User - Gestione Utenti Multi-Tipo

### Scopo
- Gestire utenti di diversi tipi (Doctor, Patient, Admin) in un unico sistema
- Fornire sistema di autenticazione e autorizzazione avanzato
- Supportare multi-tenancy per diversi studi/organizzazioni

### Logica & Filosofia
- **Single Table Inheritance (STI)**: Un unico modello per gestire diversi tipi di utenti
- **Sicurezza**: Sicurezza e privacy come priorità principale
- **Flessibilità**: Adattabilità a diversi contesti di utilizzo (sanitario, aziendale, ecc.)

### Business Logic Critica
- Sistema di ruoli e permessi granulari
- Gestione di team e collaborazioni tra utenti
- Supporto per 2FA e altre misure di sicurezza avanzate
- Isolamento dati tra tenant diversi

### Politica
- Nessun accesso non autorizzato ai dati degli altri utenti
- Tracciamento completo delle attività per compliance
- Supporto per diversi contesti di business

## 🌍 Modulo Geo - Geolocalizzazione Avanzata

### Scopo
- Gestire indirizzi e coordinate geografiche in modo flessibile
- Fornire integrazione con Google Maps e altri servizi geografici
- Supportare relazioni polimorfe con qualsiasi entità

### Logica & Filosofia
- **Polymorphic**: Gli indirizzi possono essere collegati a qualsiasi modello
- **Precisione**: Geocoding accurato e validazione degli indirizzi
- **Riutilizzo**: Componenti riutilizzabili per qualsiasi modulo

### Business Logic Critica
- Sistema di geocoding automatico con cache intelligente
- Supporto per diversi provider (Google Maps, OpenStreetMap, ecc.)
- Componenti Filament riutilizzabili per gestione indirizzi

### Politica
- Nessun indirizzo senza validazione geografica
- Cache intelligente per prestazioni ottimali
- Supporto per diversi formati di indirizzi internazionali

## 🔔 Modulo Notify - Sistema di Notifiche Multi-Canale

### Scopo
- Fornire un sistema completo per l'invio di notifiche su diversi canali
- Gestire template email e personalizzazione avanzata
- Supportare analytics e tracciamento delle notifiche

### Logica & Filosofia
- **Multi-Canale**: Supporto per email, SMS, push, Slack, ecc.
- **Template**: Sistema flessibile per personalizzazione notifiche
- **Real-Time**: Notifiche istantanee quando possibile

### Business Logic Critica
- Sistema di coda per gestione efficiente delle notifiche
- Template system con variabili e personalizzazione
- Analytics per monitoraggio tassi di consegna e apertura
- Supporto per notifiche programmate

### Politica
- Nessuna notifica senza consenso dell'utente
- Tracciamento completo per compliance e analytics
- Supporto per opt-out e preferenze utente

## 📊 Modulo Activity - Tracciamento Attività

### Scopo
- Registrare tutte le attività del sistema per audit trail
- Fornire analytics e monitoraggio delle attività
- Supportare sicurezza e compliance

### Logica & Filosofia
- **Audit Trail**: Tracciamento completo di tutte le azioni
- **Event-Driven**: Sistema eventi per registrazione automatica
- **Analisi**: Analytics avanzate per comprensione comportamento

### Business Logic Critica
- Sistema di logging automatico per tutte le azioni significative
- Supporto per diverse categorie di eventi (autenticazione, business, sicurezza)
- Real-time monitoring per rilevamento attività sospette
- Analytics per reporting e analisi tendenze

### Politica
- Nessuna azione significativa senza registrazione
- Sicurezza e privacy come priorità
- Supporto per compliance normativa

## 🌐 Modulo TechPlanner - Pianificazione Tecnica

### Scopo
- Gestire la pianificazione di servizi tecnici e ispezioni
- Fornire sistema completo per gestione clienti e appuntamenti
- Supportare compliance e gestione dispositivi

### Logica & Filosofia
- **Ciclo di Vita Cliente**: Gestione completa dal primo contatto alla conclusione
- **Integrazione**: Connessione con tutti gli altri moduli per esperienza completa
- **Compliance**: Supporto per requisiti normativi e di sicurezza

### Business Logic Critica
- Sistema completo di gestione clienti con contatti multipli
- Pianificazione appuntamenti e gestione dispositivi
- Integrazione con legal representatives e medical directors
- Supporto per documentazione e compliance tracking

### Politica
- Nessun appuntamento senza verifica compliance
- Tracciamento completo per responsabilità e audit
- Integrazione con sistema di notifiche per comunicazioni automatiche

## 🗂️ Modulo Cms - Gestione Contenuti

### Scopo
- Fornire sistema flessibile per gestione contenuti
- Supportare Folio e Volt per sviluppo frontend moderno
- Integrare con sistema multi-tenant

### Logica & Filosofia
- **File-Based**: Routing e strutture basate su file (Laravel Folio)
- **Reattivo**: Componenti reattivi con Laravel Volt
- **Flessibile**: Adattabilità a diversi tipi di contenuti

### Business Logic Critica
- Sistema di pagine e blocchi di contenuto personalizzabili
- Supporto per layout e temi personalizzati
- Integrazione con media management
- Gestione menu e navigazione

### Politica
- Separazione tra contenuto e presentazione
- Supporto per diversi tipi di utenti e permessi
- Integrazione con sistema multi-tenant

## ⚡ Modulo Job - Sistema di Code

### Scopo
- Gestire operazioni asincrone e processi in background
- Fornire monitoraggio e analytics per le code
- Supportare batch processing e scheduling avanzato

### Logica & Filosofia
- **Asincrono**: Elaborazione senza blocco dell'interfaccia utente
- **Scalabile**: Supporto per grandi volumi di operazioni
- **Monitorabile**: Visibilità completa sullo stato dei processi

### Business Logic Critica
- Multi-queue support per diversi tipi di operazioni
- Sistema di retry intelligente per operazioni fallite
- Batch processing per operazioni di massa
- Real-time monitoring e alerting

### Politica
- Nessuna operazione lunga senza sistema di code
- Tracciamento completo per debug e analisi
- Supporto per diversi backend di code (Redis, Database, SQS)

## 🏗️ Regole Critiche di Architettura

### Regola Fondamentale XotBase
- **Mai estendere direttamente classi Filament**
- **Sempre estendere XotBase* o LangBase* classi**
- **Mantenere la gerarchia: Model → Module BaseModel → XotBaseModel → Laravel Model**

### Regola DRY/KISS
- **Non ripetere codice**: Usare trait, base classes, e pattern condivisi
- **Mantenere semplicità**: Evitare complessità non necessaria
- **Riutilizzo**: Massimizzare le componenti riutilizzabili

### Regola Type Safety
- **PHPStan Level 10**: Compliance in tutti i moduli
- **No property_exists() su modelli Eloquent**: Usare hasAttribute() o isFillable()
- **Validazione input/output**: Usare Webmozart Assert per validazione

## 🧘 Zen del Progetto

Il "zen" del progetto TechPlanner risiede nell'equilibrio tra:

- **Funzionalità avanzate** e **semplicità di sviluppo**
- **Flessibilità** e **coerenza architetturale**
- **Sicurezza** e **usabilità**
- **Estensibilità** e **manutenibilità**
- **Performance** e **leggibilità del codice**

Ogni modulo deve contribuire a questo equilibrio, rispettando i principi fondamentali mentre fornisce funzionalità specifiche al sistema complessivo.
