# Merge conflict markers — Notify

## Stato (2026-05-26)

- [x] `resources/svg/*.svg` (13) — HEAD (SVG reale, non puntatore Git LFS)
- [x] `app/Filament/Resources/**/Tables/*Table.php` (3 conflitti + 3 allineati) — corpo HEAD, firma `public function getTableColumns()` (non `static`: vedi memoria sotto)
- [x] `docs/redundancy-report.md` — HEAD
- [x] Rimossi `*.php.up` backup con marker

## Verifica

```bash
cd laravel && git grep -n '^<<<<<<< ' -- Modules/Notify/
./vendor/bin/phpstan analyse Modules/Notify --memory-limit=2G
```

## Memoria

[`docs/wiki/memories/merge-collision-notify-lessons.md`](wiki/memories/merge-collision-notify-lessons.md)
