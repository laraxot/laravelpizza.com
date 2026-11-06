---
title: "[DEV] PHPStan cleanup modulo Cms"
type: dev
status: done
created: 2026-10-06
updated: 2026-10-06
tags: [cms, phpstan, tests, enum, lang]
related:
  - ./phpstan-cleanup-cms.story.md
---

# [DEV] PHPStan cleanup modulo Cms

## Technical Plan

1. Per ogni file: leggere cosa deve fare, `grep` dei chiamanti, `git log -S` per capire se la variabile "mai letta" era logica persa.
2. Codice di produzione: correggere la funzionalita' (fallback email), rimuovere solo il codice davvero morto, tipizzare.
3. Test: ogni `$x = ...` mai letto diventa un'asserzione di comportamento verificabile **leggendo il codice** (i test non sono eseguibili qui).
4. Enum: nessuna costante di insieme di valori nel gruppo; l'enum esistente (`AttachmentDiskEnum`) aveva traduzioni mancanti.
5. Docs: write-back in `docs/actions/page-resolution-pipeline.md` e indice.

## Files to Modify

Produzione (`app/`): `Actions/BuildPageSchemaAction.php`, `Support/PageSchemaBuilder.php` (duplicato, stessa correzione),
`Models/Policies/CmsBasePolicy.php`, `Providers/FolioVoltServiceProvider.php`, `Models/Menu.php`, `docs/config.php`.
Lang nuovi: `lang/{it,en,de}/attachment_disk_enum.php`.
Test (`tests/`): `PestStubs.php`, 8 `Feature/Frontoffice/FolioRoutes/*`, `Feature/Auth/{LoginHttpTest,LoginVoltComponentTest,logintest,loginvolttest}`,
`Feature/{CmsContentManagementTest,FilamentBuilderBlocksTest}`, e ~28 file in `Unit/` (Actions, Enums, Filament, Http, Middleware, Models, Providers, Support, View).

## Implementation Steps

- [x] `BuildPageSchemaAction` + `PageSchemaBuilder`: `$email = '' !== trim($publicEmail) ? trim($publicEmail) : trim($profileEmail)`
- [x] `CmsBasePolicy`: rimossi `$xotData` e `use XotData`
- [x] `FolioVoltServiceProvider`: rimosso `$defaultLocale` morto
- [x] `Menu`: `@implements HasRecursiveRelationshipsContract<Model>`, call senza `@var`
- [x] `app/docs/config.php`: helper `pageStringCall`/`pageProperty`/`docsEnv`, closure `static` tipizzate
- [x] `lang/{it,en,de}/attachment_disk_enum.php` (chiavi `values.<case>.{label,color,icon,description}`)
- [x] `HasBlocksTest`: modelli reali al posto delle anonymous class
- [x] `PestStubs`: parametri usati nel messaggio dell'eccezione
- [x] Test: asserzioni al posto di variabili inutilizzate (route Folio: stato accettabile + skip su 5xx; login: `assertAuthenticatedAs($user)`; azioni; enum; provider; composer; policy)
- [x] Write-back docs + indice

## Testing

**Pest NON eseguito.** `phpunit.xml` forza sqlite `:memory:`, ma `Modules\Cms\Tests\TestCase` usa `DatabaseTransactions` sulla connessione `user`
e `.env.testing` punta a MySQL (`techplanner_data_test`): per la regola "DB sacri" non si lanciano. Le asserzioni nuove sono state scritte
solo su comportamenti verificabili dalla lettura del codice (es. `Page::getMiddlewareBySlug()` -> `[]`, `GetCmsViewAction` -> `Exception('View not found: ...')`).
Da eseguire in CI/ambiente con sqlite: `cd laravel && ./vendor/bin/pest Modules/Cms/tests`.

## Verification

```bash
cd /mnt/nas07/var/www/_bases/base_techplanner_fila5/laravel
./vendor/bin/phpstan analyse Modules/Cms --memory-limit=-1 --no-progress   # [OK] No errors
php -l <file toccati>                                                        # nessun errore di sintassi
# smoke manuale di app/docs/config.php (closure) con php -r + vendor/autoload.php: OK
```

## Lessons Learned

- "Variabile mai letta" in un test = quasi sempre test senza asserzione. PHPStan (con pest-plugin-phpstan) segnala poi anche le asserzioni **ridondanti**
  (`assertIsString` su `string`, `toBeArray` su `array`): asserire sul valore, non sul tipo.
- Errori "in context of anonymous class" dentro un trait = effetto delle `new class extends Model { use Trait; }` nei test: usare i modelli reali.
- `$x` calcolato e mai usato in produzione: fare `git log -S'$x'` prima di cancellarlo. `$profileEmail` era un fallback perso nel refactor.
- Un enum con `EnumTrait` senza file lang mostra `fix:<chiave>` in UI: l'errore PHPStan sui test dell'enum nascondeva traduzioni mancanti.
- Un `@implements Contratto<Sottoclasse>` rende invariante il passaggio a un'action che accetta `<Model>`; la correzione vera sta nel template dell'action (Xot), non in un `@var`.
- PHPUnit 12: `assertContainsOnly()` non esiste, usare `assertContainsOnlyArray()`.

## Fuori scope / da segnalare

- `app/Support/PageSchemaBuilder.php` duplica `app/Actions/BuildPageSchemaAction.php` (usato da `Metatags`); `PageSchemaBuilder` risulta senza chiamanti: non toccato oltre al fix.
- `tests/Unit/{dashboardtest,exampletest}.php` e `tests/Feature/Auth/{logintest,loginvolttest}.php` (minuscolo) non finiscono nel pattern `*Test.php`: probabili duplicati orfani di `DashboardTest.php`/`LoginTest.php`/`ExampleTest.php`.
- `app/docs/config.php` e' un config Jigsaw dentro `app/` (cartella PSR-4): fuori posto, la copia canonica e' `Themes/docs/shared-components/config-Modules.php`. Non spostato.
- `Xot\Actions\Tree\GetTreeOptionsByModelClassAction::execute()` dovrebbe essere generico (`@template TModel of Model`) invece di `class-string<...<Model>>`.
- Esiste `docs/bmad/stories/` accanto a `docs/stories/` (creata come da brief).
