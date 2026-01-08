# Strategia Migrazioni e Morphs Polymorphic - <nome progetto>

## Principio Architetturale Fondamentale

### Una Tabella = Una Migrazione = Una Verità

Il sistema <nome progetto> segue la **filosofia Laraxot** per le migrazioni database, dove ogni tabella ha una sola migrazione che evolve nel tempo attraverso il cambio di timestamp nel nome file.

## Regole Critiche per Morphs Polymorphic

### ID Polymorphic DEVE essere string

```php
// ✅ CORRETTO - Supporta tutti i formati ID
$table->string('causer_id')->nullable()->change();

// ❌ ERRATO - Limitato solo a ID numerici
$table->unsignedBigInteger('causer_id')->nullable()->change();
```

### Motivazione Architetturale

Il sistema <nome progetto> è **multi-modulo** con diverse strategie ID:

- **User**: UUID `"550e8400-e29b-41d4-a716-446655440000"`
- **Doctor**: UUID `"a1b2c3d4-e5f6-7890-abcd-ef1234567890"`
- **Patient**: UUID `"p1a2t3i4-e5n6-7890-uuid-123456789012"`
- **Admin**: Integer `"123"` (memorizzato come string)
- **System**: Custom `"SYSTEM_001"`

### Pattern Evolutivo

```bash
# Evoluzione migrazione Activity
2023_03_31_103351_create_activity_table.php  # Versione originale
↓
2024_01_01_000001_create_activity_table.php  # Aggiunta nullable
↓  
2024_01_15_103351_create_activity_table.php  # Correzione tipo string
```

## Processo di Modifica Migrazione

### STEP 1: Copia e Rinomina
```bash
cp 2023_03_31_103351_create_activity_table.php 2024_01_15_103351_create_activity_table.php
```

### STEP 2: Modifica Contenuto
```php
return new class extends XotBaseMigration
{
    public function up(): void
    {
        // Struttura completa aggiornata
        $this->tableCreate(function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject', 'subject');
            $table->nullableMorphs('causer', 'causer'); // Già nullable per design
            $table->json('properties')->nullable();
            $table->index('log_name');
            $table->uuid('batch_uuid')->nullable();
            $table->string('event')->nullable();
        });
        
        // Gestione DB esistenti
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('causer_id')) {
                $table->string('causer_id')->nullable()->change(); // STRING!
            }
            if ($this->hasColumn('causer_type')) {
                $table->string('causer_type')->nullable()->change();
            }
            $this->updateTimestamps($table, true);
        });
    }
};
```

### STEP 3: Elimina Originale
```bash
rm 2023_03_31_103351_create_activity_table.php
```

## Vantaggi Architetturali

### 1. **Universalità**
- Supporta qualsiasi formato ID attuale e futuro
- Zero accoppiamento tra moduli
- Evoluzione indipendente delle strategie ID

### 2. **Idempotenza**
- Una migrazione funziona su DB vuoto (crea) e esistente (aggiorna)
- Zero duplicazioni di logica
- Manutenzione semplificata

### 3. **Modularità**
- Ogni modulo può definire la sua strategia ID
- Activity log universale per tutto il sistema
- Polimorfismo reale senza vincoli

## Casi d'Uso Reali

### Scenario 1: User Login
```php
Activity::create([
    'log_name' => 'auth',
    'description' => 'User logged in',
    'causer_id' => '550e8400-e29b-41d4-a716-446655440000', // UUID
    'causer_type' => 'Modules\User\Models\User'
]);
```

### Scenario 2: System Operation
```php
Activity::create([
    'log_name' => 'system',
    'description' => 'Backup completed',
    'causer_id' => 'SYSTEM_BACKUP', // Custom ID
    'causer_type' => 'Modules\System\Models\SystemUser'
]);
```

### Scenario 3: Admin Action
```php
Activity::create([
    'log_name' => 'admin',
    'description' => 'User deleted',
    'causer_id' => '123', // Integer as string
    'causer_type' => 'Modules\Admin\Models\Admin'
]);
```

## Anti-Pattern da Evitare

### ❌ Multiple Migrazioni
```bash
# SBAGLIATO
2023_03_31_create_activity_table.php
2024_01_15_update_activity_table_causer_nullable.php  # NO!
2024_02_10_add_event_to_activity_table.php           # NO!
```

### ❌ Tipo ID Rigido
```php
// SBAGLIATO - Non funziona con UUID
$table->unsignedBigInteger('causer_id')->nullable()->change();
```

### ❌ Logica Duplicata
```php
// SBAGLIATO - Duplicazione tra create e update
Schema::create('activity_log', function($table) { /* ... */ });
// E poi in altra migrazione...
Schema::table('activity_log', function($table) { /* stessa logica */ });
```

## Filosofia <nome progetto>

> *"In un sistema sanitario, ogni azione deve essere tracciata universalmente. Come un medico deve curare pazienti di ogni nazionalità, il nostro sistema deve registrare attività di ogni modulo, indipendentemente dal formato del loro ID. L'universalità è salute, la rigidità è malattia."*

## Collegamenti

- [Modules/Activity/docs/database/migrations.md](../laravel/Modules/Activity/docs/database/migrations.md)
- [.cursor/rules/migration-morphs-polymorphic.md](../.cursor/rules/migration-morphs-polymorphic.md)
- [.cursor/rules/migration-complete-rules.mdc](../.cursor/rules/migration-complete-rules.mdc)

*Ultimo aggiornamento: 2025-01-06*  
*Autore: Sistema di AI Learning <nome progetto>*  
*Motivazione: Comprensione profonda architettura morphs polymorphic*

