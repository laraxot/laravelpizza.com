---
id: Xot/phpstan-modules-bootstrap-and-user-20260929
title: PHPStan Modules — bootstrap e residui User
status: review
epic: quality-gates
references:
  - ./fleet-blocking-merge-conflict-markers.story.md

- ./fleet-blocking-merge-conflict-markers-20260929.story.md
  - ../../../../../../bashscripts/ai/wiki/memories/phpstan-bootstrap-merge-file-markers.md
---

# Obiettivo

Eseguire `cd laravel && ./vendor/bin/phpstan analyse Modules` e correggere le
cause funzionali delle segnalazioni, senza baseline né soppressioni.

## Acceptance criteria

- [x] bootstrap PHPStan valido;
- [x] nessun marker di conflitto PHP residuo nei moduli;
- [x] `phpstan analyse Modules` completato con exit code 0 e 0 messaggi;
- [ ] Pest proporzionato allo scope eseguito e verde (run mirato terminato per timeout
  a 180s senza output; da ripetere in ambiente test isolato).

## Evidenze e decisioni

- Il primo run falliva per marker di merge lasciati in file PHP e per contenuto
  Markdown finito in `User/Filament/Widgets/Auth/BaseAuthWidget.php`.
- Le pagine `ListPermissions` e `ListTenants` ridefinivano metodi `getTable*`
  finali della base: le definizioni restano nelle rispettive Table class e le
  pagine sono state rese sottili.
- Le risorse Passport operative vivono nel cluster `Passport`; sono stati
  mantenuti wrapper legacy per i riferimenti ancora presenti nei test e nelle
  pagine storiche.
- `LoginWidget` usa esplicitamente `Filament\Notifications\Notification`;
  i widget tabellari restringono i valori misti prima di usarli.

## Verifica

Comando:

```text
cd laravel && php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules --no-progress --error-format=json
```

Risultato del run finale: exit code `0`, `listed=0`.
