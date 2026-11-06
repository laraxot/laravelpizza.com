---
title: "Blueprint: Services a Queueable Actions"
type: bmad-blueprint
status: active
module: Xot
created: 2026-10-20
updated: 2026-10-20
tags: [bmad, blueprint, queueable-actions, services, filament]
related:
  - ./services-to-queueable-actions-objective.md
  - ../development/queueable-actions.md
  - ./filament-blueprint.md
qmd: "blueprint operativo xot"
---

# Blueprint operativo

## Scopo

Portare a zero le directory `Modules/*/app/Services` senza rompere i caller:
ogni classe viene letta per responsabilità, chiamanti e side effect; ogni
use-case applicativo diventa una `Spatie\QueueableAction\QueueableAction` e ogni
componente tecnico viene ricollocato fuori da `Services`.

## Dipendenze e wave

1. **Research:** census live di directory, classi, FQCN, caller, binding, route,
   config, test e Action già esistenti.
2. **Wave A (parallela):** Geo data, Geo math e Geo provider HTTP; scope
   separati per sottodominio, senza modifiche concorrenti agli stessi file.
3. **Wave B:** retarget dei caller Filament/Folio/test e rimozione dei cinque
   Geo Service dopo il gate A.
4. **Wave C:** rimozione di `.gitkeep`, `.bak` e directory `Services` vuote;
   ricerca globale di riferimenti residui e aggiornamento docs owner.
5. **Wave D:** ratchet architetturale che fallisce su qualunque directory
   `app/Services`, audit Modules/Themes e chiusura solo con conteggio zero.

## Gate per ogni step

```bash
cd laravel
vendor/bin/phpstan analyse Modules/<Modulo>/app Modules/<Modulo>/tests --no-progress
vendor/bin/pint --dirty
```

Poi eseguire il test Pest mirato e verificare con `rg` i caller residui. Nessuna
classe viene cancellata prima di avere zero riferimenti e una Action successora
verificata. Per Filament, Resource e Widget restano su basi `XotBase*` e
delegano alle Actions; non si trasferisce logica nei form/table hooks.
Il gate strutturale è:

```bash
test -z "$(find Modules -type d -path '*/app/Services' -print -quit)"
test -z "$(find Modules -type f -path '*/app/Services/*' -print -quit)"
```

## Review avversariale

Prima di chiudere una wave, controllare: firma pubblica invariata o migrata in
modo esplicito, queueability sicura, transazioni, error handling, tenant/policy,
side effect, test di regressione, riferimenti in config/provider e docs owner.
