---
status: done
scope: module:User
type: architecture
updated: 2026-09-01
qmd: "user form column parity UserColumn SingleRoleSelectColumn"
---

# Story: parita' Forms/Components ↔ Tables/Columns (User)

## User story

Come sviluppatore del modulo User,
voglio `UserColumn` e `SingleRoleSelectColumn` come gemelli di `UserSection` e `SingleRoleSelect`,
allineandomi alla regola piattaforma gia' applicata in Ptv.

## Acceptance criteria

- [x] `UserColumn` raggruppa `first_name`, `last_name`, `email`
- [x] `SingleRoleSelectColumn` riusa le stesse opzioni di `SingleRoleSelect`
- [x] Test `FormColumnParityTest` verde
- [x] Documentazione [form-column-parity.md](../form-column-parity.md)

## Riferimenti

- [form-column-parity.md](../form-column-parity.md)
- [Ptv form-column-parity.md](../../Ptv/docs/form-column-parity.md)
