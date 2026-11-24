---
title: "Task: Job Filament v5 Alignment (Clusters)"
type: note
qmd: "job filament v5 task alignment clusters"
---
# Task: Job Filament v5 Alignment (Clusters)

## 📋 Obiettivo
Organizzare le potenti funzionalità di gestione code in un sistema di Clusters coerente in Filament v5.

## 🏗️ Struttura Proposta
- **QueueCluster**: 
    - **JobResource**: Visualizzazione job correnti.
    - **FailedJobResource**: Gestione errori e retry.
    - **JobBatchResource**: Tracciamento batch.
- **ScheduleCluster**:
    - **TaskResource**: Configurazione task.
    - **ScheduleResource**: Pianificazioni.
    - **ScheduleCalendar**: Visualizzazione grafica (FullCalendar).

## ✅ Checklist
- [ ] Creazione dei Cluster `QueueCluster` e `ScheduleCluster`.
- [ ] Migrazione delle pagine di monitoraggio.
- [ ] Implementazione del polling Livewire nativo v5 per le statistiche delle code.
- [ ] Ottimizzazione dei widget dashboard per il caricamento asincrono.

## 🔗 Riferimenti
- [Roadmap Job](../roadmap.md)
