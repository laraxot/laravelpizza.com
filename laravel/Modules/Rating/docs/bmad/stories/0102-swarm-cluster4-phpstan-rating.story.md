---
title: "Swarm cluster-4 PHPStan: Rating: orphan ignore + leaf DRY (story 8.22)"
type: story
module: Rating
epic: quality
story_id: "swarm-cluster4-phpstan-rating-2026-10-06"
status: review
track: quality/phpstan
related:
  - ./0062-phpstan-fleet-fix.story.md
qmd: "swarm cluster4 phpstan Rating BaseRatingMorphPolicy ignore unmatchedLine BaseRatingPolicy leaf unused imports"
updated: 2026-10-07
tags: [docs, rating, bmad]
---
# Swarm cluster-4: Rating: 1 errore reale SSoT + completamento refactor 8.22

## Context and Problem Statement

Problema e obiettivo sono descritti nel Decision Outcome (migrazione automatica a MADR).

## Decision Drivers

- Richiesta utente / acceptance criteria della story
- Vincoli BMAD, second brain, Pest gate e dati sacri

## Considered Options

- Status quo (non fare)
- Implementare come descritto nel Decision Outcome

## Decision Outcome

Scelta: **implementare**, perché i driver sopra.

## Scopo

`RatingPolicy` / `RatingMorphPolicy` esistono per l'autorizzazione Filament
su `/admin/ratings` e `/admin/rating-morphs` (auto-discovery per naming
convention). La story 8.22 ha estratto la logica nelle basi astratte
`BaseRatingPolicy` / `BaseRatingMorphPolicy`; le leaf erano rimaste nel
worktree con corpo svuotato ma `use` orfani.

## Errori trovati (gate SSoT = `laravel/phpstan.neon`)

1. `app/Models/Policies/BaseRatingMorphPolicy.php:82`
   `ignore.unmatchedLine`: `// @phpstan-ignore-next-line
   booleanNot.alwaysFalse` orfano: sotto `treatPhpDocTypesAsCertain: false`
   il check non scatta piu', e `reportUnmatchedIgnoredErrors: true` lo
   segnala come errore. La guardia `if (! $ratedModel) return false;`
   resta: a runtime una `MorphTo` puo' essere null (relazione assente),
   quindi il ramo e' funzionale, e' il commento-ignore ad essere morto.
2. Scan peer (config custom piu' stretta, NON SSoT): 13 `always*` su tipi
   da PHPDoc (`HasRating`, `HasRatingsTrait`, `BaseRating:250`,
   `GetSumByModelRatingIdAction:26`, test). Rivalidati contro la SSoT:
   falsi positivi per costruzione: NON toccati (vedi memoria
   `multi-agent-coordination.md#swarm-phpstan-peer-findings-vs-ssot-config`).

## Fix (scopo/funzionalita')

- `BaseRatingMorphPolicy.php`: rimosso l'ignore orfano (lock acquisito
  prima dell'edit, `php -l` verde). Nessun cambio di logica.
- `RatingPolicy.php`, `RatingMorphPolicy.php`: rimossi i `use` morti
  (`Model`, `UserContract`, `XotBasePolicy`) rimasti dallo svuotamento
  8.22; le leaf restano thin per DRY. `php -l` verde.

## Gate

- `php -l`: verde sui 3 file.
- SSoT 5-file scope (2 leaf + 2 basi + `Ptv/HasIndennitaTipoFilter`):
  unico errore = l'orphan-ignore sopra, poi rimosso.
- Full `Modules/Rating`: lanciato in background (`nice`, cache calda);
  al momento della scrittura ancora in corso (box con load avg > 100
  per swarm concorrente). Re-run mirato post-fix in coda.
- Pest: non eseguito (host condiviso saturo + policy no-test-su-ambiente
  conteso; documentato come skip).

## Residuo

- `BaseRating.php:182` `// @phpstan-ignore return.type`,
  `HasRating.php:61` ignore `alreadyNarrowedType`,
  `RatingTrait.php:20` ignore `trait.unused`: da rivalidare con run SSoT
  (tentativo precedente crashato per file peer ICL transiente, fuori
  cluster: non toccato). Se unmatched sotto SSoT, rimuovere; se matched
  (es. `return.type` su generics `MorphTo`), tenere + debito.
- Lock detenuti fino a gate completo:
  `RatingPolicy.php`, `RatingMorphPolicy.php`, `BaseRatingMorphPolicy.php`.


### Consequences

- Buono, perché chiude il gap descritto nel Context
- Cattivo, perché richiede write-back docs, lock e quality gate

### Confirmation

Aggiungere prova ripetibile (Pest exit code + conteggio, PHPStan, o skip host documentato).
