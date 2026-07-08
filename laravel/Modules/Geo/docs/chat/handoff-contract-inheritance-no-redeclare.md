# Handoff — Contract Inheritance Fix (2026-06-15)

## Scoperto

`Qua00f` e `Rep00f` avevano `implements Contracts\DateRangeFieldsContract` ridondante:
- `BaseDateRangeModel` già implementa `DateRangeFieldsContract`
- L'interfaccia si eredita via OOP

## Fix

Rimosso `implements Contracts\DateRangeFieldsContract` da:
- `laravel/Modules/Sigma/app/Models/Qua00f.php:135`
- `laravel/Modules/Sigma/app/Models/Rep00f.php:143`

## Nuova Regola

`laravel/Modules/Sigma/docs/wiki/rules/contract-inheritance-no-redeclare.md`

**Principio**: Child class NON ripete mai `implements InterfaceName` se il parent già lo fa.

Docs aggiornati:
- `sigma-model-inheritance.md` — sezione "Regola child-implements"
- `basemodel-hierarchy.md` — anti-pattern aggiunto
- `model-contracts-placement.md` — nota "senza ridichiarare"
- `index.md` — nuova sezione Rules
- `log.md` — nuovo entry
- `docs/wiki/log.md` — root log aggiornato

## Supermemory

Memoria `learned-pattern` salvata: "Contract Inheritance — No Re-declare"

## Stato

Altri 5 modelli Sigma (Asz00k1, Asz00f, Qua03f, Dipt00f, Sto00f) erano già corretti.  
`EnteMatrFieldsContract` su BaseModel — nessun figlio lo ridichiara → ok.

## Prossimi passi possibili

- Audit cross-modulo: cercare `extends.*implements` in tutti i moduli
- qmd embed per vettori
