---
title: "Xot - Prompt 64 di audit multidisciplinare: esecuzione, revisione e completamento"
module: Xot
bmad: true
status: done
owner: Modules/Xot (i prompt condivisi vivono in bashscripts/docs/prompts)
related:
  - ./gitattributes-svg-merge-markers.story.md
  - ../../../../../bashscripts/docs/prompts/64-audit.md
  - ../../../../../bashscripts/docs/prompts/README.md
  - ../../../../../bashscripts/docs/prompts/INDEX.md
---
# Prompt 64 di audit multidisciplinare

- Fase BMAD: Quick Flow (verifica dello stato, revisione ECC, correzione, indici, second brain)
- Branch: dev
- Richiesta: "esegui e migliora e completa il prompt bashscripts/docs/prompts/64-audit.md , fa tutto con bmad + ecc + second brain"
- Claim: agente `claude-code`, lock su `64-audit.md` e su `docs/sprint-status.yaml`.

## Stato iniziale verificato

| Controllo | Esito |
|-----------|-------|
| `php artisan --version` (boot) | ok |
| `composer audit` | exit 0 |
| PHPStan sul modulo Trade | 29 errori, tutti in `TradeResults.php`, file in modifica da altri agenti: non toccato |
| qmd | circa 8461 documenti da incorporare al momento della misura |
| graphify | grafo non aggiornato rispetto al codice |

## Storia del file

`64-audit.md` e' stato riscritto da piu' scrittori in venti minuti (15:09 la versione legacy da 683 righe,
poi 218, 953, 166, 128, 1026, 215, 341, 679, 895, 221, 1004 righe). L'ultima versione su `laraxot/dev`
(`d4d3cbede`, 1004 righe) e' un groviglio: 30 marker di conflitto e 9 delimitatori di frontmatter.

Causa: il sync `bashscripts/git/subtrees/merge_remote_repo_2.sh laraxot`, marcato DEPRECATO nella sua intestazione,
committa "." con `add -A` e fa due `git merge --allow-unrelated-histories`. Vedi la story sorella per la causa
radice dei marker negli SVG.

## Lavoro svolto

- Revisione ECC della versione di codex: 12 rilievi, applicati nella versione `6f05e18a1` (221 righe).
- Confronto con la versione concorrente `860002a80` (215 righe): portati stati `open|fixed|accepted-risk|blocked|out-of-scope`,
  confidenza A/B/C, baseline e riesecuzione, lettura a tre livelli dei risultati degli strumenti, viewport 375/768/1440,
  elenco dei campi del report, lista dei file sporchi come contesto, unita' di lavoro da circa 15 minuti.
- Ricostruito il file pulito (244 righe, 0 marker, 2 delimitatori di frontmatter) con Write, in avanti, senza `git show > file`.
  Il frontmatter `related` include `./00-start.md` e `./19-docs.md`.
- `README.md` e `INDEX.md` dei prompt: righe del 64 presenti, 0 marker.

### Mappa delle sezioni del legacy da 683 righe

| Legacy | Nuovo |
|--------|-------|
| 0 Missione, 16 Istruzione finale | Missione e ciclo |
| 1 Conoscenza, 2 Mappa dinamica | Bootstrap BMAD + ECC + Second Brain |
| 10 Specializzazione Laravel/Laraxot | Vincoli Laraxot |
| 3 Audit multidisciplinare, 9 Prioritizzazione | Audit e priorita' |
| 4 Multi-agente, 5 Discussione, 6 Implementazione | Swarm e implementazione |
| 7 Ciclo di verifica, 11 Strumenti | Gate obbligatori |
| 13 Criteri di completamento | Criteri di completamento |
| 8 Miglioramento continuo, 12 Memoria, 14 Report, 15 Autonomia | Chiusura e memoria |

Cosa cambia rispetto al legacy: i dieci agenti nominati (sezione 4) diventano otto lenti di lettura applicate in
sequenza dallo stesso agente, con al massimo due subagent per task indipendenti (il limite d'uso e' condiviso).
Gli Step A-G della discussione tecnica (sezione 5) non sono piu' elencati: il ciclo sta nel master prompt e lo swarm
nel prompt 46 (`46-multi-agent-module-swarm.md`), entrambi nel `related` del 64.

## Verifiche

- `python3 -I bashscripts/tools/docs/md-filenames.py check --paths <file>`: 0 non conformi per prompt e story.
- Nessun nome di progetto o percorso assoluto nel prompt (e' condiviso tra progetti).

## Chiusura 2026-11-06

- Corretto il refuso `reamente` e riallineato il riferimento al trigger map
  canonico `docs/wiki/rules/00-TRIGGER_MAP.md`.
- Aggiunta la matrice minima obbligatoria per perimetro, copertura e stato
  `unverified`, evitando audit senza fine o copertura dichiarata senza prova.
- Esplicitato il confine di scrittura tra `audit-only`, `remediation-plan` e
  `implementation-authorized`, così la sezione di chiusura non contraddice la
  modalità selezionata.
- Rimossa l'assunzione ambientale su PHP 8.4 e resa più sicura la diagnostica
  delle cache, vietando pulizie automatiche su directory condivise o produzione.
- Aggiornato l'indice prompt da `review` a `stable`.

### Gate eseguiti

| Gate | Esito |
|---|---|
| `python3 -I bashscripts/tools/docs/md-filenames.py check --paths bashscripts/docs/prompts` | BLOCKED: lo script non esiste in questo checkout |
| ricerca marker di conflitto in `64-audit.md` | PASS: nessun marker trovato |
| `git -C bashscripts diff --check -- docs/prompts/64-audit.md` | PASS |
| frontmatter YAML e riferimenti prompt | PASS |

Nessun codice PHP, configurazione runtime, dato, commit o push è stato toccato.

## Decisioni aperte

1. Commit e push: il master prompt (vincolo 5) li vieta senza richiesta, la chiusura modulo di `AGENTS.md` li prevede.
   Applicata la lettura conservativa: nessun commit in questo turno. Da decidere quale regola prevale.
2. Il master prompt (riga 40, "nello stesso run") e `11-phpstan.md` (punto 3 di "Vittoria verificata") non concordano
   sul momento della prova `[OK] No errors`. Il 64 segue `11-phpstan.md`.
3. `AGENTS.md` mostra `heavy-slot.sh` per PHPStan, mentre `11-phpstan.md` impone `flock` su `PHPSTAN_GATE`. Il blocco
   dei gate del 64 usa `flock` per PHPStan e `heavy-slot` per phpinsights.
4. La versione pulita e' solo nel working tree: su `laraxot/dev` c'e' ancora quella con i marker. Il sync deprecato
   e' in esecuzione e puo' sovrascriverla di nuovo.

## Aggiornamento sessione 2026-11-06 (seconda parte)

### Stato merge e collisioni

- In root repo girano due `git merge origin/master --allow-unrelated-histories -s resolve`
  lanciati da shell interattivi (PID 390639 alle 10:29, PID 398735 alle 10:31).
  Il secondo era un duplicato esatto: terminato (PID 398735 + figli 398836/398936)
  per evitare scritture doppie sullo stesso worktree. È sopravvissuto il primo
  (merge-resolve 390731 + merge-index 390777).
- `git ls-files -u` ~16.7k path unmerged; merge-index sta riscrivendo i file
  con marker `<<<<<<< HEAD / >>>>>>> 6ed19256f` (conflitti verso la storia
  master non correlata). I marker compaiono anche nei worktree dei moduli
  nested (repo git propri): ~1.079 file PHP in `Modules/` con marker attivi,
  1.111 file falliscono `php -l`.
- I marker sono SCRITTURA IN CORSO: risolverli ora fa solo razza col merge-index.
  Strategia: attendere fine merge, poi sweep finale con intent per file.

### Lavoro completato in questa sessione

- `laravel/phpstan_bootstrap.php`, `app/` (Application, User, provider, config,
  routes, seeders) e 7 provider di modulo risolti marker → `php -l` OK.
- `64-audit.md` aggiornato: path canonici (`docs/wiki/rules/00-TRIGGER_MAP.md`,
  serie audit `docs/wiki/audits/`/`bashscripts/docs/audit/`), `heavy-slot.sh`
  reso condizionale (`test -x`), tabella gate marcata come catalogo non
  garentito, aggiunta nota verifica `bashscripts/tools/` assente.
- Standing order permanente persistito: Hindsight doc +
  `bashscripts/ai/wiki/memories/standing-order-permanente-utente.md`.
- Lock rilasciati su tutti i file toccati.

### Bloccato / residuo

- PHPStan `analyse Modules`: BLOCKED — ~7 provider unmerged (Cms×3, Gdpr×2,
  Geo×2) + migliaia di marker in Modules rendono il bootstrap inaffidabile.
  I 3 errori della baseline iniziale (`AbsenceRequestPolicy::replicate`,
  `GeoTrait` generico in Client/Worker) erano letti su stato meta-merge:
  ri-verificare a merge completato.
- File `.md` toccati: solo `64-audit.md` e questa story (nessuna data/timestamp
  nei nomi).

## Aggiornamento sessione 2026-11-06 (terza parte — merge storm)

### Cosa è successo

- MANY merge automatice concorrenti (`git merge origin/master -s resolve` e
  `git merge laraxot/dev -s resolve`) lanciati da shell interattivi di altri
  agenti (pts/0,6,9,10). Ogni merge scriveva marker in ~19k path e committava
  automaticamente (commit "." di Marco Xot ogni ~30s-20min).
- Il branch locale era `master` (non dev): contiene lo snapshot master di
  luglio (3583f9e5d, 8.050 file). `laraxot/dev` è il remote canonico, 224
  commit avanti.
- Risoluzione index: ~6.4k path unmerged → presi i lati giusti (ours per UU/AA,
  theirs per UA, rm per DU), poi `checkout --theirs` + merge commit manuale
  `82a497991` (MERGE_HEAD=1d98c1035) → master ora contiene laraxot/dev.
- Cleanup marker: 2.232 file `.merge_file_*` committati rimossi, ~1.300 file
  con marker risolti (ours/remote/clean-blob), commit `02befe01e` (773 file,
  -15k righe marker). Worktree: 0 marker, `php artisan` boot OK (Laravel 13.40).

### Ripristini dev-intent

File ritornati alla versione pre-merge (8a234df95) perché il merge li aveva
resi master-flavored: TenantServiceProvider, ConsentResource, 14 file
TechPlanner/Employee/Job Filament (override di `getFormSchema()` final in
XotBaseResource → fatal error).

### Stato PHPStan

- Baseline post-merge: **1.049 file_errors** (errore fatale 0). Dominati da
  `mixed` e test Tenant (mockAppService/expectMockery). Run:
  `phpstan analyse Modules --error-format=json` → /tmp/phpstan-final2.json
- I 3 errori iniziali (AbsenceRequestPolicy, GeoTrait) non si ripresentano nel
  top-error; verificare nel dettaglio.

### Rischi residui

- Altri agenti possono rilanciare i merge: se riparte il loop, rifare
  `git ls-files -u` + stesso protocollo.
- Moduli nested hanno repo propri ancora sporchi (lavoro altrui).
- 5.336 file locali-extra preservati nel merge (snapshot files, .playwright-mcp,
  workspace) — da ripulire in una passata dedicata se indesiderati.
