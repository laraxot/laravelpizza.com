# Script Push Subtree per Organizzazioni

## Panoramica

Lo script `git_push_subtree_org.sh` gestisce il push di sottocartelle verso repository remoti di organizzazioni. È stato progettato per essere flessibile e robusto, gestendo automaticamente i conflitti più comuni.

## Collegamenti
- [Documentazione Git Subtree](git-subtree-conflicts.md)
- [Script Git](git_scripts.md)
- [Risoluzione Conflitti](../../docs/risoluzione_conflitti_git.md)

## Funzionalità Principali

### Parametri
- `path`: Percorso locale della sottocartella
- `remote_repo`: URL del repository remoto
- `branch`: (Opzionale) Nome del branch, default "main"

### Configurazione
- Utilizza `git_config_setup` per una configurazione standardizzata
- Gestisce automaticamente i line endings e i path lunghi
- Supporta repository senza storia comune

### Gestione Conflitti
Lo script implementa una strategia robusta per la gestione dei conflitti:

1. Tenta prima un push diretto
2. Se fallisce, esegue un rebase
3. In caso di conflitti:
   - Tenta una risoluzione automatica
   - Se fallisce, annulla e riprova con un nuovo pull

## Decisioni Architetturali

### 1. Parametro Branch Opzionale
- **Decisione**: Reso opzionale il parametro branch con default "main"
- **Motivazione**: Maggiore flessibilità mantenendo compatibilità con script esistenti
- **Impatto**: Riduce la necessità di modificare gli script chiamanti

### 2. Gestione Errori Robusta
- **Decisione**: Implementato sistema di logging e gestione errori dettagliato
- **Motivazione**: Facilita il debug e il monitoraggio
- **Impatto**: Migliore tracciabilità dei problemi

### 3. Strategia di Risoluzione Conflitti
- **Decisione**: Implementato ciclo di tentativi con fallback
- **Motivazione**: Gestione automatica dei casi più comuni
- **Impatto**: Riduce la necessità di intervento manuale

## Best Practices

1. **Backup**
   ```bash
   # Eseguire sempre un backup prima di operazioni critiche
   ./backup_subtree.sh "$LOCAL_PATH"
   ```

2. **Logging**
   ```bash
   # Utilizzare sempre le funzioni di logging
   log "info" "Messaggio informativo"
   log "error" "Messaggio di errore"
   ```

3. **Gestione Errori**
   ```bash
   # Gestire sempre gli errori dei comandi git
   comando || handle_git_error "comando" "messaggio"
   ```

## Esempi di Utilizzo

### Push Base
```bash
./git_push_subtree_org.sh modules/auth https://github.com/org/auth
```

### Push con Branch Specifico
```bash
./git_push_subtree_org.sh modules/auth https://github.com/org/auth develop
```

## Risoluzione Problemi

### Conflitti di Merge
1. Verificare lo stato del repository locale
2. Controllare i log per errori specifici
3. Se necessario, eseguire un reset e riprovare

### Errori di Push
1. Verificare le credenziali git
2. Controllare i permessi sul repository remoto
3. Verificare la connessione di rete

## Manutenzione

### Aggiornamenti
- Verificare regolarmente gli aggiornamenti della documentazione
- Testare lo script con nuove versioni di git
- Mantenere aggiornate le dipendenze

### Test
- Eseguire test su repository di prova
- Verificare la gestione dei conflitti
- Testare con diverse configurazioni git

## Note di Sviluppo

### Versioning
- Mantenere la compatibilità con versioni precedenti
- Documentare i cambiamenti nelle API
- Seguire semantic versioning

### Contributi
- Seguire le linee guida del progetto
- Testare le modifiche
- Aggiornare la documentazione

## Vedi Anche
- [Documentazione Git](../../docs/git.md)
- [Script di Backup](backup_scripts.md)
- [Configurazione Git](git_config.md) 
