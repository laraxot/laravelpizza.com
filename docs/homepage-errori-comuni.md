# Errori Comuni nell'Interpretazione dei Contenuti dell'Homepage

## Introduzione

Questo documento elenca e analizza gli errori più comuni che possono verificarsi nell'interpretazione e nell'implementazione dei contenuti dell'homepage di il progetto. L'obiettivo è prevenire confusioni e garantire che il portale comunichi in modo coerente e accurato con le utenti.

## Errore #1: Confondere le Fonti dei Contenuti

### Problema
Uno degli errori più comuni è cercare le specifiche dei contenuti dell'homepage nei documenti di progetto generali, invece di consultare il file dedicato `/var/www/html/<directory progetto>/project_docs/images/2.md` che contiene le specifiche esatte dell'interfaccia.

### Impatto
- Contenuti incoerenti rispetto al design approvato
- Messaggi non allineati con la comunicazione ufficiale del progetto
- Possibile omissione di elementi visivi chiave

### Soluzione
- Sempre riferirsi al file `docs/images/2.md` come fonte primaria per i contenuti dell'homepage
- Verificare che l'immagine di riferimento corrisponda alla versione più recente approvata

## Errore #2: Interpretazione Errata dei Requisiti

### Problema
Spesso vengono trasmessi requisiti imprecisi o incompleti sul target del progetto, come l'ISEE massimo o lo stato di residenza richiesti.

### Impatto
- Comunicazione di criteri di ammissibilità errati alle potenziali utenti
- Esclusione di beneficiarie che potrebbero essere idonee
- Inclusione di persone non idonee, con conseguente spreco di risorse

### Soluzione
- Utilizzare esattamente la formulazione: "donna in stato di gravidanza residente in Italia o in attesa di permesso di soggiorno, con un valore ISEE pari a euro 20,000 o inferiore"
- Non alterare numeri, cifre o criteri senza approvazione formale

## Errore #3: Modifiche al Call-to-Action

### Problema
Il testo e lo stile del pulsante CTA ("INIZIA ORA") vengono talvolta modificati per adattarsi a preferenze personali o stili diversi.

### Impatto
- Riduzione dell'efficacia della call-to-action
- Incoerenza tra materiali promozionali e portale
- Confusione nelle utenti sul percorso da seguire

### Soluzione
- Mantenere il testo esatto "INIZIA ORA" in maiuscolo
- Rispettare gli stili visivi (colore blu navy, bordi arrotondati) specificati nel design

## Errore #4: Omissione dei Loghi dei Partner

### Problema
I loghi dei partner (COI, INMP/NIHMP, Fondazione ANDI) vengono a volte omessi o posizionati in modo non prominente.

### Impatto
- Violazione degli accordi di partnership
- Riduzione della credibilità percepita del portale
- Mancato riconoscimento del contributo dei partner al progetto

### Soluzione
- Includere sempre tutti i loghi dei partner nel piè di pagina
- Assicurarsi che siano visibili e di dimensioni appropriate
- Verificare che i loghi siano aggiornati alle versioni ufficiali più recenti

## Errore #5: Confondere il Contenuto Tecnico con quello Visibile

### Problema
Spesso si confonde ciò che è contenuto nel file JSON di configurazione con ciò che effettivamente viene visualizzato all'utente finale.

### Impatto
- Discrepanze tra il contenuto configurato e quello visualizzato
- Difficoltà nel debugging di problemi di visualizzazione
- Confusione nella manutenzione dell'homepage

### Soluzione
- Verificare sempre la visualizzazione reale dell'homepage dopo le modifiche al file JSON
- Testare su dispositivi mobili e desktop
- Implementare un processo di revisione che confermi che il contenuto visualizzato corrisponda alle specifiche

## Errore #6: Ignorare l'Accessibilità

### Problema
Le considerazioni di accessibilità spesso vengono trascurate nella frenesia di implementare i contenuti.

### Impatto
- Esclusione di utenti con disabilità
- Riduzione dell'usabilità generale del portale
- Potenziali problemi legali relativi all'accessibilità

### Soluzione
- Mantenere alto contrasto tra testo e sfondo (testo bianco su sfondo blu navy)
- Assicurarsi che i testi siano di dimensioni adeguate
- Verificare che tutti gli elementi interattivi siano accessibili da tastiera

## Conclusione

L'accuratezza dei contenuti dell'homepage è fondamentale per la riuscita del progetto il progetto. Evitando questi errori comuni, possiamo garantire un'esperienza utente coerente e accessibile, rispettando al contempo gli accordi con i partner e comunicando correttamente i criteri di ammissibilità alle potenziali beneficiarie.

Questo documento dovrebbe essere consultato regolarmente dal team di sviluppo e di contenuti per assicurare l'aderenza alle specifiche ufficiali del progetto. 
