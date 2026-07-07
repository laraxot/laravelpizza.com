---
title: "PHPStan — falsi positivi da scope parziale (trait.unused cross-modulo)"
type: concept
module: Xot
tags: [phpstan, trait, scope, cross-module, false-positive, second-brain]
created: 2026-07-06
updated: 2026-07-06
related:
  - ./phpstan-trait-probes.md
  - ./phpstan-fixes-log.md
---

# PHPStan — falsi positivi da scope parziale

## Problema

Eseguire `phpstan analyse Modules/{UnSoloModulo}` (o più moduli ma non tutti
quelli coinvolti) può segnalare `trait.unused` su un trait che **è** usato,
ma solo da un modello di un **altro** modulo non incluso nello scope
analizzato. Esempio reale (2026-07-06):

- `Modules/Geo/app/Models/Traits/GeoTrait.php` → `trait.unused` quando si
  analizza solo `Modules/Geo`, ma **nessun errore** analizzando
  `Modules/Geo Modules/TechPlanner` insieme, perché l'unico `use GeoTrait;`
  reale è in `Modules/TechPlanner/app/Models/Worker.php`.
- Stesso pattern per `HasPlaceTrait`, `HasAddresses` (Geo) e
  `SushiToPhpArray` (Tenant, usato da `Modules/User/app/Models/SocialProvider.php`).

Analogamente, un secondo tipo di falso positivo da scope parziale:
`Ignored error pattern #PHPDoc tag @mixin contains unknown class # was not
matched in reported errors` — appare ogni volta che si analizza un
sotto-percorso invece di tutto `Modules/`, perché il pattern di
`ignoreErrors` in `phpstan.neon` matcha errori che esistono altrove
nell'albero. Non è un errore di codice.

## Regola

**Non fidarsi di un run scoped a un singolo modulo per decidere se un trait è
morto.** Prima di eliminare un trait per `trait.unused`:

1. Verificare con `grep -rl NomeTrait Modules` (whole tree) se esiste un
   `use NomeTrait;` altrove, anche in un modulo diverso da quello del file.
2. Se sì: il `trait.unused` era un artefatto di scope, non toccare nulla.
3. Se no: è dead code reale (vedi [phpstan-trait-probes](./phpstan-trait-probes.md)
   per i probe morti già rimossi con questa verifica).

L'unica esecuzione affidabile al 100% per la baseline reale del progetto è

```bash
cd laravel
./vendor/bin/phpstan analyse Modules --no-progress
```

sull'intero albero, non su sottocartelle.

## Collegamenti

- [phpstan-trait-probes](./phpstan-trait-probes.md)
- [phpstan-fixes-log](./phpstan-fixes-log.md)
