# Fasi di Sviluppo del Modulo Rating

## Fase 1 · Stabilizzazione della base tecnica

### Obiettivi

- Portare il modulo a **PHPStan Level 10** senza errori.
- Allineare tutte le dipendenze e il codice a **Laravel 12** e **Filament v5**.
- Garantire che il modulo sia **sicuro da riutilizzare** in altri progetti Laraxot senza regressioni.

### Attività

- Normalizzare namespace, tipi di ritorno e nullable secondo le regole Laraxot Core.
- Verificare che tutti i modelli del modulo estendano il `BaseModel` corretto del modulo.
- Adeguare eventuali Resource / Widget Filament alle XotBase classes e alle regole:
  - niente `->label()` / `->placeholder()` / `->helperText()`
  - array con **chiavi stringa** per `getTableColumns()`, `getTableFilters()`, `getInfolistSchema()`.
- Aggiungere o correggere test Pest minimi ma significativi sulla logica di rating.

## Fase 2 · Funzionalità core di rating

### Obiettivi

- Implementare in modo stabile il **trait `HasRatingsTrait`** e le sue relazioni pivot.
- Consentire la configurazione di **criteri di valutazione** con campi chiari (nome, descrizione, peso, scala, attivo, ecc.).
- Definire regole di validazione configurabili per l’inserimento/aggiornamento dei punteggi.

### Attività

- Disegnare e documentare il modello dati:
  - tabella criteri
  - eventuale tabella di configurazione scala/valori
  - pivot per collegare entità valutate e punteggi.
- Estrarre la logica di calcolo del punteggio in Actions riusabili (es. `ComputeRatingAction`, `UpdateRatingAggregateAction`).
- Scrivere test di integrazione che coprano:
  - creazione di un rating
  - aggiornamento
  - cancellazione/logica di soft delete se prevista.

## Fase 3 · Integrazione con moduli consumer

### Obiettivi

- Fornire pattern chiari per l’integrazione con altri moduli (es. User, Patient, Cms, ecc.).
- Garantire che le traduzioni siano complete in italiano e inglese per tutti i concetti di rating.
- Documentare scenari di utilizzo tipici (es. valutazione di utenti, servizi, contenuti).

### Attività

- Definire esempi di integrazione in documentazione (non hardcodare riferimenti ad un singolo modulo consumer).
- Aggiungere esempi di componenti Filament (widget/list) puramente dimostrativi per mostrare l’uso del modulo.
- Allineare file di traduzione `lang/it` e `lang/en` con struttura espansa (navigation, fields, actions, messages).

---

Per i **criteri di accettazione** dettagliati e verificabili di ogni fase si veda [acceptance-criteria.md](acceptance-criteria.md).  
Per le **metriche** di qualità e test si veda [metrics.md](metrics.md).

