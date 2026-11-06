---
title: SushiToJsons dopo il commit 33465888 - variabili morte, dddx e cartella mancante
status: review
owner: Tenant
created: 2026-10-29
related:
  - ./7.1.phpstan-sushi-boundaries.story.md
  - ../../../../../bashscripts/ai/wiki/rules/debugging-rules.md
  - ../../../../../bashscripts/ai/wiki/rules/recuperare-codice-cancellato-prima-di-riscriverlo.md
  - ../../../Xot/docs/stories/xot-docs-archive-php-old-suffix.story.md
---

# SushiToJsons dopo il commit 33465888

## Fase BMAD

Dev, correzione di errori PHPStan dopo il pull dei sottomoduli (2026-10-29).

## Problema

Il pull porta in Tenant il commit upstream `33465888` (2026-10-28, messaggio "."). Il commit
riscrive `collectRowsFromJsonFiles()` in `app/Models/Traits/SushiToJsons.php`: prima leggeva
piu' sorgenti (cartella del tenant, `Themes/Sixteen`, baseline dei moduli), ora legge solo la
cartella del tenant. La riscrittura e' rimasta a meta'.

PHPStan da' 4 errori, ripetuti per 8 classi che usano il trait (32 in tutto):

| Riga | Errore |
|------|--------|
| 112 | `$tenantName` mai letta (`variable.unused`) |
| 120 | `$failed[]` mai letto (`assign.unused`) |
| 136 | `$key` mai letta (`variable.unused`) |
| 141 | `array_values()` su una lista (`arrayValues.list`) |

Le variabili servivano alla versione a piu' sorgenti e non servono piu'.

## Regressioni trovate nello stesso commit

1. **Due `dddx($file)` in `mapJsonFileToRow()`.** Bloccano tutto il processo quando un file non
   e' JSON valido o il modello non ha `$schema`. Prima la funzione restituiva `null` e il file
   veniva saltato. Prova: `tests/Unit/TenantGapsCoverageTest.php` si ferma al test
   "SushiToJsons covers empty schema map..." con il dump di `SushiToJsons.php:181`, e i test
   successivi non girano.
2. **Manca il controllo `File::isDirectory($path)`.** `File::allFiles()` su una cartella che non
   esiste lancia `DirectoryNotFoundException`. Prima la cartella mancante dava zero righe.
   Prova in locale (2026-10-29): `(new Menu)->getSushiRows()` e `(new Page)->getSushiRows()`
   di Cms lanciano l'eccezione, perche' in questo progetto non esiste nessuna cartella
   `database/content`.

## Decisione

- Si toglie `dddx`: la regola [debugging-rules](../../../../../bashscripts/ai/wiki/rules/debugging-rules.md)
  dice che i dump di debug vanno rimossi prima del commit.
- Si rimette il controllo `File::isDirectory()` della versione `493af8b1`, adattato alla sola
  sorgente: cartella mancante, zero righe. Regola
  [recuperare-codice-cancellato](../../../../../bashscripts/ai/wiki/rules/recuperare-codice-cancellato-prima-di-riscriverlo.md).
- Si tolgono le variabili morte (`$tenantName` con il suo `use`, `$failed`, `$id`/`$key`) e
  `array_values()`.
- Si mantiene la scelta upstream di una sola sorgente. Non si rimettono `Themes/Sixteen` e le
  baseline dei moduli: nessun test le copre e in questo progetto quelle cartelle non esistono.

- PHPMD segnalava `$slugOwners` non definita e non usata: il commit upstream aveva tolto anche
  l'inizializzazione. Rimessa la riga `$slugOwners = [];` della versione `493af8b1`.

## Lasciato com'e'

Il controllo `$slugOwners` sullo slug ora confronta sempre la stessa cartella, quindi non scarta
mai niente. Non e' un errore e dipende da come l'upstream vuole chiudere la riscrittura.

## Verifica (2026-10-29)

- `php -l`: nessun errore. Pint `--test`: passed (la versione upstream falliva con 6 fixer).
- PHPMD (`tools/phpmd.sh ... ../docs/phpmd.ruleset.xml`): nessun finding. Prima: 4
  (`$tenantName`, `$key`, `$slugOwners` due volte).
- PHPStan, `./vendor/bin/phpstan analyse` da `laravel/`: **0 errori in Tenant**, totale da 54 a 22
  (Geo 20, Limesurvey 1, Media 1).
- PHPInsights (diagnostico) sul file: da 13 finding a 9. Tolti i 2 `Unused variable`, un
  `Inline doc comment declaration` e `Binary operator spaces`. I 9 rimasti c'erano gia'
  (complessita' del trait, 2 `@var` inline, lunghezza riga 125, spaziature di doc comment e `use`).
- Pest (cache di `bootstrap/cache` saltata con `APP_*_CACHE`): `SushiToJsonsTest` 4/4, e in
  `TenantGapsCoverageTest` e `TenantStatementCoverageTest` i due test di `SushiToJsons` passano.
  Prima la suite si fermava al dump di `SushiToJsons.php:181`.
- Tinker in locale: `Menu` e `Page` di Cms danno 0 righe invece dell'eccezione.

## Fuori scope, gia' rotto prima

4 test falliscono su `SushiToJson.php` (singolare), un altro trait: cercano per reflection
`maxIdFromRows()`, `applyAuditFields()`, `maxIdFromDatabase()`, che il trait non ha piu', e uno
riceve `null` a `SushiToJson.php:64`. Prima di questa modifica non giravano nemmeno, perche' il
`dddx` fermava il processo prima.

## Test aggiunto dopo la revisione sulle linee guida (2026-10-29)

La revisione richiesta dall'utente ha trovato un buco: nessun test copriva il controllo `File::isDirectory()` rimesso
(pilastro 10 e workflow dei bugfix: test per il codice modificato). Aggiunto in `tests/Unit/Traits/SushiToJsonsTest.php`
"returns empty rows when json directory does not exist", accanto al test sulla cartella vuota.

Il test e' scritto dopo la correzione: farlo fallire sul codice di `33465888` richiederebbe di riportare indietro il file,
e git va solo in avanti. Il fallimento con quel codice e' gia' provato sopra (tinker su `Menu` e `Page` di Cms:
`DirectoryNotFoundException`). Esito: `SushiToJsonsTest` 5 passati, 8 asserzioni; PHPStan, Pint e PHPMD puliti sul file.
