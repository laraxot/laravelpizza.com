---
title: "Git repository object report"
type: audit
status: current
---

# Git repository object report

Rilevazione: 2026-11-26. La misura `total objects` è `loose objects + in-pack objects`; il limite operativo richiesto è `< 10000` per ogni repository separato elencato in `gitmodules.ini`.

| Repository | Loose | In-pack | Totale | Pack | Size-pack | Prune-packable | Garbage | Refs | Esito |
|---|---:|---:|---:|---:|---:|---:|---:|---:|---|
| `bashscripts` | 20 | 6203 | 6223 | 2 | 21.92 MiB | 0 | 0 | 3 | OK |
| `laravel/Modules/Activity` | 86 | 974 | 1060 | 2 | 4.27 MiB | 35 | 0 | 3 | OK |
| `laravel/Modules/AI` | 71 | 694 | 765 | 1 | 518.05 KiB | 0 | 0 | 2 | OK |
| `laravel/Modules/Cms` | 91 | 2472 | 2563 | 2 | 5.28 MiB | 28 | 0 | 2 | OK |
| `laravel/Modules/Gdpr` | 88 | 1410 | 1498 | 1 | 679.70 KiB | 0 | 0 | 4 | OK |
| `laravel/Modules/Geo` | 90 | 4128 | 4218 | 2 | 11.83 MiB | 47 | 0 | 3 | OK |
| `laravel/Modules/Job` | 81 | 867 | 948 | 1 | 706.69 KiB | 0 | 0 | 2 | OK |
| `laravel/Modules/Lang` | 83 | 793 | 876 | 2 | 3.01 MiB | 26 | 0 | 3 | OK |
| `laravel/Modules/Media` | 101 | 1357 | 1458 | 2 | 4.43 MiB | 45 | 0 | 4 | OK |
| `laravel/Modules/Meetup` | 56 | 937 | 993 | 1 | 3.88 MiB | 0 | 0 | 4 | OK |
| `laravel/Modules/Notify` | 148 | 3749 | 3897 | 2 | 13.83 MiB | 19 | 0 | 3 | OK |
| `laravel/Modules/Rating` | 56 | 532 | 588 | 1 | 752.78 KiB | 0 | 0 | 2 | OK |
| `laravel/Modules/Seo` | 59 | 665 | 724 | 1 | 317.07 KiB | 0 | 0 | 4 | OK |
| `laravel/Modules/Tenant` | 101 | 405 | 506 | 1 | 524.36 KiB | 0 | 0 | 2 | OK |
| `laravel/Modules/UI` | 88 | 1708 | 1796 | 2 | 16.96 MiB | 26 | 0 | 2 | OK |
| `laravel/Modules/User` | 212 | 3444 | 3656 | 2 | 5.85 MiB | 142 | 0 | 3 | OK |
| `laravel/Modules/Xot` | 128 | 2240 | 2368 | 1 | 4.19 MiB | 0 | 0 | 2 | OK |
| `laravel/Themes/Meetup` | 18 | 1324 | 1342 | 1 | 47.32 MiB | 0 | 0 | 4 | OK |

## Interpretazione

- Tutti i repository separati sono già sotto 10000 oggetti; non serve una riscrittura della storia.
- `prune-packable` è diverso da zero in Activity, Cms, Geo, Lang, Media, Notify, UI e User: indica oggetti sciolti impacchettabili, non oggetti da cancellare.
- Non risultano oggetti garbage.
- Il repository principale (`.`) ha 234024 oggetti e 426.14 MiB di pack; non è un path di `gitmodules.ini`, quindi è riportato separatamente e non viene alterato.
- La misura è riproducibile con `git -C <repo> count-objects -vH`; prima di qualsiasi manutenzione distruttiva va eseguito `git fsck --full` e va verificato il backup remoto.
