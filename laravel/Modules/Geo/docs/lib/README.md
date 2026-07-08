# Librerie Bash: Documentazione delle Funzioni

## Perché questa documentazione è importante

- **Singola fonte di verità**: Ogni funzione deve essere definita una sola volta
- **Prevenzione duplicazioni**: Evitare di riscrivere funzioni già esistenti
- **Manutenibilità**: Facilitare gli aggiornamenti e le correzioni
- **Onboarding**: Aiutare i nuovi sviluppatori a comprendere le funzionalità disponibili

## Funzioni disponibili in `custom.sh`

### Logging e Gestione Errori

| Funzione | Descrizione | Parametri |
|----------|-------------|-----------|
| `log()` | Registra messaggi nel log con timestamp e colori | `level` (error/success/warning/info), `message` |
| `handle_git_error()` | Gestisce errori nelle operazioni git | `operation`, `error_message`, `retry_count` (opzionale) |
| `handle_error()` | Gestisce errori generici e termina l'esecuzione | `error_message` |
| `die()` | Termina l'esecuzione con messaggio di errore | `message` |

### Manutenzione Git

| Funzione | Descrizione | Parametri |
|----------|-------------|-----------|
| `check_repository_integrity()` | Verifica l'integrità del repository git | - |
| `git_maintenance()` | Esegue operazioni di manutenzione sul repository | - |
| `git_config_setup()` | Configura le impostazioni git ottimali | - |
| `git_delete_history()` | Elimina la storia di un branch | `branch` |

### Utilità

| Funzione | Descrizione | Parametri |
|----------|-------------|-----------|
| `rewrite_url()` | Riscrive URL secondo regole specifiche | `original_url`, `org` |
| `backup_disk()` | Esegue backup su disco | - |

## Come utilizzare queste funzioni

```bash
#!/bin/bash
source ./bashscripts/lib/custom.sh

# Esempio di utilizzo
log "info" "Avvio operazione"
rewrite_url "https://github.com/example/repo.git" "nuova-org"

# Gestione errori
if ! git pull; then
    handle_git_error "git pull" "Impossibile eseguire pull"
fi

# Manutenzione
git_maintenance
```

## Principio DRY (Don't Repeat Yourself)

**IMPORTANTE**: Quando si utilizza `source ./bashscripts/lib/custom.sh`, NON ridefinire MAI le funzioni già presenti in questa libreria. Per maggiori dettagli, consultare la [documentazione sul principio DRY negli script Bash](/var/www/html/_bases/base_<nome progetto>_fila5_mono/bashscripts/docs/NO_DUPLICATE_FUNCTIONS_IN_SOURCED_SCRIPTS.md).

## Contribuire

Per aggiungere nuove funzioni:
1. Verificare che la funzione non esista già
2. Aggiungere la funzione a `custom.sh` con documentazione appropriata
3. Aggiornare questo README
4. Aggiornare i test se presenti

---

> Questo documento è parte della [Filosofia della Documentazione](/var/www/html/_bases/base_<nome progetto>_fila5_mono/docs/DOCUMENTATION_PHILOSOPHY.md) del progetto.
