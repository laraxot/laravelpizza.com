# Fix: Duplicate Entry Error in team_user Table - Conversione UUID a Autoincrement

## Data Intervento
**2025-01-22** - Conversione PRIMARY KEY da UUID a autoincrement nella tabella pivot team_user

## Problema Identificato

Errore: `SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '' for key 'PRIMARY'` quando si cerca di associare un team a un utente tramite `AttachAction` di Filament.

### Causa Radice

La tabella `team_user` ha `id` come PRIMARY KEY di tipo UUID (`char(36)`), ma quando Filament `AttachAction` cerca di inserire un nuovo record, Laravel non genera automaticamente l'UUID perché il modello `Membership` ha `$incrementing = true` (default da `BasePivot`), causando un conflitto:

```php
// ❌ ERRATO - Prima della correzione
class Membership extends BasePivot
{
    // $incrementing = true (default da BasePivot)
    // $keyType = 'string' (default da BasePivot)
    // Ma la tabella ha id UUID che richiede generazione manuale
}
```

Quando Filament `AttachAction` cerca di inserire un nuovo record nella tabella pivot, Laravel non genera automaticamente l'UUID perché `$incrementing = true` indica che l'ID è auto-incrementale (tipicamente per `bigint`), non per UUID.

### Stack Trace

L'errore si verificava in:
- `vendor/filament/actions/src/AttachAction.php:90`
- Durante l'inserimento di un nuovo record nella tabella `team_user`
- Quando si cercava di associare un team a un utente tramite RelationManager

## Soluzione Implementata

### 1. Migrazione per Conversione UUID a Autoincrement

Creata nuova migrazione `2025_01_22_120000_create_team_user_table.php` che gestisce sia la creazione che l'aggiornamento della tabella:

```php
// ✅ CORRETTO - Migrazione con conversione UUID → autoincrement
public function up(): void
{
    // -- CREATE --
    $this->tableCreate(static function (Blueprint $table): void {
        $table->id();  // ← bigint autoincrement
        $table->foreignId('team_id');
        $table->uuid('user_id')->nullable()->index();
        $table->string('role')->nullable();
        $table->unique(['team_id', 'user_id']);
    });

    // -- UPDATE --
    $this->tableUpdate(function (Blueprint $table): void {
        // Se la tabella esiste già con id UUID, convertiamo a autoincrement
        if ($this->hasColumn('id') && in_array($this->getColumnType('id'), ['string', 'guid'], true)) {
            // Rimuoviamo la PRIMARY KEY esistente
            $this->dropPrimaryKey();

            // Se non esiste già, rinominiamo id a uuid per preservare i dati
            if (! $this->hasColumn('uuid')) {
                $this->renameColumn('id', 'uuid');
            }

            // Aggiungiamo la nuova colonna id come bigint autoincrement
            if (! $this->hasColumn('id')) {
                $table->id()->first();
            }

            // Impostiamo la nuova PRIMARY KEY su id
            $this->query('ALTER TABLE `'.$this->table_name.'` ADD PRIMARY KEY (`id`)');
        }

        // Aggiorniamo i timestamp e soft deletes
        $this->updateTimestamps($table, true);

        // Aggiungiamo l'indice univoco se non esiste
        // ...
    });
}
```

### 2. Correzione del Modello Membership

Aggiornato il modello per usare autoincrement invece di UUID:

```php
// ✅ CORRETTO - Dopo la correzione
class Membership extends BasePivot
{
    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';  // ← Cambiato da 'string' a 'int'

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',  // ← Cast a integer invece di string
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
```

### 3. Correzione PHPDoc

Corretto il tipo di `$id` da `string` a `int` nel PHPDoc:

```php
// ❌ ERRATO
 * @property string $id

// ✅ CORRETTO
 * @property int $id
```

## Struttura Tabella team_user (Dopo la Correzione)

La tabella avrà la seguente struttura dopo la migrazione:

```sql
CREATE TABLE `team_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `team_id` bigint unsigned DEFAULT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

## File Modificati

1. **`laravel/Modules/User/database/migrations/2025_01_22_120000_create_team_user_table.php`**
   - Nuova migrazione per gestire conversione UUID → autoincrement
   - Gestisce sia creazione che aggiornamento della tabella
   - Preserva i dati esistenti rinominando `id` a `uuid`

2. **`laravel/Modules/User/app/Models/Membership.php`**
   - Impostato `$keyType = 'int'` per usare autoincrement
   - Corretto cast di `id` da `string` a `integer`
   - Corretto PHPDoc per `$id` da `string` a `int`

## Filosofia delle Migrazioni Laraxot

Questa correzione segue la filosofia delle migrazioni Laraxot:

1. **NON creare nuove migrazioni separate per modifiche**: La migrazione gestisce sia creazione che aggiornamento
2. **COPIARE la migrazione originale con nuovo timestamp**: Basata su `2023_01_01_000006_create_team_user_table.php`
3. **Verificare sempre l'esistenza**: Usa `hasColumn()`, `getColumnType()`, ecc.
4. **Preservare i dati**: Rinominando `id` a `uuid` per mantenere i dati esistenti

## Verifica

- ✅ PHPStan livello 10 passa senza errori
- ✅ La migrazione gestisce correttamente sia creazione che aggiornamento
- ✅ Il modello usa correttamente autoincrement per `id`
- ✅ `AttachAction` di Filament funziona correttamente senza errori di constraint violation

## Prevenzione Errori Futuri

### Pattern Corretto per Modelli Pivot con Autoincrement

Quando si crea un modello pivot che usa autoincrement come PRIMARY KEY:

1. **Impostare `$keyType = 'int'`**:
   ```php
   protected $keyType = 'int';
   ```

2. **Mantenere `$incrementing = true`** (default):
   ```php
   public $incrementing = true;  // Default da BasePivot
   ```

3. **Correggere cast**:
   ```php
   protected function casts(): array
   {
       return [
           'id' => 'integer',  // ← Non 'string'!
           // ...
       ];
   }
   ```

4. **Correggere PHPDoc**:
   ```php
   /**
    * @property int $id  // ← Non string!
    */
   ```

## Collegamenti

- [Membership Model](../../app/Models/Membership.php)
- [BasePivot Model](../../app/Models/BasePivot.php)
- [TeamsRelationManager](../../app/Filament/Resources/UserResource/RelationManagers/TeamsRelationManager.php)
- [HasTeams Trait](../../app/Models/Traits/HasTeams.php)
- [Migration Rules](../../../Xot/docs/migrations-consolidated.md)

*Ultimo aggiornamento: gennaio 2025*
