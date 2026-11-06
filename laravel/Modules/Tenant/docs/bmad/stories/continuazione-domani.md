---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "continuazione domani"
issues: []
discussions: []
title: "Continuazione BMAD: Domani (chiusura 7.1/7.2 sushi PHPStan + profile-contract stale)"
type: module-fix
scope: Tenant
epic: "7"
bmad_version: v3.30.1
updated_at: '2026-09-23'
status: in-progress
related:
  - ../../stories/7.1.phpstan-sushi-boundaries.story.md
  - ../../stories/7.2.phpstan-test-harness-contracts.story.md
  - ../../stories/21-1-replace-profile-model-with-contract.md
  - ../../stories/git-state-conflict-marker-daemon-cleanup.story.md
---

# Tenant: Continuazione Domani

## Stato verificato ora (sessione 2026-09-22)

- Marker di conflitto: `35353af` (fix, dopo la story dedicata `828c1da`) ha ripulito la regressione del daemon; verificato ora con `grep -rIl "<<<<<<<" .` su tutto il modulo (esclusi vendor/.git): **0 hit reali**: i soli 2 file trovati (`docs/merge-conflicts-list.md`, `docs/wiki/troubleshooting/git-merge-conflict-inventory.md`) sono documentazione *sul* problema, non marker live.
- **Il daemon auto-commit e' attivo ora, in questa stessa sessione**: e' arrivato un nuovo commit `b91acc6` (`.`, autore Marco Xot) che ha committato `docs/bmad/architecture.md` e questo stesso file (boilerplate generico, prima untracked): stessa firma gia' documentata in `git-state-conflict-marker-daemon-cleanup.story.md`. `dev` risulta comunque allineato a `laraxot/dev` (0 ahead/behind).
- `@phpstan-ignore trait.unused` presente in `app/Models/Traits/SushiToPhpArray.php:16`: coerente con l'owned scope di `7.1.phpstan-sushi-boundaries.story.md` (quel trait e' esplicitamente nello scope), non un problema nuovo.
- 0 `TODO`/`FIXME`/`dddx` in `app/` (grep pulito).

## Priorita' #1: CHIUSA (2026-09-23, sessione claude sonnet 5, swarm phpstan-fix-21-moduli)

Fatto esattamente come pianificato: `./vendor/bin/phpstan clear-result-cache &&
./vendor/bin/phpstan analyse Modules/Tenant --no-progress --memory-limit=-1` a freddo
-> `[OK] No errors`. `7.1.phpstan-sushi-boundaries.story.md` e
`7.2.phpstan-test-harness-contracts.story.md` promosse entrambe a `done`, task
residuo di 7.1 chiuso, `sushi-traits-phpstan-fixes.md` aggiornato con la nota di
chiusura. Nessun errore PHPStan reale trovato da correggere in questa sessione:
il modulo era gia' a 0 dal 2026-08-24/2026-09-07, mancava solo il riallineamento
di stato delle story. Unico evento notato: un fatal error transitorio in fase di
bootstrap PHPStan causato da un file `Modules/Incentivi` in WIP concorrente di un
altro agente dello swarm (`getFormSchemaOld` reso static su
`ActivityResource.php:28`, fuori owned scope Tenant): risolto da solo al retry,
nessuna azione necessaria, stesso pattern gia' visto il 2026-09-06 su AiAssistant.

## Altri task aperti, in ordine di priorita'

1. `docs/stories/21-1-replace-profile-model-with-contract.md` (status `todo`, epic 21): l'unico file target elencato (`app/Models/TenantSubscription.php`, presunta `@property-read \Modules\Quaeris\Models\Profile|null $deleter`) **non contiene piu' ne' `Profile` ne' `deleter`** (verificato leggendo il file corrente, 63 righe, grep senza match; `git log -S Profile -- app/Models/TenantSubscription.php` non mostra storia per quella stringa in questo file). La premessa della story sembra gia' risolta altrove (o mai stata vera nella forma descritta): da chiudere come `done`/`obsolete` dopo un doppio controllo, non da rilavorare come se fosse ancora da fare.
2. Story `3.5.multi-tenant-scope-isolation.story.md`, `3.8.verify-rls-policies.story.md`, `5.8.monitoring-alerting-setup.story.md`, `6.1.setup-wizard-db-init-seed.story.md`: tutte `status: backlog` in `docs/stories/`, nessuna evidenza raccolta in questa sessione che siano state iniziate; restano backlog reale, non azione per domani se non un re-triage di priorita'.
3. Rischio daemon: se al prossimo giro ricompaiono marker `<<<<<<<`/`=======`/`>>>>>>>` in `docs/` o `app/`, **non** fare `git checkout -- <file>` alla cieca (nota gia' scritta in `git-state-conflict-marker-daemon-cleanup.story.md`): verificare prima con `git show <ref>:<path>` quale versione e' quella buona, come fatto in `35353af`.

## Second brain

`qmd query` su "Tenant sushi phpstan 7.1 7.2 40 findings zero" prima di riprendere (per non ri-diagnosticare da zero il disallineamento status); `qmd update` dopo la chiusura del punto 1.