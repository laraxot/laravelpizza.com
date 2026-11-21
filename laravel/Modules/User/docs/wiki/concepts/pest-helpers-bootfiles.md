---
title: Helper di dominio in tests/Helpers.php — niente require_once, niente tests/Support
description: Come User è passato da 1264 a 84 errori PHPStan restituendo i 64 helper al file che Pest 5 carica da solo.
document_type: concept
module: User
status: active
language: it-IT
updated_at: 2026-08-19
related:
  - ../../../../Xot/docs/wiki/concepts/pest5-configuring-tests.md
  - ../../testing.md
  - ../../../../../../bmad-output/stories/2.6.user-tests-helpers-bootstrap-phpstan.story.md
  - ../../../../../../docs/chat/hasxottable-rename-blocca-phpstan-2026-08-19.md
tags: [pest, pest5, phpstan, bootstrap, helpers, testing]
---

# Helper di dominio in `tests/Helpers.php`

`Modules/User` è il primo modulo del monorepo ad adottare lo strato 2 del bootstrap descritto
in [pest5-configuring-tests](../../../../Xot/docs/wiki/concepts/pest5-configuring-tests.md).
Questa pagina racconta il caso concreto, perché il numero che ne è uscito è la ragione
migliore per adottarlo anche altrove.

## Il meccanismo

`Pest\Bootstrappers\BootFiles` (vendor/pestphp/pest, righe 30-31) carica dalla test directory
esattamente due file, in quest'ordine:

```php
'Helpers.php',
'Pest.php',
```

Sono nomi cablati nel framework. Mettere gli helper di dominio in `tests/Helpers.php` non è
quindi una convenzione locale: è il posto che Pest 5 prevede. Ne discendono tre cose:

- niente `require_once` relativi fra un file di test e l'altro;
- niente `tests/Support/` (vietata: ADR-002);
- niente `autoload.files` in `composer.json`, che caricherebbe gli helper anche in runtime di
  produzione.

`Helpers.php` viene caricato **prima** di `Pest.php`, quindi il binding del TestCase può già
contare sugli helper.

## Cosa c'era prima, e cosa costava

Tre file di test contenevano una riga come questa:

```php
require_once __DIR__.'/../Support/team-management-helpers.php';
```

La cartella `tests/Support/` è stata cancellata dal working tree in applicazione di ADR-002,
ma i 64 helper che ci vivevano non erano stati spostati da nessuna parte. Il risultato, letto
da PHPStan su `Modules/User`:

| identificatore | occorrenze |
|---|---|
| `function.notFound` | 460 (su 51 nomi distinti) |
| `method.nonObject` | 220 |
| `property.nonObject` | 220 |
| `offsetAccess.nonArray` | 44 |
| `cast.string` | 41 |
| **totale modulo** | **1264** |

La cascata dopo la prima riga è automatica e va capita bene, perché è il motivo per cui non
si correggono questi errori uno per uno: una funzione che PHPStan non conosce ha tipo di
ritorno `mixed`, quindi `[$owner, $member, $team] = teamMgmtBootstrap();` produce un
`offsetAccess.nonArray`, poi `$owner->id` un `property.nonObject`, poi `$team->users()->count()`
un `method.nonObject`. Un solo file mancante, quattro identificatori diversi, 984 errori
derivati. È il caso da manuale della regola «`mixed` è l'ultima spiaggia: risali alla
sorgente».

Dopo il ripristino in `tests/Helpers.php`: **84 errori**, nessuno dei quali `function.notFound`.

## Come sono stati ripristinati

Gli helper non sono stati riscritti: erano già interamente tipizzati in `HEAD`, e riscriverli
avrebbe significato inventare firme diverse dall'originale. Sono stati estratti con
`token_get_all()` dai cinque file cancellati (`helpers.php`, `helpers-core.php`,
`helpers-extended.php`, `team-management-helpers.php`,
`team-management-business-helpers.php`), deduplicati per nome — `helpers.php` è di fatto
l'unione di `helpers-core` e `helpers-extended`, quindi le collisioni erano attese — e
concatenati in un solo file con gli `use` uniti e ordinati.

Le uniche modifiche di merito rispetto all'originale riguardano tre `mixed` che non
sopravvivevano a `level: max`:

```php
// prima
return config('permission.table_names.model_has_roles', 'model_has_role');
// dopo
return Config::string('permission.table_names.model_has_roles', 'model_has_role');
```

```php
// prima
$secret = (string) decrypt($user->two_factor_secret);
// dopo
$secret = decrypt($user->two_factor_secret);
if (! is_string($secret)) {
    return false;
}
```

`Config::string()` è già la convenzione del monorepo (`Modules/UI`, `Modules/Media`,
`Modules/Xot` la usano). Il cast su `decrypt()` era invece un `(string) mixed`: un cast non
restringe niente, sposta solo il problema a runtime.

## Strato 3 — il binding del TestCase

`Modules/User/tests/Pest.php` contiene ora solo il legame con il TestCase concreto del modulo:

```php
pest()->extend(\Modules\User\Tests\TestCase::class)->in('.');
```

Con `pestphp/pest-plugin-phpstan` v5 registrato da `phpstan/extension-installer` questa forma
non produce più `method.internalClass`: il divieto che circolava nei commenti di alcuni
`Pest.php` è decaduto il 2026-08-19, quando il plugin è entrato in `GeneratedConfig.php`.

## Come si esegue

Gli helper vengono caricati solo se Pest riceve la test directory del modulo — `BootFiles`
costruisce il percorso come `rootPath . '/' . testDirectory()`, e `rootPath` è `laravel/`:

```bash
cd laravel
./vendor/bin/pest --test-directory=Modules/User/tests
```

Senza `--test-directory` viene caricato solo `laravel/tests/Pest.php` e gli helper del modulo
restano codice morto a runtime — pur restando visibili a PHPStan, che analizza tutto
`Modules/`. È la stessa trappola documentata nella story 2.5 per `Modules/Media`.

## Da rifare altrove

Gli stessi `function.notFound` orfani restano, alla data di questa pagina, in altri moduli:
`mediaTableRecordActions` e `runFileExtensionRule` (Media), `notificationsCoverageTicketModel`
(Notify), `safeEloquentCastFixture` e `xotBaseTransitionFixture` (Xot). La ricetta è questa,
identica.
