# Git

> **Nota**: Questo documento è correlato a [Git Scripts](../bashscripts/docs/git_scripts.md). Per una panoramica completa, consulta entrambi i documenti.

Questo documento serve come indice per la documentazione Git del progetto.

## Guide Generali
Le guide complete per l'utilizzo di Git sono documentate in:
- [Workflow Git](../laravel/Modules/Xot/docs/git/workflow.md)
- [Gestione dei Conflitti](../bashscripts/docs/git_conflict_resolution.md)
- [Best Practices](../laravel/Modules/Xot/docs/git/best-practices.md)

## Guide Specifiche per Modulo

### Core
- [Xot Git Guidelines](../laravel/Modules/Xot/docs/git/README.md)
- [UI Git Guidelines](../laravel/Modules/UI/docs/git/README.md)
- [CMS Git Guidelines](../laravel/Modules/Cms/docs/git/README.md)

### Business Logic
- [Patient Module Git](../laravel/Modules/Patient/docs/git/README.md)
- [Dental Module Git](../laravel/Modules/Dental/docs/git/README.md)

## Risorse Correlate
- [CI/CD Pipeline](../laravel/Modules/Xot/docs/ci-cd/README.md)
- [Testing Workflow](../laravel/Modules/Xot/docs/testing/git-workflow.md)
- [Deployment Process](../laravel/Modules/Xot/docs/deployment/README.md)

## Strumenti di Gestione Git

### Script Principali
- [Risoluzione Conflitti](../bashscripts/docs/git_conflict_resolution.md)
- [Push Subtree](../bashscripts/docs/git_subtree_push_org.md)
- [Script Git](../bashscripts/docs/git_scripts.md)

### Funzionalità Chiave
- Risoluzione automatica dei conflitti con supporto AI
- Gestione subtree per moduli
- Sincronizzazione repository multipli

## Best Practices

### Gestione Conflitti
1. Utilizzare gli script forniti per la risoluzione automatica
2. Verificare sempre i backup prima delle modifiche
3. Testare il codice dopo la risoluzione

### Workflow Git
1. Pull frequenti dal repository principale
2. Commit atomici e descrittivi
3. Branch feature di breve durata

### Configurazione
```bash
git config merge.ff only
git config pull.rebase true
```

## Vedi Anche
- [Documentazione Moduli](modules.md)
- [Script di Backup](backup.md)
- [Configurazione Git](git_config.md) 
