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
  - ./0118-phpstan-conflict-markers-bootstrap.story.md
  - ./0138-phpstan-modules-bootstrap-and-user-3.story.md
  - ./0149-phpstan-modules-zero-swarm.story.md
  - ./0147-phpstan-modules-swarm-session.story.md
  - ./0154-phpstan-xot-test-fixtures-generics-mixed.story.md
  - ../../../../Rating/docs/bmad/stories/phpstan-rating-tests-missing-classes.story.md
  - ../../../../User/docs/bmad/stories/phpstan-user-lang-duplicate-keys.story.md
  - ../../../../../../bashscripts/ai/wiki/memories/git-merge-markers.md#trait-merge-duplicate-methods-repair
---
# PHPStan Modules: bootstrap rotto da righe duplicate

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Obiettivo

`cd laravel && ./vendor/bin/phpstan analyse Modules` a zero errori (level max, nessuna baseline), risalendo alla
funzione del codice e non solo all'errore.

## Acceptance criteria

- [x] Bootstrap valido: `php -l` su 12.217 PHP sotto `laravel/`, 0 rotti.
- [x] `phpstan analyse Modules` con `exit=0` e 0 errori (18:17-18:21 UTC, cache fredda, nessun PHP riscritto nella finestra).
- [ ] Pest verde: non eseguibile per `TestDatabaseGuard` (`host "10.100.200.53" is not local`). Passato solo
  `ModuleRouteEntrypointsExistTest` (`1 passed, 2 assertions`). Da ripetere in ambiente di test isolato.
- [x] Second brain: estesa la memoria `git-merge-markers.md#trait-merge-duplicate-methods-repair`.

## Sovrapposizione con la sessione parallela

`0149-phpstan-modules-zero-swarm.story.md` (status done, altra sessione) ha riparato in parallelo gli stessi file rotti
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

## Secondo giro: marker annidati da un progetto fratello (20:37)

Alle 20:40 PHPStan e' tornato a `exit 1` in 6 secondi (`unexpected token "<<"`): 126 PHP con marker in Activity (28), Job (9),
Lang (12), Media (3), Notify (74), gia' committati nei repo dei moduli e allineati a `laraxot/dev` (0 commit di scarto). Il
commit radice `41e757843a` (20:29) ne contiene 84; `d2ae03eb31` (20:27) ne aveva 0 e fa da riferimento di sola lettura.

- **Produttore fuori da questo repo.** `git merge laraxot/dev --allow-unrelated-histories -s resolve` vivo in
  `base_laravelpizza_fila5` (cwd dei pid verificato), il cui sync fa `rm -rf .git/hooks`: nessun guard hook. Il rischio di
  reimport resta finche' i remoti `laraxot/module_*_fila5` portano i marker.
- **Classificazione** (stack per livello, token PHP contro `d2ae03eb31`): 94 cosmetici, 15 con stessi token tra i lati,
  7 `THEIRS=BASE`, 1 `OURS=BASE`, 3 semantici, 6 file Notify (lang `en`/`it` di `template` e `sms`, `GenericNotification`) dove
  nessun lato e' valido perche' due `=======` cadono nello stesso livello.
- **Risoluzione non mia.** In 6 minuti altri agenti (`codex`, story `Activity/php-conflict-markers-20261124`, lock di modulo
  `Notify.lock`) hanno portato i marker PHP a 0. Non ho scritto nei loro moduli: il lock non si forza, stale a 60 minuti.
- **Mio intervento.** Tre `use` duplicati rimasti dopo i marker, fatal di compilazione che il parser di PHPStan non vede:
  `Notify/tests/TestCase.php`, `User/tests/TestCase.php`, `User/tests/Unit/UserExecuteCoverage50Test.php`. Tolta la riga
  fuori ordine, `php -l` OK. Lint dell'intero albero (`Modules`, `app`, `config`, `routes`, `bootstrap`): nessun altro
  Fatal/Parse.
- **Second brain.** Sezione "Variante 2026-11-24" in `git-merge-markers.md#merge-markers-committed-e7e667b11`; prompt `37-phpstan.md` esteso con
  cache privata (`-c` + `tmpDir`) e diagnosi del commit con `php -l` sui blob.

## Terzo giro: r5 fallita, due nuovi merge committati con marker (21:01 e 21:11)

- **r5 non e' una misura valida.** Cache privata fredda, 20:59:05-21:09:16 UTC (10m11s), `exit=1`, `Result is incomplete because of
  severe errors`: 4 parse error, Tenant `CreateJsonFileByRecordActionStringIdTest.php` e UI `GetLocalizedBlockDataAction`,
  `NullGeocodingService`, `UIService`. Load average 124. L'exit 0 della notifica era quello del wrapper.
- **Tenant, 21:01:52.** Merge `67c5e43` ("Merge remote-tracking branch 'laraxot/dev' into dev") con marker in 4 Actions + 1 test.
  I 3 file UI sono stati riscritti da altri alle 21:09:10 (lint OK); le 4 Actions Tenant erano senza marker entro le 21:11
  (working tree `M`). Non toccati da me.
- **User, 21:11:01.** Merge `c492fc0fb` ("first") nel repo del modulo, genitori `6bc3f497e` (commit "." delle 21:10:54, di questo
  repo) e `53fefcd99` (HEAD del modulo User di `base_laravelpizza_fila5`). Reflog: `commit (merge): first`, poi
  `Branch: renamed refs/heads/dev to refs/heads/dev`. 147 PHP in `Modules/User` con marker, tutti con mtime 21:10:57, working tree pulito
  (sono committati). Etichette `HEAD`/`laraxot/dev` (275 blocchi) e `.merge_file_*` (57): stessa firma del secondo giro.
  Remote del modulo: `laraxot` (`module_user_fila5`). Nessun `MERGE_HEAD`, nessun processo di merge vivo, nessun lock o claim su User
  alle 21:12.
- **Cosa non so.** Chi ha lanciato il merge in questo working tree: l'autore del commit e' lo stesso git user locale, quindi non
  discrimina. So solo che il secondo genitore e' un commit del progetto fratello.

## Quarto giro: r6 verde (22:53-22:54)

- **Esito.** `phpstan analyse Modules` con cache privata (`phpstan-private-r6.neon`, `tmpDir` scratch): 22:53:12-22:54:10, `exit=0`.
  Un secondo run sulla stessa cache col formato a tabella stampa `[OK] No errors`. Marker di merge nei PHP: 0.
- **Perche' ci credo.** `--error-format=raw` su un run pulito non stampa nulla, quindi l'output vuoto da solo non prova niente.
  Controllo negativo con lo stesso neon: un file isolato con `needsInt($raw)` su `mixed` produce
  `argument.type ... expects int, mixed given`. La cache privata ha 18308 file di analisi.
- **Prima di r6.** `php -l` sui 758 PHP di `Modules`, `app`, `config`, `routes`, `bootstrap` modificati nelle ultime 3 ore: 0 fatal/parse.
  Il primo tentativo con `find -newermt '-180 minutes'` dava 0 file per una data non valida, non per pulizia: lo ha
  smascherato un controllo su `Utils.php`, che avevo modificato io. Corretto con `-mmin -180`.
- **Limite.** Il lint copre i file recenti, non tutti gli 11.883 PHP sotto `Modules`. PHPStan non vede i `use` duplicati
  (fatal di compilazione), quindi un residuo vecchio e mai toccato non sarebbe emerso da r6.
- **Causa dei marker, confermata.** User: i due genitori del merge `c492fc0fb` non hanno merge-base (`git merge-base` vuoto), il
  secondo genitore e' fuori dal confine shallow. Su 40 file con marker campionati, 40 non hanno versione nel merge-base: il merge
  e' add/add su storie non correlate. Finche' i `.git` restano senza antenato comune con `laraxot/dev`, ogni sync riproduce i marker.
  Per questo lo slim dei `.git` non fa re-clone per ref. L'unico taglio di storia (Notify, `fetch --depth=1` sul commit di HEAD)
  e' stato fatto perche' li' HEAD coincide con `laraxot/dev`, quindi il merge-base esiste (vedi `0105-module-theme-git-slim.story.md`).

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


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
