---
title: "Teams — owner_id: fold-in fix (no separate add_* migration)"
type: concept
tags: [migration, teams, owner-id, xotbase-migration-religion]
created: 2026-07-27
updated: 2026-07-27
qmd: "teams owner_id migration violation add_owner_id_to_teams_table fold create_teams_table"
related:
  - "../../Xot/docs/wiki/concepts/xotbase-migration-religion.md"
  - "../../../../docs/wiki/concepts/xotbase-migration-religion.md"
---

# Teams — `owner_id`: fold-in fix

## Cosa c'era di sbagliato

`Modules/User/database/migrations/2025_05_16_221811_add_owner_id_to_teams_table.php`
violava la [religione XotBaseMigration](../../Xot/docs/wiki/concepts/xotbase-migration-religion.md):
una migrazione separata per aggiungere una colonna a una tabella che ha già il suo
`create_teams_table.php`. Inoltre il codice stesso conteneva un bug funzionale:
`foreignIdFor(Team::class, 'owner_id')` — riferiva `Team::class` invece di `User::class`
per una colonna che semanticamente rappresenta il proprietario (`User`) del team
(vedi `@property User|null $owner` in `Modules/User/app/Models/Team.php`).

## Correzione applicata

`owner_id` vive ora in `Modules/User/database/migrations/*_create_teams_table.php`,
dentro `tableCreate()` (colonna nuova) **e** `tableUpdate()` (idempotente per chi ha
già la tabella senza la colonna), usando la classe utente dinamica invece di
hardcodare `User`:

```php
$userClass = XotData::make()->getUserClass();

$table->foreignIdFor($userClass, 'owner_id')->nullable()->index();
```

Il vecchio file `add_owner_id_to_teams_table.php` non esiste più. Nessun `$connection`
dichiarato sulla migrazione (non serve — la connection arriva dal model).

## Perché non un `protected ?string $connection = 'user'`

Alcune note storiche in questa cartella (ora superate) raccomandavano di dichiarare
esplicitamente `$connection` sulla migrazione. **Non è la convenzione di questo
progetto**: la connection/tabella si ricavano dal `$model_class`, non da proprietà
duplicate sulla migrazione — vedi la religione XotBaseMigration linkata sopra.

## Riferimento

Skill: `xotbase-migration-religion`. Canon: `Modules/Xot/docs/wiki/concepts/xotbase-migration-religion.md`.
