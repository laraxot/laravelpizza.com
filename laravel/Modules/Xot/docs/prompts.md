# Struttura dei prompt

## Scopo
I prompt definiscono regole operative riutilizzabili tra progetti. Devono essere portabili, coerenti e senza riferimenti al progetto specifico.

## Regole principali
- **Posizione**: `bashscripts/tools/prompts/`.
- **Formato**: Markdown consentito; se un prompt richiede una singola riga, dichiararlo esplicitamente nel file.
- **Portabilita'**: vietati percorsi assoluti e nomi di progetto; usare segnaposto (`<project_root>`, `<module>`, `<theme>`).
- **Coerenza**: allineare i prompt alle regole e alla documentazione dei moduli/temi.

## Processo di aggiornamento
1. Studiare la documentazione del modulo/tema coinvolto.
2. Aggiornare il prompt con esempi generici e path relativi.
3. Aggiornare le regole/memorie pertinenti se richiesto.
4. Verificare che i prompt restino project-agnostic.

## Collegamenti
<<<<<<< .merge_file_ooazFP
- [regole prompt consolidate](./consolidated/prompt-rules.md)
- [organizzazione bashscripts](./bashscripts-organization-1.md)
- [regole documentazione](./consolidated/documentation-rules.md)
- [prompts consolidati](./consolidated/prompts.md)
- [indice documentazione](./00-index.md)
=======
- [Documentazione Generale](./documentation.md)
- [Regole del Progetto](./rules.md)
- [Miglioramenti al Prompt docs.txt](./prompt_docs_improvements.md)

- [Miglioramenti al Prompt docs.txt](./prompt_docs_improvements.md)b6f667c (.)

- [Miglioramenti al Prompt docs.txt](./prompt_docs_improvements.md)b6f667c (.)

## Collegamenti tra versioni di prompts.md
* [prompts.md](docs/prompts.md)
* [prompts.md](../../../xot/project_docs/prompts.md)

## Modifiche al Prompt docs.txt

### Modifiche Proposte
- Rimozione delle sezioni non necessarie (es. API)
- Focalizzazione sulle regole effettivamente presenti nel codice
- Mantenimento della struttura a singola stringa continua
- Preservazione delle regole di organizzazione della documentazione

### Processo di Aggiornamento
1. Verifica delle regole esistenti nel codice
2. Documentazione delle modifiche in questo file
3. Aggiornamento del prompt in bashscripts/prompts/docs.txt
4. Verifica dei collegamenti bidirezionali

### Collegamenti Correlati
- [Regole Universali](./prompt_rules.md)
- [Gestione Documentazione](./documentation_management.md)
- [Struttura Moduli](./module-structure.md)

## Errori Comuni da Evitare

### Percorsi Assoluti
⚠️ **Problema Identificato**: Uso di percorsi assoluti nei collegamenti
❌ Esempio errato: `Modules/Xot/project_docs/file.md`
✅ Esempio corretto: `./file.md` o `../altro-modulo/file.md`

### Impatto dell'Errore
- Rende la documentazione non portabile
- Crea dipendenze dal nome del progetto
- Viola il principio di modularità
- Impedisce il riutilizzo del codice

### Prevenzione
1. **Verifica Preliminare**:
   - Controllare SEMPRE i percorsi prima di ogni commit
   - Usare strumenti di validazione markdown
   - Implementare pre-commit hooks

2. **Regole di Base**:
   - Mai usare percorsi che iniziano con `/`
   - Mai includere il nome del progetto
   - Mai riferirsi al workspace assoluto
   - Usare sempre `./ `o `../`

3. **Processo di Correzione**:
   - Identificare tutti i file con percorsi assoluti
   - Documentare l'errore nel modulo appropriato
   - Aggiornare le regole nei file di configurazione
   - Correggere i percorsi in modo coerente
   - Verificare i collegamenti bidirezionali

## Analisi del Prompt docs.txt

### Scopo del Prompt
Il prompt `docs.txt` serve come:
1. Guida per l'analisi della struttura modulare
2. Regole per la gestione della documentazione
3. Istruzioni per mantenere la coerenza tra moduli

### Punti di Forza Attuali
1. **Struttura Modulare**:
   - Chiara separazione delle responsabilità tra moduli
   - Documentazione specifica per ogni modulo
   - Collegamenti bidirezionali tra moduli

2. **Gestione Documentazione**:
   - Root come indice centrale
   - Moduli come contenitori specializzati
   - Xot come repository di documentazione generica

3. **Aggiornamento Regole**:
   - Aggiornamento `.cursor/rules/`
   - Aggiornamento `.cursor/memories/`
   - Aggiornamento `.windsurfrules`

### Aree di Miglioramento
1. **Validazione**:
   - Aggiungere strumenti di validazione automatica
   - Implementare pre-commit hooks
   - Verificare periodicamente i collegamenti

2. **Organizzazione**:
   - Migliorare la struttura delle cartelle docs
   - Standardizzare i nomi dei file
   - Mantenere una gerarchia coerente

3. **Automazione**:
   - Script per verificare collegamenti
   - Tool per validare la struttura
   - Sistemi di alert per documentazione obsoleta

### Proposta di Miglioramento
1. **Struttura Standard**:
   ```
   docs/
   ├── README.md           # Panoramica
   ├── ARCHITECTURE.md     # Architettura
   ├── GUIDELINES.md       # Linee guida
   └── sections/          # Sezioni specifiche
   ```

2. **Sistema di Tag**:
   ```markdown
   # Titolo Documento
   tags: #modulo-xot #categoria-architettura #tipo-linee-guida
   ```

3. **Collegamenti Standardizzati**:
   ```markdown
   [Documento](./path/relativo) #tag-correlati
   ```
>>>>>>> .merge_file_rJcEWm
