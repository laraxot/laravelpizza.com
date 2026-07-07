---
title: lezioni merge collision Notify
type: memory
module: Notify
updated: 2026-05-26
related:
  - ../../merge-conflicts-list.md
  - ../../../../../../docs/wiki/how-to/git-merge-marker-sweep.md
---

# Lezioni merge — modulo Notify

## SVG (`resources/svg/`)

| Lato conflitto | Contenuto | Scelta |
|----------------|-----------|--------|
| HEAD | XML SVG | **Tenere** |
| Incoming | Riga `git-lfs.github.com/spec/v1` | Scartare nel working tree mono (asset inline) |

## Filament `*Table.php`

**Canon (sempre):** `public function getTableColumns(): array` — filosofia Filament + `XotBaseResourceTable`.

| Lato merge | Firma | Azione |
|------------|-------|--------|
| HEAD | `static` | Rimuovere `static` |
| Incoming / canon | `public function` | **Obbligatorio** |

Corpo colonne (chiavi stringa): di solito da HEAD.

## File da eliminare, non risolvere

- `*.php.up` — backup merge; rimuovere se compaiono marker.

## Post-fix obbligatorio

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Notify --memory-limit=2G
./tools/phpmd.sh Modules/Notify/app/Filament/Resources/...
./tools/phpinsights.sh analyse Modules/Notify/app/...
```
