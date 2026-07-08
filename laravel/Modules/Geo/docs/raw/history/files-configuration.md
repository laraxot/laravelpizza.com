# File di Configurazione

Questa documentazione descrive i file di configurazione utilizzati nel progetto.

## .gitignore

### Descrizione
Il file `.gitignore` specifica i file e le directory che Git dovrebbe ignorare durante le operazioni di commit e sincronizzazione.

### Posizione
```
bashscripts/.gitignore
```

### Struttura Organizzativa
Il file è organizzato in categorie logiche per facilitare la manutenzione:

1. **Sistema operativo**: File specifici del sistema operativo che non dovrebbero essere inclusi nel repository
   ```
   .fuse_hidden*
   .fuse_hidden**.lock
   **/*.Zone.Identifier
   *:Zone.Identifier
   ```

2. **File temporanei e cache**: File di cache e temporanei generati durante lo sviluppo
   ```
   *.cache
   .php-cs-fixer.cache
   .git-rewrite
   .git-blame-ignore-revs
   cache/
   docs/cache/
   ```

3. **Dipendenze e pacchetti**:
   - **Node.js**: Dipendenze JavaScript
     ```
     node_modules/
     /node_modules/
     package-lock.json
     ```
   - **Composer**: Dipendenze PHP
     ```
     vendor/
     *.lock
     *.phar
     ```

4. **Build e output**: Directory di build e output compilato
   ```
   build/
   ```

5. **Eseguibili**: File eseguibili che non dovrebbero essere versionati
   ```
   *.exe
   ```

### Risoluzione Conflitti Applicata
- Eliminati i pattern duplicati che comparivano più volte nel file
- Organizzato il contenuto in categorie logiche per migliorare la leggibilità
- Uniformato il formato delle esclusioni per mantenere la coerenza
- Aggiunta documentazione delle categorie per facilitare future modifiche

### Integrazione con il Workflow di Sviluppo
I pattern di esclusione definiti in questo file sono fondamentali per:
- Evitare di committare file temporanei o di sistema
- Mantenere il repository pulito e leggero
- Garantire che solo i file sorgente necessari vengano versionati
- Prevenire conflitti causati da file specifici dell'ambiente di sviluppo

Per aggiungere nuovi pattern di esclusione, si consiglia di:
1. Identificare chiaramente la categoria a cui appartiene il pattern
2. Aggiungere il pattern nella sezione appropriata
3. Documentare il cambiamento se introduce un nuovo tipo di esclusione

## Documentazione Correlata
- [Gestione dei Repository Git](/docs/bashscripts/gestione_git.md)
- [Conflitti di Merge](conflict-resolution-bash.md) 