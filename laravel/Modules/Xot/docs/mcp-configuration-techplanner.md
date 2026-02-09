# 🤖 Configurazione MCP per Meetup Fila4 Mono

## Panoramica

Questa documentazione descrive la configurazione del Model Context Protocol (MCP) ottimizzata per il progetto Meetup Fila4 Mono, un'applicazione Laravel modulare basata sull'architettura Laraxot.

## 🎯 Scopo del Sistema MCP

Il sistema MCP è configurato per supportare lo sviluppo e la manutenzione del progetto con particolare attenzione a:

- **Integrazione con Laravel**: Comandi Artisan e interazione con il framework
- **Accesso ai file**: Gestione efficiente dei file del progetto e delle risorse
- **Database**: Interazione diretta con MySQL per query e analisi
- **Documentazione**: Accesso rapido alla documentazione interna
- **Version control**: Integrazione con Git per analisi del codice
- **Testing e QA**: Supporto per testing e analisi di qualità del codice

## 📋 Server MCP Configurati

### 1. Laravel Artisan Server
- **Scopo**: Esecuzione diretta di comandi Artisan
- **Funzionalità**:
  - Esecuzione di comandi di sistema (migrate, seed, etc.)
  - Interazione con i modelli e le risorse
  - Gestione dei servizi Laravel
- **Path**: `artisan`

### 2. Filesystem Server
- **Scopo**: Accesso completo ai file del progetto
- **Directory monitorate**:
  - `/laravel` - Codice sorgente e moduli
  - `/docs` - Documentazione generale
  - `/bashscripts` - Script di utilità
  - `/laravel/Themes` - Temi e risorse frontend
- **Funzionalità**:
  - Lettura/scrittura di file
  - Ricerca per pattern
  - Analisi della struttura del progetto

### 3. MySQL Server
- **Scopo**: Interazione diretta con il database MySQL
- **Implementazione**: Script Node.js personalizzato per connessione sicura
- **Funzionalità**:
  - Esecuzione di query SQL
  - Analisi delle tabelle e strutture
  - Supporto per debugging e ottimizzazione database

### 4. Memory Server
- **Scopo**: Gestione della conoscenza e contesto durante lo sviluppo
- **Funzionalità**:
  - Knowledge graph persistente
  - Memorizzazione di pattern architetturali
  - Contesto tra sessioni di sviluppo multiple

### 5. Sequential Thinking Server
- **Scopo**: Problem-solving avanzato e analisi complessa
- **Funzionalità**:
  - Ragionamento strutturato step-by-step
  - Analisi multi-step per problemi complessi
  - Revisione e correzione del pensiero precedente

### 6. Fetch Server
- **Scopo**: Accesso a risorse esterne e API
- **Funzionalità**:
  - Download documentazione esterna
  - Testing di API esterne
  - Verifica di aggiornamenti e dipendenze

### 7. Git Server
- **Scopo**: Integrazione con il sistema di version control
- **Funzionalità**:
  - Analisi della storia dei commit
  - Ricerca di pattern nel codice
  - Verifica di cambiamenti e conflitti
  - Supporto per analisi del codice

### 8. Playwright Server
- **Scopo**: Testing e automazione frontend
- **Funzionalità**:
  - Test UI per le interfacce Filament
  - Testing di funzionalità frontend
  - Screenshot e registrazione per documentazione

### 9. Laravel Docs Server
- **Scopo**: Accesso rapido alla documentazione Laravel/Filament
- **Funzionalità**:
  - Ricerca nella documentazione ufficiale
  - Supporto durante lo sviluppo con reference diretti

## 🏗️ Integrazione con l'Architettura Laraxot

La configurazione MCP è specificamente ottimizzata per l'architettura modulare Laraxot:

### Supporto per Moduli
- Accesso diretto a tutti i moduli (Xot, User, Meetup, ecc.)
- Supporto per pattern XotBase* in tutte le interazioni
- Verifica della corretta estensione delle classi base

### Sicurezza e Best Practices
- Isolamento delle operazioni per modulo
- Controllo delle dipendenze tra moduli
- Verifica della compliance PHPStan Level 10

### Sviluppo Multi-Tenant
- Supporto per analisi delle configurazioni multi-tenant
- Verifica dell'isolamento dei dati
- Testing delle funzionalità tenant-specific

## 🔧 Configurazione Consigliata per gli Editor

### Per Cursor/Windsurf
Posizionare il file `mcp-config.json` nella directory principale del progetto o in `.cursor/` o `.windsurf/`.

### Per altri editor
Verificare la documentazione specifica dell'editor per l'integrazione MCP.

## 🚀 Utilizzo Ottimale

### Scenario 1: Analisi Architetturale
1. **Sequential Thinking** - Analisi step-by-step dell'architettura
2. **Memory** - Memorizzazione dei pattern trovati
3. **Git** - Analisi della storia e best practices
4. **Filesystem** - Accesso ai file per verifica

### Scenario 2: Debugging Complesso
1. **MySQL** - Verifica diretta dei dati
2. **Laravel Artisan** - Esecuzione di comandi di debug
3. **Memory** - Contesto delle sessioni precedenti
4. **Fetch** - Ricerca di soluzioni esterne

### Scenario 3: Sviluppo Funzionalità
1. **Filesystem** - Accesso ai file del modulo
2. **Laravel Artisan** - Generazione di codice
3. **Playwright** - Testing UI
4. **Laravel Docs** - Reference durante lo sviluppo

## 🛡️ Sicurezza

- Tutti i path sono specificati in modo assoluto
- Nessuna credenziale hardcoded nella configurazione
- Solo directory specifiche sono accessibili tramite filesystem server
- Utilizzo di script personalizzati per connessioni database sicure

## 📊 Metriche di Successo

Questa configurazione MCP è stata progettata per supportare:

- **Efficienza**: Accesso rapido a tutte le risorse necessarie
- **Qualità**: Supporto per mantenere gli standard PHPStan Level 10
- **Sicurezza**: Isolamento e protezione delle operazioni sensibili
- **Scalabilità**: Adattabilità ai cambiamenti dell'architettura
- **Collaborazione**: Supporto per diverse modalità di sviluppo

## 🔄 Manutenzione

La configurazione dovrebbe essere aggiornata quando:
- Vengono aggiunti nuovi moduli
- Cambiano le strutture del database
- Vengono implementati nuovi pattern architetturali
- Cambiano le dipendenze del progetto
