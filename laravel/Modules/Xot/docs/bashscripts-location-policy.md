# Policy Posizione Script Bash (VINCOLANTE)

## 🚫 Regola Assoluta

**TUTTI gli script `.sh` devono essere creati ESCLUSIVAMENTE in sottocartelle di `bashscripts/`, MAI nella root `laravel/`.**

## 📂 Struttura Corretta

```
/var/www/_bases/base_ptvx_fila4_mono/
├── laravel/                    # Codice applicativo (PHP/Laravel)
│   ├── Modules/
│   ├── composer.json
│   └── artisan
└── bashscripts/                # Automazione e tooling
    ├── fix/                    # Script di correzione (bug fix, cleanup)
    ├── deploy/                 # Script di deploy
    ├── backup/                 # Script di backup
    ├── maintenance/            # Script di manutenzione
    ├── test/                   # Script di test automation
    └── docs/                   # Script di generazione documentazione
```

## ✅ Esempi Corretti

```bash
# ✅ Script di cleanup duplicati case-sensitivity
bashscripts/fix/cleanup-case-duplicates.sh

# ✅ Script di deploy
bashscripts/deploy/deploy-production.sh

# ✅ Script di backup database
bashscripts/backup/backup-all-databases.sh

# ✅ Script PHPStan automation
bashscripts/test/run-phpstan-all-modules.sh
```

## ❌ Esempi Errati

```bash
# ❌ VIETATO - Script nella root Laravel
laravel/cleanup-case-duplicates.sh
laravel/fix-duplicates.sh
laravel/deploy.sh

# ❌ VIETATO - Script nella root modulo
laravel/Modules/Xot/fix-something.sh

# ❌ VIETATO - Script nella root progetto
/var/www/_bases/base_ptvx_fila4_mono/cleanup.sh
```

## 🧘 La Filosofia (WHY)

### 1. **Separazione delle Responsabilità (SRP)**
- `laravel/` = **SOLO** codice applicativo (PHP, config, routes, views)
- `bashscripts/` = **SOLO** automazione operativa (fix, deploy, maintenance)
- Ogni cartella ha **un singolo scopo chiaro**

### 2. **Organizzazione e Manutenibilità**
- **Facile trovare**: Tutti gli script in un unico posto organizzato per categoria
- **Facile capire**: Nome sottocartella indica lo scopo (fix, deploy, backup)
- **Facile manutenere**: Modifiche centralizzate, no script sparsi ovunque

### 3. **Portabilità e Deploy**
- **Laravel root pulito**: Pronto per deploy senza script temporanei
- **Esclusione facile**: `.gitignore` o rsync esclude `bashscripts/` se necessario
- **Chiara distinzione**: "Cosa va in production" vs "Cosa è tool di sviluppo"

### 4. **Convenzione Laraxot**
- **Struttura modulare pulita**: Ogni modulo PHP sta in `Modules/`, ogni script in `bashscripts/`
- **Prevedibilità**: Developer sa dove cercare script operativi
- **Scalabilità**: Aggiungere nuovi script non inquina la root Laravel

### 5. **ZEN del Codice**
- _"Un posto per ogni cosa, ogni cosa al suo posto"_
- _"Separare le preoccupazioni, unire le responsabilità correlate"_
- _"Il caos nasce dalla mescolanza, l'ordine dalla separazione"_

### 6. **Politica di Team**
- **Standard condiviso**: Tutti i developer seguono stessa convenzione
- **Code review semplice**: Facile verificare posizione corretta
- **Onboarding veloce**: Nuovi developer capiscono subito la struttura

### 7. **Religione Architetturale**
- **Laravel è sacro**: Non inquinarlo con script operativi
- **Separazione domini**: Applicazione vs automazione
- **Purezza strutturale**: Ogni livello ha il suo scopo

## 📋 Sottocartelle Standard

| Cartella | Scopo | Esempio |
|----------|-------|---------|
| `fix/` | Script correzione bug, cleanup, refactoring | `cleanup-case-duplicates.sh` |
| `deploy/` | Script deploy, release, versioning | `deploy-production.sh` |
| `backup/` | Script backup database, files | `backup-mysql-all.sh` |
| `maintenance/` | Script manutenzione, ottimizzazione | `clear-all-caches.sh` |
| `test/` | Script automation test, CI/CD | `run-all-tests.sh` |
| `docs/` | Script generazione documentazione | `generate-module-docs.sh` |

## 🔒 Enforcement

### Durante Development
```bash
# Verifica posizione corretta prima di creare script
# ❌ Se sei in laravel/ → SBAGLIATO
# ✅ Se sei in bashscripts/fix/ → CORRETTO
pwd
```

### Durante Code Review
- **Reject PR** con script `.sh` in `laravel/`
- **Richiedi spostamento** in sottocartella appropriata di `bashscripts/`

### Durante CI/CD
```bash
# Check automatico (opzionale)
if find laravel/ -maxdepth 1 -name "*.sh" | grep -q .; then
  echo "❌ ERROR: Script .sh trovati in laravel/ - devono stare in bashscripts/"
  exit 1
fi
```

## 🛠️ Migration Script Esistenti

Se trovi script in posizioni errate:

```bash
# 1. Identifica script mal posizionati
find laravel/ -name "*.sh" -type f

# 2. Sposta in sottocartella appropriata
mv laravel/fix-something.sh bashscripts/fix/fix-something.sh

# 3. Aggiorna riferimenti (se presenti in docs o altri script)
grep -r "fix-something.sh" bashscripts/ laravel/Modules/*/docs/

# 4. Commit
git add -A
git commit -m "refactor: move script to bashscripts/fix/ (location policy compliance)"
```

## 📚 Collegamenti

- [Laraxot Architecture](./architecture.md)
- [Project Structure Guidelines](./project-structure.md)
- [Deploy Best Practices](./deploy-best-practices.md)

---

**Ultimo aggiornamento**: Gennaio 2025  
**Motivazione**: Enforcement della separazione tra codice applicativo e script operativi  
**Filosofia**: "Separazione delle responsabilità, organizzazione scalabile, deploy pulito"


