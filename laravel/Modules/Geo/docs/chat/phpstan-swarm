---
title: "PHPStan swarm — run parallelo 2026-06-15"
type: chat-handoff
created: 2026-06-15
related:
  - ../wiki/how-to/phpstan-modules-swarm.md
  - ../wiki/troubleshooting/phpstan-parallel-worker-oom.md
  - ./handoff-phpstan-random-scan-2026-06-15.md
---

# PHPStan swarm — esito

## Comando

```bash
SWARM_JOBS=4 CACHE_DRIVER=file CACHE_STORE=file SESSION_DRIVER=file \
  bash bashscripts/tools/phpstan-modules-swarm.sh
```

## Risultato

- **PASS**: 33 moduli OK, 2 SKIP (`Pdnd`, `Incentivi` — esclusi in neon)
- **Wall**: ~342s (~5.7 min)
- **Log**: `/tmp/phpstan-swarm-805649/`
- Moduli critici: **Sigma** 75s OK, **Performance** 39s OK, **Xot** 63s OK

## Fix script (questa sessione)

`bashscripts/tools/phpstan-modules-swarm.sh`:

1. `tmpDir` per worker (neon effimero) — elimina race su `/tmp/phpstan/`
2. `SWARM_RANDOM=1` default
3. `[SKIP] excluded` per «No files found to analyse»

## Prossimi passi

- Gate random sequenziale: `bashscripts/tools/phpstan-modules-random.sh` (audit lungo, no parallel)
- STORY-002: `Legge104\Models\Scheda` → `extends BaseScheda`
- Non modificare `laravel/phpstan.neon`
