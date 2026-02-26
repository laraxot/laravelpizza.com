# Struttura dei Prompt

I prompt sono file di testo che contengono istruzioni per l'AI. Devono seguire queste regole:

1. **Regola Fondamentale**:
   - Per la regola universale sui prompt condivisi (come quelli in bashscripts/prompts), vedi [Regola prompt condivisi](./PROMPT_RULES.md)

2. **Contenuto**:
   - Devono essere chiari e concisi
   - Devono essere completi
   - Devono essere coerenti con la struttura del progetto
   - Devono essere aggiornati regolarmente

3. **Posizione**:
   - Devono essere nella cartella `bashscripts/prompts/`
   - Il nome del file deve essere descrittivo
   - L'estensione deve essere `.txt`


4. **Aggiornamenti**:
   Quando si modifica un prompt:
   - Aggiornare `.cursor/rules/` con le regole per Cursor AI
   - Aggiornare `.cursor/memories/` con le memories
   - Aggiornare `.windsurfrules` con le regole per Windsurf
   - Documentare le modifiche nel modulo appropriato
   - Mantenere i collegamenti bidirezionali

5. **Esempio**:
   ```text
   analizza l'intero contenuto della cartella Modules come un unico insieme coerente ogni modulo nella cartella Modules è indipendente con proprio composer.json da cui ricavare namespace autoload e struttura le classi da registrare si trovano nella rispettiva cartella app ma il namespace corretto è Modules<nome>\ e non Modules<nome>\app\ ogni modulo ha la propria cartella docs che contiene la documentazione tecnica approfondita quella è la tua memoria la cartella docs nella root del progetto non è documentazione ma un indice con collegamenti bidirezionali che ti guida a dove leggere studiare aggiornare e documentare correttamente la logica e le scelte di progetto inoltre può contenere la descrizione generale del progetto con roadmap epiche milestone stime politica filosofia zen e religione non ci devono essere documentazioni generali nella cartella docs della root la documentazione va organizzata per moduli secondo queste regole documentazione generica nella cartella docs del modulo Xot documentazione specifica del progetto nella cartella docs della root del progetto documentazione del frontend nella cartella docs del modulo Cms documentazione dei componenti UI nella cartella docs del modulo UI documentazione utenti e permessi nella cartella docs del modulo User documentazione pazienti nella cartella docs del modulo Patient documentazione dental nella cartella docs del modulo Dental documentazione multi-tenant nella cartella docs del modulo Tenant documentazione traduzioni nella cartella docs del modulo Lang documentazione media nella cartella docs del modulo Media documentazione notifiche nella cartella docs del modulo Notify documentazione report nella cartella docs del modulo Reporting documentazione gdpr nella cartella docs del modulo Gdpr documentazione jobs nella cartella docs del modulo Job documentazione grafici nella cartella docs del modulo Chart nella cartella docs della root del progetto ci devono essere solo i collegamenti bidirezionali alle documentazioni verso i moduli devi verificare sempre se le cartelle docs dei moduli hanno quello che ti serve e se sono ben collegate con collegamenti bidirezionali alla cartella docs della root e tra i moduli stessi la documentazione va riscritta in modo efficace ed essenziale concentrandosi sul perché e sul cosa evitando i dettagli implementativi se ti viene corretta una cosa devi sempre aggiornare prima la documentazione del modulo più adatto e poi aggiungere il collegamento nella root devi analizzare anche la documentazione presente nella cartella docs della root e valutare se alcuni documenti vanno spostati nella documentazione di un modulo più adeguato aggiornando poi i collegamenti bidirezionali coerentemente la documentazione generica va sempre collocata nella cartella docs del modulo Xot se trovi pezzi di documentazione generica all'interno della cartella docs della root questi vanno spostati nella cartella docs del modulo Xot e nella root devono essere lasciati solo i collegamenti bidirezionali ai documenti spostati le funzioni getListTableColumns getTableActions e getTableBulkActions devono restituire array con chiavi stringa se getTableActions restituisce solo ViewAction EditAction e DeleteAction va rimosso del tutto altrimenti deve includere ...parent::getTableActions() se getTableBulkActions restituisce solo DeleteBulkAction va rimosso altrimenti deve includere ...parent::getTableBulkActions() non usare mai ->label('') perché le label sono gestite solo tramite file di traduzione nei moduli con LangServiceProvider se una funzionalità chiama -><nome>($metatag->get<Nome>()) e manca il metodo get<Nome> allora documenta perché serve e poi implementalo coerentemente all'interno del modulo corretto se devi creare uno script shell devi usare la cartella bashscripts più vicina e non devi mai creare nuove cartelle bashscripts ma usare solo quelle già esistenti procedi nell'ordine che ritieni più efficace senza mai fermarti mantenendo coerenza architetturale e senza rompere funzionalità esistenti aggiornando sempre la documentazione locale e i collegamenti bidirezionali nella root e tra i moduli devi capire e documentare anche lo scopo specifico di ogni modulo per spostare la documentazione nel modulo giusto e poi creare/aggiornare i files coi collegamenti bidirezionali procedi sempre e scegli tu ordine e priorità senza interruzioni non usare mai percorsi assoluti nei collegamenti usa sempre percorsi relativi partendo dal livello corrente con ./ o salendo di livello con ../ non includere mai il percorso assoluto del workspace o il nome del progetto nei percorsi verifica sempre i percorsi prima di ogni commit usa strumenti di validazione markdown implementa pre-commit hooks identifica e correggi tutti i file con percorsi assoluti documenta gli errori nel modulo appropriato aggiorna le regole nei file di configurazione correggi i percorsi in modo coerente verifica i collegamenti bidirezionali quando modifichi qualcosa aggiorna sempre .cursor/rules/ con le regole per Cursor AI aggiorna .cursor/memories/ con le memories aggiorna .windsurfrules con le regole per Windsurf documenta le modifiche nel modulo appropriato mantieni i collegamenti bidirezionali
   ```

6. **Collegamenti**:4. **Esempio**:
   ```text
   analizza l'intero contenuto della cartella Modules come un unico insieme coerente ogni modulo nella cartella Modules è indipendente con proprio composer.json da cui ricavare namespace autoload e struttura le classi da registrare si trovano nella rispettiva cartella app ma il namespace corretto è Modules<nome>\ e non Modules<nome>\app\ ogni modulo ha la propria cartella docs che contiene la documentazione tecnica approfondita quella è la tua memoria la cartella docs nella root del progetto non è documentazione ma un indice con collegamenti bidirezionali che ti guida a dove leggere studiare aggiornare e documentare correttamente la logica e le scelte di progetto inoltre può contenere la descrizione generale del progetto con roadmap epiche milestone stime politica filosofia zen e religione non ci devono essere documentazioni generali nella cartella docs della root la documentazione va organizzata per moduli secondo queste regole documentazione generica nella cartella docs del modulo Xot documentazione specifica del progetto nella cartella docs della root del progetto documentazione del frontend nella cartella docs del modulo Cms documentazione dei componenti UI nella cartella docs del modulo UI documentazione utenti e permessi nella cartella docs del modulo User documentazione pazienti nella cartella docs del modulo Patient documentazione dental nella cartella docs del modulo Dental documentazione multi-tenant nella cartella docs del modulo Tenant documentazione traduzioni nella cartella docs del modulo Lang documentazione media nella cartella docs del modulo Media documentazione notifiche nella cartella docs del modulo Notify documentazione report nella cartella docs del modulo Reporting documentazione gdpr nella cartella docs del modulo Gdpr documentazione jobs nella cartella docs del modulo Job documentazione grafici nella cartella docs del modulo Chart nella cartella docs della root del progetto ci devono essere solo i collegamenti bidirezionali alle documentazioni verso i moduli devi verificare sempre se le cartelle docs dei moduli hanno quello che ti serve e se sono ben collegate con collegamenti bidirezionali alla cartella docs della root e tra i moduli stessi la documentazione va riscritta in modo efficace ed essenziale concentrandosi sul perché e sul cosa evitando i dettagli implementativi se ti viene corretta una cosa devi sempre aggiornare prima la documentazione del modulo più adatto e poi aggiungere il collegamento nella root devi analizzare anche la documentazione presente nella cartella docs della root e valutare se alcuni documenti vanno spostati nella documentazione di un modulo più adeguato aggiornando poi i collegamenti bidirezionali coerentemente la documentazione generica va sempre collocata nella cartella docs del modulo Xot se trovi pezzi di documentazione generica all'interno della cartella docs della root questi vanno spostati nella cartella docs del modulo Xot e nella root devono essere lasciati solo i collegamenti bidirezionali ai documenti spostati le funzioni getListTableColumns getTableActions e getTableBulkActions devono restituire array con chiavi stringa se getTableActions restituisce solo ViewAction EditAction e DeleteAction va rimosso del tutto altrimenti deve includere ...parent::getTableActions() se getTableBulkActions restituisce solo DeleteBulkAction va rimosso altrimenti deve includere ...parent::getTableBulkActions() non usare mai ->label('') perché le label sono gestite solo tramite file di traduzione nei moduli con LangServiceProvider se una funzionalità chiama -><nome>($metatag->get<Nome>()) e manca il metodo get<Nome> allora documenta perché serve e poi implementalo coerentemente all'interno del modulo corretto se devi creare uno script shell devi usare la cartella bashscripts più vicina e non devi mai creare nuove cartelle bashscripts ma usare solo quelle già esistenti procedi nell'ordine che ritieni più efficace senza mai fermarti mantenendo coerenza architetturale e senza rompere funzionalità esistenti aggiornando sempre la documentazione locale e i collegamenti bidirezionali nella root e tra i moduli devi capire e documentare anche lo scopo specifico di ogni modulo per spostare la documentazione nel modulo giusto e poi creare/aggiornare i files coi collegamenti bidirezionali procedi sempre e scegli tu ordine e priorità senza interruzioni non usare mai percorsi assoluti nei collegamenti usa sempre percorsi relativi partendo dal livello corrente con ./ o salendo di livello con ../ non includere mai il percorso assoluto del workspace o il nome del progetto nei percorsi verifica sempre i percorsi prima di ogni commit usa strumenti di validazione markdown implementa pre-commit hooks identifica e correggi tutti i file con percorsi assoluti documenta gli errori nel modulo appropriato aggiorna le regole nei file di configurazione correggi i percorsi in modo coerente verifica i collegamenti bidirezionali quando modifichi qualcosa aggiorna sempre .cursor/rules/ con le regole per Cursor AI aggiorna .cursor/memories/ con le memories aggiorna .windsurfrules con le regole per Windsurf documenta le modifiche nel modulo appropriato mantieni i collegamenti bidirezionali
   ```

6. **Collegamenti**:4. **Esempio**:
   ```text
   analizza l'intero contenuto della cartella Modules come un unico insieme coerente ogni modulo nella cartella Modules è indipendente con proprio composer.json da cui ricavare namespace autoload e struttura le classi da registrare si trovano nella rispettiva cartella app ma il namespace corretto è Modules<nome>\ e non Modules<nome>\app\ ogni modulo ha la propria cartella docs che contiene la documentazione tecnica approfondita quella è la tua memoria la cartella docs nella root del progetto non è documentazione ma un indice con collegamenti bidirezionali che ti guida a dove leggere studiare aggiornare e documentare correttamente la logica e le scelte di progetto inoltre può contenere la descrizione generale del progetto con roadmap epiche milestone stime politica filosofia zen e religione non ci devono essere documentazioni generali nella cartella docs della root la documentazione va organizzata per moduli secondo queste regole documentazione generica nella cartella docs del modulo Xot documentazione specifica del progetto nella cartella docs della root del progetto documentazione del frontend nella cartella docs del modulo Cms documentazione dei componenti UI nella cartella docs del modulo UI documentazione utenti e permessi nella cartella docs del modulo User documentazione pazienti nella cartella docs del modulo Patient documentazione dental nella cartella docs del modulo Dental documentazione multi-tenant nella cartella docs del modulo Tenant documentazione traduzioni nella cartella docs del modulo Lang documentazione media nella cartella docs del modulo Media documentazione notifiche nella cartella docs del modulo Notify documentazione report nella cartella docs del modulo Reporting documentazione gdpr nella cartella docs del modulo Gdpr documentazione jobs nella cartella docs del modulo Job documentazione grafici nella cartella docs del modulo Chart nella cartella docs della root del progetto ci devono essere solo i collegamenti bidirezionali alle documentazioni verso i moduli devi verificare sempre se le cartelle docs dei moduli hanno quello che ti serve e se sono ben collegate con collegamenti bidirezionali alla cartella docs della root e tra i moduli stessi la documentazione va riscritta in modo efficace ed essenziale concentrandosi sul perché e sul cosa evitando i dettagli implementativi se ti viene corretta una cosa devi sempre aggiornare prima la documentazione del modulo più adatto e poi aggiungere il collegamento nella root devi analizzare anche la documentazione presente nella cartella docs della root e valutare se alcuni documenti vanno spostati nella documentazione di un modulo più adeguato aggiornando poi i collegamenti bidirezionali coerentemente la documentazione generica va sempre collocata nella cartella docs del modulo Xot se trovi pezzi di documentazione generica all'interno della cartella docs della root questi vanno spostati nella cartella docs del modulo Xot e nella root devono essere lasciati solo i collegamenti bidirezionali ai documenti spostati le funzioni getListTableColumns getTableActions e getTableBulkActions devono restituire array con chiavi stringa se getTableActions restituisce solo ViewAction EditAction e DeleteAction va rimosso del tutto altrimenti deve includere ...parent::getTableActions() se getTableBulkActions restituisce solo DeleteBulkAction va rimosso altrimenti deve includere ...parent::getTableBulkActions() non usare mai ->label('') perché le label sono gestite solo tramite file di traduzione nei moduli con LangServiceProvider se una funzionalità chiama -><nome>($metatag->get<Nome>()) e manca il metodo get<Nome> allora documenta perché serve e poi implementalo coerentemente all'interno del modulo corretto se devi creare uno script shell devi usare la cartella bashscripts più vicina e non devi mai creare nuove cartelle bashscripts ma usare solo quelle già esistenti procedi nell'ordine che ritieni più efficace senza mai fermarti mantenendo coerenza architetturale e senza rompere funzionalità esistenti aggiornando sempre la documentazione locale e i collegamenti bidirezionali nella root e tra i moduli devi capire e documentare anche lo scopo specifico di ogni modulo per spostare la documentazione nel modulo giusto e poi creare/aggiornare i files coi collegamenti bidirezionali procedi sempre e scegli tu ordine e priorità senza interruzioni non usare mai percorsi assoluti nei collegamenti usa sempre percorsi relativi partendo dal livello corrente con ./ o salendo di livello con ../ non includere mai il percorso assoluto del workspace o il nome del progetto nei percorsi verifica sempre i percorsi prima di ogni commit usa strumenti di validazione markdown implementa pre-commit hooks identifica e correggi tutti i file con percorsi assoluti documenta gli errori nel modulo appropriato aggiorna le regole nei file di configurazione correggi i percorsi in modo coerente verifica i collegamenti bidirezionali quando modifichi qualcosa aggiorna sempre .cursor/rules/ con le regole per Cursor AI aggiorna .cursor/memories/ con le memories aggiorna .windsurfrules con le regole per Windsurf documenta le modifiche nel modulo appropriato mantieni i collegamenti bidirezionali
   ```

6. **Collegamenti**:
   - Questo documento deve essere collegato nella root `docs/` con un link bidirezionale
   - Gli altri moduli devono avere un link a questo documento
   - I prompt devono essere aggiornati quando cambiano le regole 

## Regole per i Prompt

Per la regola universale sui prompt condivisi (come quelli in bashscripts/prompts), vedi:

- [Regola Universale per i Prompt](./PROMPT_RULES.md)

## Collegamenti
- [Documentazione Generale](./documentation.md)
- [Regole del Progetto](./rules.md)
- [Miglioramenti al Prompt docs.txt](./prompt_docs_improvements.md)

- [Miglioramenti al Prompt docs.txt](./prompt_docs_improvements.md)b6f667c (.)


- [Miglioramenti al Prompt docs.txt](./prompt_docs_improvements.md)b6f667c (.)


## Collegamenti tra versioni di prompts.md
* [prompts.md](docs/prompts.md)
* [prompts.md](../../../Xot/project_docs/prompts.md)


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
- [Regole Universali](./PROMPT_RULES.md)
- [Gestione Documentazione](./DOCUMENTATION_MANAGEMENT.md)
- [Struttura Moduli](./module-structure.md)

## Errori Comuni da Evitare

### Percorsi Assoluti
⚠️ **Problema Identificato**: Uso di percorsi assoluti nei collegamenti
❌ Esempio errato: `/var/www/html/<nome progetto>/laravel/Modules/Xot/project_docs/file.md`
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
