# 📋 Produzione Migration Checklist

## Prima di Eseguire Migration in Produzione

### ✅ Pre-Flight Checklist

```
[ ] 1. Migration testata in LOCALE
[ ] 2. Migration testata in STAGING
[ ] 3. Backup del database pianificato
[ ] 4. Maintenance mode preparato
[ ] 5. Rollback plan testato
[ ] 6. Team notificato (se necessario)
[ ] 7. Monitoring attivo
```

---

## Procedura Step-by-Step

### Step 1: Test in Locale

```bash
# Verifica che la migration funzioni
php artisan migrate --path=Modules/Activity/database/migrations/2026_03_24_120000_add_batch_uuid_and_event_to_activity_table.php

# Verifica le colonne
php artisan tinker
>>> Schema::hasColumn('activity_log', 'batch_uuid')
>>> Schema::hasColumn('activity_log', 'event')

# Rollback test (opzionale, solo in locale)
php artisan migrate:rollback --step=1
```

### Step 2: Test in Staging

```bash
# SSH in staging
ssh user@staging.ptvx.local

# Esegui migration
php artisan migrate --path=Modules/Activity/database/migrations/2026_03_24_120000_add_batch_uuid_and_event_to_activity_table.php

# Verifica
php artisan tinker --execute="echo Schema::hasColumn('activity_log', 'batch_uuid')"

# Test applicazione
# ... esegui test manuali o automatici ...
```

### Step 3: Produzione

#### 3.1 Backup (OBBLIGATORIO)

```bash
# SSH in produzione
ssh user@production

# Backup completo
mysqldump -u $DB_USER -p$DB_PASS --single-transaction \
  --routines --triggers \
  $DB_DATABASE > backup_$(date +%Y%m%d_%H%M%S).sql

# Verifica backup
ls -lh backup_*.sql
```

#### 3.2 Maintenance Mode

```bash
# Metti in maintenance
php artisan down

# Verifica maintenance
curl http://ptvx.local
# Dovrebbe restituire 503 Service Unavailable
```

#### 3.3 Esegui Migration (SENZA --force!)

```bash
# Esegui migration
php artisan migrate --path=Modules/Activity/database/migrations/2026_03_24_120000_add_batch_uuid_and_event_to_activity_table.php

# > Do you really wish to run this command in production? [yes|No]
# Digita: yes
```

#### 3.4 Verifica

```bash
# Verifica colonne
php artisan tinker --execute="
  echo 'batch_uuid: ' . (Schema::hasColumn('activity_log', 'batch_uuid') ? 'OK' : 'MISSING');
  echo ' event: ' . (Schema::hasColumn('activity_log', 'event') ? 'OK' : 'MISSING');
"

# Verifica migration registrate
php artisan migrate:status | grep 2026_03_24_120000
```

#### 3.5 Riattiva Applicazione

```bash
# Riattiva
php artisan up

# Verifica applicazione
curl http://ptvx.local
# Dovrebbe restituire 200 OK
```

---

## Script Automatizzato (Consigliato)

Crea uno script `deploy-migration.sh`:

```bash
#!/bin/bash
# deploy-migration.sh

set -e  # Exit on error

MIGRATION_PATH=$1
DB_USER=$2
DB_PASS=$3
DB_NAME=$4

echo "🚀 Produzione Migration Deploy"
echo "Migration: $MIGRATION_PATH"
echo "Database: $DB_NAME"
echo ""

# 1. Backup
echo "📦 Step 1/5: Backup del database..."
BACKUP_FILE="backup_$(date +%Y%m%d_%H%M%S).sql"
mysqldump -u $DB_USER -p$DB_PASS --single-transaction \
  --routines --triggers \
  $DB_NAME > $BACKUP_FILE

if [ -f "$BACKUP_FILE" ]; then
    echo "✅ Backup creato: $BACKUP_FILE"
    ls -lh $BACKUP_FILE
else
    echo "❌ Backup FALLITO!"
    exit 1
fi

# 2. Maintenance Mode
echo ""
echo "🔧 Step 2/5: Maintenance mode..."
php artisan down

# 3. Migration
echo ""
echo "⚙️  Step 3/5: Esecuzione migration..."
php artisan migrate --path=$MIGRATION_PATH

if [ $? -eq 0 ]; then
    echo "✅ Migration completata"
else
    echo "❌ Migration FALLITA!"
    echo "🔄 Ripristino applicazione..."
    php artisan up
    exit 1
fi

# 4. Verifica
echo ""
echo "🔍 Step 4/5: Verifica..."
php artisan tinker --execute="echo 'Migration OK'"

# 5. Riattiva
echo ""
echo "🎯 Step 5/5: Riattivazione applicazione..."
php artisan up

echo ""
echo "✅ DEPLOY COMPLETATO CON SUCCESSO!"
echo ""
echo "Backup: $BACKUP_FILE"
echo "Conserva questo file per almeno 7 giorni"
```

Utilizzo:

```bash
# Rendi eseguibile
chmod +x deploy-migration.sh

# Esegui
./deploy-migration.sh \
  "Modules/Activity/database/migrations/2026_03_24_120000_add_batch_uuid_and_event_to_activity_table.php" \
  "user" \
  "password" \
  "database_name"
```

---

## Rollback di Emergenza

Se qualcosa va storto:

### 1. Ripristina Backup

```bash
# Ferma applicazione
php artisan down

# Ripristina backup
mysql -u $DB_USER -p$DB_PASS $DB_DATABASE < backup_20260324_120000.sql

# Verifica
php artisan tinker --execute="echo DB::table('activity_log')->count()"

# Riattiva
php artisan up
```

### 2. Rollback Migration

```bash
# Rollback di 1 step
php artisan migrate:rollback --step=1

# Oppure rollback specifico
php artisan migrate:rollback --path=Modules/Activity/database/migrations/2026_03_24_120000_add_batch_uuid_and_event_to_activity_table.php
```

---

## Monitoring Post-Migration

Dopo la migration, monitora:

```bash
# Log errori
tail -f storage/logs/laravel.log | grep -i error

# Performance database
mysql -u $DB_USER -p$DB_PASS -e "SHOW PROCESSLIST"

# Health check
curl http://ptvx.local/api/health
```

---

## Errori Comuni e Soluzioni

### Errore: "Connection refused"

```bash
# Verifica connessione
php artisan tinker
>>> DB::connection()->getDatabaseName()

# Se fallisce, controlla .env
cat .env | grep DB_
```

### Errore: "Table doesn't exist"

```bash
# Verifica tabelle esistenti
php artisan tinker
>>> DB::select('SHOW TABLES')

# Controlla migration precedenti
php artisan migrate:status
```

### Errore: "Duplicate column name"

```bash
# La colonna esiste già
php artisan tinker
>>> Schema::hasColumn('activity_log', 'batch_uuid')

# Se true, la migration non è necessaria
```

---

## Best Practices

### ✅ DO

- Test SEMPRE in staging prima
- Backup OBBLIGATORIO
- Maintenance mode SEMPRE
- Verifica DOPO la migration
- Monitora PER almeno 1 ora dopo

### ❌ DON'T

- MAI `migrate --force` manuale
- MAI skippare il backup
- MAI eseguire in orario di punta
- MAI senza rollback plan
- MAI senza testing preliminare

---

## Template Comunicazione Team

Se la migration richiede comunicazione al team:

```
Oggetto: Maintenance Programmata - Migration Database

Ciao Team,

Il [DATA] alle [ORA] eseguiremo una migration del database.

Durata stimata: [X] minuti
Impatto: [Servizio non disponibile / Nessun impatto]

Migration: [NOME MIGRATION]
Backup: ✅ Pianificato
Rollback Plan: ✅ Pronto

Aggiornamenti: [CANALE COMUNICAZIONE]

Grazie,
[TUO NOME]
```

---

## Riferimenti

- [MAI FARE migrate:refresh](../Activity/docs/errori/MAI_FARE_MIGRATE_REFRESH.md)
- [MAI FARE migrate --force](../Activity/docs/errori/MAI_FARE_MIGRATE_FORCE.md)
- [Forward-Only Philosophy](../Xot/docs/philosophy-complete.md)
- [Laravel Migration Docs](https://laravel.com/docs/migrations)

---

*Documento creato per standardizzare le migration in produzione - Da seguire SEMPRE*
