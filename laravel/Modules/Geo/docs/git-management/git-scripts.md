# Git Scripts

> **Nota**: Questo documento è correlato a [Git](../../docs/git.md). Per una panoramica completa, consulta entrambi i documenti.

# Script Git per la Gestione dei Subtree

Questi script sono utilizzati per automatizzare le operazioni Git nel progetto.

## Panoramica
Questa documentazione descrive gli script bash utilizzati per la gestione dei subtree git nel progetto Laraxot.

## Script Principali

### git_config_setup
Funzione centralizzata per la configurazione git, definita in `custom.sh`. Gestisce le seguenti impostazioni:
- `core.ignorecase`: false (case-sensitive)
- `core.fileMode`: false (ignora permessi)
- `core.autocrlf`: false (no conversione automatica line endings)
- `core.eol`: lf (line ending di default)
- `core.symlinks`: false (no symlinks per Windows)
- `core.longpaths`: true (supporto path lunghi Windows)

### git_pull_subtrees.sh
Script principale per il pull dei subtree. Funzionalità:
1. Configurazione git tramite `git_config_setup`
2. Backup opzionale su disco esterno
3. Gestione dei subtree definiti in gitmodules.ini
4. Supporto per organizzazioni GitHub personalizzate

### git_pull_subtree.sh
Script per il pull di un singolo subtree. Caratteristiche:

1. Sistema avanzato di logging con timestamp, colori ed emoji
2. Gestione errori robusta con fallback automatici
3. Supporto per branch personalizzati
4. Strategie multiple di pull con tentativi sequenziali:
   - Pull standard con squash
   - Pull senza squash
   - Split e merge con branch temporaneo
   - Backup e ripristino completo
5. Logging dettagliato in file di log

**Risoluzione conflitti applicata**:
- Integrato il miglior sistema di logging con timestamp e output colorato
- Migliorata la gestione degli errori con messaggi più descrittivi
- Ottimizzato il flusso di backup/ripristino per una maggiore robustezza
- Unificate le strategie di fallback in caso di errori
- Aggiunto logging su file per facilitare il debugging

**Uso**:
```bash
./bashscripts/git_pull_subtree.sh <path> <remote_repo>
```

**Parametri**:
- `<path>`: Il percorso del subtree locale
- `<remote_repo>`: L'URL del repository remoto

### git_push_subtrees.sh
Script per il push dei subtree. Funzionalità:
1. Push verso repository remoti
2. Supporto per organizzazioni multiple
3. Gestione errori e logging

### git_sync_subtree.sh
Script ottimizzato per la sincronizzazione di un singolo subtree. Caratteristiche principali:
1. Sistema avanzato di logging con timestamp e codici colore
2. Gestione robusta degli errori con fallback automatici
3. Strategia di sincronizzazione in più passaggi:
   - Pull del subtree con tentativo di squash
   - Merge con strategia subtree
   - Split e push forzato tramite branch temporaneo
   - Push di backup con metodo standard

**Risoluzione conflitti applicata**:
- Integrato il miglior sistema di logging dalla versione HEAD (con timestamp)
- Adottata la variabile REMOTE_BRANCH dalla versione incoming per maggiore flessibilità
- Implementata una strategia di gestione errori più robusta con fallback automatici
- Mantenuti i commenti emoji per maggiore leggibilità
- Aggiunto push standard come backup dopo il metodo split-push

Questo script è progettato per funzionare in tandem con `git_pull_subtree.sh` e `git_push_subtree.sh`, ma può essere utilizzato anche come soluzione standalone per casi complessi di sincronizzazione subtree.

### git_sync_subtrees.sh
Script completo per la sincronizzazione di tutti i subtree definiti in `gitmodules.ini`. Caratteristiche:
1. Sistema avanzato di logging con timestamp e output colorato
2. Preservazione delle modifiche locali durante la sincronizzazione
3. Meccanismi intelligenti di backup e recovery
4. Risoluzione automatica dei conflitti più comuni
5. Supporto per organizzazioni GitHub personalizzate

**Funzionalità avanzate:**
- Creazione automatica di backup branch prima di operazioni rischiose
- Gestione dello stash per preservare modifiche non committate
- Strategie progressive di fallback in caso di errori
- Meccanismo di merge cherry-pick per preservare modifiche locali
- History minima tramite fetch con depth per migliorare le performance

**Risoluzione conflitti applicata:**
- Integrato il sistema avanzato di preservazione delle modifiche locali
- Migliorato il sistema di logging con timestamp e colorazione
- Ottimizzato il meccanismo di utilizzo della memoria tramite depth limitato
- Implementata una gestione strutturata degli errori in ogni fase
- Aggiunto supporto per la lettura diretta da `gitmodules.ini` tramite l'utility `parse_gitmodules_ini.sh`

**Uso:**
```bash
./bashscripts/git_sync_subtrees.sh [org_personalizzata]
```

**Parametri:**
- `[org_personalizzata]`: (Opzionale) Permette di specificare un'organizzazione GitHub alternativa per tutti i repository

Per una documentazione più generale sugli script di gestione Git, consultare la [documentazione centrale](../../docs/bashscripts/gestione_git.md).

## Best Practices
1. Utilizzare sempre `git_config_setup` per la configurazione
2. Gestire i backup prima delle operazioni critiche
3. Verificare i log per eventuali errori
4. Mantenere aggiornato gitmodules.ini

## Risoluzione Problemi Comuni
1. Conflitti di merge: utilizzare gli script di backup prima di risolvere
2. Errori di path: verificare la configurazione Windows
3. Problemi di permessi: controllare fileMode e symlinks

## Script di sincronizzazione repository remoti

### sync_remote_repo.sh

Questo script sincronizza i repository remoti con i sottoprogetti locali definiti in un file `gitmodules.ini`.

**Percorso**: `bashscripts/subtrees/sync_remote_repo.sh`

**Utilizzo**:
```bash
./bashscripts/subtrees/sync_remote_repo.sh <org>
```

**Parametri**:
- `<org>`: L'organizzazione da usare per i remote repository

**Funzionalità**:
1. Carica librerie di supporto per operazioni personalizzate e parsing del file INI
2. Verifica che sia stato fornito il parametro dell'organizzazione
3. Per ogni sottoprogetto nel file gitmodules.ini:
   - Inizializza il repository Git se necessario
   - Configura il repository come directory sicura
   - Passa al branch specificato
   - Aggiunge il repository remoto dell'organizzazione specificata
   - Applica configurazioni Git
   - Fa commit delle modifiche locali
   - Esegue un `git pull` con autostash e rebase
   - Gestisce automaticamente i conflitti (accettando i cambiamenti locali)
   - Fa push dei cambiamenti al repository remoto

**Note sulla strategia di sincronizzazione**:
- Lo script utilizza `git pull --autostash --rebase` che:
  - Salva temporaneamente le modifiche non commitdate (--autostash)
  - Applica i commit remoti prima dei commit locali (--rebase)
  - Riscrive la storia locale in modo più lineare

Questa strategia è generalmente migliore per ridurre i conflitti rispetto all'uso di `git merge`, specialmente quando si lavora con sottoprogetti che vengono aggiornati frequentemente. Il rebase mantiene una storia più pulita e lineare.

[Torna alla documentazione principale](../../docs/maintenance.md#git-management) 
