# Piano di Consolidamento Documentazione PTVX - 2025

## Obiettivo
Consolidare, organizzare e aggiornare sistematicamente la documentazione del progetto PTVX seguendo i principi **DRY (Don't Repeat Yourself)** + **KISS (Keep It Simple, Stupid)** con focus sulla **business logic**.

## Stato Attuale (Analisi Completata)

### Problematiche Identificate
1. **Naming non conforme**: Numerosi file con lettere maiuscole e separatori inconsistenti
2. **Duplicazioni**: File archivio non organizzati, contenuti duplicati
3. **File vuoti**: Molti placeholder vuoti nella docs root
4. **Incoerenza strutturale**: Mancanza di collegamenti bidirezionali sistematici

### Statistiche
- **Moduli totali**: ~30
- **File .md non conformi**: ~1000+ (inclusi archivi)
- **File .md docs root**: Maggioranza vuoti
- **Unico file sostanzioso root**: `filament-4-upgrade-guide.md` (260 righe)

## Business Logic del Progetto

### Sistema PTVX (Pubblica Amministrazione)
**Scopo**: Sistema modulare per la gestione del personale e processi PA

**Moduli Core**:
1. **Xot**: Base framework - architettura, service providers, convenzioni
2. **User**: Autenticazione, autorizzazione, ruoli, permessi, teams
3. **UI**: Componenti interfaccia Filament custom
4. **Tenant**: Multi-tenancy per gestione enti
5. **Performance**: Valutazioni dipendenti
6. **Activity**: Event sourcing, audit log
7. **Lang**: Gestione traduzioni centralizzata

**Moduli Specifici PA**:
- **IndennitaCondizioniLavoro**: Gestione indennità
- **IndennitaResponsabilita**: Indennità di responsabilità
- **Performance**: Sistema valutazione
- **PresenzeAssenze**: Timbrature e presenze
- **Progressioni**: Progressioni di carriera
- **MobilitaVolontaria**: Mobilità personale

**Stack Tecnologico**:
- Laravel 10.x → 11.x (upgrade in corso)
- Filament 3.x → 4.x (upgrade in corso)
- PHP 8.1+ → 8.2+
- PHPStan livello 10 (qualità codice)
- Spatie Laravel Data (DTO)
- Spatie QueueableActions (business logic)

## Filosofia Documentazione

### Principi DRY
- **Eliminare duplicazioni**: Un concetto = un luogo
- **Single Source of Truth**: Ogni informazione ha un'unica fonte autorevole
- **Collegamenti invece di copie**: Usare riferimenti bidirezionali

### Principi KISS
- **Semplicità prima di tutto**: Documentazione diretta, senza orpelli
- **Navigazione intuitiva**: Trovare informazioni in <3 passaggi
- **No over-engineering**: Struttura minimale ma efficace

### Focus Business Logic
- **Perché**: Motivazioni strategiche e architetturali
- **Scopo**: Obiettivi funzionali e di dominio
- **Religione/Politica**: Decisioni architetturali non negoziabili
- **Filosofia**: Approccio al problema e pattern adottati

## Piano d'Azione

### Fase 1: Pulizia e Standardizzazione (COMPLETATA)
✅ Analisi stato attuale
✅ Identificazione file non conformi
✅ Comprensione business logic

### Fase 2: Consolidamento Root Docs (IN CORSO)
**Obiettivo**: Creare documentazione root essenziale e ben collegata

**Azioni**:
1. Creare `README.md` root completo
2. Popolareindex.md` con navigazione
3. Consolidare guide essenziali:
   - `getting-started.md`
   - `architecture.md`
   - `development-guide.md`
   - `module-development.md`
   - `testing-strategy.md`
4. Archiviare documentazione obsoleta
5. Standardizzare naming (solo minuscolo eccetto README.md)

### Fase 3: Consolidamento Moduli
**Per ogni modulo**:
1. Verificare/creare `README.md`
2. Creare documentazione essenziale:
   - `architecture.md` - Architettura e decisioni
   - `business-logic.md` - Dominio e logica
   - `api.md` - Interfacce pubbliche
   - `testing.md` - Strategie di test
3. Archiviare documentazione obsoleta
4. Collegamenti bidirezionali con root e altri moduli

### Fase 4: Collegamenti e Cross-Reference
1. Mappa completa delle dipendenze tra moduli
2. Collegamenti bidirezionali sistematici
3. Indice centralizzato delle risorse

### Fase 5: Validazione Finale
1. Verifica assenza duplicazioni
2. Verifica conformità naming
3. Verifica completezza collegamenti
4. Test navigazione documentazione

## Metriche di Successo

### Quantitative
- 0 file con naming non conforme (eccetto README.md)
- 0 duplicazioni di contenuto
- 100% moduli con documentazione base
- 100% collegamenti bidirezionali verificati

### Qualitative
- Tempo per trovare info <3 min
- Chiarezza business logic: Alta
- Facilità onboarding nuovi dev: Alta
- Manutenibilità: Alta

## Regole Ferree

### Naming Files
- **SOLO minuscolo**: `nome-file.md`
- **Separatore trattino**: `-` (NON `_`)
- **UNICA ECCEZIONE**: `README.md`
- **NO date nei nomi**: `2025-01-update.md` ❌

### Creazione Nuovi File
1. **Verifica esistenza**: Prima controlla se esiste già file simile
2. **Posizionamento corretto**: Docs modulo O docs root
3. **NON creare nuove cartelle docs**
4. **Naming conforme**: Immediatamente

### Contenuto Documentazione
1. **Business logic sempre prima**: Perché, scopo, motivazione
2. **Collegamenti bidirezionali**: Sempre
3. **Esempi pratici**: Pattern + anti-pattern
4. **NO stringhe hardcoded**: Sempre traduzioni
5. **PHPStan compliant**: Esempi codice livello 10

## Backlink e Riferimenti

### Documentazione Correlata
- [Getting Started Guide](./getting-started/README.md)
- [Architecture Overview](./architecture/README.md)
- [Module Development](./development/module-development.md)
- [Filament 4 Upgrade](./filament-4-upgrade-guide.md)

### Regole Cursor/Windsurf
- [.cursor/rules](../.cursor/rules/)
- [.windsurf/rules](../.windsurf/rules/)

---

**Ultimo aggiornamento**: 2025-01-29
**Responsabile**: AI Assistant
**Stato**: In progressione - Fase 2 avviata

