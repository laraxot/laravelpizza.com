# Convenzione Naming README.md - Regola Fondamentale

## ⚠️ REGOLA CRITICA ⚠️

**TUTTI** i file README.md devono essere scritti in **MAIUSCOLO**:
- ✅ CORRETTO: `README.md`
- ❌ ERRATO: `readme.md`

## Motivazione

### Coerenza con Standard
- **GitHub**: Riconosce automaticamente i file `README.md` in maiuscolo
- **Git**: Convenzione standard per file di documentazione principale
- **Editor**: Visual Studio Code, Sublime Text, ecc. riconoscono automaticamente il file
- **Sistemi**: Cross-platform compatibility garantita

### Vantaggi Pratici
- **Visibilità**: File più facilmente identificabile
- **Navigazione**: Migliore esperienza utente
- **Standardizzazione**: Coerenza in tutto il progetto
- **Automazione**: Script e tool riconoscono automaticamente il file

## Procedura per Gestione Conflitti

Quando esistono sia `readme.md` che `README.md` nella stessa cartella:

### 1. Analisi Contenuti
```bash
# Confronta i contenuti dei due file
diff readme.md README.md
```

### 2. Decisione
- **Se identici**: Rimuovere `readme.md` (minuscolo)
- **Se diversi**: Assemblare i contenuti nel file `README.md` (maiuscolo)

### 3. Assemblaggio Contenuti
```bash
# Esempio di assemblaggio
# Mantieni il contenuto più completo e aggiornato
# Aggiungi informazioni mancanti se necessario
# Rimuovi duplicati
```

### 4. Pulizia
```bash
# Rimuovi il file minuscolo
rm readme.md

# Verifica che solo README.md esista
ls -la README.md
```

## Esempi di Correzione

### Caso 1: Contenuti Identici
```bash
# Rimuovere semplicemente il file minuscolo
rm readme.md
```

### Caso 2: Contenuti Diversi
```bash
# Assemblare i contenuti nel file maiuscolo
# Poi rimuovere il file minuscolo
rm readme.md
```

### Caso 3: Solo File Minuscolo
```bash
# Rinominare il file
mv readme.md README.md
```

## Comandi Utili

### Trova File Problematici
```bash
# Trova tutti i file readme.md in minuscolo
find . -name "readme.md" -type f

# Trova tutti i file README.md in maiuscolo
find . -name "README.md" -type f

# Trova conflitti (entrambi esistono)
find . -name "readme.md" -type f | while read file; do dir=$(dirname "$file"); if [ -f "$dir/README.md" ]; then echo "CONFLITTO: $file e $dir/README.md"; fi; done
```

### Correzione Automatica
```bash
# Script per rinominare tutti i file readme.md in README.md
find . -name "readme.md" -type f -exec bash -c 'mv "$1" "$(dirname "$1")/README.md"' _ {} \;
```

## Applicazione nel Progetto

### Moduli Laravel
- `laravel/Modules/*/docs/README.md`
- `laravel/Modules/*/docs/*/README.md`

### Documentazione Root
- `docs/README.md`
- `docs/*/README.md`

### Sottocartelle
- `docs/roadmap_frontoffice/README.md`
- `docs/bashscripts/README.md`

## Checklist di Verifica

- [ ] Verificare esistenza di file `readme.md` in minuscolo
- [ ] Confrontare contenuti con `README.md` se esistente
- [ ] Assemblare contenuti se necessario
- [ ] Mantenere solo `README.md` in maiuscolo
- [ ] Aggiornare riferimenti nei file correlati
- [ ] Documentare la correzione
- [ ] Verificare che tutti i link funzionino

## Best Practices

### 1. Controllo Pre-Commit
```bash
# Aggiungi questo script al pre-commit hook
find . -name "readme.md" -type f
if [ $? -eq 0 ]; then
    echo "ERRORE: Trovati file readme.md in minuscolo!"
    exit 1
fi
```

### 2. Documentazione
- Aggiornare sempre i link nei file correlati
- Documentare le modifiche nel changelog
- Mantenere coerenza in tutto il progetto

### 3. Team
- Condividere questa regola con tutto il team
- Includere nei documenti di onboarding
- Verificare periodicamente la compliance

## Collegamenti

- [Convenzioni Naming](convenzioni-naming-campi.md)
- [Struttura Documentazione](struttura-documentazione.md)
- [Best Practices](best-practices.md)

## Riferimenti

- [GitHub README Guidelines](https://docs.github.com/en/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/about-readmes)
- [Git Naming Conventions](https://git-scm.com/docs/gitignore)

*Ultimo aggiornamento: 2025-01-27* 