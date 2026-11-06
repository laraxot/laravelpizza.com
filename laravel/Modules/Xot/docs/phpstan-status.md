# PHPStan Status — Xot

Stato vivo del gate. Non copiare numeri da report storici: rimisura.

## Misura 2026-09-24 (notte) — certify no-path + harness worktree
# PHPStan Status: Xot

Stato vivo del gate. Non copiare numeri da report storici: rimisura.

## Misura 2026-09-24 (notte): certify no-path + harness worktree

`./vendor/bin/phpstan analyse` (no path CLI): **`[OK] No errors` EXIT 0**.

Regressione tipica: i 5 helper in `Modules/Xot/tests/*Coverage.php` spariscono dal
worktree (restano in HEAD) → ~394 `class.notFound`. Fix:
`git checkout HEAD -- tests/…` o `ensure-audit-coverage-gitignore.sh --fix`.
Story: [phpstan-analyse-no-path-certify.story.md](./bmad/stories/phpstan-analyse-no-path-certify.story.md).

Pest: skip — `DB_HOST=10.100.200.53` DOWN (non host 15).

## Misura 2026-09-24 (sera) — GeoTrait generics + re-zero
Pest: skip: `DB_HOST=10.100.200.53` DOWN (non host 15).

## Misura 2026-09-24 (sera): GeoTrait generics + re-zero

`analyse Modules` dopo fix `@template TModel` / `@use GeoTrait<Address>`:
**0** `file_errors`. Canon:
[phpstan-journey.md](../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md).

Questa misura documenta lo stato storico prima della rimozione del trait.
Nella verifica corrente il trait e i relativi probe sono stati rimossi dopo
l'audit completo dei chiamanti: nessun consumer PHP resta nel repository.
`GeographicalScopes`, `Address` e `HasAddress` coprono i comportamenti ancora
utilizzati.

## Misura 2026-09-24 (notte) — gate freddo dopo cache stale
## Misura 2026-09-24 (notte): gate freddo dopo cache stale

Un run intermedio ha segnalato `phpstan.path` verso il file GeoTrait non più
presente. Dopo il controllo read-only dei chiamanti e l'arresto di tutte le run,
`phpstan clear-result-cache` è uscito 0. Il successivo
`phpstan analyse Modules --no-progress --memory-limit=-1 --error-format=json`
ha chiuso con **EXIT 0**, `totals.errors=0`, `totals.file_errors=0`.
Report: `build/phpstan-modules-final.json`.

## Misura 2026-09-24 — regressione naming (CloudStorage + Symplify)
## Misura 2026-09-24: regressione naming (CloudStorage + Symplify)

Dopo cache clear, `cd laravel && ./vendor/bin/phpstan analyse Modules` ha riportato
**571** poi **394** `file_errors` (non più lo zero certificato del 2026-09-23).

### Perché (religione vs Symplify)

Laraxot usa `*Contract` (non `*Interface`), basi `BaseModel` / `XotBase*` / `TestCase`
(non `Abstract*`), trait `Has*` (non suffisso `*Trait`). Symplify
`ExplicitClassPrefixSuffixRule` (via `naming-rules.neon`, `symplify.naming=true`)
impone esattamente il contrario. Memoria:
[contract-suffix-no-interfaces-folder.md](../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md).

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
## Misura 2026-09-23 (story 5.224: comando utente)

```bash
cd laravel
rm -rf /tmp/phpstan && mkdir -p /tmp/phpstan
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --memory-limit=2G
# EXIT 0 — [OK] No errors — 9421 file
# EXIT 0: [OK] No errors: 9421 file
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
- [phpstan-journey.md](../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md) — second brain
- [CloudStorage coverage](../../CloudStorage/docs/coverage.md) — incidente require-dev Symplify
- [contract-suffix memory](../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md) — religione `*Contract`
- [phpstan-modules-fix.md](./wiki/troubleshooting/phpstan-modules-fix.md): ricette
- [phpstan-best-practices.md](./wiki/phpstan-best-practices.md): pattern Pest
- [18.59](./stories/18.59.phpstan-repo-wide-zero-2026-09-21.story.md): drift 23→0 del 2026-09-21
- [phpstan-journey.md](../../../../bashscripts/ai/wiki/second-brain/phpstan-journey.md): second brain
- [CloudStorage coverage](../../CloudStorage/docs/coverage.md): incidente require-dev Symplify
- [contract-suffix memory](../../../../bashscripts/ai/wiki/memories/contract-suffix-no-interfaces-folder.md): religione `*Contract`