---
# 📝 Documentazione Script Git

> **Revisione manuale:** File rivisto per eliminare duplicazioni, conflitti e marker. Strutturato per massima chiarezza, con esempi pratici e riferimenti architetturali.

> **Backlink:** [README globale](./README.md) · [scripts_conflict_resolution.md](./scripts_conflict_resolution.md) · [GitHub Actions](./github-actions.md)

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
- **Dependencies**: See [Dependencies](dependencies.md) for required external scripts.
- **Workflow**: `sync-remote-repo.yml` (GitHub Actions)

### `sync_remote_repo.sh`
- Sincronizzazione automatizzata repository remoti
- Supporto CI/GitHub Actions (vedi [GitHub Actions](./github-actions.md))

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
- [GitHub Actions](./github-actions.md)

---

> Ogni modifica agli script va testata manualmente e tracciata nella documentazione. 














