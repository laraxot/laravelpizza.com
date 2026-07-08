# Sistema di Prompt per la Documentazione

## Panoramica

Il file `./prompts/docs.txt` è un componente cruciale del sistema di gestione della documentazione nei progetti che utilizzano l'architettura modulare Laravel. Questo prompt fornisce istruzioni strutturate e standardizzate per l'organizzazione, la manutenzione e l'aggiornamento della documentazione tecnica attraverso i moduli del progetto.

## Obiettivo

Il prompt è progettato per essere utilizzato con assistenti AI per garantire che:

1. La struttura della documentazione sia mantenuta in modo coerente
2. I collegamenti bidirezionali tra moduli siano preservati
3. La documentazione sia sempre aggiornata quando il codice viene modificato
4. Le best practices tecniche siano seguite costantemente
5. La documentazione sia organizzata logicamente in base alla competenza dei moduli

## Struttura del Prompt

Il prompt è organizzato in diverse sezioni tematiche, tutte contenute in un unico testo senza interruzioni di riga per ottimizzare l'uso con sistemi AI:

1. **Sistema di documentazione gerarchica**: Spiega la struttura generale con cartelle docs nei moduli e nella root
2. **Backlinks e collegamenti**: Definisce il formato preciso per i collegamenti bidirezionali
3. **Organizzazione per competenza**: Specifica quali tipi di documentazione vanno in quali moduli
4. **Best practices XotBaseResource**: Linee guida per evitare override non necessari
5. **Traduzioni e localizzazione**: Convenzioni per le chiavi di traduzione
6. **Componenti Filament**: Linee guida per l'uso corretto dei componenti UI
7. **Struttura Volt/Folio**: Regole per l'implementazione frontend
8. **Convenzioni tecniche specifiche**: Dettagli implementativi cruciali

## Miglioramenti Recenti

Il prompt è stato recentemente migliorato per:

1. **Rimuovere riferimenti specifici al progetto**: Reso generico per funzionare in qualsiasi progetto con questa architettura
2. **Chiarire i nomi dei metodi**: Correzione dei nomi dei metodi per riflettere accuratamente la struttura attuale del codice (es. `getActions()` invece di `Actions()`)
3. **Dettagliare i metodi XotBaseResource**: Elenco più completo dei metodi che non devono essere sovrascritti
4. **Aggiungere configurazioni vite.js**: Inclusi i parametri `emptyOutDir: false, manifest: 'manifest.json'`
5. **Migliorare le descrizioni dei moduli**: Descrivere con maggiore precisione le responsabilità di ogni modulo
6. **Specificare convenzioni di naming**: Aggiunta la convenzione esatta per le chiavi di traduzione (`modulo::risorsa.fields.campo.label`)

## Utilizzo

Questo prompt è pensato per essere utilizzato:

1. Come input per assistenti AI che lavorano sulla documentazione del progetto
2. Come riferimento per gli sviluppatori che necessitano di capire le convenzioni di documentazione
3. Come base per l'automazione della generazione e manutenzione della documentazione

## Manutenzione del Prompt

Ogni volta che il prompt viene modificato:

1. Gli aggiornamenti devono essere documentati in questo file
2. Le motivazioni delle modifiche devono essere spiegate
3. I collegamenti a esempi di documentazione che seguono il pattern devono essere aggiornati

## Collegamenti Correlati

- [Sistema di Prompt in Xot](../../laravel/Modules/Xot/docs/DOCUMENTATION_PROMPT_SYSTEM.md)
- [Linee Guida per la Documentazione di Xot](../../laravel/Modules/Xot/docs/DOCUMENTATION-GUIDELINES.md)
- [Percorsi Relativi nella Documentazione](./PERCORSI_RELATIVI_DOCUMENTAZIONE.md)
- [Regole per la Configurazione degli IDE](./REGOLE_IDE_CONFIGURAZIONE.md)
- [Convenzioni Generali per la Documentazione](../../docs/regole-documentazione.md)
- [Collegamenti della Documentazione](../../docs/collegamenti-documentazione.md)
