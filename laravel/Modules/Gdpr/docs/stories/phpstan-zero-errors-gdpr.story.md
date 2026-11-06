---
title: "[STORY] PHPStan zero errori — modulo Gdpr"
type: story
status: done
priority: high
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, gdpr, merge-conflict, pest, bmad, swarm]
related:
  - "./phpstan-zero-errors-gdpr.dev.md"
  - "../../../../../docs/stories/all-modules-phpstan-zero-errors.story.md"
---

# Story: PHPStan zero errori — modulo Gdpr

## User Request

Swarm PHPStan (2026-10-28): zero errori in `Gdpr` (14 di baseline), risolvendo la causa; rinominare senza data `docs/wiki/troubleshooting/git-merge-conflict-inventory-2026-04-28.md`; non rifare il riordino docs in corso.

## Analysis

14 errori = 3 cause, tutte **regressioni della risoluzione dei merge del 2026-10-28** (`b8c56ce` committa i marker `<<<<<<<`, `281b74c` li risolve ma perde righe). Nessuna classe cancellata per scelta: erano pezzi dimenticati, tutti ancora usati.

| Causa radice | Errori | Scopo del codice | Soluzione |
|---|---|---|---|
| `use Filament\Tables\Columns\IconColumn` perso in `TreatmentsTable` | 7 | colonne booleane `active` e `required` della tabella Trattamenti (a runtime: `Class IconColumn not found`) | import ripristinato |
| `use PHPUnit\Framework\Assert` perso in `ConflictResolutionTest` | 5 | smoke test: `Treatment` e `Profile` istanziabili, `fillable` array, connessione `gdpr` (a runtime: `Class "Assert" not found`) | import ripristinato |
| `TestCase::$currentTest` + `setUp`/`tearDown` rimossi da `tests/TestCase.php` | 2 | i test Pest vivono in closure senza `$this`: `gdprTest()`/`gdprGet()`/`gdprPost()`/`gdprActingAs()` in `PestHelpers.php` ricevono il test corrente da qui (il docblock della classe lo dichiara ancora) | proprieta' statica `?self $currentTest`, valorizzata in `setUp()` dopo `parent::setUp()`, azzerata in `tearDown()` — identica alla versione pre-`b8c56ce`; e' lo stesso schema di `Modules/Cms/tests/TestCase.php` |

Docs: `git-merge-conflict-inventory-2026-04-28.md` e `git-merge-conflict-inventory.md` avevano lo stesso corpo. `git mv -f` ha unificato i due nel nome senza data; la data dell'inventario (2026-04-28) e' in `created`. L'unico riferimento (`docs/index.md`, riga duplicata) e' stato tolto.

## Result (verificato 2026-10-28)

- `phpstan analyse Modules/User Modules/Gdpr Modules/UI` → Gdpr **14 → 0**; full-tree 0 errori in Gdpr.
- `php -l` pulito sui 3 file di codice toccati.
- **Pest non eseguito** (`.env.testing` = MySQL, DB Gdpr non isolato). `TestCase` e' stata ripristinata a una versione gia' esistita in storia, ma non provata.

## Acceptance Criteria

- [x] 0 errori PHPStan in `Modules/Gdpr`
- [x] Nessun `@phpstan-ignore`, baseline o modifica a `phpstan.neon`
- [x] Nessun file cancellato (la fusione dei due inventari e' un `git mv -f` di contenuto identico)
- [x] Nessun `.md` con data nel nome rimasto in `docs/wiki/troubleshooting/`
- [ ] Pest in sqlite sui test Gdpr (`ConflictResolutionTest` e tutti i test che usano `gdprTest()`)
- [ ] Commit (il modulo e' in un rebase interattivo dell'utente: nessun commit fatto)

## Decisioni aperte

- Il modulo e' in `interactive rebase ... You are currently editing a commit`; il `git mv` ha lasciato nell'indice una rinomina staged. `docs/index.md` era gia' modificato dall'utente (riordino docs): toccata una sola riga.
- Altri `.md` con suffisso `-1` in `docs/raw/root-import/` (cloudflare-1, consents-1, ...): duplicati di import, non unificabili senza cancellare; restano elencati in `docs/index.md`.
- `docs/wiki/troubleshooting/git-merge-conflict-inventory.md` descrive 1 file con marker (`docs/wiki/README.md`): dato del 2026-04-28, non riverificato.
- Durante un run PHPStan e' comparso una volta `phpstan.parse` su `tests/Feature/DatabaseConnectionTest.php:17` (nome `DB` gia' in uso); al run successivo era sparito e il file risulta invariato in git: probabile modifica concorrente dell'utente.

## GitHub (tracciamento)

### Issues
- TODO (`gh` non installato su questa macchina)
### Discussions
- TODO