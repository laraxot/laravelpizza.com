# PHPStan Errori LocationSelector - Analisi e Correzione

## Problema Identificato

Il componente `LocationSelector` presenta errori PHPStan livello 10:

1. **Classe non trovata**: `Modules\Geo\Models\Comune` non esiste
2. **Metodi su mixed**: Tutti i metodi chiamati su `Comune` risultano su `mixed` perché la classe non è trovata

## Analisi Business Logic

### Scopo del Componente
`LocationSelector` è un componente Filament per la selezione gerarchica di:
- Regione
- Provincia (dipendente da regione)
- CAP (dipendente da regione e provincia)

### Modello Geografico Attuale
- **Modulo Geo**: NON esiste
- **Modulo Sigma**: Esiste `Modules\Sigma\Models\Comuni` ma con struttura diversa:
  - Campi: `id`, `comune`, `descom`, `provin`, `codcap`
  - NON ha campi JSON `regione`, `provincia`, `cap`
  - Struttura piatta, non gerarchica

## Strategia di Correzione Proposta

### Opzione 1: Creare Modello Geo (RACCOMANDATO)
Creare il modulo Geo con il modello `Comune` che ha la struttura JSON attesa:
- `regione` (JSON): `{codice: string, nome: string}`
- `provincia` (JSON): `{codice: string, nome: string}`
- `cap` (JSON array): `[{codice: string}]`

**Vantaggi**:
- Mantiene la logica esistente del componente
- Separazione responsabilità (Geo vs Sigma)
- Struttura dati gerarchica corretta

**Svantaggi**:
- Richiede creazione nuovo modulo
- Richiede migrazione dati da Sigma se necessario

### Opzione 2: Adattare a Modello Sigma Esistente
Modificare `LocationSelector` per usare `Modules\Sigma\Models\Comuni`:
- Rimuovere query su campi JSON
- Usare campi piatti: `provin`, `codcap`
- Adattare logica gerarchica

**Vantaggi**:
- Usa dati esistenti
- Nessun nuovo modulo

**Svantaggi**:
- Perde struttura gerarchica
- Richiede refactoring completo
- Potrebbe non supportare tutte le funzionalità attuali

### Opzione 3: Disabilitare Componente (TEMPORANEO)
Aggiungere `@phpstan-ignore` e gestione errori:
- Mantiene codice esistente
- Previene errori runtime con try-catch

**Vantaggi**:
- Nessuna modifica architetturale
- Soluzione rapida

**Svantaggi**:
- Non risolve il problema root
- Componente non funzionante
- Debito tecnico

## Decisione

**SCELTA: Opzione 1 - Creare Modello Geo**

**Motivazione**:
- Il componente è progettato per struttura gerarchica JSON
- Separazione responsabilità (Geo = dati geografici, Sigma = dati anagrafici)
- Mantiene business logic esistente
- Migliore architettura a lungo termine

## Implementazione Proposta

1. **Creare Modulo Geo**:
   - `Modules/Geo/app/Models/Comune.php`
   - Struttura con campi JSON per regione, provincia, cap
   - Estende `BaseModel` del modulo Geo

2. **Creare Migrazione**:
   - Tabella `comuni` con campi JSON
   - Struttura gerarchica completa

3. **Aggiornare LocationSelector**:
   - Verificare import corretto
   - Rimuovere `@phpstan-ignore` se presenti

## File da Modificare

- ✅ `laravel/Modules/UI/app/Filament/Forms/Components/LocationSelector.php` (correggere import)

## File da Creare

- ⚠️ `laravel/Modules/Geo/app/Models/Comune.php` (creare modello)
- ⚠️ `laravel/Modules/Geo/database/migrations/YYYY_MM_DD_HHMMSS_create_comuni_table.php` (creare migrazione)

## Note

- Verificare se esistono dati geografici da migrare da Sigma
- Valutare se Geo deve essere modulo separato o parte di UI
- Documentare struttura dati JSON attesa

*Ultimo aggiornamento: 2025-01-27*

