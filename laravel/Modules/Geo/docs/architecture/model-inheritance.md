# Principi di Ereditarietà dei Modelli

## Principio Fondamentale
Tutti i modelli nel modulo Geo devono estendere `\Modules\Geo\Models\BaseModel` e non direttamente `Illuminate\Database\Eloquent\Model`. Questa non è una semplice preferenza stilistica, ma una decisione architettonica con profonde implicazioni.

## Razionale Architettonico

### 1. Principio DRY (Don't Repeat Yourself)
L'estensione del `BaseModel` permette di centralizzare:
- Configurazioni comuni come `$snakeAttributes`, `$timestamps`
- Trait condivisi come `Updater`
- Definizioni di cast comuni
- Impostazioni di connessione al database

### 2. Coesione e Accoppiamento
- **Alta coesione**: Ogni modulo ha una propria classe base che definisce il comportamento specifico del modulo
- **Basso accoppiamento**: I cambiamenti nella logica di base impattano solo il `BaseModel`, non tutti i modelli individuali

### 3. Principio di Stratificazione
L'architettura del sistema segue un modello a strati:
```
Modules\Xot\Models\BaseModel   (Livello 1: Base comune cross-module)
   ↑
Modules\Geo\Models\BaseModel   (Livello 2: Base specifica del modulo)
   ↑
Modules\Geo\Models\Address     (Livello 3: Implementazione concreta)
```

## Dimensione Filosofica

### Paradigma Olistico
L'estensione del `BaseModel` incarnna un approccio olistico alla progettazione del software:
- Il modello non è un'entità isolata, ma parte di un ecosistema più ampio
- L'identità del modello è definita dal contesto (il modulo) in cui esiste
- L'insieme (il modulo) influenza le parti (i modelli), e viceversa

### Principio di Zen: "Mu" (無)
Il concetto zen di "Mu" (assenza di categorie separate) si riflette in questa architettura:
- Non esiste una separazione netta tra il "modello" e il "modulo"
- Ogni modello incapsula la filosofia del modulo a cui appartiene
- L'intero è presente nella parte

## Dimensione Politica

### Governance e Autonomia
- **Autonomia del modulo**: Ogni modulo definisce le proprie politiche attraverso il `BaseModel`
- **Centralizzazione controllata**: Alcune decisioni sono prese a livello centrale (traits, connessioni)
- **Federalismo**: Bilancio tra autonomia dei modelli e coerenza dell'ecosistema

### Contratto Sociale
Estendere `BaseModel` rappresenta l'adesione al "contratto sociale" del modulo:
- Accettazione delle convenzioni comuni
- Sottomissione a regole condivise per il bene dell'ecosistema
- Bilanciamento tra libertà individuale (del modello) e bene comune (dell'applicazione)

## Implicazioni Tecniche

### 1. Connessione al Database
`BaseModel` specifica `protected $connection = 'geo';`, garantendo che tutti i modelli utilizzino la stessa connessione.

### 2. Trait Condivisi
Il trait `Updater` aggiunge funzionalità di tracciamento delle modifiche a tutti i modelli.

### 3. Configurazioni Comuni
Configurazioni come `$snakeAttributes = true` garantiscono coerenza nella serializzazione.

### 4. Gestione del Ciclo di Vita
Eventi come `creating`, `updating`, ecc. possono essere gestiti uniformemente nel `BaseModel`.

## Impatto sulla Manutenibilità

### Scenario 1: Cambio di Requisiti
Se dobbiamo modificare il comportamento di tutti i modelli del modulo Geo:
- **Con BaseModel**: Modifichiamo una sola classe
- **Senza BaseModel**: Dobbiamo modificare ogni singolo modello

### Scenario 2: Aggiunta di Funzionalità
Se dobbiamo aggiungere una nuova funzionalità a tutti i modelli:
- **Con BaseModel**: Aggiungiamo il trait o il metodo al BaseModel
- **Senza BaseModel**: Aggiungiamo il trait o il metodo a ogni singolo modello

### Scenario 3: Debugging
Se un comportamento inatteso si verifica in tutti i modelli:
- **Con BaseModel**: Sappiamo immediatamente dove cercare
- **Senza BaseModel**: Dobbiamo esaminare ogni modello individualmente

## Conclusione

L'estensione di `BaseModel` non è una semplice convenzione sintattica, ma una decisione architettonica che:
- Migliora la manutenibilità
- Rafforza la coesione del modulo
- Riflette principi filosofici di olismo e armonia
- Stabilisce un framework politico di governance
- Realizza il principio zen dell'unità nella diversità

Ogni volta che creiamo un nuovo modello nel modulo Geo, la sua estensione da `BaseModel` rappresenta un atto di allineamento con questi principi fondamentali, garantendo che il modello non sia solo una raccolta di attributi e metodi, ma un cittadino responsabile nell'ecosistema più ampio dell'applicazione.