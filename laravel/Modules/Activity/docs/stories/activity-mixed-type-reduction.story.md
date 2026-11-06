# Story: Riduzione uso di `mixed`: Activity

**Modulo**: Activity
**Tipo**: type-safety (best-effort, no PHPStan regression)
**Data**: 2026-09-04

## Contesto

Convenzione di progetto: "cerchiamo di non usare mixed, quando lo troviamo cerchiamo di
sostituirlo con qualcosa di adeguato" (dove possibile, non 100% coverage). Censiti 159
usi di `mixed` (nativi e docblock) in 50 file del modulo.

## Cosa ho trovato

La maggior parte dei `mixed` del modulo e' gia' giustificata:

- `@method`/`@property` generati da ide-helper su `Activity`/`StoredEvent` che
  rispecchiano le firme vendor di Eloquent (`whereDate(..., mixed $value)`, ecc.) -
  narrowing rompe la generazione automatica.
- Colonne JSON / payload genuinamente polimorfi (`properties`, `attribute_changes`,
  `changes`, snapshot `state`, factory `definition()`, `ActivityRecorder` diff/log).
- `ActivityLogger::log(mixed $user = null, ...)` (sia l'adapter reale sia il duplicato
  legacy `app/Actions/ActivityLogger.php`): verificato via test esistenti
  (`ActivityLoggerTest.php:47`, `CoverageHundredActionsTest.php:233`) che il metodo viene
  chiamato deliberatamente con valori non-`User` per testare `InvalidArgumentException` -
  e' un boundary di validazione runtime voluto, tipizzare `User|null` cambia
  l'`InvalidArgumentException` atteso in un `TypeError` prima ancora di entrare nel corpo.
- Idioma Pest `expect(fn (): mixed => ...)->toThrow(...)` (decine di occorrenze).

4 casi avevano invece un tipo reale desumibile con confidenza dal contesto immediato.

## Cosa ho fatto

Sostituiti 4 usi di `mixed` con tipi concreti, verificati contro il codice/vendor reale
(non assunti):

1. `app/Filament/Resources/ActivityResource/Pages/ListActivities.php` e
   `.../Tables/ActivitysTable.php`: `getTableColumns(): array<string, mixed>` →
   `array<string, TextColumn>`: ogni entry nell'array ritornato e' effettivamente una
   `TextColumn::make(...)`.
2. `tests/Fixtures/ListLogActivitiesNestedFormResource.php`: `canRestore(mixed $record)`
   → `canRestore(Model $record)`, allineato al contratto reale verificato in
   `Modules/Xot/app/Filament/Resources/Pages/XotBaseEditRecord.php:47`
   (`canRestore(Model $record): bool`) e al call site
   `ListLogActivities.php:172` (`$resource::canRestore($this->record)`).
3. `tests/Feature/FilamentTest.php`: `fn (mixed $action): bool => $action instanceof Action`
   → `fn (Action|ActionGroup $action): bool`, allineato al return type reale verificato in
   `vendor/filament/tables/src/Table/Concerns/HasRecordActions.php:98`
   (`getRecordActions(): array<Action|ActionGroup>`).

Un quinto tentativo (`tests/Feature/CodeQualityTest.php`, output di `exec()`) e' stato
fatto e **scartato**: PHPStan continua a vedere l'array popolato by-ref da `exec()` come
`array` generico, quindi `mixed $line` + `is_string()` resta la forma corretta -
ripristinato l'originale dopo verifica con run reale di PHPStan (non assunto a tavolino).

Non toccati, con motivazione documentata in `docs/coverage.md`: tutti i casi di payload
polimorfo, le firme ide-helper, l'`ActivityLogger` (vedi sopra), l'idioma Pest
`expect(): mixed`, e la fixture `ListLogActivitiesNonSchemaFormResource` (testa
deliberatamente una forma non conforme).

## Verifica

- PHPStan (`./vendor/bin/phpstan analyse Modules/Activity --no-progress`): 0 → 0 errori,
  nessuna regressione introdotta.
- PHPMD: crash noto su tutto il modulo (`No node to visit provided for
  visitAnonymousClass`); rieseguito sui 4 file toccati: un solo finding informativo
  pre-esistente (`UnusedFormalParameter $record`, gia' inutilizzato prima del rename di
  tipo).
- Pest: `./vendor/bin/pest Modules/Activity/tests -c Modules/Activity/phpunit.xml
  --no-coverage` fallisce con bootstrap non trovato
  (`Modules/Activity/vendor/autoload.php` non esiste: il monorepo ha un solo `vendor/`
  in `laravel/`). Difetto pre-esistente di `phpunit.xml` del modulo (file non toccato in
  questa sessione, `git status`/`git log` puliti su quel path), non imputabile a questo
  diff. Suite non eseguibile con l'invocazione canonica.

## Nota di collisione multi-agente

`git status` a inizio sessione mostrava ~150 file gia' modificati nel working tree
(quasi l'intero modulo: `app/Models/*`, `docs/*`, `tests/*`, `lang/*`), lavoro di
un'altra sessione concorrente non committato. Non toccato/discardato. Due dei quattro
file che ho modificato (`ListActivities.php`, `ActivitysTable.php`) erano gia' nella
lista dei file dirty: la loro diff pre-esistente (rispetto all'HEAD committato) rimuoveva
l'import `Filament\Tables\Columns\Column` e retrocedeva il docblock da
`array<string, Column>` a `array<string, mixed>`: compatibile e complementare con la mia
modifica (`mixed` → `TextColumn`, piu' preciso di entrambe le versioni precedenti). Non
in conflitto, nessuna sovrascrittura del lavoro altrui.

## Cosa resta da fare

- Diagnosticare e correggere `Modules/Activity/phpunit.xml` (`bootstrap` path errato) in
  una sessione dedicata: blocca completamente l'esecuzione della suite Pest del modulo.
- `tests/Unit/Filament/ListLogActivitiesPureMethodsTest.php` e
  `tests/Fixtures/ListLogActivitiesPageHarness.php` richiamano via reflection un metodo
  `toTranslationString` non piu' presente in `ListLogActivities.php`: verificare se e'
  stato rinominato dalla sessione concorrente e aggiornare i riferimenti.
- I restanti ~155 usi di `mixed` documentati come intenzionali in `docs/coverage.md`
  restano un audit trail, non un backlog da azzerare: la maggior parte e' legittimamente
  polimorfa o vincolata da firme vendor.
