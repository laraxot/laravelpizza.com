---
title: "PHPStan L10 User Module — Phase 2 (Resource constraints)"
status: in_progress
epic: code-quality
<<<<<<< HEAD
parent_story: "phpstan-l10-user-lang-fix.story.md"
=======
parent_story: "phpstan-l10-user-lang-fix-20261006.story.md"
>>>>>>> laraxot/dev
created: 2026-10-06T14:30Z
acceptance_criteria:
  - Identify 3–5 fixable PHPStan L10 errors in User module
  - Apply type-narrowing and minimal fixes (no logic changes)
  - Verify with php -l for each file
  - Update BMAD story with findings
  - One commit per fix with clear message
<<<<<<< HEAD
=======
qmd: "phpstan l10 user phase2 story phase"
>>>>>>> laraxot/dev
---

# PHPStan L10 User Module — Phase 2

**Status: IN PROGRESS** — Resource constraints (WSL2 memory) prevent full-module analysis; using targeted file-by-file review.

## Findings (Session 2026-10-06)

### Fix 1: HasModules trait — Malformed PHPDoc (READY)

**File**: `Modules/User/app/Models/Traits/HasModules.php`
**Line**: 39
**Issue**: `/* @var ... */` (single-asterisk comment) should be `/** @var ... */` (double-asterisk PHPDoc)
**Impact**: PHPStan L10 may not recognize the type hint
**Fix**: Change line 39

```php
// BEFORE
/* @var array<string, Module> $result */

// AFTER
/** @var array<string, Module> $result */
```

**Status**: ✅ READY FOR COMMIT

### Phase 2 Pipeline

1. Apply Fix 1 (HasModules)
2. Run php -l verification
3. Commit
4. Continue targeted scan: SocialiteServiceProvider, Login component, others
5. Document remaining (deferred to Phase 3 if resource-bound)

## Quality Gates

- ✅ php -l: Syntax check per file
- ✅ No @phpstan-ignore suppressions added
- ✅ Minimal: Only type hints, no logic rewrite
- ⏳ Full PHPStan: Pending system resource availability (WSL2 memory)

## Files

<<<<<<< HEAD
- Story: `laravel/Modules/User/docs/bmad/stories/phpstan-l10-user-phase2.story.md`
=======
- Story: `laravel/Modules/User/docs/bmad/stories/phpstan-l10-user-phase2-20261006.story.md`
>>>>>>> laraxot/dev
- Code: TBD (fixes staged per-commit)

## References

- Story 8.1 (Phase 1): 77 migration errors fixed
- Story phpstan-l10-user-lang-fix (parallel Lang fixes)
- Constraint: WSL2 memory timeout on monorepo (>10m); per-module analysis required

## Swarm-misc 2026-10-06 (run 4): EditUserWidget

- Claim: `swarm-misc`, lock su `Filament/Widgets/EditUserWidget.php` rilasciato a fine lavoro.
- Scopo funzionale: `EditUserWidget` mostra e salva il form di modifica dati dell'utente; `getFormSchema()` prende lo
  schema dalla resource (`getFormSchemaWidget()`) e lo normalizza in `array<int|string, Component>` per il form.
- Errore: `varTag.variableNotFound` alla riga 128, `@var ... $result` davanti a un `return` diretto. Il commento si
  riferiva a una variabile `$result` rimossa in un refactor: il valore restituito e' il risultato di `normalizeFormSchema()`.
- Fix: rimosso il `@var` orfano. Il tipo e' gia' garantito dal `@return array<int|string, Component>` di
  `normalizeFormSchema()` e dal ritorno del metodo; nessun cambio di comportamento.
- Verifica: `php -l` ok, `class_exists` true, PHPStan mirato sul file: 0 errori.
- Lezione: un `@var` senza variabile e' un residuo di refactor, non un'informazione: toglierlo, non inventare una variabile.
