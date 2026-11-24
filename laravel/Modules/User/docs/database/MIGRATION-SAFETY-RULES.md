# Migration Safety Rules - NEVER Destroy Data

## Regola ASSOLUTA

**🚨 MAI E POI MAI eseguire questi comandi:**

```bash
❌ php artisan migrate:fresh
❌ php artisan migrate --force
❌ php artisan db:wipe
❌ php artisan db:fresh
❌ php artisan migrate:refresh
❌ php artisan migrate:reset
```

**🚨 MAI usare trait in produzione:**

```php
❌ use RefreshDatabase;  // Solo in tests!
❌ use DatabaseMigrations; // Solo in tests!
```

---

## La Filosofia (Why)

### 1. Data Preservation Principle

**I DATI SONO SACRI**

- I dati del cliente NON possono essere distrutti
- I dati di produzione NON possono essere persi
- I dati di sviluppo vanno preservati quando possibile
- Il rollback è un'illusione: i dati persi non tornano

### 2. Forward-Only Philosophy

**SEMPRE AVANTI, MAI INDIETRO**

```
❌ DROP TABLE users;           // Mai!
❌ TRUNCATE TABLE profiles;    // Mai!
❌ DELETE FROM orders;         // Mai!

✅ ALTER TABLE users ADD COLUMN new_field;  // Sempre!
✅ UPDATE users SET status = 'active';      // Con cautela!
```

### 3. Production-First Mindset

**SVILUPPA COME SE FOSSI IN PRODUZIONE**

- Se non lo faresti in produzione, non farlo in dev
- I comandi distruttivi diventano abitudine → disastri in produzione
- Il muscle memory uccide i dati

---

## La Religione (Best Practices)

### Regola #1: Additive Migrations Only

**SEMPRE** aggiungere, MAI rimuovere:

```php
// ✅ CORRETTO - Additive
Schema::table('profiles', function (Blueprint $table) {
    if (! $this->hasColumn('uuid')) {
        $table->uuid('uuid')->nullable();
    }
});

// ❌ WRONG - Destructive
Schema::table('profiles', function (Blueprint $table) {
    $table->dropColumn('old_field');  // MAI!
});
```

### Regola #2: Idempotent Migrations

**SEMPRE** verificare prima di modificare:

```php
// ✅ CORRETTO - Check first
if (! $this->hasColumn('uuid')) {
    $table->uuid('uuid')->nullable();
}

// ❌ WRONG - Blind add
$table->uuid('uuid');  // Crash if exists!
```

### Regola #3: Timestamp Update, Never Delete

**SEMPRE** aggiornare timestamp migration, MAI eliminarla:

```bash
# ✅ CORRETTO - Update timestamp to re-run
mv 2024_01_01_create_profiles.php 2026_03_12_172000_create_profiles.php
php artisan migrate

# ❌ WRONG - Delete and recreate
rm 2024_01_01_create_profiles.php
php artisan make:migration create_profiles_table
```

### Regola #4: ONE Migration Per Table

**SEMPRE** una sola migration per tabella:

```
✅ CORRETTO
Modules/User/database/migrations/
└── 2026_03_12_172000_create_profiles_table.php  # UNICA fonte

❌ WRONG
Modules/User/database/migrations/
├── 2024_01_01_create_profiles_table.php
├── 2024_02_01_add_uuid_to_profiles.php         # NO!
├── 2024_03_01_fix_profiles_schema.php          # NO!
└── 2024_04_01_repair_profiles_contract.php     # NO!
```

---

## La Visione (Safe Workflow)

### Workflow Corretto per Modifiche Schema

1. **TROVA** la migration originale della tabella
2. **STUDIA** il contenuto attuale
3. **MODIFICA** aggiungendo solo nuovi campi (con check)
4. **AGGIORNA** timestamp nel filename
5. **ESEGUI** `php artisan migrate`

```bash
# Step 1: Find
find Modules/User/database/migrations -name "*create_profiles*"

# Step 2: Study
cat Modules/User/database/migrations/2026_03_12_172000_create_profiles_table.php

# Step 3: Modify (add idempotent check)
if (! $this->hasColumn('uuid')) {
    $table->uuid('uuid')->nullable();
}

# Step 4: Update timestamp
mv 2026_03_12_170000_create_profiles_table.php \
   2026_03_12_172000_create_profiles_table.php

# Step 5: Run
php artisan migrate
```

---

## Lo Zen (Testing Exception)

### L'Unica Eccezione: Test Environment

**NEI TEST È CONSENTITO** (ma solo nei test):

```php
// tests/TestCase.php o tests/Pest.php
use RefreshDatabase;  // ✅ OK nei test

// MAI nel codice di produzione!
```

**Perché?**
- I test hanno database temporanei
- I test DEVONO partire da stato pulito
- I test NON contengono dati reali

---

## Comandi SICURI vs PERICOLOSI

### ✅ SICURI (Usa Sempre)

```bash
php artisan migrate              # Esegue nuove migrations
php artisan migrate:status       # Verifica stato
php artisan migrate:rollback     # rollback ULTIMA migration (con cautela)
php artisan db:table tablename   # Visualizza struttura
php artisan db:seed              # Popola dati (additivo)
```

### ⚠️ CAUTELA (Usa Raramente)

```bash
php artisan migrate:rollback --step=1  # Solo UNA volta
php artisan migrate:refresh            # Solo in dev, con backup!
```

### 🚨 VIETATI (Mai Usare)

```bash
php artisan migrate:fresh         # DISTRUGGE TUTTO
php artisan migrate --force       # FORZA in produzione
php artisan db:wipe              # CANCELLA DATABASE
php artisan db:fresh             # SINONIMO DI DISASTRO
```

---

## Esempio Reale: Il Caso profiles

### Problema Iniziale

```
Errore: Column 'uuid' not found in profiles table
```

### ❌ Approccio SBAGLIATO (Distruttivo)

```bash
php artisan migrate:fresh  # 💀 DISTRUGGE TUTTI I DATI
```

### ✅ Approccio CORRETTO (Forward-Only)

```bash
# 1. Trova migration esistente
find Modules/User/database/migrations -name "*create_profiles*"

# 2. Modifica migration aggiungendo uuid con check
if (! $this->hasColumn('uuid')) {
    $table->uuid('uuid')->nullable();
}

# 3. Aggiorna timestamp
mv 2026_03_12_170000_create_profiles_table.php \
   2026_03_12_172000_create_profiles_table.php

# 4. Esegui migration
php artisan migrate

# Risultato: ✅ Dati preservati, schema aggiornato
```

---

## Documentazione per Altri Agenti AI

### Come Comunicare Questa Regola

Quando un altro agente AI incontra problemi di schema:

1. **DIRIGI** alle cartelle `docs/`
2. **SPIEGA** la filosofia forward-only
3. **MOSTRA** l'esempio corretto
4. **LINKA** a GitHub Discussions

### File da Leggere

- `Modules/Xot/docs/MIGRATION_PHILOSOPHY.md`
- `Modules/User/docs/database/MIGRATION_SAFETY_RULES.md`
- `.opencode/rules/migration-safety.md`
- `.opencode/skills/safe-migrations/SKILL.md`

---

## Related

- **GitHub Issue**: #24 (Migration Safety Rules)
- **GitHub Discussion**: Forward-Only Database Evolution
- **Skill**: `.opencode/skills/safe-migrations/SKILL.md`
- **Memory**: `.opencode/memories/never-use-migrate-fresh.md`
- **Docs**: `Modules/Xot/docs/MIGRATION_PHILOSOPHY.md`

---

## Checklist Prima di Ogni Migration

- [ ] Ho verificato che il comando NON è distruttivo?
- [ ] Ho usato `hasColumn()` check prima di aggiungere?
- [ ] Ho aggiornato timestamp invece di creare nuova migration?
- [ ] Ho testato in ambiente di sviluppo sicuro?
- [ ] Ho fatto backup se necessario?
- [ ] Ho documentato il PERCHÉ della modifica?

---

**Regola d'Oro**: Quando in dubbio, NON eseguire. Chiedi chiarimenti.

**Creato da**: AI Agent Session 2026-03-12  
**Per**: Preservazione dati e comunicazione inter-agent
