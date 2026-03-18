# Standard di Documentazione dei Moduli

## Regola: Nessun Riferimento al Progetto Specifico

### Problema
Nei file di documentazione all'interno delle cartelle `docs` dei moduli **non deve mai apparire** il nome specifico del progetto .

### Motivazione
1. **Riutilizzabilità dei moduli**: I moduli sono progettati per essere riutilizzabili e potenzialmente distribuibili come pacchetti indipendenti. Riferimenti al progetto specifico limitano questa riutilizzabilità.

2. **Manutenibilità**: Se il nome del progetto dovesse cambiare, sarebbe necessario aggiornare tutti i riferimenti in tutti i file di documentazione.

3. **White-labeling**: I moduli potrebbero essere utilizzati in progetti white-label dove il nome del prodotto finale cambia in base al cliente.

4. **Separazione delle responsabilità**: La documentazione del modulo dovrebbe riguardare solo il modulo stesso e le sue funzionalità, non il progetto specifico in cui è attualmente utilizzato.

5. **Gestione del codice sorgente**: Facilita la gestione dei repository Git, in particolare quando si utilizzano tecniche come git subtree o submodule.

### Esempi

#### Non corretto ❌
```markdown

# Modulo Chart per il progetto

Questo modulo fornisce funzionalità di grafici per l'applicazione il progetto.

## Supporto
Per supporto e domande, contattare support@<nome progetto>.com
```

#### Corretto ✅
```markdown

# Modulo Chart

Questo modulo fornisce funzionalità avanzate per la creazione e gestione di grafici.

## Supporto
Per supporto e domande, contattare il team di sviluppo.
```

### Eccezioni
- File di configurazione specifici dell'ambiente (che non dovrebbero comunque essere versionati)
- File di deployment specifici del progetto (che dovrebbero essere in una cartella separata)

### Implementazione
1. Utilizzare termini generici come "l'applicazione", "il sistema", "il progetto"
2. Fare riferimento a ruoli anziché a team specifici
3. Utilizzare URL e indirizzi email generici o segnaposto nei documenti di esempio

## Collegamenti Bidirezionali
- [Standard di Documentazione Generale](../../Xot/project_docs/standards/documentation.md)
- [Convenzioni di Nomenclatura](../../Xot/project_docs/conventions/naming.md)
- [Struttura dei Moduli](../../Xot/project_docs/architecture/modules.md)
