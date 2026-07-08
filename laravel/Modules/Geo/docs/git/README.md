# Operazioni Git 🔄

Questa directory contiene gli script per la gestione avanzata delle operazioni Git, con particolare focus su subtrees, submodules e manutenzione del repository.

## 📁 Struttura

```
git/
├── subtrees/          # Gestione subtrees
├── submodules/        # Gestione submodules
└── maintenance/       # Manutenzione repository
```

## 🔧 Funzionalità Principali

### Gestione Subtrees
- Sincronizzazione automatica dei subtrees
- Aggiunta e rimozione subtrees
- Risoluzione conflitti
- Aggiornamento branch

### Gestione Submodules
- Inizializzazione submodules
- Aggiornamento submodules
- Sincronizzazione stato
- Gestione dipendenze

### Manutenzione Repository
- Pulizia repository
- Ottimizzazione performance
- Gestione branch
- Backup automatici

## 🚀 Utilizzo

### Prerequisiti
- Git 2.0+
- Bash 4.0+
- Accesso repository

### Comandi Comuni
```bash

# Sincronizzare subtrees
./subtrees/sync.sh

# Aggiornare submodules
./submodules/update.sh

# Manutenzione repository
./maintenance/cleanup.sh
```

## ⚠️ Note Importanti

1. **Backup**
   - Eseguire sempre backup prima di operazioni critiche
   - Verificare lo stato del repository
   - Controllare i log

2. **Conflitti**
   - Utilizzare gli script di risoluzione conflitti
   - Verificare le modifiche
   - Testare dopo la risoluzione

3. **Performance**
   - Ottimizzare dimensione repository
   - Gestire history
   - Monitorare tempi di esecuzione

## 📚 Documentazione Correlata

- [Guida Subtrees](subtrees/README.md)
- [Guida Submodules](submodules/README.md)
- [Guida Manutenzione](maintenance/README.md)

## 🤝 Contribuire

1. Fork del repository
2. Creazione branch feature (`git checkout -b feature/nome-feature`)
3. Commit modifiche (`git commit -am 'Aggiunta feature'`)
4. Push al branch (`git push origin feature/nome-feature`)
5. Creazione Pull Request

# Gestione Git

## File di Configurazione

### .gitignore-template
Template per la configurazione di `.gitignore` per i moduli Laravel. Contiene le regole standard per escludere file e directory non necessari nel repository.

### GITIGNORE-README.md
Documentazione dettagliata sulle regole di `.gitignore` e sulla loro gestione nei moduli.

### update-gitignore.sh
Script per aggiornare automaticamente i file `.gitignore` in tutti i moduli del progetto.

## Utilizzo

### Aggiornamento dei .gitignore
```bash
./update-gitignore.sh
```

Questo script:
1. Copia il template in tutti i moduli
2. Verifica la correttezza delle regole
3. Aggiorna i file esistenti

## Best Practices
- Mantenere il template aggiornato
- Verificare le regole prima dell'aggiornamento
- Documentare eventuali modifiche

## Note
Questi file sono utilizzati per mantenere la coerenza nella gestione dei file ignorati da Git in tutti i moduli del progetto.
