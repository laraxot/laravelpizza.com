# Architettura Tecnologica il progetto

## Stack Tecnologico

il progetto è sviluppato seguendo un'architettura moderna e modulare, con una netta separazione tra backend e frontend, ciascuno con il proprio specifico stack tecnologico.

### Backend/Backoffice

Per il backend e l'area di amministrazione (backoffice) utilizziamo **ESCLUSIVAMENTE**:

- **Filament**: Framework completo per la creazione di pannelli amministrativi
- **Spatie Laravel-Queueable-Action**: Per gestire la logica di business secondo il pattern Action
- **Laravel Modules**: Per organizzare il codice in moduli indipendenti

#### Regole Fondamentali per il Backend

1. **MAI utilizzare Blade nel backend** se non come ultima risorsa e solo in casi eccezionali
2. Implementare tutte le interfacce amministrative tramite Filament
3. Utilizzare esclusivamente il pattern Action con Spatie Laravel-Queueable-Action
4. Organizzare il codice in moduli funzionali e indipendenti

### Frontend/Frontoffice

Per l'interfaccia utente lato cliente (frontoffice) utilizziamo:

- **Laravel Folio**: Per la gestione delle pagine e del routing
- **Laravel Volt**: Per la creazione di componenti dinamici e reattivi
- **Blade**: Come motore di template per il frontend
- **Alpine.js**: Per interazioni JavaScript leggere
- **Tailwind CSS**: Per lo styling

#### Regole Fondamentali per il Frontend

1. Utilizzare Folio per la struttura delle pagine e il routing
2. Implementare componenti dinamici con Volt
3. Seguire una struttura componibile per favorire il riutilizzo
4. Mantenere una chiara separazione tra logica di business e presentazione

## Principi Architetturali

1. **Separazione delle Responsabilità**:
   - Backend (Filament): gestione dati, logica di business, amministrazione
   - Frontend (Folio+Volt): presentazione, interazione utente, esperienza utente

2. **Modularità**:
   - Ogni funzionalità principale è isolata in un modulo dedicato
   - I moduli comunicano tramite interfacce ben definite
   - Possibilità di abilitare/disabilitare moduli secondo necessità

3. **Coerenza**:
   - Backend: esclusivamente Filament per tutte le interfacce amministrative
   - Frontend: Folio+Volt per tutte le interfacce cliente
   - Pattern Action coerente in tutta l'applicazione

## Schema delle Dipendenze

```
il progetto
│
├── Backend/Backoffice
│   ├── Filament (ESCLUSIVO)
│   ├── Spatie Laravel-Queueable-Action
│   └── Laravel Modules
│
└── Frontend/Frontoffice
    ├── Laravel Folio
    ├── Laravel Volt
    ├── Blade (solo frontend)
    ├── Alpine.js
    └── Tailwind CSS
```

## Linee Guida per lo Sviluppo

1. **Sviluppo Backend**:
   - Iniziare sempre creando Resources Filament per nuove entità
   - Implementare la logica di business attraverso Actions
   - Utilizzare i widget Filament per dashboard e visualizzazioni personalizzate
   - EVITARE qualsiasi utilizzo di Blade nel backend

2. **Sviluppo Frontend**:
   - Utilizzare Folio per definire nuove pagine e route
   - Creare componenti Volt per funzionalità dinamiche e reattive
   - Organizzare i componenti in modo modulare e riutilizzabile
   - Utilizzare Blade per il templating frontend

Questa architettura garantisce un'applicazione modulare, scalabile e manutenibile, con una chiara separazione delle responsabilità e l'utilizzo delle migliori tecnologie per ciascun contesto.
