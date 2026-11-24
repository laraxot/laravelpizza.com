---
title: "PHPStan Modules: bootstrap rotto da righe duplicate e residui nei test"
type: story
status: review
module: Xot
epic: quality-gates
story_id: phpstan-modules-bootstrap-duplicate-lines
created: 2026-11-24
updated: 2026-11-24
tags: [phpstan, bootstrap, php-lint, swarm, lang, rating, xot]
qmd: "phpstan analyse Modules exit 1 otto secondi bootstrap failed righe duplicate 3db6193228 UserForm BaseProfile InitialsAvatarProvider lang array.duplicateKey HasRatingResource class.notFound cache condivisa tmpDir privata swarm"
related:
  - ./phpstan-conflict-markers-bootstrap.story.md
  - ./phpstan-modules-bootstrap-and-user.story.md
  - ./phpstan-modules-zero-swarm.story.md
  - ./phpstan-modules-swarm-session.story.md
  - ./phpstan-xot-test-fixtures-generics-mixed.story.md
  - ../../../../Rating/docs/bmad/stories/phpstan-rating-tests-missing-classes.story.md
  - ../../../../User/docs/bmad/stories/phpstan-user-lang-duplicate-keys.story.md
  - ../../../../../../bashscripts/ai/wiki/memories/trait-merge-duplicate-methods-repair.md
---

# PHPStan Modules: bootstrap rotto da righe duplicate

## Obiettivo

`cd laravel && ./vendor/bin/phpstan analyse Modules` a zero errori (level max, nessuna baseline), risalendo alla
funzione del codice e non solo all'errore.

## Acceptance criteria

- [x] Bootstrap valido: `php -l` su 12.217 PHP sotto `laravel/`, 0 rotti.
- [x] `phpstan analyse Modules` con `exit=0` e 0 errori (18:17-18:21 UTC, cache fredda, nessun PHP riscritto nella finestra).
- [ ] Pest verde: non eseguibile per `TestDatabaseGuard` (`host "10.100.200.53" is not local`). Passato solo
  `ModuleRouteEntrypointsExistTest` (`1 passed, 2 assertions`). Da ripetere in ambiente di test isolato.
- [x] Second brain: estesa la memoria `trait-merge-duplicate-methods-repair.md`.

## Sovrapposizione con la sessione parallela

`phpstan-modules-zero-swarm.story.md` (status done, altra sessione) ha riparato in parallelo gli stessi file rotti
(`UserForm`, `BaseProfile`, import `Str` doppio). Non e' stata toccata ne' duplicata. Questa story aggiunge: attribuzione
al commit `3db6193228` con lint dei blob, i cluster lang / Xot test / Rating, e la misura finale con cache privata.

## Causa radice

Il commit `3db6193228` (messaggio ".", non un merge) ha riaggiunto righe gia' presenti. Verificato sui blob con
`git show <commit>:<file> | php -l`: i 5 file passano a `69c5e4aaf0` e a `dc010170d4` e si rompono solo a `3db6193228`.
Il merge `dc010170d4` era a posto sui marker, ma ha cancellato i duplicati `Filament/Resources/HasRatingResource/*` del
modulo Rating (voluto: `docs/redundancy-report.md`, righe 25 e 67-70), lasciando test che li referenziavano.

## Esito per cluster (ordine random: Rating, Xot, User)

| Cluster | Errori | Intervento |
|---------|--------|------------|
| Bootstrap | 3 file | `UserForm.php` apertura di `getFormSchema()` ripetuta; `InitialsAvatarProvider.php` `use Str` doppio; `BaseProfile.php` blocco di 45 righe identico. Rimosso il duplicato. |
| User lang | 2 | `attach_role.php` e `base_profile_form.php`: chiavi duplicate con valori identici, effetto invariato. |
| Xot | 3 | `@use HasCommonScopes<static>` nel fixture; `is_string()` con fallimento esplicito al posto di cast di `mixed` in `ModuleRouteEntrypointsExistTest`. |
| Rating | 16 | Stub: PHPDoc di `morphToManyX()` allineato a `RelationX` (1). Gli altri 15 (`class.notFound`) sono test dei duplicati cancellati: rimossi da un'altra sessione, non da questa. |

Totale al run con bootstrap funzionante: 21 errori in 7 file, tutti a 0 al run finale.

## Incidenti e lezioni

- Prima diagnosi sbagliata: attribuito il difetto al merge `dc010170d4`. Corretto con il lint dei blob; memoria aggiornata.
- Un subagent Rating ha restituito `tool_uses: 0`: rilanciato con altro tipo di agente. Un report non vale come prova.
- `/tmp/phpstan` e' condivisa da ~25 PHPStan di altre sessioni: `resultCache.php` corrotta (`Malformed entry header`), run
  `incomplete because of severe errors`. Un run ha dato un errore interno perche' `BaseProfile.php` e' stato riscritto
  a meta' analisi. Misura finale con `-c` su un neon scratch che include `phpstan.neon` e cambia solo `tmpDir`.
- `pint --dirty` lanciato da un subagent ha toccato file di altri (import inutilizzati, lint ok). Usare `pint <file>`.
- `sed -i` da Bash non e' coperto dal gate Edit/Write: i fatti vanno esposti comunque.

## Debito aperto

- Pest da rieseguire dove il DB di test e' raggiungibile (Rating, Xot `HasCommonScopesTest`).
- La rimozione dei test obsoleti Rating e' avvenuta per mano di un'altra sessione senza approvazione esplicita:
  verificare con il proprietario che il test rimosso (`HasRatingResource RatingsRelationManager allinea lo schema tabella`)
  fosse davvero ridondante.
- Docs: audit di sola lettura (37 nomi datati, 1.346 senza frontmatter, 670 gruppi di collisioni di maiuscole) non
  applicato: se ne occupa la story `docs-md-filename-date-debt`.
