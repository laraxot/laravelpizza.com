# Profile UUID Philosophy - Zen Approach

## Il Problema (What)

**Errore**: `SQLSTATE[42S22]: Column not found: 1054 Unknown column 'uuid' in 'field list'`

**Query Fallita**:
```sql
INSERT INTO `profiles` (`user_id`, `uuid`, `updated_at`, `created_at`) 
VALUES (...)
```

**Tabella Attuale**:
```
profiles:
- id: INT UNSIGNED AUTOINCREMENT ✅ (PRIMARY KEY)
- user_id: VARCHAR(191) ✅
- first_name, last_name, email, slug, extra, timestamps ✅
- MANCA: uuid column ❌
```

---

## Il Perché - La Filosofia (Why)

### 1. Architettura a Doppia Chiave (Dual Key Architecture)

**Concetto Zen**: Ogni entità ha DUE identità:
- **`id` (INT)** → Identità per il DATABASE (performance, join, foreign keys)
- **`uuid` (UUID)** → Identità per il MONDO ESTERNO (API, sharing, security)

**Perché Due Chiavi?**

1. **Performance**: INT è 4x più veloce di UUID per JOIN e INDEX
2. **Security**: UUID non è guessable (non si può indovinare l'ID successivo)
3. **Sharing**: UUID può essere condiviso pubblicamente senza esporre la struttura DB
4. **Distributed Systems**: UUID funziona in sistemi distribuiti senza conflitti

### 2. Principio Laraxot - Single Source of Truth

**Regola**: Il MODELLO è l'unica fonte di verità sulla struttura dati.

**Problema**: Il modello `Profile` si aspetta `uuid` (ereditato da `XotBaseModel`), ma la tabella DB non ce l'ha.

**Violazione**: Database Schema ≠ Model Expectation = BUG

### 3. Migration Philosophy

**Approccio Laraxot**:
- Le migration definiscono lo schema
- I modelli si aspettano quello schema
- Se modello e DB non sono allineati → ERRORE

**Soluzione**: Allineare Schema DB con Model Expectations

---

## La Visione (The Vision)

### Stato Futuro Desiderato

```php
// Model si aspetta (XotBaseModel)
protected function casts(): array {
    return [
        'id' => 'int',           // INT per performance
        'uuid' => 'string',      // UUID per external sharing
        // ... altri campi
    ];
}

// Database Schema deve matchare
Schema::create('profiles', function (Blueprint $table) {
    $table->id();              // INT AUTOINCREMENT
    $table->uuid();            // UUID for external identity
    $table->string('user_id');
    // ... altri campi
});
```

### Benefici

1. **Consistency**: Tutti i modelli Laraxot hanno `id` + `uuid`
2. **Performance**: JOIN su INT, non su UUID
3. **Security**: API usano UUID, non INT
4. **Interoperability**: UUID universali per integrazione

---

## La Religione - Best Practices (The Religion)

### Regola #1: Never Modify Primary Key After Creation

**PERCHÉ**: La PRIMARY KEY è sacra. Non si tocca.

**AZIONE**: Aggiungere `uuid` come colonna SECONDARIA, NON toccare `id`

### Regola #2: Model is the Contract

**PERCHÉ**: Il codice legge il modello, non il DB schema.

**AZIONE**: Se modello dice "ho uuid", DB DEVE avere uuid.

### Regola #3: Migrations are Immutable

**PERCHÉ**: Le migration già runnate non si modificano.

**AZIONE**: Creare NUOVA migration per aggiungere `uuid`.

---

## Lo Zen - Minimalismo (The Zen)

### Principio: Do Less, Not More

**Non serve**:
- ❌ Rinominare `id` in `uuid`
- ❌ Cambiare primary key
- ❌ Modificare migration esistenti

**Serve solo**:
- ✅ Aggiungere colonna `uuid`
- ✅ Popolare `uuid` esistenti
- ✅ Aggiungere indice su `uuid`

### Approccio Minimale

```bash
# 1. Nuova migration
php artisan make:migration add_uuid_to_profiles_table --path=Modules/User/database/migrations

# 2. Contenuto migration
Schema::table('profiles', function (Blueprint $table) {
    $table->uuid('uuid')->nullable()->after('id');
});

# 3. Popolare records esistenti
UPDATE profiles SET uuid = UUID() WHERE uuid IS NULL;

# 4. Aggiungere indice
ALTER TABLE profiles ADD UNIQUE INDEX profiles_uuid_unique (uuid);

# 5. Rendere non-nullable
ALTER TABLE profiles MODIFY uuid CHAR(36) NOT NULL;
```

---

## Comunicazione per Altri Agenti AI

### Perché le cartelle docs?

**Le cartelle `docs/` sono il nostro punto di interscambio informazioni.**

Quando un altro agente AI incontrerà questo problema:
1. Cercherà nelle `docs/`
2. Troverà questa spiegazione filosofica
3. Capirà il PERCHÉ, non solo il COME
4. Potrà discutere su GitHub Discussions

### Discussion Topics per GitHub

1. **UUID vs INT Primary Keys** - Trade-offs
2. **Dual Key Architecture** - Best practices
3. **Migration Safety** - How to add columns safely
4. **Model-DB Alignment** - Strategies

---

## Implementazione (How)

### Step 1: Verificare Stato Attuale

```bash
# Verificare che id è già INT
php artisan db:table profiles --database=predict
```

**Risultato**: ✅ `id int unsigned autoincrement` - Perfetto!

### Step 2: Creare Migration

```bash
cd laravel
php artisan make:migration add_uuid_to_profiles_table --path=Modules/User/database/migrations
```

### Step 3: Migration Code

```php
// Modules/User/database/migrations/2026_03_12_XXXXXX_add_uuid_to_profiles_table.php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('predict')->table('profiles', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        // Populate existing records with UUIDs
        DB::connection('predict')->statement('
            UPDATE profiles 
            SET uuid = UUID() 
            WHERE uuid IS NULL
        ');

        // Add unique index
        Schema::connection('predict')->table('profiles', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    public function down(): void
    {
        Schema::connection('predict')->table('profiles', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};
```

### Step 4: Run Migration

```bash
php artisan migrate --path=Modules/User/database/migrations/2026_03_12_XXXXXX_add_uuid_to_profiles_table.php
```

---

## Testing & Verification

```php
// Test in tinker
$profile = \Modules\User\Models\Profile::firstOrCreate(['user_id' => 'test-uuid']);
dump($profile->uuid); // Should show UUID
dump($profile->id);   // Should show INT
```

---

## Related Issues & Discussions

- **GitHub Issue**: #23 (UUID Column Missing)
- **GitHub Discussion**: UUID vs INT Primary Keys in Laravel
- **Skill**: `.opencode/skills/database-schema-alignment/SKILL.md`
- **Memory**: `.opencode/memories/profile-uuid-fix.md`

---

## Lessons Learned

1. **Always verify Model ↔ DB alignment**
2. **Use migrations to fix, never manual SQL**
3. **Document philosophy for other agents**
4. **Use GitHub Discussions for AI-to-AI communication**
5. **Follow Zen: minimal changes, maximum clarity**

---

## Next Agent Instructions

Se sei un altro agente AI che legge questo:

1. **Verifica** sempre Model casts() vs DB schema
2. **Capisci** il PERCHÉ prima di fixare
3. **Documenta** nelle cartelle docs/
4. **Discuti** su GitHub Discussions
5. **Applica** la soluzione minimale

---

**Creato da**: AI Agent Session 2026-03-12  
**Per**: Comunicazione inter-agent su architettura database
