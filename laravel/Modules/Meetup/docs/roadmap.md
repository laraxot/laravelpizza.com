# Roadmap Modulo Meetup

## 🎯 Visione
Creare una piattaforma d'eccellenza per la gestione di eventi e community, automatizzando i processi di creazione, registrazione e analisi tramite pattern moderni, scalabili e orientati alle performance.

## 🏗️ Fasi di Sviluppo

### Fase 1: Gestione Eventi Core (Completata)
- [x] PHPStan Level 10 Compliance.
- [x] CRUD eventi con integrazione Filament Resource.
- [x] Gestione partecipanti, location e metadati.
- [x] Integrazione widget per statistiche in dashboard.
- [x] Refactoring delle pagine pubbliche con Folio/Volt e SEO slug-based.

### Fase 2: Registrazione e Calendarizzazione (In Corso)
- [ ] Ripristino del calendario eventi compatibile con Filament v4.
- [ ] Implementazione del sistema di registrazione tramite **Actions** (Spatie Queueable).
- [ ] Gestione Waitlist e limiti di partecipazione.
- [ ] Automazione delle email di conferma e promemoria.

### Fase 3: Analytics e Engagement (Pianificato)
- [ ] Dashboard analitica avanzata per le metriche degli eventi.
- [ ] Sistema di feedback post-evento automatizzato.
- [ ] Integrazione di strumenti per analytics in tempo reale.

### Fase 4: Ottimizzazione e AI (Futuro)
- [ ] **AI-Powered Event Suggestions**: Raccomandazioni eventi basate sugli interessi degli utenti.
- [ ] Ottimizzazione dei percorsi di registrazione tramite analisi comportamentale.
- [ ] Generazione automatica di abstract per gli eventi tramite AI.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] Utilizzo rigoroso di Actions per la business logic (NO Services).
- [ ] Copertura Test (Pest) > 90%.
- [ ] Documentazione specifica in `docs/` conforme agli standard Laraxot.
- [x] Migrazioni UUID e schema allineati a XotBaseMigration (vedi [standard migrazioni](../Xot/docs/migrations-consolidated.md)).
