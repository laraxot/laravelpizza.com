# Regola Critica: Naming Convention per Cartelle Docs

## Regola Fondamentale

**NEI FILE E NELLE SOTTOCARTELLE DELLE CARTELLE DOCS NON DEVONO ESSERCI CARATTERI MAIUSCOLI, TRANNE PER README.md**

### ✅ CORRETTO
```
docs/
├── README.md (eccezione: può avere maiuscole)
├── translation-standards.md
├── filament-best-practices.md
├── naming-conventions.md
├── regole/
│   ├── traduzioni.md
│   ├── filament-resources.md
│   └── naming-convention.md
└── rules/
    ├── translation-keys.md
    ├── filament-components.md
    └── project-structure.md
```

### ❌ ERRATO
```
docs/
├── Translation_Standards.md (maiuscole nel nome)
├── Filament_Best_Practices.md (maiuscole nel nome)
├── Naming_Conventions.md (maiuscole nel nome)
├── Regole/ (maiuscola nella cartella)
└── Rules/ (maiuscola nella cartella)
```

## Motivazione

1. **Coerenza**: Mantenere una convenzione uniforme in tutto il progetto
2. **Compatibilità**: Evitare problemi con sistemi case-sensitive
3. **Manutenibilità**: Facilitare la ricerca e organizzazione dei file
4. **Standard**: Seguire le convenzioni Unix/Linux per i file

## Applicazione

### File
- ✅ `translation-standards.md`
- ✅ `filament-best-practices.md`
- ✅ `naming-conventions.md`
- ✅ `send-email-fix.md`
- ❌ `Translation_Standards.md`
- ❌ `Filament_Best_Practices.md`
- ❌ `Naming_Conventions.md`

### Cartelle
- ✅ `regole/`
- ✅ `rules/`
- ✅ `standards/`
- ✅ `conventions/`
- ❌ `Regole/`
- ❌ `Rules/`
- ❌ `Standards/`

### Eccezioni
- ✅ `README.md` - Può contenere maiuscole nel nome
- ✅ `index.md` - Nome standard per file indice

## Checklist di Controllo

Prima di considerare completa una cartella docs:

- [ ] Tutti i file hanno nomi in minuscolo
- [ ] Tutte le sottocartelle hanno nomi in minuscolo
- [ ] Solo README.md può avere maiuscole
- [ ] Uso di trattini (-) invece di underscore (_)
- [ ] Nomi descrittivi e chiari
- [ ] Nessun carattere speciale oltre a trattini

## Esempi di Conversione

### Prima (Errato)
```
docs/
├── Translation_Standards.md
├── Filament_Best_Practices.md
├── Naming_Conventions.md
├── Regole/
│   ├── Traduzioni.md
│   └── Filament_Resources.md
└── Rules/
    ├── Translation_Keys.md
    └── Project_Structure.md
```

### Dopo (Corretto)
```
docs/
├── translation-standards.md
├── filament-best-practices.md
├── naming-conventions.md
├── regole/
│   ├── traduzioni.md
│   └── filament-resources.md
└── rules/
    ├── translation-keys.md
    └── project-structure.md
```

## Comandi per Verificare

### Verifica Manuale
```bash

# Trova file con maiuscole nelle cartelle docs
find docs/ -name "*[A-Z]*" -type f | grep -v README.md

# Trova cartelle con maiuscole nelle cartelle docs
find docs/ -name "*[A-Z]*" -type d

# Verifica completa (docs + moduli)
find ./docs ./Modules/*/docs -name "*[A-Z]*" -type f | grep -v README.md
```

### Script Automatico
```bash

# Esegui script di correzione automatica
./bashscripts/fix_docs_naming_convention.sh
```

## Note Importanti

- **Sempre**: Usare trattini (-) invece di underscore (_)
- **Sempre**: Nomi descrittivi e chiari
- **Mai**: Caratteri maiuscoli nei nomi
- **Eccezione**: Solo README.md può avere maiuscole
- **Verifica**: Controllare sempre prima di creare nuovi file

---

**Questa regola è OBBLIGATORIA per tutte le cartelle docs del progetto.**

