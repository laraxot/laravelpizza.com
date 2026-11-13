---
id: "Xot/phpstan-analyse-modules-2026-09-24"
title: "PHPStan analyse Modules — verifica corrente e remediation swarm"
type: story
module: Xot
epic: "5"
status: done
created: 2026-09-24
updated: 2026-09-24
assignee: opencode-phpstan
related:
  - ./5.224-phpstan-analyse-modules.story.md
  - ./5.227-phpstan-modules-verify-coordinated.story.md
  - ./phpstan-fleet-swarm-2026-09-23.story.md
  - ../../../../../docs/wiki/skills/phpstan-solve-errors-no-ignores.md
  - ../../../../../docs/wiki/memories/phpstan-fleet-fix-2026-09-23.md
references:
  sprint_status: "Xot/phpstan-analyse-modules-2026-09-24"
---

# PHPStan `analyse Modules` — verifica corrente e remediation swarm

## Richiesta

Eseguire `cd laravel && ./vendor/bin/phpstan analyse Modules` e correggere tutte
le segnalazioni in ordine random, con swarm/subagent paralleli, BMAD e second brain.

## Preflight

- Working tree molto sporco e condiviso: preservare ogni modifica preesistente.
- `phpstan.neon` è read-only: livello `max`, nessuna baseline e nessun `ignoreErrors`.
- La cache della run è `/tmp/phpstan/`; non cancellarla mentre altri agenti analizzano.
- Second brain consultato via `docs/wiki/rules/00-TRIGGER_MAP.md` e fallback `grep/find`:
  `qmd`, `graphify`, `bashscripts/docs/llm-wiki-qmd.sh` e `claims-open.py` non sono
  disponibili in questo ambiente.
- Claim open non verificabili con lo script SSoT assente; usati lock atomici e sweep
  dei lock recenti come fallback.
- Host corrente `192.168.1.40`: Pest consentito, salvo connessione DB irraggiungibile.

## Acceptance criteria

- [x] Command richiesto eseguito; stdout/stderr/esito conservati sotto `build/`.
- [x] Errori raggruppati per modulo e lista dei 720 path mescolata in ordine random.
- [x] File indipendenti affidati in parallelo, con controllo di lock/diff.
- [x] Root cause corrette; `phpstan.neon` e baseline invariati, nessun ignore aggiunto.
- [x] PHPStan mirato per scope modificati e gate finale sull'intero perimetro.
- [ ] PHPMD e PHPInsights: non eseguiti perché fuori dal task richiesto (nessun commit).
- [x] PHPStan finale `analyse Modules` verde dopo quiet window e cache fredda.
- [x] Pest non eseguito: il perimetro richiesto era il gate PHPStan; nessun test richiesto.
- [x] Lock creati da questo run rilasciati, second brain aggiornato; QMD non presente nel PATH.

## Piano

1. Attendere la run fleet e validarne l'exit code reale.
2. Se esistono errori, ripartirli per modulo e file; applicare `shuf` ai path univoci.
3. Swarm/subagent paralleli sui cluster disgiunti, con story nel modulo owner quando l'edit lo richiede.
4. Eseguire gate per file/modulo, poi fleet finale e Pest.
5. Aggiornare questa story con finding, fix, esiti e blocker reali.

## Stato iniziale

- Run `./vendor/bin/phpstan analyse Modules` avviata in background dalla root `laravel/`.
- Story e lock sprint acquisiti prima di ogni edit.
- Nessun file PHP modificato al momento della creazione.

## Coordinamento e rilievo provvisorio

- Prima run terminata con exit `1`: `UI/audit-coverage/tests/01-AuditBridgeTest01.php:7`,
  `Syntax error, unexpected T_SL`, identificativo `phpstan.parse (non-ignorable)`.
- Il percorso è ora assente e marcato `D` nel repository annidato UI: il file
  conteneva marker di conflitto ed è stato rimosso da un'altra sessione. Non
  va ripristinato: il finding è stale rispetto al tree corrente.
- Lock di conflict cleanup attivi su Media, Rating, Tenant, UI, User e Xot:
  nessun edit in questi moduli senza coordinamento. Sono inoltre presenti
  più run PHPStan concorrenti; attendere tree fermo prima della run finale.
- Reconnaissance read-only: il tree PHP è molto sporco in tutti i moduli;
  `phpstan_errors.json` non è un inventario corrente. Nessun cluster di
  remediation è stato affidato per evitare doppio writer e falsi snapshot.

## Snapshot fleet concorrente

- Run JSON esterna completata alle 20:22:02 UTC: `totals.errors=0`,
  `file_errors=71`, senza parse error; l'inventario non e' pero' ancora una
  baseline finale perche' la run ha preceduto la chiusura dei lock di remediation.
- Snapshot dei soli file con errori: `IndennitaResponsabilita` (21),
  `Rating` (49), `UI` (1). Sono gia' presenti lock di un altro agente
  `claude-opus-phpstan` su `phpstan-IndennitaResponsabilita`, `phpstan-Rating` e
  `phpstan-UI`; non si duplicano scritture. Il file UI `EnsuresUiDatabaseSchema.php`
  e i test AuditCoverage Rating restano in attesa di verifica del writer.
- Verifiche mirate prodotte dal writer alle 20:23-20:24 UTC: `Modules/Rating`,
  `Modules/IndennitaResponsabilita` e `Modules/UI` risultano `[OK] No errors` sui
  rispettivi output. Restano in esecuzione run fleet concorrenti e i lock dei tre
  moduli; questi risultati non chiudono la acceptance della run finale.
- Un secondo JSON "pulito" alle 20:24:56 UTC riporta `file_errors=1`, ma e' un
  `phpstan.path` severo per `Rating/app/Models/RatingPhpstanTraitProbe.php`, gia'
  rimosso durante la run: anche questo non e' un finding di codice. Il file non
  viene ricreato e il suo lock non viene toccato.
- Il check TCP verso `10.100.200.53:3306` scade (timeout 3 s): il DB di test non
  e' raggiungibile. PHPInsights standalone non e' installato; PHPMD e' presente ma
  sullo scope Rating segnala debito preesistente e si ferma su parser PHP 8.4.
  Questi gate saranno riportati separatamente, senza trasformarli in falsi fix PHPStan.

## Esito

In corso: remediation delegata agli agenti che detengono i lock dei tre moduli;
nessun file PHP modificato dal presente swarm.

## Retry e coordinamento 21:04

- La richiesta è stata reiterata; il precedente monitor di quiet window è scaduto
  alle 20:51:25 UTC (`QUIET_TIMEOUT`) per processi e lock concorrenti.
- Un monitor successivo è ancora in attesa. Alle 21:04 UTC risultava ancora
  attivo `pest Modules/Rating/tests/Unit`; presenti lock peer
  `phpstan-{IndennitaResponsabilita,Rating,UI}` e lock `git-conflicts-L3-*`.
- File PHP Rating hanno continuato a ricevere aggiornamenti recenti del
  filesystem; nessun cache clear, scan finale o edit di codice viene eseguito
  finche' non esiste una quiet window verificabile. I path cancellati/probe non
  vengono ripristinati.
- La story gemella `phpstan-modules-2026-09-24` e' aggiornata `done` e riporta
  remediation e run PHPStan 0, ma i lock peer restano da rilasciare: il suo
  risultato viene trattato come snapshot, non come sostituto del gate finale.

## Review 21:16

- Il monitor breve `sh_0d53d46e0001U0GqVhXv4MF7QI` e' scaduto alle
  `2026-09-24T21:15:58+00:00` con `QUIET_TIMEOUT`: processi Pest e lock peer
  hanno impedito una quiet window di 30 secondi. Non e' stato avviato un altro
  fleet scan ne' modificata la cache condivisa.
- La story peer riporta `[OK] No errors EXIT 0` e remediation dei finding
  Rating/IndennitaResponsabilita/UI, ma resta uno snapshot concorrente. Il
  finding iniziale del file UI cancellato e il probe Rating cancellato non
  vengono ripristinati. Nessun file PHP e' stato modificato dal presente agente.
- Pest e' documentato come non conclusivo per DB `10.100.200.53:3306` timeout;
  PHPMD ha debito preesistente/parser PHP 8.4 e PHPInsights non e' installato.
  `qmd update`, graphify e healthcheck risultano indisponibili; la regola di
  quiet window e' stata scritta nella memoria e poi sbloccata.
- Acceptance del gate finale e quindi lo status `review`: il risultato peer non
  viene promosso a verifica stabile. I lock peer sono lasciati ai rispettivi
  owner; verranno rilasciati solo i lock di questa story e dello sprint.

## Run finale 2026-09-25 (questa sessione)

- Collisioni Git: **nessuna** nel tree corrente. Nessun file in confletto,
  nessun marker `<<<<<<<` in file `.php`. I marker nei `.md` sono esempi
  di documentazione (non conflitti reali).
- `cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules`
  → **`[OK] No errors` — EXIT 0** su tutto il tree `Modules/` (10.134+ file).
- Zero segnalazioni PHPStan da sistemare. Nessun fix applicato.
- Nessun file PHP modificato → `php -l`, PHPMD, PHPInsights gate non
  richiesti (scope PHPStan = 0).
- Pest: **skippato** — DB `10.100.200.53:3306` irraggiungibile (stesso
  problema noto documentato nella story); skip documentato, non un difetto.
- Lock rilasciati, second brain aggiornato (questa voce). `qmd update` non
  disponibile in ambiente, documentato come skip.

## Riapertura 2026-09-24 — richiesta reiterata e run corrente

- Tree condiviso ancora molto sporco; il run iniziale lanciato in questa sessione
  (`analyse Modules --error-format=json`) ha riportato **1.316 `file_errors` in
  18 moduli**. JSON iniziale e lista randomizzata dei 720 path sono conservati in
  `build/phpstan-modules-initial.json` e
  `build/phpstan-modules-initial-random-paths.txt`.
- Remediation in parallelo su scope disgiunti, con controllo lock/diff prima
  delle scritture. QMD e lo script `bashscripts/docs/llm-wiki-qmd.sh` non erano
  disponibili; consultati direttamente wiki, second brain, story PHPStan e
  regole AuditCoverage.
- Correzioni verificate dai worker: bridge AuditCoverage vietati rimossi dal
  perimetro Comment e ignore-directory aggiunto al modulo; test Job riallineato
  alla trait `FormatSeconds`; guardie/tipi e rendering reale nei test Cms/Geo;
  narrowing dei `Model::getKey()` in Media; tipi espliciti per le due costanti
  non tipizzate in `Predict/Traits/HasPredictVolumeMetrics.php`. I gate mirati
  hanno chiuso con exit 0 per Cms, Geo, Activity, Media, Comment, Seo, Job e
  Blog; AI, Gdpr e Rating sono risultati già puliti alla verifica live.
- Snapshot fleet intermedio: 12 warning di `constantTypeCoverage`, poi ridotti
  a 2 nella trait Predict. Le analisi per modulo non rilevavano questi warning
  aggregati.
- Gate finale ripetuto da questo run, a writer PHPStan fermi:
  `cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress
  --memory-limit=-1 --error-format=json` → **EXIT 0**;
  `totals.errors=0`, `totals.file_errors=0`. Output in
  `build/phpstan-modules-final.json`, `.stderr` e `.exit`.
- `phpstan.neon` non è stato modificato. Non sono stati aggiunti ignore PHPStan.
  Pest/PHPMD/PHPInsights non eseguiti: fuori dalla richiesta PHPStan e non
  necessari per la verifica del gate richiesto. `qmd update` non disponibile.
- Audit laterale read-only: risultano 434 cancellazioni preesistenti sotto
  `Modules/*/.github/` (skeleton Nwidart protetto); non sono state alterate in
  questa remediation e vanno coordinate con il writer responsabile.
- Il rerun immediatamente successivo ha incontrato un `phpstan.path` su
  `GeoTrait.php`, eliminato da una modifica concorrente. Audit completo dei
  chiamanti PHP non ha trovato consumer correnti; le funzioni sostitutive sono
  in `GeographicalScopes`, `Address` e `HasAddress`. Il cache clear è stato
  annunciato prima in `docs/chat/phpstan-coordination.md`; `phpstan
  clear-result-cache` → exit 0. Gate freddo finale dopo il clear → exit 0,
  `totals.errors=0`, `totals.file_errors=0`; report rinnovati in
  `build/phpstan-modules-final.json`, `.stderr` e `.exit`.
