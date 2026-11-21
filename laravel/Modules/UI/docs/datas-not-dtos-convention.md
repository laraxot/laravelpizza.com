---
qmd: "ui datas not dtos convention md"
title: Datas, non DTOs
type: convention
tags: [datas, spatie-laravel-data, dto, root-app-cleanup]
created: 2026-07-14
---

# Datas, non DTOs

Il progetto usa moduli nwidart. La root `laravel/app/` è solo skeleton — non deve
contenere logica di dominio (`app/DTOs/`, `app/Traits/`, ecc.).

## Regola

- Nessun `*Dto.php` / cartella `DTOs/`. Ogni classe dati è `Modules\<M>\Datas\<Nome>Data`
  ed estende `Spatie\LaravelData\Data` (https://github.com/spatie/laravel-data).
- Namespace `Datas` (plurale), non `Data` o `DTOs`.
- Constructor promotion con `public readonly` (vedi `Modules\Geo\Datas\AddressData`),
  non getter privati manuali.

## Storia

`laravel/app/DTOs/ThemeMetadataDto.php` (root, non modulare, classe DTO custom,
zero utilizzatori) è stato convertito e spostato in
`Modules\UI\Datas\ThemeMetadataData` (estende `Data`, stesso comportamento).

## Perché

- **Logica**: nwidart isola il dominio per modulo; root `app/` deve restare
  bootstrap/skeleton (vedi `bashscripts/ai/.agents/rules/root-scripts.md` e
  `docs/chat/multiagent-gate-2026-07-14.md`).
- **Filosofia**: un solo pattern per "oggetto dati immutabile" nel repo
  (`spatie/laravel-data`) invece di DTO custom reinventati per ogni feature —
  meno codice da mantenere, validazione/cast automatici già inclusi in `Data`.
