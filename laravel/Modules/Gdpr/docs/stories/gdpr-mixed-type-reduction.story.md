---
title: "gdpr mixed type reduction.story"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "gdpr mixed type reduction.story"
issues: []
discussions: []
---

# Story: Reduce mixed type usage — Gdpr

**Fase BMAD**: Qualita del codice (type-safety), nessuna modifica di comportamento applicativo.

**Contesto**: convenzione di progetto ("cerchiamo di non usare mixed, quando lo troviamo cerchiamo di
sostituirlo con qualcosa di adeguato"). Il modulo Gdpr aveva 21 occorrenze di `mixed` in 11 file, tutte
in PHPDoc (nessun type-hint nativo `mixed` in firma di metodo).

**Analisi**: per ciascuna occorrenza e' stato verificato l'uso reale del valore nel codice circostante
(construction letterale dell'array nei chiamanti, forma dei dati ritornati da una Action).

**Modifiche applicate** (solo PHPDoc, zero modifica a codice eseguibile):
- `app/Actions/Validation/ValidateUserDataAction.php`: `@param array<string, mixed> $formData`
  (ripetuto 3 volte per errore) unificato in un solo `@param array<string, string> $formData` — i due
  chiamanti (`RegisterWidget::submit()`, `GdprConsentForm::submit()`) costruiscono sempre l'array con
  valori stringa letterali. Il `@return` resta `array<string, mixed>`: e' stato tentato uno shape
  `array{first_name: string, ..., email_verified_at: Carbon}` ma introduceva 6 nuovi errori PHPStan nei
  test (`offsetAccess.notFound` su `$validatedData['state']`, mai presente nel valore di ritorno reale —
  bug pre-esistente nei test, non nel diff; `nullCoalesce.unnecessary` su `?? null` ridondanti). Cambio
  di ritorno **revertito** per non introdurre errori e non toccare test fuori scope.
- `app/Filament/Widgets/Auth/RegisterWidget.php` e `GdprConsentForm.php`:
  `logRegistrationAttempt(array $formData)` → `@param array<string, string> $formData` (stessa
  evidenza: costruzione letterale con soli valori stringa).
- `database/factories/ConsentFactory.php`, `EventFactory.php`: `definition(): array` →
  `@return array<string, string>` (tutti i valori letterali nell'array sono stringhe).
- `database/factories/TreatmentFactory.php`: `definition(): array` →
  `@return array<string, bool|int|string>` (name/description stringa, weight int, active/required bool).

**Lasciato `mixed` (motivato)**:
- `tests/TestCase.php` (`assertDatabaseHasRow`/`assertDatabaseMissingRow`), `tests/PestHelpers.php`
  (`gdprPost`, `gdprArtisan`, `assertGdprTableHas/Missing`, `createGdprConsent`): helper di test
  generici, riusati con shape diverse in ogni test — payload volutamente polimorfico.
- `app/Models/Profile.php` (`@method childrenWith/childrenWithCount(array<int|string, mixed> $relations)`):
  docblock IDE-helper che rispecchia la firma vendor Eloquent `with()`/`withCount()` — mimica di
  contratto di framework, non va ristretta.
- `app/Models/Traits/HasGdpr.php` (`giveConsent(..., array $metadata = [])`): nessun chiamante nel
  modulo passa metadata concreti (verificato via grep su app/ e tests/); e' un payload di audit
  volutamente estensibile per chi usa il trait — polimorfico per design.
- `app/Datas/GdprData.php` (`@var array<string, mixed> $data`): il valore arriva da
  `Modules\Tenant\Actions\Config\GetTenantConfigArrayAction::execute()`, che dichiara essa stessa
  `array<string, mixed>` perche' legge un file di config PHP arbitrario — corrisponde esattamente al
  tipo della Action esterna chiamata.

**Fix collaterale necessario per la verifica**: `phpunit.xml` del modulo aveva
`bootstrap="vendor/autoload.php"` (percorso relativo al file, ma `Modules/Gdpr/vendor/` non esiste in
questo monorepo) — la suite non partiva affatto. Corretto in `bootstrap="../../vendor/autoload.php"`,
stesso pattern gia' documentato e verificato in `Modules/Notify/phpunit.xml`.

**Verifica**:
- PHPStan (`./vendor/bin/phpstan analyse Modules/Gdpr --no-progress --error-format=table`): 0 errori
  prima, 0 errori dopo.
- PHPMD (`./tools/phpmd.sh Modules/Gdpr text ../docs/phpmd.ruleset.xml`): crash noto
  (`No node to visit provided for visitAnonymousClass`), non imputabile a questo diff (nessuna
  anonymous class toccata).
- Pest (`./vendor/bin/pest Modules/Gdpr/tests -c Modules/Gdpr/phpunit.xml --no-coverage`, dopo il fix
  del bootstrap): 167 passed, 69 failed, 3 risky, 10 skipped (639 assertions). Tutti i 6 file PHP con
  modifiche applicative in questa story contengono **solo** cambi di PHPDoc (verificato via `git diff`),
  quindi nessuno dei 69 fallimenti puo' essere causato da questo diff. Cause osservate: bug
  pre-esistente (`$validatedData['state']` mai impostato da `ValidateUserDataAction::execute()` ma
  atteso dai test), collisioni su vincoli unique nel DB MySQL condiviso di test (`treatments_name_unique`),
  risposte 500 su rotte di registrazione — coerenti con l'ambiente di test noto e non deterministico
  (vedi memoria `env-sqlite-manca-suite-non-eseguibile`).

**Dettaglio numerico**: 21 occorrenze di `mixed` trovate in 11 file; 8 sostituite/ristrette in 6 file
(1 param narrowing consolidato da 3 righe duplicate a 1); 13 lasciate invariate con motivazione in 5 file.
