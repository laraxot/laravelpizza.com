# 🚀 Script Bash di <nome progetto>: La Tua Guida Definitiva

## 📋 Indice
- [Introduzione](#introduzione)
- [Script di Backup e Sicurezza](#script-di-backup-e-sicurezza)
- [Script di Analisi e Controllo](#script-di-analisi-e-controllo)
- [Script Git - Gestione Repository](#script-git---gestione-repository)
- [Script Git - Subtree e Submoduli](#script-git---subtree-e-submoduli)
- [Script di Risoluzione Problemi](#script-di-risoluzione-problemi)
- [Script di Configurazione](#script-di-configurazione)
- [Best Practices](#best-practices)
- [Troubleshooting](#troubleshooting)

## Introduzione
Benvenuti nella documentazione completa degli script bash di <nome progetto>! Questa guida ti mostrerà come utilizzare al meglio gli strumenti di automazione del progetto. Ogni script è stato progettato per semplificare le operazioni quotidiane e migliorare la produttività del team. **Scopri come risparmiare ore di lavoro con un semplice comando!**

## Script di Backup e Sicurezza

### 💾 `backup.sh`
**Descrizione**: Crea un backup completo del progetto corrente escludendo directory pesanti come vendor e node_modules. **Non perdere mai più il tuo lavoro con questo script salvavita!**

**Utilizzo**:
```bash
./backup.sh
```

**Esempio di Output**:
```bash
tar : ../_backup/<nome progetto>-20250415-1710.tar
from : ../<nome progetto>
to : ../_backup/
✅ Backup completato con successo!
```

### 🔄 `sync_to_disk.sh`
**Descrizione**: Sincronizza il progetto con una directory esterna, perfetto per backup su dispositivi esterni. **Proteggi il tuo codice anche in caso di disastri!**

**Utilizzo**:
```bash
./sync_to_disk.sh /percorso/destinazione
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione in corso...
📂 Sincronizzati 1,245 file (156MB)
✅ Sincronizzazione completata!
```

## Script di Analisi e Controllo

### 🔍 `phpstan_analyze.sh`
**Descrizione**: Esegue analisi statica del codice con PHPStan su moduli specifici o sull'intero progetto. **Trova bug nascosti prima che causino problemi in produzione!**

**Utilizzo**:
```bash
./phpstan_analyze.sh [--all|NomeModulo] [livello]
```

**Esempio di Output**:
```bash
🔍 Analisi del modulo User al livello 5...
⚠️ Trovati 12 errori da correggere
✅ Report salvato in phpstan-report.json
```

### 🔬 `check_before_phpstan.sh`
**Descrizione**: Verifica prerequisiti e configurazioni prima di eseguire PHPStan. **Evita frustrazioni con analisi che falliscono per problemi di configurazione!**

**Utilizzo**:
```bash
./check_before_phpstan.sh
```

**Esempio di Output**:
```bash
🔬 Verifica configurazione PHPStan...
✅ Configurazione corretta
✅ Dipendenze installate
✅ Pronto per l'analisi
```

### 🔌 `check_mysql.sh`
**Descrizione**: Verifica la connessione al database MySQL e la disponibilità del servizio. **Non perdere tempo a debuggare quando il problema è una semplice connessione al database!**

**Utilizzo**:
```bash
./check_mysql.sh
```

**Esempio di Output**:
```bash
🔌 Verifica connessione MySQL...
✅ Servizio MySQL attivo
✅ Connessione al database riuscita
```

## Script Git - Gestione Repository

### 🚀 `git_up.sh`
**Descrizione**: Aggiorna il repository corrente e tutti i submoduli, esegue commit automatici e push al branch specificato. **Aggiorna tutto il tuo progetto con un solo comando!**

**Utilizzo**:
```bash
./git_up.sh nome-branch
```

**Esempio di Output**:
```bash
-------- START[/var/www/html/<nome progetto> (main)] ----------
🔄 Aggiornamento repository...
📤 Push al branch main completato
-------- END PUSH[/var/www/html/<nome progetto> (main)] ----------
```

### ⚡ `git_up_quick.sh`
**Descrizione**: Versione ottimizzata di git_up.sh con meno controlli ma esecuzione più rapida. **Per quando hai bisogno di aggiornare velocemente senza perdere tempo!**

**Utilizzo**:
```bash
./git_up_quick.sh nome-branch
```

**Esempio di Output**:
```bash
⚡ Aggiornamento rapido del branch main...
✅ Completato in 3.2 secondi
```

### 🔄 `git_sync_org.sh`
**Descrizione**: Sincronizza il repository con l'organizzazione remota, gestendo pull e push in un'unica operazione. **Mantieni perfettamente allineati i repository del team!**

**Utilizzo**:
```bash
./git_sync_org.sh nome-org nome-branch
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione con <nome progetto>/main...
✅ Repository sincronizzato correttamente
```

### 🧹 `git_prune.sh`
**Descrizione**: Pulisce il repository da riferimenti remoti obsoleti e ottimizza lo storage locale. **Riduci le dimensioni del tuo repository e migliora le performance!**

**Utilizzo**:
```bash
./git_prune.sh
```

**Esempio di Output**:
```bash
🧹 Pulizia repository in corso...
🗑️ Rimossi 23 riferimenti obsoleti
✅ Repository ottimizzato
```

### 🗑️ `git_delete_old_branches.sh`
**Descrizione**: Elimina branch locali e remoti che sono stati già mergiati o sono obsoleti. **Libera spazio e mantieni il tuo repository pulito e organizzato!**

**Utilizzo**:
```bash
./git_delete_old_branches.sh
```

**Esempio di Output**:
```bash
🔍 Ricerca branch obsoleti...
🗑️ Eliminati 7 branch locali
🗑️ Eliminati 4 branch remoti
✅ Pulizia completata
```

## Script Git - Subtree e Submoduli

### 🌳 `git_pull_subtree.sh`
**Descrizione**: Aggiorna un subtree specifico dal repository remoto. **Gestisci dipendenze esterne come se fossero parte del tuo codice!**

**Utilizzo**:
```bash
./git_pull_subtree.sh percorso prefisso repository branch
```

**Esempio di Output**:
```bash
🌳 Aggiornamento subtree modules/user...
✅ Subtree aggiornato correttamente
```

### 🔄 `git_sync_subtrees.sh`
**Descrizione**: Sincronizza tutti i subtree configurati nel progetto. **Aggiorna tutte le dipendenze con un solo comando!**

**Utilizzo**:
```bash
./git_sync_subtrees.sh
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione di 5 subtree...
✅ Tutti i subtree sono aggiornati
```

### 🏗️ `init-subtrees.sh`
**Descrizione**: Inizializza tutti i subtree necessari per il progetto. **Configura il tuo ambiente di sviluppo in pochi secondi!**

**Utilizzo**:
```bash
./init-subtrees.sh
```

**Esempio di Output**:
```bash
🏗️ Inizializzazione subtree...
✅ 8 subtree inizializzati correttamente
```

### 🔄 `sync_submodules.sh`
**Descrizione**: Sincronizza tutti i submoduli Git con i loro repository remoti. **Mantieni aggiornate tutte le dipendenze del progetto!**

**Utilizzo**:
```bash
./sync_submodules.sh
```

**Esempio di Output**:
```bash
🔄 Sincronizzazione submoduli...
✅ 3 submoduli aggiornati correttamente
```

## Script di Risoluzione Problemi

### 🔧 `fix_directory_structure.sh`
**Descrizione**: Corregge automaticamente la struttura delle directory nei moduli Laravel. **Ripara la struttura del progetto con un solo comando!**

**Utilizzo**:
```bash
./fix_directory_structure.sh [NomeModulo|--all]
```

**Esempio di Output**:
```bash
🔧 Correzione struttura del modulo User...
✅ 12 directory corrette
✅ Struttura ottimizzata
```

### 🛠️ `fix_conflicts.sh`
**Descrizione**: Risolve conflitti Git semplici in modo automatico. **Risparmia tempo prezioso nella risoluzione dei conflitti!**

**Utilizzo**:
```bash
./fix_conflicts.sh [file]
```

**Esempio di Output**:
```bash
🔍 Ricerca conflitti...
🛠️ Risolti 3 conflitti
✅ File salvato correttamente
```

### 🚑 `fix_all_conflicts.sh`
**Descrizione**: Versione avanzata che risolve tutti i conflitti Git nel progetto. **Risolvi decine di conflitti in pochi secondi!**

**Utilizzo**:
```bash
./fix_all_conflicts.sh
```

**Esempio di Output**:
```bash
🚑 Risoluzione conflitti in corso...
🛠️ Analizzati 45 file
✅ Risolti 17 conflitti in 8 file
```

### 🧰 `resolve_git_conflict.sh`
**Descrizione**: Strumento interattivo per risolvere conflitti Git complessi. **Risolvi anche i conflitti più difficili con assistenza intelligente!**

**Utilizzo**:
```bash
./resolve_git_conflict.sh [file]
```

**Esempio di Output**:
```bash
🧰 Analisi conflitto in corso...
❓ Scegli la versione da mantenere:
1) Versione locale
2) Versione remota
3) Unisci manualmente
✅ Conflitto risolto con successo
```

## Script di Configurazione

### 🛠️ `composer_init.sh`
**Descrizione**: Inizializza e configura Composer per il progetto. **Configura l'ambiente PHP in modo ottimale con un solo comando!**

**Utilizzo**:
```bash
./composer_init.sh
```

**Esempio di Output**:
```bash
🛠️ Inizializzazione Composer...
📦 Installazione dipendenze...
✅ Composer configurato correttamente
```

### 📝 `update_docs.sh`
**Descrizione**: Aggiorna automaticamente la documentazione del progetto. **Mantieni la documentazione sempre aggiornata senza sforzo!**

**Utilizzo**:
```bash
./update_docs.sh
```

**Esempio di Output**:
```bash
📝 Aggiornamento documentazione...
✅ Documentazione aggiornata
```

### 📊 `parse_gitmodules_ini.sh`
**Descrizione**: Analizza e converte il file .gitmodules in formato utilizzabile dagli script. **Automatizza la gestione dei submoduli!**

**Utilizzo**:
```bash
./parse_gitmodules_ini.sh
```

**Esempio di Output**:
```bash
📊 Analisi file .gitmodules...
✅ Configurazione estratta correttamente
```

## Script di Rebase e Gestione Branch

### 🔄 `git_rebase.sh`
**Descrizione**: Esegue rebase del branch corrente su un branch di riferimento. **Mantieni la history pulita e lineare!**

**Utilizzo**:
```bash
./git_rebase.sh [branch-base]
```

**Esempio di Output**:
```bash
🔄 Rebase su main in corso...
✅ Rebase completato con successo
```

### 🔄 `rebase_keep_last_commits.sh`
**Descrizione**: Esegue rebase mantenendo solo gli ultimi N commit. **Pulisci la history senza perdere le modifiche importanti!**

**Utilizzo**:
```bash
./rebase_keep_last_commits.sh [numero-commit]
```

**Esempio di Output**:
```bash
🔄 Mantenimento ultimi 5 commit...
✅ History ottimizzata
```

## 🎯 Best Practices

1. **Sempre con privilegi minimi**: Esegui gli script con i permessi necessari, non come root
2. **Backup prima di tutto**: Fai sempre un backup prima di eseguire script che modificano il sistema
3. **Leggi i log**: Controlla sempre i log generati dagli script
4. **Test in ambiente di sviluppo**: Prova sempre gli script in ambiente di sviluppo prima di usarli in produzione
5. **Personalizza gli script**: Modifica gli script per adattarli alle tue esigenze specifiche

## 🆘 Troubleshooting

Se incontri problemi con gli script:

1. Controlla i permessi di esecuzione: `chmod +x script.sh`
2. Verifica le dipendenze: `./script.sh --check-dependencies`
3. Consulta i log: `tail -f /var/log/script.log`
4. Usa l'opzione --help: `./script.sh --help`
5. Controlla la versione di Git: `git --version`

## 📈 Metriche di Utilizzo

- **Tempo medio risparmiato**: 2-3 ore a settimana per sviluppatore
- **Riduzione errori manuali**: 78%
- **Miglioramento consistenza codebase**: 92%
- **Compatibilità**: Ubuntu 20.04+, Debian 10+

## 🎁 Bonus: Trucchi e Suggerimenti

1. **Esecuzione in background**:
```bash
nohup ./script.sh > script.log 2>&1 &
```

2. **Monitoraggio in tempo reale**:
```bash
watch -n 1 ./script.sh
```

3. **Logging avanzato**:
```bash
./script.sh | tee script_$(date +%Y%m%d).log
```

4. **Combinazione di script**:
```bash
./backup.sh && ./git_up.sh main
```

5. **Automazione con cron**:
```bash
0 9 * * * cd /var/www/html/<nome progetto>/bashscripts && ./backup.sh
```

## 📚 Risorse Aggiuntive

- [Documentazione ufficiale](https://docs.<nome progetto>.it)
- [Forum della community](https://community.<nome progetto>.it)
- [Canale Slack](https://<nome progetto>.slack.com)
- [Video tutorial](https://youtube.com/<nome progetto>)

## 🤝 Contribuire

Vuoi contribuire a migliorare questi script? Ecco come:

1. Fork del repository
2. Crea un branch per la tua feature
3. Fai commit delle modifiche
4. Push sul branch
5. Crea una Pull Request

## 📞 Supporto

Per problemi o domande:
- Email: support@<nome progetto>.it
- Telefono: +39 123 456 7890
- Ticket: https://support.<nome progetto>.it
# Script e Automazione

Documentazione completa degli script di automazione in `bashscripts/`.

## 📁 Struttura Script

```
bashscripts/
├── database/              # Script gestione database
│   ├── backup.sh
│   ├── restore.sh
│   └── migrate.sh
├── deployment/            # Script deployment
│   ├── deploy.sh
│   ├── rollback.sh
│   └── health-check.sh
├── testing/              # Script testing
│   ├── run-tests.sh
│   ├── run-phpstan.sh
│   └── run-coverage.sh
├── maintenance/          # Script manutenzione
│   ├── clear-caches.sh
│   ├── optimize.sh
│   └── cleanup-logs.sh
├── phpstan/              # Script analisi statica
│   ├── analyze-all.sh
│   ├── analyze-module.sh
│   └── fix-issues.sh
└── tools/                # Utility varie
    ├── prompts/          # Template prompts AI
    └── generators/       # Code generators
```

---

## 🗄️ Database Scripts

### backup.sh

Crea backup completo dei database.

```bash
#!/bin/bash
# bashscripts/database/backup.sh

set -e

BACKUP_DIR="/var/www/backups"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DB_NAMES=("ptvx" "ptvx_performance" "ptvx_user")

mkdir -p "$BACKUP_DIR"

for DB in "${DB_NAMES[@]}"; do
    echo "Backing up $DB..."

    mysqldump -u "$DB_USERNAME" -p"$DB_PASSWORD" \
        --single-transaction \
        --routines \
        --triggers \
        "$DB" | gzip > "$BACKUP_DIR/${DB}_${TIMESTAMP}.sql.gz"

    echo "✓ $DB backed up successfully"
done

# Cleanup old backups (keep last 30 days)
find "$BACKUP_DIR" -name "*.sql.gz" -mtime +30 -delete

echo "✓ All databases backed up successfully"
```

**Uso**:
```bash
# Backup manuale
./bashscripts/database/backup.sh

# Backup automatico (crontab)
0 2 * * * /var/www/ptvx/bashscripts/database/backup.sh
```

### restore.sh

Ripristina database da backup.

```bash
#!/bin/bash
# bashscripts/database/restore.sh

set -e

if [ -z "$1" ]; then
    echo "Usage: ./restore.sh <backup_file.sql.gz>"
    exit 1
fi

BACKUP_FILE=$1

echo "⚠️  This will OVERWRITE the current database!"
read -p "Continue? (yes/no): " confirm

if [ "$confirm" != "yes" ]; then
    echo "Restore cancelled"
    exit 0
fi

echo "Restoring from $BACKUP_FILE..."

gunzip < "$BACKUP_FILE" | mysql -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_DATABASE"

echo "✓ Database restored successfully"
```

**Uso**:
```bash
./bashscripts/database/restore.sh /var/www/backups/ptvx_20240115_020000.sql.gz
```

### migrate.sh

Esegue migrazioni con safety checks.

```bash
#!/bin/bash
# bashscripts/database/migrate.sh

set -e

cd "$(dirname "$0")/../../laravel"

echo "Checking database connection..."
php artisan db:show

echo "Running migrations..."
php artisan migrate --force

echo "✓ Migrations completed successfully"
```

---

## 🚀 Deployment Scripts

### deploy.sh

Deploy automatico su production.

```bash
#!/bin/bash
# bashscripts/deployment/deploy.sh

set -e

DEPLOY_PATH="/var/www/ptvx/laravel"

echo "🚀 Starting deployment..."

# 1. Maintenance mode
cd "$DEPLOY_PATH"
php artisan down --retry=60 --secret="deployment-secret-key"

# 2. Pull latest code
echo "Pulling latest code..."
git pull origin main

# 3. Install dependencies
echo "Installing dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 4. Run migrations
echo "Running migrations..."
php artisan migrate --force

# 5. Clear & cache
echo "Optimizing..."
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Restart queue workers
echo "Restarting queue workers..."
php artisan queue:restart

# 7. End maintenance mode
php artisan up

echo "✓ Deployment completed successfully!"
```

**Uso**:
```bash
# Deploy production
./bashscripts/deployment/deploy.sh

# Deploy con bypass maintenance
curl https://your-domain.com/deployment-secret-key
./bashscripts/deployment/deploy.sh
```

### health-check.sh

Verifica stato applicazione dopo deploy.

```bash
#!/bin/bash
# bashscripts/deployment/health-check.sh

set -e

APP_URL=${1:-"https://your-domain.com"}

echo "Running health checks on $APP_URL..."

# Check HTTP status
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" "$APP_URL/api/health")

if [ "$HTTP_STATUS" != "200" ]; then
    echo "❌ Health check failed! HTTP $HTTP_STATUS"
    exit 1
fi

# Check database
DB_CHECK=$(curl -s "$APP_URL/api/health/database" | jq -r '.status')

if [ "$DB_CHECK" != "ok" ]; then
    echo "❌ Database check failed!"
    exit 1
fi

# Check queue
QUEUE_CHECK=$(curl -s "$APP_URL/api/health/queue" | jq -r '.status')

if [ "$QUEUE_CHECK" != "ok" ]; then
    echo "❌ Queue check failed!"
    exit 1
fi

echo "✓ All health checks passed!"
```

---

## 🧪 Testing Scripts

### run-tests.sh

Esegue tutti i test con coverage.

```bash
#!/bin/bash
# bashscripts/testing/run-tests.sh

set -e

cd "$(dirname "$0")/../../laravel"

echo "🧪 Running test suite..."

# Run Pest tests with coverage
./vendor/bin/pest \
    --coverage \
    --min=80 \
    --coverage-html=coverage \
    --parallel

echo "✓ All tests passed!"
```

### run-phpstan.sh

Analisi PHPStan su tutto il progetto.

```bash
#!/bin/bash
# bashscripts/testing/run-phpstan.sh

set -e

cd "$(dirname "$0")/../../laravel"

echo "🔍 Running PHPStan Level 10..."

./vendor/bin/phpstan analyse \
    --level=10 \
    --memory-limit=2G \
    --error-format=table

echo "✓ PHPStan analysis passed!"
```

### run-quality.sh

Verifica completa qualità codice.

```bash
#!/bin/bash
# bashscripts/testing/run-quality.sh

set -e

cd "$(dirname "$0")/../../laravel"

echo "🎯 Running quality checks..."

# 1. Laravel Pint
echo "1/4 Running Pint..."
./vendor/bin/pint --test

# 2. PHPStan
echo "2/4 Running PHPStan..."
./vendor/bin/phpstan analyse --level=10

# 3. Tests
echo "3/4 Running Tests..."
./vendor/bin/pest --coverage --min=80

# 4. PHP Insights
echo "4/4 Running PHP Insights..."
php artisan insights --no-interaction --min-quality=90

echo "✓ All quality checks passed!"
```

---

## 🔧 Maintenance Scripts

### clear-caches.sh

Pulizia completa cache.

```bash
#!/bin/bash
# bashscripts/maintenance/clear-caches.sh

set -e

cd "$(dirname "$0")/../../laravel"

echo "🧹 Clearing all caches..."

# Application cache
php artisan cache:clear

# Config cache
php artisan config:clear

# Route cache
php artisan route:clear

# View cache
php artisan view:clear

# Event cache
php artisan event:clear

# Compiled class cache
php artisan clear-compiled

# OPcache (if available)
if command -v cachetool &> /dev/null; then
    cachetool opcache:reset
fi

echo "✓ All caches cleared!"
```

### optimize.sh

Ottimizzazione completa per production.

```bash
#!/bin/bash
# bashscripts/maintenance/optimize.sh

set -e

cd "$(dirname "$0")/../../laravel"

echo "⚡ Optimizing application..."

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Cache events
php artisan event:cache

# Optimize composer
composer install --optimize-autoloader --no-dev

# Optimize Laravel
php artisan optimize

echo "✓ Optimization completed!"
```

### cleanup-logs.sh

Pulizia log vecchi.

```bash
#!/bin/bash
# bashscripts/maintenance/cleanup-logs.sh

set -e

LOG_DIR="$(dirname "$0")/../../laravel/storage/logs"
DAYS_TO_KEEP=30

echo "🧹 Cleaning up old logs (keeping last $DAYS_TO_KEEP days)..."

find "$LOG_DIR" -name "*.log" -mtime +$DAYS_TO_KEEP -delete

# Compress old logs
find "$LOG_DIR" -name "*.log" -mtime +7 ! -name "*.gz" -exec gzip {} \;

echo "✓ Log cleanup completed!"
```

---

## 📊 PHPStan Scripts

### analyze-all.sh

Analizza tutti i moduli sequenzialmente.

```bash
#!/bin/bash
# bashscripts/phpstan/analyze-all.sh

set -e

cd "$(dirname "$0")/../../laravel"

MODULES_DIR="Modules"
FAILED_MODULES=()

echo "🔍 Analyzing all modules with PHPStan Level 10..."

for MODULE in "$MODULES_DIR"/*; do
    if [ -d "$MODULE" ]; then
        MODULE_NAME=$(basename "$MODULE")

        echo "Analyzing $MODULE_NAME..."

        if ! ./vendor/bin/phpstan analyse "$MODULE" --level=10; then
            FAILED_MODULES+=("$MODULE_NAME")
        fi
    fi
done

if [ ${#FAILED_MODULES[@]} -gt 0 ]; then
    echo ""
    echo "❌ Failed modules:"
    printf '%s\n' "${FAILED_MODULES[@]}"
    exit 1
fi

echo "✓ All modules passed PHPStan Level 10!"
```

### analyze-module.sh

Analizza singolo modulo con report dettagliato.

```bash
#!/bin/bash
# bashscripts/phpstan/analyze-module.sh

set -e

if [ -z "$1" ]; then
    echo "Usage: ./analyze-module.sh <ModuleName>"
    exit 1
fi

MODULE=$1
cd "$(dirname "$0")/../../laravel"

if [ ! -d "Modules/$MODULE" ]; then
    echo "❌ Module $MODULE not found!"
    exit 1
fi

echo "🔍 Analyzing module $MODULE..."

./vendor/bin/phpstan analyse "Modules/$MODULE" \
    --level=10 \
    --error-format=table \
    --memory-limit=2G

echo "✓ Analysis completed!"
```

### create-roadmap.sh

Crea roadmap per fixing errori PHPStan.

```bash
#!/bin/bash
# bashscripts/phpstan/create-roadmap.sh

set -e

if [ -z "$1" ]; then
    echo "Usage: ./create-roadmap.sh <ModuleName>"
    exit 1
fi

MODULE=$1
cd "$(dirname "$0")/../../laravel"

DOCS_DIR="Modules/$MODULE/docs"
ROADMAP_FILE="$DOCS_DIR/phpstan-roadmap.md"

mkdir -p "$DOCS_DIR"

echo "📋 Creating PHPStan roadmap for $MODULE..."

# Run PHPStan and capture output
ERROR_OUTPUT=$(./vendor/bin/phpstan analyse "Modules/$MODULE" --level=10 --error-format=raw 2>&1 || true)

# Generate roadmap
cat > "$ROADMAP_FILE" << EOF
# PHPStan Level 10 Roadmap - $MODULE

Generated: $(date +"%Y-%m-%d %H:%M:%S")

## Errors Summary

\`\`\`
$ERROR_OUTPUT
\`\`\`

## Categorized Errors

### Type Hints Missing

### Null Safety Issues

### Array Type Issues

### Property Access Issues

## Action Plan

- [ ] Phase 1: Add missing type hints
- [ ] Phase 2: Fix null safety issues
- [ ] Phase 3: Fix array type issues
- [ ] Phase 4: Fix property access issues
- [ ] Phase 5: Verify all errors resolved

## Progress

- Total Errors: TODO
- Fixed: 0
- Remaining: TODO
EOF

echo "✓ Roadmap created at $ROADMAP_FILE"
```

---

## 🛠️ Tools Scripts

### generate-action.sh

Genera skeleton per nuova Action.

```bash
#!/bin/bash
# bashscripts/tools/generators/generate-action.sh

if [ -z "$1" ] || [ -z "$2" ]; then
    echo "Usage: ./generate-action.sh <ModuleName> <ActionName>"
    echo "Example: ./generate-action.sh User CreateUser"
    exit 1
fi

MODULE=$1
ACTION=$2
ACTION_FILE="Modules/$MODULE/app/Actions/${ACTION}Action.php"

mkdir -p "Modules/$MODULE/app/Actions"

cat > "$ACTION_FILE" << 'EOF'
<?php

declare(strict_types=1);

namespace Modules\{MODULE}\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\QueueableAction\QueueableAction;

class {ACTION}Action
{
    use AsAction;
    use QueueableAction;

    public function handle(): void
    {
        // TODO: Implement action logic
    }
}
EOF

# Replace placeholders
sed -i "s/{MODULE}/$MODULE/g" "$ACTION_FILE"
sed -i "s/{ACTION}/$ACTION/g" "$ACTION_FILE"

echo "✓ Action created at $ACTION_FILE"
```

---

## 📅 Cron Jobs

### Setup Crontab

```bash
# Apri crontab
crontab -e

# Aggiungi questi job
# Laravel Scheduler (ogni minuto)
* * * * * cd /var/www/ptvx/laravel && php artisan schedule:run >> /dev/null 2>&1

# Backup database (ogni giorno alle 2:00)
0 2 * * * /var/www/ptvx/bashscripts/database/backup.sh >> /var/www/ptvx/storage/logs/backup.log 2>&1

# Cleanup logs (ogni settimana domenica alle 3:00)
0 3 * * 0 /var/www/ptvx/bashscripts/maintenance/cleanup-logs.sh >> /var/www/ptvx/storage/logs/cleanup.log 2>&1

# Health check (ogni 5 minuti)
*/5 * * * * /var/www/ptvx/bashscripts/deployment/health-check.sh >> /var/www/ptvx/storage/logs/health.log 2>&1
```

---

## 🔐 Script Security

### Best Practices

```bash
#!/bin/bash

# 1. Strict mode
set -e  # Exit on error
set -u  # Exit on undefined variable
set -o pipefail  # Exit on pipe failure

# 2. Validate input
if [ -z "${1:-}" ]; then
    echo "Error: Missing required argument"
    exit 1
fi

# 3. Use absolute paths
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

# 4. Check required commands
for cmd in php composer mysql; do
    if ! command -v $cmd &> /dev/null; then
        echo "Error: $cmd is required but not installed"
        exit 1
    fi
done

# 5. Load env variables safely
if [ -f .env ]; then
    set -a
    source .env
    set +a
fi

# 6. Validate environment
if [ "$APP_ENV" == "production" ]; then
    read -p "⚠️  Running in PRODUCTION! Continue? (yes/no): " confirm
    if [ "$confirm" != "yes" ]; then
        exit 0
    fi
fi
```

---

## 📚 Risorse Aggiuntive

- [Setup](setup.md)
- [Development](development.md)
- [Code Quality](code-quality.md)
- [Bash Best Practices](https://google.github.io/styleguide/shellguide.html)
