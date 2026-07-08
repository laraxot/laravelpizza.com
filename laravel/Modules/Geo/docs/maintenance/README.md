# Script di Manutenzione

## Descrizione
Questa cartella contiene gli script per la manutenzione del sistema, inclusi:
- Pulizia della cache
- Ottimizzazione del database
- Aggiornamento delle dipendenze
- Manutenzione dei file

## Script Disponibili

### 1. clear_cache.sh
Gestisce la pulizia della cache con:
- Pulizia cache Laravel
- Pulizia cache view
- Pulizia cache route

### 2. optimize_database.sh
Ottimizza il database con:
- Analisi tabelle
- Ottimizzazione indici
- Pulizia dati non utilizzati

### 3. update_dependencies.sh
Gestisce gli aggiornamenti con:
- Aggiornamento Composer
- Aggiornamento npm
- Verifica compatibilità

### 4. Git Maintenance
Vedi [Git Scripts](../git/git_scripts.md) per:
- Sincronizzazione Subtrees (`sync_remote_repo.sh`)
- Backup e Restore
- Automazione CI/GitHub Actions

## Utilizzo

```bash

# Manutenzione completa
./clear_cache.sh
./optimize_database.sh
./update_dependencies.sh

# Manutenzione specifica
./clear_cache.sh --laravel-only
./optimize_database.sh --analyze-only
```

## Best Practices
- Eseguire backup prima della manutenzione
- Verificare l'impatto delle ottimizzazioni
- Monitorare le performance dopo gli aggiornamenti 
