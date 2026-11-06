---
title: "PHPStan globale: analizzare Modules e correggere le cause"
status: done
module: Xot (coordinamento), tutti i moduli coinvolti (owner dei fix)
created: 2026-11-04
updated: 2026-11-04
type: story
qmd: "PHPStan analyse Modules zero errori cause radice swarm scope disgiunti source first"
related:
  - ../../stories/base-setting-page.story.md
  - ./setting-page-tutti-i-moduli.story.md
---

# PHPStan globale: analizzare Modules e correggere le cause

## Intento

Eseguire il comando canonico `cd laravel && ./vendor/bin/phpstan analyse Modules`, ricostruire
lo scopo del codice per ogni famiglia di segnalazioni e portare l'analisi completa a zero,
senza ignorare errori o alterare la configurazione PHPStan.

## Vincoli

- Prima verificare vendor, sintassi e bootstrap; un fatal rende il report incompleto.
- Clusterizzare il JSON per identificatore e causa radice; delegare owner e file disgiunti.
- Ogni lane opera dentro story BMAD del modulo owner e lock per ogni file.
- Tipi precisi; `mixed` solo dopo aver escluso shape, generics, Data e union.
- Pest per le modifiche e gate PHPStan globale finale; niente DB distruttivo.

## Claim

| Owner | Scope | Stato |
|---|---|---|
| `/root` | Baseline, clustering, coordinamento, integrazione e verifica globale | done: gate completo exit 0 |
| `/root/activity_table_fix` | Activity: override di hook tabella che bloccano bootstrap | done: gate Pest e PHPStan mirati verdi |
| `/root/prompt_audit` | `bashscripts/docs/prompts/11-phpstan.md`, coordinamento README solo se necessario | done: comandi in coda `flock`, output/exit code distinti, destinazioni story corrette |
| `/root/prompts_core` | `00-start.md`, `00-master-prompt.md`, `01-confidence-bootstrap.md`, `01-architecture-patterns.md`, `15-bmad.md`, `19-docs.md`, `25-services-to-actions.md`; audit del resto `00-*`–`29-*`, escluso `11-phpstan.md` | done: riferimenti alle story aggiornati a `docs/bmad/stories/`; anti-pattern chiarito |
| `/root/prompts_extended` | Audit prompt `30-*` e file non numerati; esclusi gli indici | done: 16 prompt aggiornati; convenzione nomi verificata |

### Finding prompt 11

- Il passo 1 mostra ancora il run completo senza `flock` e senza acquisire l'exit code del
  processo, mentre i vincoli più sotto impongono la coda per ogni run multi-file.
- Le istruzioni di report e handoff indicano `docs/stories/`, mentre il repository richiede gli
  artefatti BMAD in `docs/bmad/stories/` dentro il modulo owner.
- Il prompt non definisce in un solo snippet un `OUT` non condiviso né una raccolta coerente di
  JSON, stderr ed exit code per il gate coordinatore.

### Finding prompt core

- `00-start.md`, `00-master-prompt.md`, `01-confidence-bootstrap.md`, `15-bmad.md` e
  `19-docs.md` indicano ancora `docs/stories/`, mentre la regola vigente richiede
  `docs/bmad/stories/` dentro il modulo o tema owner.
- `01-architecture-patterns.md` ha un anti-pattern ambiguo che sembra raccomandare
  `bmad-output/` e manda le story in `docs/stories/`.
- `00-start.md` aveva un link relativo funzionante verso `prompts-review.story.md`, ma associava il catalogo a una story legacy in `docs/stories/`; aggiornato il riferimento alla story BMAD owner in `docs/bmad/stories/`.

### Esito prompt core

- Corrette le destinazioni delle story in `00-start.md`, `00-master-prompt.md`, `01-confidence-bootstrap.md`, `01-architecture-patterns.md`, `15-bmad.md`, `19-docs.md` e `25-services-to-actions.md` verso `docs/bmad/stories/`.
- Il prompt di avvio ora punta alla story esistente `laravel/Modules/Xot/docs/bmad/stories/docs-prompts-reorganization.story.md`; il link locale `prompts-review.story.md` esiste e quindi non era rotto.
- Reso esplicito in `01-architecture-patterns.md` che `bmad-output/` e `docs/stories/` non sono destinazioni valide per le story.
- Ricontrollo dei riferimenti nel catalogo `00-*`–`29-*`: restano menzioni di `bmad-output/` solo come anti-pattern o controlli di assenza; `02-controller-to-folio-actions.md` e `05-livewire-to-filament-widgets.md` descrivono già la story dell'owner senza indicare un path errato.
- `git -C bashscripts diff --check -- docs/prompts` → exit 0.
- Prompt audit completato in tutti i gruppi assegnati; `python3 -I
  bashscripts/tools/docs/md-filenames.py check --paths bashscripts/docs/prompts` → 0 nomi
  non conformi. Lo script `11-phpstan.md` documenta run serializzati con `flock`, output
  JSON/stderr/exit code dedicati e storie in `docs/bmad/stories/` nel modulo owner.

## Acceptance criteria

- [x] `php artisan --version` e PHPStan completano il bootstrap (`Laravel Framework 13.38.0`).
- [x] `./vendor/bin/phpstan analyse Modules` termina exit 0 con `totals.errors = 0`.
- [x] Ogni causa corretta e' descritta nella story owner con verifica reale: Activity, Incentivi e Rating.
- [x] Nessun ignore, baseline, cast o `mixed` e' stato introdotto per silenziare (audit diff PHP dei moduli: zero aggiunte).
- [x] Second brain aggiornato con le story owner indicizzate e i prompt riutilizzabili revisionati.

## Stato

## Esito gate globale: 2026-11-04

- `cd laravel && php artisan --version` → exit 0, Laravel Framework 13.38.0.
- `cd laravel && ./vendor/bin/phpstan analyse Modules` → exit 0, scansione 10.400/10.400,
  `[OK] No errors`.
- Seconda acquisizione con `--error-format=json --no-progress` → exit 0,
  `totals.errors=0`, `totals.file_errors=0`, zero file con messaggi.
- Nessun warning PHPStan residuo da correggere nel baseline verificato. Il gate finale e'
  stato eseguito dopo le modifiche concorrenti registrate nelle story dei rispettivi owner;
  l'analisi completa copre quindi il worktree integrato al momento dell'esecuzione.
- Gate dopo la correzione finale Incentivi: `php -d memory_limit=2G ./vendor/bin/phpstan
  analyse Modules/Incentivi --no-progress --error-format=raw` → exit 0; Pest del modulo
  Incentivi → 64 passed, 0 failed (casi legati al DB saltati dalla guardia), exit 0.
- Story owner aggiuntive: `Incentivi/filament-create-action-api-compatibility`,
  `Incentivi/filament-and-policy-test-remediation` e
  `Rating/rating-contract-template-binding`.
- Rimane in corso la revisione indipendente dei prompt `bashscripts/docs/prompts/`; i relativi
  claim sono tracciati sopra e non cambiano l'esito del gate PHPStan.
