---
# 📝 Documentazione Script Git

> **Revisione manuale:** File rivisto per eliminare duplicazioni, conflitti e marker. Strutturato per massima chiarezza, con esempi pratici e riferimenti architetturali.

> **Backlink:** [README globale](./README.md) · [scripts_conflict_resolution.md](./scripts_conflict_resolution.md)

---

## Obiettivo
Fornire una panoramica aggiornata e priva di conflitti sugli script bash per la gestione avanzata di Git e subtree nel progetto.

## Script principali

### `git_config_setup`
Funzione centralizzata (in `custom.sh`) per impostare:
- `core.ignorecase`, `core.fileMode`, `core.autocrlf`, `core.eol`, `core.symlinks`, `core.longpaths`

### `git_pull_subtrees.sh`
- Pull multiplo dei subtree
- Backup opzionale
- Gestione `gitmodules.ini` e organizzazioni custom

### `git_pull_subtree.sh`
- Pull di un singolo subtree
- Gestione errori e logging avanzato
- Supporto branch personalizzati

### `git_push_subtrees.sh`
- Push verso remoti multipli
- Logging e gestione errori

## Best Practice
- Usare sempre `git_config_setup`
- Eseguire backup prima di operazioni critiche
- Validare i log e aggiornare `gitmodules.ini`

## Risoluzione conflitti
- In caso di merge, usare script di backup e seguire la strategia documentata in [scripts_conflict_resolution.md](./scripts_conflict_resolution.md)

## Collegamenti
- [README globale](./README.md)
- [scripts_conflict_resolution.md](./scripts_conflict_resolution.md)
- [git_subtree_conflicts.md](./git_subtree_conflicts.md)

---

> Ogni modifica agli script va testata manualmente e tracciata nella documentazione.- `core.autocrlf`: false (no conversione automatica line endings)
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
1. Gestione errori robusta
2. Logging delle operazioni
3. Supporto per branch personalizzati

### git_push_subtrees.sh
Script per il push dei subtree. Funzionalità:
1. Push verso repository remoti
2. Supporto per organizzazioni multiple
3. Gestione errori e logging

## Best Practices
1. Utilizzare sempre `git_config_setup` per la configurazione
2. Gestire i backup prima delle operazioni critiche
3. Verificare i log per eventuali errori
4. Mantenere aggiornato gitmodules.ini

## Risoluzione Problemi Comuni
1. Conflitti di merge: utilizzare gli script di backup prima di risolvere
2. Errori di path: verificare la configurazione Windows
3. Problemi di permessi: controllare fileMode e symlinks

# Script Git

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
1. Gestione errori robusta
2. Logging delle operazioni
3. Supporto per branch personalizzati

### git_push_subtrees.sh
Script per il push dei subtree. Funzionalità:
1. Push verso repository remoti
2. Supporto per organizzazioni multiple
3. Gestione errori e logging

## Best Practices
1. Utilizzare sempre `git_config_setup` per la configurazione
2. Gestire i backup prima delle operazioni critiche
3. Verificare i log per eventuali errori
4. Mantenere aggiornato gitmodules.ini

## Risoluzione Problemi Comuni
1. Conflitti di merge: utilizzare gli script di backup prima di risolvere
2. Errori di path: verificare la configurazione Windows
3. Problemi di permessi: controllare fileMode e symlinks


[Torna alla documentazione principale](/docs/maintenance.md#git-management) 
[Torna alla documentazione principale](/docs/maintenance.md#git-management) 
[Torna alla documentazione principale](/docs/maintenance.md#git-management) 






# Script Git

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
1. Gestione errori robusta
2. Logging delle operazioni
3. Supporto per branch personalizzati

### git_push_subtrees.sh
Script per il push dei subtree. Funzionalità:
1. Push verso repository remoti
2. Supporto per organizzazioni multiple
3. Gestione errori e logging

## Best Practices
1. Utilizzare sempre `git_config_setup` per la configurazione
2. Gestire i backup prima delle operazioni critiche
3. Verificare i log per eventuali errori
4. Mantenere aggiornato gitmodules.ini

## Risoluzione Problemi Comuni
1. Conflitti di merge: utilizzare gli script di backup prima di risolvere
2. Errori di path: verificare la configurazione Windows
3. Problemi di permessi: controllare fileMode e symlinks

## Principi Applicati

### DRY (Don't Repeat Yourself)
- **Configurazione centralizzata**: `git_config_setup` unificato
- **Script riutilizzabili**: Funzioni comuni condivise
- **Logging standardizzato**: Formato unificato per tutti gli script

### KISS (Keep It Simple, Stupid)
- **Struttura lineare**: Script semplici e comprensibili
- **Configurazione minima**: Solo parametri essenziali
- **Output chiaro**: Log leggibili e informativi









## Collegamenti
[Torna alla documentazione principale](/docs/maintenance.md#git-management) 










## Collegamenti
[Torna alla documentazione principale](/docs/maintenance.md#git-management) 
