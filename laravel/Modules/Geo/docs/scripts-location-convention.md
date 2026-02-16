# Convenzione Posizione Script

## Regola Fondamentale

**GLI SCRIPT NON DEVONO MAI ESSERE POSIZIONATI NELLE CARTELLE DOCS**

### ✅ Posizioni Corrette per Script

#### 1. Script di Utilità Generali
```
bashscripts/
├── fix_docs_naming_convention.sh
├── composer_init.sh
├── update.sh
└── altri_script.sh
```

#### 2. Script Specifici Modulo
```
Modules/NomeModulo/bashscripts/
├── composer_init.sh
├── update.sh
└── script_specifici.sh
```

#### 3. Script di Servizio
```
Modules/NomeModulo/app/Services/bashscripts/
├── service_script.sh
└── utility_script.sh
```

#### 4. Script Docker
```
docker/
├── mariadb/create-testing-database.sh
├── mysql/create-testing-database.sh
└── altri_script_docker.sh
```

### ❌ Posizioni Errate

```
docs/
├── check_docs_naming.sh  # ❌ ERRATO
├── fix_naming.sh         # ❌ ERRATO
└── utility_script.sh     # ❌ ERRATO
```

## Motivazione

1. **Separazione Responsabilità**: Le cartelle docs sono per documentazione, non per script
2. **Organizzazione**: Script raggruppati per tipo e funzione
3. **Manutenibilità**: Facile trovare e gestire gli script
4. **Convenzione**: Struttura standard del progetto

## Script Disponibili

### Script di Utilità Generali
- `bashscripts/fix_docs_naming_convention.sh` - Correzione convenzioni naming docs
- `bashscripts/composer_init.sh` - Inizializzazione composer
- `bashscripts/update.sh` - Aggiornamento sistema

### Script Modulo
- `Modules/*/bashscripts/composer_init.sh` - Inizializzazione composer per modulo
- `Modules/*/bashscripts/update.sh` - Aggiornamento modulo specifico

### Script Docker
- `docker/mariadb/create-testing-database.sh` - Database testing MariaDB
- `docker/mysql/create-testing-database.sh` - Database testing MySQL

## Convenzioni Naming Script

### ✅ CORRETTO
```bash

# Script di utilità
fix_docs_naming_convention.sh
composer_init.sh
update.sh

# Script specifici
create_testing_database.sh
fix_module_structure.sh
```

### ❌ ERRATO
```bash

# Nomi con maiuscole
FixDocsNaming.sh
ComposerInit.sh

# Nomi con underscore
fix_docs_naming.sh
composer_init.sh
```

## Esecuzione Script

### Script Generali
```bash

# Dalla root del progetto
./bashscripts/fix_docs_naming_convention.sh
./bashscripts/composer_init.sh
```

### Script Modulo
```bash

# Dalla root del progetto
./Modules/NomeModulo/bashscripts/composer_init.sh
./Modules/NomeModulo/bashscripts/update.sh
```

### Script Docker
```bash

# Dalla root del progetto
./docker/mariadb/create-testing-database.sh
./docker/mysql/create-testing-database.sh
```

## Verifica Posizione Script

```bash

# Trova tutti gli script nel progetto
find . -name "*.sh" -type f

# Trova script nelle cartelle docs (dovrebbero essere 0)
find ./docs ./Modules/*/docs -name "*.sh" -type f

# Trova script nelle posizioni corrette
find ./bashscripts ./Modules/*/bashscripts ./docker -name "*.sh" -type f
```

## Checklist Pre-commit

- [ ] Nessuno script nelle cartelle docs
- [ ] Script nelle posizioni appropriate
- [ ] Nomi script in minuscolo con trattini
- [ ] Script eseguibili (permessi +x)
- [ ] Documentazione script aggiornata

## Note Importanti

- **Mai**: Posizionare script nelle cartelle docs
- **Sempre**: Usare posizioni appropriate per tipo di script
- **Sempre**: Nomi script in minuscolo con trattini
- **Sempre**: Rendere script eseguibili
- **Sempre**: Documentare script importanti

---

**Questa convenzione è OBBLIGATORIA per tutti gli script del progetto.**

