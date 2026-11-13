---
id: quality-gates-phpstan-swarm-2026-09-23
title: PHPStan quality gate swarm — Activity (2026-09-23)
type: module-fix
status: blocked-external
scope: Activity
created: 2026-09-23
updated: 2026-09-23
epic: quality-gates-phpstan-fleet-2026-09-23
assignee: ai-agent
related:
  - ./conflict-markers-cleanup-2026-09-22.story.md
  - ./continuazione-domani.md
references:
  - sprint-status: "Activity/nested-conflict-markers-86-files (2026-09-22) — ultimo stato verificato: PHPStan Modules/Activity 0 errori"
---

# Activity — PHPStan quality gate swarm (2026-09-23)

## Contesto

Uno di 21 agenti paralleli (uno per modulo) nello swarm "phpstan su tutti i
Modules/Themes + git status + BMAD" del 2026-09-23. Scope stretto: solo
`laravel/Modules/Activity`, nessuna modifica a `laravel/phpstan.neon`, ad
altri moduli, né a `bashscripts/docs/prompts/03-quality-gates.md`.

## Stato git iniziale

```
cd laravel/Modules/Activity && git status --short --branch
## dev...laraxot/dev
```

Working tree **completamente pulito** (0 righe da `git status --short`).
Remote: `laraxot/dev` (github.com/laraxot/module_activity_fila5) +
`provtv/dev`. Branch `dev`, HEAD `d6648338` (". ", commit del daemon
auto-commit). Nessun `.git/MERGE_HEAD`, nessun marker di conflitto residuo
(già risolti in `conflict-markers-cleanup-2026-09-22.story.md`).

Lock: **libero** al check iniziale (`bash bashscripts/lock/check.sh
laravel/Modules/Activity` → `FREE`). Acquisito con motivo
`phpstan-fix-swarm`, rilasciato a fine sessione.

## Comando PHPStan e blocco riscontrato

```
cd laravel && ./vendor/bin/phpstan analyse Modules/Activity --no-progress --memory-limit=-1
```

Eseguito **4 volte** in questa sessione (a distanza di alcuni minuti l'una
dall'altra, per verificare se il blocco fosse transitorio). Esito in tutti
e 4 i tentativi: **crash di bootstrap dell'applicazione Laravel/Filament**,
non un report PHPStan normale:

- Tentativo 1: `PHP Fatal error: Cannot make non static method
  Modules\Xot\Filament\Resources\XotBaseResource::getFormSchemaOld() static
  in class Modules\Incentivi\Filament\Resources\ActivityResource` —
  `Modules/Incentivi/app/Filament/Resources/ActivityResource.php:28`.
- Tentativi 2-4: `Application bootstrap failed... Error: syntax error,
  unexpected token "<<", expecting end of file`, sollevato dentro
  `Filament\Panel->discoverResources()` →
  `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php:127` →
  autoload di classi Filament in tutti i moduli.

**Causa reale, verificata (non nel modulo Activity):** `larastan/bootstrap.php`
boota l'intera applicazione Laravel, e `XotBasePanelProvider::panel()` chiama
`discoverResources()` che fa `class_exists()` su **tutti** i Resource
Filament di **tutti** i moduli, non solo quello passato a
`phpstan analyse <path>`. Grep read-only (nessuna modifica) su
`Modules/**/*.php` per marker di conflitto residui:

```
grep -rlE '^<<<<<<<' Modules --include="*.php"
Modules/Incentivi/tests/Feature/Integration/IncentiviWorkflowIntegrationTest.php
Modules/Incentivi/app/Filament/Resources/CapitalPercentageResource.php
Modules/Incentivi/app/Filament/Resources/ActivityResource/RelationManagers/EmployeesRelationManager.php
Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectSettlements.php
Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageActivityEmployees.php
Modules/Incentivi/app/Filament/Resources/ActivityResource.php
Modules/Incentivi/app/Filament/Resources/PhaseResource/Pages/ManagePhaseSettlements.php
```

Tutti i file rotti sono in **`Modules/Incentivi`** (nota: contiene una
propria classe `Filament\Resources\ActivityResource`, senza relazione col
modulo Activity — coincidenza di nome), confermato anche da
`git -C Modules/Incentivi status --short` (9 file modificati, non
committati, al momento del quarto tentativo) e dal fatto che il git status
iniziale dello swarm (fornito nel prompt) elencava già decine di file
modificati in `Modules/Incentivi`. Root cause: un altro agente dello swarm
sta lavorando su `Modules/Incentivi` in questo stesso momento (refactor
Filament Resources in corso, working tree instabile con marker/segnature
non ancora sistemate). Non è WIP di Activity: **fuori scope, non toccato**,
per vincolo esplicito del prompt ("NON toccare nulla fuori da
laravel/Modules/Activity").

## Cosa è stato fixato

**Nessuna modifica al codice del modulo Activity in questa sessione.** Il
working tree era già pulito in ingresso e il blocco che ha impedito di
ottenere un report PHPStan reale origina da un altro modulo (Incentivi),
non modificabile per vincolo di scope.

## Cosa è stato lasciato aperto e perché

1. **Verifica PHPStan Modules/Activity non completata in questa sessione**:
   bloccata 4/4 volte da un fatal error di bootstrap causato da
   `Modules/Incentivi` (vedi sopra). Non risolvibile restando nello scope
   di Activity. Ultimo stato **realmente verificato** (sessione precedente,
   `docs/bmad/stories/conflict-markers-cleanup-2026-09-22.story.md` +
   `docs/coverage.md`, commit `d0bc6e4f`, 2026-09-22): **PHPStan
   Modules/Activity → 0 errori**. Nessuna modifica al codice `app/` di
   Activity è avvenuta tra quel commit e questa sessione (working tree
   pulito, nessun nuovo commit sul codice), quindi non c'è motivo di
   ritenere che lo stato sia regredito — ma va **riverificato con un run
   reale** appena `Modules/Incentivi` torna in uno stato bootstrappabile.
2. **3x `@phpstan-ignore-next-line`** in
   `app/Filament/Pages/ListLogActivities.php` (righe 70, 95, 290) — tutti
   con identifier esplicito (`cast.string`, `argument.type`), non generici,
   e già motivati inline (`__()` di Laravel ritorna `string|array|null`).
   Non tolti: sono sopprimazioni scoped correttamente, non "segnalazioni
   PHPStan reali" da risolvere in questa sessione; un refactor verso un
   helper tipizzato condiviso resta un miglioramento facoltativo, già
   annotato in `continuazione-domani.md` punto 3, non duplicato qui.
3. **`@phpstan-ignore trait.unused`** su `app/Traits/HasEvents.php` e
   `app/Traits/HasSnapshots.php` — trait morti/placeholder, zero usi
   verificati nel modulo. Decisione di design (cablarli su un model o
   rimuoverli) già segnalata in `continuazione-domani.md` punto 2, non
   presa qui: non è una segnalazione PHPStan da "sistemare" ma una scelta
   architetturale che richiede contesto di prodotto (event
   sourcing/snapshot pattern) fuori portata di un fix meccanico.

## Verifica reale finale

```
cd laravel/Modules/Activity && git status --short --branch
## dev...laraxot/dev   (0 righe — pulito)

cd laravel && ./vendor/bin/phpstan analyse Modules/Activity --no-progress --memory-limit=-1
# 4/4 tentativi: Application bootstrap failed (causa: Modules/Incentivi, fuori scope)
```

Nessuna riga di codice Activity toccata → nessun rischio di regressione
introdotto da questa sessione. La verifica del gate PHPStan resta un
**follow-up bloccato** dall'esterno, non un lavoro rimandato per pigrizia.

## Second brain — pattern non ovvio

`larastan/bootstrap.php` boota l'intera app Laravel e
`XotBasePanelProvider::panel()->discoverResources()` fa autoload di **tutti**
i Resource Filament di **tutti** i moduli, indipendentemente dal path
passato a `phpstan analyse <path>`. Conseguenza concreta per lo swarm
multi-agente: **un solo modulo con codice PHP non parsabile (marker di
conflitto, redeclare static/non-static, ecc.) blocca il comando `phpstan
analyse` per QUALSIASI altro modulo**, non solo per sé stesso. In uno
swarm con 21 agenti che editano 21 moduli in parallelo, questo produce
falsi "0 modifiche necessarie" o falsi blocchi a seconda di quale modulo è
temporaneamente rotto nell'istante esatto del run. Non è un problema del
modulo Activity: è un limite architetturale del setup PHPStan+Larastan+
Filament auto-discovery di questo monorepo, da tenere presente per i
prossimi cicli di swarm (es. serializzare i run PHPStan, o far girare il
gate solo dopo che tutti i moduli hanno raggiunto un working tree
bootstrappabile).
