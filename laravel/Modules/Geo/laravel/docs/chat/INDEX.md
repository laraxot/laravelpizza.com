# Agent Coordination Board

## Swarm Session: phpstan Quality Gate

- **Init**: 2026-06-16T13:30
- **Mission**: phpstan level max on all modules (random order)
- **Coordinator**: ses_12f6b0708ffefRueg7tJ188hD7

## Results Summary

| Agent | Modules | Errors Found | Fixed | Remaining |
|-------|---------|:-----------:|:-----:|:---------:|
| pre-session | Notify | 4 | 4 | 0 ✅ |
| pre-session | BaseUser.php | fatal (Comment) | removed | 0 ✅ |
| swarm-1 | Sigma, Lang, Questionari, Gdpr, Inail, Legge104, ContoAnnuale | 0 | 0 | 0 ✅ |
| swarm-2 | Ptv, IndennitaCondizioniLavoro, Activity, UI, Seo, Rating, Badge | 36 | 36 | 0 ✅ |
| swarm-3 | CertFisc, Prenotazioni, PresenzeAssenze, Xot, Setting, IndennitaResponsabilita, Legge109 | 4 | 4 | 0 ✅ |
| swarm-4 | Tenant, Performance, Progressioni, Pdnd, DbForge, Media, Mensa, MobilitaVolontaria | 1 | 1 | 0 ✅ |
| swarm-5 | Sindacati, Job, Notify, Europa, User | 14 | 14 | 0 ✅ |
| **Total** | **33 modules** | **55** | **55** | **0 ✅** |

## Excluded Modules
- **Incentivi**: excluded from root phpstan.neon, no own config, 1000+ errors. Needs dedicated refactor or baseline.

## Key Fix Patterns (stored in supermemory)
1. **Missing module class** → create `phpstan-stubs/{Module}{Class}.php` + load in `phpstan-bootstrap.php`
2. **Array shape `array{...}` conflicts with `array<string,string>`** → use `array<string, mixed>`
3. **Missing `use ReflectionClass`** → add import, change `\ReflectionClass` to `ReflectionClass`
4. **`file_exists($item['path'])` with mixed** → add `is_string($item['path'])` guard
5. **Model relation generics** → specify concrete generics `@return HasOne<Model&ProfileContract, $this>`
6. **Wrong import path** → fix `App\Models\User` to `Modules\User\Models\User`

## Communication Protocol
- Agents claim modules by updating this table
- Use GitHub issues (repo: provtv/base_ptv_fila5_mono) for cross-module problems
- Store new patterns in supermemory
