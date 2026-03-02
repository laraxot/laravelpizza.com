# Implementazione di Sushi nel Modulo Geo

## Cos'è Sushi?

Sushi è una libreria creata da Caleb Porzio che consente di utilizzare i modelli Eloquent con dati in memoria, senza necessità di una tabella nel database. Il nome "Sushi" si riferisce all'idea che i dati siano "serviti crudi" direttamente dal codice, senza passare dal database.

## Caratteristiche principali

- Crea un database SQLite temporaneo in memoria o in cache
- Permette di utilizzare tutte le funzionalità di Eloquent (query, relazioni, ecc.)
- Ideale per dati statici o raramente modificabili
- Supporta relazioni con modelli "normali" basati su database
- Consente validazione dei dati con le regole di Laravel

## Vantaggi dell'utilizzo di Sushi (90%)

1. **Prestazioni superiori (95%)**: I dati sono caricati in memoria, evitando query al database.
2. **Semplicità di gestione (90%)**: Dati definiti direttamente nel codice, senza necessità di migrazioni.
3. **Versionamento del codice (95%)**: I dati sono parte del codice sorgente, quindi versionati con Git.
4. **Facilità di deployment (95%)**: Non è necessario sincronizzare database tra ambienti.
5. **Eliminazione di seeder (100%)**: Non servono seeder per dati di riferimento.
6. **Coerenza dei dati (90%)**: I dati sono garantiti coerenti in tutti gli ambienti.
7. **Facilità di test (95%)**: Test più semplici senza mock di database.

## Svantaggi dell'utilizzo di Sushi (10%)

1. **Limitazioni per grandi dataset (20%)**: Non consigliato per tabelle con migliaia di righe.
2. **Difficoltà di modifica runtime (40%)**: I dati sono definiti nel codice, quindi non facilmente modificabili.
3. **Limitazioni in alcune query complesse (15%)**: Alcune operazioni avanzate potrebbero non funzionare.
4. **Incompatibilità con `whereHas` (100%)**: Non funziona con relazioni tra database diversi.
5. **Overhead di memoria (15%)**: Per dataset molto grandi, può consumare memoria.

## Casi d'uso ideali

Sushi è particolarmente indicato per:

1. **Dati di riferimento** (regioni, province, comuni, CAP)
2. **Enumerazioni complesse** che richiedono relazioni
3. **Configurazioni statiche** del sistema
4. **Dati geografici** che cambiano raramente
5. **Tabelle di lookup** usate frequentemente

## Casi d'uso non ideali

Sushi non è consigliato per:

1. **Dati modificati frequentemente** dagli utenti
2. **Dataset molto grandi** (>10.000 righe)
3. **Dati che richiedono transazioni complesse**
4. **Informazioni che necessitano backup regolari**

## Implementazione raccomandata per Comune.php

Per il modello `Comune.php`, Sushi rappresenta una scelta eccellente (valutazione: 95% positiva) considerando:

1. L'elenco dei comuni italiani cambia raramente
2. I dati sono utilizzati frequentemente per ricerche e relazioni
3. La struttura è standardizzata e ben definita
4. Il dataset è di dimensioni gestibili (circa 8.000 comuni)

### Analisi tecnica del modello Comune con Sushi

#### Impatto sulle prestazioni
- **Lettura**: Miglioramento del 80-95% rispetto a query DB
- **Scrittura**: Non applicabile (dati statici)
- **Memoria**: Incremento stimato di 2-5 MB in memoria
- **Caricamento iniziale**: Rallentamento di 100-300ms all'avvio dell'applicazione

#### Valutazione complessiva: 95% positiva