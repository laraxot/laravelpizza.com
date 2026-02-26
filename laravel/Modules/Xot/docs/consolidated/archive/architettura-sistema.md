# Architettura del Sistema il progetto

## Panoramica dell'Architettura

il progetto è basato su un'architettura modulare che utilizza Laravel come framework principale e Laraxot come sistema di moduli. L'architettura è progettata per garantire:

- **Modularità**: Ogni funzionalità è incapsulata in moduli indipendenti
- **Estensibilità**: Facile aggiunta di nuove funzionalità
- **Manutenibilità**: Separazione chiara delle responsabilità
- **Sicurezza**: Protezione dei dati sensibili delle pazienti

## Componenti Principali

### 1. Core Framework
- **Laravel 12**: Framework PHP per lo sviluppo web
- **Filament 3**: Framework di amministrazione per il backend

### 2. Sistema Modulare
- **Laraxot**: Sistema di moduli personalizzato
- **Module Manager**: Gestione delle dipendenze tra moduli

### 3. Livelli Applicativi
- **Presentation Layer**: Interfacce utente e API
- **Business Logic Layer**: Logica di business e regole di dominio
- **Data Access Layer**: Accesso e persistenza dei dati

### 4. Infrastruttura
- **Database**: MySQL per la persistenza dei dati
- **Cache**: Redis per caching e sessioni
- **Storage**: Sistema di file per documenti e media

## Flusso dei Dati

1. **Input**: Raccolta dati dalle gestanti e dagli operatori sanitari
2. **Elaborazione**: Validazione, trasformazione e archiviazione dei dati
3. **Output**: Generazione di report, notifiche e interfacce utente

## Sicurezza e Privacy

- **Autenticazione**: Sistema multi-livello con ruoli e permessi
- **Autorizzazione**: Controllo granulare degli accessi
- **Crittografia**: Protezione dei dati sensibili
- **Audit Trail**: Tracciamento delle attività per conformità GDPR

## Integrazione dei Moduli

I moduli Laraxot sono integrati tramite:
- **Service Provider**: Registrazione dei servizi
- **Composer**: Gestione delle dipendenze
- **Autoloading**: Caricamento automatico delle classi

## Diagramma dell'Architettura

```
┌─────────────────────────────────────────────────────────┐
│                   Presentation Layer                     │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │  Web UI     │  │  Admin UI   │  │  API Endpoints  │  │
│  │ (ThemeOne)  │  │ (Filament)  │  │                │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
├─────────────────────────────────────────────────────────┤
│                  Business Logic Layer                    │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │   Actions   │  │  Services   │  │    Policies     │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
├─────────────────────────────────────────────────────────┤
│                   Data Access Layer                      │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │   Models    │  │ Repositories│  │     DTOs        │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
├─────────────────────────────────────────────────────────┤
│                    Infrastructure                        │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────┐  │
│  │  Database   │  │    Cache    │  │     Storage     │  │
│  └─────────────┘  └─────────────┘  └─────────────────┘  │
└─────────────────────────────────────────────────────────┘
```
