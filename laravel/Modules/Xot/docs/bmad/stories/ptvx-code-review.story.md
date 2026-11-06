---
title: "Code review delle modifiche SettingPage e qualità globale"
type: story
module: Xot
epic: quality-gates
story_id: "ptvx-code-review"
status: done
track: quality-gates
created: 2026-11-04
updated: 2026-11-04
tags: [code-review, security, phpstan, filament, bmad]
qmd: "code review SettingPage 18 moduli PHPStan prompts installer Incentivi Activity Rating"
references:
  - "./setting-page-tutti-i-moduli.story.md"
  - "./global-phpstan-remediation.story.md"
  - "../../Incentivi/docs/bmad/stories/filament-create-action-api-compatibility.story.md"
  - "../../Incentivi/docs/bmad/stories/filament-and-policy-test-remediation.story.md"
  - "../../Activity/docs/bmad/stories/list-snapshots-table-hooks.story.md"
---

# Code review delle modifiche recenti

## Obiettivo

Riesaminare in modo avversariale le modifiche appena completate: pagine SettingPage in
18 moduli, cause PHPStan corrette, regressione dei test Incentivi, prompt aggiornati e
`bashscripts/ai/install.sh`. Cercare errori funzionali, sicurezza/accessi, edge case e
criteri di accettazione mancanti.

## Acceptance criteria

- [x] Diff code PHP/install non vuoto acquisito; revisione dei prompt non inclusa nel diff isolato (oltre 16k righe), limitata ai claim tracciati nelle story owner.
- [x] Tre reviewer indipendenti (blind, edge case, acceptance) e reviewer verification-gap eseguiti; risultati verificati contro il codice e le story owner.
- [x] Finding triagiati con riferimento, reachability, impatto e test consultati.
- [x] Gate Pest/QMD: YAML sprint valido; `bash -n`, `--help` e `git diff --check` installer validi; gate PHPStan/Pest applicativi già eseguiti e documentati nelle story owner; QMD aggiornato.
- [x] Regressione installer corretta: ripristinata la versione a registro e idempotente con `--list`, `--only`, `--dry-run`, riepilogo degli errori e agent mancanti.

## Ambito

- `laravel/Modules/*/app/Filament/Pages/SettingPage.php`, Data, traduzioni e test relativi.
- Fix PHPStan e test Activity, Incentivi, Rating registrati nelle story correlate.
- `bashscripts/ai/install.sh` e prompt modificati nella sessione.

Review read-only; nessuna modifica applicativa senza finding confermato e relativo lock.


## Review findings

### Finding 1 — Nessun finding: azioni FailedJobs conservate nella Table class

- **Fonte:** blind hunter.
- **Esito:** dismiss. La supposizione che `retry_all` e `delete_all` fossero rimossi non regge: sono stati trasferiti in `FailedJobsTable::getTableHeaderActions()`, risolto dalla `FailedJobResource::table()` tramite `XotBaseResource::getTableClass()`. `ListJobsWaiting.php` (singolare) era un duplicato non referenziato; la pagina registrata e il widget restano in `ListJobsWaitings.php`. Le story owner Job documentano il contratto e il fix.

### Finding 2 — Nessun finding: policy `ActivityPolicy::viewAny()`

- **Fonte:** analisi locale.
- **Esito:** dismiss. La policy include dipendenti assegnati; `ActivityPolicyTest` copre utenti senza assegnazioni e dipendenti assegnati.

### Finding 3 — Filtro snapshot con risultati limitati

- **Fonte:** edge-case hunter.
- **Esito:** dismiss, falso positivo per la versione diffata: la query contiene `limit(50)` prima di `pluck()`, e usa ricerca remota Filament. La tabella `snapshots` indicizza `aggregate_uuid`.

### Finding 4 — Installer ridotto a sequenza fragile di comandi

- **Fonte:** review diretta della versione corrente; il finding edge sul flag `--only` era riferito a una versione precedente del file e viene dismissato.
- **Severità:** alta.
- **Bucket:** patch, risolto.
- **Riferimento:** `bashscripts/ai/install.sh:6-43`.
- **Evidenza:** la versione corrente installa ogni tool senza controllare se è già presente, ripete Kilo e OpenCode in più modalità e, con `set -e`, termina al primo comando fallito senza report degli altri agenti. Inoltre ha perso l'interfaccia `--list`, `--only` e `--dry-run` presente nella revisione precedente del file e il registro degli agent mancanti (`gemini-cli`, `copilot`, `amp`, `crush`, `codebuff`, `auggie`, `junie`, `iflow`, `openhands`, `gptme`, `ra-aid`, `goose`). Non ho eseguito installazioni.
- **Azione richiesta:** ripristinare e consolidare l'installer a registro, idempotente, con dry-run/selezione e riepilogo errori, verificando i binari e rimuovendo duplicati; mantenere gli emoji già aggiunti.

### Finding 5 — Traduzione `compila_scheda_dip`

- **Fonte:** blind hunter.
- **Esito:** dismiss, falso positivo: il file segnalato appartiene a `Progressioni` ma non fa parte del diff corrente del repository `laravel`; i termini `profile` ricorrono nelle traduzioni pregresse del modulo e la pagina collegata e' una sottoclasse di `CompilaScheda`.

### Finding 6 — Etichette Settings duplicate

- **Fonte:** blind hunter.
- **Esito:** dismiss, comportamento previsto dall'AC esplicito: tutte le 18 pagine sono richieste e hanno voce `Impostazioni`; il modulo proprietario determina la destinazione.

### Finding 7 — Regressione del test legacy form

- **Fonte:** blind hunter.
- **Esito:** dismiss. Il test non elimina piu' la chiamata `getFormSchemaOld()`: e' stata ripristinata con istanza corretta; `IncentiviFilamentResourcesTest` verifica inoltre gli schemi Activity e Project.

### Risultati dei layer

- Acceptance auditor: nessun finding concreto sugli AC.
- Verification-gap: nessun verification gap; copertura verificata per SettingPage, Data e policy.
- Finding patch installer risolto. Nessuna installazione è stata eseguita. Nessun altro finding confermato.
- Controlli di review: `bash -n`, `--help`, `git diff --check` installer e parsing YAML sprint-status validi.
- Gate di progetto gia' registrati nelle story owner: PHPStan globale exit 0; Pest e PHPStan mirati verdi secondo le evidenze registrate.

## Esito

La review ha confermato e corretto la regressione dell’installer ripristinando il registro robusto e idempotente. L’installer non è stato lanciato. I 147 prompt sono stati esclusi dal diff isolato per dimensione e coperti tramite l’audit owner registrato nella story principale. Nessun finding resta aperto.

## Stato

Done: review conclusa, finding risolto, gate e QMD aggiornati.
