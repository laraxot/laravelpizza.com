---
qmd: "merge conflicts list"
issues: []
discussions: []
title: "Merge conflict markers: Notify"
module: notify
type: integration
tags: [integrations, modules, notify]
created: 2026-08-24
<<<<<<< HEAD
<<<<<<< .merge_file_0Z3vvd
updated: 2026-11-23
=======
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> .merge_file_O8keZg
updated: 2026-08-24
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
<<<<<<< .merge_file_0Z3vvd
=======
updated: 2026-11-23
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_O8keZg
status: draft
---

# Merge conflict markers: Notify

## Stato (2026-08-02)

Resolved forward-only:
- [x] `resources/svg/*.svg` (13): SVG reale, non puntatore Git LFS
- [x] `app/Filament/Resources/**/Tables/*Table.php` (3 conflitti + 3 allineati): corpo HEAD, firma `public function getTableColumns()` (non `static`)
- [x] `docs/redundancy-report.md`: HEAD version
## Stato (2026-05-26)

- [x] `app/Filament/Resources/**/Tables/*Table.php` (3 conflitti + 3 allineati): corpo HEAD, firma `public function getTableColumns()` (non `static`: vedi memoria sotto)
- [x] `docs/redundancy-report.md`: HEAD
- [x] Rimossi `*.php.up` backup con marker

## Verifica

```bash
cd laravel && git grep -n '^<<<<<<< ' -- Modules/Notify/
./vendor/bin/phpstan analyse Modules/Notify --memory-limit=2G
```

## Memoria

<<<<<<< HEAD
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
=======
<<<<<<< .merge_file_0Z3vvd
<<<<<<< HEAD
<<<<<<< HEAD
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
=======
=======
>>>>>>> .merge_file_O8keZg
<<<<<<< .merge_file_1UcBlF
[`docs/wiki/memories/merge-collision-notify-lessons.md`](wiki/memories/merge-collision-notify-lessons.md)
=======
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
>>>>>>> .merge_file_8XrHSI
>>>>>>> laraxot/dev
<<<<<<< .merge_file_0Z3vvd
=======
[`docs/wiki/memories/merge-collision-notify-lessons.md`](../../memories/merge-collision-notify-lessons.md)
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
>>>>>>> .merge_file_O8keZg
