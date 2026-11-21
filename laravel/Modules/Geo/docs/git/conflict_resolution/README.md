---
title: "README"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "README"
issues: []
discussions: []
---

# Git Conflict Resolution Scripts

Questa cartella contiene script specializzati per la risoluzione automatica dei conflitti Git.

## Script Disponibili

### 🆕 resolve_conflicts_current_change.sh (V5.0) - **CONSIGLIATO**

Script principale ottimizzato per risolvere automaticamente tutti i conflitti Git scegliendo sempre la "current change" (il contenuto tra `=======` e `>>>>>>>`).

**Caratteristiche:**
- ✅ Risoluzione automatica intelligente
- ✅ Modalità dry-run per testing sicuro
- ✅ Gestione robusta dei file binari
- ✅ Backup automatici con timestamp
- ✅ Logging dettagliato con timestamp
- ✅ Verifica post-risoluzione
- ✅ Output colorato e user-friendly
- ✅ Gestione degli errori avanzata
- ✅ Esclusione automatica di vendor/, node_modules/, .git/
- ✅ Supporto per nomi file con spazi
- ✅ Contatori dettagliati e statistiche

**Utilizzo:**
```bash
# Test sicuro (SEMPRE consigliato come primo step)
./resolve_conflicts_current_change.sh --dry-run --verbose

# Esecuzione reale dopo aver verificato il dry-run
./resolve_conflicts_current_change.sh

# Con output dettagliato
./resolve_conflicts_current_change.sh --verbose

# Aiuto
./resolve_conflicts_current_change.sh --help
```

**Opzioni:**
- `--dry-run`: Simula l'esecuzione senza modificare i file
- `--verbose`: Output dettagliato durante l'esecuzione
- `--help`: Mostra l'aiuto

**Output:**
Lo script genera automaticamente:
- File di log in `bashscripts/logs/` con timestamp
- Backup dei file modificati in `bashscripts/backups/` con timestamp
- Riepilogo dettagliato con statistiche

### Script Legacy

#### auto_resolve_head_conflicts.sh
Script più vecchio con funzionalità di base per la risoluzione automatica.

#### resolve_head_conflicts_advanced.sh
Versione avanzata del vecchio script con più opzioni.

#### resolve_head_conflicts.sh
Script semplice per risoluzione basic.

## Best Practices

### 1. **SEMPRE usare dry-run prima**
```bash
./resolve_conflicts_current_change.sh --dry-run --verbose
```
Questo ti permette di vedere esattamente cosa farà lo script senza modificare nulla.

### 2. **Verifica i risultati**
Dopo l'esecuzione, controlla sempre:
- I file di log generati
- I backup creati
- Che non ci siano conflitti rimanenti

### 3. **Test il codice**
Dopo la risoluzione automatica:
- Esegui i test della tua applicazione
- Verifica che tutto funzioni come aspettato
- Controlla con `git status` e `git diff`

### 4. **Backup aggiuntivi**
Per progetti critici, considera un backup completo del repository prima dell'esecuzione.

## Quando NON usare questi script

- ❌ Conflitti complessi che richiedono merge manuale intelligente
- ❌ Quando la "current change" potrebbe non essere sempre la scelta corretta
- ❌ File di configurazione critica dove entrambe le versioni potrebbero essere necessarie
- ❌ Quando non sei sicuro di quale versione mantenere

## Troubleshooting

### Script non trova conflitti
```bash
# Verifica manualmente
find . -name "*.php" -o -name "*.md" | xargs grep -l "<<<<<<< "

# Oppure usa git
git status --porcelain | grep "^UU"
```

### Conflitti rimanenti dopo l'esecuzione
1. Controlla il file di log per errori specifici
2. Esegui di nuovo il dry-run per vedere cosa manca
3. Risolvi manualmente i conflitti rimanenti

### Problemi di permessi
```bash
# Rendi lo script eseguibile
chmod +x resolve_conflicts_current_change.sh

# Verifica i permessi dei file
ls -la
```

## Struttura dei File Generati

```
bashscripts/
├── logs/
│   └── resolve_conflicts_current_change_YYYYMMDD_HHMMSS.log
├── backups/
│   └── conflicts_current_change_YYYYMMDD_HHMMSS/
│       ├── file1.backup
│       ├── file2.backup
│       └── ...
└── git/
    └── conflict_resolution/
        └── resolve_conflicts_current_change.sh
```

## Supporto

Per problemi o miglioramenti, controlla:
1. I file di log generati automaticamente
2. La documentazione generale in `bashscripts/docs/`
3. Gli script legacy per confronti

## Collegamenti Utili

- [Documentazione Git Conflicts](../docs/git_conflicts_resolution.md)
- [Script Documentation](../docs/fix_all_git_conflicts.md)
- [Best Practices Git](../docs/git_scripts.md)