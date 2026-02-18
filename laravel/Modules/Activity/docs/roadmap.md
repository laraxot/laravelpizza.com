# Roadmap Modulo Activity - Audit Trail & Intelligence

**Data Creazione**: 2026-01-31
**Status**: 📋 IN LAVORAZIONE
**Versione**: 2.3.0

## 🎯 Obiettivo

Evolvere il sistema di logging verso un'analisi proattiva (AI-driven) e una visualizzazione dei dati sempre più granulare ed efficiente, mantenendo la compliance nativa a PHPStan Level 10.

## 📊 Stato Attuale

### Metriche
- **PHPStan Level 10**: ✅ Compliance Nativa (Modulo di Riferimento)
- **Copertura Test**: ~94% (Eccellente)
- **Documentazione**: ~140 file (Necessaria pulizia file duplicati).

## 🚨 TODO e Miglioramenti Identificati

### 1. Cleanup Documentazione (140+ file)
**Problema**: Presenza di molti file duplicati con suffissi `-duplicate.md` e file di log/coverage test inutili.
**Priorità**: 🔴 Alta
**Link**: [docs/tasks/cleanup-activity-docs.md](./tasks/cleanup-activity-docs.md)

### 2. Allineamento Filament v5 (Clusters)
**Problema**: Organizzare i logs e i widgets in una struttura a Cluster per una navigazione premium.
**Priorità**: 🔴 Alta
**Link**: [docs/tasks/activity-filament-v5.md](./tasks/activity-filament-v5.md)

### 3. AI-Driven Anomaly Detection
**Problema**: I log sono molti, ma l'identificazione di pattern anomali è manuale.
**Priorità**: 🟡 Media
**Link**: [docs/tasks/activity-ai-detection.md](./tasks/tasks/activity-ai-detection.md)

## 📋 Roadmap Dettagliata

### Fase 1: Qualità e Pulizia (Completed/In Progress)
- [x] PHPStan Level 10 Compliance Nativa.
- [x] Rimozione sistematica dei file obsoleti e standardizzazione nomi.
- [x] GitHub Action automation for Quality Check and Releases.
- [ ] Rimozione sistematica dei file `.txt`, `.xml` di coverage e dei duplicati `.md`.
- [ ] Consolidamento della guida agli eventi di dominio.
- [ ] Verifica compatibilità Laravel 12.

### Fase 2: Enterprise UI (In Progress)
- [ ] Implementazione del **Cluster "Observability"**:
    - **Activity logs** Resource.
    - **Performance** Dashboard.
    - **Security Audit** Page.

### Fase 3: Analytics Evolute (Mese 1)
- [ ] Integrazione con strumenti di analisi pattern per identificare accessi sospetti o operazioni non autorizzate.

## 🎯 Priorità immediate
1. **Cleanup**: Eliminare i duplicati per chiarezza.
2. **Clusters**: Migliorare l'organizzazione Filament.

## 📁 Lista task (file .md separati)

Ogni task è documentato in un file nella cartella `docs/tasks/`. Indice: **[tasks-index](./tasks/tasks-index.md)**.

## 🔗 Collegamenti
- [README](./README.md)
- [00-index](./00-index.md)
- [Testing Strategy](./testing-strategy-implementation.md)