# Business Logic - Indennità Responsabilità

> **Focus**: PERCHÉ esiste questo modulo e COME risolve problemi reali

---

## 🎯 Lo Scopo del Modulo

### Il Problema da Risolvere

Le pubbliche amministrazioni devono:
1. **Valutare** il personale dirigenziale annualmente
2. **Calcolare** indennità di responsabilità basate su criteri oggettivi
3. **Documentare** il processo di valutazione
4. **Tracciare** le modifiche nel tempo
5. **Generare** documentazione ufficiale (PDF, lettere)

### La Soluzione

Sistema informatizzato che:
- Automatizza il processo di valutazione
- Calcola indennità secondo formule definite
- Garantisce trasparenza e tracciabilità
- Produce documentazione conforme

---

## 🏗️ Architettura Business

### Entità Principali

#### 1. IndennitaResponsabilita (Scheda Principale)

**Scopo**: Rappresenta la valutazione annuale di un dirigente.

**Business Rules**:
- Una scheda per dirigente per anno
- Collegata a dati anagrafici (Sigma)
- Contiene valutazioni (Rating)
- Calcola importo indennità automaticamente

**Workflow**:
```
Creazione Scheda → Compilazione Valutazioni → Calcolo Automatico → Approvazione → Generazione PDF
```

#### 2. Rating (Valutazioni)

**Scopo**: Criteri di valutazione configurabili per anno.

**Business Rules**:
- Criteri diversi per anno (schemaless attributes)
- Punteggi da 0 a 5 per criterio
- Alcuni criteri readonly (calcolati)
- Totale determina l'indennità

**Formula Base**:
```
Totale Punti × 10 = Importo Mensile Base
Importo Mensile × % Part-Time = Importo Attribuito
Importo Attribuito × 12 × (giorni/365) = Importo Annuale
```

#### 3. StabiDirigente (Valutatore)

**Scopo**: Collegamento tra stabilimento e dirigente valutatore.

**Business Rules**:
- Ogni stabilimento ha un dirigente responsabile
- Il dirigente può valutare il personale del suo stabilimento
- Autorizzazione basata su questo collegamento

---

## 💼 Casi d'Uso Principali

### UC1: Compilazione Indennità

**Attori**: Dirigente, Valutatore  
**Scopo**: Inserire valutazioni per calcolare indennità

**Flow**:
1. Valutatore accede alla scheda del dirigente
2. Sistema mostra criteri di valutazione per l'anno
3. Valutatore inserisce punteggi (0-5)
4. Sistema calcola automaticamente:
   - Totale punti
   - Importo mensile calcolato
   - Importo mensile attribuito (con % part-time)
   - Importo annuale attribuito (proporzionale ai giorni)
5. Valutatore salva
6. Sistema traccia modifiche (Activity Log)

**Business Rules**:
- Solo valutatore autorizzato può compilare
- Punteggi devono essere 0-5
- **Validazione Minima**: Almeno 2 criteri devono avere un punteggio > 0 (come da legenda)
- Calcoli automatici non modificabili
- Salvataggio tracciato

### UC2: Consultazione Storico

**Attori**: Dirigente, HR, Amministrazione  
**Scopo**: Vedere storico valutazioni

**Flow**:
1. Utente accede alla lista schede
2. Filtra per anno, dirigente, stabilimento
3. Visualizza schede compilate
4. Può vedere dettaglio valutazioni
5. Può vedere storico modifiche (Activity Log)

**Business Rules**:
- Visibilità basata su permessi
- Storico immutabile (audit trail)
- Export per reporting

### UC3: Generazione Documentazione

**Attori**: Sistema, HR  
**Scopo**: Produrre documenti ufficiali

**Flow**:
1. Scheda compilata e approvata
2. Sistema genera PDF con:
   - Dati anagrafici dirigente
   - Valutazioni dettagliate
   - Calcoli indennità
   - Firme digitali
3. PDF archiviato e inviato

**Business Rules**:
- Solo schede approvate
- Template ufficiale
- Tracciabilità generazione

---

## 🔢 Logica di Calcolo

### Formula Indennità

```
INPUT:
- Valutazioni (ratings): punteggi 0-5 per criterio
- % Part-Time anno: percentuale lavoro
- Periodo: dal - al (giorni effettivi)

CALCOLO:
1. Totale = Σ(punteggi editabili)
2. Importo Mensile Calcolato = Totale × 10 €
3. Importo Mensile Attribuito = Importo Calcolato × % Part-Time
4. Importo Annuale = Importo Attribuito × 12 × (giorni periodo / 365)

OUTPUT:
- Importo annuale da erogare
```

**Esempio**:
```
Totale punti: 25
Importo mensile calcolato: 25 × 10 = 250 €
Part-time: 80%
Importo mensile attribuito: 250 × 0.8 = 200 €
Periodo: 01/01 - 31/12 (365 giorni)
Importo annuale: 200 × 12 × (365/365) = 2,400 €
```

---

## 🔐 Autorizzazioni

### Policy Rules

```php
// Chi può fare cosa

view: Tutti (con permesso base)
viewAny: Tutti (lista)
create: Solo HR/Admin
update: Solo valutatore assegnato
delete: Solo Admin
compila: Solo valutatore dello stabilimento
```

**Business Logic**:
- Dirigente può vedere solo le proprie schede
- Valutatore può compilare solo schede del suo stabilimento
- HR può vedere tutte
- Admin può tutto

---

## 🔄 Integrazione con Altri Moduli

### Sigma (Dati Anagrafici)

**Scopo**: Fonte dati personale

**Integration**:
- `anag`: Anagrafica completa dirigente
- `wstr01lx`: Storico contratti
- `sto00f`: Storico posizioni
- `qua00f`: Qualifiche
- `rep00f`: Reparti

**Business Logic**: Dati Sigma sono READ-ONLY, fonte unica verità

### Rating (Sistema Valutazioni)

**Scopo**: Criteri e punteggi

**Integration**:
- Relazione polimorfica `ratings()`
- Criteri configurabili per anno (schemaless)
- Validazione regole dinamiche

**Business Logic**: Rating module gestisce COSA valutare, questo modulo gestisce COME usare le valutazioni

### Activity (Audit Trail)

**Scopo**: Tracciabilità modifiche

**Integration**:
- Automatico su save/update/delete
- Storico completo accessibile
- Compliance GDPR

**Business Logic**: Ogni modifica deve essere tracciata per audit

### Ptv (Base Framework)

**Scopo**: Struttura comune schede

**Integration**:
- Estende `BaseScheda`
- Usa `Profile` per creator/updater
- Pattern comuni per tutte le schede

**Business Logic**: Consistenza tra tutti i moduli di valutazione

---

## 📊 Stati e Workflow

### Stati Scheda

```
DRAFT → IN_COMPILAZIONE → COMPILATA → APPROVATA → ARCHIVIATA
```

**Transizioni**:
- `DRAFT`: Creata, non ancora compilata
- `IN_COMPILAZIONE`: Valutatore sta inserendo dati
- `COMPILATA`: Tutti i campi inseriti
- `APPROVATA`: Validata da responsabile
- `ARCHIVIATA`: Anno chiuso, immutabile

### Business Rules per Stato

| Stato | Può Modificare | Può Eliminare | Può Approvare |
|-------|----------------|---------------|---------------|
| DRAFT | Valutatore | Admin | No |
| IN_COMPILAZIONE | Valutatore | Admin | No |
| COMPILATA | No | No | Responsabile |
| APPROVATA | No | No | No |
| ARCHIVIATA | No | No | No |

---

## 🎯 Obiettivi di Business

### Trasparenza

- Criteri di valutazione chiari e documentati
- Calcoli automatici e verificabili
- Storico completo delle modifiche

### Efficienza

- Processo digitale (no carta)
- Calcoli automatici (no errori manuali)
- Generazione documenti automatica

### Compliance

- Tracciabilità completa (Activity Log)
- Audit trail immutabile
- GDPR compliant

### Equità

- Criteri oggettivi e uguali per tutti
- Processo standardizzato
- Valutazioni documentate

---

## 🔍 Perché Certe Scelte Architetturali

### Perché Schemaless Attributes per Rating?

**Problema**: Criteri di valutazione cambiano ogni anno  
**Soluzione**: Schemaless attributes permettono configurazione flessibile  
**Beneficio**: No migration per ogni cambio criteri

### Perché MorphToMany per Rating?

**Problema**: Ratings usati da più moduli (IndennitaResponsabilita, Performance, etc.)  
**Soluzione**: Relazione polimorfica  
**Beneficio**: Riuso Rating module, DRY compliance

### Perché BaseScheda di Ptv?

**Problema**: Logica comune tra schede valutazione  
**Soluzione**: Estensione BaseScheda  
**Beneficio**: Consistenza, meno codice, pattern condiviso

### Perché Activity Log?

**Problema**: Necessità audit trail per compliance  
**Soluzione**: Spatie Activity Log automatico  
**Beneficio**: Tracciabilità completa, GDPR compliant

---

## 📚 Related Documentation

- [README.md](./README.md) - Module overview
- [Architecture Overview](./architecture-overview.md) - Technical architecture
- [Rating System](./features/rating-system.md) - How ratings work
- [CHANGELOG.md](./CHANGELOG.md) - Temporal history

---

**Focus**: Business logic and purpose  
**Philosophy**: Transparency, efficiency, compliance, equity  
**Zen**: Automate the boring, document the important, trace everything


