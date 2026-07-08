# Script di Risoluzione dei Conflitti

## Panoramica

Questo documento fornisce una guida completa agli script di automazione per la risoluzione dei conflitti git nel progetto Laraxot PTVX. Gli script descritti sono progettati per aiutare gli sviluppatori a identificare, analizzare e risolvere i conflitti di merge in modo efficiente.

## Script Disponibili

### 1. find_conflicts.sh

#### Descrizione
Identifica e elenca tutti i file con conflitti git non risolti nel repository.

#### Utilizzo
```bash
./bashscripts/git/find_conflicts.sh
```

#### Output
Un elenco di file che contengono marcatori di conflitto git.

#### Come Funziona
1. Utilizza `git grep` per cercare i marcatori  in tutti i file
2. Organizza i risultati per tipo di file (PHP, MD, JSON, ecc.)
3. Mostra un riepilogo della quantità di conflitti per tipo

### 2. resolve_conflicts.sh

#### Descrizione
Uno script interattivo che aiuta a risolvere i conflitti di merge proponendo varie strategie di risoluzione.

#### Utilizzo
```bash
./bashscripts/utils/resolve_conflicts.sh [percorso_file]
```

#### Funzionalità
1. Visualizza il contenuto del file con conflitti
2. Propone diverse strategie di risoluzione:
   - Mantenere la versione HEAD
   - Mantenere la versione incoming
   - Fusione manuale guidata
   - Aprire il file in un editor
3. Applica la strategia selezionata e rimuove i marcatori di conflitto
4. Crea backup dei file prima delle modifiche

### 3. fix_all_git_conflicts.sh

#### Descrizione
Script di risoluzione automatica che mantiene la versione HEAD per tutti i conflitti.

#### Utilizzo
```bash
./bashscripts/utils/fix_all_git_conflicts.sh
```

#### Funzionalità
1. Identifica tutti i file con conflitti
2. Crea backup dei file originali
3. Mantiene automaticamente la versione HEAD
4. Rimuove i marcatori di conflitto
5. Produce un report delle modifiche

#### Limitazioni
- Non adatto per conflitti complessi che richiedono fusione manuale
- Può perdere modifiche importanti dalla versione non-HEAD

### 4. check_namespaces.sh

#### Descrizione
Verifica e corregge i problemi comuni di namespace nei file PHP, che sono spesso causa di conflitti.

#### Utilizzo
```bash
./bashscripts/utils/check_namespaces.sh [directory]
```

#### Funzionalità
1. Cerca i namespace che includono incorrettamente il segmento 'app'
2. Suggerisce correzioni secondo le convenzioni del progetto
3. Può applicare automaticamente le correzioni se richiesto

### 5. conflict_analyzer.sh

#### Descrizione
Analizza i conflitti e fornisce statistiche e suggerimenti per la risoluzione.

### sync_to_disk.sh

Il file presenta un conflitto tra due approcci distinti:

1. **Versione avanzata**: Utilizza tar.gz con esclusioni dettagliate ed emoji per il feedback
2. **Versione semplice**: Utilizza rsync con un numero minore di esclusioni

## Strategia di Risoluzione

La strategia di risoluzione si basa sui seguenti principi:

1. **Comprensione del contesto**:
   - Identificare la funzionalità principale di ogni script
   - Comprendere le dipendenze e l'integrazione con il resto del sistema

2. **Selezione della versione ottimale**:
   - Privilegiare la versione più robusta e completa
   - Valutare la gestione degli errori e il logging
   - Verificare la coerenza con le convenzioni del progetto

3. **Integrazione di miglioramenti**:
   - Incorporare miglioramenti presenti nelle diverse versioni
   - Mantenere la retrocompatibilità

4. **Documentazione**:
   - Aggiornare la documentazione con le modifiche apportate
   - Creare collegamenti bidirezionali tra la documentazione del modulo e quella principale

## Implementazione della Soluzione

Per ogni script in conflitto, sarà implementata la seguente soluzione:

### fix_structure.sh

Mantenere la versione più avanzata con funzioni di logging colorate, migliorando:
- Gestione errori
- Compatibilità tra sistemi
- Documentazione interna

### git_pull_org.sh

Mantenere la versione con error handling più robusto e logging avanzato, incorporando:
- Migliori pratiche per il rebase
- Gestione automatica dei conflitti
- Ripristino sicuro in caso di errori

### git_push_subtree_org.sh

Mantenere la versione con l'implementazione più completa, assicurando:
- Corretta validazione dei parametri
- Gestione robusta degli errori
- Feedback chiaro durante l'esecuzione

### git_pull_subtree_org.sh

Integrazione dei due approcci per rendere il terzo parametro (branch) opzionale:
- Parametro branch viene reso opzionale con valore predefinito "main"
- Migliorata la validazione dei parametri
- Mantenuta compatibilità con entrambe le versioni

### git_sync_subtree.sh.old

Rimozione di tutti i conflitti e duplicazioni mantenendo la versione più recente:
- Eliminate tutte le duplicazioni dello script causate dai marker di conflitto nidificati
- Rimossi i messaggi di sistema relativi alla risoluzione automatica
- Mantenuto il core funzionale dello script

### sync_to_disk.sh

Mantenuta la versione più avanzata con tar.gz ed emoji:
- Conservata la versione con emoji e feedback visivo
- Mantenuta la gestione dettagliata delle esclusioni
- Ottimizzata l'opzione --warning=no-file-changed

## Verifiche Post-Risoluzione

Dopo la risoluzione dei conflitti, verranno eseguite le seguenti verifiche:

1. **Controllo sintassi**: Verifica della correttezza sintattica degli script
2. **Test di esecuzione**: Test di funzionamento in un ambiente controllato
3. **Verifica integrazione**: Controllo della corretta integrazione con il resto del sistema

## Collegamenti

- [Documentazione Generale sulla Risoluzione dei Conflitti](../../docs/bashscripts_conflict_resolution.md)
- [Linee Guida per la Scrittura di Script Bash](./git_scripts.md)
- [Principio DRY negli Script Bash](./NO_DUPLICATE_FUNCTIONS_IN_SOURCED_SCRIPTS.md)
- [Risoluzione dei Conflitti Bash](./CONFLICT_RESOLUTION_BASH.md)

## Risoluzioni recenti (Aprile 2025)

I seguenti file sono stati recentemente risolti:

- `git_pull_subtree_org.sh`: Integrati diversi approcci rendendo il parametro branch opzionale
- `git_sync_subtree.sh.old`: Eliminati conflitti nidificati mantenendo la versione funzionale
- `sync_to_disk.sh`: Mantenuta versione avanzata con migliore feedback e gestione esclusioni
- `fix_merge_conflicts.sh`: Corretta la logica di individuazione e rimozione dei marker di conflitto per garantire la pulizia completa di tutti i tre tipi di marker 

##<!-- REVISIONE MANUALE: File aggiornato per chiarezza architetturale e tracciabilità delle scelte. Vedi anche [README globale](/docs/README.md) e gli script citati in questa documentazione. -->

[Backlink: Documentazione Globale](/docs/README.md)
[Backlink: fix_all_git_conflicts.md](fix_all_git_conflicts.md)
[Backlink: git_conflicts_resolution.md](git_conflicts_resolution.md)


### fix_structure.sh

Mantenere la versione più avanzata con funzioni di logging colorate, migliorando:
- Gestione errori
- Compatibilità tra sistemi
- Documentazione interna

### git_pull_org.sh

Mantenere la versione con error handling più robusto e logging avanzato, incorporando:
- Migliori pratiche per il rebase
- Gestione automatica dei conflitti
- Ripristino sicuro in caso di errori

### git_push_subtree_org.sh

Mantenere la versione con l'implementazione più completa, assicurando:
- Corretta validazione dei parametri
- Gestione robusta degli errori
- Feedback chiaro durante l'esecuzione

### git_pull_subtree_org.sh

Integrazione dei due approcci per rendere il terzo parametro (branch) opzionale:
- Parametro branch viene reso opzionale con valore predefinito "main"
- Migliorata la validazione dei parametri
- Mantenuta compatibilità con entrambe le versioni

### git_sync_subtree.sh.old

Rimozione di tutti i conflitti e duplicazioni mantenendo la versione più recente:
- Eliminate tutte le duplicazioni dello script causate dai marker di conflitto nidificati
- Rimossi i messaggi di sistema relativi alla risoluzione automatica
- Mantenuto il core funzionale dello script

### sync_to_disk.sh

Mantenuta la versione più avanzata con tar.gz ed emoji:
- Conservata la versione con emoji e feedback visivo
- Mantenuta la gestione dettagliata delle esclusioni
- Ottimizzata l'opzione --warning=no-file-changed

## Verifiche Post-Risoluzione

Dopo la risoluzione dei conflitti, verranno eseguite le seguenti verifiche:

1. **Controllo sintassi**: Verifica della correttezza sintattica degli script
2. **Test di esecuzione**: Test di funzionamento in un ambiente controllato
3. **Verifica integrazione**: Controllo della corretta integrazione con il resto del sistema

## Collegamenti

- [Documentazione Generale sulla Risoluzione dei Conflitti](../../docs/bashscripts_conflict_resolution.md)
- [Linee Guida per la Scrittura di Script Bash](./git_scripts.md)
- [Principio DRY negli Script Bash](./NO_DUPLICATE_FUNCTIONS_IN_SOURCED_SCRIPTS.md)
- [Risoluzione dei Conflitti Bash](./CONFLICT_RESOLUTION_BASH.md)

## Risoluzioni recenti (Aprile 2025)

I seguenti file sono stati recentemente risolti:

- `git_pull_subtree_org.sh`: Integrati diversi approcci rendendo il parametro branch opzionale
- `git_sync_subtree.sh.old`: Eliminati conflitti nidificati mantenendo la versione funzionale
- `sync_to_disk.sh`: Mantenuta versione avanzata con migliore feedback e gestione esclusioni
- `fix_merge_conflicts.sh`: Corretta la logica di individuazione e rimozione dei marker di conflitto per garantire la pulizia completa di tutti i tre tipi di marker 

Questa documentazione è collegata bidirezionalmente con la [documentazione principale sulla risoluzione dei conflitti](../../docs/bashscripts_conflict_resolution.md) nella root del progetto. 


#### Utilizzo
```bash
./bashscripts/utils/conflict_analyzer.sh
```

#### Output
1. Statistiche sulla quantità e tipi di conflitti
2. Analisi dei file più frequentemente in conflitto
3. Suggerimenti su quali file dovrebbero essere risolti per primi
4. Identificazione dei conflitti più critici

## Metodologia di Risoluzione Guidata

### Fase 1: Identificazione
```bash


# Trova tutti i file con conflitti
./bashscripts/git/find_conflicts.sh
```

### Fase 2: Analisi
```bash


# Analizza i conflitti trovati
./bashscripts/utils/conflict_analyzer.sh
```

### Fase 3: Risoluzione Mirata
```bash


# Risolvi manualmente i conflitti più critici
./bashscripts/utils/resolve_conflicts.sh [file_critico]
```

### Fase 4: Risoluzione Automatica
```bash


# Risolvi automaticamente i conflitti rimanenti meno critici
./bashscripts/utils/fix_all_git_conflicts.sh
```

### Fase 5: Verifica
1. Eseguire PHPStan per verificare la compatibilità
2. Verificare il funzionamento del codice
3. Controllare la documentazione

## Best Practices per l'Utilizzo degli Script

1. **Analizzare Prima, Risolvere Dopo**: Utilizzare gli script di analisi prima di procedere con la risoluzione
2. **Backup Sistematici**: Assicurarsi di avere backup prima di applicare modifiche automatiche
3. **Risoluzione Manuale dei File Critici**: Risolvere manualmente i file più importanti o complessi
4. **Documentazione delle Decisioni**: Documentare le scelte fatte durante la risoluzione
5. **Verifica Post-Risoluzione**: Testare sempre il codice dopo la risoluzione

## Sviluppo e Manutenzione degli Script

### Contribuire agli Script
Gli script possono essere migliorati e personalizzati. Per contribuire:

1. Testare lo script in un ambiente sicuro
2. Documentare le modifiche proposte
3. Creare una pull request

### Regole di Naming
- Script di utilità: `utils/nome_script.sh`
- Script git: `git/nome_script.sh`
- Script di analisi: `analysis/nome_script.sh`

### Struttura Standard
```bash
#!/bin/bash

# =======================


# Nome dello script

# =======================

# Descrizione: Breve descrizione dello script

# Utilizzo: ./path/to/script.sh [argomenti]

# Autore: Nome dell'autore


# Nome dello script
# =======================
# Descrizione: Breve descrizione dello script
# Utilizzo: ./path/to/script.sh [argomenti]
# Autore: Nome dell'autore


# =======================

# Dichiarazione delle costanti e variabili

# Funzioni di utilità

# Funzione principale

# Esecuzione dello script
```

## Casi d'Uso Comuni

### 1. Risoluzione Post-Pull
Quando un `git pull` fallisce a causa di conflitti:
```bash
git pull origin main


# Conflitti rilevati
./bashscripts/utils/conflict_analyzer.sh
./bashscripts/utils/resolve_conflicts.sh [file_conflittuale]
```

### 2. Controllo Pre-Commit
Prima di eseguire un commit, verificare l'assenza di conflitti:
```bash
./bashscripts/git/find_conflicts.sh


# Se vengono trovati conflitti, risolverli
git add .
git commit -m "Messaggio del commit"
```

### 3. Pulizia del Repository
Per pulire un repository con molti conflitti non risolti:
```bash
./bashscripts/git/find_conflicts.sh
./bashscripts/utils/fix_all_git_conflicts.sh
```

## Troubleshooting

### Errori Comuni
1. **Script Non Eseguibile**: `chmod +x script.sh`
2. **Percorsi Errati**: Eseguire gli script dalla root del progetto
3. **Permessi Insufficienti**: Verificare i permessi di scrittura

### Risoluzione dei Problemi
1. Controllare i log generati dagli script
2. Utilizzare le opzioni di debug se disponibili
3. Consultare la documentazione specifica dello script

## Collegamenti Bidirezionali

- [Gestione dei Conflitti Git](/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/docs/git_conflicts_resolution.md)
- [Risoluzione Automatica dei Conflitti](/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/docs/fix_all_git_conflicts.md)
- [Conflitti nei File di Configurazione](/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/docs/config_file_conflicts.md)
- [Convenzioni di Namespace](/var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules/Xot/docs/NAMESPACE-CONVENTIONS.md)
- [Risoluzione Conflitti nei Moduli](/var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules/Xot/docs/conflitti_merge_risolti.md)


