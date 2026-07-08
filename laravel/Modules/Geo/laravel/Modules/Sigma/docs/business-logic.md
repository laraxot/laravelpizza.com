# Business Logic – Modulo Sigma

> **Scopo**: riassumere la logica di business di Sigma in modo DRY+KISS e puntare ai documenti di dettaglio.
>
> Documenti di approfondimento:
> - [Business Logic Analysis](./business-logic-analysis.md)
> - [Architecture](./architecture.md)
> - [Module Dependencies](./module-dependencies.md)
> - [Summary](./summary.md)

---

## 1. Scopo del modulo

Il modulo **Sigma** è il **motore di calcolo delle schede di valutazione** per le progressioni di carriera nella PA.

In pratica Sigma:

- **Aggrega** dati da più fonti:
  - Performance (valutazioni individuali)
  - Presenze/assenze (timbrature, codici assenza)
  - Parametri integrativi (integparam)
  - Anagrafiche (Anag, User)
- **Calcola** valori derivati complessi (giorni, performance medie, punteggi)
- **Persiste** i risultati in modo denormalizzato per avere UI e report veloci
- **Serve** altri moduli (Ptv, Progressioni, Indennità, Incentivi) come fonte autorevole di dati calcolati

Principio guida:

> "Calcolare una volta, consultare mille volte"  
> (calcolo costoso → valore persistito → letture economiche)

Per il dettaglio normativo e casi d’uso vedi:
- [Business Logic Analysis](./business-logic-analysis.md)

---

## 2. Entità e concetti chiave

### 2.1 Scheda

Rappresenta la **scheda di valutazione annuale** di un dipendente.

Campi chiave:

- Identità: `id`, `ente`, `matr`, `anno`
- Periodo: `dal`, `al`
- Calcoli giorni: `gg_*` (presenza, assenza, esperienza, ecc.)
- Performance: `perf_ind_*`, `perf_ind_media`
- Punteggi: `totale`, `totale_pond`, altri indicatori usati dai moduli di progressione

Sigma non decide *se* il dipendente ottiene la progressione: fornisce i **dati oggettivi** e consolidati che gli altri moduli usano per prendere la decisione.

### 2.2 IntegParam e dati di base

Altre entità importanti (vedi doc di dettaglio):

- **IntegParam**: parametri integrativi per calcolo giorni/punteggi
- **Anag / Ana
b**: anagrafiche e storici posizione
- **Qua00f / Qua03f / Rep00f / Sto00f / Asz00f / Asz00k1 / Tqu00f**: tabelle tecniche di qualifica, reparto, assenze, storici, ecc.

Dettagli ed esempi completi in:
- [Business Logic Analysis – Entità Principali](./business-logic-analysis.md)

---

## 3. Flussi di business principali

### 3.1 Creazione e popolamento di una scheda

Flusso tipico (semplificato):

1. **Creazione scheda** con dati minimi (`ente`, `matr`, `anno`, periodo).
2. Primo `save()` per avere una PK (`id`).
3. Gli **accessor** di Sigma calcolano i vari campi derivati (giorni, performance, punteggi) usando dati da Performance, PresenzeAssenze, integparam, ecc.
4. Ogni accessor:
   - Verifica se il valore è già presente (cache DB).
   - Se serve ricalcolo, delega ad un **metodo puro** di calcolo.
   - Persiste il risultato con **update chirurgico** sul singolo campo.

Risultato: la scheda diventa una **snapshot denormalizzata** pronta per essere letta rapidamente da UI e report.

### 3.2 Edit e refresh di una scheda

Quando cambiano dati di base (nuove performance, correzioni presenze, parametri integrativi):

1. Gli accessor controllano un flag di **refresh** (`request()->input('refresh', 0)`).
2. Se `refresh` è attivo, ricalcolano il valore e lo ripersistono.
3. I moduli che mostrano schede (es. UI Filament) possono esporre azioni "ricalcola" basate su questo flag.

Questo permette di avere sia:

- Letture rapide (cache DB),
- Sia la possibilità di riallineare i calcoli quando la base dati cambia.

Per esempi concreti di codice vedi:
- [business-logic-analysis.md – Workflow Business](./business-logic-analysis.md)

---

## 4. Pattern architetturale: Delegation Cascade

Sigma applica un **Delegation Cascade Pattern** centrato su `SchedaTrait`:

- `SchedaTrait` = **orchestratore** (accessor, ciclo di vita, deleghe)
- `SchedaHelper` = **metodi puri** di calcolo
- `FunctionExtra` / `MassExtra` = operazioni DB-heavy e di massa
- `CommonScope` / altri trait = filtri riutilizzabili (anno, ente, intervalli di date)

Idea chiave:

> Gli accessor non fanno calcolo complesso: 
> gestiscono cache/guard/persistenza e delegano il calcolo a metodi puri.

Vedi:
- [Architecture – Delegation Cascade Pattern](./architecture.md)

---

## 5. Relazioni con altri moduli

Sigma è un **modulo infrastrutturale di dominio**: non vive da solo.

### 5.1 Moduli che usano Sigma

- **Ptv** – usa `BaseScheda` con `SchedaTrait` per gestire schede PTV.
- **Progressioni** – usa `Schede` con `SchedaTrait` + `SigmaModelTrait` (con `insteadof` per risolvere conflitti).
- **IndennitaResponsabilita** – usa direttamente i modelli Sigma per calcolare indennità.
- **Incentivi** – usa modelli Sigma per anagrafiche/stabilimenti e calcoli correlati.

### 5.2 Moduli da cui Sigma dipende

- **Performance** – fornisce i dati di valutazione individuale.
- **PresenzeAssenze** – fornisce i dati di timbrature/assenze (tramite Anag).
- **User** – anagrafiche utente/dipendente.

Per diagrammi e snippet di esempio vedi:
- [Module Dependencies](./module-dependencies.md)

---

## 6. Regole di dominio (estratto)

Alcune regole di business chiave (vedi doc di dettaglio per la versione completa):

- **Performance Individuale Media**
  - Media (non ponderata) delle performance degli ultimi N anni non nulli.
  - Se non ci sono anni validi → 0.0.
- **Giorni Esperienza Validi**
  - = giorni cateco_posfun - giorni assenza rilevanti.
  - Aspettative possono escludere giorni dal conteggio.
- **Gestione Assenze**
  - Codici assenza diversi hanno trattamenti differenti (alcuni totalmente esclusi, altri parzialmente conteggiati).

Ulteriori dettagli, esempi di codice e riferimenti CCNL in:
- [Business Logic Analysis](./business-logic-analysis.md)

---

## 7. Cosa fare quando tocchi Sigma

Quando modifichi Sigma o moduli che lo usano:

1. **Parti da qui** (business-logic.md) per ricordare scopo e flussi.
2. Leggi i dettagli in:
   - `business-logic-analysis.md`
   - `architecture.md`
   - `module-dependencies.md`
3. Identifica **quali moduli dipendenti** potrebbero essere impattati (Progressioni, Ptv, Indennità, Incentivi).
4. Pianifica eventuali **test di regressione cross‑modulo**.
5. Aggiorna questa pagina solo per cambiare la **visione di alto livello**, lasciando i dettagli ai file specialistici.
