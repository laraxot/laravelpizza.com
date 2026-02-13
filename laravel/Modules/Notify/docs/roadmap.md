# Notify Module Roadmap

"Informare con precisione: il battito cardiaco dell'applicazione."

## 🎯 Visione
Diventare un Communication Hub universale che orchestra in modo intelligente le notifiche tra canali diversi, ottimizzando i costi (es. SMS vs WhatsApp) e il coinvolgimento dell'utente finale.

## 🏗️ Fasi di Sviluppo

### Fase 1: Stability & Standard (In Progress)
- [x] PHPStan Level 10.
- [ ] Rimozione definitiva dei 500+ file obsoleti.
- [ ] Implementazione del **Notify Cluster** in Filament v5.
- [ ] Supporto per **Laravel 12 concurrent queuing** per le notifiche bulk.

### Fase 2: Provider Intelligence (Planned)
- [ ] Sistema di "Channel Fallback": se l'invio fallisce su WhatsApp, riprova via SMS.
- [ ] Dashboard analitica avanzata dei tassi di apertura direttamente in Filament.
- [ ] Webhook Receiver unificato per conferme di lettura cross-provider.

### Fase 3: AI & Optimization (Future)
- [ ] **AI Subject Generator**: Suggerimento dell'oggetto email in base al contenuto per aumentare l'Open Rate.
- [ ] **Priority Orchestrator**: L'AI decide il canale migliore in base alle abitudini dell'utente.
- [ ] **Seasonal Auto-Theming**: Generazione AI di grafiche per i template festivi (Natale, ecc.).

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] 0 hardcoded strings nei template (usa il modulo Lang).
- [ ] Smoke tests per ogni provider configurato.

---
**Ultimo aggiornamento**: 31 Gennaio 2026
