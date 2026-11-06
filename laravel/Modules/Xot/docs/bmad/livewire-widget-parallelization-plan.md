---
title: "Parallelization plan: Livewire custom a Filament Widgets"
type: bmad-parallel-plan
status: ready-for-execution
module: Xot
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, swarm, subagents, filament, livewire, parallel-waves]
related:
  - ./livewire-widget-platform-blueprint.md
  - ./livewire-to-filament-widgets-brainstorming.md
  - ./livewire-to-filament-widgets-inventory.md
  - ./livewire-widget-decision-log.md
  - ./stories/livewire-to-filament-widgets-fleet.story.md
qmd: "piano di parallelizzazione xot"
---

# Piano di parallelizzazione

> Nota di verifica 2026-10-20 sera: la seconda intestazione "Wave 4" e' ora
> **Wave 7**; Job e' Wave 2 qui e W2 nella
> [story](./stories/livewire-to-filament-widgets-fleet.story.md) (la vecchia tabella
> della story con Job in W1 e' sostituita dalla sua nota di verifica). Mappa verso la
> story: Wave 1 e Wave 2 = W2 (ritiri a basso rischio), Wave 3 = W2/W3 (auth a rischio
> medio), Wave 7 = W5 (guardia). Le menzioni di 28 classi e di Toast `KEEP` in Wave 0
> sono superate (oggi 23 classi, Toast e' REUSE+RETIRE): vedi il
> [decision-log](./livewire-widget-decision-log.md), voce "Allineamento al canone
> 2026-05".

Questo documento applica BMAD Parallel Plan al blueprint di piattaforma. Le
lane possono essere eseguite da subagent in ordine casuale **solo nella stessa
wave** e solo con ownership disgiunta. Il coordinatore esegue gli scan globali
e l'integrazione.

## Wave 0: baseline chiusa + primi `REUSE` (seriale poi lane)

<!-- gateguard: update existing parallelization plan; linked from fleet story; user: "non utilizziamo piu' componenti livewire ma utilizziamo al loro posto filament widget" + planning BMAD -->

Scope condiviso gia' fatto (inventory 28 classi, story `ready-for-dev`).
Alla **apertura** di W0 (implementazione, non questa sessione di planning):

- lane disgiunte: UI `DarkModeSwitcher`, Lang switcher/change, User
  `TermsOfService`/`PrivacyPolicy` → chiudi caller verso gemelli Widget e
  ritira HTTP solo a `rg` zero;
- Toast resta `KEEP` FO;
- non toccare Auth policy/redirect in W0.

Gate planning (questa sessione): matrice aggiornata, nessun PHP modificato.
Gate implementazione W0: Pest widget + scan caller.

## Wave 1: orfani indipendenti (lane disgiunte, ordine casuale)

| Lane | Ownership | Esito atteso |
|---|---|---|
| A | `Modules/Cms` `Page/Show` docs/caller | confermare FO full-page; nessun widget inventato |
| B | `Modules/Geo` `Test` docs/caller | ritirare solo dopo caller zero; il form FO resta FO |
| C | `Modules/Media` `Card/Video/Clip` docs/caller | ritiro del componente non montato; nessun widget inventato |
| D | audit dei sample `Chart` | nessuna cancellazione senza consumer verificato |

Dipendenze: Wave 0. Le lane non modificano provider Xot, indice globale o
file di un'altra lane.

## Wave 2: Job (seriale, ownership unica)

Scope: `Modules/Job` Livewire, Page, Widget, views e test correlati. Convergere
su `JobStatus`/`ScheduleResource` solo dopo aver deciso `saveEnv()`,
`dummyAction()` e i comandi Artisan: le capability pericolose non diventano
widget senza allowlist e policy.

## Wave 3: User e Gdpr (seriale rispetto ai flussi sensibili)

Scope: `Modules/User` e i suoi test/docs. Analizzare separatamente auth,
password, legal, profilo, team e socialite. Convertire in widget solo il
chrome panel; Page/FO restano nel boundary corretto.

Gate aggiuntivi: policy, tenant, guard, redirect, rate limit, sessione,
accessibilità e test di autorizzazione.

`Modules/Gdpr` resta nello stesso stream semantico per `RegisterWidget` e
consenso; scegliere una sola SSoT per logout, reset password e social login.

## Wave 4: UI e Lang (lane tecnicamente separate, merge coordinato)

`Modules/UI` e `Modules/Lang` condividono header e switcher. Possono analizzare
in parallelo, ma il merge è coordinato: preservare sessione, locale, refresh,
dark mode, toast e navigation.

## Wave 5: Limesurvey (seriale)

Stabilizzare i chart widget e i mount dinamici FQCN prima dei consumer Quaeris.

## Wave 6: Quaeris e dashboard (seriale)

| Lane | Ownership | Esito atteso |
|---|---|---|
| E | `Modules/Quaeris` e integrazioni Pulse | widget/dashboard solo per superfici panel e mount reali; tenant e UI verificati |

Nessuna conversione motivata dal solo conteggio dei componenti. I conflitti
globali impediscono modifiche simultanee a `Xot/app/Filament/Widgets`, ai
provider User, alle viste auth, all'header UI/Lang e ai widget Limesurvey
consumati dinamicamente da Quaeris.

## Wave 7: ritiro e gate globali (seriale)

- rimuovere discovery HTTP e alias solo dopo scan a zero riferimenti;
- aggiornare gli indici docs del modulo/tema coinvolto;
- eseguire una sola analisi PHPStan globale del coordinatore;
- eseguire test mirati e smoke dei caller;
- verificare `git diff --check`, accessibilità, policy e tenant isolation.

## Merge e rollback

Ogni lane deve essere integrabile senza revert distruttivi. Il merge segue
l'ordine delle wave; dentro una wave l'ordine è casuale ma il coordinatore
risolve eventuali collisioni prima del gate. Se un gate fallisce, si sospende
solo la lane responsabile, si ripristina il caller precedente e si corregge la
causa nel modulo owner.

## Comandi di verifica

```bash
cd laravel
vendor/bin/phpstan analyse Modules/<Module> --no-progress
vendor/bin/pest Modules/<Module>/tests --no-coverage
rg -n 'Http\\Livewire|<livewire:|@livewire\\(' Modules/<Module> Themes
git diff --check
```
