---
<<<<<<< .merge_file_24bfRU
title: "Continuazione BMAD — Domani (Activity)"
=======
title: "Continuazione BMAD: Domani (Activity)"
>>>>>>> .merge_file_xEObwE
type: module-fix
scope: Activity
epic: docs-conflict-markers-cleanup
bmad_version: v3.30.1
updated_at: '2026-09-22'
status: in-progress
related:
<<<<<<< .merge_file_24bfRU
  - ./conflict-markers-cleanup-2026-09-22.story.md
---

# Activity — Continuazione Domani
=======
  - ./conflict-markers-cleanup.story.md
updated: 2026-10-07
tags: [docs, activity, bmad]
qmd: "activity   continuazione domani activity"
---

# Activity: Continuazione Domani
>>>>>>> .merge_file_xEObwE

## Stato verificato ora (sessione 2026-09-22)

- `conflict-markers-cleanup-2026-09-22` (**done**, riverificato): 90 file `.md`
  in `docs/` + `.github/contributing.md` + `.github/security.md` avevano
  marker di conflitto git mai risolti, in alcuni casi annidati fino a 4 round
  (`docs/00-index.md`: 39 righe marker su 385). Causa reale: il fix del
  mattino (`6db1c9e3`, 09:40:04) era stato **annullato** dal merge
  `baf9bfbd` "Merge remote-tracking branch 'laraxot/dev' into dev" che ha
<<<<<<< .merge_file_24bfRU
  reintrodotto la versione remota stale — entrambi i commit verificati ora
=======
  reintrodotto la versione remota stale: entrambi i commit verificati ora
>>>>>>> .merge_file_xEObwE
  con `git show -s --format=%H %ci %s`, esistono davvero nella history locale.
  Fix definitivo ri-applicato: `5fe111e1` (contenuto, 90 file), `e6eb12dd`
  (story), `7836580e` (root cause), `d79c39d5` (fence markdown orfana in
  `implementation.md`), `d0bc6e4f` (quality gate). `git status` pulito,
  `dev` ora 1 commit avanti a `laraxot/dev` (il commit `.` che ha introdotto
<<<<<<< .merge_file_24bfRU
  questo stesso file, autore daemon auto-commit — non ancora pushato).
- Quality gate post-pulizia (`docs/coverage.md`, commit `d0bc6e4f`): PHPStan
  `Modules/Activity` → 0 errori. PHPMD → 0 (unico rumore: il parser pdepend
  del `.phar` crasha su `tests/Unit/Listeners/LoginLogoutListenerBehaviorTest.php:32`,
  sintassi PHP 8.4 method-chaining su `new` non supportata dal parser —
  `php -l` pulito, falso negativo noto del tool, non un difetto del codice).
  PHPInsights → code 95.3, complexity 100, architecture 78.6, style 90.1,
  **security 0** (nessun security issue registrato dal tool, non uno score
  basso — da non confondere leggendo la tabella).
=======
  questo stesso file, autore daemon auto-commit: non ancora pushato).
- Quality gate post-pulizia (`docs/coverage.md`, commit `d0bc6e4f`): PHPStan
  `Modules/Activity` → 0 errori. PHPMD → 0 (unico rumore: il parser pdepend
  del `.phar` crasha su `tests/Unit/Listeners/LoginLogoutListenerBehaviorTest.php:32`,
  sintassi PHP 8.4 method-chaining su `new` non supportata dal parser -
  `php -l` pulito, falso negativo noto del tool, non un difetto del codice).
  PHPInsights → code 95.3, complexity 100, architecture 78.6, style 90.1,
  **security 0** (nessun security issue registrato dal tool, non uno score
  basso: da non confondere leggendo la tabella).
>>>>>>> .merge_file_xEObwE
  Pest **non eseguito**: `10.100.200.53:3306` irraggiungibile (`nc -z`
  fallito), pattern noto (`project-test-db-unreachable-drives-skips.md`).
- Nessun altro file `*.story.md` con stato aperto nel modulo: l'unica story
  esistente oltre a questo file è `conflict-markers-cleanup-2026-09-22`, ed
  è `done`.

<<<<<<< .merge_file_24bfRU
## Continuazione — priorità, in ordine
=======
## Continuazione: priorità, in ordine
>>>>>>> .merge_file_xEObwE

1. **Follow-up esplicito lasciato aperto dalla story stessa** (sezione
   `notes`): nessun gate impedisce che un `merge`/`pull` da `laraxot/dev`
   reintroduca marker di conflitto già risolti localmente (è esattamente
   quello che ha fatto `baf9bfbd`). Servirebbe uno script
   `verify-no-conflict-markers.sh` da lanciare pre-merge/pre-push (pattern
   già segnalato per Xot: `Xot/5.159-docs-conflict-markers-regression-2026-09-22`
   in `docs/sprint-status.yaml`). Valutare se centralizzarlo in
   `bashscripts/` così da coprire tutti i moduli con un solo tool.
2. **Due trait morti mascherati da soppressione silenziosa**:
   `app/Traits/HasEvents.php` e `app/Traits/HasSnapshots.php` hanno
<<<<<<< .merge_file_24bfRU
   `/** @phpstan-ignore trait.unused */` — verificato con
=======
   `/** @phpstan-ignore trait.unused */`: verificato con
>>>>>>> .merge_file_xEObwE
   `grep -rn "HasEvents\|HasSnapshots" app/` (esclusi i file stessi): **zero
   usi** in tutto il modulo. `HasSnapshots` è dichiarato esplicitamente
   placeholder vuoto nel proprio commento ("This trait can be extended...
   For now, it's a placeholder"). Per il pilastro "ogni soppressione nasconde
   un errore vero": decidere se cablare i trait sui model che dovrebbero
   usarli (event sourcing / snapshot pattern, coerente col resto del modulo
<<<<<<< .merge_file_24bfRU
   `StoredEvent`/`Snapshot`) o rimuoverli — non lasciarli come dead code
   silenziato da un ignore permanente.
3. **Tre `@phpstan-ignore-next-line` in
   `app/Filament/Pages/ListLogActivities.php`** (righe 70, 95, 290): tutti
   mascherano lo stesso problema — `__()` di Laravel ritorna
=======
   `StoredEvent`/`Snapshot`) o rimuoverli: non lasciarli come dead code
   silenziato da un ignore permanente.
3. **Tre `@phpstan-ignore-next-line` in
   `app/Filament/Pages/ListLogActivities.php`** (righe 70, 95, 290): tutti
   mascherano lo stesso problema: `__()` di Laravel ritorna
>>>>>>> .merge_file_xEObwE
   `string|array|null` e il codice fa `implode()`/cast su un valore che
   PHPStan non riesce a restringere. Vale la pena valutare un helper tipizzato
   (`__string()` o simile, già eventualmente presente in Xot) da riusare al
   posto di sopprimere l'errore in 3 punti diversi dello stesso file.
4. **Pest da rilanciare quando il DB torna raggiungibile**
   (`nc -z -w3 10.100.200.53 3306`): la pulizia marker ha toccato solo
   `docs/`/`.github/`, quindi dovrebbe essere no-op sui test, ma non è mai
   stato verificato a runtime in questa sessione.
5. **Push del commit locale in sospeso**: `dev` è 1 commit avanti a
   `laraxot/dev` (il commit `.` con questo stesso file, generato dal daemon
<<<<<<< .merge_file_24bfRU
   auto-commit prima di questa sessione) — verificare che sia stato pushato
=======
   auto-commit prima di questa sessione): verificare che sia stato pushato
>>>>>>> .merge_file_xEObwE
   insieme al commit di questa sessione.

## Second brain

`qmd query` su "Activity conflict markers regression baf9bfbd trait.unused"
prima di riprendere; `qmd update` dopo ogni chiusura.
