# Bugfix — Profile `firstOrCreate()` fatal: "Field 'id' doesn't have a default value"

## Sintomo (produzione, 2026-07-27)

```
SQLSTATE[HY000]: General error: 1364 Field 'id' doesn't have a default value
insert into `profiles` (`user_id`, `uuid`, `updated_at`, `created_at`) values (...)
```

Scatenato da `XotData::getProfileModelByUserId()` → `Profile::firstOrCreate(['user_id' => ...])`,
chiamato da `XotComposer` su ogni pagina (view composer globale).

## Causa

La tabella `profiles` (connection `user`, db `workorder_user`) aveva `id` come
`char(36)` UUID primary key legacy (creata dalla prima di 5 migrazioni
`create_profiles_table.php` mai consolidate — violazione "1 model = 1 migration").
`Modules\User\Models\BaseProfile::casts()` dichiara `'id' => 'integer'` e nessun
codice generava un valore per `id` prima dell'insert: né la colonna (nessun
default/auto_increment) né il model (`booted()` genera solo `uuid`, non `id`).

## Fix

1. Consolidate le 5 migrazioni `create_profiles_table.php` in una sola,
   con `convertIdFromUuidToBigintIfNeeded()` (nuovo helper su `XotBaseMigration`)
   per convertire in sicurezza `id` da UUID legacy a `bigint` auto-increment
   (dato reale preservato via mapping, tabella era comunque vuota in questo caso).
2. Audit più ampio: qualsiasi model il cui `id` è UUID (`$table->uuid('id')->primary()`
   in migration) deve dichiarare esplicitamente `use HasUuids;` +
   `public $incrementing = false;` — altrimenti stesso fatal error al primo insert.
   Trovate e corrette 2 altre istanze identiche: `Modules\Notify\Models\NotificationTemplate`,
   `Modules\Media\Models\TemporaryUpload`. Pattern corretto già presente in
   `Modules\Gdpr\Models\{Consent,Event,Treatment}` (usato come riferimento).

## Come evitare in futuro

- Ogni volta che una migration definisce `$table->uuid('id')->primary()`, il model
  corrispondente **deve** avere `use HasUuids;` + `public $incrementing = false;`.
- Ogni volta che una migration usa `$table->id()` (bigint auto-increment), il model
  **non deve** castare `'id'` come stringa né usare `HasUuids`.
- Vedi memoria `feedback_uuid_primary_key_needs_hasuuids_trait` per la query di
  audit SQL da rilanciare periodicamente.
