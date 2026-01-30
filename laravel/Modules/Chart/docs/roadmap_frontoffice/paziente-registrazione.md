# Flusso Registrazione Paziente

## Stato Attuale (Marzo 2024)
- 🚧 Implementazione base (85%)
- 🚧 Testing utente (70%)
- 🚧 Ottimizzazione UX (65%)

## Dettagli Implementazione

### 1. Form Registrazione Base
- ✅ Dati anagrafici
  - Nome e cognome
  - Data di nascita
  - Codice fiscale
  - Residenza
  - Contatti (email, telefono)
- 🚧 Validazione campi (80%)
  - Validazione real-time
  - Messaggi di errore
  - Formato dati
- 🚧 Salvataggio progressivo (75%)
  - Auto-save
  - Ripristino sessione
  - Gestione timeout

### 2. Gestione Documenti
- ✅ Upload documenti base
  - Tessera sanitaria
  - STP/ENI
  - Autocertificazione ISEE
  - Documentazione gravidanza
- 🚧 Validazione documenti (70%)
  - Verifica formato
  - Controllo dimensioni
  - OCR base
- 🚧 Compressione immagini (65%)
  - Ottimizzazione qualità
  - Ridimensionamento
  - Watermark

### 3. Questionario Anamnestico
- ✅ Domande base
  - Storia medica
  - Allergie
  - Farmaci in uso
  - Condizioni attuali
- 🚧 Logica condizionale (60%)
  - Domande dinamiche
  - Validazione dipendenze
  - Salvataggio parziale
- 🚧 Esportazione dati (55%)
  - Formato PDF
  - Integrazione cartella clinica
  - Backup automatico

### 4. Gestione Privacy
- ✅ Termini e condizioni
  - Accettazione base
  - Informativa privacy
  - Consensi marketing
- 🚧 Gestione consensi (50%)
  - Tracciamento modifiche
  - Storico versioni
  - Esportazione consensi
- 🚧 Conformità GDPR (45%)
  - Cookie policy
  - Privacy policy
  - Diritti utente

## Priorità Immediate

### 1. Ottimizzazione UX
- 🚧 Miglioramento form (40%)
  - [Dettagli UX](./paziente-ux.md)
  - [Validazione](./paziente-validazione.md)
  - [Notifiche](./paziente-notifiche.md)

### 2. Automazione Processi
- 🚧 Verifica automatica (35%)
  - [Automazione](./backoffice-automazione.md)
  - [Workflow](./backoffice-workflow.md)
  - [Alert](./backoffice-alert.md)

### 3. Integrazione Sistemi
- 🚧 Connessione SSN (30%)
  - [Integrazione](./integrazione-ssn.md)
  - [Validazione](./validazione-ssn.md)
  - [Reportistica](./reporting-ssn.md)

## Note Tecniche
- Utilizzare Laravel Folio per routing
- Implementare Livewire per interattività
- Gestire cache con Redis
- Implementare queue per processi pesanti

## Collegamenti
- [Gestione Documenti](./paziente-documenti.md)
- [Questionario](./paziente-questionario.md)
- [Privacy](./paziente-privacy.md)
- [Backoffice](./backoffice-pazienti.md)

## Metriche
- Tempo medio completamento: 15 min
- Tasso di abbandono: 25%
- Tasso di errore: 5%
- Soddisfazione utente: 4.2/5 
