# Git Subtree Operations

## Perché

Gli script di gestione dei subtree sono stati creati per semplificare e standardizzare le operazioni di gestione dei repository Git con subtree. Questi script garantiscono:

- Gestione robusta degli errori
- Logging dettagliato delle operazioni
- Standardizzazione delle operazioni comuni
- Manutenzione automatica del repository

## Cosa

Gli script forniscono:

1. Pull di subtree con gestione degli errori
2. Push di subtree con strategie di fallback
3. Backup automatico dei dati
4. Logging strutturato delle operazioni
5. Pulizia e manutenzione del repository

## Implementazione

Gli script utilizzano:

- Funzioni di logging colorate per una migliore leggibilità
- Gestione robusta degli errori con messaggi descrittivi
- Backup automatico dei dati prima delle operazioni critiche
- Pulizia automatica dei file temporanei
- Librerie incorporate per la gestione delle dipendenze

### git_push_subtree.sh

Questo script specifico gestisce il push dei subtree con:

- Validazione degli input e dei prerequisiti
- Gestione delle dipendenze tramite `custom.sh`
- Strategie di fallback per il push
- Pulizia automatica dei file temporanei
- Gestione degli errori con rollback

## Sicurezza e Robustezza

- Validazione degli input
- Backup automatico dei dati
- Gestione degli errori con rollback
- Pulizia dei file temporanei
- Verifica delle dipendenze
- Utilizzo di librerie incorporate testate

## Sync monorepo (tutti i subtrees)

Nel monorepo, la sincronizzazione massiva dei repository configurati in `gitmodules.ini` avviene tramite:

```bash
./bashscripts/git/subtrees/sync_remote_repo.sh [ORG]
```

Note operative:

- Lo script risolve i path a partire dalla sua posizione, quindi può essere invocato da qualunque directory.
- Il backup (`backup_disk`) viene eseguito solo in modalità interattiva (stdin TTY), per evitare blocchi in CI.

Principio di sicurezza:

- Evitare chiamate a `git rebase --continue/--abort` se non è presente un rebase attivo (causa errori non deterministici).

## Collegamenti Correlati

- [Git Best Practices](../git_tips.txt)
- [Repository Management](../repositories.md)
- [Error Handling](../errors.txt)
- [Custom Library Documentation](../lib/custom.md)
