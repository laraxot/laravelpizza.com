# convertIdFromUuidToBigintIfNeeded - Metodo XotBaseMigration

## Scopo

Metodo riutilizzabile in `XotBaseMigration` per convertire la colonna `id` da UUID a bigint in tabelle legacy, aggiungendo la colonna `uuid` per identificazione esterna.

## Quando usare

- Installazioni legacy con `id` di tipo char/varchar (UUID)
- Migrazione a schema con `id` bigint autoincrement + `uuid` char(36) unique
- Tabelle con pivot correlate da aggiornare

## Firma

```php
protected function convertIdFromUuidToBigintIfNeeded(
    Closure $createNewTableSchema,
    array $dataColumns,
    array $options = []
): void
```

### Parametri

- **createNewTableSchema**: Closure che riceve `Blueprint` e definisce lo schema della nuova tabella (id bigint + uuid + colonne dati)
- **dataColumns**: Lista di nomi colonne da copiare (esclusi id, uuid)
- **options**: Array opzionale con:
  - `pivot_table`: Nome tabella pivot da aggiornare
  - `pivot_fk`: Nome colonna FK nella pivot verso la tabella principale
  - `pivot_post_update`: Closure opzionale `(ConnectionInterface $conn): void` per operazioni MySQL post-update (es. ADD UNIQUE)

## Esempio: profiles (TechPlanner)

```php
$this->convertIdFromUuidToBigintIfNeeded(
    createNewTableSchema: function (Blueprint $table): void {
        $this->profilesNewTableSchema($table);
    },
    dataColumns: [
        'user_id', 'type', 'first_name', 'last_name', 'email', 'phone', ...
    ],
    options: [
        'pivot_table' => 'profile_team',
        'pivot_fk' => 'profile_id',
        'pivot_post_update' => function (\Illuminate\Database\ConnectionInterface $conn): void {
            $conn->statement('ALTER TABLE profile_team ADD UNIQUE ...');
        },
    ]
);
```

## Regola: Profile nel main_module

Profile è strettamente dipendente dal main_module (es. TechPlanner). La migrazione `create_profiles_table` deve stare nel modulo main, non in User.

## Riferimenti

- [migration-philosophy.md](../migration-philosophy.md)
- [fix-profile-id-uuid](../../User/docs/fix-profile-id-uuid.md)
