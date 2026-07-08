# Contribuire al Progetto PTVX con Strumenti AI

## Linee Guida per i Contributori

### Prima di Iniziare
- Familiarizzare con i principi fondamentali del progetto PTVX
- Comprendere le regole critiche Laraxot
- Consultare la documentazione specifica per lo strumento AI che si intende utilizzare

### Processo di Contribuzione con AI

1. **Pianificazione**
   - Definire chiaramente gli obiettivi della modifica o implementazione
   - Identificare i moduli e componenti coinvolti
   - Considerare l'impatto sulle dipendenze esistenti

2. **Richiesta all'AI**
   - Fornire un contesto dettagliato sul progetto PTVX
   - Specificare chiaramente le regole Laraxot da rispettare
   - Richiedere codice che segua i pattern esistenti

3. **Validazione**
   - Verificare che il codice generato rispetti tutte le regole Laraxot
   - Controllare che non ci siano violazioni architetturali
   - Assicurarsi che le traduzioni siano gestite correttamente

4. **Testing**
   - Eseguire i test esistenti per verificare che non ci siano regressioni
   - Creare nuovi test se necessario
   - Verificare che PHPStan non segnali errori

## Esempi di Richieste AI Efficaci

### Per una nuova funzionalità
```
"Implementa una nuova risorsa Filament per gestire le entità MiaEntita nel modulo MioModulo.
Rispetta le regole Laraxot:
- Estendi XotBaseResource
- Non usare metodi hardcoded per le traduzioni
- Usa Actions per la logica di business
- Segui le convenzioni di denominazione del progetto
- Assicurati che tutte le relazioni con altri modelli siano corrette"
```

### Per la correzione di un bug
```
"Correggi questa pagina di modifica in modo che rispetti le regole Laraxot:
[Inserisci qui il codice esistente]
Il problema è che la pagina estende direttamente una classe Filament invece di usare la classe XotBase appropriata."
```

## Validazione del Codice Generato

Dopo aver ottenuto codice da uno strumento AI, è essenziale verificarne la qualità:

### Controllo Architetturale
- Le classi estendono le corrette XotBase?
- Le traduzioni sono gestite automaticamente?
- Le Actions sono usate al posto dei Services?

### Controllo Tecnico
- Il codice passa PHPStan senza errori?
- I test esistenti continuano a funzionare?
- Non ci sono nuovi problemi di sicurezza?

### Controllo di Qualità
- Il codice segue i principi DRY, KISS e SOLID?
- Le convenzioni di denominazione sono rispettate?
- I commenti sono presenti solo dove necessari?

## Errori Comuni da Evitare

### Con gli Strumenti AI
- Fidarsi ciecamente del codice generato senza verificarlo
- Non fornire contesto sufficiente quando si richiede assistenza
- Ignorare le regole architetturali specifiche del progetto

### Nella Valutazione del Codice
- Approvare codice che non rispetta i pattern Laraxot
- Trascurare i controlli di qualità automatici
- Non testare adeguatamente le modifiche

## Risorse per i Contributori

- [Guida per Claude](./.claude/docs/claude-ptvx-guide.md) - Specifiche per l'uso di Claude
- [Guida per Gemini](./.gemini/docs/gemini-ptvx-guide.md) - Specifiche per l'uso di Gemini
- [Guida per iFlow](./.iflow/docs/iflow-ptvx-guide.md) - Specifiche per l'uso di iFlow
- [Risoluzione Problemi](./troubleshooting-ai.md) - Come affrontare i problemi comuni
- [Best Practices](./best-practices.md) - Linee guida generali di sviluppo
- [Struttura del Progetto](./structure.md) - Organizzazione generale del codice

## Richieste di Modifica

Quando si sottomettono modifiche generate o assistite da AI:

1. Spiegare chiaramente lo scopo della modifica
2. Indicare quali regole Laraxot sono state rispettate
3. Fornire informazioni sul testing effettuato
4. Indicare eventuali impatti su altre parti del sistema