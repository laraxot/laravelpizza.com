# Roadmap Modulo Xot

## 🎯 Visione
Consolidare Xot come il framework core "Zero-Config" dell'ecosistema Laraxot, dove ogni nuovo modulo eredita automaticamente sicurezza, internazionalizzazione, gestione temi e performance di alto livello tramite l'estensione delle classi base.

## 🏗️ Fasi di Sviluppo

### Fase 1: Consolidamento e Qualità (In Corso)
- [x] PHPStan Level 10 Compliance (Standard di Progetto).
- [ ] Rimozione sistematica dei file obsoleti e ridondanti.
- [ ] Refactoring di `XotBaseServiceProvider` per il supporto al boot ottimizzato.
- [ ] Piena compatibilità con le API di Filament v4/v5.

### Fase 2: Developer Experience (Pianificato)
- [ ] **Xot CLI**: Comandi Artisan per la generazione di moduli conformi agli standard Laraxot.
- [ ] **Trait Auditor**: Tooling per il rilevamento di collisioni nei nomi dei Trait a tempo di build.
- [ ] Miglioramento di `XotBasePage` per il supporto nativo a Folio + Volt.

### Fase 3: Ottimizzazione e AI (Futuro)
- [ ] **AI Code Reviewer**: Integrazione di modelli locali per la verifica delle regole architetturali.
- [ ] **Self-Healing Base Classes**: Suggerimenti automatici di correzione tipi basati sull'analisi statica.
- [ ] **Dependency Visualizer**: Rappresentazione grafica delle dipendenze tra i moduli core.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] Assenza di dipendenze esterne non necessarie.
- [ ] 100% test coverage sui dispatcher delle Actions core.
- [ ] Documentazione agnostica e aggiornata in `docs/`.
