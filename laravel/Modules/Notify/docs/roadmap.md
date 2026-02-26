# Roadmap Modulo Notify

## 🎯 Visione
Diventare un Communication Hub universale che orchestra in modo intelligente le notifiche tra canali diversi (Email, SMS, Push, WhatsApp), ottimizzando i costi e massimizzando il coinvolgimento dell'utente.

## 🏗️ Fasi di Sviluppo

### Fase 1: Stabilità e Standard (In Corso)
- [x] PHPStan Level 10 Compliance.
- [ ] Implementazione del **Cluster Notify** per l'amministrazione in Filament.
- [ ] Rimozione sistematica di file obsoleti e ridondanti.
- [ ] Supporto per il queuing concorrente di Laravel 12 per invii massivi.

### Fase 2: Provider Intelligence (Pianificato)
- [ ] Sistema di "Channel Fallback": retry automatico su canali alternativi in caso di fallimento.
- [ ] Dashboard analitica avanzata dei tassi di consegna e apertura in Filament.
- [ ] Webhook Receiver unificato per conferme di ricezione/lettura cross-provider.

### Fase 3: Ottimizzazione e AI (Futuro)
- [ ] **AI Subject Generator**: Suggerimento dell'oggetto delle notifiche per aumentare l'Open Rate.
- [ ] **Priority Orchestrator**: Scelta automatica del canale migliore basata sulle abitudini dell'utente.
- [ ] Automazione dei template grafici per ricorrenze stagionali tramite AI.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] Assenza di hardcoded strings nei template (integrazione modulo Lang).
- [ ] Smoke tests automatizzati per ogni provider configurato.
- [ ] Documentazione agnostica aggiornata in `docs/`.
