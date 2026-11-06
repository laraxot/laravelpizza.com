---
title: "BMAD Story: Remove TypedHasRecursiveRelationships (CONFIRMED)"
type: note
status: unverified
created: 2026-10-19
updated: 2026-10-19
module: Xot
tags: [xot, bmad]
qmd: "BMAD Story: Remove TypedHasRecursiveRelationships (CONFIRMED)"
---
# BMAD Story: Remove TypedHasRecursiveRelationships (CONFIRMED)

type: decision
status: done
module: Xot
related: laravel-adjacency-list (staudenmeir/laravel-adjacency-list v1.26 for Laravel 13.x), eloquent-has-many-deep (staudenmeir/eloquent-has-many-deep)

## Stato attuale verificato (2026-10-19)

1. Il file `laravel/Modules/Xot/app/Models/Traits/TypedHasRecursiveRelationships.php` **NON ESISTE** (confermato: `find ... -iname "*TypedHasRecursive*"` restituisce 0 file nel codebase).
2. Tutti i modelli Tree in Xot, Cms, Blog, Rating **usano già direttamente**:
   ```php
   use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
   ```
   (Confermato: `grep -r` su `laravel/Modules/` trova 12 riferimenti, nessuno al trait wrapper).
3. Il contratto `Modules\Xot\Contracts\HasRecursiveRelationshipsContract` mantiene la compatibilità **runtime** (non impone return type rigorosi, solo PHPDoc `@return mixed`): questo è il pattern corretto per non rompere il vendor trait.

## Perché NON va modificato `laravel/phpstan.neon`

Regola stabilita dall'utente (m00244): **solo l'utente può modificare `laravel/phpstan.neon`**. Questo è il file autoritativo per PHPStan (level: max), che include `vendor/phpstan/phpstan/conf/bleedingEdge.neon`. Non vanno creati nuovi `.neon` per singoli moduli; se servono esclusioni, vanno aggiunte a `laravel/phpstan.neon` dall'utente.

## Versioni Staudenmeir da aggiornare in Xot `composer.json`

Scaricata la documentazione ufficiale (GitHub: staudenmeir/laravel-adjacency-list, staudenmeir/eloquent-has-many-deep):

| Package | Versione attuale | Versione corretta per Laravel 13.x | Fonte |
|---|---|---|---|
| `staudenmeir/laravel-adjacency-list` | `*` | `^1.26` | Tabella compatibilità: Laravel 13.x → v1.26 |
| `staudenmeir/eloquent-has-many-deep` | `*` | `^2.0` (o `*` mantenuto ma documentato) | Supporto Laravel 5.5+, compatibile con PHP 8.3 |

Nota: Il `*` nel `composer.json` di Xot è accettabile ma non documenta la versione minima richiesta; per sicurezza e riproducibilità, si consiglia il passaggio a `^1.26`.

## PR proposta per il contratto (HasRecursiveRelationshipsContract)

**Motivo**: Il vendor trait fornisce metodi senza return type nativi (`public function ancestors()`); il contratto deve mantenere firme compatibili ma può migliorare il PHPDoc per PHPStan `max`.

**Cambi in `HasRecursiveRelationshipsContract.php`**:
- Mantenere `public function ancestors(): ?Collection` (o simile) ma con `@phpstan-ignore` o `@param` esplicito per evitare errori di generics.
- Non aggiungere `static` come tipo di ritorno (come richiesto in alcune storie precedenti) perché il vendor trait non lo dichiara; il contrato deve restare runtime-compatible.

## Documentazione aggiunta

Questo file (`docs/bmad/remove-typedhasrecursiverelationships-confirm.md`) documenta lo stato attuale, il motivo della rimozione, le versioni corrette e la regola su `phpstan.neon`.
