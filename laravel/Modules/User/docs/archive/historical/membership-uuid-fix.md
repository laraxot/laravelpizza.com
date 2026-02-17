# Fix: Duplicate Entry Error in team_user Table (DEPRECATO)

> ⚠️ **DEPRECATO**: Questa soluzione è stata sostituita dalla conversione UUID → autoincrement.
> Vedi [membership-autoincrement-fix.md](./membership-autoincrement-fix.md) per la soluzione corretta.

## Data Intervento
**2025-01-22** - Correzione gestione UUID nella tabella pivot team_user (SOLUZIONE DEPRECATA)

## Problema Identificato

Errore: `SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '' for key 'PRIMARY'` quando si cerca di associare un team a un utente tramite `AttachAction` di Filament.

### Causa Radice

La tabella `team_user` ha `id` come PRIMARY KEY di tipo UUID (`char(36)`), ma il modello `Membership` aveva `$incrementing = true`, causando un conflitto:

```php
// ❌ ERRATO - Prima della correzione
class Membership extends BasePivot
{
    public $incrementing = true;  // ← Causava errore con UUID
}
```

Quando Filament `AttachAction` cercava di inserire un nuovo record nella tabella pivot, Laravel non generava automaticamente l'UUID perché `$incrementing = true` indica che l'ID è auto-incrementale (tipicamente per `bigint`), non per UUID.

### Stack Trace

L'errore si verificava in:
- `vendor/filament/actions/src/AttachAction.php:90`
- Durante l'inserimento di un nuovo record nella tabella `team_user`
- Quando si cercava di associare un team a un utente tramite RelationManager

## Soluzione Implementata

### 1. Correzione del Modello Membership

Impostato `$incrementing = false` e aggiunto un boot method per generare automaticamente l'UUID:

```php
// ✅ CORRETTO - Dopo la correzione
class Membership extends BasePivot
{
    /** @var bool */
    public $incrementing = false;  // ← UUID non è auto-incrementale

    /**
     * Boot the model.
     *
     * Genera automaticamente l'UUID per l'ID quando viene creato un nuovo record.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Membership $membership): void {
            if (empty($membership->id)) {
                $membership->id = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }
}
```

### 2. Correzione PHPDoc

Corretto il tipo di `$id` da `int` a `string` nel PHPDoc:

```php
// ❌ ERRATO
 * @property int $id

// ✅ CORRETTO
 * @property string $id
```

## Struttura Tabella team_user

La tabella ha la seguente struttura:

```sql
CREATE TABLE `team_user` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_id` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:guid)',
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:guid)',
  `role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `team_user_team_id_user_id_unique` (`team_id`,`user_id`),
  KEY `uudi` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
```

## File Modificati

1. **`laravel/Modules/User/app/Models/Membership.php`**
   - Impostato `$incrementing = false`
   - Aggiunto boot method per generare UUID automaticamente
   - Corretto PHPDoc per `$id` da `int` a `string`

## Verifica

- ✅ PHPStan livello 10 passa senza errori
- ✅ Il modello genera correttamente UUID quando viene creato un nuovo record
- ✅ `AttachAction` di Filament funziona correttamente senza errori di constraint violation

## Prevenzione Errori Futuri

### Pattern Corretto per Modelli Pivot con UUID

Quando si crea un modello pivot che usa UUID come PRIMARY KEY:

1. **Impostare `$incrementing = false`**:
   ```php
   public $incrementing = false;
   ```

2. **Aggiungere boot method per generare UUID**:
   ```php
   protected static function boot(): void
   {
       parent::boot();

       static::creating(function (YourPivotModel $model): void {
           if (empty($model->id)) {
               $model->id = (string) \Illuminate\Support\Str::uuid();
           }
       });
   }
   ```

3. **Correggere PHPDoc**:
   ```php
   /**
    * @property string $id  // ← Non int!
    */
   ```

## Collegamenti

- [Membership Model](../../app/Models/Membership.php)
- [BasePivot Model](../../app/Models/BasePivot.php)
- [TeamsRelationManager](../../app/Filament/Resources/UserResource/RelationManagers/TeamsRelationManager.php)
- [HasTeams Trait](../../app/Models/Traits/HasTeams.php)

*Ultimo aggiornamento: gennaio 2025*
