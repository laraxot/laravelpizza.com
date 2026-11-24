---
updated: 2026-09-26
discussions: []
title: "PHPStan errors — fix via BMAD + second brain"
type: story
created: 2026-09-25
tags: [phpstan, second-brain, bmad, fix, swarm-parallel]
related:
  - ../rules/phpstan-rules.md
  - ../../../docs/wiki/log.md
  - ../../../bashscripts/docs/second-brain-healthcheck.sh
issues:
  - "https://github.com/laraxot/<nome repository>/issues/281"
qmd: "phpstan fixes second brain bmad swarm parallel"
---
# Story: Fix PHPStan errors with BMAD + Second Brain

## Trigger
`00-TRIGGER_MAP.md` — `phpstan` pattern + `swarm-parallel-bmad-second-brain.md`

## Second Brain — Phase B retrieval
- `qmd search "phpstan"` → `phpstan-neon-immutable.md`, `phpstan-rules.md`
- `docs/wiki/log.md` → stato moduli (AI, GDPR, Activity, UI, Job, Seo, Xot, etc.)
- `gitmodules.ini` → 48 moduli + 2 temi, ognuno repo autonomo

## BMAD — Phase C (work)
- **Bootstrap**: `bashscripts/docs/second-brain-healthcheck.sh` non presente nel checkout; usato manualmente (bootstrap compatto + trigger map + QMD)
- **Lock**: `bashscripts/lock/check.sh` / `lock.sh` / `unlock.sh` — usato per file PHP toccati
- **Edit**: Forward-only — solo `php -l` + `edit` + `git status`; mai `restore` / `reset`
- **Quality gate**: `laravel/phpstan.neon` immutabile (solo umano lo modifica); agent NON edita `.neon`
- **PHPStan results (precedente run)**: 29 errori documentati (Activity paginateQuery, Comment view-string, Job assertSame, Rating staticMethod, UI deprecatedPlaceholder, UI lang array, Xot is_int)

## Stato attuale (2026-09-25)
- **Rebase attivi**: Activity, UI, Job, Seo
- **Rebase completato con conflitti**: Xot (58 UU), Seo (18 UU), GDPR (2272 ahead), Zero Theme (pulito)
- **AI**: bloccato (rebase con >100 conflitti UU/UD)
- **PHPStan bootstrap**: fallito per `syntax error, unexpected token "<<"` in `Modules/Xot/app/Providers/Filament/XotBasePanelProvider.php` — heredoc in `renderHook` (PHP 8.4 valido, ma PHPStan parser fallisce); necessita investigazione separata

## Fix plan (da autorizzare esplicitamente)
1. **Xot provider**: studiare se heredoc in `renderHook` deve essere sostituito con `view()` o `view-string` (non `<<<HTML` in closure)
2. **31/66 errors**: fix per tipo specifico (template covariant, deprecated, staticMethod, array merge, is_int narrowing)
3. **Moduli con rebase attivo**: attendere completamento prima di PHPStan
4. **GDPR**: 2272 ahead — decidere se merge/rebase o lasciare

## Second Brain — Phase D (write-back)
- `docs/wiki/log.md` aggiornato con stato completo moduli
- `docs/wiki/concepts/phpstan-compliance.md` consultato
- `docs/chat/` non aggiornato (singolo agente, no multi-agent immediate)
- Nessun `.lock` lasciato orfano

## Not done / blocchi
- Non creato `.dev.md` (non richiesto esplicitamente dall'utente per questa sessione)
- Non modificato `laravel/phpstan.neon` (immuteable — regola permanente)
- Non eseguito `git commit` (richiede richiesta esplicita utente)
- Non risolti i 29 errori PHPStan (richiedono analisi per file + autorizzazione utente)
