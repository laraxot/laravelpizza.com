---
title: "Xot - phpstan-status.md"
module: Xot
bmad: true
status: active
---
# PHPStan Status — Xot

Stato vivo del gate. Non copiare numeri da report storici: rimisura.

## Misura 2026-10-06 (sera) — swarm Xot/app: scopo prima dell'errore

`analyse Modules/Xot/app`: 147 segnalazioni del file errori -> **21**, tutte
`classConstant.nativeTypeNotSupported`: `laravel/composer.json` dichiara `"php": "^8.2"`,
PHPStan assume 8.2 e rifiuta le costanti di classe con tipo nativo (PHP 8.3), mentre il
runtime e' 8.4 e il `HEAD` le ha gia' tipizzate. Si esce solo con `require.php: ^8.3`
(decisione dell'utente). Senza tipi si ritorna a `typeCoverage.constantTypeCoverage`.

Orfane che erano logica tolta, non rumore: `RelationX::morphToManyX()` (prefisso
`database.tabella` del pivot cross-database, tolto il 2026-09-03 per un `variable.unused`),
`RouteService::urlAct()` (nome route letto dopo l'uso), `extractBelongsToRelations()`
(non popolava `$data`), `--type` di `xot:analyze-components` (mai applicato).
Gli errori `HasXotTable` "in context of class@anonymous" erano result-cache stale.
Dettaglio e lezioni: [dev-story](../stories/2026-10-06-phpstan-cleanup-xot-app.dev.md).

## Misura 2026-10-06 (notte) — swarm Xot/rest: test, helpers, stub Pest

`analyse Modules`: 87 segnalazioni del file errori -> **0** in `Modules/Xot/{tests,helpers}`.
12 erano result-cache stale (`iterableValue` su classi anonime con PHPDoc presente);
20 erano test segnaposto con la variabile non letta (asserzione persa: ora asseriscono il
comportamento del titolo); 53 erano parametri inutilizzati degli stub Pest
(`helpers/Helper.php`, `tests/PestStubs.php`: firme invariate, ora passano nome e argomenti a
`xotPestStubFailure()`); 2 di fixture (`SendMailByRecordActionTest`: classe anonima annidata
senza PHPDoc risolto -> classe nominata). Pest non eseguito (`.env.testing` = MySQL).
Da decidere: `tests/PestStubs.php` e' orfano ma e' lui a risolvere `Pest\Laravel\*` per PHPStan.
Dettaglio e lezioni: [dev-story](../stories/2026-10-06-phpstan-cleanup-xot-rest.dev.md).

## Misura 2026-10-06 — EnsureKeysAction + file scratch rimossi

`analyse Modules/Xot` dopo il sync delle sub-repository (`64a28f945`): **4** errori, ora **0**.

- `app/Actions/Arr/ScratchNarrowingTest.php` e `ScratchNarrowingTest2.php` (3 errori):
  classi di prova sul narrowing di `Assert`, mai referenziate, arrivate col sync dentro
  `app/`. **Cancellate**, non corrette: è codice morto, stessa logica di
  [phpstan-no-probes-rule](../../../../../bashscripts/ai/wiki/rules/phpstan-no-probes-rule.md)
  ("rimuovere codice morto non referenziato").
- `app/Actions/Arr/EnsureKeysAction.php` (`return.type`): `Arr::map()` di Laravel non ha
  tipo di ritorno generico, quindi il risultato era `array` nudo. Sostituito con un
  `foreach` che costruisce l'array tipizzato; stesso comportamento (chiavi preservate,
  default `null`, i valori della riga vincono), niente `@var` né cast.

Fuori da Xot: `analyse Modules/Tenant` riporta ancora errori su `SushiToJson`,
`TestSushiModel` e relativi test, inclusi i chiamanti di `EnsureKeysAction` che passano
`array`/`mixed` non tipizzati. Non toccati in questa misura.

## Misura 2026-09-24 (sera) — GeoTrait generics + re-zero

`analyse Modules` dopo fix `@template TModel` / `@use GeoTrait<Address>`:
**0** `file_errors`. Canon:
[geo-trait.md](../../../Geo/docs/traits/geo-trait.md) ·
[phpstan-journey.md](../../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md).

## Misura 2026-09-24 — regressione naming (CloudStorage + Symplify)

Dopo cache clear, `cd laravel && ./vendor/bin/phpstan analyse Modules` ha riportato
**571** poi **394** `file_errors` (non più lo zero certificato del 2026-09-23).

### Perché (religione vs Symplify)

Laraxot usa `*Contract` (non `*Interface`), basi `BaseModel` / `XotBase*` / `TestCase`
(non `Abstract*`), trait `Has*` (non suffisso `*Trait`). Symplify
`ExplicitClassPrefixSuffixRule` (via `naming-rules.neon`, `symplify.naming=true`)
impone esattamente il contrario. Memoria:
[contract-suffix-no-interfaces-folder.md](../../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md).

### Cosa è successo

`Modules/CloudStorage/composer.json` (require-dev aggiunto 2026-09-24) ha tirato
`symplify/phpstan-rules ^14.10`. `phpstan/extension-installer` auto-carica
`config/naming-rules.neon` → ~393 errori di naming sul tree. In parallelo,
helper Xot coverage eliminati (`git D`) producevano ~148 `class.notFound`:
`FilamentSchemaCoverage.php`, `ModuleBusinessCoverage.php`,
`ModuleDeepCoverage.php`, `ModuleExecuteCoverage.php`,
`ModuleRemainingCoverage.php` in `Modules/Xot/tests/`.

`phpstan.neon` resta **immutabile** (niente ignore/baseline per spegnere Symplify).

### Remediation

1. Rimuovere `symplify/phpstan-rules` da `CloudStorage` `require-dev` (e
   `composer update` / dump autoload extension-installer).
2. Ripristinare i cinque helper coverage in `Modules/Xot/tests/` se assenti.
3. Non rinominare il codebase verso le convenzioni Symplify.

### Verifica

```bash
cd laravel
rm -rf /tmp/phpstan && mkdir -p /tmp/phpstan
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --memory-limit=2G
```

## Misura 2026-09-23 (story 5.224 — comando utente)

```bash
cd laravel
rm -rf /tmp/phpstan && mkdir -p /tmp/phpstan
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --memory-limit=2G
# EXIT 0 — [OK] No errors — 9421 file
# phpstan.neon immutato (level max, ignoreErrors vuoto)
```

Pest **non** eseguito: host `10.100.200.15` (personale2022).

Misura precedente 2026-09-21: `analyse` senza path e `analyse Modules` entrambi a 0
(story 18.59). Path CLI spegne `type-coverage`; il certify «siamo a zero» resta
il comando senza argomenti. Oggi l'utente ha chiesto esplicitamente `analyse Modules`.

Il 2026-09-21, dopo la verifica 18.59: un `analyse` su file Media caricava Setting e
il bootstrap Filament andava in fatal (`Cannot override final method
XotBaseResource::getFormSchema()`), poi 25 errori Setting, poi marker `<<<<<<<`
in `Activity/LogViewer.php` (mute-gate). Tutto chiuso. Rilancio certifying: ancora 0.

Config: `laravel/phpstan.neon` (`level: max`, `phpstan.neon` immutabile).
Neon **non** si tocca. Errori si risolvono nel codice, mai con baseline o ignore di evasione.

## Perché questo file esiste

Xot è la piattaforma: un errore di tipo qui si propaga a ogni modulo foglia.
Il gate verde significa che le classi base (`XotBaseResource`, `XotBaseResourceTable`,
`HasXotTable` solo sulla Table class) tengono i contratti che i consumer estendono.

## Comandi

| Scopo | Comando (cwd `laravel/`) |
|-------|--------------------------|
| Certifica zero | `./vendor/bin/phpstan analyse --memory-limit=-1` |
| Lavoro su un modulo | `./vendor/bin/phpstan analyse Modules/<Nome> --memory-limit=-1` |
| File toccato | `./vendor/bin/phpstan analyse Modules/<Nome>/app/<File>.php --memory-limit=-1` |

Un path CLI **sovrascrive** `parameters.paths` e spegne `tomasvotruba/type-coverage`.
Per dichiarare «siamo a zero» serve il comando senza argomenti.

## Debito aperto (non è un errore PHPStan oggi)

- Story [18.27](./stories/18.27.hasxottable-fuori-dai-componenti-filament.story.md):
  `HasXotTable` montato ancora su componenti `HasTable` → ignore `method.deprecated` nel trait.
- Duplicate path `XotBaseManageRelatedRecords` (`Pages/` vs `XotBaseResource/Pages/`).
- Marker di merge in alcuni `.md` (wiki, temi): PHPStan non li vede. I `.php` sono a 0 `<<<<<<<`.

## Collegamenti

- [phpstan-modules-fix.md](./wiki/troubleshooting/phpstan-modules-fix.md) — ricette
- [phpstan-best-practices.md](./wiki/phpstan-best-practices.md) — pattern Pest
- [18.59](./stories/18.59.phpstan-repo-wide-zero-2026-09-21.story.md) — drift 23→0 del 2026-09-21
- [2026-10-08 regressioni Xot/app](../stories/2026-10-08-phpstan-xot-app-regressions.story.md) — `$models` di MorphMany, `urlAct` (row e beforeLast), assert finti
- [phpstan-journey.md](../../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md) — second brain
- [CloudStorage coverage](../../CloudStorage/docs/coverage.md) — incidente require-dev Symplify
- [contract-suffix memory](../../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md) — religione `*Contract`
