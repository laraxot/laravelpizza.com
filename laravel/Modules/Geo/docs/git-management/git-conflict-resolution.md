# Risoluzione dei Conflitti Git

## Panoramica

Questo documento descrive gli strumenti e le procedure per la risoluzione dei conflitti git nel progetto.

## Collegamenti
- [Documentazione Git](../../docs/git.md)
- [Script Git](git_scripts.md)
- [Best Practices Git](git_best_practices.md)

## Script di Risoluzione

### resolve_conflicts.sh
Lo script principale per la risoluzione dei conflitti offre due modalità:

1. **Modalità Manuale** (default)
   ```bash
   ./bashscripts/utils/resolve_conflicts.sh
   ```
   - Rimuove i marker di conflitto
   - Mantiene il contenuto più recente
   - Crea backup dei file modificati

2. **Modalità AI** (richiede Ollama)
   ```bash
   ./bashscripts/utils/resolve_conflicts.sh --ai
   ```
   - Usa CodeLLama per analizzare e risolvere i conflitti
   - Ottimizza il codice durante la risoluzione
   - Fallback automatico alla modalità manuale in caso di errori

### Compatibilità
Per compatibilità con gli script esistenti, sono disponibili i seguenti link simbolici:
- `bashscripts/git/resolve_git_conflict.sh` → `../utils/resolve_conflicts.sh`

## Best Practices

### Prima della Risoluzione
1. Eseguire backup del repository
2. Verificare lo stato di git
3. Aggiornare il branch locale

### Durante la Risoluzione
1. Usare la modalità AI solo per conflitti complessi
2. Verificare i backup creati dallo script
3. Testare il codice dopo la risoluzione

### Dopo la Risoluzione
1. Eseguire i test automatizzati
2. Verificare la funzionalità
3. Committare le modifiche

## Casi d'Uso

### Conflitti Semplici
Per conflitti di formattazione o semplici:
```bash
./bashscripts/utils/resolve_conflicts.sh --no-ai
```

### Conflitti Complessi
Per conflitti che richiedono analisi del codice:
```bash
./bashscripts/utils/resolve_conflicts.sh --ai
```

## Risoluzione Manuale
Se gli script automatici non sono sufficienti:

1. Identificare i file con conflitti:
   ```bash
   git status
   ```

2. Per ogni file:
   - Aprire il file
   - Cercare i marker di conflitto
   - Scegliere la versione corretta
   - Rimuovere i marker

3. Testare le modifiche:
   ```bash
   ./vendor/bin/phpunit
   ```

## Prevenzione

### Strategie
1. Pull frequenti dal repository remoto
2. Commit atomici e descrittivi
3. Branch feature di breve durata

### Configurazione Git
```bash
git config merge.ff only
git config pull.rebase true
```

## Vedi Anche
- [Workflow Git](git_workflow.md)
- [Gestione Branch](git_branching.md)
- [Monitoraggio Conflitti](conflict_monitoring.md) 
