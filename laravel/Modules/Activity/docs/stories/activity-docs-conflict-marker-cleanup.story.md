# Story: Activity — pulizia marker di conflitto residui in docs/

## Status
Done (risoluzione meccanica) + follow-up esplicito aperto per la
consolidazione editoriale di README.md/index.md (non fatta qui, vedi sotto).

## Contesto
Stesso task ricorrente descritto in
`Modules/Media/docs/stories/media-docs-conflict-marker-cleanup.story.md`,
applicato ad Activity. Causa radice: daemon locale di auto-commit che
committa marker non risolti dopo merge con remote divergente (diagnosi in
`docs/stories/5.122-gitmodules-sync-2026-09-15-safe-subset.story.md`, repo
principale). Quella story (2026-09-15) aveva trovato **1 solo file** marcato
in Activity (`docs/wiki/agents.md`, gia' risolto). Una settimana dopo
(2026-09-22, questa story) i file marcati erano **88**: il daemon ha
continuato a corrompere il modulo nel frattempo.

## Trovato
88 file con marker committati. A differenza di Media, la maggior parte NON
ha una struttura piatta: verificato con un validatore di sequenza marker
(`< = > < = > ...` atteso) che la maggioranza dei file ha sequenze
non valide — marker annidati/impilati su piu' generazioni (fino a 3-4
`<<<<<<< ` consecutivi nello stesso punto, es. `docs/lang-link.md`,
`docs/README.md`, `docs/filament-errors.md`), risultato di piu' merge non
risolti sovrapposti nel tempo.

## Decisione
La risoluzione blocco-per-blocco a giudizio editoriale (come per Media) non
era praticabile in sicurezza su questa scala/struttura: il parser piatto
standard non identifica correttamente i confini di un blocco annidato,
rischio concreto di perdere contenuto in modo silenzioso scegliendo il lato
sbagliato o tagliando a meta' un blocco. Applicata invece una rimozione
meccanica delle sole righe marker, mantenendo **tutto** il contenuto di
**tutti** i lati e **tutte** le generazioni (nessuna riga di contenuto
rimossa o scelta) — 1143 righe marker rimosse, 0 righe di contenuto perse.

Prima di applicarla su tutto il modulo, verificato che nessuno degli 88 file
usasse marker di conflitto come citazione documentale intenzionale (pattern
trovato invece in Lang, vedi story Lang): cercata prosa con
"conflitto/conflict/marker" immediatamente prima di un fence di codice in
tutti gli 88 file originali — nessun risultato, quindi tutti i marker erano
conflitti reali del daemon, non citazioni.

## Follow-up esplicito (non fatto qui)
`docs/README.md` e `docs/index.md` contengono ora 3-4 generazioni di
contenuto quasi-completo concatenate in sequenza (redazioni AI diverse nel
tempo; almeno una contiene dati chiaramente fittizi: email/Discord/
statistiche inventate del tipo "1M+ attivita' tracciate", "94/100 score").
Consolidarle in un'unica versione richiede giudizio editoriale su contenuto
sostanziale (non solo rimozione marker) e non e' stato fatto in questa
sessione per non rischiare scelte affrettate su file cosi' centrali. Da
trattare come story dedicata.

`docs/root-files-hygiene.md` verificato coerente (dedup code-workspace del
2026-09-22 gia' presente, commit 96e7575a) — nessuna modifica necessaria.

## Verifica
```bash
cd laravel/Modules/Activity
grep -rl '^<<<<<<< \|^=======$\|^>>>>>>> ' docs/ --include='*.md'
# atteso: nessun output (verificato, exit 1)
```

Commit: `6db1c9e3`.

## 2026-11-03: marker committati nel codice, non solo nei docs

Durante il rebase del mono dopo il pull dei sottomoduli (quadro generale in
[resolve-conflict-markers-xot.story.md](../../../Xot/docs/stories/resolve-conflict-markers-xot.story.md))
PHPStan si fermava con `Syntax error, unexpected T_SL on line 8` su
`app/Actions/Query/GetActivityStatisticsAction.php`. Il file non era in conflitto nel rebase:
i marker sono committati nell'HEAD di Activity, nel merge `200def5c9` (Marco Xot,
2026-11-01) tra `18997544c` e `f339962b9`, e sono arrivati nel mono con lo snapshot locale.

Il blocco aveva la meta' vecchia vuota e la meta' nuova con due import, `Model` e `Collection`.

| Import | Scelta | Motivo |
|---|---|---|
| `Illuminate\Database\Eloquent\Model` | Tenuto | Il corpo usa `$user instanceof Model`. Senza l'import `Model` diventa `Modules\Activity\Actions\Query\Model`, una classe che non esiste: `instanceof` da' sempre false senza errori, e ogni chiamata con un utente lancia `InvalidArgumentException`. |
| `Illuminate\Support\Collection` | Tolto | Serviva al vecchio `countByType()` con `mapWithKeys`. Il merge ha tenuto la versione con `foreach` e `getAttribute()`, che non lo usa. Pint lo rimuoverebbe comunque. |

Verifica:

- `php -l`, `pint --test` e PHPStan sul file: nessun errore.
- Il test `GetActivityStatisticsAction con e senza user e event null` in
  `tests/Unit/Actions/CoverageHundredActionsTest.php` chiama `execute($user)` con un `User` vero,
  quindi protegge gia' l'import di `Model`. Non e' stato aggiunto un test nuovo.
- Pest non e' verde: quel test e `Adapter ActivityLogger getStatistics delega al container`
  falliscono prima di arrivare al codice, con `SQLiteDatabaseDoesNotExistException`. In
  `laravel/database/` manca il file SQLite condiviso dei test, che e' in `.gitignore` e si
  ricostruisce con `php artisan xot:build-test-sqlite`. Il comando esegue le migration di tutti i
  moduli e non e' stato lanciato senza il via dell'utente.

Aperto: il fix va committato anche nel repo di Activity, altrimenti il prossimo pull riporta i marker.
Lock preso con `bashscripts/lock/lock.sh` (task `activity-rebase-markers-20261103`) e rilasciato.

Nota 2026-11-03 (seconda passata): in `GetActivityStatisticsAction` importato `InvalidArgumentException` al posto del nome qualificato (PHPMD `MissingImport`). PHPStan intero progetto `[OK]`, Pint passa.